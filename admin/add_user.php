<?PHP
require 'admin_header.php';
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" href= "../bootstrap-3.3.2-dist/css/bootstrap.css">
        <link rel="stylesheet" href= "../bootstrap-3.3.2-dist/css/bootstrap-theme.css">

        <script src="../jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../bootstrap-3.3.2-dist/js/bootstrap.js" type="text/javascript"></script>

    </head>

    <body>

        <?php
        include('validation.php');
        require '../model/model.php';

        $valid = new validator();
        $data = new ORM();


        if (!empty($_POST['save'])) {
            $flag = true;
            // check on validation 
            $check = $valid->empty_fields($_POST);
            if (gettype($check) == "array") {
                for ($i = 0; $i < count($check); $i++) {
//                                $check[$i] . "<br/>";
                }
               // var_dump($check);
                $flag = false;
            }

//            //check on password&email&image 
//          echo $error = $valid->valid_password(md5($_POST['password']), md5($_POST['confirmpassword']));

//             $error = $valid->valid_email($_POST['email']);
            if (gettype($error) == "string") {
                $flag = false;
            }

            if ($flag == true) {

                //save image 

                $upfile = '/var/www/html/cafeteria/images/users/' . $_FILES['userfile']['name'];
                if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                    if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)) {
                        echo 'can`t upload your image  ' . "<br/>";
                        exit();
                    }
                }

//                //saving data of user in database 
//                @$db = mysqli_connect('localhost', 'root', 'admin', 'cafeteria');
//                if (mysqli_connect_errno()) {
//                    echo $error = 'Could not connect to database. Please try again later.';
//                    exit;
//                }
                // insert data into database 
                $obj = ORM::getInstance();
                $obj->setTable('users');
                $obj->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => md5($_POST['password']), "room_no" => $_POST['roomno'], "ext" => $_POST['ext'], "is_admin" => 0, "question" => $_POST['securityquestion'], "answer" => $_POST['answer'], "pic" => $_FILES['userfile']['name']));
                header("Location: http://localhost/cafeteria/admin/all_users.php");


//                mysqli_close($db);
            }
        }
        ?>


        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <form  method='post' action='add_user.php' enctype="multipart/form-data" class="form-signin">
                        <h4> Add User</h4>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type='text' name='name'placeholder="Enter your name..." value="<?php
                            if (!empty($_POST['name'])) {
                                echo $_POST['name'];
                            }
                            ?>"  
                                   <span> <?php
                            if (isset($check[0])) {
                                echo " This field is required ";
                            }
                                  
                            ?> </span>
                        </div>

                        <div class="form-group">
                            <label>Email</label> 
                            <input class="form-control" type='text' name='email'placeholder="Enter your email..." value="<?php
                            if (!empty($_POST['email'])) {
                                echo $_POST['email'];
                            }
                            ?>"  > 
                            <span> <?php
                            if(isset($_POST['save'])){
                                echo $error = $valid->valid_email($_POST['email']);
                            }
                            ?> </span>
                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input class="form-control" type='password' name='password'placeholder="Enter your password...">
                            <span> <?php
                            if (isset($check[2])) {
                                echo " This field is required ";
                            }
                            ?> </span>
                        </div>

                        <div class="form-group">
                            <label> Confirmed password </label>
                            <input class="form-control" type='password' name='confirmpassword'placeholder="Enter password again...">
                            <span> <?php if (isset($_POST['save']) ) {
                                echo $error = $valid->valid_password(md5($_POST['password']), md5($_POST['confirmpassword']));
                            } ?> </span>
                        </div>

                        <div class="form-group">   
                            <label> Room No.</label>
                            <input class="form-control" type='text' name='roomno'placeholder="Enter your room no ..">
                            <span> <?php
                            if (isset($check[3])) {
                                echo " This field is required ";
                            }
                            ?> </span>
                        </div>
                        <div class="form-group"> 
                            <label> Ext..</label>
                            <input class="form-control" type='text' name='ext'placeholder="Enter your ext number..." >
                            <span> <?php
                            if (isset($check[4])) {
                                echo " This field is required ";
                            }
                            ?> </span>
                        </div>

                        <div class="form-group">
                            <label> Profile Picture</label>
                            <input type="file" name="userfile" id="profilepicture">

                        </div>

                        <div class="form-group"> 
                            <label> Security question</label>
                            <input class="form-control" type="text" name="securityquestion" placeholder="Type the question here..." >
                            <span> <?php
                                if (isset($check[5])) {
                                    echo " This field is required ";
                                }
                            ?> </span>
                        </div>

                        <div class="form-group"> 
                            <label> Answer </label>
                            <input class="form-control" type="text" name="answer" placeholder="Type the answer here..." >
                            <span> <?php
                                if (isset($check[6])) {
                                    echo " This field is required ";
                                }
                            ?> </span>
                        </div>

                        <input class="btn btn-success btn-sm" type='submit' name='save' value='Save'>
                        <input class="btn btn-danger btn-sm" type='reset' name='reset' value='Reset'>

                        </div>
                        </div>
                        </div>



                    </form>
                    </body>
                    </html>


