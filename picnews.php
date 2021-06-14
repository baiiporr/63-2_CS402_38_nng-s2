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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>อัพโหลดรูปข่าวสาร</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                <div class="sidebar-brand-text mx-3">TRACKING SYSTEM TU</sup>
                </div>
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
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

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-4 text-gray-800">อัพโหลดไฟล์รูปภาพสำหรับข่าวสาร</h1>

                        <div class="row">

                            <div class="col-lg-6">


                                <!-- Circle Buttons -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">เจ้าหน้าอัพโหลดไฟล์รูปภาพ </h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="save-picnew.php" name="form1" method="post"
                                            enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">ไฟล์รูปภาพข่าวสาร(แสดงเพียงแค่
                                                    รูปภาพเท่านั้น)</label>
                                                <input class="form-control" type="file" name="fileToUploadinfo"
                                                    id="fileToUploadinfo">
                                            </div>
                                            <div class="col-md-12 text-center">

                                                <input type="submit" class=btncolor:black value="บันทึกไฟล์ลงระบบ"
                                                    id="submitaddpicinfo" name="submitaddpicinfo" class="btn ass_btn  ">
                                            </div>
                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>



                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">ไฟล์ pdf ที่อัพโหลดเสร็จสิ้น</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                    //ไฟล์jpg,png
                                    //1. เชื่อมต่อ database: 
                                    //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
                                    //2. query ข้อมูลจากตาราง: 
                                    $query = "SELECT * FROM file_news" or die("Error:");
                                    //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result . 
                                    $result = mysqli_query($objConnect, $query);
                                    //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล: 
                                    echo "<table border='1' align='center' width='100'>";
                                    while ($row = mysqli_fetch_array($result)) {

                                        $pdffile = $row['file_name'];
                                        echo "<tr>";
                                        echo "<td>" . "<img src='picnews/" . $row["file_name"] . "' width='500'>" . "</td>";
                                        echo "<td><a href='delete-picnews.php?News_id=$row[0]' onclick=\"return confirm('คุณต้องการลบบันทึกนี้')\">ลบ</a></td> ";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                    //5. close connection
                                    mysqli_close($objConnect);

                                    ?>
                            </div>
                        </div>



                    </div>
                    <!-- End of Content Wrapper -->



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
                            <a class="btn btn-primary" href="login.html">ออกจากระบบ</a>
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