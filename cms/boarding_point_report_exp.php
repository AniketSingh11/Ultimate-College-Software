<?php
require("includes/config.php");
/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=boarding-point-report.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/

$qry=mysql_fetch_array(mysql_query("select * from school_name"));

$school_name=$qry["sc_name"];

	 		$rid=$_GET['rid'];
			$acyear=$_GET['ayid'];
			
			 $classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $class=mysql_fetch_array($classlist);
								  $vid=$class['v_id'];
								  $rname=$class['r_name'];
							$did=$class['d_id'];
							$sdid=$class['sd_id'];
								$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid"); 
								$vehicle=mysql_fetch_array($vehiclelist);
								$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								$driver=mysql_fetch_array($driverlist);
								$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid"); 
								$driver1=mysql_fetch_array($driverlist1);
								
								$myarray = array();
								  $qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($row=mysql_fetch_array($qry))
									{
										array_push($myarray,$row['stop_id']);										
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
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No");$column++;
								$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Phone");$column++;
								 
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Boarding Point");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Type");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Type");$column++;
								
							 
								
								$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
								
								
								//end of adding column names
								//start while loop to get data
								
								$rowCount = 3;
								
									
								
$content = '';
$title = '';			
$spquery  = "SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID ASC";
$spresult = mysql_query($spquery);
$count=1;
while($sprow = mysql_fetch_array($spresult, MYSQL_ASSOC))
{
					$qry=mysql_query("SELECT * FROM student WHERE ay_id=$acyear AND sp_id='$sprow[stop_id]'ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
        		    $column = 'A';
        		    
					$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  $bid=$row['b_id'];
								$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid");
								  $row5=mysql_fetch_array($qry5);
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];
	$content .= stripslashes($count). ',';
	$content .= stripslashes($row['admission_number']). ',';
	$content .= stripslashes($row['firstname']." ".$row['middlename']." ".$row['lastname']). ',';
	$content .= stripslashes($class['c_name']." / ".$section['s_name'])." ( ".$board['b_name']." )". ',';
	$content .= stripslashes($row6['stop_name']). ',';
	$content .= stripslashes($fesstypearray1[$busfeestype1]). ',';
	$content .= stripslashes("Student"). ',';
	$content .= "\n";
	$count++;	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['admission_number']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['firstname']." ".$row['middlename']." ".$row['lastname']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']." / ".$section['s_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['phone_number']); $column++;
	 
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row6['stop_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fesstypearray1[$busfeestype1]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student"); $column++;
	
	$rowCount++;
}

}
$objPHPExcel->getActiveSheet()->setTitle("Student BoardingPointDetails");

$objPHPExcel->createSheet(1);

$objPHPExcel->setActiveSheetIndex(1);

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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff ID");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Phone Number");$column++;
	

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Boarding Point");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Type");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Type");$column++;



$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;

$spquery  = "SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID ASC";
$spresult = mysql_query($spquery);
$count=1;
while($sprow = mysql_fetch_array($spresult, MYSQL_ASSOC))
{
$qry=mysql_query("SELECT * FROM staff WHERE sp_id='$sprow[stop_id]' AND status=1 ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
			  while($row=mysql_fetch_array($qry))
        		{
        		    
        		    $column = 'A';
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];
		
		$content .= stripslashes($count). ',';
	$content .= stripslashes($row['staff_id']). ',';
	$content .= stripslashes($row['fname']." ".$row['mname']." ".$row['lname']). ',';
	$content .= stripslashes(" - "). ',';
	$content .= stripslashes($row6['stop_name']). ',';
	$content .= stripslashes($fesstypearray1[$busfeestype1]). ',';
	$content .= stripslashes("Staff"). ',';
	$content .= "\n";
	$count++;	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['staff_id']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['fname']." ".$row['mname']." ".$row['lname']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "-"); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['phone_no']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row6['stop_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fesstypearray1[$busfeestype1]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff"); $column++;
	$rowCount++;
				}
				
}
				$objPHPExcel->getActiveSheet()->setTitle("Staff BoardingPointDetails");
$content .= "\n\n Vehicle No : ".$vehicle['v_no']." - Driver Name : ".$driver['fname']." ".$driver['lname']." - Bus Assistant : ".$driver1['fname']." ".$driver1['lname']."\n";
$title .= $rname." Route Student/Staff Boarding Point Details \n\n";
$title .= "s.no,Admin No/Staff ID,Student/Staff Name,Class-Section,Booarding Point,Bus Type,Type"."\n";
//echo $title;
//echo $content;


$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Bus_BoardingPointDetails-list($row5[r_name]).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
