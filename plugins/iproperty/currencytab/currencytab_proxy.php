<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

require_once "services_JSON.php"; 
header('Content-Type: text/html; charset=utf-8');

function curlIt($vars, $price){
    $ch = curl_init();
    $url = "http://www.google.com/ig/calculator?hl=en&q=" . $vars;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($ch);

    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
    $array = $json->decode($data);

    // if there's an error return a 500 so the JSON call fails
    if($array['error']) {
        header("HTTP/1.0 500");
        return false;
    }

    // hack since Google uses idiotic JSON
    $rate = $array['rhs'];
    $pattern = "/[0-9. ]+/";
    preg_match($pattern, $rate, $matches);

    if($matches[0]){
        $rate = trim($matches[0]);
        $price = number_format($rate * $price);
        return json_encode($price);
    }

    return false;
    curl_close($ch);
}

// currency converter ajax caller
if($_GET['vars']){
	$vars  = (string) $_GET['vars'];
	$price = (int) $_GET['price'];
   	echo curlIt( $vars, $price );
}
