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
                    <a class="navbar-btn pull-right" href="../login/logout.php">Logout</a>
                    <?php
                    session_start();
                    ?>
                    <img src="<?php
                    if (isset($_SESSION['user_pic'])) {
                        $user_pic = $_SESSION['user_pic'];
                        echo "../images/users/" . $user_pic;
                    } else {
                        header("Location: ../login/login.php");
                    }
                    ?>" class="pull-right" width="50px" height="50px">
                    <p class="navbar-text pull-right"> welcome 
                        <?php
                        if (isset($_SESSION['user_pic'])) {
                            $user_name = $_SESSION['user_name'];
                            echo " ".$user_name;
                        } else {
                            header("Location: ../login/login.php");
                        }
                        ?></p>
                     
                    <ul class="nav navbar-nav">
                        <li class="active"><a  navbar-brandhref="user_home.php">Home</a></li>
                        <li><a href="user_orders.php">My Orders</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </body>

</html>

