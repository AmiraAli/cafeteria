<?php

require 'user_model.php';

/*
 * this file used to insert order into database
 */

//taking the order_price
//default status=processing
$order_price = $_POST['order_price'];

$user_id = 1;
$status = "processing";

/**
 * insert order into database
 */
$obj_order = user_ORM::getInstance();
$obj_order->setTable('orders');

$result = $obj_order->insert(array("user_id" => $user_id, "status" => $status, "order_price" => $order_price));

/**
 * select the last order to get order_id
 */
$obj_order_id = user_ORM::getInstance();
$obj_order_id->setTable('orders');

$last_order=$obj_order_id->select_last_row(array("user_id" => 1));

$order_id = $last_order['id'];


/**
 *  insert into table order_product all products of the order
 */
$notes = $_POST['notes'];

$products_array = $_POST['array'];

//getting all products separated by comma
$products =explode(",", $products_array);

//getting information obout each product and insert it into order_product table
for ($i = 0; $i < count($products)- 1; $i++) {
    
     $product = explode(":", $products[$i]);
     
     $obj_order_product = user_ORM::getInstance();
     $obj_order_product->setTable('order_product');
     
     $product_id = $product[0];
     $product_amount = $product[1];
     $product_price = $product[2];
     
     $obj_order_product->insert(array("order_id"=>$order_id,"product_id"=>$product_id ,"amount"=>$product_amount,"total_price"=>$product_price,"notes"=>$notes));
    
}




