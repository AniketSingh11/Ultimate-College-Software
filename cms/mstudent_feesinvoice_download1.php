<?php

ini_set('max_execution_time', 0);
require("includes/config.php");
session_start();
$sacyear = $_SESSION['acyear'];

if ($sacyear) {
    $ayear = mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
    $ay = mysql_fetch_array($ayear);
} else {
    $ayear = mysql_query("SELECT * FROM year WHERE status='1'");
    $ay = mysql_fetch_array($ayear);
}

$acyear = $ay['ay_id'];
$acyear_name = $ay['y_name'];

$syear = $ay['s_year'];
$eyear = $ay['e_year'];

$qry = mysql_fetch_array(mysql_query("select * from school_name"));
$school_name = $qry["sc_name"];






require_once 'Classes/PHPExcel.php';


require_once 'Classes/PHPExcel/IOFactory.php';

$excel_readers = array(
    'Excel5',
    'Excel2003XML',
    'Excel2007'
);

function cellColor($cells, $color) {
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}

function cellFont($cells, $fontfamily) {
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000'),
            'size' => 12,
            'name' => $fontfamily
    )));
}

$reader = PHPExcel_IOFactory::createReader('Excel5');
$reader->setReadDataOnly(false);


$objPHPExcel = new PHPExcel();

// Set the active Excel worksheet to sheet 0

$objPHPExcel->setActiveSheetIndex(0);

// Initialise the Excel row number


$cid = $_GET['cid'];
$bid = $_GET['bid'];
$sid = $_GET['sid'];


if (!$bid) {
    $boardlist1 = mysql_query("SELECT * FROM board");
    $board1 = mysql_fetch_array($boardlist1);
    $bid = $board1['b_id'];
}
$boardlist = mysql_query("SELECT * FROM board WHERE b_id=$bid");
//	echo "SELECT * FROM board WHERE b_id=$bid";die;
$board = mysql_fetch_array($boardlist);

$ss_id = $_GET['ssid'];
$ssid = $ss_id;

$cid = $_GET['cid'];
$sid = $_GET['sid'];
$sid = $_GET['sid'];
$ddlterm = $_GET["ddlterm"];
$otherfees_qry = "SELECT * FROM fgroup_detail where fg_id='4' AND otherfees='0'";
$qry = mysql_query($otherfees_qry);
while ($row = mysql_fetch_array($qry)) {
    
}
$feesub = $_GET["fees_sub"];
if ($cid && $sid) {
    $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
    // echo "SELECT * FROM class WHERE c_id=$cid";die;							
    $class = mysql_fetch_array($classlist);
    $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
    //	echo "SELECT * FROM section WHERE s_id=$sid";die;
    $section = mysql_fetch_array($sectionlist);
    //echo $class['c_name']."-".$section['s_name'];
}



$rowCount = 2;


$objPHPExcel->getActiveSheet()->setCellValue("D1", " $school_name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(50);
cellFont("D1", "Calibri");

//start of printing column names as names of MySQL fields

$column = 'A';

/*   for ($i = 1; $i < mysql_num_fields($result); $i++)

  {
  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
  $column++;

  }
 */

$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Admission  No");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
cellFont("A2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Student Name");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
cellFont("B2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Class Name");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
cellFont("C2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Student type");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
cellFont("E2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Student Phone no");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
cellFont("E2", "Calibri");

if ($ddlterm == "1") {
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "I Term Fees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    cellFont("F2", "Calibri");


    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    }
}
// II term fees
if ($ddlterm == "2") {
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "II Term Fees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    cellFont("F2", "Calibri");


    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    }
}
//III tgerm fees
if ($ddlterm == "3") {
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "III Term Fees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    cellFont("F2", "Calibri");


    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    }
}
//others
$qry_others = mysql_query($otherfees_qry);
while ($row_other = mysql_fetch_array($qry_others)) {
    $fees_otherid = '4' . $row_other['fgd_id'];
    if ($fees_otherid == $ddlterm) {

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $row_other['name']);
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        cellFont("D2", "Calibri");





        if ($feesub == "1") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            cellFont("F2", "Calibri");
        } else if ($feesub == "2") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            cellFont("F2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            cellFont("G2", "Calibri");
        } else if ($feesub == "3") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            cellFont("F2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            cellFont("G2", "Calibri");
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            cellFont("F2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            cellFont("G2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
        }
    }
}

