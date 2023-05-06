<?php  
  $db_host = "localhost";
  $db_name = "arecibo_db";
  $db_pass = "ajFk04%1_vbc9G@"; // WARNING
  $db_user = "wc6KimonQZFw"; // WARNING 

  $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  
  if (!$con){
    die('Failed to connect with server.');
  }

  if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
?>