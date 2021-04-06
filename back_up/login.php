<?php 
    session_start();

    include_once('function.php'); 
    
    $userdata = new DB_con();

    if (isset($_POST['login'])) {
        $uname = $_POST['username'];
        $password = $_POST['password'];

        $result = $userdata->signin($uname, $password);
        $num = mysqli_fetch_array($result);

        if ($num > 0) {
            $_SESSION['id'] = $num['user_id'];
            $_SESSION['fname'] = $num['firstname'];
            $_SESSION['user_type'] = $num['user_type'];
            //echo "<script>alert('Login Successful!');</script>";
            if( strtoupper($_SESSION['user_type']) == "ADMIN" ){
              echo "<script>window.location.href='eco_level.php'</script>";
            }elseif (strtoupper($_SESSION['user_type']) == "AUDITOR" ) {
              echo "<script>window.location.href='audit.php'</script>";
            }elseif (strtoupper($_SESSION['user_type']) == "USER" ) {
              echo "<script>window.location.href='eco_level.php'</script>";
            }else{
            echo "<script>window.location.href='login.php'</script>";
            }
        } else {
            echo "<script>alert('Something went wrong! Please try again.');</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
    }

?>

<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>log in</title>
<link rel = "stylesheet" type = "text/css" href = "css\login.css" >

</head>
<body>
<form class="login-form" method="post">
  <p class="login-text">
    <span class="fa-stack fa-lg">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-lock fa-stack-1x"></i>
    </span>
  </p>
  <input type="username" name="username" id="username" class="login-username" autofocus="true" required="true" placeholder="USERNAME" />
  <input type="password" name="password" id="password" class="login-password" required="true" placeholder="PASSWORD" />
  <input type="submit" name="login" type="submit"  value="Login" class="login-submit" />
</form>
<a href="#" class="login-forgot-pass">forgot password?</a>
<div class="underlay-photo"></div>
<div class="underlay-black"></div> 
</body>
</html>