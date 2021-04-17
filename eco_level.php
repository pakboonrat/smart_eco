<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ((strtoupper($_SESSION['user_type']) == "USER") or (strtoupper($_SESSION['user_type']) == "ADMIN") ) {


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

    if (isset($_POST['score'])) {
      
        
        $level_id = $_POST['level_id'];
        $point = $_POST['point'];
        $score_des = $_POST['score_des'];
        $updatedata = new DB_con();
        $sql = $updatedata->insertscore($level_id, $point, $score_des);
        if ($sql) {
            echo "<script>alert('Updated Successfully!".$sql."');</script>";
            // echo "<script>window.location.reload()</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!".$sql."');</script>";
            // echo "<script>window.location.href='update.php'</script>";
        }
    }
	//---------------delete file in transaction-------------
	    $edit_type ="";
		if(isset($_GET['edit'])){ 
			$edit_type = $_GET['edit'];
		}
		if(isset($_GET['tran_id'])){
			$transaction_id = $_GET['tran_id'];
		}
		
		if ($edit_type == "delete") {
			include_once('function.php');
			$deltransaction = new DB_con();
			$sql = $deltransaction->del_transaction($transaction_id);
			 echo "<script>alert('ลบมูลเรียบร้อย !');</script>";
		};
	//---------------delete file in user_add-------------
		$edit_type = $_GET['edit'];
		$transaction_id = $_GET['add_id'];
		if ($edit_type == "del_useradd") {
			include_once('function.php');
			$deluseradd = new DB_con();
			$sql = $deluseradd->del_useradd($transaction_id);
			 echo "<script>alert('ลบมูลเรียบร้อย !');</script>";
		};
	//--------------send to approve by each ID------------------
		//if ($_POST['uploadBtn'] == 'ส่งพิจารณา') {
		//	include_once('function.php');
		//	$updatetran_status = new DB_con();
		//	$updateuseradd_statusbyid = new DB_con();
			
		//	if ($_POST['transac_table']=="useradd") {				
				
		//	}			
		//	else {
				
		//	}
		//	if ($_POST['typeof_rule']=="Guidelines") {
		//		echo "<script>window.location.href='/eco_level.php?level_label=".$_POST['level_label']."&set_lebel=Guidelines'</script>";
		//		} else {echo "<script>window.location.href='/eco_level.php?level_label=".$_POST['level_label']."'</script>";};
		//}
		
		
		
	//--------------send all to approve-------------------------
		$edit_type = $_GET['edit'];
		if ($edit_type == "sendapprove") {
			include_once('function.php');
			$updatetran_status = new DB_con();
			$sql = $updatetran_status->update_transaction($_SESSION['id']);
			$updateuseradd_status = new DB_con();
			$sql = $updateuseradd_status->update_useradd($_SESSION['id']);
			echo "<script>alert('ส่งพิจารณาเรียบร้อย !');</script>";
		} elseif ($edit_type == "sendapproveid") {
			include_once('function.php');
			$updatetran_status = new DB_con();
			$updateuseradd_statusbyid = new DB_con();
			$level_id = $_GET['level_id'];
			$sql = $updatetran_status->update_transactionID($level_id,$_SESSION['id']);
			$sql = $updateuseradd_statusbyid->update_useraddID($level_id,$_SESSION['id']);
			echo "<script>alert('ส่งพิจารณาเรียบร้อย !');</script>";
		};
    //------------start upload file-------------------------
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
			$user_id = $_POST['user_id'];
			$list_id = $_POST['list_id'];
			$now  = new DateTime;
			$savedate = $now->format( 'Y-m-d' );
						
			// sanitize file-name
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

			// insert into database
			include_once('function.php'); 
			$insert_filedb = new DB_con();
			// $level_id, $user_id , $list_label, $remark, $ori_filename, $filename, $savedate
			$inserttodb = $insert_filedb->insert_transaction($user_id, $list_id, $description , $fileName, $newFileName, $savedate);
			mysqli_fetch_array($inserttodb);

			// check if file has one of the following extensions
			$allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'pptx', 'ppt', 'xls', 'doc', 'pdf', 'xlsx', 'docx');

			if (in_array($fileExtension, $allowedfileExtensions))
			{
			  // directory in which the uploaded file will be moved
			  $uploadFileDir = './useraddfile/';
			  $dest_path = $uploadFileDir . $newFileName;

			  if(move_uploaded_file($fileTmpPath, $dest_path)) 
			  {
				$message ='File is successfully uploaded.';
				echo "<script>alert('File is successfully uploaded.');</script>";
				if ($_POST['typeof_rule']=="Guidelines") {
				echo "<script>window.location.href='/eco_level.php?level_label=".$_POST['level_label']."&set_lebel=Guidelines'</script>";
				} else {echo "<script>window.location.href='/eco_level.php?level_label=".$_POST['level_label']."&set_lebel=basic'</script>";};
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
	
		//------------start user manual add upload file-------------------------
		$message = ''; 
		if (isset($_POST['useradd']) && $_POST['useradd'] == 'เพิ่มข้อมูล')
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
			$user_id = $_POST['user_id'];
			$score_id = $_POST['score_id'];;
			$level_id = $_POST['level_id'];
			$now  = new DateTime;
			$savedate = $now->format( 'Y-m-d' );
						
			// sanitize file-name
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

			// insert into database user_add
			include_once('function.php'); 
			$insert_filedb = new DB_con();
			// `level_id`, `score_id`, `user_id`, `list_label`, `remark`, `status`, `ori_filename`, `save_filename`, `save_date`
			$inserttodb = $insert_filedb->user_uploadfile($level_id, $score_id, $user_id,  $subject, $description , $fileName, $newFileName, $savedate);
			mysqli_fetch_array($inserttodb);

			// check if file has one of the following extensions
			$allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'pptx', 'ppt', 'xls', 'doc', 'pdf', 'xlsx', 'docx');

			if (in_array($fileExtension, $allowedfileExtensions))
			{
			  // directory in which the uploaded file will be moved
			  $uploadFileDir = './useraddfile/';
			  $dest_path = $uploadFileDir . $newFileName;

			  if(move_uploaded_file($fileTmpPath, $dest_path)) 
			  {
				$message ='File is successfully uploaded.';
				echo "<script>alert('File is successfully uploaded.');</script>";
				if ($_POST['typeof_rule']=="Guidelines") {
					echo "<script>window.location.href='/eco_level.php?level_label=".$_POST['level_label']."&set_lebel=Guidelines'</script>";
				} else {echo "<script>window.location.href='/eco_level.php?level_label=".$_POST['level_label']."&set_lebel=basic'</script>";};
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

?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>ECO Champion</title>


<?php include('style-header.php'); ?>
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- <script type="text/javascript" >
$('#collapseOne').collapse({
            toggle: false
            })
</script> -->
</head>
<body>
<div class="site-wrap">

  <?php include('site-nav.php'); ?>
  

  <main>

    <header>
      <div class="breadcrumbs">
        <a href="index.php">Home</a>
      </div>
      <h1>เกณฑ์การตรวจประเมิน : <?php echo strtoupper($_GET['level_label']); ?></h1>
      <nav class="nav-tabs" id="nav-tabs">
      <?php 
            // $level_id = $_GET['id'];
            // $set_lebel = $_GET['set_lebel'];
            $year_set = 2564;

            if(!isset($_GET['level_label'])){
                $level_array = array();   
                $LVDB = new DB_con();
                $sql = $LVDB->fetch_level_menu();
                while($rowlm = mysqli_fetch_array($sql)) {
                    if( $rowlm['level_label'] != null ){
                        
                array_push($level_array,$rowlm['level_label']);
                    }
                }
                $_GET['level_label'] = $level_array[0];
            }
            $level_label = $_GET['level_label'];
            $updatelevel = new DB_con();
			if ($_SESSION['user_type']=="ADMIN") {
				$sql = $updatelevel->level_headeradmin($_GET['level_label']);
			} else {$sql = $updatelevel->fetch_level_header($_GET['level_label'],$_SESSION['id']);}
			
            $set_lebel_array = array();
            $active_class = "class=\"active\" " ;
            while($row = mysqli_fetch_array($sql)) {
					array_push($set_lebel_array,$row['set_lebel']);
					$i = 0;
				?>
				<a href="eco_level.php?level_label=<?php echo $level_label; ?>&set_lebel=<?php echo $row['set_lebel']; ?>" <?php 
					if(!isset($_GET['set_lebel'])){ 
						echo $active_class;
					}elseif ($row['set_lebel'] == $_GET['set_lebel']) {
						echo "class=\"active\" ";
					}; ?>  >
					<?php if ($row['set_lebel']== 'basic'){ echo "เงื่อนไขเบื้องต้น";}
					else {
						echo "หลักเกณฑ์การขอรับรองการเป็นเมืองอุตสาหกรรมเชิงนิเวศ";
						}
					?>
				
				</a>
        	<?php $active_class=""; } ?>
      </nav>
      
    </header>

    <div class="content-columns">
      <?php 
          $fetchdata = new DB_con();
          $level_label = $_GET['level_label'];

          //if(isset($_GET['set_lebel'])){ 
            $set_lebel = $_GET['set_lebel'];
          //}else{ 
          //  $set_lebel = $set_lebel_array[0]; 
          //  }
			
         //--------------Select only rule with in 6 type not include Admin------------
		 if($_SESSION['user_type']=="USER") {
			$sql = $fetchdata->fetchdata($level_label,$set_lebel,$_SESSION['id']);
		 } else{
			$sql = $fetchdata->fetchdata_admin($level_label,$set_lebel);
		 }
          while($row = mysqli_fetch_array($sql)) {
            $level_label = $row['level_label'] ;
      ?>
            <div>
            
            <div class="item"><B><?php echo $row['sub_lebel']; ?></B> 
                <?php if($_SESSION['user_type']!="USER") { ;?>
							<div class="item-button">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" alt="แก้ไข" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
									<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
									<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
									</svg> 
							</div>
                
                <?php } ?>
                

                <?php 
                // ถ้าอิงคะแนน ต้องดึง จาก Table score ก่อน
                if( $row['type'] == 'measure' ){
                    ?>
                    <div class="item2">
                        <?php
						if ($row['type']=="control") {
							$typeof_rule = "เกณฑ์บังคับ";
						} else {$typeof_rule = "เกณฑ์คะแนน";};
                        echo "<p>".$typeof_rule."</p>";
                        $fetchdata3 = new DB_con();
                        //echo "level_ID :".$row['level_id'];
                        $sql3 = $fetchdata3->fetch_score($row['level_id']);
                        if( $sql3 !="" ){ 
                        ?>
							<div class="card">
								<?php //-----------------start write score_id on web-----------------
								while($row_score = mysqli_fetch_array($sql3)) {
								?>
									<?php //echo $row['level_id']; ?><?php //echo $row_score['score_id']; ?>
									<div class="card">
										<div class="card-header" id="headingOne">
											  <h5 class="mb-0">
												<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row['level_id']; ?><?php echo $row_score['score_id']; ?>" aria-expanded="true" aria-controls="collapseOne">ส่งข้อมูลเกณฑ์คะแนน #<?php echo $row_score['score_des']; ?>
												</button>
											  </h5>
										</div>
										<div id="collapseOne<?php echo $row['level_id']; ?><?php echo $row_score['score_id']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?php echo $row['level_id']; ?><?php echo $row_score['score_id']; ?>">  
										  <div class="card-body">
											<?php $fetchdata4 = new DB_con();
											$sql4 = $fetchdata4->select_listby_score($row['level_id'],$row_score['score_id']);
											while($row_oflist = mysqli_fetch_array($sql4)) {
												
											//echo $row_oflist['list_label'];?>
											<?php 	include_once('function.php'); 
													$transactiondata = new DB_con();
													$result = $transactiondata->selecttransaction($_SESSION['id'], $row_oflist['list_id']);
													$transactionfile = mysqli_fetch_array($result);
													if ($transactionfile == 0) 
													{?>
													<div class="card">
													
														<div class="card-header" id="headingOne">
														<?php echo $row_oflist['list_label'];
														//----------------show evidence in each of score-----------?>
														<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>" aria-expanded="true" aria-controls="collapseOne">>></button>
														</div>
														<div id="collapseOne<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>">
															<div class="card-body">
															  <form name="myForm" method="POST" action="eco_level.php" enctype="multipart/form-data">
																	  <div class="item2">
																		<table width="100%" border="0" cellspacing="1" cellpadding="1">
																		  <tr>
																			<td width="200" align="right" valign="top"><p style="font-size:14px;">รายละเอียด :&nbsp;&nbsp;</p></td>
																			<td width="913"><label for="description"></label>
																			&nbsp;<textarea name="description" id="description" cols="50" rows="5"style="overflow:hidden"></textarea></td>
																		  </tr>
																		  <tr>
																			<td height="30" align="right"><span><font style="font-size:14px;">เลือกไฟล์&nbsp;:&nbsp;</font></span>&nbsp;</td>
																			<td height="30">&nbsp;&nbsp;<input type="file" name="uploadedFile" /></td>
																		  </tr>
																		</table>
																		<input name="level_label" type="hidden" id="level_label" value="<?php echo $_GET['level_label'];?>">
																		<input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['id'];?>">
																		<input name="list_id" type="hidden" id="list_id" value="<?php echo $row_oflist['list_id'];?>">
																		<input name="typeof_rule" type="hidden" id="typeof_rule" value="<?php echo $_GET['set_lebel'];?>">
																	  </div>&nbsp;&nbsp;&nbsp;<input type="submit" name="uploadBtn" value="บันทึกข้อมูล" />
																</form>
															</div>
														</div>
													</div>
													<?php } else {//-----------if found in transaction------------ ?>
													
														<div class="card">
														<div class="card-header" id="headingOne" style="background-color: lightblue">
															<?php echo $row_oflist['list_label'];
															//----------------show evidence in each of score-----------?>
															<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>" aria-expanded="true" aria-controls="collapseOne">&nbsp;<font style="font-size:14px;color:#0A910D;">(สถานะ&nbsp;:&nbsp;
														<?php if (($transactionfile['status'])=="save") {echo "บันทึก";} 
														elseif (($transactionfile['status'])=="consider") {echo "รอพิจารณา";}
														elseif (($transactionfile['status'])=="pass") {echo "ผ่านพิจารณา";}
														elseif (($transactionfile['status'])=="reject") {echo "ไม่อนุมัติ";}
														else {echo "-";}?>&nbsp;เมื่อ :&nbsp;
														<?php //echo $transactionfile['save_date'];
														$str_date = date("j",strtotime($transactionfile['save_date']));
														$str_Year = date("Y",strtotime($transactionfile['save_date']))+543;
														$str_Month = date("n",strtotime($transactionfile['save_date']));
														$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
														$strMonthThai=$strMonthCut[$str_Month];
														echo $str_date."-".$strMonthThai."-".$str_Year;?>)</font>&nbsp;>></button>
															</div>
															<div id="collapseOne<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>">
																<div class="card-body">
																	<table width="100%" border="0" cellspacing="1" cellpadding="1">
																		<tr>
																			<td width="200" align="right" valign="top"><p style="font-size:14px;">รายละเอียด :&nbsp;&nbsp;</p></td>
																			<td width="913"><p style="font-size:14px;">
																				&nbsp;<?php echo $transactionfile['remark'];?></p></td>
																		</tr>
																		<tr>
																			<td height="30" align="right"><span><font style="font-size:14px;">ไฟล์แนบ&nbsp;:&nbsp;</font></span>&nbsp;</td>
																			<td height="30">&nbsp;&nbsp;<a href="useraddfile/<?php echo $transactionfile['save_filename']; ?>" target="_blank" style="text-decoration: none"><?php echo $transactionfile['ori_filename'];?></a>&nbsp;<a href="eco_level.php?level_label=eco_champion&edit=delete&tran_id=<?php echo $transactionfile['t_id'];?>&set_lebel=<?php echo $_GET['set_lebel'];?>" onClick="return confirm('คุณยืนยันที่จะลบข้อมูล?');"><img src="images/delete.gif" width="30" height="26"><font style="font-size:16px;">&nbsp;ลบข้อมูล</font></a></td>
																		</tr>
																	</table>
																</div>
															</div>
														</div>	
														
													<?php;}//-----------end check data in transaction----------------?>	
											<?php }?>
										  
										  <?php //------------------select from user manual add in each score-------?>
										  <?php  //---------------------select from user manual add--------------- 
												$fetchdata_user = new DB_con();
												$level_id = $row['level_id'];
												$score_id = $row_score['score_id'];
												$sql_useradd = $fetchdata_user->fetch_useradd($level_id,$_SESSION['id'],$score_id);
												while($useradd_list = mysqli_fetch_array($sql_useradd)) {
											?>
											<div class="card">
											<div class="card-header" style="background-color: lightblue">
												<table width="100%" border="0" cellspacing="1" cellpadding="1">
														<tr>
															<td width="130" align="right" valign="top"><p style="font-size:14px;">ข้อมูลเพิ่มเติม :&nbsp;</p></td>
															<td width="550"><p style="font-size:14px;">
																&nbsp;<?php echo $useradd_list['list_label'];?></p></td>
															<td width="446" align="right"><p style="font-size:14px;color:#0A910D;">&nbsp;(สถานะ&nbsp;:&nbsp;
													<?php if (($useradd_list['status'])=="save") {echo "บันทึก";} 
													elseif (($useradd_list['status'])=="consider") {echo "รอพิจารณา";}
													elseif (($useradd_list['status'])=="pass") {echo "ผ่านพิจารณา";}
													elseif (($useradd_list['status'])=="reject") {echo "ไม่อนุมัติ";}
													else {echo "-";}?>
													&nbsp;เมื่อ :&nbsp;
													<?php //------------------change to Thaidate-----------------
													$str_date = date("j",strtotime($useradd_list['save_date']));
													$str_Year = date("Y",strtotime($useradd_list['save_date']))+543;
													$str_Month = date("n",strtotime($useradd_list['save_date']));
													$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
													$strMonthThai=$strMonthCut[$str_Month];
													echo $str_date."-".$strMonthThai."-".$str_Year;?>)</p></td>
														</tr>
														<tr>
															<td width="130" align="right" valign="top"><p style="font-size:14px;">รายละเอียด :&nbsp;&nbsp;</p></td>
															<td colspan="2"><p style="font-size:14px;">
																&nbsp;<?php echo $useradd_list['remark'];?></p></td>
														</tr>
														<tr>
															<td height="30" align="right"><span><font style="font-size:14px;">ไฟล์แนบ&nbsp;:&nbsp;</font></span>&nbsp;</td>
															<td height="30" colspan="2">&nbsp;&nbsp;<a href="useraddfile/<?php echo $useradd_list['save_filename'];?>" target="_blank" style="text-decoration: none"><?php echo $useradd_list['ori_filename'];?></a>&nbsp;<a href="eco_level.php?level_label=eco_champion&edit=del_useradd&add_id=<?php echo $useradd_list['add_id'];?>&set_lebel=<?php echo $_GET['set_lebel'];?>" onClick="return confirm('คุณยืนยันที่จะลบข้อมูล?');"><img src="images/delete.gif" width="30" height="26"><font style="font-size:16px;">&nbsp;ลบข้อมูล</font></a></td>
														 </tr>
												</table>
                                            </div>
											</div>
									<?php }; //---------------------end select from user manual add---------------  ?>
									</div> 
										  <?php //-----------------end select from user manual score--------
												//---------------add manual score evidence----------- 
												if (strtoupper($_SESSION['user_type']) == "USER"){
										?>
													<table width="100%"><tr><td align="center">
													<button class="btn-info" data-toggle="collapse"
														aria-expanded="false"
														aria-controls="collapseExample"
														data-target="#collapseExample<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>">+เพิ่มหลักฐานอื่นๆ</button>&nbsp;&nbsp;
														<button class="btn-info" name="sendapprove" onclick="window.location.href='eco_level.php?level_label=eco_champion&edit=sendapproveid&set_lebel=<?php echo $_GET['set_lebel'];?>&level_id=<?php echo $row['level_id']; ?>'">ส่งพิจารณา</button>
													</td></tr></table>
													<form name="myForm" method="POST" action="eco_level.php" enctype="multipart/form-data">
														<div class="collapse" id="collapseExample<?php echo $row_oflist['list_id'];?><?php echo $row_score['score_id'];?>">                                
														<div class="item2">
																	<p class="mb-0">
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
																				<tr>
																				<td height="10" colspan="2">
																				<input id="level_id" name="level_id" type="hidden" value="<?php echo $row['level_id']; ?>">
																				<input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['id'];?>">
																				<input name="score_id" type="hidden" id="score_id" value="<?php echo $row_score['score_id'];?>">
																				<input name="level_label" type="hidden" id="level_label" value="<?php echo $_GET['level_label'];?>">
																				<input name="typeof_rule" type="hidden" id="typeof_rule" value="<?php echo $_GET['set_lebel'];?>"></td>
																				</tr>
																				<tr>
																				<td height="30" align="right"><span><font style="font-size:16px;">&nbsp;</font></span>&nbsp;</td>
																				<td height="30"><input type="submit" name="useradd" value="เพิ่มข้อมูล" /></td>
																			</tr>
																		</table>
																	</p>
														</div>
														</div>
													</form>
											
											<?php };//---------------end add manual score evidence-----------?>
										</div>
									  </div>
									
								<?php } ?>
							</div>
							
                        <?php };?>
                    </div>
                
                <?php 
                }else{
                    //---------------control---------------
                    if( $row['type'] == 'control' ){
						?><div class='item2'>
                    			<?php echo "<p>เกณฑ์บังคับ</p>";
                    }
                        		$fetchdata2 = new DB_con();
                        		$sql2 = $fetchdata2->fetch_list($row['level_id']);
                        		if( $sql2 != '' ){
                            ?>  <?php 
                                    
                                    while($row_list = mysqli_fetch_array($sql2)) {?>
                                        
                                            <?php if($_SESSION['user_type']=="ADMIN"){ 
                                            //  Admin จะเป็นกล่องสำหรับแก้ไขได้     ?>
                                            <div contentEditable='true' class='edit' id='list_label_<?php echo $row_list['list_id']; ?>' name='list_label_<?php echo $row_list['list_id']; ?>'><?php echo $row_list['list_label']; ?></div> 
                                            <?php }else{ ?>
                                                                                              
											
                                            <div id="accordion<?php echo $row_list['list_id'];?>">
												<?php //---------------select transaction if found show file/delete/change color-----------
												    include_once('function.php'); 
    												$transactiondata = new DB_con();
													$result = $transactiondata->selecttransaction($_SESSION['id'], $row_list['list_id']);
													$transactionfile = mysqli_fetch_array($result);
													 if ($transactionfile == 0) {
												?>
												
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                    <p class="mb-0"><?php echo $row_list['list_label']; ?>
										<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row_list['list_id'];?>" aria-expanded="true" aria-controls="collapseOne">
                  						>></button>
                                                    </p>
                                                    </div>
                                                    <div id="collapseOne<?php echo $row_list['list_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?php echo $row_list['list_id'];?>">
													<div class="card-body">
                                       				  <form name="myForm" method="POST" action="eco_level.php" enctype="multipart/form-data">
															  <div class="item2">
																<table width="100%" border="0" cellspacing="1" cellpadding="1">
																  <tr>
																	<td width="200" align="right" valign="top"><p style="font-size:14px;">รายละเอียด :&nbsp;&nbsp;</p></td>
																	<td width="913"><label for="description"></label>
																    &nbsp;<textarea name="description" id="description" cols="50" rows="5"style="overflow:hidden"></textarea></td>
																  </tr>
																  <tr>
																	<td height="30" align="right"><span><font style="font-size:14px;">เลือกไฟล์&nbsp;:&nbsp;</font></span>&nbsp;</td>
																	<td height="30">&nbsp;&nbsp;<input type="file" name="uploadedFile" /></td>
																  </tr>
																</table>
																<input name="level_label" type="hidden" id="level_label" value="<?php echo $_GET['level_label'];?>">
																<input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['id'];?>">
																<input name="list_id" type="hidden" id="list_id" value="<?php echo $row_list['list_id'];?>">
																<input name="typeof_rule" type="hidden" id="typeof_rule" value="<?php echo $_GET['set_lebel'];?>">
															  </div>&nbsp;&nbsp;&nbsp;<input type="submit" name="uploadBtn" value="บันทึกข้อมูล" />
														</form>
                                                    </div>
												
                                                    </div>
                                                </div>
													 
											<?php } else { //--------------found show file/delete/change color-----------?>
												<div class="card">
                                                    <div class="card-header" id="headingOne" style="background-color: lightblue">
                                                    <p class="mb-0"> <?php echo $row_list['list_label']; ?>&nbsp;<font style="font-size:14px;color:#0A910D;">(สถานะ&nbsp;:&nbsp;
													<?php if (($transactionfile['status'])=="save") {echo "บันทึก";} 
													elseif (($transactionfile['status'])=="consider") {echo "รอพิจารณา";}
													elseif (($transactionfile['status'])=="pass") {echo "ผ่านพิจารณา";}
													elseif (($transactionfile['status'])=="reject") {echo "ไม่อนุมัติ";}
													else {echo "-";}?>&nbsp;เมื่อ :&nbsp;
													<?php //echo $transactionfile['save_date'];
													$str_date = date("j",strtotime($transactionfile['save_date']));
													$str_Year = date("Y",strtotime($transactionfile['save_date']))+543;
													$str_Month = date("n",strtotime($transactionfile['save_date']));
													$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
													$strMonthThai=$strMonthCut[$str_Month];
													echo $str_date."-".$strMonthThai."-".$str_Year;?>)</font>
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row_list['list_id'];?>" aria-expanded="true" aria-controls="collapseOne">
                                                        >>
                                                        </button>
                                                    </p>
                                                    </div>
                                                    <div id="collapseOne<?php echo $row_list['list_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?php echo $row_list['list_id'];?>">
														<div class="card-body">
														 
																  <div class="item2">
																	<table width="100%" border="0" cellspacing="1" cellpadding="1">
																	  <tr>
																		<td width="200" align="right" valign="top"><p style="font-size:14px;">รายละเอียด :&nbsp;&nbsp;</p></td>
																		<td width="913"><p style="font-size:14px;">
																			&nbsp;<?php echo $transactionfile['remark'];?></p></td>
																	  </tr>
																	  <tr>
																		<td height="30" align="right"><span><font style="font-size:14px;">ไฟล์แนบ&nbsp;:&nbsp;</font></span>&nbsp;</td>
																		<td height="30">&nbsp;&nbsp;<a href="useraddfile/<?php echo $transactionfile['save_filename']; ?>" target="_blank" style="text-decoration: none"><?php echo $transactionfile['ori_filename'];?></a>&nbsp;<a href="eco_level.php?level_label=eco_champion&edit=delete&tran_id=<?php echo $transactionfile['t_id'];?>&set_lebel=<?php echo $_GET['set_lebel'];?>" onClick="return confirm('คุณยืนยันที่จะลบข้อมูล?');"><img src="images/delete.gif" width="30" height="26"><font style="font-size:16px;">&nbsp;ลบข้อมูล</font></a></td>
																	  </tr>
																	</table>
																  </div>
														</div>
                                                    </div>
                                                </div>
											<?php } ?>
											
											
                                            </div>
                                          	

                                            <?php  };  ?>
                                    <?php }; //-----------------end select list table-------------------- ?>
									<?php  //---------------------select from user manual add--------------- 
												$fetchdata_user = new DB_con();
												$level_id = $row['level_id'];
												$score_id = "0";
												$sql_useradd = $fetchdata_user->fetch_useradd($level_id,$_SESSION['id'],$score_id);
												
												while($useradd_list = mysqli_fetch_array($sql_useradd)) {
												
											?>
											<div class="card">
											<div class="card-header" style="background-color: lightblue">
												
												<table width="100%" border="0" cellspacing="1" cellpadding="1">
														<tr>
															<td width="130" align="right" valign="top"><p style="font-size:14px;">ข้อมูลเพิ่มเติม :&nbsp;</p></td>
															<td width="550"><p style="font-size:14px;">
																&nbsp;<?php echo $useradd_list['list_label'];?></p></td>
															<td width="576" align="right"><p style="font-size:14px;color:#0A910D;">&nbsp;(สถานะ&nbsp;:&nbsp;
													<?php if (($useradd_list['status'])=="save") {echo "บันทึก";} 
													elseif (($useradd_list['status'])=="consider") {echo "รอพิจารณา";}
													elseif (($useradd_list['status'])=="pass") {echo "ผ่านพิจารณา";}
													elseif (($useradd_list['status'])=="reject") {echo "ไม่อนุมัติ";}
													else {echo "-";}?>&nbsp;เมื่อ :&nbsp;
													<?php //------------------change to Thaidate-----------------
													$str_date = date("j",strtotime($useradd_list['save_date']));
													$str_Year = date("Y",strtotime($useradd_list['save_date']))+543;
													$str_Month = date("n",strtotime($useradd_list['save_date']));
													$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
													$strMonthThai=$strMonthCut[$str_Month];
													echo $str_date."-".$strMonthThai."-".$str_Year;?>)</p></td>
														</tr>
														<tr>
															<td width="130" align="right" valign="top"><p style="font-size:14px;">รายละเอียด :&nbsp;&nbsp;</p></td>
															<td colspan="2"><p style="font-size:14px;">
																&nbsp;<?php echo $useradd_list['remark'];?></p></td>
														</tr>
														<tr>
															<td height="30" align="right"><span><font style="font-size:14px;">ไฟล์แนบ&nbsp;:&nbsp;</font></span>&nbsp;</td>
															<td height="30" colspan="2">&nbsp;&nbsp;<a href="useraddfile/<?php echo $useradd_list['save_filename'];?>" target="_blank" style="text-decoration: none"><?php echo $useradd_list['ori_filename'];?></a>&nbsp;<a href="eco_level.php?level_label=eco_champion&edit=del_useradd&add_id=<?php echo $useradd_list['add_id'];?>&set_lebel=<?php echo $_GET['set_lebel'];?>" onClick="return confirm('คุณยืนยันที่จะลบข้อมูล?');"><img src="images/delete.gif" width="30" height="26"><font style="font-size:16px;">&nbsp;ลบข้อมูล</font></a></td>
														 </tr>
												</table>
												
                                            </div>
											</div>
                                              
									<?php }; //---------------------end select from user manual add---------------  ?>
									<?php if (strtoupper($_SESSION['user_type']) == "USER"){?>
											<br>
											<table width="100%"><tr><td align="center">
											<button class="btn-info" data-toggle="collapse"
												aria-expanded="false"
												aria-controls="collapseExample"
												data-target="#collapseExample<?php echo $row['level_id']; ?>">+เพิ่มหลักฐานอื่นๆ</button>
												<button class="btn-info" name="sendapprove" onclick="window.location.href='eco_level.php?level_label=eco_champion&edit=sendapproveid&set_lebel=<?php echo $_GET['set_lebel'];?>&level_id=<?php echo $row['level_id']; ?>'">ส่งพิจารณา</button>
											</td></tr></table>
											<form name="myForm" method="POST" action="eco_level.php" enctype="multipart/form-data">
												<div class="collapse" id="collapseExample<?php echo $row['level_id']; ?>">                                
												<div class="item2">
															
															<p class="mb-0">
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
															<tr>
																<td height="10" colspan="2"><input id="level_id" name="level_id" type="hidden" value="<?php echo $row['level_id']; ?>"><input name="user_id" type="hidden" id="user_id" value="<?php echo $_SESSION['id'];?>">
																<input name="score_id" type="hidden" id="typeof_rule" value="0">
																<input name="typeof_rule" type="hidden" id="typeof_rule" value="<?php echo $_GET['set_lebel'];?>"></td>
																</tr>
																<tr>
																			<td height="30" align="right">&nbsp;<input name="level_label" type="hidden" id="level_label" value="<?php echo $_GET['level_label'];?>"></td>
																			<td height="30"><input type="submit" name="useradd" value="เพิ่มข้อมูล" /></td>
																		</tr>
															</table>
															</p>
															
												</div>
											
												</div>
											</form>
								
                        				<?php  };
                      
                      
                      }; 
                        ?></div>
                    <?php   //--Close-------control : section    } 
					
                };?>
            </div>
            
            <?php } ?>
        
		<?php
		// Admin กำหนด Level ใหม่
		if($_SESSION['user_type']=="ADMIN"){ ?>
		<div class="col" >
				<form method="post">
				<div class="collapse multi-collapse mt-3" id="multiCollapseExample1">
						<div class="item">
						<input type="text" id="sub_lebel" name="sub_lebel" class="form-control form-control-sm" >
							<div>
								<input id="level_label" name="level_label" type="hidden" value="<?php echo $level_label; ?> ">
								<input id="year_set" name="year_set" type="hidden" value="<?php echo $year_set; ?> ">
								<input id="set_lebel" name="set_lebel" type="hidden" value="<?php echo $set_lebel; ?> ">
								<button type="submit" name="submit" id="submit" class="badge bg-primary btn btn-success" >save</button>
							
							</div> 
						</div>
				</div>
				</form>

			
				
			</div> 
		</div>
		<?php }; ?>
				<button class="btn btn-success" onclick="window.location.href='eco_level.php?level_label=eco_champion&edit=sendapprove';">ส่งพิจารณาทั้งหมด</button>
			
		
	</main>

	</div>
</body>
</html>

<?php 

} }
   ?>