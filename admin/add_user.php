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


        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header"> </div>
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Product</a></li>
                        <li><a href="#">Users</a></li>
                        <li><a href="#">Manual orders</a></li>
                        <li><a href="#">Checks</a></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <form  method='post' action='add_user.php' enctype="multipart/form-data" class="form-signin">
                        <h4> Add User</h4>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type='text' name='name'placeholder="Enter your name..."  >
                        </div>

                        <div class="form-group">
                            <label>Email</label> 
                            <input class="form-control" type='text' name='email'placeholder="Enter your email...">  
                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input class="form-control" type='password' name='password'placeholder="Enter your password...">
                        </div>

                        <div class="form-group">
                            <label> Confirmed password </label>
                            <input class="form-control" type='password' name='confirmpassword'placeholder="Enter password again...">
                        </div>

                        <div class="form-group">   
                            <label> Room No.</label>
                            <input class="form-control" type='text' name='roomno'placeholder="Enter your room no ..">
                        </div>
                        <div class="form-group"> 
                            <label> Ext..</label>
                            <input class="form-control" type='text' name='ext'placeholder="Enter your ext number..." >
                        </div>

                        <div class="form-group">
                            <label> Profile Picture</label>
                            <input type="file" name="userfile" id="profilepicture">
                        </div>

                        <div class="form-group"> 
                            <label> Security question</label>
                            <input class="form-control" type="text" name="securityquestion" placeholder="Type the question here..." >
                        </div>

                        <div class="form-group"> 
                            <label> Answer </label>
                            <input class="form-control" type="text" name="answer" placeholder="Type the answer here..." >
                        </div>

                        <input class="btn btn-success btn-sm" type='submit' name='save' value='Save'>
                        <input class="btn btn-danger btn-sm" type='reset' name='reset' value='Reset'>

                        </div>
                        </div>
                        </div>




                        <?php
                        include('validation.php');
                        include('database.php');

                        $valid = new validator();
                        $data = new admin_ORM();


                        if (!empty($_POST['save'])) {
                            $flag = true;
                           // check on validation 
                            $check = $valid->empty_fields($_POST);
                            if (gettype($check) == "array") {
                                for ($i = 0; $i < count($check); $i++) {
                                    echo $check[$i] . "<br/>";
                                }
                                $flag = false;
                            }
                            
                            //check on password&email&image 
                            echo $error = $valid->valid_password($_POST['password'], $_POST['confirmpassword']);
                            echo $error = $valid->valid_email($_POST['email']);
                            echo $error = $valid->valid_image($_FILES['userfile']['error'], $_FILES['userfile']['type']);
                            if (gettype($error) == "string") {
                                $flag = false;
                            }

                            if ($flag == true) {

                               //save image 

                               $upfile = '/var/www/cafeteria/images/users/'.$_FILES['userfile']['name'] ;
                                    if (is_uploaded_file($_FILES['userfile']['tmp_name']))
                                    {
                                            if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile))
                                            {
                                            echo 'can`t upload your image  '."<br/>";
                                            exit();
                                            }
                                    }

                                //saving data of user in database 
                                @$db = mysqli_connect('localhost', 'root', 'admin', 'cafeteria');
                                if (mysqli_connect_errno()) {
                                    echo $error = 'Could not connect to database. Please try again later.';
                                    exit;
                                }
                                // insert data into database 
                                $obj = admin_ORM::getInstance();
                                $obj->setTable('users');
                                echo $obj->insert(array("name" => $_POST['name'], "email" => $_POST['email'], "password" => $_POST['password'], "room_no" => $_POST['roomno'], "ext" => $_POST['ext'], "is_admin" => 0, "question" => $_POST['securityquestion'], "answer" => $_POST['answer'], "pic" => $_FILES['userfile']['name']));



                                mysqli_close($db);
                            }
                        }
                        ?>





                    </form>
                    </body>
                    </html>


