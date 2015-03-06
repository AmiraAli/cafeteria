<?php
require 'user_header.php';
require '../model/model.php';
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


        <div class="container" id="contatiner">
            <div class="row">

                <div class="panel panel-heading">

                    <h1> My orders </h1>
                </div>
                <div class="col-md-5">
                    <label  class="col-sm-2 control-label"  >From:</label>
                    <input class="form-control" type = 'date' name="date_from" id="date_from" >
                </div>
                <div class="col-md-5">
                    <label  class="col-sm-2 control-label"  >To:</label>
                    <input class="form-control" type = 'date'  tname="date_to" id="date_to" >
                </div>
                <div class="col-sm-3 pull-right">
                    <button type="button" class="btn btn-success pull-right" onclick="select_orders()">Get my orders</button>
                </div>
            </div>
            <div class="row">
                <div class="row table-responsive">
                    <table class="table table-bordered" >
                        <tr class="active">
                            <td class="col-md-3"> Order Date</td>
                            <td class="col-md-3"> Status</td>
                            <td class="col-md-3"> Total price</td>
                            <td class="col-md-3 "> Action</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="row table-responsive"  id="table_row">
                    <table id="table">

                    </table>
                </div>
            </div>
            <div class="row" id="products_row">
                <div class="row" id="products">

                </div>
            </div>
            <div class=" row panel ">
                <div class="  col-md-2 panel-title alert alert-success" id="total">
                    Total: 0
                </div>
                
            </div>
           

            <!--            <nav>
                            <ul class="col-md-8 pull-right pagination" id="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>-->
        </div>

        <script>


            /**
             * function to get the value of date to when key up
             * @returns {Element.value}
             */
            function get_date_to() {
                return document.getElementById("date_to").value;
            }

            /**
             * function to get the value of date from when key up
             * @returns {Element.value}
             */
            function get_date_from() {
                return document.getElementById("date_from").value;
            }

            /**
             * if there is the value for date to and date from select orders
             */

            function select_orders() {


                var date_to = get_date_to();
                var date_from = get_date_from();

                //get orders when the user select dates
                if (date_to !== "" && date_from !== "") {



                    //open xmlhttp request that render to user_get_order and send date to & date from
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("POST", "user_get_orders.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("dateTo=" + date_to + "&dateFrom=" + date_from);

                    //on change check even the request send or not and get the values of response

                    xmlhttp.onreadystatechange = function () {

                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

                            //get information of response of orders

                            var get_order_info = xmlhttp.responseText.split(",");

                            //select the table of old date and remove it

                            var elem_table = document.getElementById("table");
                            if (elem_table !== null) {
                                elem_table.remove();
                            }
                            var elem_products = document.getElementById("products");
                            if (elem_products !== null) {
                                elem_products.remove();
                            }

                            //get row of table to append on it
                            var table_row = document.getElementById("table_row");

                            //create new table withe id table
                            var elem_table_new = document.createElement("table");
                            elem_table_new.setAttribute("id", "table");
                            elem_table_new.setAttribute("class", "table table-bordered");

                            var table_header = document.createElement("tr");
                            elem_table_new.appendChild(table_header);

                            table_row.appendChild(elem_table_new);

                            //select table by its id to add the information on it
                            var elem_table_exist = document.getElementById("table");

                            console.log(get_order_info);
                            console.log(get_order_info.length);

                            for (var i = 0; i < get_order_info.length - 1; i++) {

                                var order = get_order_info[i];
                                console.log(order);

                                //set information in table of each order in rows

                                var tr = document.createElement("tr");
                                tr.setAttribute("class", "active");


                                //get array of colums in each row

                                var order_data = order.split(";");

                                //set tr by id equal to order id
                                tr.setAttribute("id", order_data[0]);

                                var td_date = document.createElement("td");
                                td_date.setAttribute("class", "col-md-3");
                                td_date.innerHTML = order_data[1];

                                //create button to show order by id "order_id btn"
                                var get_product_btn = document.createElement("button");
                                get_product_btn.setAttribute("id", order_data[0] + " btn");
                                get_product_btn.setAttribute("class", "btn btn-success pull-right");
                                get_product_btn.innerHTML = "+";
                                get_product_btn.setAttribute("onclick", "show_order('" + order_data[0] + " btn" + "')");


                                var td_status = document.createElement("td");
                                td_status.setAttribute("class", "col-md-3");
                                td_status.innerHTML = order_data[2];



                                var td_totalprice = document.createElement("td");
                                td_totalprice.innerHTML = order_data[3];
                                td_status.setAttribute("class", "col-md-3");

                                //if the statues is processing add button cancel
                                if (td_status.innerHTML === "processing") {


                                    var td_cancel = document.createElement("td");
                                    var cancel_btn = document.createElement("button");
                                    cancel_btn.innerHTML = "Cancel";
                                    cancel_btn.setAttribute("class", "col-md-5 btn btn-danger pull-right ");

                                    //get id of the order to send it to the function onclick
                                    var order_id = tr.getAttribute("id");
                                    cancel_btn.setAttribute("onclick", "cancel(" + order_id + ")");

                                }

                                td_date.appendChild(get_product_btn);
                                tr.appendChild(td_date);


                                tr.appendChild(td_status);


                                tr.appendChild(td_totalprice);


                                if (td_status.innerHTML === "processing") {

                                    td_cancel.appendChild(cancel_btn);

                                    tr.appendChild(td_cancel);

                                }

                                elem_table_exist.appendChild(tr);

                            }
                        }

                    };
                    set_total_price(date_to, date_from, "amira");
                }

            }

            /**
             * Cancel function that is calling when click on cancel action
             */
            function cancel(order_id) {
                console.log(order_id);
                document.getElementById(order_id).remove();
            }


            /**
             * function show orders used to show all the products of the order
             */
            function show_order(bttn_id) {

                //get the id of order from bttn id
                var order_id = bttn_id.toString().split(" ")[0];

                var bttn = document.getElementById(bttn_id);
                if (bttn.innerHTML === "+") {
                    bttn.innerHTML = "-";

                    //select the contatiner to append div on it
                    var elem_product_row = document.getElementById("products_row");
                    // create the div with id products to append on it the products of the order
                    var elem_products = document.createElement("div");
                    elem_products.setAttribute("id", "products");
                    elem_products.setAttribute("class", "row");

                    //create new row with id equal to "order_id product"
                    var elem_order_products = document.createElement("div");
                    elem_order_products.setAttribute("id", order_id + " product");
                    elem_order_products.setAttribute("class", "row alert alert-success");

                    //open xmlhttp request that render to user_get_order_products and send order_id to get all products
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("POST", "user_get_order_products.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("order_id=" + order_id);

                    //on change check even the request send or not


                    xmlhttp.onreadystatechange = function () {

                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

                            console.log(xmlhttp.responseText);


                            //get information of response of order products with comma separated

                            var get_order_info = xmlhttp.responseText.split(",");


                            for (var i = 0; i < get_order_info.length - 1; i++) {

                                var order = get_order_info[i];

                                //get information about products by semicolum separated
                                var order_products = order.split(";");

                                var product_name = order_products[0];
                                var product_pic_path = order_products[1];
                                var product_amount = order_products[2];
                                var product_totalPrice = order_products[3];

                                var j = i + 2;
                                var product_colum = document.createElement("div");
                                product_colum.setAttribute("class", "col-md-" + j);


                                var product_name_row = document.createElement("div");
                                product_name_row.setAttribute("class", "row");

                                var product_name_label = document.createElement("label");
                                product_name_label.innerHTML = "Name: " + product_name;


                                var product_amount_row = document.createElement("div");
                                product_amount_row.setAttribute("class", "row");

                                var product_amount_label = document.createElement("label");
                                product_amount_label.innerHTML = "Amount: " + product_amount;



                                var product_price_row = document.createElement("div");
                                product_price_row.setAttribute("class", "row");

                                var product_price_label = document.createElement("label");
                                product_price_label.innerHTML = "Price: " + product_totalPrice;


                                var product_pic_row = document.createElement("div");
                                product_pic_row.setAttribute("class", "row");

                                var product_pic = document.createElement("img");
                                product_pic.setAttribute("src", "../images/products/" + product_pic_path);
                                product_pic.setAttribute("class", "img-responsive img-circle");
                                product_pic.setAttribute("width", "120px");
                                product_pic.setAttribute("height", "120px");


                                product_name_row.appendChild(product_name_label);
                                product_amount_row.appendChild(product_amount_label);
                                product_price_row.appendChild(product_price_label);
                                product_pic_row.appendChild(product_pic);

                                product_colum.appendChild(product_name_row);
                                product_colum.appendChild(product_amount_row);
                                product_colum.appendChild(product_price_row);
                                product_colum.appendChild(product_pic_row);

                                elem_order_products.appendChild(product_colum);


                            }


                        }
                    };



                    elem_products.appendChild(elem_order_products);
                    elem_product_row.appendChild(elem_products);


                } else {
                    bttn.innerHTML = "+";

                    //get the order products dev to remove

                    var elem_order_products_remove = document.getElementById(order_id + " product");
                    elem_order_products_remove.remove();

                }

            }

            /**
             * this function used to setthe total price
             * @param {type} date_to
             * @param {type} date_from
             * @param {type} user_name
             * @returns {undefined}
             */
            function set_total_price(date_to, date_from, user_name) {

                //open xmlhttp request that render to admin_get_check and send date to & date from & user_name
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "../admin/admin_get_check_user.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("dateTo=" + date_to + "&dateFrom=" + date_from + "&user_name=" + user_name);

                //on change check even the request send or not and get the values of response

                xmlhttp.onreadystatechange = function () {

                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

                        //get information of response of orders
                        console.log(xmlhttp.responseText);

                        var user_info = xmlhttp.responseText.split(";");

                        var total_price = document.getElementById("total");
                        if (user_info[1] !== "") {
                            total_price.innerHTML ="Total: "+user_info[1];
                        } else {
                            total_price.innerHTML ="Total: "+"0";
                        }
                    }
                };
            }


        </script>
    </body>
</html>