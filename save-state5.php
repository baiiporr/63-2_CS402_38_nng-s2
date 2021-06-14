<?php
//connect db
session_start();
$student_id = $_SESSION['studentID'];
$serverName = "localhost";
$userName = "root";
$userPassword = "";
$dbName = "trackkingsystem";

$objConnect = mysqli_connect($serverName, $userName, $userPassword, $dbName);
mysqli_select_db($objConnect, "trackkingsystem");
mysqli_set_charset($objConnect, "utf8");
mysqli_query($objConnect, "SET NAMES UTF8");
//
$status = $_POST['status'];

$select_last = "SELECT * FROM semester ORDER BY id DESC LIMIT 0, 1";
$objQuerySelect_last = mysqli_query($objConnect, $select_last);
$last = mysqli_fetch_array($objQuerySelect_last);
$term = "";
$year = "";
if (mysqli_num_rows($objQuerySelect_last) != 0) {
    $term = $last['term'];
    $year = $last['year'];
}


$select = "SELECT * FROM state5 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year'";
$objQuerySelect = mysqli_query($objConnect, $select);

$count = 0;

while ($row = mysqli_fetch_assoc($objQuerySelect)) {
    $count++;
}


if ($count == 0) {
    $insert = "INSERT INTO state5 (Student_ID, term, year, Status)
            VALUES ('$student_id','$term', '$year', $status)";
    $objQuery = mysqli_query($objConnect, $insert);

    if (!$objQuery) {
        echo "Error: INSERT" . $objQuery . "<br>" . $objConnect->error;
    } else {
        echo "บันทึกข้อมูลสำเร็จ";
    }
} else {
    $update = "UPDATE state5 SET term = '$term', year ='$year', Status='$status'
        WHERE Student_ID = $student_id";
    $objQuery = mysqli_query($objConnect, $update);

    if (!$objQuery) {
        echo "Error: UPDATE" . $objQuery . "<br>" . $objConnect->error;
    } else {
        echo "บันทึกข้อมูลสำเร็จ";
    }
}

if ($status == 2) {
    $insert = "INSERT INTO all_state (Student_ID, term, year, state)
            VALUES ('$student_id','$term', '$year', 5)";
    $objQuery = mysqli_query($objConnect, $insert);
    echo $status;
}

if ($status == 3) {
    $update = "UPDATE all_state SET term= '$term', year ='$year', state = 0
        WHERE Student_ID = $student_id";
    $objQuery = mysqli_query($objConnect, $update);
}

mysqli_close($objConnect);