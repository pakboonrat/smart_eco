<?php

include "function.php";

// $con = mysqli_connect($host, $user, $password,$dbname);
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con-> set_charset("utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}
//echo " console.log('test')";
if(isset($_POST['field']) && isset($_POST['value']) && isset($_POST['id']) && isset($_POST['user']) ){
   $field = mysqli_real_escape_string($con,$_POST['field']);
   $value = mysqli_real_escape_string($con,$_POST['value']);
   $listid = mysqli_real_escape_string($con,$_POST['id']);
   $userid = mysqli_real_escape_string($con,$_POST['user']);
   echo "post :".$_POST['value'];
   echo "$ :".$value;
//    $con = new DB_con();
// $query = "UPDATE list SET ".$field."='".$value."' WHERE list_id=".$editid;
   $query = "INSERT INTO transaction ( user_id, list_id, remark, file, status) VALUES ( '".$userid ."', '".$listid."', '".$value."', '', 'active' )";
   //mysqli_query($con,$query);
   alert('$query');
   echo $query;
}else{
   //echo $value;
   //$value = mysqli_real_escape_string($con,$_POST['value']);
   //$filename = $_FILES['file']['name'];
   //echo $_POST['value'];
   if ( isset($_POST['value'] ) ){
      $val = $_POST['value'];
      echo $_POST["value"];
  }
  echo $_POST["value"];
  //print_r($_POST());
}
exit;


// จาก file ajax
// file name
$filename = $_FILES['file']['name'];

// Location
$location = 'transaction/'.$filename;

// file extension
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);

// Valid image extensions
$image_ext = array("jpg","png","jpeg","gif");

//$response = 0;
$response = $filename;
if(in_array($file_extension,$image_ext)){
  // Upload file
  if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $response = $location;
  }
}

echo $response;


?>