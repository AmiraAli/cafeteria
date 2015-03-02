<?php
require 'user_model.php';
?>
<html>
    <head>
        <style>
            body{
                width:1000px;
                height:1000px;
                border-style: solid;
                border-width: 1px;
            }               
            .header{
                width:1000px;
                height:20px;
                border-style: solid;
                border-width: 1px;
            }
            .lists{
                width:600px;
                height:970px;
                border-style: solid;
                border-width: 1px;
                float: right;
            }
            .create_order{
                width:390px;
                height:970px;
                border-style: solid;
                border-width: 1px;
                float: left;
            }
            .last_order{
                width:600px;
                height:250px;
                border-style: solid;
                border-width: 1px;
            }
            .list_products{
                width:600px;
                height:780px;
                border-style: solid;
                border-width: 1px;
            }
            .create_order_products{
                width:300px;
                height:500px;
                border-style: solid;
                border-width: 1px;
            }

        </style>
    </head>
    <body>
        <div class="header">
            <a href="user_home.php">HOME</a>
            <a href="user_orders.php">My Orders</a>
            <p><?php   session_start(); 
                       $admin=$_SESSION['login_user'];
                       echo $admin;
            ?></p>
        </div>

        <div class="container">

            <div class="lists">
                <div class="last_order">
                    Last order:
                    <br/>
                    <?php
                    /**
                     * Select all product of latest order for the user
                     */
                    $obj_order = user_ORM::getInstance();
                    $obj_order->setTable('orders');

                    // select the latest order  of this user
                    $last_order = $obj_order->select_last_row(array('user_id' => 1));

                    if ($last_order) {

                        $order_id = $last_order['id'];
                        /**
                         * get all products of the last order
                         */
                        $obj_order_product = user_ORM::getInstance();
                        $obj_order_product->setTable('order_product');

                        $order_products = $obj_order_product->select(array('order_id' => $order_id));

                        while ($current_product = $order_products->fetch_assoc()) {
                            echo "Amount: " . $current_product['amount'];
                            echo " totalPrice: " . $current_product['total_price'];

                            //get the name of product and all it`s info
                            $obj_product_info = user_ORM::getInstance();
                            $obj_product_info->setTable('products');

                            $product_info_array = $obj_product_info->select(array('id' => $current_product['product_id']));
                            $product_info = $product_info_array->fetch_assoc();

                            echo " Name: " . $product_info['name'];
                            ?>
                            <img src="<?php echo "../images/products/" . $product_info['pic']; ?>" width="100px" height="100px">
                            <br>  
                            <?php
                        }
                    } else {
                        echo "NO Orders!!";
                    }
                    ?>

                </div>
                <div class="list_products">
                    All Products:
                    <br/>

                    <?php
                    /**
                     * Select all products
                     */
                    $obj_product = user_ORM::getInstance();
                    $obj_product->setTable('products');
                    $products = $obj_product->select(array("is_available" => 1));

                    //if there is more than one product while loop every time fetch row
                    if ($products->num_rows > 0) {

                        while ($row = $products->fetch_assoc()) {
                            ?>
                            <img src="<?php echo "../images/products/" . $row['pic']; ?>" width="100px" height="100px"
                                 onclick="add_product('<?php echo $row['name']; ?>',<?php echo $row['id']; ?>,<?php echo $row['price']; ?>)">
                                 <?php
                             }
                         } else {
                             echo "NO Products!!";
                         }
                         ?>
                </div>

            </div>
            <div class="create_order" id="create_order">

                <form method="post" action="user_home.php" >
                    <div class="create_order_products" id="create_order_products">

                    </div>
                    <br/>
                    <br/>
                    Notes <textarea name='notes'></textarea><br>
                    Room <select name="room">
                        <?php
                        /**
                         * get all rooms numbers
                         */
                        $obj_rooms = user_ORM::getInstance();
                        $obj_rooms->setTable('rooms');

                        $all_rooms = $obj_rooms->select_all();

                        if ($all_rooms->num_rows > 0) {

                            while ($room = $all_rooms->fetch_assoc()) {
                                foreach ($room as $key => $value) {
                                    ?>
                                    <option value="<?php $room['number'] ?>"><?php echo $room['number'] ?>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                            <option>NO Rooms
                                <?php
                            }
                            ?>
                    </select>
                    <br>
                    <br>

                    <input type='submit' name='confirm' value='Confirm' ><br/>
                    <label id="total_price">Total Price: 0</label>
                </form>
            </div>
        </div>
        
        <script>
            
            //global array of products id 
            var products_id = [];
            /**
             * this function to append the product in order form 
             * @param {type} name
             * @param {type} id
             * @param {type} price
             * @returns {undefined}
             */
            function add_product(name, id, price) {
                //if condition to check id the product is ordered before in this
                //order to increase the amount or not
                //check if the id of the product in the global array or not
                if (products_id.indexOf(id) === -1) {
                    //if product isn`t orderd before push it`s id in the array of products
                    products_id.push(id);
                    //select the div of order to append on the products
                    var elem_order = document.getElementById("create_order_products");
                    //create div it`s id equal to the product id
                    var elem_product = document.createElement("div");
                    elem_product.setAttribute("id", id);
                    elem_product.setAttribute("class", "product");
                    //create label for product with it`s name
                    var elem_product_name = document.createElement("label");
                    elem_product_name.innerHTML = name;
                    //create input field for amount of product
                    var elem_product_amount = document.createElement("input");
                    elem_product_amount.setAttribute("type", "text");
                    elem_product_amount.setAttribute("name", "amount");
                    elem_product_amount.setAttribute("value", "1");
                    //create label for product with it`s price
                    var elem_product_price = document.createElement("label");
                    elem_product_price.innerHTML = price;

                    //appeand parameter
                    elem_product.appendChild(elem_product_name);
                    elem_product.appendChild(elem_product_amount);
                    elem_product.appendChild(elem_product_price);
                    elem_order.appendChild(elem_product);

                } else {
                    //get the div of product by it`s id number
                    var elem_exists_product = document.getElementById(id);
                    //get value of the product and increase it by one
                    var value = elem_exists_product.childNodes[1].value;
                    value = parseInt(value) + 1;
                    elem_exists_product.childNodes[1].setAttribute("value", value);
                    //increase the price by increase it`s amount
                    var new_price = price * value;
                    elem_exists_product.childNodes[2].innerHTML = new_price;
                }
                //set the total price of the order in the label of total price
                //by select all products dev and get it`s price
                
                var total_price = 0;

                var products = document.getElementsByClassName("product");
                for (var i = 0; i < products.length; i++) {

                    total_price += parseInt(products[i].childNodes[2].innerHTML);
                }

                var elem_order_price = document.getElementById("total_price");
                elem_order_price.innerHTML = "Total Price: "+total_price;
                


            }

            /**
             * This function check if there are products in order or not
             * if there exists it return the total price of the order
             * @returns {String}
             */

            function check_order() {

                //check if the form order has childs of products or not
                var elem_order = document.getElementById("create_order_products");
                if (elem_order.childElementCount > 0) {
                    
                    var elem_order_price = document.getElementById("total_price");
                    var res = elem_order_price.innerHTML.split(" ");
                   window.location.href="user_home.php?totalprice=res[1]";
                } else {
                    return false;
                }

            }
                check_order();


        </script>
        <?php
        /**
         * insert the order into table of orders and table of order_product
         */
        
        if (!empty($_POST['confirm'])) {
         
            echo $_GET['totalprice'];
        }
        ?>

    </body>

</html>
