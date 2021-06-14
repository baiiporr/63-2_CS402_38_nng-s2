<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('data.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//สร้างตัวแปรสำหรับรับค่า member_id จากไฟล์แสดงข้อมูล
$member_id = $_REQUEST["PDF_id"];

//ลบข้อมูลออกจาก database ตาม member_id ที่ส่งมา

$sql = "DELETE FROM file_pdf WHERE id='$member_id'";
$result = mysqli_query($conn, $sql) or die("Error in query: $sql ");

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม

if ($result) {
	echo "<script type='text/javascript'>";
	echo "alert('ลบเสร็จสิ้น');";
	echo "window.location = 'pic-pdf-schedule.php'; ";
	echo "</script>";
} else {
	echo "<script type='text/javascript'>";
	echo "alert('การลบผิดพลาดกรุณาลบอีกครั้ง');";
	echo "</script>";
}
?>