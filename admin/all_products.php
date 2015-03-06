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
                <button type="button" class="btn btn-info pull-right"onclick="addproduct()">Add Product</button>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="info">
                                <td>Name</td>
                                <td>Price</td>
                                <td>Image</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                            <?php
                            $category_data = ORM::getInstance();
                            $category_data->setTable('products');
                            $all_data = $category_data->select_all();

                            if ($all_data->num_rows > 0) {
                                for ($i = 0; $i < $all_data->num_rows; $i++) {
                                    while ($category = $all_data->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td> <?php echo $category['name']; ?></td>
                                            <td> <?php echo $category['price']; ?></td>
                                            <?php $imgpath = "../images/products/" . trim($category['pic']); ?>
                                            <td><img src="<?php echo $imgpath; ?>" class="img-responsive" width="80" height="80"></td>
                                            <td><?php
                                                if ($category['is_available'] == "1") {
                                                    echo "Avaliable";
                                                }else{
                                                    echo "Unavaliable";
                                                }
                                                ?></td>
                                            <td> <a href="delete_pro.php?id=<?php echo $category['id']; ?>" >Delete</a>
                                            </td>
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




