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
      <h1>เกณฑ์การตรวจประเมิน : ECO CHAMPION </h1>
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
        <a href="score_add.php" >
          เพิ่มเกณฑ์
          
        </a>
      </nav>
      
    </header>

    <div class="content-columns">
      <?php 
          $fetchdata = new DB_con();
          $level_label = $_GET['level_label'];

          if(isset($_GET['set_lebel'])){ 
            $set_lebel = $_GET['set_lebel'];
          }else{ 
            $set_lebel = $set_lebel_array[0]; 
            }

          $sql = $fetchdata->fetchdata($level_label,$set_lebel);
          while($row = mysqli_fetch_array($sql)) {
            $level_label = $row['level_label'] ;
      ?>
            <div class="col" >
            <!-- <div class="item"><h2><?php echo "==================".$row['set_lebel']; ?></h2></div> -->
            <div class="item"><?php echo $row['sub_lebel']; ?> 
                <div class="item-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" alt="แก้ไข" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                        </svg> | < ลบ >
                    </div>
                </div>

                <?php 
                // ถ้าอิงคะแนน ต้องดึง จาก Table score ก่อน
                
                if( $row['type'] == 'measure' ){
                    ?>
                    <div class="item2">+
                        <?php
                        echo "<p><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-award-fill\" viewBox=\"0 0 16 16\">
                        <path d=\"m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z\"></path>
                        <path d=\"M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z\"></path>
                        </svg>".$row['type']."</p>";
                        $fetchdata3 = new DB_con();
                        
                        $sql3 = $fetchdata3->fetch_score($row['level_id']);
                        if( $sql3 !="" ){ 
                        ?>
                            <div class="item2">
                                <form>
                                    <?php 
                                    while($row_score = mysqli_fetch_array($sql3)) {
                                    ?>
                                    
                                    <div class="form-row">
                                        <div>
                                        <div contentEditable='true' class='edit' id='point___<?php echo $row_score['score_id']; ?>' name='point___<?php echo $row_score['point']; ?>'><?php echo $row_score['point']; ?></div> 
                                        <input type="text" class="form-control" placeholder="scroe" value="<?php echo $row_score['point']; ?>">
                                        </div>
                                        <div>
                                        <input type="text" class="form-control" placeholder="คำอธิบาย" value="<?php echo $row_score['score_des']; ?>">
                                        </div>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        <?php };?>
                    
                        <form method="post">
                            <div class="form-row">
                                <div >
                                    <input name="point" id="point"  type="text" class="form-control" placeholder="scroe" >
                                </div>
                                <div >
                                    <input name="score_des" id="score_des"  type="text" class="form-control" placeholder="คำอธิบาย" >
                                </div>
                                <input id="level_id" name="level_id" type="hidden" value="<?php echo $row['level_id']; ?> ">
                                <button type="submit" name="score" id="score" class="badge bg-primary btn btn-success" >save</button>
                            </div>
                        </form>
                    </div>
                
                <?php 
                }else{
                    //-------control  
                    if( $row['type'] == 'control' ){
                        echo "<p>".$row['type']."</p>";
                    }

                        $fetchdata2 = new DB_con();
                        $sql2 = $fetchdata2->fetch_list($row['level_id']);
                        if( $sql2 != '' ){
                            ?> <div class="item2"> <?php 
                                    
                                    while($row_list = mysqli_fetch_array($sql2)) {
                                    ?>
                                        
                                            <?php if($_SESSION['user_type']=="ADMIN"){ 
                                            //  Admin จะเป็นกล่องสำหรับแก้ไขได้     ?>
                                            <div contentEditable='true' class='edit' id='list_label_<?php echo $row_list['list_id']; ?>' name='list_label_<?php echo $row_list['list_id']; ?>'><?php echo $row_list['list_label']; ?></div> 
                                            <?php }else{ ?>
                                                <!-- <div  id='list_label_<?php // echo $row_list['list_id']; ?>' name='list_label_<?php // echo $row_list['list_id']; ?>'><?php //echo $row_list['list_label']; ?></div> -->
                                                

                                            <div id="accordion<?php echo $row_list['list_id'];?>">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                    <p class="mb-0">list id : <?php echo $row_list['list_id'];?> / <?php echo $row_list['list_label']; ?>
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row_list['list_id'];?>" aria-expanded="true" aria-controls="collapseOne">
                                                        >>
                                                        </button>
                                                    </p>
                                                    </div>

                                                    <div id="collapseOne<?php echo $row_list['list_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?php echo $row_list['list_id'];?>">
                                                    <div class="card-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <input type="text" id="transaction_<?php echo $row_list['list_id'];?>">
                                                                <label for="File___<?php echo $row_list['list_id'];?>">File</label>
                                                                <input type="file" class="form-control-file" id="File___<?php echo $row_list['list_id'];?>">
                                                                <button type="button" class="btn btn-primary" value="บันทึก">บันทึก</button>
                                                                <button type="button" class="btn btn-primary" value="ส่งพิจารณา">ส่งพิจารณา</button>
                                                                
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php  };  
                                    }; ?>
                            

                                </div>
                        
                        <?php   }; 
                        if($_SESSION['user_type']=="USER"){
                            // admin ตั้งหัวข้อใหม่
                                echo "admin ตั้งหัวข้อใหม่ ";

                            }elseif($_SESSION['user_type']=="USER"){ 
                            //  เฉพาะ USER  จส่งหลักฐาน และกำหนดหัวข้อเอง  ?>
                            >> user ส่งหลักฐาน และกำหนดหัวข้อเอง
                            <div class="item2">...
                            </div>
                            <?php }; ?>
                    <?php   //--Close-------control : section    } 
                };
                            ?>

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
            </div>
            </form>

        
            <button class=" btn btn-success" data-mdb-toggle="collapse"
            data-mdb-target="#multiCollapseExample1"
            aria-expanded="false"
            aria-controls="multiCollapseExample1">เพิ่ม</button>
      </div>
      <?php }; ?>
<!-- <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0"> xxxx 
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>

<!-- <p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div> -->
      </div 1234> -->
    
    <!-- <scripttype= type="text/javascript">
      $(document).ready(function(){
        $('[data-toogle="tooltip"]').tooltip();
        
        $(document).on("click",".edit",function(){
          var input = $(this).parents("tr").find("input[type='text']");
          input.each(function(){
                $(this).removeAttr('disabled'); 
          });
          $(this).parents("tr").find(".add, .edit").toggle();
        });
      });
    </scripttype=> -->
      <script type="text/javascript">
        const collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
        const collapseList = collapseElementList.map((collapseEl) => {
          return new mdb.Collapse(collapseEl, {
            toggle: false,
          });
        });
      </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){
 
 // Add Class
 $('.edit').click(function(){
  $(this).addClass('editMode');
 });

 // Save data
 $(".edit").focusout(function(){
  $(this).removeClass("editMode");
  var id = this.id;
  var split_id = id.split("_");
  var field_name = split_id[0];
  var edit_id = split_id[2];
  var split_id2 = id.split("_"+edit_id);
  var field_name2 = split_id2[0];
  var value = $(this).text();
  console.log("value :"+value);
  $.ajax({
   url: 'update.php',
   type: 'post',
   data: { field:field_name2, value:value, id:edit_id },
   success:function(response){
     if(response == 1){
        console.log('Save successfully'); 
     }else{
        console.log(response);
     }
   }
  });
 
 });

});
</script>

  </main>

</div>
</body>
</html>

<?php 

}
?>