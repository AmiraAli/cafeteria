<?php

require '../model/model.php';
$name=$_POST['text'];

$obj= ORM::getInstance();
$obj->setTable('categories');

$result=$obj->insert(array('name'=>$name));

echo $result;