 <!-- connectdb-->
 <?php session_start();
    $serverName = "localhost";
    $userName = "root";
    $userPassword = "";
    $dbName = "trackkingsystem";

    $objConnect = mysqli_connect($serverName, $userName, $userPassword, $dbName);
    mysqli_select_db($objConnect, "trackkingsystem");
    mysqli_set_charset($objConnect, "utf8");
    mysqli_query($objConnect, "SET NAMES UTF8");
    $student_id = "";

    if (isset($_SESSION['studentID']) && !empty($_SESSION['studentID'])) {
        $student_id = $_SESSION["studentID"];
    }

    $select = "SELECT * FROM user_info WHERE Student_ID = '$student_id'";
    $objQuerySelect = mysqli_query($objConnect, $select);
    $_student_type = 1;
    $_grade = null;
    $_parent_income = null;
    $_volunteer = null;
    $_phone_number = "";
    $count = 0;
    while ($row = mysqli_fetch_assoc($objQuerySelect)) {
        $_student_type = $row['Estudentloan_Type'];
        $_grade = $row['Grade'];
        $_parent_income = $row['Parent_Income'];
        $_volunteer = $row['Volunteer'];
        $_phone_number = $row['Phone_Number'];
        $count++;
    }
    ?>
 <!-- end connecdb -->

 <!-- แสดงข้อมูล   -->
 <?php
    mysqli_select_db($objConnect, "trackkingsystem");
    mysqli_set_charset($objConnect, "utf8");
    mysqli_query($objConnect, "SET NAMES UTF8");


    $select = "SELECT * FROM user_info WHERE Student_ID = '$student_id'";
    $objQuerySelect = mysqli_query($objConnect, $select);
    $grade = true;
    $parent_income = true;
    $volunteer = true;
    $pass = false;
    $_grade;
    $_parent_income;
    $_volunteer;
    $_sutdent_type;
    $_phone_number;
    $count = 0;
    while ($row = mysqli_fetch_assoc($objQuerySelect)) {
        if ($row['Grade'] < 1.90) {
            $grade = false;
        }
        if ($row['Parent_Income'] > 300000) {
            $parent_income = false;
        }
        if ($row['Volunteer'] < 36) {
            $volunteer = false;
        }
        if ($grade && $parent_income && $volunteer) {
            $pass = true;
        }
        $_grade = $row['Grade'];
        $_parent_income = $row['Parent_Income'];
        $_volunteer = $row['Volunteer'];
        $_sutdent_type = $row['Estudentloan_Type'];
        $_phone_number = $row['Phone_Number'];
        $count++;
    }
    if ($count == 0) {
        $pass = false;
    }
    ?>
 <!-- จบแสดงข้อมูล -->


 <!DOCTYPE html>
 <html lang="en">

 <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <title>Tracking System For e-Studentloan In TU</title>

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
     <!-- Icon -->
     <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
     <!-- Slicknav -->
     <link rel="stylesheet" type="text/css" href="assets/css/slicknav.css">
     <!-- Nivo Lightbox -->
     <link rel="stylesheet" type="text/css" href="assets/css/nivo-lightbox.css">
     <!-- Animate -->
     <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
     <!-- Main Style -->
     <link rel="stylesheet" type="text/css" href="assets/css/main.css">
     <!-- Responsive Style -->
     <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
     <script type="text/javascript" src="jquery.js"></script>
     <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


     <!-- สร้างคำร้อง-->
     <script>
     function Edit() {
         $('#grade').attr('readonly', false);
         $('#parent_income').attr('readonly', false);
         $('#volunteer').attr('readonly', false);
         $('#phone_number').attr('readonly', false);
         $(':radio:not(:checked)').attr('disabled', false);
     }

     $(document).ready(function() {

         $("#btn_save").click(function() {
             var StudentId = $("#student_id").val().trim();
             var Name = $("#student_name").val();
             var Grade = $("#grade").val().trim();
             var ParentIncome = $("#parent_income").val().trim();
             var Volunteer = $("#volunteer").val().trim();
             var PhoneNum = $("#phone_number").val().trim();
             var Type = $('input[name=e-student_type]:checked', '#e-student_type').val();
             $.ajax({
                 url: 'save-request.php',
                 type: 'post',
                 data: {
                     StudentId: StudentId,
                     Name: Name,
                     Grade: Grade,
                     ParentIncome: ParentIncome,
                     Volunteer: Volunteer,
                     PhoneNum: PhoneNum,
                     Type: Type
                 },
                 success: function(response) {
                     $('input').attr('readonly', true);
                     $(':radio:not(:checked)').attr('disabled', true);
                     alert(response);
                 }
             });
         });


     });
     </script>

     <!-- จบสร้างคำร้อง   -->
 </head>

 <body>
     <?php
        if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        ?>
     <!-- เริ่มส่วน header -->
     <header id="header-wrap">
         <!-- เริ่ม Navbar  -->
         <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
             <div class="container">
                 <!-- เมนูสำหรับ dekstop -->
                 <div class="navbar-header">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
                         aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon"></span>
                         <span class="icon-menu"></span>
                         <span class="icon-menu"></span>
                         <span class="icon-menu"></span>
                     </button>
                     <a href="studentpage.php" class="navbar-brand"><img src="assets/img/logosystem.png" alt=""></a>
                 </div>
                 <div class="collapse navbar-collapse" id="main-navbar">
                     <ul class="navbar-nav mr-auto w-100 justify-content-end">
                         <li class="nav-item active">
                             <a class="nav-link" href="studentpage.php">
                                 หน้าหลัก
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php">
                                 กำหนดการ
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="#schedules">
                                 สร้างคำร้อง
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php">
                                 ติดตามสถานะ
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php">
                                 ข่าวประชาสัมพันธ์
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php">
                                 คำถามที่พบบ่อย
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="logout.php">
                                 ออกจากระบบ
                             </a>
                         </li>
                     </ul>
                 </div>
             </div>

             <!-- เมนูสำหรับ mobile -->
             <ul class="mobile-menu">
                 <li>
                     <a class="page-scrool" href="#header-wrap">หน้าหลัก</a>
                 </li>
                 <li>
                     <a class="page-scrool" href="#about">กำหนดการ</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="#schedules">สร้างคำร้อง</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="#faq">คำถามที่พบบ่อย</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="#pricing">ติดตามสถานะ</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="#team">ข่าวประชาสัมพันธ์</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="#logout">ออกจากระบบ</a>
                 </li>
             </ul>
             <!-- จบ เมนูสำหรับ mobile -->

         </nav>
         <!-- จบส่วน Navbar -->



         <!-- ข่าว Section Start -->
         <section id="team" class="section-padding text-center">
             <div class="container">
                 <div class="row">
                     <div class="col-12">
                         <div class="section-title-header text-center">
                             <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">ข่าวประชาสัมพันธ์</h1>
                             <p class="wow fadeInDown" data-wow-delay="0.2s">
                                 ข่าวประชาสัมพันธ์เกี่ยวกับการกู้ยืมเงินเพื่อการศึกษา กรอ. และ กยศ.
                                 มหาวิทยาลัยธรรมศาสตร์</p>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="ccol-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/qrcode.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/qrcode.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/img-1.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/img-1.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="ccol-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/img-2.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/img-2.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="ccol-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/img-3.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/img-3.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="ccol-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/img-4.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/img-4.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="ccol-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/img-5.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/img-5.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="ccol-md-6 col-sm-6 col-lg-4">
                         <div class="gallery-box">
                             <div class="img-thumb">
                                 <img class="img-fluid" src="assets/img/gallery/img-6.jpg" alt="">
                             </div>
                             <div class="overlay-box text-center">
                                 <a class="lightbox" href="assets/img/gallery/img-6.jpg">
                                     <i class="lni-plus"></i>
                                 </a>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>
             <!-- ข่าว Section End -->


             <!-- Footer Section Start -->
             <footer class="footer-area section-padding">
                 <div class="container">
                     <div class="row justify-content-md-center">
                         <class class="row">
                             <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.2s">
                                 <h3><img src="assets/img/logosystem.png" alt=""></h3>
                             </div>
                         </class>
                     </div>
                 </div>
                 <div class="container">
                     <div class="row justify-content-md-center">
                         <div class="row">
                             <!-- /.widget -->
                             <div class="widget">
                                 <h5 class="widget-title">FOLLOW US ON</h5>
                                 <ul class="footer-social">
                                     <li><a class="facebook" href="#"><i class="lni-facebook-filled"></i></a></li>
                                     <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
                                     <li><a class="linkedin" href="#"><i class="lni-linkedin-filled"></i></a></li>
                                     <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                 </div>
             </footer>
             <!-- Footer Section End -->
             <div id="copyright">
                 <div class="container">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="site-info">
                                 <p>ระบบติดตามสถานะการกู้ยืมเงินกรอ. และ กยศ. มหาวิทยาลัยธรรมศาสตร์ &nbsp Tracking
                                     System For e-Studentloan In Thammasat University</a>
                                 </p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Go to Top Link -->
             <a href="#" class="back-to-top">
                 <i class="lni-chevron-up"></i>
             </a>

             <div id="preloader">
                 <div class="sk-circle">
                     <div class="sk-circle1 sk-child"></div>
                     <div class="sk-circle2 sk-child"></div>
                     <div class="sk-circle3 sk-child"></div>
                     <div class="sk-circle4 sk-child"></div>
                     <div class="sk-circle5 sk-child"></div>
                     <div class="sk-circle6 sk-child"></div>
                     <div class="sk-circle7 sk-child"></div>
                     <div class="sk-circle8 sk-child"></div>
                     <div class="sk-circle9 sk-child"></div>
                     <div class="sk-circle10 sk-child"></div>
                     <div class="sk-circle11 sk-child"></div>
                     <div class="sk-circle12 sk-child"></div>
                 </div>
             </div>
             <?php
            } else

                ?>
             <a calss="h-100 row align-items-center" href="login.html"
                 style="text-align:center; vertical-align: middle;">
                 <h1>กรุณาเข้าสู่ระบบ</h1>
             </a>
             <!-- jQuery first, then Popper.js, then Bootstrap JS -->
             <script src="assets/js/jquery-min.js"></script>
             <script src="assets/js/popper.min.js"></script>
             <script src="assets/js/bootstrap.min.js"></script>
             <script src="assets/js/jquery.countdown.min.js"></script>
             <script src="assets/js/jquery.nav.js"></script>
             <script src="assets/js/jquery.easing.min.js"></script>
             <script src="assets/js/wow.js"></script>
             <script src="assets/js/jquery.slicknav.js"></script>
             <script src="assets/js/nivo-lightbox.js"></script>
             <script src="assets/js/main.js"></script>
             <script src="assets/js/form-validator.min.js"></script>
             <script src="assets/js/contact-form-script.min.js"></script>


 </body>

 </html>