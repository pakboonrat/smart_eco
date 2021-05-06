<?php

include "function.php";

// $con = mysqli_connect($host, $user, $password,$dbname);
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con-> set_charset("utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

                        // level_id: level_id,
						// score_id: score_id,
						// comment: comment,
						// approve_action: approve_action,
						// audit: audit,
						// user_id: user_id,
						// input_type: input_type	

if( $_POST['input_type'] != 'cancle' && isset($_POST['input_type']) && isset($_POST['level_id']) && isset($_POST['audit']) && isset($_POST['approve_action']) && isset($_POST['comment']) && isset($_POST['user_id']) ){
    $level_id = mysqli_real_escape_string($con,$_POST['level_id']);
    $comment = mysqli_real_escape_string($con,$_POST['comment']);
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $audit = mysqli_real_escape_string($con,$_POST['audit']);
    if($_POST['input_type'] == '-') {
        $input_type = "basic";
    }else{
        $input_type = $_POST['input_type'];
    }
    $input_type = mysqli_real_escape_string($con,$input_type);
    $score_id = mysqli_real_escape_string($con,$_POST['score_id']);
    
         if($_POST['approve_action'] == "ผ่านอนุมัติ" ){
            $status = "pass";

            // pass cancle_app_id       // ค่า list T และ M โดยมี :: คั่น
            if(isset($_POST['cancle_app_id']) ){
                $pass_var = explode("::", $_POST['cancle_app_id'] );
                // $pass_var[0]  >> 
                // $pass_var[1]  >> 
                if( $pass_var[0] ==""){
                    $query_passT = " ";
                }else{
                    $query_passT = " UPDATE transaction SET status='pass' WHERE t_id in (".$pass_var[0].");" ;
                }

                if( $pass_var[1] ==""){
                    $query_passU = " ";
                }else{
                    $query_passU = " UPDATE user_add SET status='pass' WHERE add_id in (".$pass_var[1].");" ;
                }

                $sql_pass = $query_passT . $query_passU ;
            }else{

                $sql_pass = " ";
                $query_passT = "";
            };

            


            


         }elseif($_POST['approve_action'] == "ไม่ผ่านการพิจารณา"  ){
            $status = "reject";
            $sql_pass = " " ;
         }

    $status_app = mysqli_real_escape_string($con,$status);



    


   if($input_type == 'control' OR $input_type == 'basic'){
        
        

        $query = "INSERT INTO `aprove_list_score`   (`user_id`,  `type`         , `level_id`, `score_id`, `status`, `point`, `score_des`, `audit_id`, `remark` ) 
                VALUES  ('$user_id', '$input_type'  , '$level_id', NULL, '$status_app', '', '', '$audit', '$comment') ;";
   //   INTO `aprove_list_score` ( `user_id`, `type`, `level_id`, `score_id`, `status`, `point`, `score_des`, `audit_id`, `remark`, ) 
   //   VALUES ( '$user_id', '$input_type', '$level_id', NULL, '$status_app', '', '', '$audit', '')";
    //mysqli_query($con,$query);

    }elseif($_POST['input_type'] == 'measure' && isset($_POST['point']) && isset($_POST['score_des']) ){
        $point = mysqli_real_escape_string($con,$_POST['point']);
        $score_des = mysqli_real_escape_string($con,$_POST['score_des']);
        $query = "INSERT INTO `aprove_list_score` (`user_id`, `type` , `level_id`, `score_id`, `status`, `point`, `score_des`, `audit_id`, `remark` ) 
                VALUES  (                       '$user_id','$input_type','$level_id',$score_id, '$status_app', '$point', '$score_des', '$audit', '$comment') ;";
   //   INTO `aprove_list_score` ( `user_id`, `type`, `level_id`, `score_id`, `status`, `point`, `score_des`, `audit_id`, `remark`, ) 
   //   VALUES ( '$user_id', '$input_type', '$level_id', NULL, '$status_app', '', '', '$audit', '')";
    //mysqli_query($con,$query);
      
   }

   //$query = $sql_pass . $query ;
   
   if (mysqli_query($con,$query)){
        $result_sql = true;
        $result_sql1 = true;

        if($_POST['approve_action'] == "ผ่านอนุมัติ" ){
            if( trim($query_passT) != ""){
                if(mysqli_query($con,$query_passT)){
                    $result_sql1 = true;
                }
            }
            if( trim($query_passU) != ""){
                if(mysqli_query($con,$query_passU)){
                    $result_sql1 = $result_sql1 AND true;
                }
            }
        }

       

       $result_sql = $result_sql AND $result_sql1;

       echo $result_sql;
    
    

    }else{
    echo $query ;
    }
    exit;

}elseif($_POST['input_type'] == 'cancle' && isset($_POST['cancle_app_id']) ){
    if($_POST['cancle_app_id'] != "0"){
     $cancle_app_id = mysqli_real_escape_string($con,$_POST['cancle_app_id']);
    //  $query = "UPDATE `aprove_list_score` SET `status` = 'cancle' WHERE `aprove_list_score`.`aprove_id` = $cancle_app_id";
     $query = "DELETE FROM `aprove_list_score` WHERE `aprove_list_score`.`aprove_id` = $cancle_app_id " ;

    }else{
     echo "--" .$query ;
     exit;
    }

    if (mysqli_query($con,$query)){
        echo 1 ;
        }else{
        echo $query ;
        }
        exit;
}


exit;




?>