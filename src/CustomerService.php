<?php

class CustomerService
{
    private static function getData()
    {
        return json_decode(file_get_contents(__DIR__ . '/../data/customers.json'), true);
    }

    public static function getCustomer($order)
    {
        $customerId = $order["customer-id"];

        $found_customer = null;

        foreach(self::getData() as $customer) {
            if($customer['id'] == $customerId) {
                $found_customer = $customer;
            }
        }

        return $found_customer;
    }
}
