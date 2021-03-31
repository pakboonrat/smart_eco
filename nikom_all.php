<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "ADMIN") {
    include_once('function.php');

    if (isset($_POST['submit'])) {
      
        
        $level_label = $_POST['level_label'];
        $year_set = $_POST['year_set'];
        $set_lebel = $_POST['set_lebel'];
        $sub_lebel = $_POST['sub_lebel'];
        $updatedata = new DB_con();
        $sql = $updatedata->insertlevel($level_label, $year_set, $set_lebel, $sub_lebel);
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
<title>Edit User</title>


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
      <h1>แก้ไขปรับปรุงผู้ใช้ : User</h1>
      <nav class="nav-tabs" id="nav-tabs">
      
      </nav>
      
    </header>
  <div class="content-columns">
    <?php    if($_SESSION['user_type']=="ADMIN"){ ?>     
            <form method="post">
<table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
  <tr>
    <td width="10%" align="center">Username</td>
    <td width="10%" align="center">ชื่อ</td>
    <td width="25%" align="center">นามสกุล</td>
    <td width="15%" align="center">Email</td>
    <td width="15%" align="center">เบอร์โทร</td>
    <td width="4%" align="center">Active</td>
    <td width="4%" align="center">แก้ไข</td>
    <td width="4%" align="center">ลบ</td>
    <td width="2%">&nbsp;</td>
  </tr>
	<?php		
			include_once('function.php');
			$fetchdata1 = new DB_con();
			$user_type = $_GET['usertype'];
            $sql1 = $fetchdata1->selectuser($user_type);

				$irow_count = 1;
				while($row_user = mysqli_fetch_array($sql1)) {
					
			//	}
			//}
		
	?>
  
  <tr <?php if($irow_count % 2 == 0){
        ?>class="item"<?php
    }
    else{
        echo "Odd";
    }?>>
    <td><?php echo $row_user['username']; ?></td>
    <td><?php echo $row_user['firstname']; ?></td>
    <td><?php echo $row_user['surname']; ?></td>
    <td><?php echo $row_user['email']; ?></td>
    <td><?php echo $row_user['phone_no']; ?></td>
    <td align="center"><?php 
if ($row_user['active']== 1){ ?><img src="images/check.gif" width="20" height="20"><? };?></td>
    <td align="center"><?php $irow_count++;?><img src="images/edit.gif" width="25" height="25"></td>
    <td></td>
    <td></td>
  </tr><?php  }; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

      </form>   
  </div>
      <?php }; ?>
</div>
 

</div>
</body>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
?>