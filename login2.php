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
<link rel = "stylesheet" type = "text/css" href = "css\login2.css" >

</head>
<body>

<div class="header">

<!--Content before waves-->
<div class="inner-header flex">
<!--Just the logo.. Don't mind this-->
    <div class="form-center">
        <div><img src="images/Eco.jpg" width="400px" ></div>
        <div style="margin:0 0 50px 0;">
            <h1>
                    <svg id="Capa_1" class="logo"  enable-background="new 0 0 512 512" height="42" viewBox="0 0 512 512" width="42" 
                xmlns="http://www.w3.org/2000/svg"><g><path stroke-width="1" d="m459.943 402.795c9.954-10.714 16.057-25.052 16.057-40.795 0-33.084-26.916-60-60-60s-60 26.916-60 60c0 15.743 6.103 30.081 16.057 40.795-14.691 7.698-27.135 19.123-36.057 33.019-8.922-13.895-21.366-25.321-36.057-33.019 9.954-10.714 16.057-25.052 16.057-40.795 0-33.084-26.916-60-60-60s-60 26.916-60 60c0 15.743 6.103 30.081 16.057 40.795-14.691 7.698-27.135 19.123-36.057 33.019-8.922-13.895-21.366-25.321-36.057-33.019 9.954-10.714 16.057-25.052 16.057-40.795 0-33.084-26.916-60-60-60s-60 26.916-60 60c0 15.743 6.103 30.081 16.057 40.795-30.32 15.887-51.057 47.667-51.057 84.205v10c0 8.284 6.716 15 15 15h480c8.284 0 15-6.716 15-15v-10c0-36.538-20.737-68.318-51.057-84.205zm-363.943-70.795c16.542 0 30 13.458 30 30s-13.458 30-30 30-30-13.458-30-30 13.458-30 30-30zm-64.81 150c2.562-33.514 30.651-60 64.81-60s62.248 26.486 64.81 60zm224.81-150c16.542 0 30 13.458 30 30s-13.458 30-30 30-30-13.458-30-30 13.458-30 30-30zm-64.81 150c2.562-33.514 30.651-60 64.81-60s62.248 26.486 64.81 60zm224.81-150c16.542 0 30 13.458 30 30s-13.458 30-30 30-30-13.458-30-30 13.458-30 30-30zm-64.81 150c2.562-33.514 30.651-60 64.81-60s62.248 26.486 64.81 60z"/><path d="m176 270h160c30.327 0 55-24.673 55-55v-160c0-30.327-24.673-55-55-55h-160c-30.327 0-55 24.673-55 55v160c0 30.327 24.673 55 55 55zm-25-215c0-13.785 11.215-25 25-25h160c13.785 0 25 11.215 25 25v160c0 13.785-11.215 25-25 25h-160c-13.785 0-25-11.215-25-25z"/><path d="m220.645 188.033c5.857 5.858 15.356 5.858 21.213 0l84.853-84.853c5.858-5.858 5.858-15.355 0-21.213-5.857-5.858-15.355-5.858-21.213 0l-74.246 74.246-24.749-24.748c-5.857-5.858-15.355-5.858-21.213 0s-5.858 15.355 0 21.213z"/></g></svg>
            Smart Eco    </h1>
        </div>
        <div>
            <form class="login-form" method="post">
                <input type="username" name="username" id="username" class="login-username" autofocus="true" required="true" placeholder="USERNAME">
                <input type="password" name="password" id="password" class="login-password" required="true" placeholder="PASSWORD">
                <input type="submit" name="login" value="Login" class="login-submit">
            </form>
        </div>
    </div>
</div>

<!--Waves Container-->
<div>
<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
<defs>
<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
</defs>
<g class="parallax">
<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
</g>
</svg>
</div>
<!--Waves end-->

</div>
<!--Header ends-->

<!--Content starts-->

<div class="content flex">

<p>Smart Eco | 2021  </p>
</div>
</body>
</html>