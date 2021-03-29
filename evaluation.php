<?php 

    session_start();

    if ($_SESSION['id'] == "") {
        header("location: login.php");
    } elseif ($_SESSION['user_type'] = "USER")  {
?>
<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>A Pen by Pak Boonrat</title>
<link rel = "stylesheet" type = "text/css" href = "css\smart1.css" >
<script src="css\eco.js"></script>
<style class="INLINE_PEN_STYLESHEET_ID">
    body {
  background: #89909f;
  padding: 3rem 0 0 3rem;
  font-size: 16px;
  height: 100vh;
  margin: 0;
  overflow: hidden;
}

.site-wrap {
  display: grid;
  grid-template-columns: 280px 1fr;
}

.site-nav {
  background: #0b121b;
  color: white;
  border-top-left-radius: 2rem;
  display: flex;
  flex-direction: column;
}
.site-nav a {
  color: inherit;
}
.site-nav ul {
  margin-bottom: auto;
}
.site-nav ul li a {
  display: block;
  padding: 0.75rem 0.5rem 0.75rem 2rem;
  position: relative;
}
.site-nav ul li a:hover, .site-nav ul li a:focus {
  color: #4371c5;
}
.site-nav ul li.active > a {
  background: linear-gradient(to right, #101b2d, transparent);
}
.site-nav ul li.active > a::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  background: #4676cd;
  width: 5px;
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
}
.site-nav ul ul {
  padding-left: 1rem;
  margin-bottom: 0.5rem;
}
.site-nav ul ul a {
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
}

.note {
  width: calc(100% - 6rem);
  margin: 2rem;
  background: #171c26;
  border-radius: 10px;
  padding: 1rem;
}
.note h3 {
  font-size: 0.9rem;
  margin: 0 0 0.4rem 0;
}
.note p {
  color: #717783;
}

.name {
  font-size: 1.3rem;
  position: relative;
  margin: 2rem 0 2rem 0;
  padding: 0 2.5rem 0.5rem 2rem;
  width: calc(100% - 3rem);
}
.name svg {
  position: absolute;
  fill: white;
  width: 16px;
  height: 16px;
  right: 0;
  top: 7px;
}
.name::after {
  content: "";
  width: 8px;
  height: 8px;
  background: #4777ce;
  border-radius: 20px;
  position: absolute;
  top: 6px;
  right: -2px;
}

main {
  border-top-left-radius: 2rem;
  background: #ebecee;
  margin-left: -2rem;
  position: relative;
}
main > header {
  padding: 3rem 3rem 0 3rem;
}

.content-columns {
  padding: 3rem;
  display: flex;
  background: #e5e5e9;
}
.content-columns .col {
  min-height: 500px;
  width: 200px;
  padding: 1rem;
  background: #ebecee;
  margin-right: 1rem;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.04);
  border-radius: 5px;
}
.content-columns .col:nth-child(1) {
  border-top: 4px solid #50aaee;
}
.content-columns .col:nth-child(2) {
  border-top: 4px solid #d56ec7;
}
.content-columns .col:nth-child(3) {
  border-top: 4px solid #e37e55;
}
.content-columns .col:nth-child(4) {
  border-top: 4px solid #ebbd41;
}

.item {
  background: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.07);
  min-height: 50px;
  border-radius: 5px;
  margin: 0 0 0.5rem 0;
}

.nav-tabs a {
  margin-right: 2rem;
  display: inline-block;
  padding: 1rem 0 1rem 0;
  font-size: 1.15rem;
  color: #8c939e;
  position: relative;
}
.nav-tabs a.active {
  color: #101620;
  font-weight: 600;
}
.nav-tabs a.active span {
  background: #d9dfea;
  color: #5887d1;
}
.nav-tabs a.active::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: #457ace;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
}
.nav-tabs a span {
  border-radius: 10px;
  font-size: 0.8rem;
  padding: 0.25rem 0.4rem;
  font-weight: 600;
  vertical-align: middle;
  position: relative;
  top: -2px;
  background: #dfe0e2;
  color: #868d99;
}
  </style>

</head>
<body>
<div class="site-wrap">

  <nav class="site-nav">

    <div class="name">
    <?php 
    echo $_SESSION['firstname'] ;
    ?>
    ECO Audit Database Web Application

      <svg width="24" height="24" viewBox="0 0 24 24">
        <path d="M11.5,22C11.64,22 11.77,22 11.9,21.96C12.55,21.82 13.09,21.38 13.34,20.78C13.44,20.54 13.5,20.27 13.5,20H9.5A2,2 0 0,0 11.5,22M18,10.5C18,7.43 15.86,4.86 13,4.18V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V4.18C7.13,4.86 5,7.43 5,10.5V16L3,18V19H20V18L18,16M19.97,10H21.97C21.82,6.79 20.24,3.97 17.85,2.15L16.42,3.58C18.46,5 19.82,7.35 19.97,10M6.58,3.58L5.15,2.15C2.76,3.97 1.18,6.79 1,10H3C3.18,7.35 4.54,5 6.58,3.58Z"></path>
      </svg>
    </div>

    <ul>
      <li class="active"><a href="nikom_all.php">นิคม</a>
      <li ><a href="score.php">เกณฑ์การเป็นเมืองอุตสาหกรรม</a>
      
        <ul>
          <li><a href="eco_champion.php">ECO-CHAMPION</a></li>
          <li><a href="eco_excellence.php">ECO-EXCELLENCE</a></li>
          <li><a href="eco_world_class.php">ECO-WORLD CLASS</a></li>
        </ul>
      </li>
      <li><a href="evaluation.php">ผู้ตรวจประเมิน</a></li>
      <li><a href="report.php">รายงาน</a></li>
      <li><a href="database.php">DATABASE</a></li>
      
    </ul>

    <div class="note">
      <h3>Your Monthly Report</h3>
      <p>Get the info about all your deals, pros, cons. And build your roadmap.</p>
    </div>

  </nav>

  <main>

    <header>
      <div class="breadcrumbs">
        <a href="index.php">Home</a>
      </div>
      
      <h1>นิคม <a href="#0" ><span>+</span></a></h1>
      
      
      <nav class="nav-tabs" id="nav-tabs">
        <a href="nikom_all.php" >
          นิคมทั้งหมด
          <span>80</span>
        </a>
        <a href="nikom_score.php">
          นิคมที่ส่งเกณฑ์เข้าตรวจ
          <span>32</span>
        </a>
        <a href="nikom_add.php" class="active">
          เพิ่มนิคม
          <span>32</span>
        </a>
        
      </nav>
    </header>

    <div class="content-columns">

      <div class="col">
        <div class="item">นิคมฯ อัญธานี</div>
        <div class="item">นิคมฯ ดับบลิวเอชเอ ชลบุรี 2  </div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>
      <div class="col">
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>
      <div class="col">
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>
      <div class="col">
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
        <div class="item"></div>
      </div>

    </div>

  </main>

</div>
</body>
</html>

<?php 

}
?>