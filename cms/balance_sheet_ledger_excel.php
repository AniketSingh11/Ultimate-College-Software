<?php

require("includes/config.php");
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

$sdate = "01/04/" . $syear;
$edate = "31/03/" . $eyear;

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

// Initialise the Excel row number

$rowCount = 2;


$objPHPExcel->getActiveSheet()->setCellValue("B1", " $school_name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(50);
cellFont("B1", "Calibri");
//start of printing column names as names of MySQL fields

$column = 'A';


/*   for ($i = 1; $i < mysql_num_fields($result); $i++)

  {
  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
  $column++;
  }
 */

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
cellFont("A2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "S.No");
$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
cellFont("B2", "Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Particular");
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

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;



$content = '';
$title = '';


$count = 1;
$total = 0;
$indisplay = 1;
$assettotal = 0;

/* * *******************************Other Fees******************************* */
$qry5 = mysql_query("SELECT fgd_id,fg_id,name FROM fgroup_detail");
while ($row5 = mysql_fetch_assoc($qry5)) {
    if($row5['fg_id']==4){
    $fgd_id = $row5['fgd_id'];
    $fg_amount = 0;

    $feeslist2 = mysql_query("SELECT SUM(b.amount) as amount FROM finvoice a, fsalessumarry b WHERE (a.fi_year*10000) + (a.fi_month*100) + a.fi_day between '" . $startdate . "' AND '" . $enddate . "' AND a.c_status!='1' AND a.i_status='0' AND a.fi_id=b.fi_id AND b.fgd_id=$fgd_id");
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

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $row5['name']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;


        $count++;
    }
    }

}
$fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                        
                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%'");
                                               
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

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,"KG Term Fees ($frmmto)");
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount_cl);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }

$feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%'");
                                               
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

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,"HS Term Fees ($frmmto)");
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount_cm);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }

    $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%'");
                                               
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

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount,"HSS Term Fees ($frmmto)");
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount_ch);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }


// Books, Notes & Other Items
$column = 'A';

$other = mysql_query("SELECT * FROM finvoice_others WHERE ay_id='" . $acyear . "' and c_status!='1' AND i_status='0'");

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
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Books, Notes & Other Items (".$fromto.")");
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $book);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
$column++;
$rowCount++;
}

/********************** TC Issued charges ******************************************************/
     $other=mysql_query("SELECT * FROM tc_xi WHERE ay_id='" . $acyear. "'");
     $other1=mysql_query("SELECT * FROM tc_xi_kg WHERE ay_id='" . $acyear. "'");
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
$feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' and c_status!='1' AND i_status='0'");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Last Year Pending Fees');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $fg_amount);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;


    $count++;
}
$etotal = 0;
$qry1 = mysql_query("SELECT fund_amount FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND funds='1' and c_status!='1' AND i_status='0'");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Student Discount Funds');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $sdf_total);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Book Fees');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $book_amount);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;


    $count++;
}
$f=1;
$bamountthisyear = 0;
$bus_lastyear = 0;
$booklist1 = mysql_query("SELECT fi_total,pending,fr_no FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND c_status!='1' AND i_status='0'");
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
}
if ($bamountthisyear != 0) {
    $total +=$bamountthisyear;
    $column = 'A';

    $content .= stripslashes($count) . ',';
     $content .= stripslashes("Bus Fees (".$start_binv.'-'.$end_binv.")") . ',';
    $content .= '-,';
    $content .= stripslashes($bamountthisyear) . ',';
    $content .= '-,';
    $content .= "\n";

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "Bus Fees (".$start_binv.'-'.$end_binv.")");
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $bamountthisyear);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Last Year Pending Bus Fees');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $bus_lastyear);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ************************************* Loan Payment Income *********************************************** */
$loanpay_amount = 0;
$booklist = mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "'");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Loan Payment');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $loanpay_amount);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
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
    $booklist1 = mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND inc_id=$incid");
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

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $row1['in_category']);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $in_amount);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
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
    $exc_id = $row6['exc_id'];
    $e_category = $row6['e_category'];
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
            $feeslist1 = mysql_query("SELECT status,amount,pending FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ") AND type=0");
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
                $check1 = mysql_query("SELECT ex_id FROM exponses WHERE ex_id=$exid AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ")");
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
                    $content .= "\n";

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $excount . ". " . $row6['ex_category']);
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
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

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
                $column++;
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $subexname);
                $column++;
                if ($e_category == '1') {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount);
                    $column++;
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount);
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
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
$booklist1 = mysql_query("SELECT total_amount FROM exp_allowance WHERE (cdate >= '$startdate1' AND cdate <= '$enddate1')");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Daily Allowance');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $d_amount);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ********************************Principal Salary ******************************** */
$sqry = mysql_query("SELECT st_id FROM staff Where prince='1'");
$srow = mysql_fetch_assoc($sqry);
$pstid1 = $srow['st_id'];
$exc_amount1 = 0;

$feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id=$pstid1 ");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Principal Salary');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}

