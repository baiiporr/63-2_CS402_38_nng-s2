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
$checkArray = json_decode(stripslashes($_POST['checkArray']));
$status = $_POST['status'];
// echo $status;
$doc1 = 0;
$doc2 = 0;
$doc3 = 0;
$doc4 = 0;
$doc5 = 0;
$doc6 = 0;
$doc7 = 0;
$doc8 = 0;
$doc9 = 0;
$doc10 = 0;
$doc11 = 0;
foreach ($checkArray as $value) {
    // echo $value . " ";
    if ($value == 1) {
        $doc1 = 1;
    }
    if ($value == 2) {
        $doc2 = 1;
    }
    if ($value == 3) {
        $doc3 = 1;
    }
    if ($value == 4) {
        $doc4 = 1;
    }
    if ($value == 5) {
        $doc5 = 1;
    }
    if ($value == 6) {
        $doc6 = 1;
    }
    if ($value == 7) {
        $doc7 = 1;
    }
    if ($value == 8) {
        $doc8 = 1;
    }
    if ($value == 9) {
        $doc9 = 1;
    }
    if ($value == 10) {
        $doc10 = 1;
    }
    if ($value == 11) {
        $doc11 = 1;
    }
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



$select1 = "SELECT * FROM state1 WHERE Student_ID = '$student_id' AND term = '$term' AND year = '$year' ";
$objQuerySelect1 = mysqli_query($objConnect, $select1);

$count = 0;

while ($row = mysqli_fetch_assoc($objQuerySelect1)) {
    $count++;
}

if ($count == 0) {
    $insert = "INSERT INTO state1 (Student_ID, term, year, LoanFrom_Pic, Grade, Income_Salary_Payslip, Id_Card, Change_Name, Location_House, Pic_House, Death, Form_Advisor, Book_Bank, Other_Doc, Status_Doc)
            VALUES ('$student_id','$term', '$year', $doc1, $doc2, $doc3, $doc4, $doc5, $doc6, $doc7, $doc8, $doc9, $doc10, $doc11, $status)";
    $objQuery = mysqli_query($objConnect, $insert);

    if (!$objQuery) {
        echo "Error: INSERT" . $objQuery . "<br>" . $objConnect->error;
    } else {
        echo "บันทึกข้อมูลสำเร็จ";
    }
} else {
    $update = "UPDATE state1 SET term = '$term', year ='$year', LoanFrom_Pic='$doc1', Grade='$doc2', Income_Salary_Payslip='$doc3', Id_Card='$doc4',
        Change_Name='$doc5', Location_House='$doc6', Pic_House='$doc7', Death='$doc8', Form_Advisor='$doc9', Book_Bank='$doc10', Other_Doc='$doc11', Status_Doc='$status'
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
            VALUES ('$student_id','$term', '$year', 1)";
    $objQuery = mysqli_query($objConnect, $insert);
}

if ($status == 3) {
    $update = "UPDATE all_state SET term= '$term', year ='$year', state = 0
        WHERE Student_ID = $student_id";
    $objQuery = mysqli_query($objConnect, $update);
}

mysqli_close($objConnect);