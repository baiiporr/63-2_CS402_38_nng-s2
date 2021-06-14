<?php

//connect db
session_start();
// $student_id = $_SESSION['studentID'];
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

$select = "SELECT * FROM fileexcelloan2 WHERE Semester = '$term' AND Year1 = '$year'";
$objQuerySelectLoan = mysqli_query($objConnect, $select);
$select2 = "SELECT * FROM fileexcelbank2";
$objQuerySelectBank = mysqli_query($objConnect, $select2);

?>
<?php
if (isset($_GET['act'])) {
    if ($_GET['act'] == 'excel') {
        header("Content-Type: application/.xls");
        header("Content-Disposition: attachment; filename=สรุปรายงานการกู้ยืม(แบบไร้คู่).xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Tracking System For e-Studentloan In TU</title>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    th {
        text-align: center;
    }
    </style>

</head>

<body>

    <div class="container" class="well-sm col-sm-12">
        <div class="btn-group pull-right">
        </div>
    </div>
    <div class="table-responsive" id="student_table">
        <p>
            <a href="?act=excel" class="btn btn-primary"> ดาวน์โหลดไฟล์สรุปรายงานการกู้ยืม (แบบไร้คู่)</a>
        </p>
        <table>
            <?php if (mysqli_num_rows($objQuerySelectLoan) != 0) { ?>
            <tr>
                <th>ปีการศึกษา</th>
                <th>ภาคเรียนที่</th>
                <th>เลขบัตรประชาชน</th>
                <th>รหัสนักศึกษา</th>
                <th>ชื่อ-นามสกุล</th>
                <th>คณะ</th>
                <th>เลขที่ใบแจ้งหนื/เลขที่ใบเสร็จ (ค่าเล่าเรียน)</th>
                <th>จำนวนเงินค่าเล่าเรียน(e-StudentLoan)</th>
                <th>จำนวนเงินค่าเล่าเรียน(ธนาคาร)</th>
                <th>ยอดคงเหลือ</th>
                <th>หมายเหตุ</th>
            </tr>
            <?php } else {
                echo "ยังไม่มีข้อมูล";
            } ?>
            <tr>
                <?php

                while ($row2 = mysqli_fetch_assoc($objQuerySelectLoan)) {

                    $Studentcode = trim($row2["Studentcode"]);
                    $row2["IdentificationNumber"] = substr_replace($row2["IdentificationNumber"], "-", 1, 0);
                    $row2["IdentificationNumber"] = substr_replace($row2["IdentificationNumber"], "-", 6, 0);
                    $row2["IdentificationNumber"] = substr_replace($row2["IdentificationNumber"], "-", 12, 0);
                    $row2["IdentificationNumber"] = substr_replace($row2["IdentificationNumber"], "-", 15, 0);
                    $IdentificationNumber = $row2["IdentificationNumber"];
                    // echo $a;
                    $select4 = "SELECT Tuitionfee AS tuitionfee FROM fileexcelbank2 WHERE Registrationnumber = '$Studentcode' OR NationalIdentificationNumber = '$IdentificationNumber'";
                    $objQuerySelectBank2 = mysqli_query($objConnect, $select4);
                    $selectBank = mysqli_fetch_array($objQuerySelectBank2);
                    if (mysqli_num_rows($objQuerySelectBank2) != 0) {
                    } else { ?>
            <tr>
                <td style=" text-align: center;"><?php echo $row2["Year1"]; ?></td>
                <td style="text-align: center;"><?php echo $row2["Semester"]; ?> </td>
                <td style="width: 150px;"><?php echo $row2["IdentificationNumber"]; ?> </td>
                <td style="text-align: center;"><?php echo $row2["Studentcode"]; ?> </td>
                <td><?php echo $row2["Name"] . ' ' . $row2["Surname"]; ?> </td>
                <td><?php echo $row2["Board"]; ?> </td>
                <td><?php echo $row2["NumberTuitionTee"]; ?> </td>
                <td><?php echo ($row2["TuitionFeeAmount"]); ?></td>
                <td><?php echo '-'; ?> </td>
                <td><?php echo '-'; ?> </td>
                <td><?php echo 'ไม่พบข้อมูลนี้จากในไฟล์ธนาคาร'; ?> </td>
            </tr>
            <?php
                    }
                }


    ?>
            </tr>
            </tr>

        </table>
    </div>

    </div>

</body>

</html>

<?php
mysqli_close($objConnect);
?>