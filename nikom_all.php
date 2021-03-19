<html lang="en" class="pc chrome88 js">
<head>
<meta charset="UTF-8">
<title>A Pen by Pak Boonrat</title>
<link rel = "stylesheet" type = "text/css" href = "css\smart1all.css" >
<script src="css\eco.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


</head>
<body>
<div class="site-wrap">

  <nav class="site-nav">

    <div class="name">
    ECO Audit Database Web Application

      <svg width="24" height="24" viewBox="0 0 24 24">
        <path d="M11.5,22C11.64,22 11.77,22 11.9,21.96C12.55,21.82 13.09,21.38 13.34,20.78C13.44,20.54 13.5,20.27 13.5,20H9.5A2,2 0 0,0 11.5,22M18,10.5C18,7.43 15.86,4.86 13,4.18V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V4.18C7.13,4.86 5,7.43 5,10.5V16L3,18V19H20V18L18,16M19.97,10H21.97C21.82,6.79 20.24,3.97 17.85,2.15L16.42,3.58C18.46,5 19.82,7.35 19.97,10M6.58,3.58L5.15,2.15C2.76,3.97 1.18,6.79 1,10H3C3.18,7.35 4.54,5 6.58,3.58Z"></path>
      </svg>
    </div>

    <ul>
      <li class="active"><a href="#">นิคม</a>
      <li ><a href="score.php">เกณฑ์การพิจารณา</a>
      
        <ul>
          <li><a href="score/a1.php">ECO-CHAMPION</a></li>
          <li><a href="score/a2.php">ECO-EXCELLENCE</a></li>
          <li><a href="score/a3.php">ECO-WORLD CLASS</a></li>
        </ul>
      </li>
      <li><a href="eva.php">ผู้ตรวจประเมิน</a></li>
      <li><a href="report.php">รายงาน</a></li>
      <li><a href="database.php">DATABASE</a></li>
      
    </ul>

    <div class="note">
      <h3>รายงาน</h3>
      <p>การประเมินตามเกณฑ์</p>
    </div>

  </nav>

  <main>

    <header>
      <div class="breadcrumbs">
        <a href="index.php">Home</a>
      </div>
      
      <h1>นิคม <a href="#0" ><span>+</span></a></h1>
      
      
      <nav class="nav-tabs" id="nav-tabs">
        <a href="#0" class="active" >
          นิคมทั้งหมด
          <span>80</span>
        </a>
        <a href="#0">
          นิคมที่ส่งเกณฑ์เข้าตรวจ
          <span>32</span>
        </a>
        <a href="#0" >
          เพิ่มนิคม
          <span>32</span>
        </a>
        
      </nav>
    </header>

    <div class="content-columns">
    <div class="page-content">
    <div class="content-categories">
      <div class="label-wrapper">
        <input class="nav-item" name="nav" type="radio" id="opt-1">
        <label class="category" for="opt-1">All</label>
      </div>
      <div class="label-wrapper">
        <input class="nav-item" name="nav" type="radio" id="opt-2" checked="">
        <label class="category" for="opt-2" >ECO-CHAMPION</label>
      </div>
      <div class="label-wrapper">
        <input class="nav-item" name="nav" type="radio" id="opt-3">
        <label class="category" for="opt-3">ECO-EXCELLENCE</label>
      </div>
      <div class="label-wrapper">
        <input class="nav-item" name="nav" type="radio" id="opt-4">
        <label class="category" for="opt-4">ECO-WORLD CLASS</label>
      </div>
    </div>
    <div class="tasks-wrapper">
      <div class="task">
        <div class="tasks-wrapper2">
          <input class="task-item" name="task" type="checkbox" id="item-1" checked="">
          <label for="item-1">
            <span class="label-text">นิคมฯ อัญธานี</span>
          </label>
        </div>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-2" checked="">
        <label for="item-2">
          <span class="label-text">นิคมฯ ดับบลิวเอชเอ ชลบุรี 2  </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-3">
        <label for="item-3">
          <span class="label-text">นิคมฯ ลาดกระบัง  </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
        <span class="tag approved" style="background-color: yellow;">ECO-EXCELLENCE</span>
        <span class="tag review" style="background-color: green;">ECO-WORLD CLASS</span>
        

      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-4">
        <label for="item-4">
          <span class="label-text">นิคมฯ บางปู </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
        <span class="tag approved" style="background-color: yellow;">ECO-EXCELLENCE</span>
      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-5">
        <label for="item-5">
          <span class="label-text">นิคมฯ แหลมฉบัง  </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-6">
        <label for="item-6">
          <span class="label-text">นิคมฯ สมุทรสาคร  </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
      </div>
      
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-7">
        <label for="item-7">
          <span class="label-text">นิคมฯ ภาคใต้  </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
      </div>

      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-8">
        <label for="item-8">
          <span class="label-text">นิคมฯ อีสเทิร์นซีบอร์ด (ระยอง)  </span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
        <span class="tag approved" style="background-color: yellow;">ECO-EXCELLENCE</span>
        <span class="tag review" style="background-color: green;">ECO-WORLD CLASS</span>
      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-9">
        <label for="item-9">
          <span class="label-text">นิคมฯ บางชัน</span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
      </div>
      <div class="task">
        <input class="task-item" name="task" type="checkbox" id="item-10">
        <label for="item-10">
          <span class="label-text">นิคมฯ พิจิตร</span>
        </label>
        <span class="tag approved" style="background-color: lightblue;">ECO-CHAMPION</span>
        <span class="tag approved" style="background-color: yellow;">ECO-EXCELLENCE</span>
      </div>

      <div class="header upcoming">หน้า 1  2  3  4  5  6  >> </div>


      
    </div>
  </div>

    

    </div>

  </main>

</div>
</body>
</html>
    
    
    
    
    