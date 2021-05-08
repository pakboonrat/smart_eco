<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "USER") {
    include_once('function.php');

?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>Summary Status Report</title>

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
      <h1>รายงานสรุปผล : &nbsp;<?php echo $_SESSION['fname']; ?></h1>

    </header>
		<div class="content-columns">
			<div class="col" >
				  <table width="90%" border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr class="bg-info">
						  <th width="84%" height="29" align="left" scope="col-lg-2 col-md-4 "><font color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียด</font></th>
						  <th width="16%" scope="col-lg-4 col-md-5"><font color="#FFFFFF">&nbsp;สถานะ/คะแนน</font></th>
						</tr>
					</thead>
					  <tbody>
						  <tr>
						  
							<tr>
							<td colspan="2">
								<div class="item">
									
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-hover">
								 <tbody>
									<?php $fetchdata = new DB_con();
										$sql = $fetchdata->fetch_allrules($_SESSION['id']);
										$point_count = 0;
										while($row = mysqli_fetch_array($sql)) {
											
											if (($row['type']=="-") and ($type_before!=$row['type']) ) {
												?>
												<tr>
												<td><h5 style="color:#019128;"><b><?php if ($row['level_label']=="eco_champion") {echo "Eco-Champion";} elseif ($row['level_label']=="eco_excellence") {echo "Eco-Excellence";} elseif ($row['level_label']=="eco_worldclass") {echo "Eco-World Class";};?></b></h5></td>
												</tr>
												<tr>
												<td height="30" colspan="2"><b><font style="color:2874A6;">เงื่อนไขเบื้องต้น</font></b></td>
												</tr>
											<?php } elseif ($row['type']=="control" and ($type_before!=$row['type'])) { ?>
												<?php if ($row['sub_lebel']!=$sub_lebel_before) {												
												?>												
												<tr>
												<td colspan="2" height="30"><b><font style="color:2874A6;"><?php echo $row['sub_lebel'];?></font></b></td>
												</tr>
												<?php }?>
												<tr>
												<td height="25"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เกณฑ์บังคับ</font></td>
												 <td width="15%" align="center"><?php  	$fetch_score_status = new DB_con();
																						$sql2 = $fetch_score_status->sel_score_status($row['level_id'],$_SESSION['id']);
																						$num2 = mysqli_fetch_array($sql2);
																						if ($num2['status']== "pass"){
																						echo "<span class='alert-success'>&nbsp;&nbsp;ผ่านพิจารณา&nbsp;&nbsp;</span>";}
																						elseif ($num2['status']== "reject") {echo "<span class='alert-danger'>ไม่ผ่านพิจารณา</span>";}
																						elseif ($num2['status']== "") {echo "-";}
																						
																						 
												 ?></td>
												</tr>
											<?php } elseif ($row['type']=="measure") {?>
												<?php if ($sub_lebel_before!=$row['sub_lebel']) {	?>
												<?php if ($level_label_before!=$row['level_label']) { ?>
												<tr>
												<td><hr><h5 style="color:#019128;"><b><?php if ($row['level_label']=="eco_champion") {echo "Eco-Champion";} elseif ($row['level_label']=="eco_excellence") {echo "Eco-Excellence";} elseif ($row['level_label']=="eco_worldclass") {echo "Eco-World Class";};?></b></h5></td>
												</tr>
												<?php }?>
												<tr>
												<td colspan="2" height="30"><b><font style="color:2874A6;"><?php echo $row['sub_lebel'];?></font></b></td>
												</tr>
												<?php }?>
												<tr>
												<td height="25"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เกณฑ์คะแนน</font></td>
												 <td width="15%" align="center"><?php  	$fetch_score_status = new DB_con();
																						$sql2 = $fetch_score_status->sel_score_status($row['level_id'],$_SESSION['id']);
																						$num2 = mysqli_fetch_array($sql2);
																						if (($num2['point']!= "") and ($num2['status']!= "reject")){
																						echo "<span class='alert-success'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$num2['point']."&nbsp;คะแนน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
																						$point_count = $point_count + $num2['point']; }
																						elseif (($num2['point']!= "") and ($num2['status']== "reject")) {echo "<span class='alert-danger'>ไม่ผ่านพิจารณา</span>";}
																						else {echo "-";}
																						
																						 
												 ?></td>
												</tr>
											<?php } else if($row['type']=="control" and ($sub_lebel_before!=$row['sub_lebel']) ) { ?>
											
												<?php if ($level_label_before!=$row['level_label']) { ?>
												<tr>
												<td><hr><h5 style="color:#019128;"><b><?php if ($row['level_label']=="eco_champion") {echo "Eco-Champion";} elseif ($row['level_label']=="eco_excellence") {echo "Eco-Excellence";} elseif ($row['level_label']=="eco_worldclass") {echo "Eco-World Class";};?></b></h5></td>
												</tr>
												<?php }?>
												
												<tr>
												<td colspan="2" height="30"><b><font style="color:2874A6;"><?php echo $row['sub_lebel'];?></font></b></td>
												</tr>
												<tr>
												<td height="25"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เกณฑ์บังคับ</font></td>
												 <td width="15%" align="center"><?php  	$fetch_score_status = new DB_con();
																						$sql2 = $fetch_score_status->sel_score_status($row['level_id'],$_SESSION['id']);
																						$num2 = mysqli_fetch_array($sql2);
																						if ($num2['status']== "pass"){
																						echo "<span class='alert-success'>&nbsp;&nbsp;ผ่านพิจารณา&nbsp;&nbsp;</span>";}
																						elseif ($num2['status']== "reject") {echo "<span class='alert-danger'>ไม่ผ่านพิจารณา</span>";}
																						elseif ($num2['status']== "") {echo "-";}
																						
																						 
												 ?></td>
												</tr>
											<?php } ?>
										<?php if (($row['type']!="control") and ($row['type']!="measure")) {?>
									<tr>
									  <td width="85%" height="30"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo iconv_substr($row['sub_lebel'], 0, 90, 'utf-8');?>...</font></td>
									  <td width="15%" align="center"><?php  	$fetch_score_status = new DB_con();
																				$sql2 = $fetch_score_status->sel_score_status($row['level_id'],$_SESSION['id']);
																				$num2 = mysqli_fetch_array($sql2);
																				if ($num2['status']== "pass"){
																				echo "<span class='alert-success'>&nbsp;&nbsp;ผ่านพิจารณา&nbsp;&nbsp;</span>";}
																				elseif ($num2['status']== "reject") {echo "<span class='alert-danger'>ไม่ผ่านพิจารณา</span>";}
																				elseif ($num2['status']== "") {echo "-";}
																						
																						 
												 ?></td>
									</tr>
										<?php }?>
										<?php 	$type_before =$row['type'];
												$sub_lebel_before =$row['sub_lebel'];
												$level_label_before = $row['level_label'];
												}?>
								 </tbody>
								</table>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="85%" height="35" align="right" valign="bottom">รวมคะแนนทั้งหมด :&nbsp;</td>
      <td width="15%" height="35" align="center" valign="bottom"><?php echo "&nbsp;".$point_count."&nbsp;คะแนน"?></td>
    </tr>
  </tbody>
</table>

								</div>
							</td>
							</tr>
						  </tr>
					  </tbody>
				</table>
			  </div>
		  
</div>
</body>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
?>