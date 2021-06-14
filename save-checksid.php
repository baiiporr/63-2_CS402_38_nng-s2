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

// $student_id = $_POST['StudentId'];

// $select = "SELECT * FROM user_info WHERE Student_ID = '$student_id'";
// $objQuerySelect = mysqli_query($objConnect, $select);
$grade = true;
$parent_income = true;
$volunteer = true;
$pass = false;
$_grade;
$_parent_income;
$_volunteer;
$_sutdent_type;
$_phone_number;
// $count = 0;
$student_id = $_POST['StudentId'];
$name = $_POST['Name'];
$grade = $_POST['Grade'];
$parent_income = $_POST['ParentIncome'];
$volunteer = $_POST['Volunteer'];
$phone_number = $_POST['PhoneNum'];
$type_estudent = $_POST['Type'];
// while ($row = mysqli_fetch_assoc($objQuerySelect)) {
if ($grade < 1.90) {
    $grade = false;
}
if ($type_estudent == 3 || $type_estudent == 4) {
    if ($parent_income > 360000) {
        $parent_income = false;
    }
}
if ($volunteer < 36) {
    $volunteer = false;
}
if ($grade && $parent_income && $volunteer) {
    $pass = true;
}
// $_grade = $row['Grade'];
// $_parent_income = $row['Parent_Income'];
// $_volunteer = $row['Volunteer'];
// $_sutdent_type = $row['Estudentloan_Type'];
// $_phone_number = $row['Phone_Number'];
// $count++;
// }
// if ($count == 0) {
//     $pass = false;
// }

$a = "";
$a1 = "";
$a2 = "";
$a3 = "";

if ($grade == true) {
    $a = " เกรดเฉลี่ยผ่านตามเกณฑ์การกู้ ";
} else {
    $a = " เกรดเฉลี่ยไม่ผ่านตามเกณฑ์การกู้ (ต้องมากกว่า 1.90) ";
}
if ($parent_income == true) {
    $a1 = " รายได้ผู้ปกครอง/ปี ผ่านตามเกณฑ์การกู้ ";
} else {
    $a1 = " รายได้ผู้ปกครอง/ปี ไม่ผ่านตามเกณฑ์การกู้ (ต้องไม่เกิน 360,000/ปี) ";
}
if ($volunteer == true) {
    $a2 = " จำนวนจิตอาสา ผ่านตามเกณฑ์การกู้ ";
} else {
    $a2 = " จำนวนจิตอาสา ไม่ผ่านตามเกณฑ์การกู้ (ต้องไม่ต่ำกว่า 36 ชั่วโมง) ";
}
if ($pass == true) {
    $a3 = " มีสิทธิ์ผ่านการกู้ ";
} else {
    $a3 = " ไม่มีสิทธิ์ผ่านการกู้ (ติดต่อกับทางเจ้าหน้าที่ที่รับผิดชอบการกู้ยืมเงิน มธ.) ";
}

echo $a;
echo "
";
echo  $a1;
echo "
";
echo $a2;
echo "
";
echo $a3;


mysqli_close($objConnect);