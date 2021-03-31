<?php 

    include_once('function.php');

    $updatedata = new DB_con();

    if (isset($_POST['update'])) {

        $userid = $_GET['id'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];

        $sql = $updatedata->update($fname, $lname, $email, $phonenumber, $address, $userid);
        if ($sql) {
            echo "<script>alert('Updated Successfully!');</script>";
            echo "<script>window.location.href='index.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!');</script>";
            echo "<script>window.location.href='update.php'</script>";
        }
    }


?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>Eco Champion</title>
<link rel = "stylesheet" type = "text/css" href = "css\smart1.css" >
<script src="css\eco.js"></script>
<style class="INLINE_PEN_STYLESHEET_ID">


  </style>

</head>
<body>
<div class="site-wrap">

  <?php include('site-nav.php'); ?>
  

  <main>

    <header>
      <div class="breadcrumbs">
        <a href="index.php">Home</a>
      </div>
      <?php 
            $level_id = $_GET['id'];
            $updatelevel = new DB_con();
            $sql = $updatelevel->fetchonerecord($level_id);
            while($row = mysqli_fetch_array($sql)) {
        ?>

      <h1>แผนการตรวจประเมิน : ECO CHAMPION <a href="#0" ><span>+</span></a></h1>
      
      
      <nav class="nav-tabs" id="nav-tabs">
        <a href="nikom_all.php" class="active">
            <?php echo $row['set_lebel']; ?>
          <span>9</span>
        </a>
        <a href="nikom_score.php">
        เกณฑ์คะแนน
          <span>5</span>
        </a>
        <a href="score_add.php" >
          เพิ่มเกณฑ์
          <span>+</span>
        </a>
        
      </nav>
      <?php } ?>
    </header>

    <div class="content-columns">
    <?php 

       
        $fetchdata = new DB_con();
        $sql = $fetchdata->fetchdata();
        while($row = mysqli_fetch_array($sql)) {

    ?>

      <div class="col">
        <!-- <div class="item"><h2><?php echo $row['set_lebel']; ?></h2></div> -->
        <div class="item"><?php echo $row['sub_lebel']; ?> <h5>< บังคับ > | < แก้ไข > | < ลบ ></h5></div>
        
      </div>
      
      <?php } ?>
     
    </div>

    </div>

  </main>

</div>
</body>
</html>