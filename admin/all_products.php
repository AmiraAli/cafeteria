<?php
require '../model/model.php';
require './admin_header.php';
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
            <div class="row page-header center-block">
                <h2> All Products</h2>
            </div>

            <div class="row">
                <button type="button" class="btn btn-warning pull-right"onclick="addproduct()">Add Product</button>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">


                    <div class="table-responsive">
                        <table class="table ">
                            <tr class=" row Active">
                                <td class="col-md2">Name</td>
                                <td class="col-md2">Price</td>
                                <td class="col-md2">Image</td>
                                <td class="col-md2">Status</td>
                                <td class="col-md2">Action</td>
                            </tr>
                            <?php
                            $category_data = ORM::getInstance();
                            $category_data->setTable('products');
                            $all_data = $category_data->select_all();

                            if ($all_data->num_rows > 0) {
                                for ($i = 0; $i < $all_data->num_rows; $i++) {
                                    while ($category = $all_data->fetch_assoc()) {
                                        ?>
                                        <tr class="row">
                                            <td class="col-md2"> <?php echo $category['name']; ?></td>
                                            <td class="col-md2"> <?php echo $category['price']; ?></td>
                                            <?php $imgpath = "../images/products/" . trim($category['pic']); ?>
                                            <td class="col-md2"><img src="<?php echo $imgpath; ?>" class="img-responsive img-circle" width="100" height="100"></td>
                                            <td class="col-md2"><?php
                                                if ($category['is_available'] == "1") {
                                                    echo "Avaliable";
                                                
                                                ?></td>
                                            <td class="col-md2"> <a  class="btn btn-danger"  href="delete_pro.php?id=<?php echo $category['id']; ?>" >Delete</a>
                                                 <a  class="btn btn-success"  href="edit_pro.php?id=<?php echo $category['id']; ?>" > Edit</a> 
                                            </td>
                                            <?php
                                            }else{
                                                    echo "Un Avaliable";
                                                    
                                                    ?></td>
                                            <td class="col-md2"> 
                                                 <a class="btn btn-success" href="edit_pro.php?id=<?php echo $category['id']; ?>" > Edit</a> 
                                            </td>
                                            <?php
                                                }
                                            ?>
                                        </tr>

                                        <?php
                                    }
                                }
                            }
                            ?>




                        </table>
                    </div>

                    <script>
                        function addproduct() {
                            window.open("http://localhost/cafeteria/admin/add_product.php", "_parent");
                        }
                    </script>
                    </body>
                    </html>




