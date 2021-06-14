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

?>
<!-- end connecdb -->

<!-- แสดงข้อมูล   -->
<?php

$select_last = "SELECT * FROM semester ORDER BY id DESC LIMIT 0, 1";
$objQuerySelect_last = mysqli_query($objConnect, $select_last);
$last = mysqli_fetch_array($objQuerySelect_last);
$term = "";
$year = "";
if (mysqli_num_rows($objQuerySelect_last) != 0) {
    $term = $last['term'];
    $year = $last['year'];
}

$select = "SELECT * FROM user_info WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
$objQuerySelect = mysqli_query($objConnect, $select);
$grade = true;
$parent_income = true;
$volunteer = true;
$pass = false;
$_grade = null;
$_parent_income = "";
$_volunteer = "";
$_student_type = "";
$_phone_number = "";
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
    $_student_type = $row['Estudentloan_Type'];
    $_phone_number = $row['Phone_Number'];
    $count++;
}
if ($count == 0) {
    $pass = false;
}
$selec_state = "SELECT MAX(State) AS stateMax FROM all_state WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
$objQuerySelect_state = mysqli_query($objConnect, $selec_state);
$state = mysqli_fetch_array($objQuerySelect_state);

$_year = 0;
$_term = 0;

$select = "SELECT * FROM semester";
$objQuerySelect = mysqli_query($objConnect, $select);
while ($row = mysqli_fetch_assoc($objQuerySelect)) {
    $_year = $row['year'];
    $_term = $row['term'];
}

?>

<!-- จบแสดงข้อมูล -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AdminPage</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>
    $(document).ready(function() {
        $("#btn_approve").click(function() {
            var stutdentID = $("#txtKeyword").val();
            $.ajax({
                url: 'save-studentID.php',
                type: 'post',
                data: {
                    stutdentID: stutdentID,
                },
                success: function(response) {
                    if (response == "กรุณากรอกเลขรหัส/ชื่อนักศึกษา") {
                        alert(response);
                    } else {
                        window.location.href = 'verify-status.php';
                    }
                }
            })
        });

        $("#btn_tracking").click(function() {
            var stutdentID = $("#txtKeyword").val();
            $.ajax({
                url: 'save-studentID.php',
                type: 'post',
                data: {
                    stutdentID: stutdentID,
                },
                success: function(response) {
                    // alert(response);
                    <?php
                        $select = "SELECT * FROM all_datestartend";
                        $objQuerySelect = mysqli_query($objConnect, $select);
                        $_start_state1;
                        $_end_state1;
                        $_start_state2;
                        $_end_state2;
                        $_start_state3;
                        $_end_state3;
                        $_start_state4;
                        $_end_state4;
                        $_start_state5;
                        $_end_state5;

                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_start_state1 = $row['start_state1'];
                            $_end_state1 = $row['end_state1'];
                            $_start_state2 = $row['start_state2'];;
                            $_end_state2 = $row['end_state2'];
                            $_start_state3 = $row['start_state3'];
                            $_end_state3 = $row['end_state3'];
                            $_start_state4 = $row['start_state4'];;
                            $_end_state4 = $row['end_state4'];
                            $_start_state5 = $row['start_state5'];
                            $_end_state5 = $row['end_state5'];
                        }

                        $paymentDate = new DateTime();


                        $select_state1 = "SELECT * FROM state1 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state1);
                        $_Status_state1 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state1 = $row['Status_Doc'];
                        }
                        $contractDateBegin = new DateTime($_start_state1);
                        $contractDateEnd = new DateTime($_end_state1); ?>
                    <?php

                        if (
                            $paymentDate->getTimestamp() > $contractDateEnd->getTimestamp() &&
                            $_Status_state1 == 1
                        ) {

                            $update = "UPDATE state1 SET Status_Doc ='3' WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                            $objQuerySelect_state = mysqli_query($objConnect, $update);
                        }

                        $select_state2 = "SELECT * FROM state2 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state2);
                        $_Status_state2 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state2 = $row['Status'];
                        }

                        $contractDateBegin = new DateTime($_start_state2);
                        $contractDateEnd2 = new DateTime($_end_state2);

                        if (
                            $paymentDate->getTimestamp() > $contractDateEnd2->getTimestamp() &&
                            $_Status_state2 == 1
                        ) {

                            $update = "UPDATE state2 SET Status ='3' WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                            $objQuerySelect_state = mysqli_query($objConnect, $update);
                        }

                        $select_state3 = "SELECT * FROM state3 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                        $objQuerySelect_state3 = mysqli_query($objConnect, $select_state3);
                        $_Status_state3 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect_state3)) {
                            $_Status_state3 = $row['Status'];
                        }

                        $contractDateBegin = new DateTime($_start_state3);
                        $contractDateEnd3 = new DateTime($_end_state3);
                        if (
                            $paymentDate->getTimestamp() > $contractDateEnd3->getTimestamp() &&
                            $_Status_state3 == 1
                        ) {
                            $update = "UPDATE state3 SET Status ='3' WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                            $objQuerySelect_state = mysqli_query($objConnect, $update);
                        }

                        $select_state4 = "SELECT * FROM state4 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                        $objQuerySelect_state4 = mysqli_query($objConnect, $select_state4);
                        $_Status_state4 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect_state4)) {
                            $_Status_state4 = $row['Status'];
                        }

                        $contractDateBegin = new DateTime($_start_state4);
                        $contractDateEnd4 = new DateTime($_end_state4);
                        if (
                            $paymentDate->getTimestamp() > $contractDateEnd4->getTimestamp() &&
                            $_Status_state4 == 1
                        ) {
                            $update = "UPDATE state4 SET Status ='3' WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                            $objQuerySelect_state = mysqli_query($objConnect, $update);
                        }

                        $select_state5 = "SELECT * FROM state5 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state5);
                        $_Status_state5 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state5 = $row['Status'];
                        }

                        $contractDateBegin = new DateTime($_start_state5);
                        $contractDateEnd5 = new DateTime($_end_state5);
                        if (
                            $paymentDate->getTimestamp() > $contractDateEnd5->getTimestamp() &&
                            $_Status_state5 == 1
                        ) {
                            $update = "UPDATE state5 SET Status ='3' WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
                            $objQuerySelect_state = mysqli_query($objConnect, $update);
                        }

                        $select_state1 = "SELECT * FROM state1 WHERE Student_ID = '$student_id'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state1);
                        $_Status_state1 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state1 = $row['Status_Doc'];
                        }

                        $select_state2 = "SELECT * FROM state2 WHERE Student_ID = '$student_id'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state2);
                        $_Status_state2 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state2 = $row['Status'];
                        }

                        $select_state3 = "SELECT * FROM state3 WHERE Student_ID = '$student_id'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state3);
                        $_Status_state3 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state3 = $row['Status'];
                        }

                        $select_state4 = "SELECT * FROM state4 WHERE Student_ID = '$student_id'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state4);
                        $_Status_state4 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state4 = $row['Status'];
                        }

                        $select_state5 = "SELECT * FROM state5 WHERE Student_ID = '$student_id'";
                        $objQuerySelect = mysqli_query($objConnect, $select_state5);
                        $_Status_state5 = 0;
                        while ($row = mysqli_fetch_assoc($objQuerySelect)) {
                            $_Status_state5 = $row['Status'];
                        }
                        ?>
                }
            })
        });
    });
    </script>

