<?php

require("includes/config.php");
session_start();
$user=$_SESSION['uname'];
/*
  header("Content-type: text/csv");
  header("Content-Disposition: attachment; filename=boarding-point-report.csv");
  header("Pragma: no-cache");
  header("Expires: 0");
 */

$qry = mysql_fetch_assoc(mysql_query("select * from school_name"));

$school_name = $qry["sc_name"];

$sacyear = $_GET['ayid'];

if ($sacyear) {
    $ayear = mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
    $ay = mysql_fetch_assoc($ayear);
} else {
    $ayear = mysql_query("SELECT * FROM year WHERE status='1'");
    $ay = mysql_fetch_assoc($ayear);
}

$acyear = $ay['ay_id'];
$acyear_name = $ay['y_name'];

$syear = $ay['s_year'];
$eyear = $ay['e_year'];

$sdate = $_GET['sdate'];
$edate = $_GET['edate'];

$sdate_split1 = explode('/', $sdate);
$sdate_month = $sdate_split1[1];
$sdate_day = $sdate_split1[0];
$sdate_year = $sdate_split1[2];
$startdate = $sdate_year . $sdate_month . $sdate_day;
$startdate1 = $sdate_year . "-" . $sdate_month . "-" . $sdate_day;

$edate_split1 = explode('/', $edate);
$edate_month = $edate_split1[1];
$edate_day = $edate_split1[0];
$edate_year = $edate_split1[2];

$enddate = $edate_year . $edate_month . $edate_day;
$enddate1 = $edate_year . "-" . $edate_month . "-" . $edate_day;


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


//Summary Sheet No 1

$sheet = $objPHPExcel->getActiveSheet();
$summary=array();
$begin = new DateTime($startdate1);
$end = new DateTime($enddate1);
$end->modify('+1 day');
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$i=1;
foreach ( $period as $dt ) {
$startdate = $dt->format( "Ymd" );
$startdate1 = $dt->format( "Y-m-d" );
$enddate = $dt->format( "Ymd" );
$enddate1 = $dt->format( "Y-m-d" );
$sameday=$dt->format( "d/m/Y" );
$forname=$dt->format( "d-m-Y" );
$objWorkSheet = $objPHPExcel->createSheet($i);

$rowCount = 2;


$objWorkSheet->setCellValue("B1", " $school_name ");
$objWorkSheet->getColumnDimension("B")->setWidth(50);
cellFont("B1", "Calibri");
$column = 'A';

$objWorkSheet->getColumnDimension('A')->setWidth(20);
cellFont("A2", "Calibri");
$objWorkSheet->setCellValue($column . $rowCount, "S.No");
$column++;
$objWorkSheet->getColumnDimension('B')->setWidth(20);
cellFont("B2", "Calibri");
$objWorkSheet->setCellValue($column . $rowCount, "Particular");
$column++;

$objWorkSheet->getColumnDimension('C')->setWidth(20);
cellFont("C2", "Calibri");
$objWorkSheet->setCellValue($column . $rowCount, "Expenses");
$column++;

$objWorkSheet->getColumnDimension('D')->setWidth(20);
cellFont("D2", "Calibri");
$objWorkSheet->setCellValue($column . $rowCount, "Income");
$column++;

$objWorkSheet->getColumnDimension('E')->setWidth(20);
cellFont("E2", "Calibri");
$objWorkSheet->setCellValue($column . $rowCount, "Assets");
$column++;

$objWorkSheet->setAutoFilter($objWorkSheet->calculateWorksheetDimension());

//start while loop to get data

$rowCount = 3;

$var="SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' and fi_by='$user'";
                                $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' and fi_by='$user'");
                                        $book=0;
                                        while($all=mysql_fetch_assoc($other)){
                                            //print_r($all);
                                            $book+=$all['fi_total'];
                                        }


$content = '';
$title = '';
$count = 1;
$total = 0;
$indisplay = 1;
$assettotal = 0;
 /********************** Manager Fees Collection **********************************/
                                                 $feeslist1 = mysql_query("SELECT * FROM feescollection WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and fee_by='$user'");
                                               
                                                $n=1;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                   $column = 'A';
                                                   $objWorkSheet->setCellValue($column . $rowCount,'');
                                                    $column++;
                                                    $objWorkSheet->setCellValue($column . $rowCount, $fees1['cashier']);
                                                    $column++;
                                                    $rowCount++;
                                                    $id1 = $fees1['id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM feescollection_child WHERE id=$id1");
                                                   $count=1;
                                                   while ($f1 = mysql_fetch_assoc($feesummarry1)) { 
                                            $amt=$f1['amount'];
                                            
                                            $column = 'A';

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $f1['fees']);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $amt);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;

                                            $total += $amt;
                                            $count++;
                                           }
                                           $n++;
                                        }
                                    /********************** Manager Fees Collection End ******************************/
