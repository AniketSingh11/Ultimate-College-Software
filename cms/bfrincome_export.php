<?php
require("includes/config.php");
/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=bus-fees-income-report.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

	 		$s_erno=$_GET['s_erno'];
			$e_erno=$_GET['e_erno'];
			$bid=$_GET['b_id'];
			$ayid=$_GET['ayid'];
			
			if(!empty($bid) && $bid!='All') {
					$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
					}
			if($bid=='All'){ 
			$b_name="All"; } else { 
			$b_name=$ecategory['b_name'];
			 }
			
					
			 require_once 'Classes/PHPExcel.php';
			 
			 
			 require_once 'Classes/PHPExcel/IOFactory.php';
			 
			 $excel_readers = array(
			     'Excel5' ,
			     'Excel2003XML' ,
			     'Excel2007'
			 );
			 
			 function cellColor($cells,$color){
			     global $objPHPExcel;
			 
			     $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
			         'type' => PHPExcel_Style_Fill::FILL_SOLID,
			         'startcolor' => array(
			             'rgb' => $color
			         )
			     ));
			 }
			 
			 
			 function cellFont($cells,$fontfamily){
			     global $objPHPExcel;
			 
			     $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
			         'font'  => array(
			             'bold'  => true,
			             'color' => array('rgb' => '000000'),
			             'size'  => 12,
			             'name'  => $fontfamily
			         )));
			 }
			 
			 
			 
			 $reader = PHPExcel_IOFactory::createReader('Excel5');
			 $reader->setReadDataOnly(false);
			 
			 
			 $objPHPExcel = new PHPExcel();
			 
			 // Set the active Excel worksheet to sheet 0
			 
			 $objPHPExcel->setActiveSheetIndex(0);
			 
			 // Initialise the Excel row number
			 
			 $rowCount = 2;
			 
			 $objPHPExcel->getActiveSheet()->setCellValue("D1"," $school_name ");
			 $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(50);cellFont("D1","Calibri");
			 //start of printing column names as names of MySQL fields
			 
			 $column = 'A';
			 
			 /*   for ($i = 1; $i < mysql_num_fields($result); $i++)
			 
			 {
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
			 $column++;
			 }
			 */
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "FR No");$column++;
			 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Board");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Category");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student type");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Inovice By");$column++;
			 
			 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
			 
			 $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
			 
			 
			 //end of adding column names
			 //start while loop to get data
			 
			 $rowCount = 3;
			 
			 
			 
			 
	 $qry="SELECT * FROM bfinvoice WHERE fr_no >= " . $s_erno. " AND fr_no <=" . $e_erno. " AND ay_id=$ayid AND c_status!='1' AND i_status='0'";
							if(!empty($bid) && $bid!='All') { $qry .= " AND bid = '" . $bid. "'"; }
							$qry=mysql_query($qry);
$total=0;
$content = '';
$title = '';
$count=1;
while($rs=mysql_fetch_array($qry)) { 
    
    $column = 'A';
$bid1=$rs['bid'];
$cid=$rs['c_id'];
				$sid=$rs['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
$boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);
					$boardname=$board1['b_name'];
								  
								  $spid1=$rs['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $rid1=$row6['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
								  
		$total +=$rs['fi_total'];
		
	$amount =number_format($rs["fi_total"],2);
	$content .= stripslashes($count). ',';
	$content .= stripslashes($rs["fr_no"]). ',';
	$content .= stripslashes($rs["fi_name"]). ',';
	$content .= stripslashes($rs["fi_day"]." / ".$rs["fi_month"]." / ".$rs["fi_year"]). ',';
	$content .= stripslashes($boardname). ',';
	$content .= stripslashes($class["c_name"]."/".$section['s_name']). ',';
	$content .= stripslashes($row5['r_name']). ',';
	$content .= stripslashes($row6['stop_name']). ',';
	$content .= stripslashes($rs["bfi_by"]). ',';
	$content .= $amount. ',';
	$content .= "\n";
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fr_no"]);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fi_name"]);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fi_day"]." / ".$rs["fi_month"]." / ".$rs["fi_year"]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $boardname); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class["c_name"]."/".$section['s_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row5['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row6['stop_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["bfi_by"]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $amount); $column++;
	
	$rowCount++;
	
	$count++;	
}
$content .= " Totol : ".$total."\n\n";
$title .= "Bus Fees Income Report ( ".$b_name." )\n\n";
$title .= "s.no,FR No,Student Name,Date,Board,Class-Section,Route Name,Stopping,Inovice By,Amount"."\n";
//echo $title;
//echo $content;

$objPHPExcel->getActiveSheet()->setTitle("Fees Income Report Based FR.No");

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FR-FeesIncome_report-list.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
