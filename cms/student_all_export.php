<?php
require("includes/config.php");
session_start();
$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		if($bid){
			$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid");
//echo "SELECT * FROM board WHERE b_id=$bid";die;			
								  $board=mysql_fetch_array($boardlist);	
		}	

			$cid=$_GET['cid']; 			
			if($cid){
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
//echo "SELECT * FROM class WHERE c_id=$cid";die;				
								  $class=mysql_fetch_array($classlist);
			}
			
		 $setting_on=$_GET["order_gender"];
           
           if($setting_on=="1")
           {
               $s_gen="DESC";
               // $s_gen=array("M","F");
                
           }elseif ($setting_on=="2"){
               $s_gen="ASC";
               //  $s_gen=array("F","M");
           }else{
               $s_gen="ASC";
               //  $s_gen=array("M","F");
                    
           }	
			

//$qry = mysql_query($qry) or die(mysql_error());
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

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Gender");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "DOB");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Religion");$column++;


$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;
 $count=1;
                        //    for($i=0;$i<2;$i++)
                        //    {
                            
							$qry="SELECT * FROM student WHERE ay_id='$acyear' AND user_status=1";
							//echo "SELECT * FROM student WHERE ay_id='$acyear' AND user_status=1";die;
							if($bid){
								$qry .=" AND b_id='$bid'";
							}
							if($cid){
								$qry .=" AND c_id='$cid'";
							}							
							 //$qry .=" AND s_id='0' AND pa_id!='0' ORDER BY firstname ASC";
					// $qry .=" AND user_status='1' ORDER BY c_id,s_id ASC";
							$qryselect=mysql_query($qry);
							//$qry ." ORDER BY c_id, ASC";
							$qry1=mysql_query($qry." ORDER BY c_id,s_id,gender $s_gen ");
						
			  while($row=mysql_fetch_array($qry1))
        		{
					$column = 'A';

					$cid=$row['c_id'];
					
					  
							$sid=$row['s_id'];							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								   if($sid){
									  $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
									 //echo "SELECT * FROM section WHERE s_id=$sid";die;
								  $section=mysql_fetch_array($sectionlist);										  
								  }
								  if($row['gender']=='M'){
									  $gender="Male";
								  }else if($row['gender']=='F'){
									  $gender="Female";
								  }
							    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['firstname']." ".$row['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['phone_number']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']."/".$section['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $gender); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['dob']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['reg']); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($class['c_name']."/".$section['s_name']). ',';
										$content .= stripslashes($gender). ',';
										$content .= stripslashes($row['dob']). ',';
										$content .= stripslashes($row['gender']). ',';
										$content .= stripslashes($row['reg']). ',';
										$content .= "\n";
							$count++;	
							
}
$objPHPExcel->getActiveSheet()->setTitle(" Student Overall List");
$ptypename=str_replace(" ","",$ptypename);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Student Overall list.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
