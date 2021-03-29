<?php 

    include_once('function.php');

    $usernamecheck = new DB_con();

    // Getting post value
    $uname = $_POST['username'];

    $sql = $usernamecheck->usernameavailable($uname);

    $num = mysqli_num_rows($sql);

    if ($num > 0) {
        echo "<span style='color: red;'>Username ได้ถูกใช้แล้ว</span>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    } else {
        echo "<span style='color: green;'>สามารถใช้ชื่อ user นี้ได้</span>";
        echo "<script>$('#submit').prop('disabled', false);</script>";
    }

?>