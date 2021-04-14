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
<div class="col-10" >
<div class="item">


  <table class="table table-striped table-hover">
    <thead>
        <tr>
          <th scope="col-lg-2 col-md-4 ">ชื่อนิคม</th>
        <!-- <th width="32%" align="center">ชื่อนิคม</th> -->
        <th scope="col-lg-1 col-md-2"></th>
        <th scope="col-lg-4 col-md-5">รอตรวจประเมิน</th>
        </tr>
    </thead>
    <?php 
          $fetchdata = new DB_con();
          $sql = $fetchdata->fetch_transaction_By_USER(" status = 'consider' ");
          if( mysqli_num_rows($sql) != 0 ){
           
          while($row = mysqli_fetch_array($sql)) { 
      ?>
      <tbody>
      <tr>
        <th scope="row"><?php echo $row['firstname'];?></th>
        <td><?php echo $row['surname'];?></td>
        <td><a href="approve.php?userid=<?php echo $row['user_id'];?>">รายละเอียด</a></td>
      </tr>
      </tbody>
      <?php }
    } else{  ?>
    </tbody>
    <?php   } ?>
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