<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
						  
 	 $acyear=$_GET['acid'];
	
	$syear=$_GET['syear'];
	$eyear=$_GET['eyear'];

			$s_id=$_GET["id"];
			$type=$_GET["type"];
			if($type=='st'){
			$stid=$s_id;
			$oid=0;
			$did=0;
			$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
			  $staff1=mysql_fetch_array($stafflist);
			  $staffid=$staff1['staff_id'];
			  $staffname=$staff1["fname"]." ".$staff1["lname"];
			}else if($type=='ow'){
				$stid=0;
				$oid=$s_id;
				$did=0;
				$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$oid"); 
			  $staff1=mysql_fetch_array($stafflist);
			  $staffname=$staff1["fname"]." ".$staff1["lname"];
			  $staffid=$staff1['others_id'];			  
			  $ocid=$staff1["category_id"];			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			}else if($type=='dr'){
				$stid=0;
				$oid=0;
				$did=$s_id;
				$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
			  $staff1=mysql_fetch_array($stafflist);
			  $staffid=$staff1['driver_id'];		
			  $staffname=$staff1["fname"]." ".$staff1["lname"];	
			}
	 		
			$emp_query="select * from staff_leave where (st_id=$stid AND o_id=$oid AND d_id=$did) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5')) order by id desc";
			$emp_result=mysql_query($emp_query);
			
			$name=$staffname."-Leave Details (".$syear." - ".$eyear.")";
	
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "S.No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Applied Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "From Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "To Date");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Days");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Leave Type");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;
$count=1;
while($emp_display = mysql_fetch_array($emp_result))
{
    $column = 'A';			  
								  if($emp_display['status']=='0'){
									  $status="Pending";
								  }else if($emp_display['status']=='1'){
									  $status="Approved";
								  }else{
									  $status="Rejected";
								  }
    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["a_date"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["f_date"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["t_date"]); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_total"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["l_type_name"]); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($emp_display["a_date"]). ',';
										$content .= stripslashes($emp_display["f_date"]). ',';
										$content .= stripslashes($emp_display["t_date"]). ',';
										$content .= stripslashes($emp_display["l_total"]). ',';
										$content .= stripslashes($emp_display["l_type_name"]). ',';
										$content .= stripslashes($status). ',';
										$content .= "\n";
							$count++;	
}

$objPHPExcel->getActiveSheet()->setTitle("Applied Leaves ( $syear - $eyear )");

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);

$emp_query="select * from leavetype order by lt_id asc";										
		$emp_result=mysql_query($emp_query);
		
		
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "S.No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Leave Type Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "approval leave");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Leave Taken");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Leave Remains");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;
$count=1;
while($emp_display = mysql_fetch_array($emp_result))
{
    $column = 'A';			  
								  $other=$emp_display["other"];
			$lt_id=$emp_display["lt_id"];
			$tleave=0;
			$emp_query1="select * from staff_leave where status='1' AND (st_id=$stid AND o_id=$oid AND d_id=$did AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			$emp_result1=mysql_query($emp_query1);
			while($emp_display1=mysql_fetch_array($emp_result1))
			{
				$tleave +=$emp_display1['l_total'];
			}
			$rleave=$emp_display["l_total"]-$tleave;
			if($other){
				$ltotal="-";
				$rleave="-";
			}else{
				$ltotal=$emp_display["l_total"];
			}
			if($other){
				$status="Open";
			}else{if($rleave<'1'){
				$status="Closed";
			}else{
				$status="Open";
			}
			}
    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["lt_name"]);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ltotal);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $tleave); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rleave); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($emp_display["lt_name"]). ',';
										$content .= stripslashes($ltotal). ',';
										$content .= stripslashes($tleave). ',';
										$content .= stripslashes($rleave). ',';
										$content .= stripslashes($status). ',';
										$content .= "\n";
							$count++;	
}

$objPHPExcel->getActiveSheet()->setTitle("Yearly Leave Details");

$ptypename=str_replace(" ","",$ptypename);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
