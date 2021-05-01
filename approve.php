<?php 
    session_start();
	ob_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "AUDITOR") {
    include_once('function.php');

	$user_id = $_GET["userid"] ;

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

?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>Auditor Approve</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
<!-- <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
></script> -->



</head>
<body>
<div class="site-wrap">
  <?php include('site-nav.php'); ?>
  
  <main>
    <header>
      <div class="breadcrumbs">
        <a href="audit.php">Home</a>
      </div>
      <h1>ตรวจพิจารณา : <?php
	  		$user_con = new DB_con();
            $sqluser = $user_con->selectuseredit($user_id);
                while($rowuser = mysqli_fetch_array($sqluser)) {
                    echo $rowuser['firstname'] ." ". $rowuser['surname'];
				}
			?> </h1><input type="hidden" id="audit" value="<?php echo $_SESSION['id']; ?>">
					<input type="hidden" id="user" value="<?php echo $user_id; ?>">
			
       <!-- <nav class="nav-tabs" id="nav-tabs">
       <a href="audit.php">ตรวจพิจารณา</a>&nbsp;>&nbsp;<a href="approve.php" >นิคมฯ อัญธานี</a></nav> -->
	
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
            $sql = $updatelevel->level_headeradmin($level_label);
            $set_lebel_array = array();
            $active_class = "class=\"active\" " ;
            while($row = mysqli_fetch_array($sql)) {
            array_push($set_lebel_array,$row['set_lebel']);
            $i = 0;
            
        ?>
        <a href="approve.php?userid=<?php echo $user_id; ?>&level_label=<?php echo $level_label; ?>&set_lebel=<?php echo $row['set_lebel']; ?>" <?php 
            if(!isset($_GET['set_lebel'])){ 
                echo $active_class;
            }elseif (strtolower($row['set_lebel']) == strtolower($_GET['set_lebel'])) {
                echo "class=\"active\" ";
            }; ?>  >
            <?php if (strtolower($row['set_lebel'])== 'basic'){ echo "เงื่อนไขเบื้องต้น";}
			else {
				  echo "หลักเกณฑ์การขอรับรองการเป็นเมืองอุตสาหกรรมเชิงนิเวศ";
				}
			?>
          
        </a>
        <?php $active_class=""; } ?>
        
      </nav>
	</header>
  	<div class="content-columns mt-0">
    <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>     
			
			<?php
				if(isset($_GET['set_lebel'])){
					$set_lebel = $_GET['set_lebel'];
				}else{
					$set_lebel = "" ;
				} 

				
				$fetchdata = new DB_con();
				$sql = $fetchdata->fetch_approve_level($user_id ,$set_lebel);
				// fetch_approve_level   ,   fetch_transaction_list_level
				if(!empty($sql)){
				$label_var = "";	
				$sub_lebel = "" ;
				$label_class = "";
				$status_var = "";
				while($row = mysqli_fetch_array($sql)) { 
				$app_level_id = $row['level_id'];
				if( !isset($_GET['set_lebel'])){

				$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				header("Refresh:0; url=".$actual_link."&set_lebel=".$row['set_lebel']);
				//echo $actual_link."&set_lebel=".$row['set_lebel'];
				}

			   ?>
					<?php
						if( strtolower($row['status']) == "pass" ){
							$check_label = "";
							$badge_color = "-info";
							$status_display = "ผ่านการพิจารณา";
						}elseif( strtolower($row['status']) == "reject" ){
							$check_label = "-reject";
							$badge_color = "-dark";
							$status_display = "ไม่ผ่านการพิจารณา";
						}else{
							$check_label = "-uncheck";
							$badge_color = "-secondary";
							$status_display = " - ";
						}

						

						if( ( strtolower($sub_lebel) != strtolower($row['sub_lebel'])) AND ( strtolower($row['set_lebel']) == 'guidelines' )  ){
							if( $row['type'] == "measure"){
								$type_display = "เกณฑ์คะแนน";
							}elseif( $row['type']== "control"){
								$type_display = "เกณฑ์บังคับ";
							}else{
								$type_display = $row['type'];
							}

							$label_var = $row['level_id'].$row['type'];
							$status_var = "status_".$row['level_id'].$row['type'];
							?>
							
							
					
							<div class="list-mail mt-3">
								<div class="mail-contents-subject">

									<input type="checkbox" name="msg" id="mail20" class="mail-choice" checked="">
									<label id="<?php echo $row['level_id'].$row['type'];?>" class="mail-choice-label<?php echo $check_label; ?>" for="mail20"></label>
							
									<div class="mail-contents-title  col-xl-10 pl-0"><?php echo $row['sub_lebel'];?></div>
								</div>
								<?php if( isset($row['status']) ){  ?>
									
									<div id="status_<?php echo $row['level_id'].$row['type']; ?>" class="mail"><?php echo $type_display;?> <strong> สถานะ : </strong>  <?php  echo $status_display ; ?> </div>
									
								<?php }else{  ?> 
									<div id="status_<?php echo $row['level_id'].$row['type']; ?>" class="mail"></div>
								<?php } ?>
							</div>
		
							<button class="badge badge<?php echo $badge_color; ?>" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'] ."_".$row['type'];?>" ><?php echo $type_display;?></button>
							<?php 	
						}elseif( strtolower($row['set_lebel']) != 'guidelines' ){
							?>
							 
							<!-- <div class="list-mail">
							<B><?php echo $row['sub_lebel'];?> 
								<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id']."_".$row['type'];?>" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
							</B>
							</div> -->
							<div class="list-mail mt-3">
								<div class="mail-contents-subject">
									<input type="checkbox" name="msg" id="mail20" class="mail-choice" checked="">
									<label class="mail-choice-label<?php echo $check_label; ?>" for="mail20"></label>
									<div class="mail-contents-title  col-xl-10 pl-0"><?php echo $row['sub_lebel'];?></div>
									
								</div>
								<?php if( isset($row['status']) ){  ?>
									<div class="mail">
										<div class='assignee pt-3'>
												<strong>สถานะ : </strong> <?php  echo $status_display ; ?>
										</div>
									</div>
								<?php } ?> 
								
								<div class="mail pt-3" id="">
									<div class="mail-contents-title  col-xl-10 pl-0"><button class="badge badge-secondary" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id']."_".$row['type'];?>" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none">รายละเอียด</button></div>
								</div>
							</div>
							<?php
						}elseif( $type_sub_lebel != $row['type'] . "_" . $row['level_id'] ){
							if( $row['type'] == "measure"){
								$type_display = "เกณฑ์คะแนน";
							}elseif( $row['type']== "control"){
								$type_display = "เกณฑ์บังคับ";
							}else{
								$type_display = $row['type'];
							}
							?>
							<?php 
							echo " 
							<script type='text/JavaScript'>
							document.getElementById('$label_var').insertAdjacentHTML('afterend',
                			'<label id=\"". $row['level_id'].$row['type']."\" class=\"mail-choice-label".$check_label."\" for=\"mail20\"></label>');
							document.getElementById('$status_var').insertAdjacentHTML('afterend',
							'<div id=\"status_".$row['level_id'].$row['type']."\" class=\"mail\">". $type_display." <strong> สถานะ : </strong>  ". $status_display ." </div> ');
							</script> " ; ?>
							<button class="badge badge<?php echo $badge_color; ?>" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'] ."_".$row['type'];?>" ><?php echo $type_display;?></button>
							<?php

						}
						?>  
				<div class="collapse" id="collapseExample<?php echo $row['level_id']."_".$row['type'];?>">
					<?php
					if( strtolower($row['set_lebel']) == 'guidelines' ){
						$txt_type = " " ;
					
						if( !is_null($row['score_des']) ){
							$txt_type = " : ".$row['score_des'];

						}
					?>
					<div class="mail-contents">
						<div class="mail-contents-subject">
							<input type="checkbox" name="msg" id="mail20" class="mail-choice" checked>
							<label class="mail-choice-label<?php echo $check_label; ?>"></label>
							<div class="mail-contents-title col-xl-8 pl-0"><?php echo $type_display . $txt_type ; ?></div>
						</div>
						

					<?php
					}else{
						?>
					<div class="mail-contents">
							<?php

						}
							$app_list_id = "0";
							$app_score_id = "0";
							$txt_ = "";
							$txt_user_add = "";

							$fetchdata2 = new DB_con();
							$sql2 = $fetchdata->fetch_transaction_list_level2($user_id,$row['level_id'] );
							if( mysqli_num_rows($sql2) != 0 ){
							
							while($row_list = mysqli_fetch_array($sql2)) { 
								if( $row_list['status'] == "consider" ){
									?>

										<div class="mail-inside">                                         
											<div class="mail-contents-body pl-0 col-8">
														
															<p class="mb-0"><?php echo $row_list['list_label'];?> <br>
															</p>
															<div class="item2">
																<table class="table" border="0" cellspacing="1" cellpadding="1">
																<tr>
																	<td scope="col" height="15">รายละเอียด : </td>
																	<td  height="15"><?php echo $row_list['remark'];?></td>
																</tr>
																<tr>
																	<td >ไฟล์แนบ :</td>
																	<td height="15"><a href="./useraddfile/<?php echo $row_list['save_filename'];?>" target="_blank"><?php echo $row_list['ori_filename'];?></a></td>
																</tr>
																<tr>
																	<td>ข้อคิดเห็น :</td>
																	<td><textarea name="comment" id="comment_<?php echo $row_list['t_id'];?>" cols="40"  style="overflow:hidden"></textarea></td>
																</tr>
																<tr>
																	<td  height="10"></td>
																	<td  height="10"></td>
																</tr>
																<tr>
																	<td><input type="submit" name="approve" id="approve_<?php echo $row_list['t_id'];?>_t" class="submit" value="ผ่านอนุมัติ"></td>
																	<td><input type="submit" name="approve2" id="approve_<?php echo $row_list['t_id'];?>_t" class="submit" value="Reject"></td>
																</tr>
																</table>
															</div>
														
														
											</div>
										</div>


								<?php
								}else{
									
									if( strtolower($row_list['status']) == "pass" ){
										$app_status2 = "ผ่านการอนุมัติ";
										
									}elseif( strtolower($row_list['status']) == "reject" ){
										$app_status2 = "ไม่ผ่านการอนุมัติ";
									}

									$txt_ = $txt_ ."
									<div class='mail-checklist'>
										<div class='mail-contents-body  col-8'>
											<div class='assignee'>
												<strong>".$row_list['list_label']."</strong> 
												</div>
											<div class='assignee'>
												<span class='assign-date'> " .$row_list['remark']."</span>
											</div> 

												<div class='mail-doc'>
													

													<div class='mail-doc-wrapper'>
														<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round' class='feather feather-file-text'>
														<path d='M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z'></path>
														<path d='M14 2v6h6M16 13H8M16 17H8M10 9H8'></path></svg>
														<div class='mail-doc-detail'>
														<div class='mail-doc-name'><a href='./useraddfile/". $row_list['save_filename']."' target='_blank'>File name : ". $row_list['ori_filename']."</a></div>
														<div class='mail-doc-date'>". $row_list['date']."</div>
														</div>
													</div>
													
												</div>
												<div><strong>ข้อคิดเห็น :</strong> ". $row_list['app_remark']." </div>
												<div class='assignee'>
													<strong>สถานะการพิจารณา : </strong> ". $app_status2 ."
													<span class='assign-date ml-4'>". $row_list['app_date']." </span>
												</div>	

											<div><button type='submit' class='cancle_app' id='cancle_t_".$row_list['t_id']."'  >ยกเลิกการพิจารณา</button></div>


										</div>
									</div>
									";

								}
							?>  
								
								<?php $app_list_id = $row_list['t_id'];
									$app_score_id = $row_list['score_id'];
									
							}; 
							} ?>
							<!-- </div> -->
							<!-- fetch_user_add_list_level2 -->
							<!-- <div class="collapse" id="collapseExample<?php echo $row['level_id']."_".$row['type'];?>"> -->
							<?php 
							$fetchdata3 = new DB_con();
							$sql3 = $fetchdata3->fetch_user_add_list_level2($user_id,$row['level_id'] );
							if( mysqli_num_rows($sql3) != 0 ){
							
								while($row_list3 = mysqli_fetch_array($sql3)) { 
									
									if( strtolower($row_list3['status']) == "pass" ){
										$app_status = "ผ่านการอนุมัติ";
										
									}elseif( strtolower($row_list3['status']) == "reject" ){
										$app_status = "ไม่ผ่านการอนุมัติ";
									}

									if( $row_list3['status'] == "consider" ){
										?>

										<div class="mail-inside">
										<div class="pb-2">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-medical-fill" viewBox="0 0 16 16">
										<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-3 2v.634l.549-.317a.5.5 0 1 1 .5.866L7 7l.549.317a.5.5 0 1 1-.5.866L6.5 7.866V8.5a.5.5 0 0 1-1 0v-.634l-.549.317a.5.5 0 1 1-.5-.866L5 7l-.549-.317a.5.5 0 0 1 .5-.866l.549.317V5.5a.5.5 0 1 1 1 0zm-2 4.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm0 2h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z"></path>
										</svg> หลักฐานเพิ่มเติม  </div>                                       
										<div class="card pl-0 pr-0 col-md-10 col-xl-8">
													<div class="card-header" id="headingOne">
													<p class="mb-0"><?php echo $row_list3['list_label'];?> <br>
													</p>
													<div class="col-sm-3 col-lg-12 col-md-9">
													<table class="table table-borderless" border="0" cellspacing="1" cellpadding="1">
													<tr>
														<td scope="col" height="15">รายละเอียด : </td>
														<td height="15"><?php echo $row_list3['remark'];?></td>
													</tr>
													<tr>
														<td >ไฟล์แนบ :</td>
														<td height="15"><a href="./useraddfile/<?php echo $row_list3['save_filename'];?>" target="_blank"><?php echo $row_list3['ori_filename'];?></a></td>
													</tr>
													<tr>
														<td>ข้อคิดเห็น :</td>
														<td><textarea name="comment" id="comment_<?php echo $row_list3['add_id'];?>" cols="40" rows="4" style="overflow:hidden"></textarea></td>
													</tr>
													<tr>
														<td  height="10"></td>
														<td  height="10"></td>
													</tr>
													<tr>
														<td><input type="submit" name="approve" id="approve_<?php echo $row_list3['add_id'];?>_a" class="submit" value="ผ่านอนุมัติ"></td>
														<td><input type="submit" name="approve2" id="approve_<?php echo $row_list3['add_id'];?>_a" class="submit" value="Reject"></td>
													</tr>
													</table>
													</div>
													
													</div>
										</div>
									</div> <?php

									}else{

									$txt_user_add = $txt_user_add ."
									<div class='mail-checklist'>
										<div class='mail-contents-body  col-8'>

											<div class='assignee'>
													<strong>".$row_list3['list_label']."</strong> 
												</div>
												<div class='assignee'>
													<span class='assign-date'> " .$row_list3['remark']."</span>
												</div>

											<div class='mail-doc'>
												<div class='mail-doc-wrapper'>
													<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round' class='feather feather-file-text'>
													<path d='M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z'></path>
													<path d='M14 2v6h6M16 13H8M16 17H8M10 9H8'></path></svg>
													<div class='mail-doc-detail'>
													<div class='mail-doc-name'><a href='./useraddfile/". $row_list3['save_filename']."' target='_blank'>File name : ". $row_list3['ori_filename']."</a></div>
													<div class='mail-doc-date'>". $row_list3['date']."</div>
													</div>
												</div>
			
												
											</div>
											<div class='assignee'>
												<div><strong>ข้อคิดเห็น :</strong> ". $row_list3['app_remark']. "</div>
												<div class='assignee'>
													<strong>สถานะการพิจารณา : </strong> ". $app_status ."
													<span class='assign-date  ml-4'> ". $row_list3['app_date']. "</span>
												</div>
											</div>
											<div><button type='submit' class='cancle_app' id='cancle_u_".$row_list3['add_id']."'  >ยกเลิกการพิจารณา</button></div>
										</div>
									</div>
									";


									}
								?>  
									
									<?php 	
											$app_score_id = $row_list3['score_id'];
											
								}; 
							} ?>
								<div class="mail">
									

									<?php echo $txt_ ; ?>

									<!-- <div class="mail-assign">
										<div class="assignee">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-check" viewBox="0 0 16 16">
												<path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
												<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
											</svg><strong>1. ประกาศคำสั่งการจัดตั้งคณะทำงาน Eco Team ประกาศคำสั่งคณะทำงานเครือข่าย Eco Committee</strong> assigned to Natalie Smith.
												<span class="assign-date">25 Nov, 2019</span>
										</div>
										<div class="assignee">
											<strong>Okla Nowak</strong> added to Marketing.
											<span class="assign-date">18 Feb, 2019</span>
										</div>
										<div class="assignee">
											<strong>Okla Nowak </strong> created task.
											<span class="assign-date">18 Feb, 2019</span>
										</div>
									</div> -->

									<?php echo $txt_user_add ; ?>

									<!-- <div class="mail-doc">

										<div class="mail-doc-wrapper">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
											<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
											<path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"></path></svg>
											<div class="mail-doc-detail">
											<div class="mail-doc-name">File name : Article.docx</div>
											<div class="mail-doc-date">added 17 May, 2020</div>
											</div>
										</div>
										<div class="mail-doc-icons">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
											<path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"></path></svg>
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
											<path d="M8 17l4 4 4-4M12 12v9"></path>
											<path d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"></path></svg>
										</div>
									</div> -->

								</div>

								<div class="fs-3 mb-3 mt-3 pl-5 ">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
										<path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"></path>
									</svg>พิจารณา
								</div>
								<div class="mail">
									<div class="pl-0 pb-2">
										<div class="col-10 pb-2">ข้อคิดเห็น : <?php  echo $row['remark'] ; ?>  </div>
										<?php if( isset($row['status']) ){ 
											if($row['status'] != "cancle"){  
												$input_disable="disabled"; ?>
													<div class="col-10">สถานะ : <?php  echo $status_display ; ?> </div> 
										<?php }else{ 
												$input_disable=""; ?>
												
												
												<div><textarea name="comment" id="comment_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="col-10 col-lg-8"  rows="4" style="overflow:hidden"></textarea>
												</div>
												

										<?php } }else{ $input_disable=""; ?> 
										<div><textarea name="comment" id="comment_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="col-10 col-lg-8"  rows="4" style="overflow:hidden"></textarea>
										</div>
										<?php } ?>	
									</div>
									<div class="pb-2">
										<input type="submit" <?php echo $input_disable ;?> name="approve"  id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ผ่านอนุมัติ">
										<input type="submit" <?php echo $input_disable ;?> name="approve2" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="Reject">
										<?php if( isset($row['status']) ){  
												if($row['status'] != "cancle"){  ?>
													<input type="submit" name="cancle_<?php echo $row['app_id'];?>" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ยกเลิก">
													<input type="hidden" id="cancle_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="<?php echo $row['app_id'];?>">
											<?php }
											}
											
											
											?> 
										
									</div>	
								</div>	
				  	</div> 


							<!-- <?php
							if( !is_null($row['score_des']) ){
								
								?>
								<div class="fs-3 mb-3 mt-3 pl-5 ">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
									<path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"></path>
									</svg>พิจารณา
								</div>
								<div class="mail">
									<div class="pl-0 pb-2">
										<div class="col-10">ข้อคิดเห็น :</div>
										<?php if( isset($row['status']) ){ 
											if($row['status'] != "cancle"){  
												$input_disable="disabled"; ?>
													<div>สถานะ : <?php  echo $row['status'] ; ?> </div> 
										<?php }else{ 
												$input_disable=""; } 
										}else{ $input_disable=""; ?> 
										<div><textarea name="comment" id="comment_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="col-10 col-lg-8"  rows="4" style="overflow:hidden"></textarea>
										</div>
										<?php } ?>	
									</div>
									<div class="pb-2">
										<input type="submit" <?php echo $input_disable ;?> name="approve"  id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ผ่านอนุมัติ">
										<input type="submit" <?php echo $input_disable ;?> name="approve2" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="Reject">
										<?php if( isset($row['status']) ){  
												if($row['status'] != "cancle"){  ?>
													<input type="submit" name="cancle_<?php echo $row['app_id'];?>" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ยกเลิก">
													<input type="hidden" id="cancle_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="<?php echo $row['app_id'];?>">
											<?php }
											}
											
											
											?> 
										
									</div>	
								</div>		
				  	</div> 
						<?php

							}else{ ?>

								<div class="fs-3 mb-3 mt-3 pl-5 ">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
										<path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"></path>
									</svg>พิจารณา
								</div>
								<div class="mail">
									<div class="pl-0 pb-2">
										<div class="col-10">ข้อคิดเห็น :</div>
										<?php if( isset($row['status']) ){ $input_disable="disabled"; ?>
										<div>สถานะ : <?php  echo $row['status'] ; ?> </div> 
										<?php }else{ $input_disable=""; ?> 
										<div><textarea name="comment" id="comment_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="col-10 col-lg-8"  rows="4" style="overflow:hidden"></textarea>
										</div>
										<?php } ?>	
									</div>
									<div class="pb-2">
										<input type="submit" <?php echo $input_disable ;?> name="approve"  id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ผ่านอนุมัติ">
										<input type="submit" <?php echo $input_disable ;?> name="approve2" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="Reject">
										<?php if( isset($row['status']) ){  ?>
											<input type="submit" name="cancle_<?php echo $row['app_id'];?>" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ยกเลิก" >
											<input type="hidden" id="cancle_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="<?php echo $row['app_id'];?>">
						
										<?php } ?> 
										
									</div>	
								</div>
						
									

				  </div>
				  <?php } 
				  
				  ?> -->
				</div>
				<input type="hidden" id="scoredes_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="<?php if(isset($row['score_des'])){echo $row['score_des'];}else{ echo "" ;} ?>">
				<input type="hidden" id="point_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="<?php if(isset($row['point'])){echo $row['point'];}else{ echo "" ;} ?>">

			<?php 
			$sub_lebel = $row['sub_lebel'] ;
			$type_sub_lebel = $row['type'] . "_" . $row['level_id'] ;
			}; 
			 }else{ echo "ไม่มีรายการ"; } ?>	
				

      <?php }; ?>
	
