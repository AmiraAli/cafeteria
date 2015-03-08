
<?php
require '../model/model.php';
?>
<html>
    
    <h1 style="color:beige;">my orders</h1>
    <body>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link href="login.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <header>
        <style>


            .jumbotron
            {
                width: 800px;
                padding-top: 30px; 
                padding-bottom: 30px;
                margin-left: 180px;
                margin-top: -100px;
                background-color:rgba(192,192,192,0.7);
            }
        


        </style>      

    </header>
    <nav class="navbar navbar-inverse">

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

    </nav>
    <?php
    $obj_order = ORM::getInstance();
    $obj_order->setTable('orders');
    $all = $obj_order->select('id');
//    $order = $obj_order->select_all_sorted('datetime');

    $all_data = $obj_order->select_all();

    if ($all_data->num_rows > 0) {
        for ($i = 0; $i < $all_data->num_rows; $i++) {
            while ($order = $all_data->fetch_assoc()) {
                ?>
                <div class="container">
                    <table class=" table table-striped">
                        <thead>
                            <tr>
                                <th>Order date</th>
                                <th>name</th>
                                <th>Room No </th>
                                <th>EXT</th>
                                <th>action</th>
                                   
                                
                                <?php
                                $user_name = ORM::getInstance();
                                $user_name->setTable('users');
                                $user_info_array = $user_name->select(array('id' => $order['user_id']));
                                $user_info = $user_info_array->fetch_assoc();
                                ?>
                            </tr>  
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $order['datetime']; ?></td>
                                <td><?php echo $user_info['name']; ?></td>
                                <td><?php echo $user_info['room_no'];?></td>
                                <td><?php echo $user_info['ext'];?></td>

                                <td> <input type="radio" name="action" value="processing" 
                                                  >processing</input>

                                    <input type="radio" name="action" value="delivered">delivered</input>
                                    <input type="radio" name="action" value="done">done</input>

                                    <br><br></td>


                        </tbody>

                    </table>

                    <?php
                }
            }
            ?> 
        </div> 
</div>

    </body>
<?php } ?>
</html>


