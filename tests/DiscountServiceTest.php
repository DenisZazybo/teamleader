<?php

use PHPUnit\Framework\TestCase;

class DiscountServiceTest extends TestCase
{
    public function testOrder1()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/example-data/order1.json'), true);
        $ds = new DiscountService();

        $return = $ds->calculateDiscounts($data);

        $this->assertArrayHasKey('discounts', $return);
    }

    public function testOrder2()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/example-data/order2.json'), true);
        $ds = new DiscountService();

        $return = $ds->calculateDiscounts($data);

        $this->assertArrayHasKey('discounts', $return);
    }

    public function testOrder3()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/example-data/order3.json'), true);
        $ds = new DiscountService();

        $return = $ds->calculateDiscounts($data);

        $this->assertArrayHasKey('discounts', $return);
    }
}
