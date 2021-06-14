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
//

$student_id = $_POST['StudentId'];
$name = $_POST['Name'];
$grade = $_POST['Grade'];
$parent_income = $_POST['ParentIncome'];
$volunteer = $_POST['Volunteer'];
$phone_number = $_POST['PhoneNum'];
$type_estudent = $_POST['Type'];

$select = "SELECT * FROM user_info WHERE Student_ID = '$student_id'";
$objQuerySelect = mysqli_query($objConnect, $select);

$count = 0;

while ($row = mysqli_fetch_assoc($objQuerySelect)) {
    $count++;
}


$select_last = "SELECT * FROM semester ORDER BY id DESC LIMIT 0, 1";
$objQuerySelect_last = mysqli_query($objConnect, $select_last);
$last = mysqli_fetch_array($objQuerySelect_last);

$term = $last['term'];
$year = $last['year'];

if ($count == 1) {
    $updateDate = date("Y-m-d h:i:sa");
    $update = "UPDATE user_info SET term = '$term', year ='$year', Name='$name', Grade='$grade', Parent_Income='$parent_income',Volunteer='$volunteer',
        Phone_Number='$phone_number', Estudentloan_Type='$type_estudent', UpDate_Date = '$updateDate'
        WHERE Student_ID = $student_id";
    $objQuery = mysqli_query($objConnect, $update);

    if (!$objQuery) {
        echo "Error: 1" . $objQuery . "<br>" . $objConnect->error;
    } else {
        echo "บันทึกข้อมูลสำเร็จ";
    }
} else {
    $createDate = date("Y-m-d h:i:sa");
    $updateDate = date("Y-m-d h:i:sa");
    $insert = "INSERT INTO user_info (Student_ID,term,year,Name, Grade, Parent_Income, Volunteer,Phone_Number, Estudentloan_Type, Create_Date, UpDate_Date)
            VALUES ('$student_id','$term', '$year', '$name', '$grade', '$parent_income','$volunteer','$phone_number','$type_estudent', '$createDate', '$updateDate')";
    $objQuery = mysqli_query($objConnect, $insert);

    if (!$objQuery) {
        echo "Error: 2" . $objQuery . "<br>" . $objConnect->error;
    } else {
        echo "บันทึกข้อมูลสำเร็จ";
    }
}

mysqli_close($objConnect);