/* * *******************************Other Fees******************************* */
$qry5 = mysql_query("SELECT fgd_id,fg_id,name FROM fgroup_detail");
while ($row5 = mysql_fetch_assoc($qry5)) {
    if($row5['fg_id']==4) {
    $fgd_id = $row5['fgd_id'];
    $fg_amount = 0;
    $feeslist2 = mysql_query("SELECT SUM(b.amount) as amount FROM finvoice a, fsalessumarry b WHERE (a.fi_year*10000) + (a.fi_month*100) + a.fi_day between '" . $startdate . "' AND '" . $enddate . "' AND a.fi_by='$user' and a.c_status!='1' AND a.i_status='0' AND a.fi_id=b.fi_id AND b.fgd_id=$fgd_id");
    $fees = mysql_fetch_assoc($feeslist2);
    $amount = $fees['amount'];
    $fg_amount += $amount;

    if ($fg_amount != 0) {
        $total += $fg_amount;


        $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $row5['name']);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $fg_amount);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;


        $count++;
    }
    }
}
$fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                        
                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_cl += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cl != 0) {
                                            $total += $fg_amount_cl;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount,"KG Term Fees ($frmmto)");
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $fg_amount_cl);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }

$feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_cm += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cm != 0) {
                                            $total += $fg_amount_cm;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount,"HS Term Fees ($frmmto)");
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $fg_amount_cm);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }

    $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_ch += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_ch != 0) {
                                            $total += $fg_amount_ch;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount,"HSS Term Fees ($frmmto)");
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $fg_amount_ch);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }
/********************** Books, Notes and Other Items ******************************************************/
     $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' and fi_by='$user'");

                                        $book=0;
                                        $from='';
                                        $to='';
                                        $fromto='';
                                        $n=1;
                                        while($all=mysql_fetch_assoc($other)){
                                           if($n==1){
                                             $from=$all['fr_no'];
                                         }
                                             $to=$all['fr_no'];
                                         $n++;
                                            $book+=$all['fi_total'];
                                           
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        if($book!=0) {
    $column = 'A';
    $objWorkSheet->setCellValue($column.$rowCount, $count);  $column++;
    $objWorkSheet->setCellValue($column.$rowCount, 'Books, Notes & Other Items Fees ('.$fromto.')');  $column++;
    $objWorkSheet->setCellValue($column.$rowCount, '');  $column++;
    $objWorkSheet->setCellValue($column.$rowCount, $book); $column++;
    $objWorkSheet->setCellValue($column.$rowCount, ''); $column++;
    $count++;
    $rowCount++;
    }

/********************** TC Issued charges ******************************************************/
     $other=mysql_query("SELECT * FROM tc_xi WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_by='$user'");
     $other1=mysql_query("SELECT * FROM tc_xi_kg WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_kg_by='$user'");
                                        $tc=0;
                                       
                                        while($all=mysql_fetch_assoc($other)){
                                            
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                         while($all=mysql_fetch_assoc($other1)){
                                            
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        $total+=$tc;
    if($tc!=0) {
    $column = 'A';
    $objWorkSheet->setCellValue($column.$rowCount, $count);  $column++;
    $objWorkSheet->setCellValue($column.$rowCount, 'TC Issued charges');  $column++;
    $objWorkSheet->setCellValue($column.$rowCount, '');  $column++;
    $objWorkSheet->setCellValue($column.$rowCount, $tc); $column++;
    $objWorkSheet->setCellValue($column.$rowCount, ''); $column++;
    $count++;
    $rowCount++;
    }
/* * **********************************************lastyesr Pending Fees ***************************************** */
$fg_amount = 0;
$feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' and c_status!='1' AND i_status='0' AND fi_by='$user'");
while ($fees = mysql_fetch_assoc($feeslist)) {
    $fi_id = $fees['fi_id'];
    $feesummarry = mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id AND ftype='pending'");
    while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
        $amount = $fsummarry['amount'];
        $fg_amount += $amount;
    }
}

if ($fg_amount != 0) {
    $total += $fg_amount;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Last Year Pending Fees ,';
    $content .= '-,';
    $content .= stripslashes($fg_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Last Year Pending Fees');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $fg_amount);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;


    $count++;
}
$etotal = 0;
$qry1 = mysql_query("SELECT fund_amount FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "'  AND funds='1' and c_status!='1' AND i_status='0' AND fi_by='$user'");
$sdf_total = 0;
while ($row1 = mysql_fetch_assoc($qry1)) {
    $sdf_tamount = $row1['fund_amount'];
    $sdf_total +=$sdf_tamount;
}
if ($sdf_total) {
    $etotal += $sdf_total;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Student Discount Funds ,';
    $content .= stripslashes($sdf_total) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Student Discount Funds');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $sdf_total);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;


    $count++;
}
$book_amount = 0;
$booklist = mysql_query("SELECT i_total FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate . "' AND '" . $enddate . "' and i_status='0'");
while ($book1 = mysql_fetch_assoc($booklist)) {
    $bamont = $book1['i_total'];
    $book_amount += $bamont;
}
if ($book_amount != 0) {
    $total +=$book_amount;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Book Fees ,';
    $content .= '-,';
    $content .= stripslashes($book_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Book Fees');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $book_amount);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;


    $count++;
}
$f=1;
$bamountthisyear = 0;
$bus_lastyear = 0;
$booklist1 = mysql_query("SELECT fi_total,pending,fr_no FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND c_status!='1' AND i_status='0' AND bfi_by='$user'");
$n=0;
                                        $cls='';
                                        $cle='';
while ($bus1 = mysql_fetch_assoc($booklist1)) {
   if($f==1){
                                                    $start_binv = $bus1['fr_no'];
                                                    }
                                                    $end_binv = $bus1['fr_no'];
                                                    $f++;
    $bamont1 = $bus1['fi_total'];
    $pending1 = $bus1['pending'];
    $bus_amount = $bamont1 - $pending1;
    $bamountthisyear += $bus_amount;
    $bus_lastyear += $pending1;
    $cle=$bus1['fr_no'];
}
$frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
if ($bamountthisyear != 0) {
    $total +=$bamountthisyear;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= stripslashes("Bus Fees (".$start_binv.'-'.$end_binv.")") . ',';
    $content .= '-,';
    $content .= stripslashes($bamountthisyear) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, "Bus Fees (".$start_binv.'-'.$end_binv.")");
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $bamountthisyear);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;


    $count++;
}
if ($bus_lastyear != 0) {
    $total +=$bus_lastyear;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Last Year Pending Bus Fees ,';
    $content .= '-,';
    $content .= stripslashes($bus_lastyear) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Last Year Pending Bus Fees');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $bus_lastyear);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ************************************* Loan Payment Income *********************************************** */
$loanpay_amount = 0;
$booklist = mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND login_user_name='$user'");
while ($book1 = mysql_fetch_assoc($booklist)) {
    $lamont = $book1['amount'];
    $loanpay_amount += $lamont;
}
if ($loanpay_amount != 0) {
    $total +=$loanpay_amount;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Loan Payment ,';
    $content .= '-,';
    $content .= stripslashes($loanpay_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Loan Payment');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $loanpay_amount);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
$rowCount++;
$indisplay = 1;
$classl = mysql_query("SELECT inc_id,in_category FROM in_category");
while ($row1 = mysql_fetch_assoc($classl)) {
    $incid = $row1['inc_id'];
    $in_amount = 0;
    $booklist1 = mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND inc_id=$incid AND inc_by='$user'");
    while ($bus1 = mysql_fetch_assoc($booklist1)) {
        $bamont1 = $bus1['amount'];
        $in_amount += $bamont1;

        $total +=$in_amount;
    }
    if ($in_amount != 0) {
        $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row1['in_category']) . ',';
        $content .= '-,';
        $content .= stripslashes($in_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $row1['in_category']);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $in_amount);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }
}
$rowCount++;
/* * **************Expenses ************************ */
$qry6 = mysql_query("SELECT exc_id,ex_category,e_category FROM ex_category");
$excount = 1;
$indisplay = 1;
while ($row6 = mysql_fetch_assoc($qry6)) {
    $e_category = $row6['e_category'];
    $exc_id = $row6['exc_id'];
    $exsqry = mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
    $cont = 1;
    while ($exrow = mysql_fetch_assoc($exsqry)) {
        $category_id = $exrow["category"];
        $exsid = $exrow["exs_id"];
        $count1 = $exrow["count"];
        $subexname = $exrow["sub_name"];
        if ($count1 == 0) {
            for ($j = 1; $j <= 20; $j++) {
                $sub_id = $exrow["sub" . $j . "_id"];

                if ($sub_id != 0) {
                    $field = $j;
                }
            }
            $fieldno = $field + 1;
            $myarray = array();
            array_push($myarray, $exsid);
            $subname = "sub" . $fieldno . "_id";
            $classlist2 = mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
            while ($class2 = mysql_fetch_assoc($classlist2)) {
                //$sub_id=$class1["sub".$j."_id"];
                array_push($myarray, $class2['exs_id']);
            }

            $exc_amount = 0;
            $feeslist1 = mysql_query("SELECT status,amount,pending FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ") AND type=0 AND billgenerate='$user'");
            while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                $type = $fees1['type'];
                $status = $fees1['status'];
                $amount1 = $fees1['amount'];
                if ($status == '1') {
                    $exc_amount += $amount1;
                }
            }
            //parcial qoutation payment
            $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses_bill_summary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id");
            while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                $amount1 = $fees1['amount'];
                $exid = $fees1['ex_id'];
                $check1 = mysql_query("SELECT ex_id FROM exponses WHERE ex_id=$exid AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ") AND billgenerate='$user'");
                $checkcount = mysql_num_rows($check1);
                if ($checkcount > 0) {
                    $exc_amount += $amount1;
                }
            }
            if ($exc_amount != 0) {
                if ($cont == '1') {

                    $column = 'A';

                    $content .= ',';
                    $content .= stripslashes($excount . ". " . $row6['ex_category']) . ',';
                    $content .= ',';
                    $content .= ',';
                    $content .= ',';
                    $content .= "\n";

                    $objWorkSheet->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, $excount . ". " . $row6['ex_category']);
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $rowCount++;

                    $cont = 0;
                    $excount++;
                }

                $column = 'A';

                $content .= stripslashes($count) . ',';
                $content .= stripslashes($subexname) . ',';
                if ($e_category == '1') {
                    $content .= '-,';
                    $content .= '-,';
                    $content .= stripslashes($exc_amount) . ',';
                    $content .= "\n";
                    $assettotal += $exc_amount;
                } else {
                    $content .= stripslashes($exc_amount) . ',';
                    $content .= '-,';
                    $content .= '-,';
                    $content .= "\n";
                    $etotal += $exc_amount;
                }

                $objWorkSheet->setCellValue($column . $rowCount, $count);
                $column++;
                $objWorkSheet->setCellValue($column . $rowCount, $subexname);
                $column++;
                if ($e_category == '1') {
                    $objWorkSheet->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount);
                    $column++;
                } else {
                    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount);
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objWorkSheet->setCellValue($column . $rowCount, '-');
                    $column++;
                }
                $rowCount++;
                $count++;
            }
        }
    }
}
$rowCount++;
/* * ********************************daily Allowance ******************************** */
$d_amount = 0;
$booklist1 = mysql_query("SELECT total_amount FROM exp_allowance WHERE (cdate >= '$startdate1' AND cdate <= '$enddate1') AND bill_by='$user'");
while ($bus1 = mysql_fetch_assoc($booklist1)) {
    $bamont1 = $bus1['total_amount'];
    $d_amount += $bamont1;
}
if ($d_amount != 0) {
    $etotal +=$d_amount;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Daily Allowance ,';
    $content .= stripslashes($d_amount) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Daily Allowance');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $d_amount);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ********************************Principal Salary ******************************** */
$sqry = mysql_query("SELECT st_id FROM staff Where prince='1'");
$srow = mysql_fetch_assoc($sqry);
$pstid1 = $srow['st_id'];
$exc_amount1 = 0;

$feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id=$pstid1 AND login_user_name='$user'");
while ($fees2 = mysql_fetch_assoc($feeslist2)) {
    $amount2 = $fees2['n_salary'];
    $exc_amount1 += $amount2;
}
if ($exc_amount1 != 0) {
    $etotal +=$exc_amount1;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Principal Salary ,';
    $content .= stripslashes($exc_amount1) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Principal Salary');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}

/* * ********************************Teaching Staff Salary ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id AND st_id!=$pstid1 AND login_user_name='$user'");
while ($fees2 = mysql_fetch_assoc($feeslist2)) {
    $amount2 = $fees2['n_salary'];
    $exc_amount1 += $amount2;
}
if ($exc_amount1 != 0) {
    $etotal +=$exc_amount1;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Teaching Staff Salary ,';
    $content .= stripslashes($exc_amount1) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Teaching Staff Salary');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ********************************Non-Teaching Staff Salary ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND (o_id OR d_id) AND login_user_name='$user'");
while ($fees2 = mysql_fetch_assoc($feeslist2)) {
    $amount2 = $fees2['n_salary'];
    $exc_amount1 += $amount2;
}
if ($exc_amount1 != 0) {
    $etotal +=$exc_amount1;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Non-Teaching Staff Salary ,';
    $content .= stripslashes($exc_amount1) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Non-Teaching Staff Salary');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ******************************** Staff Salary Advance  ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT a_amount FROM staff_advance WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND status=0 AND login_user_name='$user'");
while ($fees2 = mysql_fetch_assoc($feeslist2)) {
    $amount2 = $fees2['a_amount'];
    $exc_amount1 += $amount2;
}

if ($exc_amount1 != 0) {
    $etotal +=$exc_amount1;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Staff Salary Advance ,';
    $content .= stripslashes($exc_amount1) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Staff Salary Advance');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ******************************** Staff Loan ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT l_amount FROM staff_loan WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND login_user_name='$user'");
while ($fees2 = mysql_fetch_assoc($feeslist2)) {
    $amount2 = $fees2['l_amount'];
    $exc_amount1 += $amount2;
}

if ($exc_amount1 != 0) {
    $etotal +=$exc_amount1;
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= 'Staff Loan ,';
    $content .= stripslashes($exc_amount1) . ',';
    $content .= '-,';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, 'Staff Loan');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ******************************** EPF - ESI Contribution ******************************** */
$alldedlist2 = mysql_query("SELECT id,name FROM staff_allw_ded WHERE pe_type!=0");
while ($allded2 = mysql_fetch_assoc($alldedlist2)) {
    $adid = $allded2['id'];
    $adname = $allded2['name'];
    $exc_amount1 = 0;
    $feeslist2 = mysql_query("SELECT b.pevalue,b.amount FROM staff_month_salary a, staff_month_salary_summary b WHERE (a.year*10000) + (a.month*100) + a.day between '" . $startdate . "' AND '" . $enddate . "' AND a.login_user_name='$user' and a.st_ms_id = b.st_ms_id AND b.ad_id=$adid AND b.pevalue");
    while ($fees2 = mysql_fetch_assoc($feeslist2)) {
        $staffpreamount = $fees2['amount'];
        $preamount = $fees2['pevalue'];
        if ($staffpreamount) {
            $exc_amount1 += $staffpreamount + $preamount;
        }
    }
    if ($exc_amount1 != 0) {
        $etotal +=$exc_amount1;
        $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($adname) . 'Contribution ,';
        $content .= stripslashes($exc_amount1) . ',';
        $content .= '-,';
        $content .= '-,';
        $content .= "\n";

        $objWorkSheet->setCellValue($column . $rowCount, $count);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $adname . 'Contribution');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, $exc_amount1);
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $objWorkSheet->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }
}

