
<?php
session_start();
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
//check information from database
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $user_values = array("email" => $email, "password" => $password);
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

        if (!$row) {
            $emptyErr = "no such email or password you must register first";
        }
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

                background-repeat: no-repeat;
                // border-style: solid;
                //border-width: 9px; 
                background-size: cover;
                height: 600px;


            }
            .jumbotron
            {
                width: 800px;
                margin-left: 180px;
                margin-top: 100px;
                background-color:rgba(195,192,192,0.7);
            }
        </style>

    </header>
    <body>
        <div class="container">
            <div class="header">
            <div class="jumbotron">

                <p> <h1 class="col-md-offset-3 " > Cafeteria<small> login </small></h1></p>
           
            <div class="form-group-lg"></div>

          

                <form  method="post" action="login.php" class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                            <span class="error"><?php
                                if (isset($error) && !empty($_POST['email'])) {
                                    echo $error;
                                }
                                if (isset($valid->errors['email']))
                                    echo $valid->errors['email'];
                                ?>
                            </span>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control"  placeholder="Password">
                            <span class="error"><?php
                                if (isset($valid->errors['password']))
                                    echo $valid->errors['password'];
                                ?></span>
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
                            <input type="submit" value="submit" name="submit" class="btn btn-default"><br>
                            <span class="error"><?php
                                if (isset($emptyErr))
                                    echo $emptyErr;
                                ?></span> 
                        </div>
                    </div>

                </form>
            </div>

        </div>
            </div>
    </body>
</html>