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

/***********************single Mark Rank ******************************/
/*function getGrades($grades)
{
    $occurrences = array_count_values($grades);
    krsort($occurrences);

    $position = 1;
    foreach ($occurrences as $score => $count) {
        $occurrences[$score] = $position;
        $position += $count;

    }

    return $occurrences;
}*/
function getGrades($marks)
{
	rsort($marks);
$narr = array_count_values($marks);
$y=1;
foreach($narr as $k=>$v)
{
$i=1;
while($i<=$v)
{
$narr[$k] = $y;
$i++;
}
$y++;
}
return $narr;
}


function getmarks($cid,$sid,$acyear,$eid,$slid,$subid1){
							
							 $myarray = array();
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist['paper'];
								   $subjectype=$slist['s_type'];
								    $studentlist=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   while($row=mysql_fetch_assoc($studentlist)){
								   
							if($subjectype=='1'){		
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								 array_push($myarray,$total);	
							}else{
								$fa1=$row['fa1'];
									$fa_sa_mark=$row['fa_sa_mark'];								
									$total=$fa_sa_mark;	
									array_push($myarray,$total);	
							} }
						  return $myarray;
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
									  
									  /**************************rank ********************************/
								  $a=array();								
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear  ORDER BY gender DESC, firstname ASC");
							$count=1;
			  while($student=mysql_fetch_assoc($qry))
        		{
						$ssid=$student['ss_id'];
						if($nofrow>1){
							$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
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
									 //print_r($a);								 
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
								
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Name");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;

$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
							$count=1;
							  while($row1=mysql_fetch_assoc($qry1))
								{
									   $slid=$row1['sl_id'];
									   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
									   $slist=mysql_fetch_assoc($subjectlist1);
									   $subjectype=$slist['s_type'];
$objPHPExcel->getActiveSheet()->getColumnDimension($column.$rowCount)->setWidth(5);cellFont($column.$rowCount,"Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $slist['s_name']);$column++;$column++;$column++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension($column.$rowCount)->setWidth(10);cellFont($column.$rowCount,"Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension($column.$rowCount)->setWidth(10);cellFont($column.$rowCount,"Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "result");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension($column.$rowCount)->setWidth(10);cellFont($column.$rowCount,"Cambria");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rank");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());

//end of adding column names
//start while loop to get data
$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear ORDER BY gender DESC,firstname ASC");
$rowCount = 4;					$count=1;
while($student = mysql_fetch_assoc($qry))
{
    
					$ssid=$student['ss_id'];
						$ssid1="'".$ssid."'";
						$rank1=findrank($rank, $ssid1);
						if($nofrow>1){
							$column = 'A';
							if($subjectype!='1'){	
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;	
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
							$qry1=mysql_query("SELECT sl_id FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
							  while($row1=mysql_fetch_assoc($qry1))
								{
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Mark');cellFont($column.$rowCount,"Cambria");  $column++;
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'First Mark');cellFont($column.$rowCount,"Cambria");  $column++;	
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Placement');cellFont($column.$rowCount,"Cambria");  $column++;
								}
							$rowCount++;
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$content .= stripslashes(''). ',';
										$qry1=mysql_query("SELECT sl_id FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
							  while($row1=mysql_fetch_assoc($qry1))
								{
										$content .= stripslashes('Mark'). ',';
										$content .= stripslashes('First Mark'). ',';
										$content .= stripslashes('Placement'). ',';
								}
										$content .= "\n";
						$nofrow=0;} }
						
					$column = 'A';	
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']); $column++;
								$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
							$pass=0;
							$fail=0;
							$gtotal=0;
							  while($row1=mysql_fetch_assoc($qry1))
								{
									$slid=$row1['sl_id'];
									$subid1=$row1['sub_id'];
									
								  //echo $myarray1=getmarks($cid,$sid,$acyear,$eid,$slid,$subid1);
								   $myarray = array();
									$slid=$row1['sl_id'];
									$subid1=$row1['sub_id'];
												   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
												   $slist=mysql_fetch_assoc($subjectlist1);
												   $paper=$slist['paper'];
												   $subjectype=$slist['s_type'];
													$studentlist=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
												   while($row=mysql_fetch_assoc($studentlist)){
												   
											if($subjectype=='1'){		
												$mark=$row['mark'];
												$mark1=$row['mark1'];								
												$total=$mark+$mark1;								
												 array_push($myarray,$total);	
											}else{
												$fa1=$row['fa1'];
													$fa_sa_mark=$row['fa_sa_mark'];								
													$total=$fa_sa_mark;	
													array_push($myarray,$total);	
											} }
								  //print_r($myarray);
								    $subjectrank=getGrades($myarray);
									//print_r($subjectrank);
									//echo $subjectrank['80'];
								
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist['paper'];
								   $subjectype=$slist['s_type'];
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_assoc($studentlist);	
								   
								if($subjectype=='1'){	
								$studentlis2t=mysql_query("SELECT CONVERT(SUBSTRING_INDEX(mark,'-',-1),UNSIGNED INTEGER) AS mark FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear ORDER BY mark DESC"); 
								   $topmarklist=mysql_fetch_assoc($studentlis2t);
								   $topmark=$topmarklist['mark'];				
									$mark=$row['mark'];
									$mark1=$row['mark1'];								
									$total=$mark+$mark1;								
									$result=$row['result'];
																	
									if($result=="FAIL"){
										$fail++;
									}	
								 if($paper=='1'){
										if($total){
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $mark."-".$mark1." = ".$total); $column++;
										}$gtotal +=$total;
									}else {
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['mark']); $column++;
									$gtotal +=$row['mark']; 
									}		
								}else{
									$studentlis2t=mysql_query("SELECT CONVERT(SUBSTRING_INDEX(fa_sa_mark,'-',-1),UNSIGNED INTEGER) AS fa_sa_mark FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear ORDER BY fa_sa_mark DESC"); 
								   $topmarklist=mysql_fetch_assoc($studentlis2t);
								   $topmark=$topmarklist['fa_sa_mark'];
								   
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
									}
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fa_sa_mark); $column++;	
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $topmark); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $subjectrank[$fa_sa_mark]); $column++;
								$gtotal +=$total; }
								}
								
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $gtotal); $column++;
								
								if($gtotal){ 
								if($fail){ $porf="FAIL"; }else{ $porf="PASS"; } 
								}
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $porf); $column++;
								
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rank1); $column++;
							    
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
							$pass=0;
							$fail=0;
							$gtotal=0;
							  while($row1=mysql_fetch_assoc($qry1))
								{
									$slid=$row1['sl_id'];
									$subid1=$row1['sub_id'];
									
								  //echo $myarray1=getmarks($cid,$sid,$acyear,$eid,$slid,$subid1);
								   $myarray = array();
									$slid=$row1['sl_id'];
									$subid1=$row1['sub_id'];
												   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
												   $slist=mysql_fetch_assoc($subjectlist1);
												   $paper=$slist['paper'];
												   $subjectype=$slist['s_type'];
													$studentlist=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
												   while($row=mysql_fetch_assoc($studentlist)){
												   
											if($subjectype=='1'){		
												$mark=$row['mark'];
												$mark1=$row['mark1'];								
												$total=$mark+$mark1;								
												 array_push($myarray,$total);	
											}else{
												$fa1=$row['fa1'];
													$fa_sa_mark=$row['fa_sa_mark'];								
													$total=$fa_sa_mark;	
													array_push($myarray,$total);	
											} }
								  //print_r($myarray);
								    $subjectrank=getGrades($myarray);
									//print_r($subjectrank);
									//echo $subjectrank['80'];
								
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist['paper'];
								   $subjectype=$slist['s_type'];
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_assoc($studentlist);	
								   
								if($subjectype=='1'){	
								$studentlis2t=mysql_query("SELECT mark FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear ORDER BY mark DESC"); 
								   $topmarklist=mysql_fetch_assoc($studentlis2t);
								   $topmark=$topmarklist['mark'];				
									$mark=$row['mark'];
									$mark1=$row['mark1'];								
									$total=$mark+$mark1;								
									$result=$row['result'];
																	
									if($result=="FAIL"){
										$fail++;
									}	
								 if($paper=='1'){
										if($total){
										$content .= stripslashes($mark."-".$mark1." = ".$total). ',';
										}$gtotal +=$total;
									}else {
										$content .= stripslashes($row['mark']). ',';
									}		
								}else{
									$studentlis2t=mysql_query("SELECT fa_sa_mark FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear ORDER BY fa_sa_mark DESC"); 
								   $topmarklist=mysql_fetch_assoc($studentlis2t);
								   $topmark=$topmarklist['fa_sa_mark'];
								   
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
									}	
										$content .= stripslashes($fa_sa_mark). ',';
										$content .= stripslashes($topmark). ',';
										$content .= stripslashes($subjectrank[$fa_sa_mark]). ',';
										$gtotal +=$total; }
								}
										$content .= stripslashes($gtotal). ',';
										if($gtotal){ 
								if($fail){ $porf="FAIL"; }else{ $porf="PASS"; } 
								}
										$content .= stripslashes($porf). ',';
										$content .= stripslashes($rank1). ',';
										$content .= "\n";
							$count++;

						}  
$rowCount++;
																															
	/*****************************************sheet 2 *************************************************/
$name=$class['c_name']."-".$section['s_name']."-".$exam['e_name']."-Mark";
$objPHPExcel->getActiveSheet()->setTitle($name);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
