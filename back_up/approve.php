<?php 
    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] == "AUDITOR") {
    include_once('function.php');

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
        <a href="audit.php">Home</a>
      </div>
      <h1>ตรวจพิจารณา : </h1>
       <nav class="nav-tabs" id="nav-tabs">
       <a href="audit.php">ตรวจพิจารณา</a>&nbsp;>&nbsp;<a href="approve.php" >นิคมฯ อัญธานี</a></nav>
    </header>
  <div class="content-columns">
    <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>     
			<div class="col">    
				<div class="item"><B>1. มีการประกาศนโยบายการพัฒนานิคมอุตสาหกรรมตามแนวคิดหลักการ Eco โดยมุ่งเน้นสู่เป้าหมายอย่างชัดเจน 
<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none"><b>+</b></button>
				</B></div>    
					<div class="collapse" id="collapseExample">
					<div class="item2">                                         
						  <div class="card">
									<div class="card-header" id="headingOne">
									<p class="mb-0">1. นโยบายการพัฒนานิคมอุตสาหกรรม <br>
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