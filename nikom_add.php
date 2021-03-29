<?php 
    include_once('function.php'); 
    
    $userdata = new DB_con();

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        


        $sql = $userdata->registration($username ,$password, $email,'USER', $firstname, $surname,true);
                          //registration($username ,$password ,$email ,$user_type, $firstname, $surname, $active)
        if ($sql) {
            echo "<script>alert('เพิ่มข้อมูลเรียบร้อย !');</script>";
            echo "<script>window.location.href='nikom_all.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again.');</script>";
            echo "<script>window.location.href='signin.php'</script>";
        }
    }
?>

<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>เพิ่มนิคมใหม่</title>
<link rel = "stylesheet" type = "text/css" href = "css\smart1.css" >
<script src="css\eco.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

</head>
<body>
<div class="site-wrap">

  <nav class="site-nav">

    <div class="name">
    ECO Audit Database Web Application

      <svg width="24" height="24" viewBox="0 0 24 24">
        <path d="M11.5,22C11.64,22 11.77,22 11.9,21.96C12.55,21.82 13.09,21.38 13.34,20.78C13.44,20.54 13.5,20.27 13.5,20H9.5A2,2 0 0,0 11.5,22M18,10.5C18,7.43 15.86,4.86 13,4.18V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V4.18C7.13,4.86 5,7.43 5,10.5V16L3,18V19H20V18L18,16M19.97,10H21.97C21.82,6.79 20.24,3.97 17.85,2.15L16.42,3.58C18.46,5 19.82,7.35 19.97,10M6.58,3.58L5.15,2.15C2.76,3.97 1.18,6.79 1,10H3C3.18,7.35 4.54,5 6.58,3.58Z"></path>
      </svg>
    </div>

    <ul>
      <li class="active"><a href="#">นิคม</a>
      <li ><a href="score.php">เกณฑ์การพิจารณา</a>
      
        <ul>
          <li><a href="score/a1.php">ECO-CHAMPION</a></li>
          <li><a href="score/a2.php">ECO-EXCELLENCE</a></li>
          <li><a href="score/a3.php">ECO-WORLD CLASS</a></li>
        </ul>
      </li>
      <li><a href="eva.php">ผู้ตรวจประเมิน</a></li>
      <li><a href="report.php">รายงาน</a></li>
      <li><a href="database.php">DATABASE</a></li>
      
    </ul>

    <div class="note">
      <h3>รายงาน</h3>
      <p>การประเมินตามเกณฑ์</p>
    </div>

  </nav>

  <main>

    <header>
      <div class="breadcrumbs">
        <a href="index.php">Home</a>
      </div>
      
      <h1>นิคม <a href="#0" ><span>+</span></a></h1>
      
      
      <nav class="nav-tabs" id="nav-tabs">
        <a href="nikom_all.php" >
          นิคมทั้งหมด
          
        </a>
        <a href="#0">
          นิคมที่ส่งเกณฑ์เข้าตรวจ
          
        </a>
        <a href="#0" class="active">
          เพิ่มนิคม
          
        </a>
        
      </nav>
    </header>

    <div class="content-columns">
      <form method="post">
        <div class="form-container">
          <div class="field-container">
              <label for="nikom_name">ชื่อนิคม</label>
              <input id="nikom_name" maxlength="20" type="text">
          </div>
          <div class="field-container">
              <label for="user">USERNAME</label>
              <input id="username" type="text" class="form-control" name="username" onblur="checkusername(this.value)">
              <span id="usernameavailable"></span>
          </div>

          <div class="field-container">
              <label for="pwd">PASSWORD</label>
              <input id="password" type="text"  inputmode="text" name="password" >
              <span ></span>
          </div>
          <div class="field-container">
              <label for="firstname">ชื่อ </label>
              <input id="firstname" type="text" name="firstname" >
              
          </div>
          <div class="field-container">
              <label for="surname">นามสกุล</label>
              <input id="surname" type="text" name="surname" >
          </div>

          <div class="field-container">
              <label for="email">Email</label>
              <input id="email" type="text" inputmode="email" name="email">
          </div>

          <div class="field-container">
              <label for="tel">เบอร์โทร</label>
              <input id="tel" type="text" name="tel">
          </div>

          <div class="field-container">
          <label for="add"> </label>
              
              <button type="submit" name="submit" id="submit" class="btn btn-success">เพิ่มนิคม</button>
          </div>
        </div>
      </form>

    </div>

  </main>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function checkusername(val) {
            $.ajax({
                type: 'POST',
                url: 'checkuser_available.php',
                data: 'username='+val,
                success: function(data) {
                    $('#usernameavailable').html(data);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>
</html>
    
    
    
    
    