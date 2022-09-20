<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
						  
 	 $acyear=$_GET['acid'];
	$month=date("M");
$year=date("Y");
$m_value=$_GET['m'];
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];

if($m_value>5){
	$y_value=$syear;
}else if($m_value<=5){
	$y_value=$eyear;
}

$myarray = array();
										
										$alldedlist2=mysql_query("SELECT id FROM staff_allw_ded WHERE pe_type!=0"); 
								  while($allded2=mysql_fetch_assoc($alldedlist2))
								  { 	
								  $adid=$allded2['id'];
								  array_push($myarray,$adid);
								  }
								  $emp_query="SELECT DISTINCT a.* FROM staff_month_salary a, staff_month_salary_summary b WHERE a.month=$m_value AND a.year=$y_value AND a.st_ms_id = b.st_ms_id AND b.ad_id IN (".implode(',',$myarray).") AND b.pevalue AND b.amount"; 									
							$emp_result=mysql_query($emp_query);

$result = mysql_query($emp_query) or die(mysql_error());


$name=$months[$m_value]." - ".$y_value;
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

$objPHPExcel->getActiveSheet()->setCellValue("F1"," $name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(50);cellFont("F1","Calibri");
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Name");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Role");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Salary");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "EPF");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Mng. EPF");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "ESI");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Mng. ESI");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "EPF Total");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "ESI Total");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);cellFont("J2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 4;
$overalltotal=0;
while($emp_display = mysql_fetch_array($emp_result))
{
    $column = 'A';
					$emp_id=$emp_display["st_ms_id"];	
								$st_id=$emp_display["st_id"];
								$o_id=$emp_display["o_id"];	
								$d_id=$emp_display["d_id"];	
								$esipf=mysql_query("SELECT ad_id,amount,pevalue FROM staff_month_salary_summary WHERE st_ms_id=$emp_id AND ad_id IN (".implode(',',$myarray).")");		
								while($esipflist=mysql_fetch_assoc($esipf))
								  { 	
								  	if($esipflist['ad_id']=='8'){
										$PFstaffpreamount=$esipflist['amount'];
										$PFpreamount=$esipflist['pevalue'];
									}else if($esipflist['ad_id']=='10'){
										$ESIstaffpreamount=$esipflist['amount'];
										$ESIpreamount=$esipflist['pevalue'];
									}
								  }
								  $ESItotal=$ESIstaffpreamount+$ESIpreamount;
								  $EPFtotal=$PFstaffpreamount+$PFpreamount;
								  $total=$ESItotal+$EPFtotal;	
								  $overalltotal+=$total;
			
		
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["staff_name"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["role"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["n_salary"]); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $PFstaffpreamount); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $PFpreamount); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ESIstaffpreamount); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ESIpreamount); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $EPFtotal); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ESItotal); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, round($total)); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($emp_display["staff_name"]). ',';
										$content .= stripslashes($emp_display["role"]). ',';
										$content .= stripslashes($emp_display["n_salary"]). ',';
										$content .= stripslashes($PFstaffpreamount). ',';
										$content .= stripslashes($PFpreamount). ',';
										$content .= stripslashes($ESIstaffpreamount). ',';
										$content .= stripslashes($ESIpreamount). ',';
										$content .= stripslashes($EPFtotal). ',';
										$content .= stripslashes($ESItotal). ',';
										$content .= stripslashes(round($total)). ',';
										$content .= "\n";
							$count++;	
}
$rowCount++;
		$column = 'A';
					
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= 'Total';
	$content .= stripslashes(round($overalltotal, 2)).',';
	$content .= "\n";
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Total');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, round($overalltotal));  $column++;
	
	
$objPHPExcel->getActiveSheet()->setTitle("ESI AND EPF Salary Report");
$ptypename=str_replace(" ","",$ptypename);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name-ESI-EPF-salary-report.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