</div>
 


</body>
<script>
$(document).ready(function() {
	$('.submit').on('click', function() {

		// $("#submit").attr("disabled", "disabled");
		var id = this.id;
  		var splitid = id.split('_');
  		var index = splitid[1];
		var input_type = splitid[2]; // ดูค่าหลัง _ ที่ 2 ว่าเป็น t หรือ a ( t = เพิ่มในตาราง aprove , a = เพิ่มในตาราง aprove_user_add)
		var approve_action = this.value;
		
		console.log(id);
		console.log(index);
		console.log(approve_action);

		var comment = $('#comment_'+index).val();
		console.log(comment);


		var audit = $('#audit').val();
		if(index!="" && approve_action!="" && audit!=""){
			$.ajax({
				url: "update2.php",
				type: "POST",
				data: {
					t_id: index,
					comment: comment,
					approve_action: approve_action,
					audit: audit,
					input_type: input_type				
				},
				cache: false,

				// success: function(dataResult){
				// 	var dataResult = JSON.parse(dataResult);
				// 	if(dataResult.statusCode==1){
				// 		// alert("บันทึกเรียบร้อยแล้ว");
				// 		// window.location.reload();
				// 		// window.location.replace("approve.php");

				// 		console.log('refresh');
            	// 		location.reload();
						
				// 		// $("#butsave").removeAttr("disabled");
				// 		// $('#fupForm').find('input:text').val('');
				// 		// $("#success").show();
				// 		// $('#success').html('Data added successfully !'); 						
				// 	}
				// 	else if(dataResult.statusCode==0){
				// 	   alert("Error occured !");
				// 	}
					
				// }

				success: function (data) {
					if (data === '1') {
						alert(" บันทึกการตรวจพิจารณาสำเร็จ !  ");
						window.history.back();
						location.reload(); 
					}
					else {
						alert("  ไม่สามารถบันทึกข้อมูลได้ !");
					}
				},
				error: function ()
				{
					alert("ไม่สามารถบันทึกข้อมูลได้ !");
				}
			});
		}
		else{
			alert('error !');
		}
	});

	$('.submit_app').on('click', function() {

			// $("#submit").attr("disabled", "disabled");
			var id = this.id;
			var splitid = id.split('_');
			var input_type = splitid[1]; // comment_measure ดูค่าหลัง _ ที่ 1 ว่าเป็น measure หรือ control ( t = เพิ่มในตาราง aprove , a = เพิ่มในตาราง aprove_user_add)
			var level_id = splitid[2];
			var score_id = splitid[3];
			var approve_action = this.value;

			//var cancle_id = this.attr('name');
			var cancle_app_id = 0;
		
			if( this.value === "ยกเลิก"){
				//console.log("C:"+cancle_id); 
				cancle_app_id = $('#cancle_'+input_type+'_'+level_id+'_'+score_id).val();
				console.log("C2:"+cancle_app_id);
				input_type = "cancle"; 
			}

			console.log(input_type);
			console.log(level_id);
			console.log(score_id);
			console.log(approve_action);

			var comment = $('#comment_'+input_type+'_'+level_id+'_'+score_id).val();
			console.log(comment);

			var point = $('#point_'+input_type+'_'+level_id+'_'+score_id).val();
			console.log(point);
			
			var score_des = $('#scoredes_'+input_type+'_'+level_id+'_'+score_id).val();
			console.log("score:"+score_des);

			var audit = $('#audit').val();
			var user_id = $('#user').val();
			if(input_type!="" && approve_action!="" && audit!="" && user_id!=""){
				$.ajax({
					url: "update3.php",
					type: "POST",
					data: {
						level_id: level_id,
						score_id: score_id,
						comment: comment,
						approve_action: approve_action,
						audit: audit,
						user_id: user_id,
						input_type: input_type,
						point : point,
						score_des : score_des,
						cancle_app_id : cancle_app_id 				
					},
					cache: false,

					// success: function(dataResult){
					// 	var dataResult = JSON.parse(dataResult);
					// 	if(dataResult.statusCode==1){
					// 		// alert("บันทึกเรียบร้อยแล้ว");
					// 		// window.location.reload();
					// 		// window.location.replace("approve.php");

					// 		console.log('refresh');
					// 		location.reload();
							
					// 		// $("#butsave").removeAttr("disabled");
					// 		// $('#fupForm').find('input:text').val('');
					// 		// $("#success").show();
					// 		// $('#success').html('Data added successfully !'); 						
					// 	}
					// 	else if(dataResult.statusCode==0){
					// 	   alert("Error occured !");
					// 	}
						
					// }

					success: function (data) {
						
						if (data === '1') {
							alert(" บันทึกการตรวจพิจารณาสำเร็จ !  ");
							window.history.back();
							location.reload(); 
						}
						else {
							alert("  ไม่สามารถบันทึกข้อมูลได้ ! " );
						}
					},
					error: function ()
					{
						alert("ไม่สามารถบันทึกข้อมูลได้ !");
					}
				});
			}
			else{
				alert('error !');
			}
	});

	$('.cancle_app').on('click', function() {

			// $("#submit").attr("disabled", "disabled");
			var id = this.id;
			var splitid = id.split('_');
			var input_type = splitid[1]; // comment_measure ดูค่าหลัง _ ที่ 1 ว่าเป็น transaction หรือ user_add_file ( T = ลบในตาราง aprove , u = ลบในตาราง aprove_user_add)
			var app_id = splitid[2];

			console.log(input_type);
			console.log(app_id);


			var audit = $('#audit').val();
			var user_id = $('#user').val();
			if(input_type!="" && app_id!="" ){
				$.ajax({
					url: "update4.php",
					type: "POST",
					data: {
						app_id: app_id,
						input_type: input_type
					},
					cache: false,

					success: function (data) {
						
						
							alert(data);
							window.history.back();
							location.reload(); 
						
					},
					error: function ()
					{
						alert("ระบบขัดข้อง !");
					}
				});
			}
			else{
				alert('error !');
			}
	});
});
</script>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
ob_end_flush();
?>