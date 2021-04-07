<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "AUDITOR") {
    include_once('function.php');

	$user_id = $_GET["userid"] ;

?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>Auditor Approve</title>
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
      <h1>ตรวจพิจารณา : นิคมฯ อัญธานี </h1>
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
            $sql = $updatelevel->fetch_level_header($level_label);
            $set_lebel_array = array();
            $active_class = "class=\"active\" " ;
            while($row = mysqli_fetch_array($sql)) {
            array_push($set_lebel_array,$row['set_lebel']);
            $i = 0;
            
        ?>
        <a href="aprove.php?level_label=<?php echo $level_label; ?>&set_lebel=<?php echo $row['set_lebel']; ?>" <?php 
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
    <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>     
			<div class="col">
			<?php 
				$fetchdata = new DB_con();
				$sql = $fetchdata->fetch_transaction_list_level($user_id);
				if( mysqli_num_rows($sql) != 0 ){
				 
				while($row = mysqli_fetch_array($sql)) { 
			   ?>   
				<div class="item">
					<B><?php echo $row['sub_lebel'];?> 
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'];?>" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
					</B>
				</div>
				
				  
				<div class="collapse" id="collapseExample<?php echo $row['level_id'];?>">
					<?php 
					$fetchdata2 = new DB_con();
					$sql2 = $fetchdata->fetch_transaction_list_level2($user_id,$row['level_id'] );
					if( mysqli_num_rows($sql2) != 0 ){
					 
					while($row_list = mysqli_fetch_array($sql2)) { 
				?>  
						<div class="item2">                                         
							<div class="card">
										<div class="card-header" id="headingOne">
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
											<td height="15"><a href="./useraddfile/<?php echo $row_list['save_filename'];?>"><?php echo $row_list['save_filename'];?></a></td>
										</tr>
										<tr>
											<td>ข้อคิดเห็น :</td>
											<td><textarea name="comment" id="comment" cols="40" rows="4" style="overflow:hidden"></textarea></td>
										</tr>
										<tr>
											<td width="25%" height="10"></td>
											<td width="75%" height="10"></td>
										</tr>
										<tr>
											<td><input type="submit" name="approve" id="approve" value="ผ่านอนุมัติ"></td>
											<td><input type="submit" name="approve2" id="approve2" value="&nbsp;Reject&nbsp;"></td>
										</tr>
										</table>
										</div>
										
										</div>
							</div>
						</div>
						<?php 
					}; } ?>
				</div>

			<?php 
				
			}; } ?>	
				<div class="item"><B>2. นิคมอุตสาหกรรมรับแนวคิดหลักการ Eco มาประยุกต์ใช้ โดยมีการจัดตั้งคณะทำงาน Eco (Eco Team)...
<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
				</B></div>  
				<div class="collapse" id="collapseExample2">
					<div class="item2">                                         
						  <div class="card">
									<div class="card-header" id="headingOne">
									<p class="mb-0">1. ประกาศคำสั่งการจัดตั้งคณะทำงาน Eco Team ประกาศคำสั่งคณะทำงานเครือข่าย Eco Committee<br>
									  </p>
									<table width="95%" border="0" cellspacing="1" cellpadding="1">
									  <tr>
									    <td width="25%" height="15">รายละเอียด :</td>
									    <td width="75%" height="15">รายละเอียดจาก user นิคม</td>
								      </tr>
									  <tr>
									    <td height="15">ไฟล์แนบ :</td>
									    <td height="15">aaaaaaaa.pdf</td>
								      </tr>
									  <tr>
									    <td>ข้อคิดเห็น :</td>
									    <td><textarea name="comment" id="comment" cols="40" rows="4" style="overflow:hidden"></textarea></td>
								      </tr>
                                      <tr>
									    <td width="25%" height="10"></td>
									    <td width="75%" height="10"></td>
								      </tr>
									  <tr>
									    <td><input type="submit" name="approve" id="approve" value="ผ่านอนุมัติ"></td>
									    <td><input type="submit" name="approve2" id="approve2" value="&nbsp;Reject&nbsp;"></td>
								      </tr>
									  </table>
									<p class="mb-0"><br>
									  
									  </p>
									</div>
						  </div>
						  
						  <div class="card">
									<div class="card-header" id="headingOne">
									<p class="mb-0">2. แผนงานการประชุมคณะทำงาน Eco Team ประจำปีงบประมาณ <br>
									  </p>
									<table width="95%" border="0" cellspacing="1" cellpadding="1">
									  <tr>
									    <td width="25%" height="15">รายละเอียด :</td>
									    <td width="75%" height="15">รายละเอียดจาก user นิคม</td>
								      </tr>
									  <tr>
									    <td height="15">ไฟล์แนบ :</td>
									    <td height="15">aaaaaaaa.pdf</td>
								      </tr>
									  <tr>
									    <td>ข้อคิดเห็น :</td>
									    <td><textarea name="comment" id="comment" cols="40" rows="4" style="overflow:hidden"></textarea></td>
								      </tr>
                                      <tr>
									    <td width="25%" height="10"></td>
									    <td width="75%" height="10"></td>
								      </tr>
									  <tr>
									    <td><input type="submit" name="approve" id="approve" value="ผ่านอนุมัติ"></td>
									    <td><input type="submit" name="approve2" id="approve2" value="&nbsp;Reject&nbsp;"></td>
								      </tr>
									  </table>
									<p class="mb-0"><br>
									  
									  </p>
									</div>
						  </div>
						  
						  
						  <div class="card">
									<div class="card-header" id="headingOne">
									<p class="mb-0">3. รายงานการประชุมคณะทำงาน Eco Team ตามแผนงาน แผนงานการประชุมคณะทำงาน Eco Committee ประจำปีงบประมาณ รายงานการประชุมคณะทำงาน Eco Committee <br>
									  </p>
									<table width="95%" border="0" cellspacing="1" cellpadding="1">
									  <tr>
									    <td width="25%" height="15">รายละเอียด :</td>
									    <td width="75%" height="15">รายละเอียดจาก user นิคม</td>
								      </tr>
									  <tr>
									    <td height="15">ไฟล์แนบ :</td>
									    <td height="15">aaaaaaaa.pdf</td>
								      </tr>
									  <tr>
									    <td>ข้อคิดเห็น :</td>
									    <td><textarea name="comment" id="comment" cols="40" rows="4" style="overflow:hidden"></textarea></td>
								      </tr>
                                      <tr>
									    <td width="25%" height="10"></td>
									    <td width="75%" height="10"></td>
								      </tr>
									  <tr>
									    <td><input type="submit" name="approve" id="approve" value="ผ่านอนุมัติ"></td>
									    <td><input type="submit" name="approve2" id="approve2" value="&nbsp;Reject&nbsp;"></td>
								      </tr>
									  </table>
									<p class="mb-0"><br>
									  
									  </p>
									</div>
						  </div>
					</div>
					</div>
				
				
			</div>

      <?php }; ?>
	</div>
</div>
 


</body>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
?>