</head>


<body id="page-top">
    <?php
    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminpage.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="sidebar-brand-text mx-3">TRACKING SYSTEM TU</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="adminpage.php">
                    <span>หน้าหลัก</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="fill-semesterandyear.php">
                    <span>ภาคการศึกษาและปีการศึกษา</span></a>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="p" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class=""></i>
                    <span>ภาคการศึกษาและปีการศึกษา</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="fill-semester.php">ภาคการศึกษา</a>
                            <a class="collapse-item" href="fill-year.php">กรอกปีการศึกษา</a>
                        </div>
                    </div>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" href="fill-datetime.php">
                    <span>กำหนดวันที่สำหรับการแก้ไข</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>อัพโหลดไฟล์ทั้งหมด</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="pic-pdf-schedule.php">ไฟล์/รูปตารางกำหนดการ</a>
                        <a class="collapse-item" href="picnews.php">รูปข่าวสาร</a>
                        <!-- <a class="collapse-item" href="qrcodeline.php">QRcodeLine</a> -->
                        <div class="collapse-divider"></div>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Tables ติดตามสถานะ-->
            <!-- <li class="nav-item">
                <a class="nav-link" href="tracking.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>ติดตามสถานะผู้กู้</span></a>
            </li> -->
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="reports-of-loan.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>สรุปรายงานการกู้ยืม</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>



                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 large"><?php echo $_SESSION["name"] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    ออกจากระบบ
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">



                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-base font-weight-bold text-primary text-uppercase mb-1">
                                                ภาคเรียน</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $_term ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-base font-weight-bold text-success text-uppercase mb-1">
                                                ปีการศึกษา</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $_year ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-base font-weight-bold text-info text-uppercase mb-1">
                                                ตารางกำหนดการ
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <!-- แสดงไฟล์PDF -->
                                                        <h6>
                                                            <?php
                                                                //ไฟล์pdf

                                                                //2. query ข้อมูลจากตาราง: 
                                                                $query = "SELECT * FROM file_pdf" or die("Error:");
                                                                //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result . 
                                                                $result = mysqli_query($objConnect, $query);
                                                                //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล: 

                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $pdffile = $row['file_name'];
                                                                    echo "<a  href=pdftable/$pdffile>$pdffile</a><br>";
                                                                }


                                                                ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--คลิกเพื่อโหลดไฟล์สรุปรายงาน-->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-3">
                                            <div class="text-base font-weight-bold text-warning text-uppercase mb-1">
                                                สรุปรายงานการกู้ยืม(แบบมีคู่)</div>
                                            <a class="btn btn-outline-warning" ;
                                                href="mapping.php">ดูไฟล์สรูุปรายงานการกู้ยืม(แบบมีคู่)</a>
                                        </div>
                                    </div>
                                    <div class="text-base font-weight-bold text-warning text-uppercase mb-1">
                                        <br>
                                        สรุปรายงานการกู้ยืม(แบบไร้คู่)
                                    </div>
                                    <a class="btn btn-outline-warning" ;
                                        href="notmapping.php">ดูไฟล์สรูุปรายงานการกู้ยืม(แบบไร้คู่)</a>
                                </div>

                            </div>
                        </div>
                        <!--คลิกเพื่อโหลดไฟล์สรุปรายงาน-->
                    </div>



                    <!-- phpสถานะ -->
                    <?php
                        ini_set('display_errors', 1);
                        error_reporting(~0);

                        $strKeyword = null;

                        if (isset($_POST["txtKeyword"])) {
                            $strKeyword = $_POST["txtKeyword"];
                        }
                        ?>
                    <!-- จบphpสถานะ -->

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-4 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary ">ติดตามสถานะผู้กู้</h6>
                                    <div class="dropdown no-arrow">
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form name="frmSearch" method="post"
                                        action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
                                        <div class="input-group mb-3">

                                            <input type="text" name="txtKeyword" class="form-control" id="txtKeyword"
                                                value="<?php echo $strKeyword; ?>"
                                                placeholder="ค้นหาจากรหัสนักศึกษา หรือ ชื่อจริง-นามสกุล"
                                                aria-label="folowstatus" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button id="btn_tracking" class="btn btn-outline-primary"
                                                    type="submit">ติดตาม</button>
                                            </div>
                                        </div>
                                        <h6 class="m-0 font-weight-bold text-primary text-center">
                                            สถานะการกู้ของ
                                            <?php if (isset($_SESSION['stutdentName'])) echo $_SESSION["stutdentName"] ?>
                                        </h6>
                                        <?php if (!empty($_SESSION['stutdentName'])) { ?>
                                        <br>
                                        <div class="pricing-list">
                                            <ul>
                                                <?php if ($_Status_state1 == 1) { ?>
                                                <i class="fas fa-circle text-warning"></i>
                                                <?php } else if ($_Status_state1 == 2) { ?>
                                                <i class="fas fa-circle text-success"></i>
                                                <?php } else if ($_Status_state1 == 3) { ?>
                                                <i class="fas fa-circle text-danger"></i>
                                                <?php } ?>
                                                <span class="text">
                                                    1.ยื่นคำร้องขอกู้</span><br><br>

                                                <?php if ($_Status_state2 == 1) { ?>
                                                <i class="fas fa-circle text-warning"></i>
                                                <?php } else if ($_Status_state2 == 2) { ?>
                                                <i class="fas fa-circle text-success"></i>
                                                <?php } else if ($_Status_state2 == 3) { ?>
                                                <i class="fas fa-circle text-danger"></i>
                                                <?php } ?>
                                                <span class="text">
                                                    2.ตรวจสอบสิทธิ์การกู้</span><br><br>

                                                <?php if ($_Status_state3 == 1) { ?>
                                                <i class="fas fa-circle text-warning"></i>
                                                <?php } else if ($_Status_state3 == 2) { ?>
                                                <i class="fas fa-circle text-success"></i>
                                                <?php } else if ($_Status_state3 == 3) { ?>
                                                <i class="fas fa-circle text-danger"></i>
                                                <?php } ?>
                                                <span class="text">
                                                    3.ทำสัญญาการกู้ยืม</span><br><br>

                                                <?php if ($_Status_state3 != 0) {
                                                            if ($_Status_state4 == 1) { ?>
                                                <i class="fas fa-circle text-warning"></i>
                                                <?php } else if ($_Status_state4 == 2) { ?>
                                                <i class="fas fa-circle text-success"></i>
                                                <?php } else if ($_Status_state4 == 3) { ?>
                                                <i class="fas fa-circle text-danger"></i>
                                                <?php }
                                                        } ?>


                                                <span class="text">
                                                    4.บันทึกค่าเล่าเรียน<br>&nbsp &nbsp
                                                    &nbsp/ค่าครองชีพ</span><br><br>

                                                <?php if ($_Status_state5 == 1) { ?>
                                                <i class="fas fa-circle text-warning"></i>
                                                <?php } else if ($_Status_state5 == 2) { ?>
                                                <i class="fas fa-circle text-success"></i>
                                                <?php } else if ($_Status_state5 == 3) { ?>
                                                <i class="fas fa-circle text-danger"></i>
                                                <?php } ?>
                                                <span class="text">
                                                    5.เซ็นต์แบบยืนยัน</span>

                                            </ul>
                                        </div>
                                        <?php } ?>
                                </div>
                                <div class="mt-1 text-center small" style="height:100px;">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-warning"></i> รอดำเนินการ
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> เสร็จสิ้น
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-danger"></i> ยกเลิก
                                    </span><br><br>
                                    <!--ปุ่ม-->
                                    <?php if (isset($_SESSION['studentID']) && !empty($_SESSION['studentID'])) { ?>

                                    <a class="btn  btn-outline-primary" ;
                                        id="btn_approve">ยืนยันแต่ละสถานะให้กับผู้กู้</a>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-5 col-lg-5">
                            <div class="card shadow mb-4" style="height: 550px;">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลผู้กู้</h6>
                                    <div class="dropdown no-arrow">

                                    </div>
                                </div>
                                <!-- Card Body -->
                                <!-- phpสถานะ -->
                                <?php if (isset($_SESSION['studentID']) && !empty($_SESSION['studentID'])) { ?>

                                <div class="card-body">
                                    <!-- phpสถานะ -->

                                    <?php

                                            include_once 'data.php';
                                            if (isset($_SESSION['studentID']) && !empty($_SESSION['studentID'])) {
                                                $stuID = $_SESSION['studentID'];
                                                $sql = "SELECT * FROM user_info WHERE  Student_ID = $stuID AND term = '$term' AND year = '$year' ";
                                            } else {
                                                $sql = "SELECT * FROM user_info WHERE term LIKE '%" . $term . "%' OR year LIKE '%" . $year . "%' OR Name LIKE '%" . $strKeyword . "%'  OR Student_ID LIKE '%" . $strKeyword . "%'";
                                            }
                                            $query = mysqli_query($conn, $sql);

                                            ?>

                                    <?php
                                            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                                            ?>
                                    <br>
                                    <h5> ประเภทกองทุน : <?php
                                                                    if ($result["Estudentloan_Type"] == 1) {
                                                                        echo "กรอ.รายใหม่";
                                                                    } else if ($result["Estudentloan_Type"] == 2) {
                                                                        echo "กรอ.รายเก่า";
                                                                    } else if ($result["Estudentloan_Type"] == 3) {
                                                                        echo "กยศ.รายใหม่";
                                                                    } else if ($result["Estudentloan_Type"] == 4) {
                                                                        echo "กยศ.รายเก่า";
                                                                    } ?></h5><br>

                                    <h5>รหัสนักศึกษา : <?php echo  $result["Student_ID"]; ?></h5><br>
                                    <h5>ชื่อ-นามสกุล : <?php echo $result["Name"]; ?></h5><br>
                                    <h5>เกรดเฉลี่ย : <?php echo $result["Grade"]; ?></h5><br>
                                    <h5> รายได้ผู้ปกครอง/ปี(บาท) :
                                        <?php echo number_format($result["Parent_Income"]); ?></h5><br>
                                    <h5> จำนวนจิตอาสา(ชั่วโมง) : <?php echo $result["Volunteer"]; ?></h5><br>
                                    <h5> เบอร์ติดต่อ : <?php echo $result["Phone_Number"]; ?></h5><br>
                                    <br>
                                    <?php
                                            }
                                            ?>

                                    <?php
                                            mysqli_close($conn);
                                            ?>
                                    <?php } ?>
                                    <!-- จบphpสถานะ -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                        </div>
                        <!-- End of Main Content -->

                        <!-- Footer -->
                        <!-- <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>ระบบติดตามสถานะการกู้ยืมเงินกรอ. และ กยศ. มหาวิทยาลัยธรรมศาสตร์ Tracking
                                        System For e-Studentloan In Thammasat University</span>
                                </div>
                            </div>
                        </footer> -->
                        <!-- End of Footer -->

                    </div>
                    <!-- End of Content Wrapper -->

                </div>
                <!-- End of Page Wrapper -->

                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ต้องการออกจากระบบ?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                                <a class="btn btn-primary" href="logout.php">ออกจากระบบ</a>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
            } else

                echo "<h1>กรุณาเข้าสู่ระะบบ</h1>"
                ?>

                <!-- Bootstrap core JavaScript-->
                <script src="vendor/jquery/jquery.min.js"></script>
                <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="js/sb-admin-2.min.js"></script>

                <!-- Page level plugins -->
                <script src="vendor/chart.js/Chart.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="js/demo/chart-area-demo.js"></script>
                <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>