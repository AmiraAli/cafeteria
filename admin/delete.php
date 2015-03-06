<?php

require '../model/model.php';


    $id = $_GET['id'];
    
    $user= ORM::getInstance();
    $user->setTable('users');
    $user_data = $user->select(array('id' => $id));
    if ($user_data->num_rows > 0) {
        for ($i=0;$i<$user_data->num_rows;$i++){
             while($user1= $user_data->fetch_assoc()){
            unlink("/var/www/cafeteria/images/users/".$user1['pic']);
            
        }
    }
  }
    $all_data = $user->delete(array('id' => $id));
    
    
    
  
  header("Location: all_users.php");
   
    
    
    