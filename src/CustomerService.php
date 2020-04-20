<?php

class CustomerService
{
    private static function getData()
    {
        // todo
        // the method of obtaining data is not extensible ( f.e to obtain data from other sources)
        // In addition, access to the data layer must be moved to another architecture level (not a business logic layer).
        // For a more clear architecture

        // todo
        // need to add file availability check
        return json_decode(file_get_contents(__DIR__ . '/../data/customers.json'), true);
    }

    public static function getCustomer($order)
    {
        // todo
        // $order["customer-id"] may not exist, the $order variable isn't check
        $customerId = $order["customer-id"];

        $found_customer = null;

        // todo
        // incoming data (self::getData()) is not checked
        foreach(self::getData() as $customer) {

            // todo
            // $customer['id'] may not exist
            if($customer['id'] == $customerId) {

                // I assume that the loop should be interrupted by the triggering condition
                // It should help save some resources sometimes
                $found_customer = $customer;
            }
        }

        return $found_customer;
    }
}
