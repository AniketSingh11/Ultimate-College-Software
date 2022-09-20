<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
						  
 	 $down=$_GET['down'];
	 $downame="All Student List";
	 $acyear=$_GET['acid'];
	 $gen=$_GET['gen'];
	 $cid=mysql_real_escape_string($_GET['cid']);
	 $bid=mysql_real_escape_string($_GET['bid']);
			
	$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  
								  $qry="SELECT * FROM pre_admission WHERE ay_id='$acyear'";							
							if($bid){
								$qry .=" AND b_id='$bid'";
							}
							if($cid){
								$qry .=" AND c_id='$cid'";
							}
							if($down=="2"){
								$qry .=" AND status='0'";
								$downame="Process Student List";
							}
							if($down=="3"){
								$qry .=" AND status='1'";
								$downame="Selected Student List";
							}
							if($down=="4"){
								$qry .=" AND status='2'";
								$downame="Rejected Student List";
							}
							if($gen=="M"){
								 $qry .=" ORDER BY gender DESC,c_id,firstname ASC";
							 }else if($gen=="F"){
								 $qry .=" ORDER BY gender,c_id,firstname ASC";
							 }else {
								 $qry .=" ORDER BY c_id,firstname ASC";
							 }

$result = mysql_query($qry) or die(mysql_error());
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pre Admin No");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Parent's name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date of Birth");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Gender");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Phone No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Detail");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;

while($row = mysql_fetch_array($result))
{
    $column = 'A';
						$cid=$row['c_id'];
	 						$classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  if($row['gender']=='M'){
									  $gender="Male";
								  }else{
									  $gender="Female";
								  }
								  if($row['status']=='1'){ 
								  	$status="Selected";
								  }else if($row['status']=='2'){
									  $status="Rejected";
								  } else {
									  $status="Processing";
								  }
    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['pa_admission_no']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['firstname']." ".$row['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['dob']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $gender); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['phone_number']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($row['pa_admission_no']). ',';
										$content .= stripslashes($row['firstname']." ".$row['lastname']). ',';
										$content .= stripslashes($row['fathersname']). ',';
										$content .= stripslashes($row['dob']). ',';
										$content .= stripslashes($gender). ',';
										$content .= stripslashes($class1['c_name']). ',';
										$content .= stripslashes($row['phone_number']). ',';
										$content .= stripslashes($status). ',';
										$content .= "\n";
							$count++;	
}
$objPHPExcel->getActiveSheet()->setTitle("Fees Paid Report");


$ptypename=str_replace(" ","",$ptypename);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=pre-admission-report($downame).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
