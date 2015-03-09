<?php

require '../model/model.php';


    $id = $_GET['id'];

    $product= ORM::getInstance();
    $product->setTable('products');
//    $product_data = $product->select(array('id' => $id));
//    
//    
//    if ($product_data->num_rows > 0) {
//        for ($i=0;$i<$product_data->num_rows;$i++){
//             while($product1= $product_data->fetch_assoc()){
//            unlink("/var/www/cafeteria/images/products/".trim($product1['pic']));
//            
//        }
//    }
// }
//  
//    
//    
//    $all_products = $product->delete(array('id' => $id));
//    
 
    //delte the product make it unavaliable 
    
  $result=$product->update(array('id' => $id),array('is_available'=>0));
  header("Location: all_products.php");
  
 
    