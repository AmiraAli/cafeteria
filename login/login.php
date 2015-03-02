
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

        //check information from database
            $email=$_POST['email'];
            $password=$_POST['password'];
            $user_values = array("email" =>$email,"password" =>$password);
            $results=$obj->select($user_values);
            $row=$results->fetch_assoc();
           
          
            if($row)
            {
                
                 $_SESSION['login_user'] = $email;
                //Redirecting To Other Page
                header("location: ../user/user_home.php");
                echo $row['name'];
               
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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h1>login</h1>
        <div class="container">
            <form  method="post" action="login.php" class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">

                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
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
    </body>
</html>