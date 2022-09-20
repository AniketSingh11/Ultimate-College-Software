<?php

require("../includes/config.php");
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
$sdate = mysql_real_escape_string($_GET['sdate']);
$edate = mysql_real_escape_string($_GET['edate']);
$syear = $ay['s_year'];
$eyear = $ay['e_year'];

$qry = mysql_fetch_array(mysql_query("select * from school_name"));
$school_name = $qry["sc_name"];


$sdate = $_GET['sdate'];
$edate = $_GET['edate'];


$sdate_split1 = explode('/', $sdate);
$sdate_month = $sdate_split1[0];
$sdate_day = $sdate_split1[1];
$sdate_year = $sdate_split1[2];
$startdate = $sdate_year . $sdate_month . $sdate_day;

$edate_split1 = explode('/', $edate);
$edate_month = $edate_split1[0];
$edate_day = $edate_split1[1];
$edate_year = $edate_split1[2];

$enddate = $edate_year . $edate_month . $edate_day;


$start = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['sdate'])));
$end = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['edate'])));

if ($sdate && $edate) {
     $sum_qry = mysql_query("SELECT sum(overall_total) as total FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 and 
                                                        mat_date between '$start' and '$end'
                                                        order by inv_material_parent.mat_parent_id desc");
                      $sum_result = mysql_fetch_assoc($sum_qry);
                    $total = $sum_result['total'];
                        
                        $qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 and 
                                                        mat_date between '$start' and '$end'
                                                        order by inv_material_parent.mat_parent_id desc");


    require_once '../Classes/PHPExcel.php';


    require_once '../Classes/PHPExcel/IOFactory.php';

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

    $rowCount = 2;

    $objPHPExcel->getActiveSheet()->setCellValue("D1", " $school_name ");
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(50);
    cellFont("D1", "Calibri");
    $objPHPExcel->getActiveSheet()->setCellValue("I1", "Total : $total ");
    $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(50);
    cellFont("I1", "Calibri");

    //start of printing column names as names of MySQL fields

    $column = 'A';

    /*   for ($i = 1; $i < mysql_num_fields($result); $i++)

      {
      $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
      $column++;
      }
     */

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Bill No");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    cellFont("A2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Issue Date");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    cellFont("B2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Student / Staff");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    cellFont("C2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Admin No");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    cellFont("D2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Board");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    cellFont("E2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Class-Section");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    cellFont("F2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Payment Type");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    cellFont("G2", "Calibri");

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Amount");
    $column++;
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    cellFont("H2", "Calibri");

    //end of adding column names
    //start while loop to get data

    $rowCount = 3;


    $count = 1;

    while ($row = mysql_fetch_array($qry)) {
        $paytype = '';
        $qry_pay = mysql_query("SELECT * FROM inv_material_payment where inv_material_payment.mat_parent_id=" . $row['mat_parent_id']);
        $row_pay = mysql_fetch_array($qry_pay);
        if ($row_pay['p_type'] == 'cash')
            $paytype = 'Cash';
        else if ($row_pay['p_type'] == 'card')
            $paytype = 'Card';
        else if ($row_pay['p_type'] == 'cheque')
            $paytype = 'Cheque';

        $column = 'A';

        $frno = $row['bill_no'];
        $st_stud = ($row['stud_staff']) ? "Student" : "Staff";
        $adminno = $row['adm_emp_no'];
        $bname = $row['b_name'];
        $date = date("d-m-Y", strtotime($row['mat_date']));
        $classsec = $row['c_name'] . "/" . $row['s_name'];
        $total = number_format($row['overall_total'], 2);


        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $frno);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $date);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $st_stud);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $adminno);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $bname);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $classsec);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $paytype);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $total);
        $column++;

        $rowCount++;

        $count++;
    }
}


$objPHPExcel->getActiveSheet()->setTitle($class_name . "-" . $section_name . "Rejected List");





// Redirect output to a client?s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Rejected_Report.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