// start advance expense


$qry_adv = "SELECT sum(adv_amt) as advance FROM agency_advance WHERE DATE(adv_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND billgenerate='$user'";
$advance_qry = mysql_query($qry_adv);
$advance_result = mysql_fetch_assoc($advance_qry);
if ($advance_result['advance'] != 0) {
    $etotal = $etotal + $advance_result['advance'];

    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= stripslashes("ADVANCE PAYMENT") . ',';
    $content .= '-,';
    $content .= stripslashes($in_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, "ADVANCE PAYMENT");
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $advance_result['advance']);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
//end advance expense
// start purchase expense

$qry_pur = "SELECT sum(overeall_total) as purchase_amt FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND billgenerate='$user'";
$pur_qry = mysql_query($qry_pur);
$pur_result = mysql_fetch_assoc($pur_qry);

$all = "SELECT  * FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND billgenerate='$user'";
                                        $from='';
                                        $to='';
                                        $n=1;
                                        $fromto='';
                                        $deff = mysql_query($all);
                                        while($row=mysql_fetch_assoc($deff)){
                                                if($n==1)
                                                    $from=$row['purchase_no'];
                                                $to=$row['purchase_no'];
                                                $n++;
                                        }
                                        
                                         if($from==$to)
                                            $fromto="PB" . str_pad($from, 5, '0', STR_PAD_LEFT);
                                        else
                                            $fromto="PB" . str_pad($from, 5, '0', STR_PAD_LEFT).'-'."PB" . str_pad($to, 5, '0', STR_PAD_LEFT);
