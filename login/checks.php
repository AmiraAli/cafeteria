<html>
    <body>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link href="login.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>
    <header>
        <style>
            .background{

                background-image: url("../images/products/tea_with_milk.jpg");
                background-repeat: no-repeat;
                background-size: cover;

            }

            .jumbotron
            {
                width: 800px;
                margin-left: 180px;
                margin-top: 30px;
                background-color:rgba(192,192,192,0.7);
            }
            #first
            {
                height:300px; 
                width: 600px;
                margin-top: 1px;
                margin-left: 270px;
            }

            #second

            {
                height:300px; 
                width: 500px;
                margin-top: 1px;
                margin-left: 320px; 
            }
            .btn-group
            {
                margin-left: 200px;
                width: 800px;
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
            <div class="row">
                <div class="input-daterange col-lg-10"  >
                    <input value="2012-04-05" />
                    <span class="add-on col-lg-2">to</span>
                    <input value="2012-04-07" />
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">users</a></li>
                    <li class="divider"></li>
                    <li><a href="#">order date</a></li>
                    
                </ul>
            </div>

            <p>users</p>

            <div class="jumbotron"  >
                <table class=" table table-striped">
                    <thead>
                        <tr>
                            <th>Names</th>
                            <th>Total amount</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <tr>
                            <td>John</td>
                            <td>1000</td>

                        </tr>
                        <tr>
                            <td>abdelrhaman mohamed</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>sayed</td>
                            <td>500</td>
                        </tr>

                        <tr>
                            <td>eslam</td>
                            <td>500</td>
                        </tr>

                    </tbody>

                </table>     

            </div>



            <div class="jumbotron" id="first">
                <table class=" table table-striped">
                    <thead>
                        <tr>
                            <th>Order date</th>
                            <th>amount</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <tr>
                            <td>+30/3/45555</td>
                            <td>500 EGP</td>

                        </tr>
                        <tr>
                            <td>+5/6//6/777</td>
                            <td>100 EGP</td>

                        </tr>
                        <tr>
                            <td>+28/6/1985</td>
                            <td>500 EGP</td>
                        </tr>

                        <tr>
                            <td>+29/8/1980</td>
                            <td>500 EGP</td>
                        </tr>

                    </tbody>

                </table> 
            </div>




            <div class="jumbotron" id="second">
                <img src="../images/products/tea_with_milk.jpg" class="img-circle" alt="Cinque Terre" width="304" height="236"> 

            </div>
        </div>

    </div>

</body>
</html>



