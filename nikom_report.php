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
        <a href="index.php">Home</a>
      </div>
      <h1>รายงานสรุปผลของนิคม : </h1>
      <nav class="nav-tabs" id="nav-tabs">
      </nav>
    </header>
  <div class="content-columns">
			<div class="col" >
				<div class="item"> <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>  
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-hover">
  <tbody>
    <tr>
		
		<td width="31%" align="left">ชื่อนิคม</td>
		<td width="33%" align="center">สถานะการส่งพิจารณา</td>
		<td width="36%" align="center">รายงานสรุปผล</td>
    </tr><?php	
						include_once('function.php');
						$fetchdata1 = new DB_con();
						$user_type = 'USER';
						$sql1 = $fetchdata1->selectuser($user_type);

							$irow_count = 1;
							while($row_user = mysqli_fetch_array($sql1)) {

				?>
    <tr>
     			
				<td><?php echo $row_user['firstname']; ?></td>
				<td align="center"><a href="status_report1.php?user_id=<?php echo $row_user['user_id']; ?>">คลิกดูรายละเอียด</a></td>
				<td align="center"><a href="summary_report1.php?user_id=<?php echo $row_user['user_id']; ?>">คลิกดูรายละเอียด</a></td>
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