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
                <h2> All Users</h2>
            </div>
            <div class="row">
                <button type="button" class="btn btn-warning pull-right"onclick="adduser()">Add User</button>
            </div>
            <div class="row">
                <div class="col-md-offset-0 col-md-12">

                    
                    <div class="table-responsive">
                        <table class="table ">
                            <tr class=" row active">
                                <td class="col-md-2">Name</td>
                                <td class="col-md-2">Room</td>
                                <td class="col-md-2">Image</td>
                                <td class="col-md-2">Ext</td>
                                <td class="col-md-2">Action</td>
                            </tr>
                            <?php
                            $user_data = ORM::getInstance();
                            $user_data->setTable('users');
                            $all_data = $user_data->select(array('is_admin'=>0));

                            if ($all_data->num_rows > 0) {
                                for ($i = 0; $i < $all_data->num_rows; $i++) {
                                    while ($user = $all_data->fetch_assoc()) {            
                                                 
                                        ?>
                                        <tr class="row">
                                            <td class="col-md-2"> <?php echo $user['name']; ?></td>
                                            <td class="col-md-2"> <?php echo $user['room_no']; ?></td>
                                            <?php $imgpath = "../images/users/" . trim($user['pic']); ?>
                                            <td class="col-md-2"><img src="<?php echo $imgpath; ?>" class="img-responsive img-circle" width="80" height="80"></td>
                                            <td class="col-md-2"> <?php echo $user['ext']; ?></td>

                                            <td class="col-md-2"> <a class="btn btn-danger" href="delete.php?id=<?php echo $user['id']; ?>" >Delete</a>
                                                <a class="btn btn-success" href="edit.php?id=<?php echo $user['id']; ?>" >Edit</a> 
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
                        function adduser(){
                            window.open("http://localhost/cafeteria/admin/add_user.php","_parent");
                        }
                    </script>

                    </body>
                    </html>
                    




