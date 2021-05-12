<?php 

    //$remote = $_SERVER["REMOTE_ADDR"]; 
    //$ip = getenv(REMOTE_ADDR); 
    //print_r("Your IP Address is $remote "); 
    //print_r($_SERVER["REMOTE_HOST"]); 
    if ($_SERVER['SERVER_NAME'] == "smartecosis.com") {
        
        define('DB_HOST', 'localhost'); // Your hostname
        define('DB_USER', 'smarteco_admin'); // Database Username
        define('DB_PASS', 'smartECO*2021'); // Database Password
        define('DB_NAME', 'smarteco_001'); // Database Name
    }elseif( $_SERVER['SERVER_NAME'] = "localhost" ){
        
        define('DB_HOST', '127.0.0.1'); // Your hostname 127.0.0.1
        define('DB_USER', 'root'); // Database Username
        define('DB_PASS', ''); // Database Password
        define('DB_NAME', 'smarteco'); // Database Name
    }

    class DB_con {
        function __construct() {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // mysql_db_query($conn,"SET NAMES utf8"); 
            $conn-> set_charset("utf8");
            $this->dbcon = $conn;

            

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        }

        public function getCon() {
            return $this->dbcon;
        }

        public function usernameavailable($uname) {
            $checkuser = mysqli_query($this->dbcon, "SELECT username FROM user WHERE username = '$uname'");
            return $checkuser;
        }

        public function registration($username ,$password ,$email ,$user_type, $firstname, $surname, $phone_no, $department,  $active) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO user(username, password, user_type, email, firstname, surname, phone_no, department , active, format_id ) VALUES('$username' ,'$password', '$user_type' ,'$email', '$firstname', '$surname', '$phone_no', '$department', $active, 1) ");
           // echo INSERT INTO user(username, password, user_type, email, firstname, surname, phone_no, department , active ) VALUES('$username' ,'$password', '$user_type' ,'$email', '$firstname', '$surname', '$phone_no', '$department', $active)";
            return $reg;
        }

        public function signin($uname, $password) {
            $signinquery = mysqli_query($this->dbcon, "SELECT user_id, firstname , user_type FROM user WHERE username = '$uname' AND password = '$password'");
            return $signinquery;
        }
		
		public function sel_username($user_id) {
            $signinquery = mysqli_query($this->dbcon, "SELECT user_id, firstname , user_type FROM user WHERE user_id = '$user_id'");
            return $signinquery;
        }

        public function fetch_level($id,$set_lebel) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM level WHERE level_id = '$id' and set_lebel = '$set_lebel' ");
            return $result;
        }

        public function fetch_level_header($level_label,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT set_lebel FROM level WHERE level_label = '$level_label' and level_id in (SELECT level_id FROM `format_todo_list` where format_id = (SELECT format_id FROM `user` where user_id = '$userid')) ");
			//SELECT DISTINCT set_lebel FROM level WHERE level_id in (SELECT level_id FROM `format_todo_list` where format_id = (SELECT format_id FROM `user` where user_id = '3'))
            return $result;
        }
		
		public function level_headeradmin($level_label) {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT set_lebel FROM level where level_label = '$level_label' ");
            
            return $result;
        }
		
		public function sel_score_status($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT point, status,remark FROM `aprove_list_score` where level_id = '$level_id' and user_id = '$userid' ");
            return $result;
        }

        public function fetchdata($level_label,$set_lebel,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM level WHERE level_label = '$level_label' and set_lebel = '$set_lebel' and level_id in (SELECT level_id FROM `format_todo_list` where format_id = (SELECT format_id FROM `user` where user_id = '$userid')) ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function basic_report($userid) {
            $result = mysqli_query($this->dbcon, "SELECT level_id,sub_lebel,level_label,set_lebel FROM `level` where set_lebel = 'basic' and level_id in (SELECT level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid' UNION select level_id from user_add where user_id = '$userid')");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function control_report($userid) {
            $result = mysqli_query($this->dbcon, "SELECT level_id,sub_lebel,level_label,set_lebel,type FROM `level` where set_lebel = 'Guidelines' and type in ('control','measure') and level_id in (SELECT level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid') UNION
select level_id,sub_lebel,level_label,set_lebel,type from `level` where set_lebel = 'Guidelines' and type in ('control','measure') and level_id in (SELECT DISTINCT(level_id) FROM `user_add` where user_id = '$userid') ORDER by level_id ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function measure_report($userid) {
            $result = mysqli_query($this->dbcon, "SELECT level_id,sub_lebel FROM `level` where set_lebel = 'Guidelines' and type = 'measure' and level_id in (SELECT level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid')");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }

		public function basic_report_tran($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT T1.status as status ,L1.list_label as list_label , T1.list_id,T1.t_id as id , A2.a_date , A2.firstname as fname FROM transaction T1 INNER JOIN list L1 ON T1.list_id = L1.list_id LEFT JOIN ( SELECT A1.t_id , U1.firstname , A1.aprove_date AS a_date FROM aprove A1 , user U1 WHERE A1.audit_id = U1.user_id ) A2 ON A2.t_id = T1.t_id WHERE T1.user_id = '$userid' and L1.level_id = '$level_id' UNION SELECT AD.status as status ,AD.list_label as list_label, AD.level_id,AD.add_id as id , AA2.a_date , AA2.firstname as fname FROM user_add AD LEFT JOIN ( SELECT AU1.add_id , UU1.firstname , AU1.aprove_date AS a_date FROM aprove_user_add AU1 , user UU1 WHERE AU1.audit_id = UU1.user_id ) AA2 ON AA2.add_id = AD.add_id WHERE AD.user_id = '$userid' and AD.level_id = '$level_id' ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		//public function sel_name_time($t_id) {
          //  $result = mysqli_query($this->dbcon, "select aprove.t_id,user.firstname,aprove.aprove_date from aprove INNER JOIN user ON aprove.audit_id = user.user_id where aprove.t_id = '$t_id' ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            //return $result;
        //}
		
		public function count_basic_report_tran($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "select sum(count) as tran_total_count from (SELECT count(*) as count FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid' and level_id = '$level_id' UNION all SELECT count(*) as count FROM user_add WHERE user_id = '$userid' and level_id = '$level_id' ) as temp ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function fetch_allrules($userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM level WHERE level_id in (SELECT level_id FROM `format_todo_list` where format_id = (SELECT format_id FROM `user` where user_id = '$userid'))");
            return $result;
        }
		
		public function select_scoredes($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "select score_des,point from score where score_id in (SELECT score_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid' and level_id = '$level_id') ");
            //select score_des from score where score_id in (SELECT score_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '3' and level_id = '5')
            return $result;
        }
		
		public function select_uadd_scoredes($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "select score_des,point from score where score_id in (SELECT score_id FROM `user_add` WHERE user_id = '$userid' and level_id = '$level_id') ");
            //select score_des from score where score_id in (SELECT score_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '3' and level_id = '5')
            return $result;
        }

        public function fetchdata_admin($level_label,$set_lebel,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM level WHERE level_label = '$level_label' and set_lebel = '$set_lebel' ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }

        public function fetch_list($level_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM list WHERE level_id = '$level_id'  ");
            return $result;
        }

        // fetch_score
        public function fetch_score($level_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM `score` where score_id in (SELECT score_id FROM `list` WHERE level_id = '$level_id' GROUP by `score_id`)");
            //SELECT * FROM `score` where score_id in (SELECT score_id FROM `list` WHERE level_id = '5' GROUP by `score_id`)
            return $result;
        }
		
		public function fetch_only_onescore($level_id, $userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM `score` where score_id in (SELECT score_id FROM `list` WHERE level_id = '$level_id' and score_id in (select score_id from list where list_id in (select list_id from transaction where user_id = '$userid') union select score_id from user_add where level_id = '$level_id' and user_id = '$userid' ) GROUP by `score_id`)");
            //SELECT * FROM `score` where score_id in (SELECT score_id FROM `list` WHERE level_id = '5' GROUP by `score_id`)
            return $result;
        }
		
		// select_listby_score
        public function select_listby_score($level_id, $score_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM `list` where level_id = '$level_id' and score_id = '$score_id' ");
            //SELECT score_id FROM `list` where level_id = 5 GROUP by score_id
            return $result;
        }
		
		public function sel_countevidence($level_id, $userid, $score_id) {
            $result = mysqli_query($this->dbcon, "select sum(count) as count_evidence from ( SELECT count(*) as count FROM transaction where list_id in (select list_id from list where level_id = '$level_id' and score_id = '$score_id') and user_id = '$userid' UNION all SELECT count(*) as count FROM user_add where level_id = '$level_id' and score_id = '$score_id' and user_id = '$userid') as temp");
            return $result;
        }

		public function sel_count_transaction($level_id, $userid) {
            $result = mysqli_query($this->dbcon, "SELECT count(DISTINCT(score_id)) as count_transaction FROM `list` WHERE level_id = '$level_id' and score_id in (select score_id from list where list_id in (select list_id from transaction where user_id = '$userid') union select score_id from user_add where level_id = '$level_id' and user_id = '$userid')");
			//$result = mysqli_query($this->dbcon, "SELECT count(score_id) as count_transaction FROM `list` WHERE level_id = '$level_id' and score_id in (select score_id from list where list_id in (select list_id from transaction where user_id = '$userid') GROUP by score_id)");
            return $result;
        }

        public function fetch_level_menu() {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT level_label FROM level ORDER BY level_label ASC ");
            return $result;
        }
		
		public function fetch_level_menuuser($userid) {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT level_label FROM level WHERE level_id in (SELECT level_id FROM `format_todo_list` where format_id = (SELECT format_id FROM `user` where user_id = '$userid')) ORDER BY level_label ASC");
            return $result;
        }

        public function fetch_level_menuuser2() {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT level_label FROM level WHERE level_id  ORDER BY level_label ASC");
            return $result;
        }

        public function insertlevel($level_label ,$year_set ,$set_lebel ,$sub_lebel) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO level(level_label ,year_set ,set_lebel ,sub_lebel ) VALUES('$level_label' ,'$year_set' ,'$set_lebel' ,'$sub_lebel')");
            //echo "INSERT INTO user(username,password, email,user_type, firstname, surname , active ) VALUES('$username' ,'$password' ,'$email' ,'$user_type', '$firstname', '$surname', $active)" ;
            return $reg;
        }
        // เพิ่ม level แบบ set_lebel = Guidelines ต้องมี TYPE ด้วยในการ insert 
        public function insertlevel2($level_label ,$year_set ,$set_lebel ,$sub_lebel , $level_type) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO level(level_label ,year_set ,set_lebel ,sub_lebel,type ) VALUES('$level_label' ,'$year_set' ,'$set_lebel' ,'$sub_lebel','$level_type')");
            //echo "INSERT INTO user(username,password, email,user_type, firstname, surname , active ) VALUES('$username' ,'$password' ,'$email' ,'$user_type', '$firstname', '$surname', $active)" ;
            return $reg;
        }

        public function insertscore($level_id ,$point ,$score_des ) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO score(level_id ,point ,score_des  ) VALUES('$level_id' ,'$point' ,'$score_des' )");
            return $reg;
        }
		
		public function selectuser($usertype) {
            $selectuser = mysqli_query($this->dbcon, "SELECT * FROM `user` where user_type = '$usertype'");
            return $selectuser;
        }
		
		public function deleteuser($userid) {
            $deleteuser = mysqli_query($this->dbcon, "delete  FROM `user` where user_id = $userid");
            return $deleteuser;
        }
		
		public function selectuseredit($userid) {
            $selectuser = mysqli_query($this->dbcon, "SELECT * , F.description as F_des FROM `user` , format F where user_id = $userid AND user.format_id = F.format_id "   );
            return $selectuser;
        }
		
		public function updateuser($username ,$password,$email ,$user_type, $firstname, $surname, $phone_no, $department, $active, $userid, $format_id) {
            $updateuserdata = mysqli_query($this->dbcon, "UPDATE `user` SET `username`='$username',`password`='$password',`user_type`='$user_type',`email`='$email',`firstname`='$firstname',`surname`='$surname',`phone_no`='$phone_no',`department`='',`active`=$active, `format_id`=$format_id  WHERE user_id = $userid");
			//echo  "UPDATE `user` SET `username`='$username',`password`='$password',`user_type`='$user_type',`email`='$email',`firstname`='$firstname',`surname`='$surname',`phone_no`='$phone_no',`department`="",`active`=$active WHERE user_id = $userid";
		    return $updateuserdata;
        }
		
		public function iuploadfile($username, $subject, $description, $ori_filename, $filename, $savedate) {
            $recordfilename = mysqli_query($this->dbcon, "INSERT INTO `user_filedb`(`user`, `subject`, `description`, `ori_filename`, `save_filename`, `save_date`) VALUES ('$username', '$subject', '$description', '$ori_filename','$filename','$savedate')");
			//INSERT INTO `user_filedb`(`id`, `user`, `subject`, `description`, `ori_filename`, `save_filename`, `save_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
			return $recordfilename;
        }

        public function user_uploadfile($level_id, $score_id, $user_id, $list_label, $remark, $ori_filename, $filename, $savedate) {
            $recordfilename = mysqli_query($this->dbcon, "INSERT INTO `user_add`( `level_id`, `score_id`, `user_id`, `list_label`, `remark`, `status`, `ori_filename`, `save_filename`, `save_date`)  VALUES ('$level_id', '$score_id', '$user_id', '$list_label', '$remark','save', '$ori_filename','$filename','$savedate')");
			//INSERT INTO `user_filedb`(`id`, `user`, `subject`, `description`, `ori_filename`, `save_filename`, `save_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7]) `level_id`, `score_id`, `user_id`, `list_label`, `remark`, `status`, `ori_filename`, `save_filename`, `save_date`
			return $recordfilename;
        }

        public function fetch_useradd($level_id,$user_id,$score_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM user_add WHERE level_id = '$level_id' and user_id = '$user_id' and score_id = '$score_id' ");
            return $result;
        }

		
		public function selectfiledb($userid, $yearselect) {
            $selectuserfile = mysqli_query($this->dbcon, "SELECT * FROM `user_filedb` where user = $userid and YEAR(save_date) = '$yearselect' " );
			//SELECT * FROM `user_filedb` where YEAR(save_date) = '2021'
            return $selectuserfile;
        }
		
		public function deleteuserfile($userid) {
            $deleteuserfiledb = mysqli_query($this->dbcon, "delete  FROM `user_filedb` where id = $userid");
            return $deleteuserfiledb;
        }
		
		public function formatdescrip($formatid) {
            $selectfdescrip = mysqli_query($this->dbcon, "SELECT `description` FROM `format` WHERE format_id = $formatid");
            return $selectfdescrip;
        }
		
		public function insert_transaction($user_id, $list_id, $description, $ori_filename, $filename, $savedate) {
            $recordfilename = mysqli_query($this->dbcon, "INSERT INTO `transaction`(`user_id`, `list_id`, `remark`, `ori_filename`, `save_filename`, `status`, `save_date`) VALUES ('$user_id', '$list_id', '$description', '$ori_filename','$filename','save','$savedate')");
			return $recordfilename;
        }
		
		public function selecttransaction($user_id, $list_id) {
            $transactionfile = mysqli_query($this->dbcon, "SELECT * FROM `transaction` WHERE user_id = '$user_id' AND list_id = '$list_id'");
			//SELECT * FROM `transaction` WHERE user_id = 3 and list_id = 3
            return $transactionfile;
			
        }
		public function del_transaction($tran_id) {
            $deletetransaction = mysqli_query($this->dbcon, "delete  FROM `transaction` where t_id = $tran_id");
            return $deletetransaction;
        }
		
		public function del_useradd($tran_id) {
            $deletetransaction = mysqli_query($this->dbcon, "delete  FROM `user_add` where add_id = $tran_id");
            return $deletetransaction;
        }
		
		public function update_transaction($user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `transaction` SET `status`='consider' WHERE `user_id` = '$user_id' and `status` = 'save'");
            return $up_tran_status;
        }
		
		public function update_approve_list_score($level_id,$user_id,$remark) {
            $up_approve_list_score = mysqli_query($this->dbcon, "UPDATE `aprove_list_score` set `status` = 'recheck' ,`remark` = '',`old_remark` = '$remark'  where level_id = '$level_id' and user_id = '$user_id'");
            return $up_approve_list_score;
        }

		
		public function update_transactionID($level_id,$user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `transaction` SET `status`='consider' WHERE `list_id` in (select list_id FROM list where level_id = '$level_id') and user_id = '$user_id' and `status` = 'save'");
            return $up_tran_status;
        }
		
		public function update_useraddID($level_id,$user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `user_add` SET `status`='consider' WHERE `level_id` = '$level_id' and user_id = '$user_id' and `status` = 'save' ");
            return $up_tran_status;
        }
		
		
		public function select_reason($t_id) {
            $result = mysqli_query($this->dbcon, "SELECT remark FROM `aprove` where t_id = '$t_id'");
            return $result;
        }
		
		public function select_ureason($add_id) {
            $result = mysqli_query($this->dbcon, "SELECT remark FROM `aprove_user_add` where add_id = '$add_id'");
            return $result;
        }
		
		public function update_useradd($user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `user_add` SET `status`='consider' WHERE `user_id` = '$user_id' and `status` = 'save'" );
            return $up_tran_status;
        }
		
		public function select_formatdes($user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "SELECT description FROM `format` where format_id = (SELECT format_id FROM `user` where user_id = '$user_id')");
            return $up_tran_status;
        }

        public function fetch_transaction_By_USER($search_text) {
            $fetch = mysqli_query($this->dbcon, "SELECT distinct user.user_id ,firstname,surname FROM `user` , transaction WHERE TRIM(transaction.user_id) = trim(user.user_id) AND $search_text 
            UNION
            select DISTINCT user_add.user_id , firstname,surname FROM user, user_add  WHERE TRIM(user_add.user_id) = trim(user.user_id) AND $search_text" 
            
        );
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }


        public function fetch_AUDIT_By_USER($user, $status ) {
            // $user : ALL , user_id     >> all คือทั้งหมด , user_id
            if( $user == 'ALL'){
                $user_txt = " TRUE ";
            }else{
                $user_txt = " U1.user_id = '".$user."' " ;
            }

            if( $status == 'ALL'){
                $search_txt = " TRUE ";
            }elseif( $status == 'consider'){
                $search_txt = " T1.status != 0 ";
            }elseif( $status == 'pass'){
                $search_txt = " T1.status = 1 ";
            }elseif( $status == 'not pass'){
                $search_txt = " T1.status != 2 AND T1.status != 0";

            }else{
                $search_txt = " TRUE ";
            }

                $sql="SELECT U1.user_id as USER , U1.firstname as firstname, GROUP_CONCAT(distinct LV.level_label ) as level_label ,
                GROUP_CONCAT(distinct T1.firstname ) AS AUDIT , GROUP_CONCAT(distinct T6.firstname ) AS AUDIT_ALL
                FROM level LV, user U1
                LEFT JOIN 
                (   SELECT DISTINCT  T3.user_id as user_id ,
                    CASE  
                    WHEN T3.user_id = aprove_list_score.user_id AND T3.status in ('pass') AND A3.firstname is NULL AND aprove_list_score.status = 'pass' THEN 2 
                    WHEN T3.user_id = aprove_list_score.user_id AND T3.status in ('pass') AND A3.firstname is NOT NULL AND aprove_list_score.status = 'pass' THEN 2 
                    WHEN T3.user_id = aprove_list_score.user_id AND T3.status in ('consider','pass','reject') AND aprove_list_score.status != 'pass' AND aprove_list_score.level_id = L.level_id THEN 1 
                    WHEN T3.status in ('consider','pass','reject') AND aprove_list_score.user_id is NULL AND aprove_list_score.status is NULL THEN 1
                    WHEN T3.status in ('consider','pass','reject') AND T3.user_id not in ( SELECT A4.user_id from  aprove_list_score A4  WHERE A4.user_id = T3.user_id AND A4.level_id = L.level_id AND  A4.status = 'pass' ) THEN 1
                    WHEN T3.user_id != aprove_list_score.user_id THEN 0
                    ELSE 0 END AS status , A3.firstname as firstname , L.level_id as LEVEL
                    FROM list L , transaction  T3 
                        LEFT JOIN 
                        ( 	select DISTINCT aprove.t_id,user.firstname 
                            FROM aprove,user 
                            where aprove.audit_id=user.user_id ) A3 ON T3.t_id=A3.t_id
                    LEFT JOIN aprove_list_score on T3.user_id = aprove_list_score.user_id 
                    WHERE T3.list_id = L.list_id
                    
					UNION 
                    SELECT DISTINCT A4.user_id as user_id ,
                    CASE  
                        WHEN  A4.status='pass' THEN 2
                        ELSE 0 END AS status , U4.firstname as firstname , A4.level_id as LEVEL
                    FROM aprove_list_score A4 ,user U4 
					WHERE
                    A4.audit_id = U4.user_id

                    UNION
                    SELECT DISTINCT UADD3.user_id as user_id ,
                    CASE  
                            WHEN  UADD3.user_id != aprove_list_score.user_id THEN 0
                            WHEN  UADD3.user_id = aprove_list_score.user_id  AND UADD3.status in ('pass') AND UA3.firstname is null AND aprove_list_score.status = 'pass' THEN 2
                            WHEN  UADD3.user_id = aprove_list_score.user_id  AND UADD3.status in ('pass') AND UA3.firstname is not null AND aprove_list_score.status = 'pass' THEN 2
                            WHEN  UADD3.user_id = aprove_list_score.user_id  AND UADD3.status in  ('consider','pass','reject') AND  aprove_list_score.status != 'pass' THEN 1
                            WHEN  UADD3.status in  ('consider','pass','reject') AND aprove_list_score.user_id is NULL AND   aprove_list_score.status is NULL THEN 1

                        ELSE 0 END AS status ,  UA3.firstname as firstname , UADD3.level_id as LEVEL
					FROM user_add  UADD3 
					LEFT JOIN 
					( 	select DISTINCT aprove_user_add.add_id,user.firstname 
  						FROM aprove_user_add,user 
  						where aprove_user_add.audit_id=user.user_id 
					) UA3 ON UADD3.add_id=UA3.add_id 
                    LEFT JOIN aprove_list_score on UADD3.level_id = aprove_list_score.level_id
					, list
					
                 
                ) T1 ON U1.user_id=T1.user_id
                LEFT JOIN 
                (   
                    SELECT DISTINCT  T6.user_id as user_id , U6.firstname as firstname 
                    FROM transaction  T6 , aprove A6 , user U6
                    WHERE T6.t_id=A6.t_id AND A6.audit_id=U6.user_id
                    
                    UNION
                    SELECT DISTINCT UD6.user_id as user_id ,  user6.firstname as firstname 
					FROM user_add  UD6 , aprove_user_add AP6 , user user6
					WHERE UD6.add_id=AP6.add_id AND AP6.audit_id=user6.user_id 
                    
                    UNION
                    SELECT DISTINCT AL6.user_id as user_id , ALU6.firstname as firstname 
                    FROM aprove_list_score AL6 , user ALU6 
                    WHERE AL6.audit_id=ALU6.user_id 
                ) T6 on U1.user_id=T6.user_id
 

                WHERE U1.user_type = 'USER' AND T1.LEVEL=LV.level_id
                 AND $search_txt
                 AND $user_txt
                GROUP BY USER";
                

                //  LEFT JOIN aprove_list_score ON aprove_list_score.level_id = list.level_id 
                //  	AND aprove_list_score.score_id = list.score_id
				// 	 WHERE UADD3.level_id = list.level_id 
                //  	AND UADD3.score_id = list.score_id
            echo $sql;
            $fetch = mysqli_query($this->dbcon,$sql);
            return $fetch;


        }




        public function fetch_transaction_list_level($user_id,$set_lebel) {

            if($set_lebel==""){
                $set_lebel_buff = " " ;
            }else{
                $set_lebel_buff = " AND set_lebel = \"". $set_lebel ."\" " ;
            }
            $fetch = mysqli_query($this->dbcon, " SELECT  DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel  
            ,  score.score_des as score_des , score.point as point
            FROM level, transaction ,list
            lEFT JOIN score on list.score_id = score.score_id
            WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) 
            AND transaction.user_id = $user_id  $set_lebel_buff and LOWER(TRIM(transaction.status))=\"consider\" 
            UNION
            select DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel
            , score.score_des as score_des , score.point as point
            FROM level, user_add
            lEFT JOIN score on user_add.score_id = score.score_id
            where 
            trim(level.level_id) = trim(user_add.level_id) AND user_add.user_id =  $user_id  $set_lebel_buff     and LOWER(TRIM(user_add.status))=\"consider\"
            ORDER by level_label , set_lebel,level_id ");

            echo " SELECT  DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel  
            ,  score.score_des as score_des , score.point as point
            FROM level, transaction ,list
            lEFT JOIN score on list.score_id = score.score_id
            WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) 
            AND transaction.user_id = $user_id  $set_lebel_buff and LOWER(TRIM(transaction.status))=\"consider\" 
            UNION
            select DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel
            , score.score_des as score_des , score.point as point
            FROM level, user_add
            lEFT JOIN score on user_add.score_id = score.score_id
            where 
            trim(level.level_id) = trim(user_add.level_id) AND user_add.user_id =  $user_id  $set_lebel_buff     and LOWER(TRIM(user_add.status))=\"consider\"
            ORDER by level_label , set_lebel,level_id ";
            //echo " SELECT  DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel  FROM list,level, transaction WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) AND transaction.user_id = $user_id  $set_lebel_buff and LOWER(TRIM(transaction.status))=\"consider\" ORDER by level.level_label , level.set_lebel ";
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        public function fetch_transaction_list_level2($user_id , $level_id) {
           
            $sql_txt = " SELECT  DISTINCT list.score_id as score_id , list.list_id as list_id , list.list_label as list_label  , list.list_label as list_label 
                , transaction.remark as remark,transaction.save_filename as save_filename 
                , transaction.ori_filename as ori_filename , transaction.t_id as t_id  , transaction.status as status
                , transaction.save_date as date 
                , aprove.remark as app_remark , aprove.aprove_date as app_date
            FROM list,level, transaction 
            LEFT JOIN aprove ON transaction.t_id = aprove.t_id
            WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) 
                AND transaction.user_id = $user_id  AND list.level_id = $level_id  
                and LOWER(TRIM(transaction.status)) in (\"consider\",\"pass\",\"reject\")   ORDER by list.list_label  ";
            
            $fetch = mysqli_query($this->dbcon, $sql_txt );
            // echo $sql_txt;
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        public function fetch_user_add_list_level2($user_id , $level_id) {
            $sql_txt = "SELECT  DISTINCT level.level_id as level_id , user_add.score_id as score_id 
            ,  user_add.list_label as list_label , user_add.remark as remark,user_add.save_filename as save_filename 
            , user_add.ori_filename as ori_filename , user_add.add_id as add_id 
            , score.point as point , score.score_des as score_des , user_add.status as status , user_add.save_date as date
            , aprove_user_add.remark AS app_remark , aprove_user_add.aprove_date as app_date
            FROM level , user_add
            LEFT JOIN score 
            ON user_add.score_id = score.score_id 
            LEFT JOIN aprove_user_add ON user_add.add_id = aprove_user_add.add_id
            WHERE 
            trim(user_add.level_id) = trim(level.level_id) AND user_add.user_id = $user_id  
            AND level.level_id = $level_id  
            and LOWER(TRIM(user_add.status)) in (\"consider\",\"pass\",\"reject\")  ORDER by list_label" ;
           
            // echo $sql_txt ;

            $fetch = mysqli_query($this->dbcon, $sql_txt );
            
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        public function fetch_approve_level($user_id,$set_lebel , $level_label ) {

            if($set_lebel==""){
                $set_lebel_buff = " " ;
            }else{
                $set_lebel_buff = " AND L.set_lebel = \"". $set_lebel ."\" " ;
            }
            // $fetch = mysqli_query($this->dbcon, " SELECT  DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel  
            // ,  score.score_des as score_des , score.point as point
            // ,  transaction.status as status
            // FROM level, transaction ,list
            // LEFT JOIN score on list.score_id = score.score_id
            // WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) 
            // AND transaction.user_id = $user_id  $set_lebel_buff 
            // and LOWER(TRIM(transaction.status)) in (\"consider\",\"pass\",\"reject\")
            // UNION
            // select DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel
            // , score.score_des as score_des , score.point as point
            // , user_add.status as status
            // FROM level, user_add
            // LEFT JOIN score on user_add.score_id = score.score_id
            // where 
            // trim(level.level_id) = trim(user_add.level_id) AND user_add.user_id =  $user_id  $set_lebel_buff     
            // and LOWER(TRIM(user_add.status)) in (\"consider\",\"pass\",\"reject\")
            // ORDER by level_label , set_lebel,level_id 
            // ");

            $sql_txt = " SELECT DISTINCT L.level_id as level_id , L.level_label as level_label , L.sub_lebel as sub_lebel ,L.type as type ,
            L.set_lebel as set_lebel , score.score_des as score_des , score.point as point , aprove_list_score.status as status 
            ,aprove_list_score.aprove_id AS app_id
            ,aprove_list_score.aprove_date AS aprove_date
            ,aprove_list_score.remark AS remark , aprove_list_score.old_remark AS old_remark
            FROM  transaction T ,list
            LEFT JOIN score on list.score_id = score.score_id , level L 
            LEFT JOIN aprove_list_score on L.level_id = aprove_list_score.level_id and aprove_list_score.user_id = $user_id
            WHERE TRIM(T.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(L.level_id) 
            AND T.user_id = $user_id  $set_lebel_buff  and LOWER(TRIM(T.status)) in (\"consider\",\"pass\",\"reject\")
            AND list.level_id in (select distinct level_id FROM level WHERE level_label = '$level_label')
            
            UNION

            select DISTINCT L.level_id as level_id , L.level_label as level_label , L.sub_lebel as sub_lebel ,L.type as type , L.set_lebel as set_lebel , score.score_des as score_des , score.point as point , aprove_list_score.status as status 
            ,aprove_list_score.aprove_id AS app_id
            ,aprove_list_score.aprove_date AS aprove_date
            ,aprove_list_score.remark AS remark , aprove_list_score.old_remark AS old_remark
            FROM user U , format_todo_list F , user_add 
            LEFT JOIN score on user_add.score_id = score.score_id , level L
            LEFT JOIN aprove_list_score on aprove_list_score.level_id = L.level_id and aprove_list_score.user_id = $user_id
            where trim(L.level_id) = trim(user_add.level_id) AND user_add.user_id = $user_id  $set_lebel_buff  and LOWER(TRIM(user_add.status)) in (\"consider\",\"pass\",\"reject\") 
            AND U.user_id = user_add.user_id and  U.user_id = $user_id  AND user_add.level_id in (select distinct level_id FROM level WHERE level_label = '$level_label')
            ORDER by level_label , set_lebel,level_id " ;

            $fetch = mysqli_query($this->dbcon, $sql_txt);

            //  echo $sql_txt ;

            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        public function fetch_notif_USER($user) {

            $sql_txt = "SELECT N.id as id , M.title as title, M.body as body , M.user_id as user_id ,  M.create_time as times
                        FROM notification N , message M    
                        WHERE M.message_id=N.message_id 
                         AND N.user_id = '$user' 
                         AND N.read_at is null ORDER by id ";
            $fetch = mysqli_query($this->dbcon, $sql_txt);
            //  echo $sql_txt ;


            return $fetch;
        }

        public function send_notif_USER( $User_id_sender , $user_id_reciever ,$txt_send) {
            // INSERT INTO `message` (`message_id`, `user_id`, `title`, `body`, `create_time`) VALUES (NULL, '6', 'ตรวจสอบแล้ว ไม่ผ่านการอนุมัติ', NULL, current_timestamp());

            $sql_txt = "INSERT INTO `message` (`message_id`, `user_id`, `title`, `body`, `create_time`) 
                        VALUES (NULL, $User_id_sender , '$txt_send' , NULL, current_timestamp());
                        INSERT INTO `notification` ( `user_id`, `message_id`) 
                        VALUES ( $user_id_reciever , ( SELECT LAST_INSERT_ID() ));
                         ";
            // echo $sql_txt ;
            $fetch = mysqli_multi_query($this->dbcon, $sql_txt);
            //  echo $sql_txt ;


            return $fetch;
        }



        public function reject_notif_USER($user) {

            $sql_txt = "SELECT 1 as T1  FROM `aprove_list_score` ALC WHERE ALC.status = 'reject' AND ALC.user_id = $user
                        UNION
                        SELECT 2 as T1  FROM transaction T WHERE T.status = 'reject' AND T.user_id = $user
                        UNION
                        SELECT 2 as T1  FROM user_add U WHERE U.status = 'reject' AND U.user_id = $user ";
            $fetch = mysqli_query($this->dbcon, $sql_txt);
            //  echo $sql_txt ;
            return $fetch;
            mysqli_free_result($fetch);
        }            


        public function fetch_format( ) {

            $sql_txt = "SELECT F.description as description ,F.format_id as format_id , GROUP_CONCAT(L.level_id) as level_id FROM format F,`format_todo_list` L WHERE F.format_id = L.format_id group by F.description ";
            $fetch = mysqli_query($this->dbcon, $sql_txt);
            return $fetch;
            
        }
        

        
    }

?>