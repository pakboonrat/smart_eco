<?php 

    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "USER")  {
?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>A Pen by Pak Boonrat</title>
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
          <span>80</span>
        </a>
        <a href="nikom_score.php">
          นิคมที่ส่งเกณฑ์เข้าตรวจ
          <span>32</span>
        </a>
        <a href="nikom_add.php" class="active">
          เพิ่มนิคม
          <span>32</span>
        </a>
        
      </nav>
    </header>

    <div class="content-columns">

      <div class="col">
        <div class="item">นิคมฯ อัญธานี</div>
        <div class="item">นิคมฯ ดับบลิวเอชเอ ชลบุรี 2  </div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>
      <div class="col">
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>
      <div class="col">
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>
      <div class="col">
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>

    </div>

  </main>

</div>
</body>
</html>

<?php 

}
?>