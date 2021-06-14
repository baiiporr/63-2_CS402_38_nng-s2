<?php
//connect db
session_start();
$serverName = "localhost";
$userName = "root";
$userPassword = "";
$dbName = "trackkingsystem";

$objConnect = mysqli_connect($serverName, $userName, $userPassword, $dbName);
mysqli_select_db($objConnect, "trackkingsystem");
mysqli_set_charset($objConnect, "utf8");
mysqli_query($objConnect, "SET NAMES UTF8");

$student_id = $_POST['stutdentID'];

// if (isset($_SESSION['studentID']) && !empty($_SESSION['studentID'])) {
//     $student_id = $_SESSION['studentID'];
//     echo $student_id . ' - ';
// }
// echo $student_id . ' - ';

if ($student_id == "") {
    echo "กรุณากรอกเลขรหัส/ชื่อนักศึกษา";
} else {
    $sql = "SELECT Student_ID AS stuID FROM user_info WHERE Name LIKE '%" . $student_id . "%'  OR Student_ID LIKE '%" . $student_id . "%' ";
    $query = mysqli_query($objConnect, $sql);
    $stutdentID = mysqli_fetch_array($query);
    $_SESSION['studentID'] = $stutdentID['stuID'];
    $student_id = $_SESSION['studentID'];
    $select = "SELECT * FROM user_info WHERE Student_ID = '$student_id'";
    $objQuerySelect = mysqli_query($objConnect, $select);
    $count = 0;
    while ($row = mysqli_fetch_assoc($objQuerySelect)) {
        $_SESSION['stutdentName'] = $row['Name'];
        $count++;
    }

    if ($count == 0) {
        $_SESSION['stutdentName'] = "";
    }

    // echo $_SESSION['studentID'];
}


mysqli_close($objConnect);