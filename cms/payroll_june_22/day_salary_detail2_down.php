<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
					  
 	 $acyear=$_GET['acid'];
	$month=date("M");
$year=date("Y");
$o_id=$_GET['id'];
$d_id=$_GET['id'];
$stafflist1=mysql_query("SELECT * FROM driver WHERE d_id=$d_id and s_type='1'"); 
								  $staff1=mysql_fetch_array($stafflist1);
								  
$y_value=$_GET['y'];
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May");

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];

$emp_query="select * from staff_daily_salary where d_id=$d_id AND ((year='$syear' AND month>5) OR (year='$eyear' AND month<=5)) order by st_ms_id desc";										
							$emp_result=mysql_query($emp_query);


$name=$staff1['fname']." ".$staff1['lname']." - (".$syear."-".$eyear.") Salary Details";
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Net Salary");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 4;

while($emp_display = mysql_fetch_array($emp_result))
{
    $column = 'A';
					$emp_id=$emp_display["st_ms_id"];
								
								$monthname=$emp_display["date_day"]." - ".$months[$emp_display["month"]]." - ".$emp_display["year"];	
			
		
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $monthname);  $column++;
							   
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["n_salary"]); $column++;
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($monthname). ',';
										
										$content .= stripslashes($emp_display["n_salary"]). ',';
										$content .= "\n";
							$count++;	
}
$objPHPExcel->getActiveSheet()->setTitle("Daily Salary Report");
$ptypename=str_replace(" ","",$ptypename);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
