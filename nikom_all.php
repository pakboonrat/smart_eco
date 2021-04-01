<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "ADMIN") {
    include_once('function.php');

    if (isset($_POST['submit'])) {
      
        
		$username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
		$user_type = $_GET['usertype'];
		$phone_no = $_POST['tel'];
		$department = "";
        
		$userdata = new DB_con();
		$sql = $userdata->registration($username ,$password, $email, $user_type , $firstname, $surname, $phone_no, $department ,true);
		//$username ,$password ,$email ,$user_type, $firstname, $surname, $phone_no, $department,  $active
        if ($sql) {
            echo "<script>alert('เพิ่มข้อมูลเรียบร้อย !');</script>";
            echo "<script>window.location.href='nikom_all.php?usertype=USER'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!');</script>";
            echo "<script>window.location.href='nikom_all.php?usertype=USER'</script>";
        }
    }
		$edit_type = $_GET['edit'];
		$user_id = $_GET['userid'];
		if ($edit_type == "delete") {
			include_once('function.php');
			$deleteuser = new DB_con();
			$sql = $deleteuser->deleteuser($user_id);
			 echo "<script>alert('ลบมูลเรียบร้อย !');</script>";
		};
      
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
      <h1>แก้ไขปรับปรุงผู้ใช้ : <?php echo $_GET['usertype']?></h1>
      <nav class="nav-tabs" id="nav-tabs">
      </nav>
    </header>
  <div class="content-columns">
    <?php    if($_SESSION['user_type']=="ADMIN"){ ?>     
            <form name="myForm" method="post" onSubmit="return validateForm()">
<table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
  <tr>
    <td width="10%" align="center">Username</td>
    <td width="15%" align="center">ชื่อ</td>
    <td width="25%" align="center">นามสกุล</td>
    <td width="12%" align="center">Email</td>
    <td width="12%" align="center">เบอร์โทร</td>
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
				if ($row_user['active']== 1){ ?><img src="images/check.gif" width="20" height="20">
				<? }
					else {?><img src="images/delete.gif" width="20" height="20">
				<?} ?></td>
    <td align="center"><?php $irow_count++;?>
      <a href="nikom_all.php?usertype=<?php echo $user_type;?>&edit=edit&userid=<?php echo $row_user['user_id']; ?>"><img src="images/edit.gif" width="25" height="25"></a></td>
    <td align="center"><a href="nikom_all.php?usertype=<?php echo $user_type;?>&edit=delete&userid=<?php echo $row_user['user_id']; ?>" onClick="return confirm('คุณยืนยันที่จะลบข้อมูล?');"><img src="images/delete.gif" width="28" height="24"></a></td>
    <td></td>
  </tr><?php  }; ?>

</table><br>
<br>
<br>
<br>
	<?php 
		$edit_type = $_GET['edit'];
		if ($edit_type != "edit") {
    ?>

<table width="90%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td height="10">&nbsp;</td>
    <td height="10">&nbsp;</td>
  </tr>
  <tr>
    <td height="10"><label for="user">USER NAME</label></td>
    <td height="10"><input name="username" type="text" id="username" size="25"></td>
  </tr>
  <tr>
    <td height="10"><label for="pwd">PASSWORD</label></td>
    <td height="10"><input name="password" type="password"  id="password" size="25"  inputmode="text" ></td>
  </tr>
  <tr>
    <td height="10"><label for="firstname">ชื่อ </label></td>
    <td height="10"> <input  name="firstname" type="text" id="firstname" size="40" ></td>
  </tr>
  <tr>
    <td height="10"><label for="surname">นามสกุล</label></td>
    <td height="10"><input name="surname" type="text"  id="surname" size="40" ></td>
  </tr>
    <tr>
    <td height="10"><label for="email">Email</label></td>
    <td height="10"><input name="email" type="text"  id="email" size="40" inputmode="email"></td>
  </tr>
    <tr>
    <td height="10"><label for="tel">เบอร์โทร</label></td>
    <td height="10"><input name="tel" type="text"  id="tel"></td>
  </tr>
    </tr>
    <tr>
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="submit" id="submit">เพิ่มผู้ใช้งาน</button></td>
    </tr>
</table>
	<?php  }
	else if ($edit_type == "edit") {
		$conn = null;
		include_once('function.php');
		$user_id = $_GET['userid'];
		$newcon = new DB_con();
		$result = $newcon->selectuseredit($user_id);
        $userdata = mysqli_fetch_array($result);

		 ?>
		<table width="90%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td height="10">&nbsp;</td>
    <td height="10">&nbsp;</td>
  </tr>
    <tr>
    <td height="10">USER ID</td>
    <td height="10"><?php echo $userdata['user_id']; ?></td>
  </tr>
  <tr>
    <td height="10"><label for="user">USER NAME</label></td>
    <td height="10"><input name="username" type="text" id="username" size="25" value="<?php echo $userdata['username']; ?>"></td>
  </tr>
  <tr>
    <td height="10"><label for="pwd">PASSWORD</label></td>
    <td height="10"><input name="password" type="password"  id="password" size="25"  inputmode="text" ></td>
  </tr>
  <tr>
    <td height="10"><label for="firstname">ชื่อ </label></td>
    <td height="10"> <input  name="firstname" type="text" id="firstname" value="<?php echo $userdata['firstname']; ?>" size="40" ></td>
  </tr>
  <tr>
    <td height="10"><label for="surname">นามสกุล</label></td>
    <td height="10"><input name="surname" type="text"  id="surname" value="<?php echo $userdata['surname']; ?>" size="40" ></td>
  </tr>
    <tr>
    <td height="10"><label for="email">Email</label></td>
    <td height="10"><input name="email" type="text"  id="email" value="<?php echo $userdata['email']; ?>" size="40" inputmode="email"></td>
  </tr>
    <tr>
    <td height="10"><label for="tel">เบอร์โทร</label></td>
    <td height="10"><input name="tel" type="text"  id="tel" value="<?php echo $userdata['phone_no']; ?>"></td>
  </tr>
    </tr>
    <tr>
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="submit" id="submit">&nbsp;Update&nbsp;</button></td>
    </tr>
</table> <?php  }; ?>
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