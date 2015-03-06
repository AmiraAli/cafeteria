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
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                   
                            <h4> All Users</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                     <tr class="info">
                                        <td>Name</td>
                                        <td>Room</td>
                                        <td>Image</td>
                                        <td>Ext</td>
                                        <td>Action</td>
                                     </tr>
                                     <?php
                                        $user_data = ORM::getInstance();
                                        $user_data->setTable('users');
                                        $all_data = $user_data->select_all();
                                        
                                        if ($all_data->num_rows > 0) {
                                            for ($i=0;$i<$all_data->num_rows;$i++){
                                                while($user= $all_data->fetch_assoc())
                                                {  
//                                                    
//                                                    
                                                   ?>
                                                        <tr>
                                                            <td> <?php echo $user['name']; ?></td>
                                                            <td> <?php echo $user['room_no']; ?></td>
                                                            <?php $imgpath="/cafeteria/images/users/".$user['pic']; ?>
                                                            <td><img src="<?php echo $imgpath; ?>" class="img-responsive" width="80" height="80"></td>
                                                            <td> <?php echo $user['ext']; ?></td>
                                                            
                                                            <td> <a href="delete.php?id=<?php echo $user['id']; ?>" >Delete</a>
                                                                <a href="edit.php?id=<?php echo $user['id']; ?>" >Edit</a> </td>
                                                                
                                                          

                                                             
                                                        </tr>
                                                        
                                                            <?php
                                                }
                                            
                                            
                                        
                                            }
                                        }
                                      ?>
                                     
                                      
                                     
                                     
                                </table>
                            </div>








    </body>
</html>




