<?php


class DiscountService
{
    public function calculateDiscounts($order)
    {
        $this->calculateDiscount1($order);
        $this->calculateDiscount2($order);
        $this->calculateDiscount3($order);

        return $order;
    }

    private function calculateDiscount1(&$order)
    {
        $customer = CustomerService::getCustomer($order);

        if($customer["revenue"] >= 1000) {
            if(!array_key_exists("discounts", $order)) {
                $order['discounts'] = [];
            }

            $order["discounts"][] = [
                'amount' => $order["total"] * 0.1,
                "reason" => "High revenue customer"
            ];

            $order['total'] = $order["total"] * 0.9;
        }
    }

    private function calculateDiscount2(&$order)
    {
        foreach($order["items"] as &$item) {

            if(2 == ProductService::getItemCategoryId($item['product-id'])) {

                $or = $item['quantity'];

                //let's give them one extra anyways, we'll not charge it anyways...
                if ($item['quantity'] % 6 == 5) {
                    $item['quantity'] = $item['quantity'] + 1;
                    $item['total'] = $item['total'] + $item['price'];
                    $order['total'] = $order['total'] + $item['price'];
                }

                if ($item['quantity'] / 6 >= 1) {
                    if(!array_key_exists("discounts", $order)) {
                        $order['discounts'] = [];
                    }

                    $n = floor($item['quantity'] / 6);

                    $order['discounts'][] = [
                        'amount' => $item['unit-price'] * $n,
                        'reason' => 'You bought ' . $or . ' items of ' . ProductService::getProductName($item['product-id']) . ", so you get $n for free."
                    ];

                    $order['total'] = $order['total'] - $n * $item['unit-price'];
                }
            }
        }
    }

    private function calculateDiscount3(&$order)
    {
        $array = [];

        foreach($order['items'] as $item) {
            if (1 == ProductService::getItemCategoryId($item['product-id']))
            {
                $array[] = $item;
            }
        }

        if(count($array) >= 2 || $array[0]['quantity'] >= 2) {
            usort($array, ['DiscountService', 'sort']);

            if(!array_key_exists("discounts", $order)) {
                $order['discounts'] = [];
            }

            $order['discounts'][] = [
                'amount' => $array[0]['unit-price'] * 0.2,
                'reason' => 'You bought more than one Tool, so we give you 20% discount on the cheapest one: ' . ProductService::getProductName($array[0]['product-id']),
            ];

            $order['total'] = $order['total'] - $array[0]['unit-price'] * 0.2;
        }
    }

    private static function sort($a, $b)
    {
        return $a['unit-price'] - $b['unit-price'];
    }
}