if ($pur_result['purchase_amt'] != 0) {
    $etotal = $etotal + $pur_result['purchase_amt'];
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= stripslashes("INVENTORY PURCHASE") . ',';
    $content .= '-,';
    $content .= stripslashes($in_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, "INVENTORY PURCHASE (".$fromto.")");
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $pur_result['purchase_amt']);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
//end purchase expense
// start material issue income


$qry_mat = "SELECT sum(overall_total) as material_amt FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate='$user'";
$mat_qry = mysql_query($qry_mat);
$mat_result = mysql_fetch_assoc($mat_qry);

$qry_mat1 = "SELECT * FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate='$user'";
                                        $from='';
                                        $to='';
                                        $n=1;
                                        $fromto='';
                                        $mat_qry1 = mysql_query($qry_mat1);
                                        while($row=mysql_fetch_assoc($mat_qry1)){
                                                if($n==1)
                                                    $from=$row['bill_no'];
                                                    $to=$row['bill_no'];
                                                $n++;
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
if ($mat_result['material_amt'] != 0) {
    $total = $total + $mat_result['material_amt'];
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= stripslashes("INVENTORY MATERIAL ISSUE") . ',';
    $content .= '-,';
    $content .= stripslashes($in_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objWorkSheet->setCellValue($column . $rowCount, $count);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, "INVENTORY MATERIAL ISSUE (".$fromto.")");
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, $mat_result['material_amt']);
    $column++;
    $objWorkSheet->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
//end material issue income


$rowCount++;
$column = 'A';

$content .= ',';
$content .= 'Total ,';
$content .= stripslashes(round($total, 2)) . ',';
$content .= stripslashes(round($etotal, 2)) . ',';
$content .= stripslashes(round($assettotal, 2)) . ',';
$content .= "\n";
$total=$total+$book;
$objWorkSheet->setCellValue($column . $rowCount, '');
$column++;
$objWorkSheet->setCellValue($column . $rowCount, 'Total');
$column++;
$objWorkSheet->setCellValue($column . $rowCount, $etotal);
$column++;
$objWorkSheet->setCellValue($column . $rowCount, $total);
$column++;
$objWorkSheet->setCellValue($column . $rowCount, $assettotal);
$column++;
$rowCount++;
$rowCount++;


$expencetotal = $etotal + $assettotal;
$finaltotal = $total - $expencetotal;
$column = 'A';

$content .= ',';
$content .= 'Income :' . $total . ' | Expenses :' . $expencetotal . ' ( ' . round($total, 2) . ' -  (' . round($etotal, 2) . ' + ' . round($assettotal, 2) . ' ) )';
$content .= 'Profit Total : ,';
$content .= stripslashes($finaltotal) . ',';
$content .= "\n";

$objWorkSheet->setCellValue($column . $rowCount, '');
$column++;
$objWorkSheet->setCellValue($column . $rowCount, 'Income :' . round($total, 2) . ' | Expenses :' . round($expencetotal, 2) . '( ' . round($total, 2) . ' - (' . round($etotal, 2) . ' + ' . round($assettotal, 2) . ' ) )');
$column++;
$objWorkSheet->setCellValue($column . $rowCount, 'Profit Total :');
$column++;
$objWorkSheet->setCellValue($column . $rowCount, round($finaltotal, 2));
$column++;
$rowCount++;

$rowCount++;

$summary[$sameday]=$etotal.'*|*'.$total.'*|*'.$assettotal;
//$objWorkSheet->setCellValue('A1', 'Hello'.$i);
$objWorkSheet->setTitle("$forname");
$i++;
}
//------------------------------------Income and expenses summary ----------------------------------------------------->


