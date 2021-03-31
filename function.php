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

        public function usernameavailable($uname) {
            $checkuser = mysqli_query($this->dbcon, "SELECT username FROM user WHERE username = '$uname'");
            return $checkuser;
        }

        public function registration($username ,$password ,$email ,$user_type, $firstname, $surname, $active) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO user(username,password, email,user_type, firstname, surname , active ) VALUES('$username' ,'$password' ,'$email' ,'$user_type', '$firstname', '$surname', $active)");
            //echo "INSERT INTO user(username,password, email,user_type, firstname, surname , active ) VALUES('$username' ,'$password' ,'$email' ,'$user_type', '$firstname', '$surname', $active)" ;
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

        public function fetch_level_header($level_label) {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT set_lebel FROM level WHERE  level_label = '$level_label' ");
            return $result;
        }

        public function fetchdata($level_label,$set_lebel) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM level WHERE level_label = '$level_label' and set_lebel = '$set_lebel' ");
            
            return $result;
        }

        public function fetch_list($level_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM list WHERE level_id = '$level_id'  ");
            return $result;
        }

        // fetch_score
        public function fetch_score($level_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM score WHERE level_id = '$level_id'  ");
            
            return $result;
        }

        public function fetch_level_menu() {
            $result = mysqli_query($this->dbcon, "SELECT DISTINCT level_label FROM level ORDER BY level_label ASC ");
            return $result;
        }

        public function insertlevel($level_label ,$year_set ,$set_lebel ,$sub_lebel) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO level(level_label ,year_set ,set_lebel ,sub_lebel ) VALUES('$level_label' ,'$year_set' ,'$set_lebel' ,'$sub_lebel')");
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
    }

?>