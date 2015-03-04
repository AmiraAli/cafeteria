
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
   
    $error = $valid->valid_email($_POST['email']);
    if (gettype($error) == "string") {
        $flag = false;
    }
    

    if ($flag == true) {

        //check information from database
        $email = $_POST['email'];
        $password = md5($_POST['password']) ;
        echo $password;
        $user_values = array("email" => $email, "password" => $password);
        $results = $obj->select($user_values);
        $row = $results->fetch_assoc();
        $name = $row['name'];
        if ($row) {         
            session_start();
            $_SESSION['login_user'] = $name;          
            setcookie ('cookie', $name,time() + (86400 * 30));
            print_r( $_COOKIE ['cookie']);
           
            //Redirecting To Other Page
            header("location: ../user/user_home.php");
        } else {
            echo "you must register first";
        }


//        if (!$row) {
//            echo "you must register first";
//        } else {
//             foreach ($row as $key => $value) {
//                  echo $key . " " . $value . "<br/>";
//                 
//             }
////            foreach ($row->results() as $obj) {
////                echo $obj->$username, '<br>';
////            }
//        }
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link href="login.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>

    </head>
    <header>
         <style>
             .error
             {
                 color: red;
             }
            .container{

                background-image: url("../images/products/tea_with_milk.jpg");
                background-repeat: no-repeat;
                background-size: cover;
                height: 600px;
                

            }
            .jumbotron
            {
                width: 800px;
                margin-left: 180px;
                margin-top: 100px;
                background-color:rgba(192,192,192,0.7);
            }
            </style>
            
    </header>
    <body>
        <div class="container">
            
                <div class="form-group-lg"></div>
                <div class="jumbotron">

                <form  method="post" action="login.php" class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                            <span class="error"><?php if(isset($error)){ echo $error;} ?></span>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control"  placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <a href="forget password.php">forget password </a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="submit" name="submit" class="btn btn-default">
                        </div>
                    </div>

                </form>
                </div>
            
        </div>
    </body>
</html>