$rowCount = 2;

$objPHPExcel->getActiveSheet()->setCellValue("B1", " $school_name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(50);
cellFont("B1", "Calibri");
$column = 'A';

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
cellFont("A2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "S.No");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
cellFont("B2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Date");
$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
cellFont("C2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Expenses");
$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
cellFont("D2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Income");
$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
cellFont("E2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Assets");
$column++;
$rowCount++;
$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
 $wtot=0;
                                        $wincome=0;
                                        $wexpenses=0;
                                        $wassets=0;
                                        //print_r($summary);
                                        $n=1;
                                        foreach ($summary as $key => $value) {
                                            $alltot=explode('*|*',$value);
                                                
                                                $column = 'A';


$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $n);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $key);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $alltot[0]);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $alltot[1]);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $alltot[2]);
$column++;
$rowCount++;
                                                $wincome+=$alltot[1];
                                                $wexpenses+=$alltot[0];
                                                $wassets+=$alltot[2];
                                            $n++;
                                        }
                                        $column='A';
                                        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Total");
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $wexpenses);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $wincome);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $wassets);
$column++;
$rowCount++;
                                        $wtot=$wincome-($wexpenses+$wassets);

$rowCount++;
$rowCount++;

$count=1;
$column = 'A';
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,'S.No');  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Particular');  $column++;
     $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Standard');  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,'Amount'); $column++;
    $count++;
    $rowCount++;
$fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                        
                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount_cl += $amount;
                                                        }
                                                    }
                                                    if($chk){
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            $column = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fees1['fi_name'].' - '.$fees1['fr_no']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,mysql_fetch_assoc($allc)['c_name']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $chk);
        $column++;
        $rowCount++;
        //$count++;                                                    
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cl != 0) {
                                            $total += $fg_amount_cl;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,"KG Term Fees Concession ($frmmto)");
        $column++;
       
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount_cl);
        $column++;
        $rowCount++;
        $count++;
    }
    $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount_cm += $amount;
                                                        }
                                                    }
                                                                             if($chk){
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            $column = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fees1['fi_name'].' - '.$fees1['fr_no']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,mysql_fetch_assoc($allc)['c_name']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $chk);
        $column++;
        $rowCount++;
        //$count++;                                                    
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cm != 0) {
                                            $total += $fg_amount_cm;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,"HS Term Fees Concession($frmmto)");
        $column++;
        
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount_cm);
        $column++;
       
        $rowCount++;
        $count++;
    }

    $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount_ch += $amount;
                                                        }
                                                    }
                                                    if($chk){
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            $column = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fees1['fi_name'].' - '.$fees1['fr_no']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,mysql_fetch_assoc($allc)['c_name']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $chk);
        $column++;
        $rowCount++;
        //$count++;                                           
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_ch != 0) {
                                            $total += $fg_amount_ch;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            $column = 'A';

        $content .= stripslashes($count) . ',';
        $content .= stripslashes($row5['name']) . ',';
        $content .= '-,';
        $content .= stripslashes($fg_amount) . ',';
        $content .= '-,';
        $content .= "\n";

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,"HSS Term Fees Concession($frmmto)");
        $column++;
        
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount_ch);
        $column++;
        
        $rowCount++;
        $count++;
    }
