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
			<div class="col-12">
			<?php
				if(isset($_GET['set_lebel'])){
					$set_lebel = $_GET['set_lebel'];
				}else{
					$set_lebel = "" ;
				} 

				
				$fetchdata = new DB_con();
				$sql = $fetchdata->fetch_transaction_list_level($user_id ,$set_lebel);
				
				if(!empty($sql)  ){
					
				$sub_lebel = "" ;
				while($row = mysqli_fetch_array($sql)) { 
				$app_level_id = $row['level_id'];
				if( !isset($_GET['set_lebel'])){

				$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				header("Refresh:0; url=".$actual_link."&set_lebel=".$row['set_lebel']);
				//echo $actual_link."&set_lebel=".$row['set_lebel'];
				}

			   ?>
					<?php
						
						if( ( strtolower($sub_lebel) != strtolower($row['sub_lebel'])) AND ( strtolower($row['set_lebel']) == 'guidelines' )  ){
						if( $row['type'] == "measure"){
							$type_display = "เกณฑ์คะแนน";
						}elseif( $row['type']== "control"){
							$type_display = "เกณฑ์บังคับ";
						}else{
							$type_display = $row['type'];
						}
						?>

						<div class="list-mail mt-3">
							<B><?php echo $row['sub_lebel'];?></B>
						</div>
	
						<button class="badge badge-secondary" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'] ."_".$row['type'];?>" ><?php echo $type_display;?></button>
						<?php 
						}elseif( strtolower($row['set_lebel']) != 'guidelines' ){
							?>
							 
							<div class="list-mail">
							<B><?php echo $row['sub_lebel'];?> 
								<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id']."_".$row['type'];?>" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
							</B>
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
							
							<button class="badge badge-secondary" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'] ."_".$row['type'];?>" ><?php echo $type_display;?></button>
							<?php

						}
						?>  
				<div class="collapse" id="collapseExample<?php echo $row['level_id']."_".$row['type'];?>">
					<?php
					if( !is_null($row['score_des']) ){
					?>
					<div class="mail-contents">
						<div class="mail-contents-subject">
							<input type="checkbox" name="msg" id="mail20" class="mail-choice" checked>
							<label class="mail-choice-label"></label>
							<div class="mail-contents-title"><?php echo $type_display;?> : <?php echo $row['score_des'] ; ?></div>
						</div>
						

					<?php
					}else{
						?>
					<div class="mail-contents">
							<?php

					}
					$app_list_id = "0";
					$app_score_id = "0";

					$fetchdata2 = new DB_con();
					$sql2 = $fetchdata->fetch_transaction_list_level2($user_id,$row['level_id'] );
					if( mysqli_num_rows($sql2) != 0 ){
					 
					while($row_list = mysqli_fetch_array($sql2)) { 
					?>  
						<div class="mail-inside">                                         
							<div class="mail-contents-body">
										
											<p class="mb-0"><?php echo $row_list['list_label'];?> <br>
											</p>
											<div class="item2">
												<table width="95%" border="0" cellspacing="1" cellpadding="1">
												<tr>
													<td width="25%" height="15">รายละเอียด :</td>
													<td width="75%" height="15"><?php echo $row_list['remark'];?></td>
												</tr>
												<tr>
													<td height="15">ไฟล์แนบ :</td>
													<td height="15"><a href="./useraddfile/<?php echo $row_list['save_filename'];?>" target="_blank"><?php echo $row_list['ori_filename'];?></a></td>
												</tr>
												<tr>
													<td>ข้อคิดเห็น :</td>
													<td><textarea name="comment" id="comment_<?php echo $row_list['t_id'];?>" cols="40"  style="overflow:hidden"></textarea></td>
												</tr>
												<tr>
													<td width="25%" height="10"></td>
													<td width="75%" height="10"></td>
												</tr>
												<tr>
													<td><input type="submit" name="approve" id="approve_<?php echo $row_list['t_id'];?>_t" class="submit" value="ผ่านอนุมัติ"></td>
													<td><input type="submit" name="approve2" id="approve_<?php echo $row_list['t_id'];?>_t" class="submit" value="Reject"></td>
												</tr>
												</table>
											</div>
										
										
							</div>
						</div>
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
						?>  
							<div class="mail-contents">
								<div class="pb-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-medical-fill" viewBox="0 0 16 16">
  								<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-3 2v.634l.549-.317a.5.5 0 1 1 .5.866L7 7l.549.317a.5.5 0 1 1-.5.866L6.5 7.866V8.5a.5.5 0 0 1-1 0v-.634l-.549.317a.5.5 0 1 1-.5-.866L5 7l-.549-.317a.5.5 0 0 1 .5-.866l.549.317V5.5a.5.5 0 1 1 1 0zm-2 4.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm0 2h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z"></path>
								</svg> หลักฐานเพิ่มเติม  </div>                                       
								<div class="card">
											<div class="card-header" id="headingOne">
											<p class="mb-0"><?php echo $row_list3['list_label'];?> <br>
											</p>
											<div class="item2">
											<table width="95%" border="0" cellspacing="1" cellpadding="1">
											<tr>
												<td width="25%" height="15">รายละเอียด :</td>
												<td width="75%" height="15"><?php echo $row_list3['remark'];?></td>
											</tr>
											<tr>
												<td height="15">ไฟล์แนบ :</td>
												<td height="15"><a href="./useraddfile/<?php echo $row_list3['save_filename'];?>" target="_blank"><?php echo $row_list3['ori_filename'];?></a></td>
											</tr>
											<tr>
												<td>ข้อคิดเห็น :</td>
												<td><textarea name="comment" id="comment_<?php echo $row_list3['add_id'];?>" cols="40" rows="4" style="overflow:hidden"></textarea></td>
											</tr>
											<tr>
												<td width="25%" height="10"></td>
												<td width="75%" height="10"></td>
											</tr>
											<tr>
												<td><input type="submit" name="approve" id="approve_<?php echo $row_list3['add_id'];?>_a" class="submit" value="ผ่านอนุมัติ"></td>
												<td><input type="submit" name="approve2" id="approve_<?php echo $row_list3['add_id'];?>_a" class="submit" value="Reject"></td>
											</tr>
											</table>
											</div>
											
											</div>
								</div>
							</div>
							<?php 	
									$app_score_id = $row_list3['score_id'];
									
						}; 
					} 
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
								<div><textarea name="comment" id="comment_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="col-10 col-lg-8"  rows="4" style="overflow:hidden"></textarea>
								</div>
							</div>
							<div class="pb-2">
								<input type="submit" name="approve" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ผ่านอนุมัติ">
								<input type="submit" name="approve2" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="Reject">
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
								<div><textarea name="comment" id="comment_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="col-10"  rows="4" style="overflow:hidden"></textarea>
								</div>
							</div>
							<div class="pb-2">
								<input type="submit" name="approve" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="ผ่านอนุมัติ">
								<input type="submit" name="approve2" id="approve_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" class="submit_app" value="Reject">
							</div>	
						</div>
				  </div>
				  <?php } ?>
				</div>
				<input type="hidden" id="scoredes_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="2<?php if(isset($row['score_des'])){echo $row['score_des'];}else{ echo "" ;} ?>">
				<input type="hidden" id="point_<?php echo $row['type'];?>_<?php echo $app_level_id."_".$app_score_id;?>" value="<?php echo $row['point']; ?>">

			<?php 
			$sub_lebel = $row['sub_lebel'] ;
			$type_sub_lebel = $row['type'] . "_" . $row['level_id'] ;
			}; 
			 }else{ echo "ไม่มีรายการ"; } ?>	
				

      <?php }; ?>
	</div>
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

			console.log(input_type);
			console.log(level_id);
			console.log(score_id);
			console.log(approve_action);

			var comment = $('#comment_'+input_type+'_'+level_id+'_'+score_id).val();
			console.log(comment);

			var point = $('#point_'+input_type+'_'+level_id+'_'+score_id).val();
			console.log(point);
			
			var score_des = $('#scoredes_'+input_type+'_'+level_id+'_'+score_id).val();
			console.log(score_des);

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
						score_des : score_des				
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
						alert("2 ไม่สามารถบันทึกข้อมูลได้ !");
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