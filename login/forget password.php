
<?php
ini_set("display_errors", 1);
include('validate.php');
require '../model/model.php';
$flag = false;


$obj = ORM::getInstance();
$obj->setTable('users');

$valid = new validator();

if (!empty($_POST['submit'])) {
    $flag = true;
    //check validations
    $check = $valid->empty_fields($_POST);

    $error = $valid->valid_email($_POST['email']);
    if (gettype($error) == "string") {
        $flag = false;
    }

    if ($flag == true) {
        $email = $_POST['email'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $user_values = array("email" => $email, "question" => $question, "answer" => $answer);
        $result = $obj->select($user_values);
        $get = $result->fetch_assoc();


        if ($get) {
            $id = $get["id"];
            session_start();
            $_SESSION['forget_pass'] = $id;
            header("location:reset_password.php");
        } else {
            $errorrequire = "please make sure your question and answers and try again ";
            
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
    <header>
        <style>
            .error
             {
                 color: red;
             }
           
            .jumbotron
            {
                 width: 600px;
                margin-left: 500px;
                margin-top: 100px;
                background-color:rgba(102,51,0,0.7);
            }
            .col-lg-12{
                background-image: url("../images/products/2.jpg");
               	background-size: cover;
                background-repeat: no-repeat;    
                height: 800px;



            }
        </style>

    </header>
    <body>
        
       <div class="col-lg-12"> 

        <div class="container">
            <div class="jumbotron">
                  <h2 class="col-md-offset-3"  style="color: white"> forget password
                            <br>
                  </h2>
            <form  method="post" action="forget password.php" class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label"  style="color: white">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                        <span>
                            <span class="error"><?php
                                if (isset($error) && !empty($_POST['email'])) {
                                    echo $error;
                                }
                                if (isset($valid->errors['email']))
                                    echo $valid->errors['email'];
                                ?>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="question" class="col-sm-2 control-label"  style="color: white">question</label>
                    <div class="col-sm-10">
                        <input type="text" name="question" class="form-control" >
                        <span class="error"><?php
                            if (isset($valid->errors['question']))
                                echo $valid->errors['question'];
                            ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="answer" class="col-sm-2 control-label"  style="color: white" > answer</label>
                    <div class="col-sm-10">
                        <input type="text" name="answer" class="form-control">
                        <span class="error"><?php
                            if (isset($valid->errors['answer']))
                                echo $valid->errors['answer'];
                            ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="submit" name="submit" class="btn btn-default" style="margin-left: 130px">
                        <br>
                        <span class="error"><?php
                            if(isset($errorrequire) && !empty($_POST['question'])&& !empty($_POST['answer'])) {
                                echo $errorrequire;
                            }
                            ?></span>
                    </div>
                </div>

            </form>
            </div>
        </div>
       </div>
    </body>
</html>

