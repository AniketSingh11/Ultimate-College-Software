<?php
require("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);
session_start();

$check=$_SESSION['email'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_assoc($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_assoc($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year']; 

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($check))

{
	
header("Location:404.php");

}

$gaid=$_GET['aid'];

function findrank($rank, $ssid1){
	 
	 foreach($rank as $key=>$data) {
				$datas=$data;
					$nos=1;
					foreach($data as $key1=>$data1) {
						if($key1==$ssid1){
						if($nos=='1'){										
							$ssid=$key1;
							$Total=$data1;
						}else{
							$studentrank=$data1;										
						}
						$nos++;	
						}
					}
				}
				return $studentrank;
 }
 function array_push_assoc($array, $key, $value){
				$array[$key] = $value;
				return $array;
				}
				
 function rank ($arr) {
  $ret = array();
  $s = array();
  $i = 0;
  foreach ($arr as $x => $v) {
    if (!$s[$v]) { $s[$v] = ++$i; }
    $ret[]= array($x => $v, $s[$v]);
  }
  return $ret;
}

$bid=$_GET['bid'];
$cid=$_GET['cid'];
$sid=$_GET['sid'];
$eid=$_GET['eid'];
$subid=$_GET['subid'];	


$examlist=mysql_query("SELECT e_name FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_assoc($examlist);
							$classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_assoc($classlist);
							$sectionlist=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_assoc($sectionlist);	  
								  
								  if(!$subid){
								$qry7=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
								$subjectlist=mysql_fetch_assoc($qry7);
									$subid=$subjectlist['sub_id'];
								}
								if($subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_assoc($subjectlist);
								   $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1' AND extra_sub=0"); 
								   $slist1=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist1['paper'];
								   $subjectype=$slist1['s_type'];
								  	  }	
								
								/*********************************************Above and No of Passed / Failed List ************************************/
$qry1="SELECT r_id FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear";
				if($subjectype=='1'){
					$qry1 .=" AND mark";
					$qry2 = $qry1." AND result='PASS'";
					$qry3 = $qry1." AND mark >= 90";
					$qry4 = $qry1." AND mark >= 60 AND mark < 90 ";
					$qry5 = $qry1." AND mark >= 35 AND mark < 60 ";
				}else{
					$qry1 .=" AND fa_sa_mark";
					$qry2 = $qry1." AND fa_sa_grade!='E'";
					$qry3 = $qry1." AND fa_sa_mark >= 90";
					$qry4 = $qry1." AND fa_sa_mark >= 60 AND fa_sa_mark < 90 ";
					$qry5 = $qry1." AND fa_sa_mark >= 35 AND fa_sa_mark < 60 ";
				}
				$qrys1=mysql_query($qry1);
				$total_appeared=mysql_num_rows($qrys1);
				$qrys2=mysql_query($qry2);
				$no_passed=mysql_num_rows($qrys2);
				$no_failed=$total_appeared-$no_passed;
				$percent=($no_passed/$total_appeared)*100;
				$qrys3=mysql_query($qry3);
				$above90=mysql_num_rows($qrys3);
				$qrys4=mysql_query($qry4);
				$above60=mysql_num_rows($qrys4);
				$qrys5=mysql_query($qry5);
				$above35=mysql_num_rows($qrys5);
/****************************************************************************************************/
	  
									  /**************************rank ********************************/
								  $a=array();								
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_assoc($qry))
        		{
						$ssid=$student['ss_id'];
						if($nofrow>1){
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear AND sub_id=$subid");
							$pass=0;
							$fail=0;
							$gtotal=0;
							$subount=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist['paper'];
								   $subjectype=$slist['s_type'];
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_assoc($studentlist);
								   
							if($subjectype=='1'){		
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								$result=$row['result'];
																
								if($result=="FAIL"){
									$fail++;
								}else if($result=="PASS"){
									$pass++;
								}
								$subount++;		
								 if($paper=='1'){
                                 $gtotal +=$total; } else {  $gtotal +=$row['mark']; }
							}else{
								$fa1=$row['fa1'];
									$fa2=$row['fa2'];
									$fa3=$row['fa3'];
									$fa_a_mark=$row['fa_a_mark'];
									$fa_b_mark=$row['fa_b_mark'];
									$fa_mark=$row['fa_mark'];
									$fa_grade=$row['fa_grade'];
									$sa_mark=$row['sa_mark'];
									$sa_grade=$row['sa_grade'];
									$fa_sa_mark=$row['fa_sa_mark'];
									$fa_sa_grade=$row['fa_sa_grade'];								
									$total=$fa_sa_mark;	
									if($fa_sa_grade=="E"){
										$fail++;
									}else{
										$pass++;
									}
									$subount++;	
									$gtotal +=$total;
							}	 
					 	  } 
					 //echo $pass."-".$subount."<br>";
					 if($pass==$subount){
                			 if($gtotal){ 
								if($fail){ 
								 }else{
									 $a = array_merge($a, array("'$ssid'"=>"$gtotal"));
									 //print_r($data);								 
									 } 
							}  
					 }
							$count++;
						}
						}
								arsort($a);
								$rank = rank($a);
			
			 					
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
								

								$objPHPExcel->getActiveSheet()->setCellValue("B1"," $school_name ");
								$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(50);cellFont("B1","Cambria");
								//start of printing column names as names of MySQL fields
								
								$column = 'A';
								
								
								/*   for ($i = 1; $i < mysql_num_fields($result); $i++)
								
								{
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
								$column++;
								}
								*/
								if($subjectype=='1'){
								$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Name");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Mark");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "result");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rank");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data
$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear");
$rowCount = 4;
$overalltotal=0;
$count=1;
while($row = mysql_fetch_array($qry))
{
    $column = 'A';
					$ssid=$row['ss_id'];						
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_assoc($studentlist);	
						if($student){	
								$ssid1="'".$ssid."'";
								$rank1=findrank($rank, $ssid1);	
								
								$mark=$row['mark'];
								$mark1=$row['mark1'];
								$total=$mark+$mark1;
			
		
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']); $column++;
								if($paper=='1'){
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $mark."-".$mark1." = ".$total); $column++;
								} else {
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['mark']); $column++;
								}
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['result']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rank1); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										if($paper=='1'){
										$content .= stripslashes($mark."-".$mark1." = ".$total). ',';
										} else {
										$content .= stripslashes($row['mark']). ',';
										}	
										$content .= stripslashes($row['result']). ',';
										$content .= stripslashes($rank1). ',';
										$content .= "\n";
							$count++;	
} }
$rowCount++;
$rowCount++;
$column = 'A';

								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Total no of students appeared');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total_appeared); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Above 90'); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $above90); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Total no of students appeared'). ',';
										$content .= stripslashes($total_appeared). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Above 90'). ',';
										$content .= stripslashes($above90). ',';
										$content .= "\n";
							$count++;
					$column = 'A';		
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No of students passed');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $no_passed); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Above 60'); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $above60); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('No of students passed'). ',';
										$content .= stripslashes($no_passed). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Above 60'). ',';
										$content .= stripslashes($above60). ',';
										$content .= "\n";
							$count++;
					$column = 'A';		
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No of students failed');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $no_failed); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Above 35'); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $above35); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('No of students failed'). ',';
										$content .= stripslashes($no_failed). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Above 35'). ',';
										$content .= stripslashes($above35). ',';
										$content .= "\n";
							$count++;
						$column = 'A';		
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Pass Percentage');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, round($percent,2)." %"); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Pass Percentage'). ',';
										$content .= stripslashes(round($percent,2)." %"). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= "\n";
							$count++;
				}else{
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Name");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "FA (a)");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "FA (b)");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "FA (40)");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "SA (60)");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total (100)");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Grade FA");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);cellFont("J2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Grade SA");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);cellFont("K2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "OverAll");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);cellFont("L2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rank");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data
$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear");
$rowCount = 4;
$count=1;
while($row = mysql_fetch_array($qry))
{
    $column = 'A';
					$ssid=$row['ss_id'];
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_assoc($studentlist);	
						if($student){	
								$ssid1="'".$ssid."'";
								$rank1=findrank($rank, $ssid1);	
			
		
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fa1']."-".$row['fa2']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fa3']."-".$row['fa4']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fa_mark']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['sa_mark']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fa_sa_mark']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fa_grade']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['sa_grade']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['fa_sa_grade']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rank1); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($row['fa1']."-".$row['fa2']). ',';
										$content .= stripslashes($row['fa3']."-".$row['fa4']). ',';
										$content .= stripslashes($row['fa_mark']). ',';
										$content .= stripslashes($row['sa_mark']). ',';
										$content .= stripslashes($row['fa_sa_mark']). ',';
										$content .= stripslashes($row['fa_grade']). ',';
										$content .= stripslashes($row['sa_grade']). ',';
										$content .= stripslashes($row['fa_sa_grade']). ',';
										$content .= stripslashes($rank1). ',';
										$content .= "\n";
							$count++;	
} }
$rowCount++;
$rowCount++;
$column = 'A';

								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Total no of students appeared');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total_appeared); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Above 90'); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $above90); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Total no of students appeared'). ',';
										$content .= stripslashes($total_appeared). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Above 90'). ',';
										$content .= stripslashes($above90). ',';
										$content .= "\n";
							$count++;
					$column = 'A';		
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No of students passed');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $no_passed); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Above 60'); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $above60); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('No of students passed'). ',';
										$content .= stripslashes($no_passed). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Above 60'). ',';
										$content .= stripslashes($above60). ',';
										$content .= "\n";
							$count++;
					$column = 'A';		
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No of students failed');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $no_failed); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Above 35'); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $above35); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('No of students failed'). ',';
										$content .= stripslashes($no_failed). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Above 35'). ',';
										$content .= stripslashes($above35). ',';
										$content .= "\n";
							$count++;
						$column = 'A';		
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Pass Percentage');  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, round($percent,2)." %"); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ''); $column++;
							    
							    $rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes('Pass Percentage'). ',';
										$content .= stripslashes(round($percent,2)." %"). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= "\n";
							$count++;	
				}
				

																															
	/*****************************************sheet 2 *************************************************/
$name=$class['c_name']."-".$section['s_name']."-".$exam['e_name']."-".$slist1['s_name'];
$objPHPExcel->getActiveSheet()->setTitle($name);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
