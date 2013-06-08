<?php

/**
 * Receipt class test
 *
 * PHP version 5
 * 
 * @author Roberto Gaveglia <roberto.gaveglia@gmail.com>
 */
require_once dirname(__FILE__) . '/../classes/Receipt.php';

/**
 * ReceiptTest class
 *
 * @author Roberto Gaveglia <roberto.gaveglia@gmail.com>
 */
class ReceiptTest extends PHPUnit_Framework_TestCase
{

    protected $receipt;

    protected function setUp()
    {
        $data = simplexml_load_file(dirname(__FILE__) . '/input_test.xml');
        $this->receipt = new Receipt($data);
    }

    public function testCalcSubTotal()
    {
        $expected = "4.27";
        $actual = $this->receipt->calcSubTotal();
        $this->assertEquals($expected, $actual);
    }

    public function testCalcDiscounts()
    {
        $expected = "0.50";
        $actual = $this->receipt->calcDiscounts();
        $this->assertEquals($expected, $actual);
    }

    public function testCalcGrandTotal()
    {
        $expected = "3.77";
        $actual = $this->receipt->calcGrandTotal();
        $this->assertEquals($expected, $actual);
    }

}

?>
