<?php
include('validation.php');
include('database.php');
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


                    <form  method='post' action='add_product.php' enctype="multipart/form-data" class="form-signin">
                        <h4> Add Product </h4>
                        <div class="form-group">
                            <label>Product</label>
                            <input class="form-control" type='text' name='product'placeholder="Enter product name..."  >
                        </div>

                        <div class="form-group">
                            <label>Price</label> 
                            <input class="form-control" type='number' name='price'placeholder="Enter price here...">  
                        </div>

                        <div class="form-group" id="1">
                            <label>Categories</label>

                            <select class="form-control" name="category">
                                <?php
                                /**
                                 * get all categories from datbase 
                                 */
                                $obj_categories = admin_ORM::getInstance();
                                $obj_categories->setTable('categories');

                                $all_categories = $obj_categories->select_all();
                                
                       
                                if ($all_categories->num_rows > 0) {

                                    for ($i=0;$i<$all_categories->num_rows;$i++){
                                            $category = $all_categories->fetch_assoc();
                                      
                                        //foreach ($category as $key => $value) {
                                            ?> 
                                            <option name="option" value="<?php echo trim($category['name']) ?>"> <?php echo $category['name'] ?>
                                            <?php
                                       // }
                                    }
                                } else {
                                    ?>
                                    <option> no category </option>  
                                    <?php
                                }
                                ?>   

                            </select>
                            <button  class="form-control"class="btn btn-default btn-xs"   value="text"type="button" onclick="addText();">add category</button>
                            <div id="div2"></div> 
                            <script type="text/javascript">
                                function addText()
                                        {
                                        var div1=document.getElementById("div2");
                                        div1.innerHTML="<input type='text'/>";
                                        }
                                 </script>
                            
                        </div>

                        <div class="form-group">
                            <label> Product Picture</label>
                            <input type="file" name="productfile" id="profilepicture">
                        </div>

                        <div class="form-group" class="checkbox">
                            <label>  
                                <input type="checkbox" name="checkbox"> Is available
                            </label>
                        </div>

                        <input class="btn btn-success btn-sm" type='submit' name='save' value='Save'>
                        <input class="btn btn-danger btn-sm" type='reset' name='reset' value='Reset'>



                        </div>
                        </div>
                        </div>
        <?php

                $valid = new validator();
                $data = new admin_ORM();
                if (!empty($_POST['save'])) {
                    $flag = true;
                    
//                    var_dump( $_POST);
                    // check on validation 
                    $check = $valid->empty_fields($_POST);
                    if (gettype($check) == "array") {
                        for ($i = 0; $i < count($check); $i++) {
                            echo $check[$i] . "<br/>";
                        }
                        $flag = false;
                    }

                    //check on image 
                    echo $error = $valid->valid_image($_FILES['productfile']['error'], $_FILES['productfile']['type']);
                    if (gettype($error) == "string") {
                        $flag = false;
                    }

                    if ($flag == true) {

                        //save image 

                        $upfile = '/var/www/cafeteria/images/products/' . $_FILES['productfile']['name'];
                        if (is_uploaded_file($_FILES['productfile']['tmp_name'])) {
                            if (!move_uploaded_file($_FILES['productfile']['tmp_name'], $upfile)) {
                                echo 'can`t upload your image  ' . "<br/>";
                            }
                        }

                        //saving data of user in database 
                        @$db = mysqli_connect('localhost', 'root', 'admin', 'cafeteria');
                        if (mysqli_connect_errno()) {
                            echo $error = 'Could not connect to database. Please try again later.';
                            exit;
                        }
                        // insert data into database 
                        $obj_category = admin_ORM::getInstance();
                        $obj_category->setTable('categories');
                        $all_data=$obj_category->select(array('name' => $_POST['category']));
                        $current_cat = $all_data->fetch_assoc();
                        $id=$current_cat['id'];
                        
                        $obj = admin_ORM::getInstance();
                        $obj->setTable('products');
                        
                        echo $obj->insert(array("name" => $_POST['product'], "price" => $_POST['price'], "category_id"=>$id, "is_available"=>$_POST['checkbox'],"pic" => $_FILES['productfile']['name']));

                        mysqli_close($db);
                    }
                }
                
                ?>



</form>
</body>
</html>


