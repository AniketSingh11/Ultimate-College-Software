<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$bid=$_GET['bid'];
							$acyear=$_GET['acid'];
							$date=$_GET['date'];
							if(!$date){
								$date=date("d/m/Y");
							}
							$idatesplit=explode("/",$date);  
							$day=$idatesplit[0]; 
							$month=$idatesplit[1];
							$year=$idatesplit[2];
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  
								  $qry="SELECT result,result_half,ss_id FROM attendance WHERE day=$day AND month=$month AND year=$year AND ay_id=$acyear AND (result='0' OR result='off')";
							if($cid){
								$qry .=" AND c_id=$cid";
							}if($sid){
								$qry .=" AND s_id=$sid";
							}
							//$qry=mysql_query($qry);  
 //echo $qry;

$qry = mysql_query($qry) or die(mysql_error());
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Parent's name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Phone no");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Gender");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Details");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;
$count=1;
//echo mysql_num_rows($result);
while($row = mysql_fetch_array($qry))

{
    $column = 'A';

  $ssid=$row['ss_id'];
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_array($studentlist);
								   $result=$row['result'];
								   $result_half=$row['result_half'];
								   	$cid=$student['c_id'];
									$sid=$student['s_id'];
									$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								  
								  if($student['gender']=='M'){
									  $gender="Male";
								  }else if($student['gender']=='F'){
									  $gender="Female";
								  }
								   if($result=='0' || $result=='off'){
									   
									   if($result=='0'){
										   $re="X";
									   }else if($result=='off'){
										   if($result_half=="M"){
											   $re="Morning absent";
										   }else if($result_half=="E"){
											   $re="Evening absent";
										   }
									   }
							    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']."/".$section['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $gender); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $re); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($class['c_name']."/".$section['s_name']). ',';
										$content .= stripslashes($gender). ',';
										$content .= stripslashes($re). ',';
										$content .= "\n";
							$count++;	
							}

}
$objPHPExcel->getActiveSheet()->setTitle("Fees Paid Report");


$ptypename=str_replace(" ","",$ptypename);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=TodayAbsent-list($date).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
