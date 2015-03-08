
<?php
ini_set("display_errors", 1);
require_once 'validate.php';
require '../model/model.php';
$flag = false;


$obj = ORM::getInstance();
$obj->setTable('users');

$valid = new validator();

if (!empty($_POST['submit'])) {
    $flag = true;

    //check validations
    $check = $valid->empty_fields($_POST);
    if (gettype($check) == "array") {
        for ($i = 0; $i < count($check); $i++) {
            // echo $check[$i] . "<br/>";
        }
        $flag = false;
    }


    if ($flag == true) {
        $error1 = $valid->valid_password($_POST['password'], $_POST['confirmpassword']);
        if ($error1 == 1) {
//      header("location: ../user/user_home.php");
            $password = $_POST['password'];
            session_start();
            $id = $_SESSION['forget_pass'];
            //echo $id;

            $user_values = array("id" => $id);

            $results = $obj->select($user_values);
            $row = $results->fetch_assoc();
//      var_dump($row);
            $name = $row['name'];
            $email = $row['email'];
            $passwordb = $row['password'];
            $data = array('password' => md5($password));
            $filters = array('name' => $name, 'email' => $email);
            $update = $obj->update($filters, $data);
            $user_values = array("email" => $email, "password" => md5($password));
            $results = $obj->select($user_values);
            $row = $results->fetch_assoc();

            // user exists
            if ($row) {

        // Information concerning ANY user.
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_pic'] = $row['pic'];

            // Info concerning admin ONLY. Should enter if condition if the user
            // is an admin.
                if ($row['is_admin'] == "1") {
                    $_SESSION['is_admin'] = true;
                    header('Location: ../admin/admin_home.php');
                } else
                    header('Location: ../user/user_home.php');
            }
        } else {
            $error = "please check your password";
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
            .container{

                border-style: solid;
                border-width: 9px; 
                background-repeat: no-repeat;
                background-size: cover;
                height: 600px;


            }
            .jumbotron
            {
                width: 800px;
                margin-left: 180px;
                margin-top: 100px;
                background-color:rgb(0,0,255,0.3);
            }
            .h1{

            }
        </style>
    </header>

    <body>
        <h1>reset password</h1>
        <div class="container">
            <div class="form-group-lg"></div>
            <div class="jumbotron">
                <form  method="post" action="reset_password.php" class="form-horizontal">
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">new password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">confirm password</label>
                        <div class="col-sm-10">
                            <input type="password" name="confirmpassword" class="form-control" id="inputPassword3" placeholder="Password">
                            <span class="error" ><?php if (isset($error)) echo $error; ?></span> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input class="btn btn-success btn-sm" type='submit' name='submit' value='check'>

                        </div>

                    </div>

                </form>
            </div>
        </div>
    </body>
</html>