/* * ********************************Teaching Staff Salary ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id AND st_id!=$pstid1");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Teaching Staff Salary');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ********************************Non-Teaching Staff Salary ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND (o_id OR d_id)");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Non-Teaching Staff Salary');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ******************************** Staff Salary Advance  ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT a_amount FROM staff_advance WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND status=0");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Staff Salary Advance');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
/* * ******************************** Staff Loan ******************************** */
$exc_amount1 = 0;
$feeslist2 = mysql_query("SELECT l_amount FROM staff_loan WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "'");
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Staff Loan');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount1);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
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
    $feeslist2 = mysql_query("SELECT b.pevalue,b.amount FROM staff_month_salary a, staff_month_salary_summary b WHERE (a.year*10000) + (a.month*100) + a.day between '" . $startdate . "' AND '" . $enddate . "' AND a.st_ms_id = b.st_ms_id AND b.ad_id=$adid AND b.pevalue");
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

        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $adname . 'Contribution');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount1);
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
        $column++;
        $rowCount++;
        $count++;
    }
}


// start advance expense


$qry_adv = "SELECT sum(adv_amt) as advance FROM agency_advance WHERE DATE(adv_date) between '" . $startdate1 . "' AND '" . $enddate1 . "'";
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

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "ADVANCE PAYMENT");
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $advance_result['advance']);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
//end advance expense
// start purchase expense

$qry_pur = "SELECT sum(overeall_total) as purchase_amt FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "'";
$pur_qry = mysql_query($qry_pur);
$pur_result = mysql_fetch_assoc($pur_qry);

if ($pur_result['purchase_amt'] != 0) {
    $etotal = $etotal + $pur_result['purchase_amt'];

    $all = "SELECT  * FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "'";
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
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= stripslashes("INVENTORY PURCHASE") . ',';
    $content .= '-,';
    $content .= stripslashes($in_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "INVENTORY PURCHASE (".$fromto.")");
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $pur_result['purchase_amt']);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
//end purchase expense
// start material issue income


$qry_mat = "SELECT sum(overall_total) as material_amt FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1";
$mat_qry = mysql_query($qry_mat);
$mat_result = mysql_fetch_assoc($mat_qry);

if ($mat_result['material_amt'] != 0) {
    $total = $total + $mat_result['material_amt'];
    $qry_mat1 = "SELECT * FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1";
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
    $column = 'A';

    $content .= stripslashes($count) . ',';
    $content .= stripslashes("INVENTORY MATERIAL ISSUE") . ',';
    $content .= '-,';
    $content .= stripslashes($in_amount) . ',';
    $content .= '-,';
    $content .= "\n";

    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, "INVENTORY MATERIAL ISSUE (".$fromto.")");
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $mat_result['material_amt']);
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '-');
    $column++;
    $rowCount++;
    $count++;
}
//end material issue income



$rowCount++;
$column = 'A';

$content .= ',';
$content .= 'Total ,';
$content .= stripslashes(round($etotal, 2)) . ',';
$content .= stripslashes(round($total, 2)) . ',';
$content .= stripslashes(round($assettotal, 2)) . ',';
$content .= "\n";
$total = $total + $book;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Total');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $etotal);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $total);
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $assettotal);
$column++;
$rowCount++;
$rowCount++;
$expencetotal = $etotal + $assettotal;
$finaltotal = $total - ($etotal + $assettotal);
$column = 'A';

$content .= ',';
$content .= 'Income :' . $total . ' | Expenses :' . $expencetotal . ' ( ' . round($total, 2) . ' -  (' . round($etotal, 2) . ' + ' . round($assettotal, 2) . ' ) )';
$content .= 'Profit Total : ,';
$content .= stripslashes($finaltotal) . ',';
$content .= "\n";

$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Income :' . round($total, 2) . ' | Expenses :' . round($expencetotal, 2) . '( ' . round($total, 2) . ' - (' . round($etotal, 2) . ' + ' . round($assettotal, 2) . ' ) )');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Profit Total :');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, round($finaltotal, 2));
$column++;
$rowCount++;

$rowCount++;
$rowCount++;
$column = 'A';

$content .= 'Liabilities :,';
$content .= ',';
$content .= ',';
$content .= ',';
$content .= "\n";

$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Liabilities : ');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
$column++;
$rowCount++;
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
            $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate . "' AND exc_id=$exc_id AND  exs_id IN (" . implode(',', $myarray) . ") AND type='1'");
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

                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $excount . ". " . $row6['ex_category']);
                    $column++;
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, ' ');
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

                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $count);
                $column++;
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $subexname);
                $column++;
                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $exc_amount);
                $column++;
                $rowCount++;


                $count++;
            }
            $etotal1 += $exc_amount;
        }
    }
}
$rowCount++;
$rowCount++;
$column = 'A';

$content .= ',';
$content .= 'Total ,';
$content .= stripslashes(round($etotal1, 2)) . ',';
$content .= "\n";

$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, '');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, 'Total');
$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, round($etotal1, 2));
$column++;
$rowCount++;

/* * ***************************************sheet 2 ************************************************ */
$objPHPExcel->getActiveSheet()->setTitle("Student BoardingPointDetails");

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Finance Year Full Ledger($syear-$eyear).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
