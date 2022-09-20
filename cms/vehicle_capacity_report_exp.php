<?php
require("includes/config.php");
$type=$_GET['type'];

/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$type-vehicle-capacity-report.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


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
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(80);cellFont("D1","Calibri");
//start of printing column names as names of MySQL fields

$column = 'A';

/*   for ($i = 1; $i < mysql_num_fields($result); $i++)

{
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
$column++;
}
*/

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus No");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Reg.No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Model No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Route Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Capacity");$column++;
	

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Capacity");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Capacity");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Vacancy");$column++;



$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;

			$acyear=$_GET['ayid'];
	if($type=='normal'){		
$content = '';
$title = '';			
					
					$qry=mysql_query("SELECT * FROM vehicle");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
        		    
        		    $column = 'A';
						$vid=$row['v_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE v_id=$vid"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $rid=$row5['r_id'];
								  
								   $myarray = array();
								  $spqry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($sprow=mysql_fetch_array($spqry))
									{
										array_push($myarray,$sprow['stop_id']);										
									}
									
								  $qry1=mysql_query("SELECT * FROM student WHERE sp_id IN (".implode(',',$myarray).") AND busfeestype='0' AND ay_id=$acyear");
								  $stucount=mysql_num_rows($qry1);
								  
								  
								  
								  $qry2=mysql_query("SELECT * FROM staff WHERE sp_id IN (".implode(',',$myarray).") AND busfeestype='0'");
								  $staffcount=mysql_num_rows($qry2);
								  
								  $vacancy=$row['v_capacity']-($stucount+$staffcount);
								  $v_regno=$text = str_replace(',', ' ', $row['v_regno']);
	$content .= stripslashes($count). ',';
	$content .= stripslashes($row['v_no']). ',';
	$content .= stripslashes($v_regno). ',';
	$content .= stripslashes($row['v_mno']). ',';
	$content .= stripslashes($row5['r_name']). ',';
	$content .= stripslashes($row['v_capacity']). ',';
	$content .= stripslashes($stucount). ',';
	$content .= stripslashes($staffcount). ',';
	$content .= stripslashes($vacancy). ',';
	$content .= "\n";
	$count++;	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_no']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$v_regno);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_mno']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row5['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_capacity']); $column++;
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $stucount); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staffcount); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $vacancy); $column++;
	
	
	$rowCount++;
	
	
	
}
//$content .= "\n\n Vehicle No : ".$vehicle['v_no']." - Driver Name : ".$driver['fname']." ".$driver['lname']." - Bus Assistant : ".$driver1['fname']." ".$driver1['lname']."\n";
$title .= "Vehicle Capacity Details \n\n";
$title .= "s.no,Bus No,Bus Reg.No,Bus Model No,Route Name,Bus Capacity,Student Capacity,Staff Capacity,Vacancy"."\n";
//echo $title;
//echo $content;
	} else if($type=='special'){		
$content = '';
$title = '';			
					
					$qry=mysql_query("SELECT * FROM vehicle");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
        		    
        		    $column = 'A';
						$vid=$row['v_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE v_id=$vid"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $rid=$row5['r_id'];
								  
								  $myarray = array();
								  $spqry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($sprow=mysql_fetch_array($spqry))
									{
										array_push($myarray,$sprow['stop_id']);										
									}
									
								  $qry1=mysql_query("SELECT * FROM student WHERE sp_id IN (".implode(',',$myarray).") AND (busfeestype='1' OR busfeestype='1') AND ay_id=$acyear");
								  $stucount=mysql_num_rows($qry1);
								  
								  $qry2=mysql_query("SELECT * FROM staff WHERE sp_id IN (".implode(',',$myarray).") AND (busfeestype='1' OR busfeestype='1')");
								  $staffcount=mysql_num_rows($qry2);
								  
								  $vacancy=$row['v_capacity']-($stucount+$staffcount);
								  $v_regno=$text = str_replace(',', ' ', $row['v_regno']);
	$content .= stripslashes($count). ',';
	$content .= stripslashes($row['v_no']). ',';
	$content .= stripslashes($v_regno). ',';
	$content .= stripslashes($row['v_mno']). ',';
	$content .= stripslashes($row5['r_name']). ',';
	$content .= stripslashes($row['v_capacity']). ',';
	$content .= stripslashes($stucount). ',';
	$content .= stripslashes($staffcount). ',';
	$content .= stripslashes($vacancy). ',';
	$content .= "\n";
	$count++;	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_no']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$v_regno);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_mno']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row5['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_capacity']); $column++;
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $stucount); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staffcount); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $vacancy); $column++;
	
	$rowCount++;
}
//$content .= "\n\n Vehicle No : ".$vehicle['v_no']." - Driver Name : ".$driver['fname']." ".$driver['lname']." - Bus Assistant : ".$driver1['fname']." ".$driver1['lname']."\n";
$title .= "Vehicle Capacity Details \n\n";
$title .= "s.no,Bus No,Bus Reg.No,Bus Model No,Bus Capacity,Student Capacity,Staff Capacity,Vacancy"."\n";
//echo $title;
////echo $content;
	}  else {		
$content = '';
$title = '';			
					
					$qry=mysql_query("SELECT * FROM vehicle");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
        		    
        		    $column = 'A';
						$vid=$row['v_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE v_id=$vid"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $rid=$row5['r_id'];
								  $qry1=mysql_query("SELECT * FROM student WHERE r_id=$rid AND ay_id=$acyear");
								  $stucount=mysql_num_rows($qry1);
								  
								  $qry2=mysql_query("SELECT * FROM staff WHERE r_id=$rid");
								  $staffcount=mysql_num_rows($qry2);
								  
								  $vacancy=$row['v_capacity']-($stucount+$staffcount);
								  $v_regno=$text = str_replace(',', ' ', $row['v_regno']);
								$content .= stripslashes($count). ',';
								$content .= stripslashes($row['v_no']). ',';
								$content .= stripslashes($v_regno). ',';
								$content .= stripslashes($row['v_mno']). ',';
								$content .= stripslashes($row5['r_name']). ',';
								$content .= stripslashes($row['v_capacity']). ',';
								$content .= stripslashes($stucount). ',';
								$content .= stripslashes($staffcount). ',';
								$content .= stripslashes($vacancy). ',';
								$content .= "\n";
								$count++;	
	

	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_no']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$v_regno);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_mno']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row5['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['v_capacity']); $column++;
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $stucount); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staffcount); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $vacancy); $column++;
	
	$rowCount++;
	
	
}
//$content .= "\n\n Vehicle No : ".$vehicle['v_no']." - Driver Name : ".$driver['fname']." ".$driver['lname']." - Bus Assistant : ".$driver1['fname']." ".$driver1['lname']."\n";
$title .= "Vehicle Capacity Details \n\n";
$title .= "s.no,Bus No,Bus Reg.No,Bus Model No,Route Name,Bus Capacity,Student Capacity,Staff Capacity,Vacancy"."\n";
//echo $title;
//echo $content;
	}

	$objPHPExcel->getActiveSheet()->setTitle("$type-vehicle-capacity-Report");
	
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=$type-vehicle-capacity-report.xls");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
?>
