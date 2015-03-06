<?php


require 'login_model.php';
require 'login.php';
// Variable To Store Error Message
$error=''; 
$flag="false";

//testing login_orm
$obj=  login_ORM::getInstance();
$obj->setTable('users');

if (isset($_POST['submit'])) {
if (empty($_POST['email']) || empty($_POST['password'])) {
$error = "email or Password is required";
}
else
{
// Define $username and $password
$email=$_POST['email'];
$regex = "/^[a-zA-Z][a-zA-Z0-9._-]+\@[a-zA-Z]+\.([a-zA-Z]{2,4}|[a-zA-Z]{2,4}\.[a-zA-Z]{2})$/";
if (!preg_match($regex,$email)){
$flag="true";
}
if($flag=="true"){
                    $regexErr = "* email isn't valid";
		}
                
if(!empty($email) && !empty($password) && $flag=="false"){
$email = stripslashes($email);
$password = stripslashes($password);
$users=$obj->select(array('email'=>$email,'password'=>$password));
if ($users) {
    
            foreach($users as $key=>$value){
            echo $key." ".$value."<br/>";}
                // Initializing Session
            $_SESSION['login_user']=$email; 
                // Redirecting To Other Page
            header("location: user.php"); 
} else {
$error = "there is no useres are you registered";
}
}
}
}

?>





