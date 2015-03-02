
<?php
ini_set("display_errors", 1);
include('validate.php');
require 'login_model.php';
$flag = false;


$obj = login_ORM::getInstance();
$obj->setTable('users');

$valid = new validator();

if (!empty($_POST['submit'])) {
    $flag = true;

    //check validations
    $check = $valid->empty_fields($_POST);
    if (gettype($check) == "array") {
        for ($i = 0; $i < count($check); $i++) {
            echo $check[$i] . "<br/>";
        }
        $flag = false;
    }
    echo $error = $valid->valid_email($_POST['email']);
    if (gettype($error) == "string") {
        $flag = false;
    }

    if ($flag == true) {
        $email = $_POST['email'];
        
        $question = $_POST['question'];
        
        $answer=$_POST['answer'];
        
        $user_values = array("email" =>$email,"question" =>$question,"answer"=>$answer);
        $result=$obj->select($user_values);
        $get=$result->fetch_assoc();
        
        
       
        
         if($get)
            {  
                $id=$get["id"];
                session_start();
                $_SESSION['forget_pass'] = $id;
                header("location:reset_password.php");
                
               
            }
    
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h1>forget password</h1>
        <div class="container">
            <form  method="post" action="forget password.php" class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">

                    </div>
                </div>
                <div class="form-group">
                    <label for="question" class="col-sm-2 control-label">insert your question</label>
                    <div class="col-sm-10">
                        <input type="text" name="question" class="form-control"  placeholder="Password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="answer" class="col-sm-2 control-label" >insert your answer</label>
                    <div class="col-sm-10">
                        <input type="text" name="answer" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="submit" name="submit" class="btn btn-default">
                    </div>
                </div>

            </form>
        </div>
    </body>
</html>

