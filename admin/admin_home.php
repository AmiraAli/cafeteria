<?php session_start(); 
?>
<p>
    <?php
    if (isset($_SESSION['is_admin']))
        {
        $name = $_SESSION['user_name'];
        echo $name;
    }
    else {
        echo "sorry";
    }
    ?></p>