$other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' and fi_by='$user'");

                                        $book=0;
                                        $from='';
                                        $to='';
                                        $fromto='';
                                        $n=1;
                                        while($all=mysql_fetch_assoc($other)){
                                           if($n==1){
                                             $from=$all['fr_no'];
                                         }
                                             $to=$all['fr_no'];
                                         $n++;
                                            $book+=$all['discount'];
                                            if($all['discount']){
                                                $cccid=$all['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                $column = 'A';
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,$all['fi_name'].' - '.$all['fr_no']);
        $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,mysql_fetch_assoc($allc)['c_name']);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $all['discount']); $column++;
    //$count++;
    $rowCount++;
                                                            
                                                            
                                                            
                                                        }
                                           
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        if($book!=0) {
    $column = 'A';
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
        $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Books, Notes & Other Items Fees Concession('.$fromto.')');  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $book); $column++;
    $count++;
    $rowCount++;
    }

$objPHPExcel->getActiveSheet()->setTitle("Income And Expenses Summary");
//$i++;




//---------------------------------------Liabilities-----------------------------------------
$sheet = $objPHPExcel->getActiveSheet();
$objWorkSheet1 = $objPHPExcel->createSheet($i);
$column = 'A';

$content .= 'Liabilities :,';
$content .= ',';
$content .= ',';
$content .= ',';
$content .= "\n";

