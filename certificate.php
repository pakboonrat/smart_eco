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
<title>Edit User</title>
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
      <?php if($_SESSION['user_type']=="AUDITOR"){  ?> 
        <a href="audit.php">Home</a>
      <?php }else{ ?>    
        <a href="index.php">Home</a>
      <?php } ?>
      </div>
      <h1>รายงานการตรวจประเมิน : </h1>
      <nav class="nav-tabs" id="nav-tabs">
      </nav>
    </header>
  <div class="content-columns">
			<div class="col" >
				<div class="item"> <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>  
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-hover">
  <tbody>
    <tr>
		
		<td width="15%" align="left">ชื่อนิคม</td>
		<td width="15%" align="left">ผู้ตรวจประเมิน</td>
		<td width="12%" align="center">รายงานการตรวจประเมิน</td>
    </tr><?php	
						include_once('function.php');
						$fetchdata1 = new DB_con();
						$user_type = 'USER';
						$sql1 = $fetchdata1->fetch_AUDIT_By_USER("ALL","ALL");
            //$sql1 = $fetchdata1->selectuser($user_type);


							$irow_count = 1;
							while($row_user = mysqli_fetch_array($sql1)) {

				?>
    <tr>
     			
				<td><?php echo $row_user['firstname']; ?></td>
				<td><?php echo $row_user['AUDIT']; ?></td>
				<td align="center"><a href="wordreport.php" target="_blank">ดาวน์โหลดรายงาน</a></td>
    </tr> <?php  }; ?>
  </tbody>
</table>
<?php }; ?>

				</div>
	  </div>
 </div>

</body>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
?>