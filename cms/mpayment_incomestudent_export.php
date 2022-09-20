<?php
require("includes/config.php");
/*header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Payment-student-list.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
								      $tquery2=mysql_query("select * from mfinvoice  where ss_id='$ssid' and c_id='$c' and s_id='$s' and bid='$b' and  ay_id='$acyear' AND c_status!='1' AND i_status='0'");
								      while($trow2=mysql_fetch_array($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								          array_push($fi,$fi_id);
								      }
								      	
								      $fis=implode(",",$fi);
								  
								  
								      $ptotal=0;
								      $tquery1=mysql_query("select * from fsalessumarry  where  fi_id IN ($fis) and fr_id!='0'  ");
								      $d=0;
								      while($trow1=mysql_fetch_array($tquery1)){
								          $d=$d+1;
								          $ptotal=$trow1['amount']+$ptotal;
								           
								      }
								      //  echo $d."-".$ptotal."<br>";
								      return $ptotal;
								      	
								  } 

$bid=$_GET['bid'];
$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid");
$board=mysql_fetch_array($boardlist);

$ptype1=$_GET['perrange'];
$cid=$_GET['cid'];
$sid=$_GET['sid'];

$sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
$section=mysql_fetch_array($sectionlist);
$class_name=$section["c_name"];

$sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
$section=mysql_fetch_array($sectionlist);
$section_name=$section["s_name"];
	
if(empty($cid)){  $class_name="All"; }
if(empty($sid)){  $section_name="All";}



$perrange1=$_GET["perrange1"];
$perrange2=$_GET["perrange2"];
$acyear=$_GET["acid"];

	if($ptype1=='All'){
						$ptypename="Fully Paid";
					}else if($ptype1=='Non'){
						$ptypename="Non Pay";
					}else if($ptype1=='Pand'){
						$ptypename="Payment Pending";
					}
					
					
					/*function total_amount($b,$c,$fdis,$acyear,$ftype)
					{
					    $fr=array();
					    $tquery=mysql_query("select * from mfrate where ay_id='$acyear' and   b_id='$b' and  c_id='$c'");
					    while($trow=mysql_fetch_array($tquery)){
					        $fr_id=$trow["fr_id"];
					        array_push($fr,$fr_id);
					    }
					    $frs=implode(",",$fr);
					    $tot=0;
					    $tquery=mysql_query("select * from mfrate_value where  fr_id IN ($frs) and fdis_id='$fdis'  and ftype in ($ftype) ");
					    while($trow=mysql_fetch_array($tquery)){
					         
					        $tot +=$trow['dis_value'];
					    }
					
					    return $tot;
					    	
					}
						
					function paid_amount($b,$c,$s,$acyear,$ssid)
					{
					    $fi=array();
					    $tquery2=mysql_query("select * from mfinvoice  where ss_id='$ssid' and c_id='$c' and s_id='$s' and bid='$b' and  ay_id='$acyear' and c_status!='1' AND i_status='0'");
					    while($trow2=mysql_fetch_array($tquery2)){
					        $fi_id=$trow2["fi_id"];
					
					        array_push($fi,$fi_id);
					    }
					    	
					    $fis=implode(",",$fi);
					
					
					    $ptotal=0;
					    $tquery1=mysql_query("select * from mfsalessumarry  where  fi_id IN ($fis) and fr_id!='0'  ");
					    $d=0;
					    while($trow1=mysql_fetch_array($tquery1)){
					        $d=$d+1;
					        $ptotal=$trow1['amount']+$ptotal;
					         
					    }
					    //  echo $d."-".$ptotal."<br>";
					    return $ptotal;
					    	
					}*/
					
					$studentlist="SELECT * FROM student WHERE b_id='" . $bid. "' AND ay_id='" . $acyear. "'";
					if(!empty($cid)) { $studentlist .= " AND c_id = '" . $cid. "'"; }
					if(!empty($sid)) { $studentlist .= " AND s_id = '" . $sid. "'"; }
					

					$result = mysql_query($studentlist) or die(mysql_error());
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
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Board");$column++;
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Category");$column++;
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student type");$column++;
					
				
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Percentage Range");$column++;
					
					$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
					
					
					//end of adding column names
					//start while loop to get data
					
					$rowCount = 3;
					
					while($student = mysql_fetch_array($result))
					
					{
					    $column = 'A';
				
								      $nonpay=0;
								$pendpay=0;
								$fullpay=0;
							  
								  $ssid=$student['ss_id'];
								  
								  $ss_id=$ssid;
								$student=mysql_fetch_array(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
								$ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
								  
								  
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid1'"); 
								  $discount1=mysql_fetch_array($qry4);
								  
								  $mpdid=$student['mpd_id'];
								  $discount=0;
								  if($mpdid){
									  $paytypelist=mysql_query("SELECT * FROM mpaydiscount WHERE mpd_id=$mpdid"); 
								  	  $mpaydiscount=mysql_fetch_array($paytypelist);
									  $dismonth=$mpaydiscount['value'];
									  $disamount=$mpaydiscount['discount'];	
								  }
								   if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD") || ($class1['c_name']=="XI") || ($class1['c_name']=="XII")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }	
								  
								  $tot=0;
								$totalamount=0;
								      $tquery=mysql_query("SELECT * FROM mfrate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 ORDER BY fgd_id");
								      while($row2=mysql_fetch_array($tquery)){
										  
										   
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];
									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_array($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 //$frateto2=$ftypevalue;
					 if($ftypevalue==1 && $mpdid){
					 	 $frateto2=intval($dismonth);
					 }else{
						 $frateto2=$ftypevalue;
					 }
						 
					 $frateamount2=$class['dis_value'];
					 if($ftypevalue==1){
					 $totalamount +=$frateamount2*$tomonth;
					 }else{
					 $totalamount +=$frateamount2;
					 }
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
								
						if($frateto12>$tomonth){
							$frateto12=$tomonth;							
						}
						if($ftypevalue==1 && $mpdid){
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
							 }
							 $rmonth=$tomonth-$frateto12;
													
					}else {
							$frateto12=$frateto2;
							
							if($frateto12>$tomonth){
								$frateto12=$tomonth;							
							}
							
							if($ftypevalue==1 && $mpdid){
								 $frateamount12=$frateamount2*$frateto12;
							 }else{
								 $frateamount12=$frateamount2;
							 }	
							 $rmonth=$tomonth-$frateto12;					
						}
						
						if($frateto12==$tomonth && ($ftypevalue==1 && $mpdid)){
							$discount=1;
						}
						
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						if($frateamount12>0){
							$tot +=$frateamount12;
						 }
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_array($fgrouplist);
														$ftypevalue=12;
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
						//$frateto12=$fratefrom2+$frateto2;
						if($frateto12>12){
							$frateto12=12;
							
						}
						
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						  $frateamount12;
						if($frateamount12>0){
							$tot +=$frateamount12;
							 $totalamount +=$frateamount2;
						 }
				}/************************ Other Fees end*********************************/
									}
								  
								  $qry1=mysql_query("SELECT * FROM mfinvoice WHERE bid=$bid AND ss_id='$ss_id' AND ay_id=$acyear");
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['fi_total'];
					$total +=$tamount;		

					$fdis=$student['fdis_id'];
					$stype=$student['stype'];
					
					if($stype=="Old")
					{
					    $ftype="0";
					}else{
					    $ftype="0,1";
					}
					$paid=paid_amount($bid,$cid,$sid,$acyear,$ss_id);
				}
				
				
							/*echo  "Total Fees :".$totalamount;
							  echo "<br>";
							  echo  "Total Paid   :".$total;
							  echo "<br>";
							  echo  "Total Pending :".$tot;
							   echo "<br>";*/
							   
							   
							      $total1=$totalamount;
							      $paid=$totalamount-$tot;
							     
							      $percentage_1=$total1*($perrange1/100);
							      
							      $percentage_2=$total1*($perrange2/100);
								  
								  if(!empty($cid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  
							$discountlist=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdisid1"); 
								  $discount=mysql_fetch_array($discountlist);
								  
								      	
								      if($paid >= $percentage_1 && $paid <= $percentage_2 && $total!=0){
								          //if($total!=0 ){
								     
								          	
							/* echo  $fullpay;
							  echo "<br>";
							  echo  $pendpay;
							  echo "<br>";
							  echo  $nonpay;
							  echo "<br>";
							  echo "<br>";*/
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board['b_name']); $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']."/".$section['s_name']); $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $discount['fdis_name']); $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
								          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $perrange1." % - ".$perrange2." %"); $column++;
								          $rowCount++;
						
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($board['b_name']). ',';
										$content .= stripslashes($class['c_name']."/".$section['s_name']). ',';
										$content .= stripslashes($discount['fdis_name']). ',';
										$content .= stripslashes($student['stype']). ',';
										//$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;	
								      }
}

$objPHPExcel->getActiveSheet()->setTitle("Percentage-FeesPaid-Report");





// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Percentage_Fees_Paid_report-list(percentage($perrange1-$perrange2)($class_name-$section_name)).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');


$title .= "S.No,Admin No,Student Name,Parent's name,Phone no,Board,Class-Section,Student Category,Student type"."\n";
//echo $title;
//echo $content;
?>
