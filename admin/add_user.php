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
        
        if (!empty($_GET)) {
            $user_data = explode(",", $_GET['user1']);
            
        }
        // check on validation
        if (!empty($_POST['save'])) {
            if (empty($_POST['user_update'])) {
                $flag = true;
                $check = $valid->empty_fields($_POST);
                if (gettype($check) == "array") {
                    for ($i = 0; $i < count($check); $i++) {
                        $check[$i];
                    }
                    $flag = false;
                }
          
                if (count($check) == 1 && $check[0] == 'user_update is required') {
                    $flag = true;
                }



//                check on password&email&image 
                $error_password = $valid->valid_password(md5($_POST['password']), md5($_POST['confirmpassword']));
                 if (gettype($error_password) == "string") {
                    $flag = false;
                }
                $error_email = $valid->valid_email($_POST['email']);
                 if (gettype($error_email) == "string") {
                    $flag = false;
                }
                $error_image = $valid->valid_image($_FILES['userfile']['error'], $_FILES['userfile']['type']);
                if (gettype($error_image) == "string") {
                    $flag = false;
                }
                
                if ($flag == true) {
                    $upfile = '/var/www/cafeteria/images/users/' . $_FILES['userfile']['name'];
                    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)) {
                            echo 'can`t upload your image  ' . "<br/>";
                            exit();
                        }
                    }

                    $obj = ORM::getInstance();
                    $obj->setTable('users');
                    $inserted = $obj->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => md5($_POST['password']), "room_no" => $_POST['roomno'], "ext" => $_POST['ext'], "is_admin" => 0, "question" => $_POST['securityquestion'], "answer" => $_POST['answer'], "pic" => $_FILES['userfile']['name']));
                    echo $inserted;
                    header("Location: http://localhost/cafeteria/admin/all_users.php");
                }
            }
            else {
                $flag = true;
                $check = $valid->empty_fields($_POST);
                if (gettype($check) == "array") {
                    $flag = false;
                    for ($i = 0; $i < count($check); $i++) {
                        $check[$i];
                    }
                }
                
              $error_password = $valid->valid_password(md5($_POST['password']), md5($_POST['confirmpassword']));
                 if (gettype($error_password) == "string") {
                    $flag = false;
                }
                $error_email = $valid->valid_email($_POST['email']);
                 if (gettype($error_email) == "string") {
                    $flag = false;
                }
                $error_image = $valid->valid_image($_FILES['userfile']['error'], $_FILES['userfile']['type']);
                if (gettype($error_image) == "string") {
                    $flag = false;
                }

                //check on password&email&image 
               
                if ($flag == true) {
                    $upfile = '/var/www/cafeteria/images/users/' . $_FILES['userfile']['name'];
                    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)) {
                            echo 'can`t upload your image  ' . "<br/>";
                            exit();
                        }
                    }

                $user_data = explode(",", $_POST['user_update']);
                $obj = ORM::getInstance();
                $obj->setTable('users');
                $updated = $obj->update(array('id' => $user_data[0]), array("name" => $_POST['name'], "email" => $_POST['email'], "password" => $_POST['password'], "room_no" => $_POST['roomno'], "ext" => $_POST['ext'], "is_admin" => 0, "question" => $_POST['securityquestion'], "answer" => $_POST['answer'], "pic" => $_FILES['userfile']['name']));
                echo $updated;
                header("Location: http://localhost/cafeteria/admin/all_users.php");
            }
            else{
                $user=$_POST['user_update'];
                header("Location: http://localhost/cafeteria/admin/add_user.php?user1=$user");
            }
            }
        }
        ?>

        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <form  method='POST' action='add_user.php' enctype="multipart/form-data" class="form-signin"> 
                        <input type="hidden" name="user_update" value="<?php if (isset($_GET['user1'])) {
            echo $_GET['user1'];
        } ?>">
                        <h4> Add User</h4>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type='text' name='name'placeholder="Enter your name..." value="<?php
        if (!empty($_POST['name'])) {
            echo $_POST['name'];
        }
        if (!empty($_GET)) {
            echo $user_data[1];
        }
        ?>">
                            <span> <?php
        if (isset($check[0]) && (empty($_POST['name']))) {
            echo " This field is required ";
        }
        ?></span>
                        </div>


                        <div class="form-group">
                            <label>Email</label> 
                            <input class="form-control" type='text' name='email'placeholder="Enter your email..." value="<?php
                                if (!empty($_POST['email'])) {
                                    echo $_POST['email'];
                                }
                                if (!empty($_GET)) {
                                    echo $user_data[2];
                                }
                                ?>"<?php if (!empty($_GET)) { ?> readonly="readonly"<?php } ?> >
                            <span> <?php
                                if (isset ($error_email)) {
                                    echo $error_email;
                                }
                                ?>    
                            </span>
                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input class="form-control" type='password' name='password' placeholder="Enter your password..." value="<?php
                            if (!empty($_POST['password'])) {
                                echo $_POST['password'];
                            }
                            if (!empty($_GET)) {
                                echo $user_data[3];
                            }
                                ?>"> 
                            <span> <?php
                            if (isset($check[2]) && (empty($_POST['password']))) {
                                echo " This field is required ";
                            }
                                ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label> Confirmed password </label>
                            <input class="form-control" type='password' name='confirmpassword'placeholder="Enter password again..." value="<?php
                            if (!empty($_POST['confirmpassword'])) {
                                echo $_POST['confirmpassword'];
                            }
                            if (!empty($_GET)) {
                                echo $user_data[3];
                            }
                                ?>">
                            <span> <?php
                            if (isset($error_password)) {
                                echo $error_password;
                            }
                                ?> 
                            </span>
                        </div>

                        <div class="form-group">   
                            <label> Room No.</label>
                            <input class="form-control" type='text' name='roomno'placeholder="Enter your room no .." value="<?php
                            if (!empty($_POST['roomno'])) {
                                echo $_POST['roomno'];
                            }
                            if (!empty($_GET)) {
                                echo $user_data[4];
                            }
                                ?>">
                            <span> <?php
                            if (isset($check[3]) && (empty($_POST['roomno']))) {
                                echo " This field is required ";
                            }
                                ?> 
                            </span>
                        </div>

                        <div class="form-group"> 
                            <label> Ext..</label>
                            <input class="form-control" type='text' name='ext'placeholder="Enter your ext number..." value="<?php
                            if (!empty($_POST['ext'])) {
                                echo $_POST['ext'];
                            }
                            if (!empty($_GET)) {
                                echo $user_data[5];
                            }
                                ?>">
                            <span> <?php
                            if (isset($check[4]) && (empty($_POST['ext']))) {
                                echo " This field is required ";
                            }
                                ?> 
                            </span>
                        </div>

                        <div class="form-group">
                            <label> Profile Picture</label>
                            <input type="file" name="userfile" id="profilepicture">
                            <span> <?php
                                if (isset($error_image)) {
                                 echo $error_image ; 
                                }
                                
                                ?>    
                            </span>

                        </div>

                        <div class="form-group"> 
                            <label> Security question</label>
                            <input class="form-control" type="text" name="securityquestion" placeholder="Type the question here..." value="<?php
                            if (!empty($_POST['securityquestion'])) {
                                echo $_POST['securityquestion'];
                            }
                            if (!empty($_GET)) {
                                echo $user_data[7];
                            }
                                ?>" >
                            <span> <?php
                            if (isset($check[5]) && (empty($_POST['securityquestion']))) {
                                echo " This field is required ";
                            }
                                ?> 
                            </span>
                        </div>

                        <div class="form-group"> 
                            <label> Answer </label>
                            <input class="form-control" type="text" name="answer" placeholder="Type the answer here..." value="<?php
                            if (!empty($_POST['answer'])) {
                                echo $_POST['answer'];
                            }
                            if (!empty($_GET)) {
                                echo $user_data[8];
                            }
                                ?>" >
                            <span> <?php
                            if (isset($check[6]) && (empty($_POST['answer']))) {
                                echo " This field is required ";
                            }
                                ?> 
                            </span>
                        </div>

                        <input class="btn btn-success btn-sm" type='submit' name='save' value='Save'>
                        <input class="btn btn-danger btn-sm" type='reset' name='reset' value='Reset'>

                        </div>
                        </div>
                        </div>




                    </form>
                    </body>
                    </html>
