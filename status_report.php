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
<title>Status Report</title>

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
      <h1>สถานะการส่งพิจารณา : </h1>

    </header>

		<div class="content-columns">
			
			<div class="col" >
					
							  <table width="97%" border="0" cellpadding="0" cellspacing="0">
								<thead>
									<tr class="bg-info">
									  <th width="88%" height="29" scope="col-lg-2 col-md-4 "><font color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียด</font></th>
										<th width="12%" scope="col-lg-4 col-md-5"><font color="#FFFFFF">สถานะ</font></th>
									</tr>
								</thead>
								  <tbody>
								  <tr>
									<th colspan="2" align="left" scope="row">
									<div class="item"><b><font style="color:2874A6;">เงื่อนไขเบื้องต้น</font></b>
									<?php 	$fetchdata = new DB_con();
											$sql = $fetchdata->basic_report($_SESSION['id']);
											while($row = mysqli_fetch_array($sql)) {
									?>									
									<div class="item2"><font style="font-size:14px;"><?php echo $row['sub_lebel']; ?></font><br>
									    <table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tbody>
											  <?php	$fetchdata2 = new DB_con();
													$sql2 = $fetchdata2->basic_report_tran($row['level_id'],$_SESSION['id']);
													while($row2 = mysqli_fetch_array($sql2)) { 
											  ?>
										    <tr>
												<td width="87%" height="30"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row2['list_label'];?></font></td>
											  <td width="13%" height="30" align="center" valign="top"><a href="eco_level.php?level_label=<?php echo $row['level_label'];?>&set_lebel=<?php echo $row['set_lebel'];?>#accordion<?php echo $row['level_id']; ?>">
												<?php if ($row2['status']=="save") {echo "<span class='alert-warning'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";} 
													elseif ($row2['status']=="consider") {echo "<span class='alert-primary'>&nbsp;รอพิจารณา&nbsp;</span>";} 
													elseif ($row2['status']=="pass") {echo "<span class='alert-success'>ผ่านพิจารณา</span>";}
													elseif ($row2['status']=="reject") {echo "<span class='alert-danger'>&nbsp;&nbsp;&nbsp;ไม่อนุมัติ&nbsp;&nbsp;&nbsp;</span>";}
													else {echo "-";}?></a>
											  </td>
										    </tr>
											  <?php }//------------select basic user manual add------------------?>
										  </tbody>
									    </table>
									  </div>
										<?php } ?>
									</div>
									 <!-----------------------end select from basic-----------------------------> 
									<div class="item"> 
									<?php 	$fetchdata = new DB_con();
										$sql = $fetchdata->control_report($_SESSION['id']);
										$score_count = 0;
										
										while($row = mysqli_fetch_array($sql)) {;
											//-------------- if change sub_lebel----------------
											$i = 0;
											if ($row['sub_lebel']!=$sub_lebel_before) {
											echo $row['sub_lebel'].'<br>';
											?>
											<div class="item2">

											<?php //--------------------control ----------------------
											if ($row['type']=="control") {
											echo "<b><font style='color:2874A6;'>เกณฑ์บังคับ</font></b><br>"; 
											} else {echo "<b><font style='color:2874A6;'>เกณฑ์คะแนน</font></b>&nbsp;&nbsp;";
													$fetchdata4 = new DB_con();
													$fetchdata3 = new DB_con();
													//echo $row['level_id'];
													$result4 = $fetchdata4->select_uadd_scoredes($row['level_id'],$_SESSION['id']);
													$num4 = mysqli_fetch_array($result4);
													$result2 = $fetchdata3->select_scoredes($row['level_id'],$_SESSION['id']);
													$num2 = mysqli_fetch_array($result2);
													//echo $row['type'];
													if ($row['type']=='measure' and $num4['score_des']!= "" ) {
													echo "<font style='color:28B463;'> #".$num4['score_des']."</font><br>";}
													else {echo "<font style='color:28B463;'> #".$num2['score_des']."</font><br>";} }
													
													?>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tbody>  
											<?php	$fetchdata2 = new DB_con();
													$fetchdata12 = new DB_con();
													$sql2 = $fetchdata2->basic_report_tran($row['level_id'],$_SESSION['id']);
													$sql12 = $fetchdata12->count_basic_report_tran($row['level_id'],$_SESSION['id']);
													$row12 = mysqli_fetch_array($sql12);
													$total_count = $row12['tran_total_count'];
													//echo "total_tran_count =".$total_count;
													while($row2 = mysqli_fetch_array($sql2)) { 
													$i++;
													//echo $i;
													//$temp_list_id=$row2['level_id'];
											  ?>
												<tr>
												  <td width="87%" height="30"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row2['list_label'];?></font></td>
												  <td width="13%" height="30" align="center" valign="top"><a href="eco_level.php?level_label=<?php echo $row['level_label'];?>&set_lebel=<?php echo $row['set_lebel'];?>#accordion<?php echo $row['level_id']; ?>"><?php if ($row2['status']=="save") {echo "<span class='alert-warning'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";} 
													elseif ($row2['status']=="consider") {echo "<span class='alert-primary'>&nbsp;รอพิจารณา&nbsp;</span>";} 
													elseif ($row2['status']=="pass") {echo "<span class='alert-success'>ผ่านพิจารณา</span>";}
													elseif ($row2['status']=="reject") {echo "<span class='alert-danger'>&nbsp;&nbsp;&nbsp;ไม่อนุมัติ&nbsp;&nbsp;&nbsp;</span>";}
													else {echo "-";}
													?></a></td>
												</tr>
											<?php }//------------select control user manual add------------------?>
											<?php 	//echo "row_sublebel=".$row['sub_lebel']."<br>";
													//echo "sub_lebel_before=".$sub_lebel_before."<br>";
													//echo "row_type=".$row['type']."<br>";
													//echo "row_type_before=".$type_before."<br>";
													
												  if (($row['sub_lebel']==$sub_lebel_before) || ( ($row['sub_lebel']!=$sub_lebel_before) and ( $row['type'] != $type_before ) ) || ( ($row['sub_lebel']!=$sub_lebel_before) and ( $row['type'] == $type_before ) ) ) {
											?></tbody>
											</table>											
												  <?php }} //---------------measure---------------------------
											elseif ($row['sub_lebel']==$sub_lebel_before){echo "<div class='item2'><b><font style='color:2874A6;'>เกณฑ์คะแนน</font></b>&nbsp;&nbsp;"; ?>
											<?php 	$fetchdata3 = new DB_con();
													$fetchdata4 = new DB_con();
													//echo $row['level_id'];
													$result2 = $fetchdata3->select_scoredes($row['level_id'],$_SESSION['id']);
													$num2 = mysqli_fetch_array($result2);
													$result4 = $fetchdata4->select_uadd_scoredes($row['level_id'],$_SESSION['id']);
													$num4 = mysqli_fetch_array($result4);
													if ($row['type']=='measure' and $num4['score_des']!= "" ) {
													echo "<font style='color:28B463;'> #".$num4['score_des']."</font><br>";}
													else {echo "<font style='color:28B463;'> #".$num2['score_des']."</font><br>";}?> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tbody>  
											<?php	$fetchdata2 = new DB_con();
													$fetchdata12 = new DB_con();
													$sql2 = $fetchdata2->basic_report_tran($row['level_id'],$_SESSION['id']);
													$sql12 = $fetchdata12->count_basic_report_tran($row['level_id'],$_SESSION['id']);
													$row12 = mysqli_fetch_array($sql12);
													$total_count = $row12['tran_total_count'];
													
													while($row2 = mysqli_fetch_array($sql2)) { 
													$i++;
													
											  ?>
												<tr>
												  <td width="87%" height="30"><font style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row2['list_label'];?></font></td>
												  <td width="13%" height="30" align="center" valign="top"><a href="eco_level.php?level_label=<?php echo $row['level_label'];?>&set_lebel=<?php echo $row['set_lebel'];?>#accordion<?php echo $row['level_id']; ?>"><?php if ($row2['status']=="save") {echo "<span class='alert-warning'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";} 
													elseif ($row2['status']=="consider") {echo "<span class='alert-primary'>&nbsp;รอพิจารณา&nbsp;</span>";} 
													elseif ($row2['status']=="pass") {echo "<span class='alert-success'>ผ่านพิจารณา</span>";}
													elseif ($row2['status']=="reject") {echo "<span class='alert-danger'>&nbsp;&nbsp;&nbsp;ไม่อนุมัติ&nbsp;&nbsp;&nbsp;</span>";}
													else {echo "-";}
													?></a></td>
												</tr>
											<?php }//------------select measure user manul add-------------------?>
													
											</tbody>
											</table>										
											
											<?php ;}  
											//---------------end change sub lebel---------------?>
											<?php 
														//echo "row_sublebel=".$row['sub_lebel']."<br>";
														//echo "sub_lebel_before=".$sub_lebel_before."<br>";
														//echo "row_type=".$row['type']."<br>";
														//echo "row_type_before=".$type_before."<br>";
														//if ($row['type']!=$type_before) {echo "ไม่เท่ากัน";} else {echo "เท่ากัน";}
											//if ( (($row['sub_lebel']!=$sub_lebel_before) and ($sub_lebel_before!='') and ($type_before=='') ) || ( ($row['sub_lebel']==$sub_lebel_before)) || ($row['type']=='measure') || ( ($row['sub_lebel']!=$sub_lebel_before) and ($row['type']!=$type_before) and ($type_before!='') and ($row['type']=='measure') ) || (($row['sub_lebel']!=$sub_lebel_before) and ($row['type']!=$type_before) and ($sub_lebel_before!='') and ($type_before!='') and ( substr($sub_lebel_before,0,2) != '1.')) || (($row['sub_lebel']!=$sub_lebel_before) and ($type_before=='') and ($sub_lebel_before=='') and ($row['type']=='measure') )  ) { echo '</div>';}
											if ( ($total_count == $i) ) { echo '</div>';}
											?>
											
							
									<?php $sub_lebel_before = $row['sub_lebel'];
										  $type_before = $row['type'];} ?>
									 </div>
									 <!-----------------------end select from control----------------------------->
									
									
									 <!-----------------------end select from measure----------------------------->
								    </th>
									</tr>
							        <tr>
									<th colspan="2" align="left" scope="row">&nbsp;</th>
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