<?php
session_start();

$username = $_POST['username'];
$pass = $_POST['password'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://restapi.tu.ac.th/api/v1/auth/Ad/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n\t\"UserName\":\"$username\",\n\t\"PassWord\":\"$pass\"\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Application-Key: TU65e1f570077f0be33201447720639c54202fd702e3562b2f028583481706a462eb85b37bc82989b425fd926959ba9809"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $data = json_decode($response);
  // echo $response;
  if ($data->status == 1) {
    //header('Location: student.html');
    if ($data->type == "student") {
      $_SESSION['name'] = $data->displayname_th;
      $_SESSION['studentID'] = $username;
      echo 1;
    } else if ($data->type == "employee") {
      $_SESSION['name'] = $data->displayname_th;
      echo 2;
    }
  } else {
    if ($data->message == "Password Invalid!") {
      echo "รหัสผ่านของท่านไม่ถูกต้อง";
    } else {
      echo "เลขทะเบียน/เลขประจำตัว หรือ รหัสผ่านของท่านไม่ถูกต้อง";
    }
  }
}