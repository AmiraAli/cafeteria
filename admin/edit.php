<?php

require '../model/model.php';



$id = $_GET['id'];

$edit_user = ORM::getInstance();
$edit_user->setTable('users');
$user_data = $edit_user->select(array('id' => $id));

if ($user_data->num_rows > 0) {
    for ($i = 0; $i < $user_data->num_rows; $i++) {
        $user = $user_data->fetch_assoc();
        
        $user=implode(",", $user);

    }
}

header("Location: http://localhost/cafeteria/admin/add_user.php?user1=".$user);
       
 