<?php
include('validation.php');
require '../model/model.php';
require './admin_header.php';


                $valid = new validator();
                if (!empty($_GET)) {
                    $product_data = explode(",", $_GET['product1']);
                }
                
                if (!empty($_POST['save'])) {
                     if (empty($_POST['product_update'])) {
                         
                    $flag = true;

                    // check on validation 
                    $check = $valid->empty_fields($_POST);
                    if (gettype($check) == "array") {
                        for ($i = 0; $i < count($check); $i++) {
                             $check[$i] . "<br/>";
                        }
                        $flag = false;
                    }
                    
                    if (count($check) == 1 && $check[0] == 'product_update is required') {
                    $flag = true;
                }

                    //check on image 
                    $error_image = $valid->valid_image($_FILES['productfile']['error'], $_FILES['productfile']['type']);
                    if (gettype($error_image) == "string") {
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


                        // insert data into database 
                        $obj_category = ORM::getInstance();
                        $obj_category->setTable('categories');
                        $all_data=$obj_category->select(array('name' => $_POST['category']));
                        $current_cat = $all_data->fetch_assoc();
                        $id=$current_cat['id'];
                        
                        $obj = ORM::getInstance();
                        $obj->setTable('products');
                        //var_dump($_POST);
                       // exit;
                        if(empty($_POST['checkbox'])){
                            $is_avaliable="0";
                        }else{
                            $is_avaliable=$_POST['checkbox'];
                        }
                         $obj->insert(array("name" => $_POST['product'], "price" => $_POST['price'], "category_id"=>$id, "is_available"=>$is_avaliable,"pic" => $_FILES['productfile']['name']));
                        header("Location: http://localhost/cafeteria/admin/all_products.php");
//                        mysqli_close($db);
                    }
                }
               else{
                $flag = true;
                $check = $valid->empty_fields($_POST);
                if (gettype($check) == "array") {
                    $flag = false;
                    for ($i = 0; $i < count($check); $i++) {
                        $check[$i];
                    }
                }

                $error_image = $valid->valid_image($_FILES['productfile']['error'], $_FILES['productfile']['type']);
                if (gettype($error_image) == "string") {
                    $flag = false;
                }

                //check on password&email&image 
               
                if ($flag == true) {
                    $upfile = '/var/www/cafeteria/images/products/' . $_FILES['productfile']['name'];
                    if (is_uploaded_file($_FILES['productfile']['tmp_name'])) {
                        if (!move_uploaded_file($_FILES['productfile']['tmp_name'], $upfile)) {
                            echo 'can`t upload your image  ' . "<br/>";
                            exit();
                        }
                    }

                $obj_category = ORM::getInstance();
                $obj_category->setTable('categories');
                $all_data=$obj_category->select(array('name' => $_POST['category']));
                $current_cat = $all_data->fetch_assoc();
                $id=$current_cat['id'];
                        
                        
                $product_data = explode(",", $_POST['product_update']);
                $obj = ORM::getInstance();
                $obj->setTable('products');
                if(empty($_POST['checkbox'])){
                            $is_avaliable="0";
                        }else{
                            $is_avaliable=$_POST['checkbox'];
                        }
                
                $updated = $obj->update(array('id' => $product_data[0]), array("name" => $_POST['product'], "price" => $_POST['price'], "category_id"=>$id, "is_available"=>$is_avaliable,"pic" => $_FILES['productfile']['name']));
                echo $updated;
                header("Location: http://localhost/cafeteria/admin/all_products.php");
            }
            else{
                $product=$_POST['product_update'];
                header("Location: http://localhost/cafeteria/admin/add_product.php?product1=$product");
            }
               }
                
    }
                
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



        <div class="container">
            <div class="row"> 
               <div class="col-md-offset-4 col-md-4">


                    <form  method='post' action='add_product.php' enctype="multipart/form-data" class="form-signin">
                    <input type="hidden" name="product_update" value="<?php if (isset($_GET['product1'])) {
                        echo $_GET['product1'];
                    } ?>">
                        <h4> Add Product </h4>
                        <div class="form-group">
                            <label>Product</label>
                            <input class="form-control" type='text' name='product'placeholder="Enter product name..." value="<?php 
                             if (!empty($_POST['product'])) {
                                    echo $_POST['product'];
                             }
                             
                             if (!empty($_GET)) {
                                echo $product_data[1];
                            }
                            ?>" >
                            <span> <?php
                                if (isset($check[0]) && (empty($_POST['product']))) {
                                    echo " This field is required ";
                                }
                                ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Price</label> 
                            <input class="form-control" type='number' name='price'placeholder="Enter price here..." value="<?php 
                             if (!empty($_POST['price'])) {
                                    echo $_POST['price'];
                                }
                                 if (!empty($_GET)) {
                                echo $product_data[2];
                            }
                            ?>">  
                             <span> <?php
                                if (isset($check[1]) && (empty($_POST['price']))) {
                                    echo " This field is required ";
                                }
                                ?>
                            </span>
                        </div>

                        <div class="form-group" id="1">
                            <label>Categories</label>

                            <select class="form-control" name="category" >
                                <?php
                                /**
                                 * get all categories from datbase 
                                 */
                                $obj_categories =ORM::getInstance();
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
                                <span> <?php
                                if (isset($error_image)) {
                                 echo $error_image ; 
                                }
                                
                                ?>    
                            </span>
                        </div>

                        <div class="form-group" class="checkbox">
                            <label>  
                                <input type="checkbox" name="checkbox" value="1"> Is available
                            </label>
                            
                        </div>

                        <input class="btn btn-success btn-sm" type='submit' name='save' value='Save'>
                        <input class="btn btn-danger btn-sm" type='reset' name='reset' value='Reset'>



                        </div>
                        </div>
                        </div>
       

</form>
</body>
</html>


