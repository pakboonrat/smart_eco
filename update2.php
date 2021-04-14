<?php

include "function.php";

// $con = mysqli_connect($host, $user, $password,$dbname);
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con-> set_charset("utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}


if(isset($_POST['t_id']) && isset($_POST['comment']) && isset($_POST['audit']) && isset($_POST['approve_action'])){
   $t_id = mysqli_real_escape_string($con,$_POST['t_id']);
   $comment = mysqli_real_escape_string($con,$_POST['comment']);
   $audit = mysqli_real_escape_string($con,$_POST['audit']);
   if($_POST['approve_action'] == "ผ่านอนุมัติ" ){
      $t_status = "pass";
   }elseif($_POST['approve_action'] == "Reject"  ){
      $t_status = "reject";
   }
   $t_status = mysqli_real_escape_string($con,$t_status);
//    $con = new DB_con();
   $query = "UPDATE transaction SET status='".$t_status."' WHERE t_id=".$t_id;
   $query2 = "INSERT INTO `aprove`(`t_id`, `audit_id`,`remark`) VALUES ('$t_id', '$audit', '$comment')";
   mysqli_query($con,$query);
   if (mysqli_query($con,$query) and $comment != "" ){
      mysqli_query($con,$query2);
      echo 1;
   }else{
   echo 1;
   }
}else{
   echo 0;
}
exit;


?>