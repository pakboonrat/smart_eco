<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "USER") {
	
	//------------start upload file--------------
		$message = ''; 
		if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'บันทึกข้อมูล')
		{
		  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
		  {
			// get details of the uploaded file
			$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
			$fileName = $_FILES['uploadedFile']['name'];
			$fileSize = $_FILES['uploadedFile']['size'];
			$fileType = $_FILES['uploadedFile']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			$subject = 	$_POST['subject'];
			$description = 	$_POST['description'];
			$now  = new DateTime;
			$savedate = $now->format( 'Y-m-d' );
						
			// sanitize file-name
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

			// insert into database
			include_once('function.php'); 
			$insert_filedb = new DB_con();
			$inserttodb = $insert_filedb->iuploadfile($_SESSION['id'], $subject, $description , $fileName, $newFileName, $savedate);
			mysqli_fetch_array($inserttodb);


			// check if file has one of the following extensions
			$allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'pdf', 'xlsx', 'docx');

			if (in_array($fileExtension, $allowedfileExtensions))
			{
			  // directory in which the uploaded file will be moved
			  $uploadFileDir = './databasefile/';
			  $dest_path = $uploadFileDir . $newFileName;

			  if(move_uploaded_file($fileTmpPath, $dest_path)) 
			  {
				$message ='File is successfully uploaded.';
				echo "<script>window.location.href='/database.php?yearsel=".date("Y")."'</script>";
			  }
			  else 
			  {
				$message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
			  }
			}
			else
			{
			  $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
			}
		  }
		  else
		  {
			$message = 'There is some error in the file upload. Please check the following error.<br>';
			$message .= 'Error:' . $_FILES['uploadedFile']['error'];
		  }
		}
		$_SESSION['message'] = $message;
		//-----------------end upload---------------- 
		$edit_type = $_GET['edit'];
		$row_id = $_GET['id'];
		if ($edit_type == "delete") {
			include_once('function.php');
			$deleteuserfile = new DB_con();
			$sql = $deleteuserfile->deleteuserfile($row_id);
			 echo "<script>alert('ลบมูลเรียบร้อย !');</script>";
		};
	 
?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>Database</title>
	<script>
		function validateForm() {
		  var x = document.forms["myForm"]["subject"].value;

		  if ((x == "")) {
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
      <h1>คลังไฟล์ข้อมูล</h1>
      <nav class="nav-tabs" id="nav-tabs">
      </nav>
    </header>
  <div class="content-columns">
    <div class="item2"><table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right"><label for="year_select"></label>
      <select name="year_select" id="year_select" ONCHANGE="location = this.options[this.selectedIndex].value;">
        <option value="database.php?yearsel=2021" <?php if ($_GET['yearsel']=='2021'){ echo "selected";} ?>>2564</option>
        <option value="database.php?yearsel=2022" <?php if ($_GET['yearsel']=='2022'){ echo "selected";} ?>>2565</option>
		<option value="database.php?yearsel=2023" <?php if ($_GET['yearsel']=='2023'){ echo "selected";} ?>>2566</option>
		<option value="database.php?yearsel=2024" <?php if ($_GET['yearsel']=='2024'){ echo "selected";} ?>>2567</option>
		<option value="database.php?yearsel=2025" <?php if ($_GET['yearsel']=='2025'){ echo "selected";} ?>>2568</option>
		<option value="database.php?yearsel=2026" <?php if ($_GET['yearsel']=='2026'){ echo "selected";} ?>>2569</option>
		<option value="database.php?yearsel=2027" <?php if ($_GET['yearsel']=='2027'){ echo "selected";} ?>>2570</option>
		<option value="database.php?yearsel=2028" <?php if ($_GET['yearsel']=='2028'){ echo "selected";} ?>>2571</option>
      </select></td>
  </tr>
</table>

	<?php		
			include_once('function.php');
			$fetchdata1 = new DB_con();
			$user_id = $_SESSION['id'];
			$year_select = $_GET['yearsel'];
            $sql1 = $fetchdata1->selectfiledb($user_id, $year_select);
			//$irow_count = 1;
			while($row_userfile = mysqli_fetch_array($sql1)) {
		
	?>
	<div class="item2">
	  <table width="95%" border="0" cellspacing="1" cellpadding="1">
		<tr>
		  <td width="73%" valign="top">เรื่อง : <?php echo $row_userfile['subject']; ?></td>
		  <td width="27%" align="left"><a href="databasefile/<?php echo $row_userfile['save_filename']; ?>" target="_blank" style="text-decoration: none"><p style="font-size:14px;"><?php echo $row_userfile['ori_filename']; ?></p></a></td>
		</tr>
		<tr>
		  <td><font style="font-size:14px;">รายละเอียด : <?php echo $row_userfile['description']; ?>&nbsp;บันทึกเมื่อ :&nbsp;
					<?php echo date("j",strtotime($row_userfile['save_date']))."-".date("n",strtotime($row_userfile['save_date']))."-".date("Y",strtotime($row_userfile['save_date'])); ?></font></td>
		  <td><a href="database.php?yearsel=<?php echo date("Y"); ?>&edit=delete&id=<?php echo $row_userfile['id']; ?>" onClick="return confirm('คุณยืนยันที่จะลบข้อมูล?');"><img src="images/delete.gif" width="30" height="26"><font style="font-size:16px;">&nbsp;ลบข้อมูล</font></a></td>
		</tr>
	  </table>
	</div>
	<?php  }; ?>
<form name="myForm" method="POST" action="database.php" enctype="multipart/form-data" onSubmit="return validateForm()">
      <div class="item2">
        <table width="90%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td width="23%" height="30" align="right" ><p style="font-size:16px;">เรื่อง :&nbsp;&nbsp;</p></td>
            <td width="77%" height="30"><label for="subject"></label>
              &nbsp;<input name="subject" type="text" id="subject2" size="47"><font color="#CC0000">**</font></td>
          </tr>
          <tr>
            <td align="right" valign="top"><p style="font-size:16px;">รายละเอียด :&nbsp;&nbsp;</p></td>
            <td><label for="description"></label>
              &nbsp;<textarea name="description" id="description" cols="50" rows="5"style="overflow:hidden"></textarea></td>
          </tr>
          <tr>
            <td height="30" align="right"><span><font style="font-size:16px;">เลือกไฟล์&nbsp;:&nbsp;</font></span>&nbsp;</td>
            <td height="30">&nbsp;&nbsp;<input type="file" name="uploadedFile" /></td>
          </tr>
        </table>
      </div>&nbsp;&nbsp;&nbsp;<input type="submit" name="uploadBtn" value="บันทึกข้อมูล" />
            </form> 
           </div>
               
  </div>
     
</div>
 

</div>
</body>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
?>