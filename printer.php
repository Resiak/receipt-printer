<?php
/**
 * Command-line script to print a receipt given an XML as input
 *
 * PHP version 5
 * 
 * @author Roberto Gaveglia <roberto.gaveglia@gmail.com>
 */

require_once 'classes/Receipt.php';


if (isset($argv[1]) && is_string($argv[1]) && substr($argv[1], -4) == ".xml" && file_exists($argv[1])) {

    $data = simplexml_load_file($argv[1]);
    if($data) {
        $receipt = new Receipt($data);
        $receipt->printReceipt();
    } else {
        exit("An error occured loading the file.");
    }
    
} else {

    exit("Input file not specified or not valid!");
    
}