/// all fees type
if ($ddlterm == "all") {
    if ($feesub == 1) {

        $colspan = '';
    } else if ($feesub == 2) {

        $colspan = 'colspan="2"';
    } else if ($feesub == 3) {

        $colspan = 'colspan="2"';
    } else {

        $colspan = 'colspan="3"';
    }
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "I Term Fees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    cellFont("D2", "Calibri");
    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        cellFont("H2", "Calibri");
    }




    //second term fees//
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "II Term Fees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    cellFont("F2", "Calibri");



    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
    }
    // 3 term fees
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "III Term Fees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    cellFont("G2", "Calibri");

    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        cellFont("G2", "Calibri");
    }
    //other fees//
    $qry_others_th = mysql_query($otherfees_qry);
    while ($row_other_th = mysql_fetch_array($qry_others_th)) {

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $row_other_th['name']);
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
        if ($feesub == "1") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
        } else if ($feesub == "2") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            cellFont("F2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
        } else if ($feesub == "3") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            cellFont("F2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
        }
    }






    //total fees	
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "TotalFees");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    cellFont("J2", "Calibri");

    if ($feesub == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    } else if ($feesub == "2") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    } else if ($feesub == "3") {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        cellFont("F2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Fees");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Paid");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Pending");
        $column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        cellFont("I2", "Calibri");
    }
}





//$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
//end of adding column names
//start while loop to get data

$rowCount = 3;



$cid = $_GET["cid"];
$sid = $_GET["sid"];
$qry = "SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype,phone_number FROM student AS s 
                                                INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='" . $acyear . "' AND user_status='1'";
