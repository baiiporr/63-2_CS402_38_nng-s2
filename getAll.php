<?php

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

$select_last = "SELECT * FROM semester ORDER BY id DESC LIMIT 0, 1";
$objQuerySelect_last = mysqli_query($objConnect, $select_last);
$last = mysqli_fetch_array($objQuerySelect_last);

$term = $last['term'];
$year = $last['year'];


$select_user = "SELECT * FROM user_Info WHERE Term = '2' && Year = '2565'";
$objQuerySelect_user = mysqli_query($objConnect, $select_user);
$count = 0;
while ($row = mysqli_fetch_assoc($objQuerySelect_user)) {
    echo $row['Student_ID'] . ' ';
    echo $row['Name'] . ' ';
    echo $row['Grade'] . ' ';
    echo $row['Parent_Income'] . ' ';
    echo $row['Volunteer'] . ' ';
    echo $row['Phone_Number'] . ' ';
    echo $row['Estudentloan_Type'] . '<br/>';
    $count++;
}

echo 'จำนวนนักศึกษาที่ยื่นคำร้องขอกู้มี ' . $count . ' คน';

$select_user = "SELECT * FROM state4 WHERE Student_ID = '$student_id' ";
$objQuerySelect_user = mysqli_query($objConnect, $select_user);
$FeeMoney_all = 0;
$Cost_Of_Living_all = 0;
while ($row = mysqli_fetch_assoc($objQuerySelect_user)) {
    $FeeMoney_all += $row['FeeMoney'];
    $Cost_Of_Living_all += $row['Cost_Of_Living'];
}

echo $FeeMoney_all . ' ' . $Cost_Of_Living_all;