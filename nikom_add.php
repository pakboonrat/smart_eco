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

<?php include('style-header.php'); ?>

</head>
<body>
<div class="site-wrap">

  
  <?php include('site-nav.php'); ?>

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
    
    
    
    
    