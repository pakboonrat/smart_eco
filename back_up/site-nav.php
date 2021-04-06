<?php 
    include_once('function.php'); 
    // $_SESSION['id'] = $num['user_id'];
    // $_SESSION['fname'] = $num['firstname'];
    // $_SESSION['user_type'] = $num['user_type'];

?>
<nav class="site-nav">

    <div class="name">
    <?php echo $_SESSION['fname']; ?>
    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
  <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"></path>
</svg></p>
    

      <svg width="24" height="24" viewBox="0 0 24 24">
        <path d="M11.5,22C11.64,22 11.77,22 11.9,21.96C12.55,21.82 13.09,21.38 13.34,20.78C13.44,20.54 13.5,20.27 13.5,20H9.5A2,2 0 0,0 11.5,22M18,10.5C18,7.43 15.86,4.86 13,4.18V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V4.18C7.13,4.86 5,7.43 5,10.5V16L3,18V19H20V18L18,16M19.97,10H21.97C21.82,6.79 20.24,3.97 17.85,2.15L16.42,3.58C18.46,5 19.82,7.35 19.97,10M6.58,3.58L5.15,2.15C2.76,3.97 1.18,6.79 1,10H3C3.18,7.35 4.54,5 6.58,3.58Z"></path>
      </svg>
    </div>

    <ul>
      
      <li >
      
        <ul>
        <?php if($_SESSION['user_type']=="USER"){
            $updatelevel = new DB_con();
            $sql = $updatelevel->fetch_level_menu();
            while($row = mysqli_fetch_array($sql)) {
              
        ?>
          <li class="active" ><a href="eco_level.php?level_label=<?php echo $row['level_label']; ?>"><?php if ($row['level_label']== 'eco_champion'){ echo "ECO_CHAMPION";} ?></a></li>
          <?php } ?>
          <li><a href="#">ECO-EXCELLENCE</a></li>
          <li><a href="#">ECO-WORLD CLASS</a></li>
        </ul>
      </li>
		<?php }
            if($_SESSION['user_type']=="ADMIN"){

        $updatelevel = new DB_con();
            $sql = $updatelevel->fetch_level_menu();
            while($row = mysqli_fetch_array($sql)) {
              
        ?>
          <li class="active" ><a href="eco_level.php?level_label=<?php echo $row['level_label']; ?>"><?php if ($row['level_label']== 'eco_champion'){ echo "ECO_CHAMPION";} ?></a></li>
          <?php } ?>
          <li><a href="#">ECO-EXCELLENCE</a></li>
          <li><a href="#">ECO-WORLD CLASS</a></li>
        </ul>
      </li>
      <li><a href="nikom_all.php?usertype=USER">ผู้ใช้นิคม</a></li>
      <li><a href="nikom_all.php?usertype=AUDITOR">ผู้ตรวจประเมิน</a></li>
      <?php } ?>
   		<?php 
            if($_SESSION['user_type']=="AUDITOR"){

        ?>
      <li><a href="audit.php">ตรวจพิจารณา</a></li>

      <?php } ?> 
	    <?php  if($_SESSION['user_type']=="USER"){
        ?>
	  <li><a href="#">รายงาน</a></li>
      <li><a href="database.php?yearsel=<?php echo date("Y"); ?>">DATABASE</a></li>
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