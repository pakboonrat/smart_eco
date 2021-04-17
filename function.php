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

        public function fetchdata($level_label,$set_lebel,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM level WHERE level_label = '$level_label' and set_lebel = '$set_lebel' and level_id in (SELECT level_id FROM `format_todo_list` where format_id = (SELECT format_id FROM `user` where user_id = '$userid')) ");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function basic_report($userid) {
            $result = mysqli_query($this->dbcon, "SELECT level_id,sub_lebel FROM `level` where set_lebel = 'basic' and level_id in (SELECT level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid')");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function control_report($userid) {
            $result = mysqli_query($this->dbcon, "SELECT level_id,sub_lebel FROM `level` where set_lebel = 'Guidelines' and type = 'control' and level_id in (SELECT level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid')");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function measure_report($userid) {
            $result = mysqli_query($this->dbcon, "SELECT level_id,sub_lebel FROM `level` where set_lebel = 'Guidelines' and type = 'measure' and level_id in (SELECT level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid')");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }

		public function basic_report_tran($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "SELECT status,list_label,level_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid' and level_id = '$level_id'");
            //SELECT * FROM level WHERE level_label ='eco_champion' and set_lebel = 'basic' 
            return $result;
        }
		
		public function select_scoredes($level_id,$userid) {
            $result = mysqli_query($this->dbcon, "select score_des,point from score where score_id in (SELECT score_id FROM `transaction` INNER JOIN list ON transaction.list_id = list.list_id WHERE user_id = '$userid' and level_id = '$level_id') ");
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
		
		// select_listby_score
        public function select_listby_score($level_id, $score_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM `list` where level_id = '$level_id' and score_id = '$score_id' ");
            //SELECT score_id FROM `list` where level_id = 5 GROUP by score_id
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
            $selectuser = mysqli_query($this->dbcon, "SELECT * FROM `user` where user_id = $userid");
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
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `transaction` SET `status`='consider' WHERE `user_id` = $user_id");
            return $up_tran_status;
        }
		
		public function update_transactionID($level_id,$user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `transaction` SET `status`='consider' WHERE `list_id` in (select list_id FROM list where level_id = '$level_id') and user_id = '$user_id'");
            return $up_tran_status;
        }
		
		public function update_useraddID($level_id,$user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `user_add` SET `status`='consider' WHERE `level_id` = '$level_id' and user_id = '$user_id'");
			//SELECT * FROM `user_add` where level_id = '2' and user_id = '3'
            return $up_tran_status;
        }
		
		public function update_useradd($user_id) {
            $up_tran_status = mysqli_query($this->dbcon, "UPDATE `user_add` SET `status`='consider' WHERE `user_id` = $user_id");
            return $up_tran_status;
        }

        public function fetch_transaction_By_USER($search_text) {
            $fetch = mysqli_query($this->dbcon, "SELECT distinct user.user_id ,firstname,surname FROM `user` , transaction WHERE TRIM(transaction.user_id) = trim(user.user_id) AND $search_text ");
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        public function fetch_transaction_list_level($user_id,$set_lebel) {

            if($set_lebel==""){
                $set_lebel_buff = " " ;
            }else{
                $set_lebel_buff = " AND set_lebel = \"". $set_lebel ."\" " ;
            }
            $fetch = mysqli_query($this->dbcon, " SELECT  DISTINCT level.level_id as level_id , level.level_label as level_label , level.sub_lebel as sub_lebel ,level.type as type , level.set_lebel as set_lebel  FROM list,level, transaction WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) AND transaction.user_id = $user_id  $set_lebel_buff and LOWER(TRIM(transaction.status))=\"consider\" ORDER by level.level_label , level.set_lebel ");
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        public function fetch_transaction_list_level2($user_id , $level_id) {
           
            $fetch = mysqli_query($this->dbcon, " SELECT  DISTINCT list.list_id as list_id , list.list_label as list_label  , list.list_label as list_label ,transaction.remark as remark,transaction.save_filename as save_filename , transaction.ori_filename as ori_filename , transaction.t_id as t_id  FROM list,level, transaction WHERE TRIM(transaction.list_id) = trim(list.list_id) AND trim(list.level_id) = trim(level.level_id) AND transaction.user_id = $user_id  AND list.level_id = $level_id  and LOWER(TRIM(transaction.status))=\"consider\"  ORDER by list.list_label  ");
            return $fetch;
			//UPDATE `transaction` SET `status`="consider" WHERE `user_id` = 3
        }

        
    }

?>