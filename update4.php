<?php

include "function.php";

// $con = mysqli_connect($host, $user, $password,$dbname);
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con-> set_charset("utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

// update table `transaction` หรือ `user_add` เป็น consider
if( isset($_POST['input_type']) && isset($_POST['app_id'])  ){
    $input_type = mysqli_real_escape_string($con,$_POST['input_type']);
    $app_id = mysqli_real_escape_string($con,$_POST['app_id']);
    if($input_type == 't') {
        // Delete 
        $app_table_type = "aprove";
        $app_field_name_id = "t_id";
        // UPDATE __  SET `status` = 'consider'
        $table_type = "transaction";
        $field_name_id = "t_id";

    }elseif($input_type == 'u'){
        // Delete 
        $app_table_type = "aprove_user_add";
        $app_field_name_id = "add_id";
        // UPDATE __  SET `status` = 'consider'
        $table_type = "user_add";
        $field_name_id = "add_id";


    }else{
        echo "การเลือกขอบเขตข้อมูลไม่ถูกต้อง";
        exit;
    }

    $query = "DELETE FROM `$app_table_type` WHERE `$app_table_type`.`$app_field_name_id` = $app_id " ;
                

        // "DELETE FROM `aprove_user_add` WHERE `aprove_user_add`.`t_id` = 3"
        // "DELETE FROM `aprove` WHERE `aprove`.`add_id` = 2"

    $query2 = "UPDATE `$table_type` SET `status` = 'consider' WHERE `$table_type`.`$field_name_id` = $app_id;" ;

        // UPDATE `transaction` SET `status` = 'consider' WHERE `transaction`.`t_id` = 14;
        // UPDATE `user_add` SET `status` = 'consider' WHERE `user_add`.`add_id` = 3;

   
   if (mysqli_query($con,$query)){

        $result = " ";
    }else{
        $result = " โปรดตรวจสอบข้อมูลอีกครั้ง " ;
    }
    

    if (mysqli_query($con,$query2)){

        $result2 = " การยกเลิกการพิจารณาเรียบร้อย : ".$query2 ;
    }else{
        $result2 = " ไม่สามารถ ยกเลิกการพิจารณา : ";
        }
    
    echo $result2.$result ;
    exit;

}else{
    
     echo "-เลือกประเภทข้อมูลไม่ถูกต้อง-"  ;
     exit;
    
}

echo "-การเชื่อมต่อฐานข้อมูลขัดข้อง-" ;
exit;


?>