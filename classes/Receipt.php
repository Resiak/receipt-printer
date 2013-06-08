<?php
/**
 * Receipt class
 *
 * PHP version 5
 * 
 * @author Roberto Gaveglia <roberto.gaveglia@gmail.com>
 */

/**
 * Receipt class
 *
 * @author Roberto Gaveglia <roberto.gaveglia@gmail.com>
 */
class Receipt
{

    private $_products = array();
    private $_subTotal = 0.00;
    private $_grandTotal = 0.00;
    private $_discounts = 0.00;
    private $_currency = '£';

    /**
     * Initialize a Receipt object
     * 
     * @param object $data - object containing the data held within the XML document
     */
    public function __construct($data)
    {
        $this->setProducts($data->product);
        $this->setCurrency($data->currency);
        $this->setSubTotal($this->calcSubTotal());
        $this->setDiscounts($this->calcDiscounts());
        $this->setGrandTotal($this->calcGrandTotal());
    }

    /**
     * Getter for products
     * 
     * @return object
     */
    public function getProducts()
    {        
        return $this->_products;
    }
    
    /**
     * Setter for products
     * 
     * @param object $input - object containing the data related to the products
     * 
     * @return void
     */
    public function setProducts($input)
    {
        $this->_products = $input;
    }
    
    /**
     * Getter for currency
     * 
     * @return string
     */
    public function getCurrency()
    {;
        return $this->_currency;
    }
    
    /**
     * Setter for currency
     * 
     * @param object $currency - object containing the currency to use in the receipt
     * 
     * @return void
     */
    public function setCurrency($currency)
    {        
        $this->_currency = strval($currency);
    }
    
    /**
     * Getter for subTotal
     * 
     * @return float
     */
    public function getSubTotal()
    {
        return $this->_subTotal;
    }
    
    /**
     * Setter for subTotal
     * 
     * @param float $subtotal - the sum of the product prices
     * 
     * @return void
     */
    public function setSubTotal($subtotal)
    {
        $this->_subTotal = $this->formatPrice($subtotal);
    }
    
    /**
     * Getter for discounts
     * 
     * @return float
     */
    public function getDiscounts()
    {
        return $this->_discounts;
    }
    
    /**
     * Setter for discounts
     * 
     * @param float $discounts - the sum to subtract from to the sub-total
     * 
     * @return void
     */
    public function setDiscounts($discounts)
    {
        $this->_discounts = $this->formatPrice($discounts);
    }
    
    /**
     * Getter for grandTotal
     * 
     * @return float
     */
    public function getGrandTotal()
    {
        return $this->_grandTotal;
    }
    
    /**
     * Setter for grandTotal
     * 
     * @param float $grandTotal - the final amount
     * 
     * @return void
     */
    public function setGrandTotal($grandTotal)
    {
        $this->_grandTotal = $this->formatPrice($grandTotal);
    }

    /**
     * Calculate the sub-total
     * 
     * @return float
     */
    public function calcSubTotal()
    {
        $subtotal = 0;
        $products = $this->getProducts();
        foreach ($products as $product) {
            $subtotal += $this->formatPrice($product->priceWas);
        }
        return $subtotal;
    }

    /**
     * Calculate the global discount
     * 
     * @return float
     */
    public function calcDiscounts()
    {
        $discounts = 0;
        $products = $this->getProducts();
        foreach ($products as $product) {
            $discounts += $this->formatPrice($product->priceWas) - $this->formatPrice($product->price);
        }
        return $discounts;
    }

    /**
     * Calculate the grand total
     * 
     * @return float
     */
    public function calcGrandTotal()
    {
        return $this->getSubTotal() - $this->getDiscounts();
    }

    /**
     * Print out the full receipt
     * 
     * @return void
     */
    public function printReceipt()
    {
        echo $this->buildReceiptRow("-", null, true);
        
        $products = $this->getProducts();
        foreach ($products as $product) {
            echo $this->buildReceiptRow($product->name, $this->formatPrice($product->priceWas));
        }

        echo $this->buildReceiptRow("-", null, true);
        echo $this->buildReceiptRow("Sub-Total", $this->getSubTotal());
        echo $this->buildReceiptRow("Discounts", $this->getDiscounts());
        echo $this->buildReceiptRow("-", null, true);
        echo $this->buildReceiptRow("Grand Total", $this->getGrandTotal());
    }
    
    /**
     * Build a row to be added in the receipt
     * 
     * @param string  $name          - the product name or a label for the row
     * @param string  $value         - the price
     * @param boolean $separator_row - true if the row is a separator
     * 
     * @return string
     */
    protected function buildReceiptRow($name, $value, $separator_row = false)
    {
        if ($separator_row) {
            return str_pad("-", 40, "-") . PHP_EOL;
        } else {
            return str_pad($name, 30) . " | " . $this->getCurrency() . " " . $value . PHP_EOL;
        }
    }

    /**
     * Format the price
     * 
     * @param string $value - the price to format
     * 
     * @return string
     */
    protected function formatPrice($value)
    {
        return number_format(floatval($value), 2);
    }

}
