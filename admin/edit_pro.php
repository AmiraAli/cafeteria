<?php

require '../model/model.php';



$id = $_GET['id'];

$edit_product = ORM::getInstance();
$edit_product->setTable('products');
$product_data = $edit_product->select(array('id' => $id));

if ($product_data->num_rows > 0) {
    for ($i = 0; $i < $product_data->num_rows; $i++) {
        $product = $product_data->fetch_assoc();
        
        $product=implode(",", $product);
    
    }
}

header("Location: http://localhost/cafeteria/admin/add_product.php?product1=".$product);
