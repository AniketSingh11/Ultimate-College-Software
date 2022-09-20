<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
					  
 	 	$acyear=$_GET['acid'];
		$syear=$_GET['syear'];
		$eyear=$_GET['eyear'];
		$filter=$_GET['filt'];
		$l_type1=$_GET['ltype'];
								  
$y_value=$_GET['y'];
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May");

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];

										$emp_query="select * from staff_leave where ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
										if($filter=="Pending"){
											$emp_query.=" AND status='0'";
										}else if($filter=="Approved"){
											$emp_query.=" AND status='1'";
										}else if($filter=="Rejected"){
											$emp_query.=" AND status='2'";
										}
										if($l_type1){
											$emp_query.=" AND l_type='$l_type1'";
										}
											
										$emp_query.=" order by id desc";										
		$emp_result=mysql_query($emp_query);



$name="Employee Leave List  (".$syear." - ".$eyear." - ".$filter.")";
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

$objPHPExcel->getActiveSheet()->setCellValue("A2"," $name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(50);cellFont("A2","Calibri");
//start of printing column names as names of MySQL fields

$rowCount = 3;

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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Emp Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "From Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "To Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Leave");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Leave type");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());

//end of adding column names
//start while loop to get data

$rowCount = 4;

while($emp_display = mysql_fetch_array($emp_result))
{
    $column = 'A';
									$id=$emp_display["id"];	
									$emp_id=$emp_display["st_id"];
									
									if($emp_display['status']=='0'){
										$status="Pending";
									}else if($emp_display['status']=='1'){
										$status="Approved";
									 } else{
										 $status="Rejected";
										 }
								
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["staff_id"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["staff_name"]); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["f_date"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["t_date"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_total"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_type_name"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status); $column++;
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($emp_display["staff_id"]). ',';
										$content .= stripslashes($emp_display["staff_name"]). ',';
										$content .= stripslashes($emp_display["f_date"]). ',';
										$content .= stripslashes($emp_display["t_date"]). ',';
										$content .= stripslashes($emp_display["l_total"]). ',';
										$content .= stripslashes($emp_display["l_type_name"]). ',';
										$content .= stripslashes($status). ',';
										$content .= "\n";
							$count++;	
}
$objPHPExcel->getActiveSheet()->setTitle("Month Salary Report");
$ptypename=str_replace(" ","",$ptypename);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
