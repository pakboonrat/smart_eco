<?php

include "function.php";

// $con = mysqli_connect($host, $user, $password,$dbname);
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con-> set_charset("utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['input_type'])){

   if($_POST['input_type'] == 't'){

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
         
         if(!isset($_POST['only_insert_aprove'])){
            
               mysqli_query($con,$query);
               if(mysqli_query($con,$query) and $comment != "" ){
                  mysqli_query($con,$query2);
                  echo 1;
                  
                  // if($t_status == "reject" ){
                  //    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
                  //    $notif = new DB_con();
                  //    $notif_sent = $notif->send_notif_USER($audit, $user_id,"สถานะ : ไม่ผ่านการอนุมัติ ");
                  //    // $notif_sent > return 0 , 1  // send_notif_USER(USER_ID ผู้ส่ง , USER_ID คนรับ  ,"ข้อความ");
                  // }


               }else{
                  echo 1;
               }

         }elseif($_POST['only_insert_aprove']===true){
            if(mysqli_query($con,$query2)){
               echo 1;
               exit;
            }else{
               echo $query2;
            }
         }


      }else{
         echo 0;
      }
      exit;



   }elseif($_POST['input_type'] == 'a'){

      
      if(isset($_POST['t_id']) && isset($_POST['comment']) && isset($_POST['audit']) && isset($_POST['approve_action'])){
         $add_id = mysqli_real_escape_string($con,$_POST['t_id']);
         $comment = mysqli_real_escape_string($con,$_POST['comment']);
         $audit = mysqli_real_escape_string($con,$_POST['audit']);
         if($_POST['approve_action'] == "ผ่านอนุมัติ" ){
            $t_status = "pass";
         }elseif($_POST['approve_action'] == "Reject"  ){
            $t_status = "reject";
         }
         $t_status = mysqli_real_escape_string($con,$t_status);
         //    $con = new DB_con();
         $query = "UPDATE user_add SET status='".$t_status."' WHERE add_id=".$add_id;
         $query2 = "INSERT INTO `aprove_user_add`(`add_id`, `audit_id`,`remark`) VALUES ('$add_id', '$audit', '$comment')";
         
         if(!isset($_POST['only_insert_aprove_user_add'])){

         
            mysqli_query($con,$query);
            if (mysqli_query($con,$query) and $comment != "" ){
               mysqli_query($con,$query2);
               echo 1;

               // if($t_status == "reject" ){
               //    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
               //    $notif = new DB_con();
               //    $notif_sent = $notif->send_notif_USER($audit, $user_id,"การส่งหลักฐาน สถานะ : ไม่ผ่านการอนุมัติ ");
               //    // $notif_sent > return 0 , 1  // send_notif_USER(USER_ID ผู้ส่ง , USER_ID คนรับ  ,"ข้อความ");
               // }

               
            }else{
            echo 1;
            }
         }elseif ($_POST['only_insert_aprove_user_add']===true) {
            if(mysqli_query($con,$query2)){
               echo 1;
               exit;
            }else{
               echo $query2;
            }
         }


      }else{
         echo 0;
      }
      exit;



   }


} 
exit;




?>