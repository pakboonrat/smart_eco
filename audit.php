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
<title>Auditor</title>
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
       <a href="audit.php" >
          ตรวจพิจารณา </a>
      </nav>
    </header>

  <div class="content-columns">
    <?php    if($_SESSION['user_type']=="AUDITOR"){ ?>     
<div class="col-12" >
<div class="item">


  <table class="table table-striped table-hover">
    <thead>
        <tr>
          <th scope="col-lg-1 col-md-1 ">ชื่อนิคม</th>
        <!-- <th width="32%" align="center">ชื่อนิคม</th> -->
        <th scope="col-lg-1 col-md-1">ผู้ตรวจ</th>
        
        <?php 


          $fetchdata = new DB_con();
          $sql = $fetchdata->fetch_level_menuuser2();
          if( mysqli_num_rows($sql) != 0 ){
            $num_col = 0;
            $format = array();
          while($row_format = mysqli_fetch_array($sql)) { 
            $num_col += 1;
            $format[$num_col] = $row_format['level_label'];
            $format_des[$num_col] = $row_format['level_label'];
            if ( $row_format['level_label']== 'eco_champion') {
              $format_des['eco_champion'] = "ECO-CHAMPION";
            }elseif($row_format['level_label']== 'eco_excellence'){
              $format_des['eco_excellence'] = "ECO-EXCELLENCE";
            }elseif($row_format['level_label']== 'eco_worldclass'){
              $format_des['eco_worldclass'] = "ECO-WORLD CLASS";
            }
					 
      ?>
        <th scope="col-lg-2 col-md-1"><?php echo $format_des[$row_format['level_label']];?></th>
        <?php   } 
        }?>

        </tr>
    </thead>
    <tbody>
    <?php  
          $fetchdata = new DB_con();
          //$sql = $fetchdata->fetch_transaction_By_USER(" status = 'consider' "); //fetch_AUDIT_By_USER
          // $sql = $fetchdata->fetch_AUDIT_By_USER("ALL","consider");
          $sql = $fetchdata->fetch_AUDIT_By_USER("ALL","consider");

          if( mysqli_num_rows($sql) != 0 ){
           
          while($row = mysqli_fetch_array($sql)) { 
      ?>
      
      <tr <?php if( $row['status']==2){ echo "class=\"table-success\""; }  ?>>
        <th scope="row"><?php echo $row['firstname'];?> </th>
        <td><?php  if(isset($row['AUDIT_ALL'])){ echo $row['AUDIT_ALL']; }else{  echo "- "; } ?></td>
        
        <?php 
          for ($x = 1; $x <= $num_col; $x++) {
            
            if( strpos($row['level_label'] ,$format[$x]  ) !== false ){
              ?>
              <td><button class="btn btn-primary" onclick="window.location.href='approve.php?userid=<?php echo $row['USER'] ; ?>&level_label=<?php echo $format[$x]; ?>&level_txt=<?php echo $format_des[$format[$x]]; ?>&set_lebel0=basic'" >ตรวจประเมิน</button></td>
              <?php 
            }else{
              echo "<td>  </td>";
            }
          }
        ?>
      </tr>
      <?php }
    } else{  ?>
    
    <?php   } ?>
    
    </tbody>
</table><br>
<br>
<br>
<br><br>
<br>
<br>
<br>
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