<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "AUDITOR") {
    include_once('function.php');

?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>Auditor</title>
<script>
function validateForm() {
  var x = document.forms["myForm"]["username"].value;
  var a = document.forms["myForm"]["password"].value;
  var b = document.forms["myForm"]["firstname"].value;

  if ((x == "") || (a == "") || (b == "")) {
    alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    return false;
  }
}
</script>

<?php include('style-header.php'); ?>
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
></script>
</head>
<body>
<div class="site-wrap">
  <?php include('site-nav.php'); ?>
  
  <main>
    <header>
      <div class="breadcrumbs">
        <a href="audit.php">Home</a>
      </div>
      <h1>ตรวจพิจารณา : </h1>
      <nav class="nav-tabs" id="nav-tabs">
       <a href="audit.php" >
          ตรวจพิจารณา </a>
      </nav>
    </header>

  <div class="content-columns">
    <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>     
<div class="col" >
<div class="item"><table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
  <tr>
    <td width="32%" align="center">ชื่อนิคม</td>
    <td width="27%" align="center">&nbsp;</td>
    <td width="41%" align="center">รอตรวจประเมิน</td>
    </tr></table></div>
<div class="item">
<table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
  <tr bgcolor="#FFFFFF">
    <td align="left">นิคมฯ อัญธานี </td>
    
    <td align="center"><a href="approve.php">รายละเอียด</a></td>
    </tr>
      <tr>
    <td align="left" bgcolor="#CCCCCC">นิคมฯ ลาดกระบัง</td>
    
    <td align="center" bgcolor="#CCCCCC"><a href="approve.php">รายละเอียด</a></td>
    </tr>
      <tr bgcolor="#FFFFFF">
    <td align="left">นิคมฯ พิจิตร</td>
   
    <td align="center"><a href="approve.php">รายละเอียด</a></td>
    </tr>
          <tr>
    <td align="left" bgcolor="#CCCCCC">นิคมฯ แหลมฉบัง  </td>
   
    <td align="center" bgcolor="#CCCCCC"><a href="approve.php">รายละเอียด</a></td>
    </tr>
      <tr bgcolor="#FFFFFF">
    <td align="left">นิคมฯ บางพลี  </td>
   
    <td align="center"><a href="approve.php">รายละเอียด</a></td>
    </tr>
</table><br>
<br>
<br>
<br><br>
<br>
<br>
<br>
</div>
</div>
  </div>
      <?php }; ?>
</div>
 

</div>
</body>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
?>