$objWorkSheet1->setCellValue($column . $rowCount, 'Liabilities : ');
$column++;

/* * **************Expenses ************************ */
$count = 1;
$etotal1 = 0;
$qry6 = mysql_query("SELECT exc_id,ex_category FROM ex_category");
$excount = 1;
$indisplay = 1;
while ($row6 = mysql_fetch_array($qry6)) {
    $exc_id = $row6['exc_id'];
    $exsqry = mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id' order by count asc");
    $cont = 1;
    while ($exrow = mysql_fetch_array($exsqry)) {
        $category_id = $exrow["category"];
        $exsid = $exrow["exs_id"];
        $count1 = $exrow["count"];
        $subexname = $exrow["sub_name"];
        if ($count1 == 0) {
            for ($j = 1; $j <= 20; $j++) {
                $sub_id = $exrow["sub" . $j . "_id"];

                if ($sub_id != 0) {
                    $field = $j;
                }
            }
            $fieldno = $field + 1;
            $myarray = array();
            array_push($myarray, $exsid);
            $subname = "sub" . $fieldno . "_id";
            $classlist2 = mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
            while ($class2 = mysql_fetch_array($classlist2)) {
                //$sub_id=$class1["sub".$j."_id"];
                array_push($myarray, $class2['exs_id']);
            }

            $exc_amount = 0;
            //$feeslist1=mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate. "' AND exc_id=$exc_id AND  exs_id IN (".implode(',',$myarray).") AND type='1'"); 
            $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id AND  exs_id IN (" . implode(',', $myarray) . ") AND type='1' AND billgenerate='$user'");
            while ($fees1 = mysql_fetch_array($feeslist1)) {
                $exid = $fees1['ex_id'];
                $amount1 = $fees1['amount'];
                $amountpaid = 0;
                $pending = 0;
                $bill_summery = mysql_query("SELECT amount FROM exponses_bill_summary WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate . "' AND ex_id=$exid AND exc_id=$exc_id");
                while ($summery = mysql_fetch_assoc($bill_summery)) {
                    $amountpaid +=$summery['amount'];
                }
                //echo $amount1."-".$amountpaid."<br>";
                $pending = $amount1 - $amountpaid;
                $exc_amount += $pending;
            }
            if ($exc_amount != 0) {
                if ($cont == '1') {

                    $column = 'A';

                    $content .= ',';
                    $content .= stripslashes($excount . ". " . $row6['ex_category']) . ',';
                    $content .= ',';
                    $content .= "\n";

                    $objWorkSheet1->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objWorkSheet1->setCellValue($column . $rowCount, $excount . ". " . $row6['ex_category']);
                    $column++;
                    $objWorkSheet1->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $rowCount++;

                    $cont = 0;
                    $excount++;
                }

                $column = 'A';

                $content .= stripslashes($count) . ',';
                $content .= stripslashes($subexname) . ',';
                $content .= stripslashes($exc_amount) . ',';
                $content .= "\n";

                $objWorkSheet1->setCellValue($column . $rowCount, $count);
                $column++;
                $objWorkSheet1->setCellValue($column . $rowCount, $subexname);
                $column++;
                $objWorkSheet1->setCellValue($column . $rowCount, $exc_amount);
                $column++;
                $rowCount++;


                $count++;
            }
            $etotal1 += $exc_amount;
        }
    }
}
$rowCount++;
$column = 'A';

$content .= ',';
$content .= 'Total ,';
$content .= stripslashes(round($etotal1, 2)) . ',';
$content .= "\n";

$objWorkSheet1->setCellValue($column . $rowCount, '');
$column++;
$objWorkSheet1->setCellValue($column . $rowCount, 'Total');
$column++;
$objWorkSheet1->setCellValue($column . $rowCount, round($etotal1, 2));
$column++;
$rowCount++;
$objWorkSheet1->setTitle("Liabilities");


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Income & Expense Ledger($sdate-$edate).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
