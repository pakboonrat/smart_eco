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
			echo $user_id;
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
  <div class="content-columns">
    <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>     
			<div class="col-10 col-md-9">
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
				
				if( !isset($_GET['set_lebel'])){

				$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				header("Refresh:0; url=".$actual_link."&set_lebel=".$row['set_lebel']);
				//echo $actual_link."&set_lebel=".$row['set_lebel'];
				}

			   ?>
					<?php
						if( ( strtolower($sub_lebel) != strtolower($row['sub_lebel'])) AND ( strtolower($row['set_lebel']) == 'guidelines' )  ){
						?>

						<div class="item">
							<B><?php echo $row['sub_lebel'];?> 
								<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'];?>" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
							</B>
						</div>
						<?php 
						}elseif( strtolower($row['set_lebel']) != 'guidelines' ){
							?>
							<div class="item">
							<B><?php echo $row['sub_lebel'];?> 
								<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $row['level_id'];?>" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
							</B>
							</div>
							<?php


						}
						?>  
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
											<td height="15"><a href="./uploads/<?php echo $row_list['ori_filename'];?>" target="_blank"><?php echo $row_list['ori_filename'];?></a></td>
										</tr>
										<tr>
											<td>ข้อคิดเห็น :</td>
											<td><textarea name="comment" id="comment_<?php echo $row_list['t_id'];?>" cols="40" rows="4" style="overflow:hidden"></textarea></td>
										</tr>
										<tr>
											<td width="25%" height="10"></td>
											<td width="75%" height="10"></td>
										</tr>
										<tr>
											<td><input type="submit" name="approve" id="approve_<?php echo $row_list['t_id'];?>" class="submit" value="ผ่านอนุมัติ"></td>
											<td><input type="submit" name="approve2" id="approve_<?php echo $row_list['t_id'];?>" class="submit" value="Reject"></td>
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
			$sub_lebel = $row['sub_lebel'] ;
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
					audit: audit				
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
						alert(" // บันทึกสำเร็จ !  ");
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
});
</script>
</html>

<?php 
} else { echo "<script>window.location.href='index.php'</script>";}
ob_end_flush();
?>