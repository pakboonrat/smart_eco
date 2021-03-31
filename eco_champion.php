<?php 

    include_once('function.php');

    $updatedata = new DB_con();

    if (isset($_POST['update'])) {

        $userid = $_GET['id'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];

        $sql = $updatedata->update($fname, $lname, $email, $phonenumber, $address, $userid);
        if ($sql) {
            echo "<script>alert('Updated Successfully!');</script>";
            echo "<script>window.location.href='index.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!');</script>";
            echo "<script>window.location.href='update.php'</script>";
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
</head>
<body>
<div class="site-wrap">

  <?php include('site-nav.php'); ?>
  

  <main>

    <header>
      <div class="breadcrumbs">
        <a href="index.php">Home</a>
      </div>
      <?php 
            $level_id = $_GET['id'];
            $set_lebel = $_GET['set_lebel'];
            $updatelevel = new DB_con();
            $sql = $updatelevel->fetch_level($level_id,$set_lebel);
            while($row = mysqli_fetch_array($sql)) {
              
        ?>

      <h1>แผนการตรวจประเมิน : ECO CHAMPION <a href="#0" ><span>+</span></a></h1>
      
      
      <nav class="nav-tabs" id="nav-tabs">
        <a href="nikom_all.php" class="active">
            <?php echo $row['set_lebel']; ?>
          <span>9</span>
        </a>
        <a href="nikom_score.php">
        เกณฑ์คะแนน
          <span>5</span>
        </a>
        <a href="score_add.php" >
          เพิ่มเกณฑ์
          <span>+</span>
        </a>
        
      </nav>
      <?php } ?>
    </header>

    <div class="content-columns">
      <?php 
          $fetchdata = new DB_con();
          $level_label = $_GET['level_label'];
          $set_lebel = $_GET['set_lebel'];
          $sql = $fetchdata->fetchdata($level_label,$set_lebel);
          while($row = mysqli_fetch_array($sql)) {
            $level_label = $row['level_label'] ;
      ?>
      <div class="col" >
        <!-- <div class="item"><h2><?php echo $row['set_lebel']; ?></h2></div> -->
        <div class="item"><?php echo $row['sub_lebel']; ?> 
          <h5> < แก้ไข > | < ลบ ></h5>
        </div>
        
      </div>
  
      <?php } ?>

      <div class="col" >
        <form method="post">
          <div class="collapse multi-collapse mt-3" id="multiCollapseExample1">
            <div class="item">
              <input type="text" class="form-control form-control-sm" >
              <input type="text" class="form-control form-control-sm" >
              <input id="level_label" name="level_label" type="hidden" value="<?php echo $level_label; ?> ">
              <button type="submit" name="submit" id="submit" class="badge bg-primary btn btn-success" >บันทึก</button>
            </div> 
          </div>

          
        </form>

        <button type="submit" name="submit" id="submit" class="badge bg-primary btn btn-success" data-mdb-toggle="collapse"
            data-mdb-target="#multiCollapseExample1"
            aria-expanded="false"
            aria-controls="multiCollapseExample1">เพิ่ม</button>
      </div>
      
    

    </div>
    <!-- <script type="text/javascript">
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
    </script> -->
      <script type="text/javascript">
        const collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
        const collapseList = collapseElementList.map((collapseEl) => {
          return new mdb.Collapse(collapseEl, {
            toggle: false,
          });
        });
      </script>

  </main>

</div>
</body>
</html>