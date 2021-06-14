<?php

session_start();
$serverName = "localhost";
$userName = "root";
$userPassword = "";
$dbName = "trackkingsystem";

$objConnect = mysqli_connect($serverName, $userName, $userPassword, $dbName);
mysqli_select_db($objConnect, "trackkingsystem");
mysqli_set_charset($objConnect, "utf8");
mysqli_query($objConnect, "SET NAMES UTF8");

$startRequest = $_POST['startRequest'];
$endRequest = $_POST['endRequest'];
$startState1 = $_POST['startState1'];
$endState1 = $_POST['endState1'];
$startState2 = $_POST['startState2'];
$endState2 = $_POST['endState2'];
$startState3 = $_POST['startState3'];
$endState3 = $_POST['endState3'];
$startState4 = $_POST['startState4'];
$endState4 = $_POST['endState4'];
$startState5 = $_POST['startState5'];
$endState5 = $_POST['endState5'];


$insert = "INSERT INTO all_datestartend (start_createrequest, end_createrequest, start_state1, end_state1, start_state2, end_state2,
                                        start_state3, end_state3, start_state4, end_state4, start_state5, end_state5)
            VALUES ('$startRequest','$endRequest', '$startState1', '$endState1', '$startState2', '$endState2', '$startState3', '$endState3', '$startState4', '$endState4'
            , '$startState5', '$endState5')";
$objQuery = mysqli_query($objConnect, $insert);

if (!$objQuery) {
    echo "Error: INSERT" . $objQuery . "<br>" . $objConnect->error;
} else {
    echo "บันทึกข้อมูลสำเร็จ";
}

mysqli_close($objConnect);