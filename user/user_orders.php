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


        <div class="container">
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
                    <button type="button" class="btn btn-success pull-right" onclick="select_orders()"c>Get my orders</button>
                </div>
            </div>
            <div class="row">
                <div class="row table-responsive">
                    <table class="table table-bordered" id="table">
                        <tr class="active">
                            <td> Order Date</td>
                            <td> Status</td>
                            <td> Total price</td>
                            <td> Action</td>
                        </tr>
                    </table>
                </div>
            </div>
            <nav>
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
            </nav>
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


                if (date_to !== "" && date_from !== "") {



                    //open xmlhttp request that render to user_order and send date to & date from
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("POST", "user_get_orders.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("dateTo=" + date_to + "&dateFrom=" + date_from);

                    //on change check even the request send or not and get the values of response

                    xmlhttp.onreadystatechange = function () {

                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

                            //get information of response of orders
                            console.log(xmlhttp.responseText);
                            var get_order_info = xmlhttp.responseText.split(",");
                            
                            var elem_table = document.getElementById("table");
                            console.log(elem_table.childElementCount);
                            
                            //check if there is date before remove it and get the new date
                            //if(elem_table.childElementCount>1){
                                
                               // console.log(elem_table.childElementCount);
                                
                               // for(var x=1;x<elem_table.childElementCount;x++){
                                    
                               //     elem_table.removeChild(elem_table.childNodes[x]);
                             //   }
                           // }

                            console.log(get_order_info);

                            for (var i = 0; i < get_order_info.length - 1; i++) {

                                var order = get_order_info[i];
                                console.log(order);

                                //set information in table of each order
                                
                                var tr = document.createElement("tr");
                                tr.setAttribute("class", "info");


                                var order_data = order.split(";");
                                //set tr by id equal to order id
                                tr.setAttribute("id",order_data[0]);
                               
                                for (var j = i; j < order_data.length - 1 && i == j; j++) {

                                    var td_date = document.createElement("td");
                                    td_date.innerHTML = order_data[1];

                                    var td_status = document.createElement("td");
                                    td_status.innerHTML = order_data[2];

                                    var td_totalprice = document.createElement("td");
                                    td_totalprice.innerHTML = order_data[3];
                                    
                                    //if the statues is processing add button cancel
                                    if (td_status.innerHTML === "processing") {
                                        var td_cancel = document.createElement("td");
                                        var cancel_btn = document.createElement("button");
                                        cancel_btn.innerHTML = "Cancel";
                                        cancel_btn.setAttribute("class", "btn btn-danger");
                                        //get id of the order
                                       var order_id=tr.getAttribute("id");
                                        cancel_btn.setAttribute("onclick", "cancel("+order_id+")");

                                    }

                                    tr.appendChild(td_date);
                                    tr.appendChild(td_status);
                                    tr.appendChild(td_totalprice);

                                    if (td_status.innerHTML === "processing") {
                                        td_cancel.appendChild(cancel_btn);
                                        tr.appendChild(td_cancel);
                                    }

                                }
                                elem_table.appendChild(tr);

                            }
                        }

                    };
                }
            }

            /**
             * Cancel function that is calling when click on cancel action
             */
            function cancel(order_id) {
                console.log(order_id);
                document.getElementById(order_id).remove();
            }


        </script>
    </body>
</html>