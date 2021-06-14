<?php
include_once 'data.php';
if (isset($_POST['submitaddpicinfo'])) {

   $file = $_FILES['fileToUploadinfo']['name'];
   $file_loc = $_FILES['fileToUploadinfo']['tmp_name'];
   $file_size = $_FILES['fileToUploadinfo']['size'];
   $file_type = $_FILES['fileToUploadinfo']['type'];
   $folder = "picnews/";

   /* new file size in KB */
   $new_size = $file_size / 1024;
   /* new file size in KB */

   /* make file name in lower case */
   $new_file_name = strtolower($file);
   /* make file name in lower case */

   $final_file = str_replace(' ', '-', $new_file_name);

   if (move_uploaded_file($file_loc, $folder . $final_file)) {
      $sql = "INSERT INTO file_news(file_name,type,size) VALUES('$final_file','$file_type','$new_size')";
      mysqli_query($conn, $sql);
      //echo "ไฟล์ ". htmlspecialchars( basename( $_FILES["fileToUploadinfo"]["name"])). " ได้รับการอัปโหลด" ;
      echo "<script type='text/javascript'>";
      echo "alert('ไฟล์รูปภาพข่าวสารได้รับการอัปโหลด');";
      echo "window.location = 'picnews.php'; ";
      echo "</script>";
   } else {
      echo  "ขออภัยเกิดข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ";
      echo "<script type='text/javascript'>";
      echo "alert('ขออภัยเกิดข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ');";
      echo "window.location = 'picnews.php'; ";
      echo "</script>";
   }
}