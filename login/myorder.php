<html>
    <body>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link href="login.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <header>
        <style>
            .background{

                background-image: url("../images/products/tea_with_milk.jpg");
                background-repeat: no-repeat;
                background-size: cover;
                height: 1100px;
                

            }

            .jumbotron
            {
                width: 800px;
                padding-top: 30px; 
                padding-bottom: 30px;
                margin-left: 180px;
                margin-top: -100px;
                background-color:rgba(192,192,192,0.7);
            }
            #first
            {
                height:300px; 
                width: 800px;
                margin-top: 1px;
                margin-left: 180px;
            }

            #second

            {
                width: 800px;
                padding-top: 30px; 
                padding-bottom: 30px;
                margin-left: 180px;
                margin-top: 0px;
                background-color:rgba(192,192,192,0.7);
               
            }
            
            
            #third
            {
                 height:300px; 
                width: 800px;
                margin-top: 1px;
                margin-left: 180px;
                
            }


        </style>      

    </header>
    <div class="container">
        <div class="background">
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
            ]

            <h1 style="color:beige;">my orders</h1>

            <div class="jumbotron"  >
                <table class=" table table-striped">
                    <thead>
                        <tr>
                            <th>Order date</th>
                            <th>name</th>
                            <th>Room No </th>
                            <th>EXT</th>
                            <th>action</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <tr>
                            <td>abdelrahman hamedy</td>
                            <td>1000</td>
                            <td>2006</td>
                            <td>355</td>
                                
                            <td>delivered</td>
                       

                    </tbody>

                </table>     

            </div>
            <div class="jumbotron" id="first">
                <table class=" table table-striped">
                    
                </table> 
            </div>

            <div class="jumbotron" id="second">
                 <table class=" table table-striped">
                    <thead>
                        <tr>
                            <th>Order date</th>
                            <th>name</th>
                            <th>Room No </th>
                            <th>EXT</th>
                            <th>action</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <tr>
                            <td>abdelrahman hamedy</td>
                            <td>1000</td>
                            <td>2006</td>
                            <td>355</td>
                                
                         <td>delivered</td>            
                    </tbody>
                </table> 

            </div>
            <div class="jumbotron" id="third">
                <table class=" table table-striped">
                    
                </table> 
            </div>
        </div>

    </div>

</body>
</html>