if ($cid != "all") {
    $qry = $qry . "	AND s.c_id='" . $cid . "'";
}
if ($sid != "all" && $sid != "Old") {
    $qry = $qry . "  AND s.s_id='" . $sid . "'";
}
if ($sid == "Old") {
    $qry = $qry . "  AND s.s_id!=0";
}
$qry = $qry . " AND s.b_id='" . $bid . "' ORDER BY s.c_id ASC";
// echo $qry;
// die;
$result = mysql_query($qry);
$cnt = 0;
while ($rs = mysql_fetch_assoc($result)) {
    $cnt+=1;
    //getting the total fees for a student 
    $qry1 = "SELECT fg.fg_id,fg.fg_name,fgd.type,fr.ay_id,fr.c_id,sum(rate) as rate FROM fgroup AS fg 
                                                   INNER JOIN fgroup_detail AS fgd  ON fgd.fg_id=fg.fg_id  
                                                   INNER JOIN frate AS fr ON fr.fg_id=fg.fg_id 
                                                    GROUP BY fg.fg_id,fgd.type,fr.c_id,fr.ay_id  having fr.ay_id='" . $acyear . "'
                                                    AND fr.c_id='" . $rs["c_id"] . "'";
    //echo $qry1;
    $qry1 = "SELECT fg_id,ay_id,c_id,sum(rate) as rate from frate AS fr "
            . "group by  fg_id,ay_id,c_id having fr.ay_id='" . $acyear . "' "
            . "AND fr.c_id='" . $rs["c_id"] . "'";
    $result1 = mysql_query($qry1);
    $t1_fees = 0;
    $t2_fees = 0;
    $t3_fees = 0;
    $other_fees = 0;
    while ($rs1 = mysql_fetch_assoc($result1)) {
        if ($rs['stype'] == "New" && $rs1['type'] == "1")
            $fees+=$rs1['rate'];
        else
            $fees+=$rs1['rate'];
        switch ($rs1['fg_id']) {
            case "1":
                $t1_fees+=$rs1['rate'];
                break;
            case "2":
                $t2_fees+=$rs1['rate'];
                break;
            case "3":
                $t3_fees+=$rs1['rate'];
                break;
            case "4":
            /* if ($rs['stype'] == "New" && $rs1['type'] == "1")
              $other_fees+=$rs1['rate'];
              else
              $other_fees+=$rs1['rate'];
              break;
             */
        }
    }

    //START OTHER FEES CALC
    $qry1_all = "SELECT fg_id,fgd_id,ay_id,c_id,rate from frate AS fr WHERE fr.ay_id='" . $acyear . "' AND fr.c_id='" . $rs["c_id"] . "'";
    //die;
    $result1_all = mysql_query($qry1_all);

    $other_fees_reg = 0;
    $other_fees_schl = 0;
    $other_fees_admn = 0;

    $other_fees_cam = 0;
    $other_fees_aba = 0;
    $other_fees_skat = 0;
    $other_fees_karat = 0;
    $other_fees_cric = 0;
    while ($rs1_all = mysql_fetch_assoc($result1_all)) {
        if ($rs1_all['fg_id'] == 4) {

            switch ($rs1_all['fgd_id']) {
                case "2":
                    //if ($rs['stype'] == "New") {
                    $other_fees_reg+=$rs1_all['rate'];
                    //}
                    break;
                case "7":
                    // if ($rs['stype'] == "New") {
                    $other_fees_admn+=$rs1_all['rate'];
                    // }
                    break;
                case "9":
                    $other_fees_schl+=$rs1_all['rate'];
                    break;
                case "10":
                    //if ($rs['stype'] == "New") {
                    $other_fees_cam+=$rs1_all['rate'];
                    //}
                    break;
                case "11":
                    // if ($rs['stype'] == "New") {
                    $other_fees_aba+=$rs1_all['rate'];
                    // }
                    break;
                case "12":
                    $other_fees_skat+=$rs1_all['rate'];
                    break;
                case "13":
                    $other_fees_karat+=$rs1_all['rate'];
                    break;
                case "14":
                    $other_fees_cric+=$rs1_all['rate'];
                    break;
            }
        }
    }
    //END OTHER FEES


    /* $qry2="Select fs.fg_id,ss_id,sum(amount) as amount from fsalessumarry AS fs INNER JOIN finvoice AS fi ON fi.fi_id=fs.fi_id INNER JOIN frate AS fr ON fr.fr_id=fs.fr_id  WHERE  ss_id='".$rs["ss_id"]."' GROUP BY ss_id,fg_id"; */
    $qry2 = "select fs.fss_id,fs.amount,fs.fg_id,fs.fgd_id from finvoice as fi 
                                                    INNER JOIN fsalessumarry AS fs ON fs.fi_id=fi.fi_id WHERE fi.ss_id='" . $rs["ss_id"] . "'
                                                    AND fi.c_status!='1' AND fi.i_status='0'";
    $result2 = mysql_query($qry2);
    $t1_amount = 0;
    $t2_amount = 0;
    $t3_amount = 0;
    $other_amount = 0;
    $other_amount_reg = 0;
    $other_amount_schl = 0;
    $other_amount_admn = 0;

    $other_amount_cam = 0;
    $other_amount_aba = 0;
    $other_amount_skat = 0;
    $other_amount_karat = 0;
    $other_amount_cric = 0;

    while ($rs2 = mysql_fetch_assoc($result2)) {

        switch ($rs2['fg_id']) {
            case "1":
                $t1_amount+=$rs2['amount'];
                break;
            case "2":
                $t2_amount+=$rs2['amount'];
                break;
            case "3":
                $t3_amount+=$rs2['amount'];
                break;
            case "4":

                /* $feesgroup = mysql_query("SELECT otherfees FROM fgroup_detail WHERE fgd_id='" . $rs2['fg_id'] . "' AND otherfees=0");
                  $feesgrouplist = mysql_fetch_array($feesgroup);
                  if ($feesgrouplist) {
                  $other_amount+=$rs2['amount'];
                  }
                  break;
                 */
//&& ($rs['stype'] == "New")
                if (($rs2['fgd_id'] == "2")) {
                    $other_amount_reg+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "7")) {
                    $other_amount_admn+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "9")) {
                    $other_amount_schl+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "10")) {
                    $other_amount_cam+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "11")) {
                    $other_amount_aba+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "12")) {
                    $other_amount_skat+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "13")) {
                    $other_amount_karat+=$rs2['amount'];
                } else if (($rs2['fgd_id'] == "14")) {
                    $other_amount_cric+=$rs2['amount'];
                }

                break;
        }
    }

    $t1_pending = $t1_fees - $t1_amount;
    $t2_pending = $t2_fees - $t2_amount;
    $t3_pending = $t3_fees - $t3_amount;

    $reg_pending = $other_fees_reg - $other_amount_reg;
    $admn_pending = $other_fees_admn - $other_amount_admn;
    $schl_pending = $other_fees_schl - $other_amount_schl;

    $cam_pending = $other_fees_cam - $other_amount_cam;
    $aba_pending = $other_fees_aba - $other_amount_aba;
    $skat_pending = $other_fees_skat - $other_amount_skat;
    $karat_pending = $other_fees_karat - $other_amount_karat;
    $cric_pending = $other_fees_cric - $other_amount_cric;
    // echo ' fees'.$feesub.'-amt'.($t1_pending);
    //  
    //
										if ($feesub == 'all' || $feesub == 1 || ($feesub == 2 && (($ddlterm == 'all' && (($t1_amount) != 0 || ($t2_amount) != 0 || ($t3_amount) != 0 || $other_amount_reg != 0 || $other_amount_admn != 0 || $other_amount_schl != 0)) || ($ddlterm == 1 && ($t1_amount) != 0) || ($ddlterm == 2 && ($t2_amount) != 0) ||
            ($ddlterm == 3 && ($t3_amount) != 0) || ($ddlterm == 42 && $other_amount_reg != 0) ||
            ($ddlterm == 47 && $other_amount_admn != 0) || ($ddlterm == 49 && $other_amount_schl != 0) )) ||
            ($feesub == 3 && (($ddlterm == 'all' && (($t1_pending) != 0 || ($t2_pending) != 0 || ($t3_pending) != 0 || $reg_pending != 0 || $admn_pending != 0 || $schl_pending != 0)) || ($ddlterm == 1 && ($t1_pending) != 0) || ($ddlterm == 2 && ($t2_pending) != 0) ||
            ($ddlterm == 3 && ($t3_pending) != 0) || ($ddlterm == 42 && $reg_pending != 0) ||
            ($ddlterm == 47 && $admn_pending != 0) || ($ddlterm == 49 && $schl_pending != 0) ||
            ($ddlterm == 410 && $cam_pending != 0) || ($ddlterm == 411 && $aba_pending != 0) ||
            ($ddlterm == 412 && $skat_pending != 0) || ($ddlterm == 413 && $karat_pending != 0) ||
            ($ddlterm == 414 && $cric_pending != 0)
            ))
    ) {

        $column = 'A';





        $adminno = $rs['admission_number'];
        $finame = $rs['firstname'];
        $cname = $rs['c_name'];
        $stype = $rs['stype'];
        $phone_number = $rs['phone_number'];
        // $date=$row['fi_day']."/".$row['fi_month']."/".$row['fi_year'];
        // $classsec=$class['c_name']."/".$section['s_name'];
        //  $stype=$row['stype'];
        // $fiby=$row['fi_by'];
        //$total=number_format($row['fi_total'],2);
        // $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cnt);  $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $adminno);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $finame);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $cname);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $stype);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $phone_number);
        $column++;



        $csv_content = $csv_content . $cnt . "," . $rs["admission_number"] . "," . $rs["firstname"] . "," . $rs["c_name"];
        if ($ddlterm == "all") {
            $csv_content = $csv_content . "," . $t1_fees . "," . $t1_amount . "," . $t1_fees - $t1_amount;

            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("F3", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t1_fees - $t1_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("G3", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t1_fees - $t1_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
            }
            //ii term fees 

            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("F3", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t2_fees - $t2_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("G3", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t2_fees - $t2_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
            }

            /// iii term fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("F3", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t3_fees - $t3_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("G3", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t3_fees - $t3_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
            }


            $reg_pending = $other_fees_reg - $other_amount_reg;

            //other reg fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == 1) {
                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            } else if ($feesub == 2) {
                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            } else if ($feesub == 3) {
                if ($rs['stype'] == "New") {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg - $other_amount_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            } else {
                if ($rs['stype'] == "New") {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg - $other_amount_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {


                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            }

            //adm fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            $adm_pending = $other_fees_admn - $other_amount_admn;
            if ($feesub == 1) {
                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            } else if ($feesub == 2) {
                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            } else if ($feesub == 3) {
                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn - $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            } else {

                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn - $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "-");
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    cellFont("G2", "Calibri");
                }
            }

            //school fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");

            $schl_pending = $other_fees_schl - $other_amount_schl;
            if ($feesub == 1) {


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl - $other_amount_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl - $other_amount_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            }
            //cambridge fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");

            $cam_pending = $other_fees_cam - $other_amount_cam;
            if ($feesub == 1) {


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam - $other_amount_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam - $other_amount_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            }

            //abacus fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");

            $aba_pending = $other_fees_aba - $other_amount_aba;
            if ($feesub == 1) {


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba - $other_amount_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba - $other_amount_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            }
            //skating fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");

            $skat_pending = $other_fees_skat - $other_amount_skat;
            if ($feesub == 1) {


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat - $other_amount_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat - $other_amount_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            }
            //karate fees
            ////school fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");

            $karat_pending = $other_fees_karat - $other_amount_karat;
            if ($feesub == 1) {


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat - $other_amount_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat - $other_amount_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            }
            //cricket fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");

            $cric_pending = $other_fees_cric - $other_amount_cric;
            if ($feesub == 1) {


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else if ($feesub == 3) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric - $other_amount_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric - $other_amount_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                cellFont("G2", "Calibri");
            }
            //total fees
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");

            $csv_content = $csv_content . "," . $total_fees . "," . $total_amount . "," . $total_pending_amount . "\n";
            $total_fees = $t1_fees + $t2_fees + $t3_fees + $other_fees_reg + $other_fees_admn + $other_fees_schl + $other_fees_cam + $other_fees_aba + $other_fees_skat + $other_fees_karat + $other_fees_cric;
            $csv_content = $csv_content . "," . $total_fees;
            $total_amount = $t1_amount + $t2_amount + $t3_amount + $other_amount_reg + $other_amount_admn + $other_amount_schl + $other_amount_cam + $other_amount_aba + $other_amount_skat + $other_amount_karat + $other_amount_cric;
            $csv_content = $csv_content . "," . $total_amount;
            $total_pending_amount = $total_fees - $total_amount;
            $csv_content = $csv_content . "," . $total_pending_amount . "\n";


            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $total_fees);
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");

            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $total_amount);
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");


            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $total_pending_amount);
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            cellFont("H2", "Calibri");
        }
        if ($ddlterm == "1") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == "1") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
            } else if ($feesub == "2") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("D2", "Calibri");
            } else if ($feesub == "3") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("E3", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t1_fees - $t1_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("D2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("D2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t1_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("D2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t1_fees - $t1_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                cellFont("D2", "Calibri");
            }
        }
        if ($ddlterm == "2") {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == "1") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
            } else if ($feesub == "2") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
            } else if ($feesub == "3") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t2_fees - $t2_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t2_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t2_fees - $t2_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                cellFont("E2", "Calibri");
            }
        }

        if ($ddlterm == "3") {

            $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
            $column++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            cellFont("D3", "Calibri");
            if ($feesub == "1") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
            } else if ($feesub == "2") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
            } else if ($feesub == "3") {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t3_fees - $t3_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_fees);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $t3_amount);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ($t3_fees - $t3_amount));
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                cellFont("F2", "Calibri");
            }
        }
        /////////reg fees
        if ($ddlterm == "42") {



            if ($feesub == 1) {


                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            } else if ($feesub == 2) {

                if ($rs['stype'] == "New") {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            } else if ($feesub == 3) {
                if ($rs['stype'] == "New") {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $reg_pending);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            } else {

                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_reg);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $reg_pending);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $reg_pending);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            }
        }
        //admission fees									
        if ($ddlterm == "47") {



            if ($feesub == 1) {


                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            } else if ($feesub == 2) {

                if ($rs['stype'] == "New") {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            } else if ($feesub == 3) {
                if ($rs['stype'] == "New") {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $adm_pending);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            } else {

                if ($rs['stype'] == "New") {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_admn);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $adm_pending);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $adm_pending);
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    cellFont("I2", "Calibri");
                }
            }
        }

        //school fees							
        if ($ddlterm == '49') {

            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 2) {
                //paid

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 3) {
                //pending


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $schl_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "");
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_schl);
                $column++;

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_schl);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $schl_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            }
        }

        //cambrifge fees							
        if ($ddlterm == '410') {

            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 2) {
                //paid

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 3) {
                //pending


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $cam_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "");
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cam);
                $column++;

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cam);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $cam_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            }
        }

