<?php

?>
<html>

<body>
		 <textarea id="ta" rows="35" cols="50">kjn</textarea>

<script>

	var exampleSocket = new WebSocket("ws://127.0.0.1:8000");


	exampleSocket.onmessage = function (event) {
	  //console.log(event.data);
          
//          var control_msg=event.data.split(";");
//          
//           if(control_msg[0] === "cancel"){
//               
//               console.log( control_msg[0]);
//                var data_after_parsing=control_msg[1]+" is canceled";
//                console.log( data_after_parsing);
//           }
//           
//           if(control_msg[0] === "confirm"){
//               
//               console.log( control_msg[0]);
//                var data_after_parsing=control_msg[1]+" is confirmed";
//                console.log( data_after_parsing);
//           }
//           
          //alert(event.data);
	 // document.getElementById("ta").value = document.getElementById("ta").value+'\n'+data_after_parsing;

         //test for parse jason object
         var msg = JSON.parse(event.data);
         alert(msg.foo);
    
    };
      </script>
</body>
</html>