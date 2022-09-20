<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
						  
 	 $acyear=$_GET['acid'];
	$ltype=$_GET['ltype'];	
 	   $year=$_GET['year'];
	 		
	$emp_query="select * from staff_loan";										
											if($ltype && $year){
											$emp_query .=" where l_type=$ltype AND year=$year";										
											}else if($ltype && !$year){
											$emp_query .=" where l_type=$ltype";										
											}else if(!$ltype && $year){
												$emp_query .=" where year='$year'";										
											}
											$emp_query .=" order by l_id desc";	

$result = mysql_query($emp_query) or die(mysql_error());
require_once '../Classes/PHPExcel.php';


require_once '../Classes/PHPExcel/IOFactory.php';

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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Emp Code");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Emp Name ");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Loan type");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rate Of Interest");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Terms Of Month");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Monthly Payment");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Inrest");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);cellFont("J2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Payment");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);cellFont("K2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;

while($emp_display = mysql_fetch_array($result))
{
    $column = 'A';
					$l_id=$emp_display["l_id"];	
					$emp_id=$emp_display["st_id"];
					$emp_id1=$emp_display["o_id"];	
					$emp_id2=$emp_display["d_id"];	
			
			$loanpay1=mysql_query("SELECT * FROM staff_loan_pay WHERE l_id=$l_id"); 
								  $loanpay=mysql_fetch_array($loanpay1);
								  
								  if($emp_display['status']=='0'){
									  $pament="Payment Processing";
								  }else{
									  $pament="Completely Paid";
								  }
    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["staff_id"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["staff_name"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_date"]); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_type_name"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_amount"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_interest"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_terms"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_m_pay"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_t_interest"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_pay"]); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $pament); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($emp_display["staff_id"]). ',';
										$content .= stripslashes($emp_display["staff_name"]). ',';
										$content .= stripslashes($emp_display["l_date"]). ',';
										$content .= stripslashes($emp_display["l_type_name"]). ',';
										$content .= stripslashes($emp_display["l_amount"]). ',';
										$content .= stripslashes($emp_display["l_interest"]). ',';
										$content .= stripslashes($emp_display["l_terms"]). ',';
										$content .= stripslashes($emp_display["l_m_pay"]). ',';
										$content .= stripslashes($emp_display["l_t_interest"]). ',';
										$content .= stripslashes($emp_display["l_pay"]). ',';
										$content .= stripslashes($pament). ',';
										$content .= "\n";
							$count++;	
}
$objPHPExcel->getActiveSheet()->setTitle("Loan Report");
$ptypename=str_replace(" ","",$ptypename);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Loan-report.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
