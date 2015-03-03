<?php
require '../model/model.php';
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
        <div class="container">
            <div class="col-md-3 panel panel-default"  id="create_order">
                <div class="panel panel-heading">

                    <h1>   Order  </h1>
                </div>
                <form method="post"  >
                    <div class="row panel-body" id="create_order_products">

                    </div>
                    <label  class="col-sm-2 control-label">Notes:</label>
                    <textarea class="form-control" rows="3" id="notes"></textarea>
                    <label  class="col-sm-2 control-label">Rooms:</label>
                    <select name="room" id="room" class="form-control" id="user">
                        <?php
                        /**
                         * get all rooms numbers
                         */
                        $obj_rooms = ORM::getInstance();
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
                    <input type='submit' name='confirm' value='Confirm' class="btn btn-primary" onclick="get_order()"><br/>
                    <label id="total_price" class=" control-label">Total Price: 0</label>
                </form>
            </div>
            <div class="col-md-9 panel panel-default">
                <div class="row panel-body">

                    <div class="panel panel-heading">

                        <h1> Add to user:</h1>
                    </div>

                    <select class="form-control  " id="user">
                        <?php
                        /**
                         * get all users name
                         */
                        $obj_users = ORM::getInstance();
                        $obj_users->setTable('users');

                        $all_users = $obj_rooms->select_all();

                        if ($all_users->num_rows > 0) {

                            while ($user = $all_users->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $user['name']; ?>"> <?php echo $user['name']; ?> 
                                    <?php
                                }
                            } else {
                                ?>
                            <option>NO Users
                                <?php
                            }
                            ?>
                    </select>
                </div>
                <div class="row">
                    <div class="row panel-body">

                        <div class="panel panel-heading">

                            <h1>Menu</h1>
                        </div>

                        <?php
                        /**
                         * Select all products
                         */
                        $obj_product = ORM::getInstance();
                        $obj_product->setTable('products');
                        $products = $obj_product->select(array("is_available" => 1));

                        //if there is more than one product while loop every time fetch row
                        if ($products->num_rows > 0) {
                            $j = 1;
                            while ($row = $products->fetch_assoc()) {
                                ?>
                                <div class="col-md-<?php echo $j + 1; ?>">
                                    <img src="<?php echo "../images/products/" . $row['pic']; ?>" width="120px" height="120px" class="img-responsive img-circle"
                                         onclick="add_product('<?php echo $row['name']; ?>',<?php echo $row['id']; ?>,<?php echo $row['price']; ?>)">
                                </div>
                                <?php
                                $j = $j + 1;
                            }
                        } else {
                            echo "NO Products!!";
                        }
                        ?>
                    </div>
                </div>
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
                    elem_product_name.setAttribute("class", " control-label");
                    elem_product_name.innerHTML = "  Name: " + name;
                    //create input field for amount of product
                    var elem_product_amount = document.createElement("input");
                    elem_product_amount.setAttribute("class", "form-control");
                    elem_product_amount.setAttribute("type", "text");
                    elem_product_amount.setAttribute("name", "amount");
                    elem_product_amount.setAttribute("value", "1");
                    //create label for product with it`s price
                    var elem_product_price = document.createElement("label");
                    elem_product_price.setAttribute("class", " control-label");
                    elem_product_price.innerHTML = "  Price: " + price;

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
                    elem_exists_product.childNodes[2].innerHTML = "  Price: " + new_price;
                }
                //set the total price of the order in the label of total price
                //by select all products dev and get it`s price

                var total_price = 0;

                var products = document.getElementsByClassName("product");

                for (var i = 0; i < products.length; i++) {
                    total_price += parseInt(products[i].childNodes[2].innerHTML.split(" ")[3]);
                }

                var elem_order_price = document.getElementById("total_price");
                elem_order_price.innerHTML = "Total Price: " + total_price;

            }

            /**
             * this function that get the order informations to insert in database
             * @returns {undefined}
             */

            function get_order() {


                //check if the form order has childs of products or not
                var elem_order = document.getElementById("create_order_products");

                if (elem_order.childElementCount > 0) {

                    //get value of all price of order
                    var elem_order_price = document.getElementById("total_price");
                    var orderPrice = elem_order_price.innerHTML.split(" ");

                    //get all order notes
                    var elem_order_notes = document.getElementById("notes").value;

                    //get room name from the select
                    var elem_order_room = document.getElementById("room");
                    var order_room = elem_order_room.options[elem_order_room.selectedIndex].text;
                    
                    //get user name from the select
                    var elem_order_user = document.getElementById("user");
                    var order_user = elem_order_user.options[elem_order_user.selectedIndex].text;

                    var product_info = "";

                    //forloop to get all product and send it in array to request
                    for (var i = 1; i <= elem_order.childElementCount; i++) {

                        var all_products = elem_order.childNodes;

                        //console.log(all_products[1]);
                        var product = all_products[i];

                        //alert(product.nodeType ? "true" : "false" );

                        var product_id = product.getAttribute("id");


                        var product_amount = product.childNodes[1].value;

                        var product_price = product.childNodes[2].innerHTML.split(" ")[3];


                        product_info += product_id + ":" + product_amount + ":" + product_price + ",";

                    }

                    //open xmlhttp request that render to user_order and send total order & products
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("POST", "admin_order.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("order_price=" + orderPrice[2] + "&room=" + order_room +"&user="+ order_user +"&notes=" + elem_order_notes + "&array=" + product_info);

                    //on change check even the request send or not
                    
                    xmlhttp.onreadystatechange = function () {
                        
                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

                            console.log(xmlhttp.responseText);

                        }
                    };

                }


            }

        </script>
    </body>
</html>



