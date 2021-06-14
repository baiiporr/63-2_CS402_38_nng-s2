<?php
include_once 'data.php';
/** PHPExcel */
require_once 'Classes/PHPExcel.php';
/** PHPExcel_IOFactory - Reader */
include 'Classes/PHPExcel/IOFactory.php';

if (isset($_POST['submitaddfileSQLlone'])) {

    $file =  $_FILES['fileToUploadSQLloan']['name'];
    $file_loc = $_FILES['fileToUploadSQLloan']['tmp_name'];
    $file_size = $_FILES['fileToUploadSQLloan']['size'];
    $file_type = $_FILES['fileToUploadSQLloan']['type'];
    $folder = "uplodefileloanSQL/";

    /* new file size in KB */
    $new_size = $file_size / 1024;
    /* new file size in KB */

    /* make file name in lower case */
    $new_file_name = strtolower($file);
    /* make file name in lower case */

    $final_file = str_replace(' ', '-', $new_file_name);

    if (move_uploaded_file($file_loc, $folder . $final_file)) {
        $sql = "INSERT INTO file_namelonesql(file_name,type,size) VALUES('$final_file','$file_type','$new_size')";
        mysqli_query($conn, $sql);
        //echo "ไฟล์ ". htmlspecialchars( basename( $_FILES["fileToUploadline"]["name"])). " ได้รับการอัปโหลด" ;
        echo "<script type='text/javascript'>";
        echo "alert('ไฟล์รายงานการกู้ยืมจากระบบ e-Studentloanได้รับการอัปโหลด');";
        //echo "window.location = 'reports-of-loan2.php'; ";
        echo "</script>";
    } else {

        echo "<script type='text/javascript'>";
        echo "alert('ขออภัยเกิดข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ');";
        //echo "window.location = 'reports-of-loan2.php'; ";
        echo "</script>";
    }


    $query = "SELECT * FROM file_namelonesql" or die("Error:");
    //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result . 
    $result = mysqli_query($conn, $query);
    //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล: 
    echo "<table border='1' align='center' width='100'>";
    while ($row = mysqli_fetch_array($result)) {
        $file_namelonesql = $row['file_name'];

        // echo "<tr>";
        //echo "<td>" . "<img src='uploads/" . $row["file_name"] . "' width='500'>" . "</td>";


        // $inputFileName ="uploads/$pdffile"; 
        $inputFileName = "uplodefileloanSQL/$file_namelonesql";
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($inputFileName);

        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();

        $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
        $headingsArray = $headingsArray[1];
        //$final_file = str_replace(' ', '-', $new_file_name);


        $r = -1;
        $namedDataArray = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
            if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                ++$r;
                foreach ($headingsArray as $columnKey => $columnHeading) {
                    $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                }
            }
        }

        // echo '<pre>';
        // var_dump($namedDataArray);
        // echo '</pre><hr />';


        $i = 0;
        foreach ($namedDataArray as $result) {
            $i++;
            $strSQL = "";
            $strSQL .= "INSERT INTO fileexcelloan2";
            $strSQL .= "(Schoolcode,Year1,Semester,Registrationnumber,IdentificationNumber,Studentcode,Name,Surname,NumberTuitionTee,
            DocumentDate1,TuitionFeeAmount,NumberRelatedExpenses,DocumentDate2,Amount,Board,Branch,Degree,Year2) ";
            $strSQL .= "VALUES ";
            $strSQL .= "('" . $result["Schoolcode"] . "','" . $result["Year1"] . "' ";
            $strSQL .= ",'" . $result["Semester"] . "','" . $result["Registrationnumber"] . "' ";
            $strSQL .= ",'" . $result["IdentificationNumber"] . "','" . $result["Studentcode"] . "' ";
            $strSQL .= ",'" . $result["Name"] . "','" . $result["Surname"] . "' ";
            $strSQL .= ",'" . $result["NumberTuitionTee"] . "','" . $result["DocumentDate1"] . "' ";
            $strSQL .= ",'" . $result["TuitionFeeAmount"] . "','" . $result["NumberRelatedExpenses"] . "' ";
            $strSQL .= ",'" . $result["DocumentDate2"] . "','" . $result["Amount"] . "' ";
            $strSQL .= ",'" . $result["Board"] . "','" . $result["Branch"] . "' ";
            $strSQL .= ",'" . $result["Degree"] . "','" . $result["Year2"] . "') ";
            mysqli_query($conn, $strSQL) or die(mysqli_error($conn));
            echo "Row $i Inserted...<br>";
        }
    }
    mysqli_close($conn);
}