//abacus fees							
        if ($ddlterm == '411') {

            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 2) {
                //paid

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 3) {
                //pending


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $aba_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "");
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_aba);
                $column++;

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_aba);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $aba_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            }
        }

//skating fees							
        if ($ddlterm == '412') {

            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 2) {
                //paid

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 3) {
                //pending


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $skat_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "");
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_skat);
                $column++;

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_skat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $skat_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            }
        }
//karate fees							
        if ($ddlterm == '413') {

            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 2) {
                //paid

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 3) {
                //pending


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $karat_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "");
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_karat);
                $column++;

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_karat);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $karat_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            }
        }

//cricket fees							
        if ($ddlterm == '414') {

            if ($feesub == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 2) {
                //paid

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else if ($feesub == 3) {
                //pending


                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $cric_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "");
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_fees_cric);
                $column++;

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $other_amount_cric);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $cric_pending);
                $column++;
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                cellFont("I2", "Calibri");
            }
        }
        $t1_fees = 0;
        $t2_fees = 0;
        $t3_fees = 0;
        $other_fees = 0;
        $t1_pending = 0;
        $t2_pending = 0;
        $t3_pending = 0;

        $reg_pending = 0;
        $admn_pending = 0;
        $schl_pending = 0;

        $cam_pending = 0;
        $aba_pending = 0;
        $skat_pending = 0;
        $karat_pending = 0;
        $cric_pending = 0;

        $rowCount++;


        $count++;
    }



    //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
    //$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acyear_name);   $column++;
}



$objPHPExcel->getActiveSheet()->setTitle($class_name . "-" . $section_name . " Student_FeesInvoice_Download");





// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename= Student_FeesInvoice_Download-list.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
