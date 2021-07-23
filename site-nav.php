<?php 
    include_once('function.php'); 
    // $_SESSION['id'] = $num['user_id'];
    // $_SESSION['fname'] = $num['firstname'];
    // $_SESSION['user_type'] = $num['user_type'];

?>
<nav class="site-nav">


    <div id="name1" class="name">
      <script>
        $.notify.addStyle('foo', {
          html: 
            "<div>" +
              "<div class='clearfix'>" +
                "<div class='title' data-notify-html='title'/> </div>" +
                "<div class='buttons'>" +
                  "<button class='no'>Cancel</button>" +
                  "<button class='yes' data-notify-text='button'></button>" +
                "</div>" +
              "</div>" +
            "</div>"
        });

        //listen for click events from this style
        $(document).on('click', '.notifyjs-foo-base .no', function() {
          //programmatically trigger propogating hide event
          $(this).trigger('notify-hide');
        });
        $(document).on('click', '.notifyjs-foo-base .yes', function() {
          //show button text
          alert($(this).text() + " clicked!");
          //hide notification
          $(this).trigger('notify-hide');
        });
      </script>
      


    <?php 
    if (isset($_SESSION['fname'])) {
      echo $_SESSION['fname']; 
    }else{
      echo "  SESSION  fname  is not set";
    }
    $updatelevel = new DB_con();
    $notif_txt = "";
    $sql = $updatelevel->reject_notif_USER($_SESSION['id']);
    if( mysqli_num_rows($sql) != 0 ){
      while($row_notif = mysqli_fetch_array($sql)) {
        if( $row_notif['T1'] == "1"){
           
          $txt_onclick = "onclick=location.href='summary_report.php';" ;
        }else{
          $txt_onclick = "onclick=location.href='status_report.php';" ;
        }
        
      }
      
    }else{
        echo "<script>
                $('.name').toggleClass('name00');
              </script> " ;

              $txt_onclick = " ";
      }

      //     // $notif_txt .= "  $.notify('".$row_notif['title']."');   " ; 
      //   //  $notif_txt .= " $.notify.addStyle('foo', {
      //   //                     html: 
      //   //                       '<div>
      //   //                         <div class='clearfix'> 
      //   //                           <div class='title' data-notify-html='title'/>
      //   //                           <div class='buttons'>
      //   //                             <button class='no'>Cancel</button>
      //   //                             <button class='yes' data-notify-text='button'></button>
      //   //                           </div>
      //   //                         </div>
      //   //                       </div>'
      //   //                   });" ;

      //   $notif_txt .= "  $.notify({
      //                       title: ' <a href=approve.php?userid=".$row_notif['user_id']." >".$row_notif['title']."</a> ',
      //                       button: 'Confirm'
      //                     }, { 
      //                       style: 'foo',
      //                       autoHide: false,
      //                       clickToHide: false
      //                     }); ";
        
      //   } 
      // }else{
      //   echo "<script>
      //           $('.name').toggleClass('name00');
      //         </script> " ;
      // }

      //ตัวอย่าง การส่ง ข้อความ send_notif_USER(5, 4,"tesssss");
      // $notif_sent > return 0 , 1  
      // send_notif_USER(USER_ID ผู้ส่ง , USER_ID คนรับ  ,"ข้อความ");
      //
      // $sql = $updatelevel->send_notif_USER(5, 4,"tesssss");
      // if($sql) {
      //   echo "ID-------- : ";
      // }
      
      
       ?>
    
      <div class="0">
      <svg class="11" width="24" height="24" viewBox="0 0 24 24" <?php echo $txt_onclick ; ?> >
        <path d="M11.5,22C11.64,22 11.77,22 11.9,21.96C12.55,21.82 13.09,21.38 13.34,20.78C13.44,20.54 13.5,20.27 13.5,20H9.5A2,2 0 0,0 11.5,22M18,10.5C18,7.43 15.86,4.86 13,4.18V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V4.18C7.13,4.86 5,7.43 5,10.5V16L3,18V19H20V18L18,16M19.97,10H21.97C21.82,6.79 20.24,3.97 17.85,2.15L16.42,3.58C18.46,5 19.82,7.35 19.97,10M6.58,3.58L5.15,2.15C2.76,3.97 1.18,6.79 1,10H3C3.18,7.35 4.54,5 6.58,3.58Z"></path>
      </svg></div>


    </div>

    <ul>
      
      <li >
        
        <?php if($_SESSION['user_type']=="USER"){
            $updatelevel = new DB_con();
            $sql = $updatelevel->fetch_level_menuuser($_SESSION['id']);
            while($row = mysqli_fetch_array($sql)) {
              
        ?>
          <li <?php if (($_GET['level_label']=='eco_champion') and ($row['level_label']== 'eco_champion')) {echo "class='active'";}
					elseif (($_GET['level_label']=='eco_excellence') and ($row['level_label']== 'eco_excellence')) {echo "class='active'";}
					elseif (($_GET['level_label']=='eco_worldclass') and ($row['level_label']== 'eco_worldclass')) {echo "class='active'";}?>><a href="eco_level.php?level_label=<?php echo $row['level_label'];?>&set_lebel=<?php if ($row['level_label']== 'eco_champion') {echo "basic";} else {echo "Guidelines";}?>"><?php if ($row['level_label']== 'eco_champion')  { echo "ECO-CHAMPION";}
					elseif ($row['level_label']== 'eco_excellence') {echo "ECO-EXCELLENCE";}
					elseif ($row['level_label']== 'eco_worldclass') {echo "ECO-WORLD CLASS";};
			  ?></a></li>
          <?php } ?>
         
     
		<?php }
            if($_SESSION['user_type']=="ADMIN"){

        $updatelevel = new DB_con();
            $sql = $updatelevel->fetch_level_menu();
            while($row = mysqli_fetch_array($sql)) {
              
        ?>
			<li <?php if (($_GET['level_label']=='eco_champion') and ($row['level_label']== 'eco_champion')) {echo "class='active'";}
					elseif (($_GET['level_label']=='eco_excellence') and ($row['level_label']== 'eco_excellence')) {echo "class='active'";}
					elseif (($_GET['level_label']=='eco_worldclass') and ($row['level_label']== 'eco_worldclass')) {echo "class='active'";}?>><a href="eco_level.php?level_label=
					<?php echo $row['level_label'];?>&set_lebel=<?php if ($row['level_label']== 'eco_champion') {echo "basic";} else {echo "Guidelines";}?>"><?php if ($row['level_label']== 'eco_champion')  { echo "ECO-CHAMPION";}
					elseif ($row['level_label']== 'eco_excellence') {echo "ECO-EXCELLENCE";}
					elseif ($row['level_label']== 'eco_worldclass') {echo "ECO-WORLD CLASS";};
			  ?></a></li>
          <?php } ?>          
       
      <li <?php if ((basename($_SERVER["SCRIPT_FILENAME"], '.php')=='nikom_all') and ($_GET['usertype']=='USER')) {echo "class='active'";}?>><a href="nikom_all.php?usertype=USER">ผู้ใช้นิคม</a></li>
      <li <?php if ((basename($_SERVER["SCRIPT_FILENAME"], '.php')=='nikom_all') and ($_GET['usertype']=='AUDITOR')) {echo "class='active'";}?>><a href="nikom_all.php?usertype=AUDITOR">ผู้ตรวจประเมิน</a></li>
      <?php } ?>
   		<?php 
            if($_SESSION['user_type']=="AUDITOR"){

        ?>
      <li <?php if ((basename($_SERVER["SCRIPT_FILENAME"], '.php')=='audit') || (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='approve')) {echo "class='active'";}?>><a href="audit.php">ตรวจพิจารณา</a></li>
	  <li <?php if ((basename($_SERVER["SCRIPT_FILENAME"], '.php')=='nikom_report') || (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='status_report1') || (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='summary_report1') ) {echo "class='active'";}?>><a href="nikom_report.php">รายงานสรุปผลของนิคม</a></li>
	  <li <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='certificate') {echo "class='active'";}?>><a href="certificate.php">รายงานการตรวจประเมิน</a></li>
      <?php } ?> 
	    <?php  if($_SESSION['user_type']=="USER"){
        ?>
	  <li <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='status_report') {echo "class='active'";}?>><a href="status_report.php">สถานะการส่งพิจารณา</a></li>
	  <li <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='summary_report') {echo "class='active'";}?>><a href="summary_report.php">รายงานสรุปผล</a></li>
      <li <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php')=='database') {echo "class='active'";}?>><a href="database.php?yearsel=<?php echo date("Y"); ?>">DATABASE</a></li>
	  <?php } ?>
      <li><a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
  <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"></path>
</svg>  | Log out</a></li>
    </ul><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

    <div class="note">
      <h3>© All Right Reserved</h3>
      <p>By Khun PAK</p>
    </div>

  </nav>