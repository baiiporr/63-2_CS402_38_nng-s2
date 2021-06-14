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

    $select_last = "SELECT * FROM semester ORDER BY id DESC LIMIT 0, 1";
    $objQuerySelect_last = mysqli_query($objConnect, $select_last);
    $last = mysqli_fetch_array($objQuerySelect_last);
    $term = "";
    $year = "";
    if (mysqli_num_rows($objQuerySelect_last) != 0) {
        $term = $last['term'];
        $year = $last['year'];
    }
    ?>
 <!-- end connecdb -->

 <!-- แสดงข้อมูล   -->
 <?php
    mysqli_select_db($objConnect, "trackkingsystem");
    mysqli_set_charset($objConnect, "utf8");
    mysqli_query($objConnect, "SET NAMES UTF8");


    $select = "SELECT * FROM user_info WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
    $objQuerySelect = mysqli_query($objConnect, $select);
    $grade = true;
    $parent_income = true;
    $volunteer = true;
    $pass = false;
    $_grade = null;
    $_parent_income = null;
    $_volunteer = null;
    $_student_type = null;
    $_phone_number = "";
    $count = 0;

    while ($row = mysqli_fetch_assoc($objQuerySelect)) {
        if ($row['Grade'] < 1.90) {
            $grade = false;
        }
        if ($row['Estudentloan_Type'] == 3 || $row['Estudentloan_Type'] == 4) {
            if ($row['Parent_Income'] > 360000) {
                $parent_income = false;
            }
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
        $_student_type = $row['Estudentloan_Type'];
        $_phone_number = $row['Phone_Number'];
        $count++;
    }
    if ($count == 0) {
        $pass = false;
    }
    $select = "SELECT * FROM all_datestartend";
    $objQuerySelect = mysqli_query($objConnect, $select);
    $_start_request = "";
    $_end_request = "";
    while ($row = mysqli_fetch_assoc($objQuerySelect)) {
        $_start_request = $row['start_createrequest'];
        $_end_request = $row['end_createrequest'];
    }

    $select_state1 = "SELECT * FROM state1 WHERE Student_ID = '$student_id'";
    $objQuerySelect = mysqli_query($objConnect, $select_state1);
    $_Status_state1 = "";
    while ($row = mysqli_fetch_assoc($objQuerySelect)) {
        $_Status_state1 = $row['Status_Doc'];
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
         $('#grade').css('border-color', "#F1C40F");
         $('#grade').css('border-style', 'solid');
         $('#grade').css('background-color', "#FFFF");
         $('#parent_income').css('border-color', "#F1C40F");
         $('#parent_income').css('border-style', 'solid');
         $('#parent_income').css('background-color', "#FFFF");
         $('#volunteer').css('border-color', "#F1C40F");
         $('#volunteer').css('border-style', 'solid');
         $('#volunteer').css('background-color', "#FFFF");
         $('#phone_number').css('border-color', "#F1C40F");
         $('#phone_number').css('border-style', 'solid');
         $('#phone_number').css('background-color', "#FFFF");
     }


     $(document).ready(function() {
         <?php if ($count != 0) { ?>
         $('input').attr('readonly', true);
         $(':radio:not(:checked)').attr('disabled', true);
         <?php
                } ?>
         $("#btn_save").click(function() {
             var StudentId = $("#student_id").val().trim();
             var Name = $("#student_name").val();
             var Grade = $("#grade").val().trim();
             var ParentIncome = $("#parent_income").val().trim();
             var Volunteer = $("#volunteer").val().trim();
             var PhoneNum = $("#phone_number").val().trim();
             var Type = $('input[name=e-student_type_radio]:checked', '#e-student_type').val();
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

                     $('#grade').css('border-color', "");
                     $('#grade').css('background-color', "#f5f5f5");
                     $('#parent_income').css('border-color', "");
                     $('#parent_income').css('background-color', "#f5f5f5");
                     $('#volunteer').css('border-color', "");
                     $('#volunteer').css('background-color', "#f5f5f5");
                     $('#phone_number').css('border-color', "");
                     $('#phone_number').css('background-color', "#f5f5f5");
                     $('input').attr('readonly', true);
                     $(':radio:not(:checked)').attr('disabled', true);
                     alert(response);
                 }
             });
         });

         $("#btn_checksid").click(function() {
             var StudentId = $("#student_id").val().trim();
             var Name = $("#student_name").val();
             var Grade = $("#grade").val().trim();
             var ParentIncome = $("#parent_income").val().trim();
             var Volunteer = $("#volunteer").val().trim();
             var PhoneNum = $("#phone_number").val().trim();
             var Type = $('input[name=e-student_type_radio]:checked', '#e-student_type').val();
             $.ajax({
                 url: 'save-checksid.php',
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
                     <ul class="navbar-nav mr-auto w-150 justify-content-end">
                         <li class="nav-item active">
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php" style="width: 100px; height: 60px;">
                                 หน้าหลัก
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php">
                                 กำหนดการ
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php" style="width: 130px; height: 60px;">
                                 ติดตามการกู้
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php" style="width: 100px; height: 60px;">
                                 ยื่นขอกู้
                             </a>
                         </li>

                         <li class="nav-item">
                             <a class="nav-link" href="studentpage.php" style="width: 150px; height: 60px;">
                                 ข่าวประชาสัมพันธ์
                             </a>
                         </li>
                         <li class=" nav-item">
                             <a class="nav-link" href="studentpage.php" style="width: 130px; height: 60px;">
                                 คำถามที่พบบ่อย
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="logout.php" style="width: 300px; height: 60px;">
                                 ออกจากระบบ
                             </a>
                         </li>

                         <li class="nav-item">
                             <a class="nav-link" style="width: 300px; height: 60px;">
                                 <div class="icon">
                                     <i class="lni-user" style="padding-right:5px;"></i>
                                     <?php echo $_SESSION['name']; ?>
                                 </div>
                             </a>
                         </li>

                     </ul>
                 </div>
             </div>



             <!-- เมนูสำหรับ mobile -->
             <ul class=" mobile-menu">
                 <li>
                     <a class="page-scrool" href="studentpage.php">หน้าหลัก</a>
                 </li>
                 <li>
                     <a class="page-scrool" href="studentpage.php">กำหนดการ</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="studentpage.php">ติดตามการกู้</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="studentpage.php">ยื่นขอกู้</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="studentpage.php">ข่าวประชาสัมพันธ์</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="studentpage.php">คำถามที่พบบ่อย</a>
                 </li>
                 <li>
                     <a class="page-scroll" href="logout.php">ออกจากระบบ</a>
                 </li>
                 <li>
                     <a class=" lni-user" style="padding-right:5px;"><?php echo $_SESSION['name']; ?></a>

                 </li>
             </ul>

             <!-- จบ เมนูสำหรับ mobile -->

         </nav>
         <!-- จบส่วน Navbar -->



         <!-- Schedule Section Start สร้างคำร้อง -->
         <section id="schedules" class="schedule section-padding">
             <div class="container">
                 <div class="row justify-content-center">
                     <div class="col-12">
                         <div class="section-title-header text-center">
                             <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">ยื่นขอกู้</h1>
                             <h5 class="wow fadeInDown" data-wow-delay="0.2s">
                                 สร้างคำร้องขอกู้ร้องการกู้ยืมเงินเพื่อการศึกษา กรอ. และ กยศ. มหาวิทยาลัยธรรมศาสตร์</h5>
                             <h6><span
                                     style="background-color: #FFFF00"><?php echo "บันทึกข้อมูลได้ตั้งแต่ &nbsp " . date("d-m-Y", strtotime($_start_request)) .
                                                                                    "  &nbsp ถึงวันที่ &nbsp" . date("d-m-Y", strtotime($_end_request)) ?>
                             </h6>

                         </div>
                     </div>
                     <div class=" col-lg-7 col-md-12 col-xs-12">
                         <div class="container-form wow fadeInLeft" data-wow-delay="0.2s">
                             <div class="form-wrapper">
                                 <form id="e-student_type">
                                     <div class="a">
                                         <div class="row form-group">
                                             <label class="col-md-4 control-label"
                                                 for="e-student_type">ประเภทกองทุน</label>
                                             <br>
                                             <br>
                                             <div class="col-md-10">
                                                 <label class="radio-inline"><input type="radio"
                                                         name="e-student_type_radio" value="1"
                                                         <?php if ($_student_type == 1) {
                                                                                                                                                echo 'checked="checked"';
                                                                                                                                            } ?>>
                                                     &nbsp กรอ.รายใหม่&nbsp </label>

                                                 <label class="radio-inline"><input type="radio"
                                                         name="e-student_type_radio" value="2"
                                                         <?php if ($_student_type == 2) {
                                                                                                                                                echo 'checked="checked"';
                                                                                                                                            } ?>>&nbsp
                                                     กรอ.รายเก่า
                                                     &nbsp </label>
                                                 <label class="radio-inline"><input type="radio"
                                                         name="e-student_type_radio" value="3"
                                                         <?php if ($_student_type == 3) {
                                                                                                                                                echo 'checked="checked"';
                                                                                                                                            } ?>>&nbsp
                                                     กยศ.รายใหม่
                                                     &nbsp </label>
                                                 <label class="radio-inline"><input type="radio"
                                                         name="e-student_type_radio" value="4"
                                                         <?php if ($_student_type == 4) {
                                                                                                                                                echo 'checked="checked"';
                                                                                                                                            } ?>>&nbsp
                                                     กยศ.รายเก่า
                                                     &nbsp </label>

                                             </div>
                                             <div class="col-md-4 panel panel-heading" style="display:none; color:red"
                                                 id="contact_error"></div>
                                         </div>
                                     </div>
                                 </form>
                                 <div class="c">
                                     <div class="row form-group">
                                         <label class="col-md-3 control-label" for="student_id">รหัสนักศึกษา</label>
                                         <div class="col-md-10">
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="glyphicon glyphicon-user"></i>
                                                 </span>
                                                 <input style="width: 500px" id="student_id" name="student_id"
                                                     value=" <?php echo $_SESSION["studentID"] ?>"
                                                     class="form-control input-md" type="text" readonly>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row form-group">
                                         <label class="col-md-3 control-label"
                                             for="student_name">ชื่อจริง-นามสกุล</label>
                                         <div class="col-md-10">
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="glyphicon glyphicon-user"></i>
                                                 </span>
                                                 <input style="width: 500px" id="student_name" name="student_name"
                                                     value="<?php echo $_SESSION["name"] ?>"
                                                     class="form-control input-md" type="text" readonly>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="row form-group">
                                         <label class="col-md-3 control-label" for="grade">เกรดเฉลี่ย</label>
                                         <div class="col-md-10">
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="glyphicon glyphicon-user"></i>
                                                 </span>
                                                 <input style="width: 500" id="grade" name="grade" placeholder=""
                                                     class="form-control input-md" type="text" maxlength="4" min="0.00"
                                                     max="4.00" value=" <?php echo $_grade; ?> ">
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row form-group">
                                         <label class="col-md-5 control-label"
                                             for="parent_income">รายได้ผู้ปกครอง/ปี(บาท)</label>
                                         <div class="col-md-10">
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="glyphicon glyphicon-user"></i>
                                                 </span>
                                                 <input style="width: 500px" id="parent_income" name="parent_income"
                                                     placeholder="" class="form-control input-md" type="number" value="<?php echo $_parent_income; ?>
">
                                             </div>
                                         </div>
                                     </div>
                                     <div class=" row form-group">
                                         <label class="col-md-5 control-label"
                                             for="volunteer">จำนวนจิตอาสา(ชั่วโมง)</label>
                                         <div class="col-md-10">
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="glyphicon glyphicon-user"></i>
                                                 </span>
                                                 <input style="width: 500px" id="volunteer" name="volunteer"
                                                     placeholder="" class="form-control input-md" type="text"
                                                     value=" <?php echo $_volunteer; ?>">
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row form-group">
                                         <label class="col-md-3 control-label" for="phone_number">เบอร์ติดต่อ
                                         </label>

                                         <div class="col-md-10">
                                             <div class="input-group">
                                                 <span class="input-group-addon">
                                                     <i class="glyphicon glyphicon-user"></i>
                                                 </span>
                                                 <input style="width: 500px" id="phone_number" name="phone_number"
                                                     placeholder="" class="form-control input-md" type="text"
                                                     maxlength="10" value=" <?php echo $_phone_number; ?>">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-4 panel panel-heading" style="display:none; color:red"
                                         id="address_error"></div>
                                 </div>
                                 <div class="d">
                                     <div class="form-group row">
                                         <?php $paymentDate = new DateTime(); // Today
                                                // echo $paymentDate->format('d/m/Y'); // echos today!
                                                $contractDateBegin = new DateTime($_start_request);
                                                $contractDateEnd = new DateTime($_end_request);

                                                if (
                                                    $paymentDate->getTimestamp() > $contractDateBegin->getTimestamp() &&
                                                    $paymentDate->getTimestamp() < $contractDateEnd->getTimestamp()
                                                ) {
                                                    // echo "is between"; 
                                                    if ($_Status_state1 != 2) { ?>
                                         <div class="col-md-12 text-center">
                                             <button class="btn btn-warning " type="button" onclick="Edit()">
                                                 แก้ไขข้อมูล

                                             </button>
                                             <button id="btn_save" name="btn_save" class="btn btn-large btn-success ">
                                                 บันทึกข้อมูล</button>
                                             <button id="btn_checksid" name="btn_checksid" class="btn btn-secondary"
                                                 type="button" onclick="Check()">
                                                 ตรวจสอบสิทธิ์เบื้องต้น</button>
                                         </div>
                                         <?php }
                                                } else {
                                                } ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>
             <!-- Schedule Section End สร้างคำร้อง -->

             <!-- Footer Section Start -->
             <footer class=" footer-area section-padding">
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
                                     <li><a class="facebook" href="https://www.facebook.com/studentservicetu/"><i
                                                 class="lni-facebook-filled"></i></a></li>
                                     <li><a class="twitter"
                                             href="http://satu.colorpack.net/index.php/th/student-services/student-loan1"><i
                                                 class="lni lni-world"></i></a></li>
                                     <!-- <li><a class="linkedin" href="#"><i class="lni-linkedin-filled"></i></a></li>
                                     <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li> -->
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

                echo " <a class='h-100 row align-items-center' href='login.html'
            style='text-align:center; vertical-align: middle;'>
            <h1>กรุณาเข้าสู่ระบบ</h1>
        </a>";
                ?>
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