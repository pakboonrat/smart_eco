<?php 

    //$remote = $_SERVER["REMOTE_ADDR"]; 
    //$ip = getenv(REMOTE_ADDR); 
    //print_r("Your IP Address is $remote "); 
    //print_r($_SERVER["REMOTE_HOST"]); 
    echo $_SERVER['SERVER_NAME'];
    echo $_SERVER['SERVER_NAME'] == "smartecosis.com" ;
    if ($_SERVER['SERVER_NAME'] == "smartecosis.com") {
        echo "test2";
        define('DB_HOST', 'localhost'); // Your hostname
        define('DB_USER', 'smarteco_admin'); // Database Username
        define('DB_PASS', 'smartECO*2021'); // Database Password
        define('DB_NAME', 'smarteco_001'); // Database Name
    }elseif( $_SERVER['SERVER_NAME'] = "localhost" ){
        echo "test";
        define('DB_HOST', '127.0.0.1'); // Your hostname 127.0.0.1
        define('DB_USER', 'root'); // Database Username
        define('DB_PASS', ''); // Database Password
        define('DB_NAME', 'smarteco'); // Database Name
    }

    class DB_con {
        function __construct() {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
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
    }

?>