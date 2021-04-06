<?php

include "function.php";

// $con = mysqli_connect($host, $user, $password,$dbname);
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con-> set_charset("utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['field']) && isset($_POST['value']) && isset($_POST['id'])){
   $field = mysqli_real_escape_string($con,$_POST['field']);
   $value = mysqli_real_escape_string($con,$_POST['value']);
   $editid = mysqli_real_escape_string($con,$_POST['id']);
   echo "post :".$_POST['value'];
   echo "$ :".$value;
//    $con = new DB_con();
   $query = "UPDATE list SET ".$field."='".$value."' WHERE list_id=".$editid;
   mysqli_query($con,$query);

   echo 1;
}else{
   echo 0;
}
exit;

?>