<?php

require 'user_model.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

////testing user_orm
//$obj = user_ORM::getInstance();
//$obj->setTable('student');
//echo $obj->insert(array('id'=>4,'name' => 'amira', 'age' => 20,'track'=> 'os'));

$obj=  user_ORM::getInstance();
$obj->setTable('products');
$products=$obj->select_all();

if($products){
   foreach($products as $key=>$value){
       echo $key." ".$value."<br/>";
   }
}else{
    echo "NO Products!!";
}

