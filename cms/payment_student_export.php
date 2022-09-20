<?php
require("includes/config.php");


$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Payment-student-list.csv");
header("Pragma: no-cache");
header("Expires: 0");

	 $ptype1=$_GET['ptype'];
	 $acyear=$_GET['acid'];
	 $cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	 $bid=mysql_real_escape_string($_GET['bid']);
	 
	 if(!empty($sid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
	$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  if($ptype1=='All'){
						$ptypename="Fully Paid";
					}else if($ptype1=='Non'){
						$ptypename="Non Pay";
					}else if($ptype1=='Pand'){
						$ptypename="Payment Pending";
					}
	 //die();
$studentlist="SELECT * FROM student WHERE b_id='" . $bid. "' AND ay_id='" . $acyear. "'";
							if(!empty($cid)) { $studentlist .= " AND c_id = '" . $cid. "'"; }
							if(!empty($sid)) { $studentlist .= " AND s_id = '" . $sid. "'"; }
							//$studentlist .= " LIMIT 3,1";
							$studentlist=mysql_query($studentlist);
							$count=1;
$content = '';
$title = '';
			  while($student=mysql_fetch_array($studentlist))
        		{
								  $ssid=$student['ss_id'];
								  //echo "<br>";
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  if(!empty($sid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  
							$discountlist=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdisid1"); 
								  $discount=mysql_fetch_array($discountlist);
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }			
							
							
							$fdisid2=$fdisid1;
				$fcount=1;
				$fullpay=0;
				$pendpay=0;
				$nonpay=0;
				 $qry=mysql_query("SELECT * FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21");
						  while($row=mysql_fetch_array($qry))
							{ 
							$total1=0;
							$frid=$row['fr_id'];
							$fgid2=$row['fg_id'];
							$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$fgid2");
											  $fgroup=mysql_fetch_array($fgrouplist);	
											  $grouptype=$fgroup['ftype'];	
									if($grouptype!="other"){		  
				$qry3=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid2");													
									  while($row3=mysql_fetch_array($qry3))
										{
											$fgdid=$row3['fgd_id'];
											$type=$row3['type'];
											$ftype="";	
											//echo $row3['name']."-";
											if($s_type=="New"){
									  $frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear"); 
								  }else{
									  $frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear AND ftype='0'"); 
								  }											
								
								$pending=0;	
								$pending=0;	
								$ptype=1;
								$paid=0;	
					$qry5=mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND bid=$bid AND ay_id=$acyear");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffi_id=$row5['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND type='terms'");
							  $row6=mysql_fetch_array($qry6);
							  $paid +=$row6['amount'];
							  if($row6['payment']){
								  $pending = $row6['pamount'];
							  } else if($row6['payment']=="0"){
								  $pending =0;
								  $ptype=0;
							  }
					}
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
								  $total1 +=$frvalue['dis_value'];								  
								  }
								  } 
								  if($pending && $ptype=="1"){
									 $pendpay +=1;
									  //$paid=$total1-$pending;
								  }else if(!$pending && $ptype=="0"){
									 $fullpay +=1;
								  }else{
									 $nonpay +=1;
								  }
								  //echo $paid;
								  //die();
								   $cartid=$frid.$fcount;
								  //echo $fgroup['fg_name']."-";
								  //echo $total1."<br>";
								  //if($pending1){
								  	//		echo $ssid."-".$pending1."<br>";
								  $fcount++;
								  //}
									}else{
										
										$qry3=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid2");													
									  while($row3=mysql_fetch_array($qry3))
										{
											$fgdid=$row3['fgd_id'];
											$type=$row3['type'];
											$ftype="";		
											//echo $row3['name']."-";										
				$frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear AND ftype='0'"); 
								$pending=0;	
								$ptype=1;
								$paid=0;		
					$qry5=mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND bid=$bid AND ay_id=$acyear");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffi_id=$row5['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND type='other'");
							  $row6=mysql_fetch_array($qry6);
							  $paid +=$row6['amount'];
							  if($row6['payment']){
								  $pending = $row6['pamount'];
							  } else if($row6['payment']=="0"){
								  $pending = 0;
								  $ptype=0;
							  }
					}
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
									  $total1=$frvalue['dis_value'];
									  if($pending && $ptype=="1"){
									 	 $pendpay +=1;
								  }else if(!$pending && $ptype=="0"){
									  $fullpay +=1;
								  }else{
									  $nonpay +=1;
								  }
								  //echo $pending1;
								    $cartid=$frid.$fcount;
								   //echo $row3['name']."-";
								  //echo $frvalue['dis_value']."<br>";
								  $fcount++;							  
								  }
								  }	
									}
								  }
							/* echo  $fullpay;
							  echo "<br>";
							  echo  $pendpay;
							  echo "<br>";
							  echo  $nonpay;
							  echo "<br>";
							  echo "<br>"; 
							 
							if($fullpay!=0 && !$pendpay && !$nonpay && $ptype1=="All"){ 
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($board['b_name']). ',';
										$content .= stripslashes($class['c_name']."/".$section['s_name']). ',';
										$content .= stripslashes($discount['fdis_name']). ',';
										$content .= stripslashes($student['stype']). ',';
										$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;	
							}
							if((($pendpay && $fullpay) || ($pendpay && !$nonpay) || ($fullpay && $nonpay)) && $ptype1=='Pand'){
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($board['b_name']). ',';
										$content .= stripslashes($class['c_name']."/".$section['s_name']). ',';
										$content .= stripslashes($discount['fdis_name']). ',';
										$content .= stripslashes($student['stype']). ',';
										$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;	
							}if($nonpay!=0 && !$pendpay && !$fullpay && $ptype1=='Non'){
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($board['b_name']). ',';
										$content .= stripslashes($class['c_name']."/".$section['s_name']). ',';
										$content .= stripslashes($discount['fdis_name']). ',';
										$content .= stripslashes($student['stype']). ',';
										$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;
							}
}
$title .= "S.No,Admin No,Student Name,Parent's name,Phone no,Board,Class-Section,Student Category,Student type,fee Paid type"."\n";
echo $title;
echo $content;

*/

 $ptype1=$_GET['ptype'];
	 $acyear=$_GET['acid'];
	 $cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	 $bid=mysql_real_escape_string($_GET['bid']);
	 
	 
	 $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
	 $section=mysql_fetch_array($sectionlist);
	 $class_name=$section["c_name"];
	 
	 $sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
	 $section=mysql_fetch_array($sectionlist);
	 $section_name=$section["s_name"];
	 	
	 if(empty($cid)){  $class_name="All"; }
	 if(empty($sid)){  $section_name="All"; }
	 
	
if(!empty($sid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
	$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  if($ptype1=='All'){
						$ptypename="Fully Paid";
					}else if($ptype1=='Non'){
						$ptypename="Non Pay";
					}else if($ptype1=='Pand'){
						$ptypename="Payment Pending";
					}
    
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "fee Paid type");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;

while($student = mysql_fetch_array($result))

{
    $column = 'A';

  $ssid=$student['ss_id'];
								  //echo "<br>";
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  if(!empty($sid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  
							$discountlist=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdisid1"); 
								  $discount=mysql_fetch_array($discountlist);
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }			
							
							
							$fdisid2=$fdisid1;
				$fcount=1;
				$fullpay=0;
				$pendpay=0;
				$nonpay=0;
				 $qry=mysql_query("SELECT * FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21");
						  while($row=mysql_fetch_array($qry))
							{ 
							$total1=0;
							$frid=$row['fr_id'];
							$fgid2=$row['fg_id'];
							$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$fgid2");
											  $fgroup=mysql_fetch_array($fgrouplist);	
											  $grouptype=$fgroup['ftype'];	
									if($grouptype!="other"){		  
				$qry3=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid2");													
									  while($row3=mysql_fetch_array($qry3))
										{
											$fgdid=$row3['fgd_id'];
											$type=$row3['type'];
											$ftype="";	
											//echo $row3['name']."-";
											if($s_type=="New"){
									  $frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear"); 
								  }else{
									  $frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear AND ftype='0'"); 
								  }											
								
								$pending=0;	
								$pending=0;	
								$ptype=1;
								$paid=0;	
					$qry5=mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND bid=$bid AND ay_id=$acyear and c_status!='1'");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffi_id=$row5['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND type='terms'");
							  $row6=mysql_fetch_array($qry6);
							  $paid +=$row6['amount'];
							  if($row6['payment']){
								  $pending = $row6['pamount'];
							  } else if($row6['payment']=="0"){
								  $pending =0;
								  $ptype=0;
							  }
					}
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
								  $total1 +=$frvalue['dis_value'];								  
								  }
								  } 
								  if($pending && $ptype=="1"){
									 $pendpay +=1;
									  //$paid=$total1-$pending;
								  }else if(!$pending && $ptype=="0"){
									 $fullpay +=1;
								  }else{
									 $nonpay +=1;
								  }
								  //echo $paid;
								  //die();
								   $cartid=$frid.$fcount;
								  //echo $fgroup['fg_name']."-";
								  //echo $total1."<br>";
								  //if($pending1){
								  	//		echo $ssid."-".$pending1."<br>";
								  $fcount++;
								  //}
									}else{
										
										$qry3=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid2");													
									  while($row3=mysql_fetch_array($qry3))
										{
											$fgdid=$row3['fgd_id'];
											$type=$row3['type'];
											$ftype="";		
											//echo $row3['name']."-";										
				$frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear AND ftype='0'"); 
								$pending=0;	
								$ptype=1;
								$paid=0;		
					$qry5=mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND bid=$bid AND ay_id=$acyear and c_status!='1'");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffi_id=$row5['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND type='other'");
							  $row6=mysql_fetch_array($qry6);
							  $paid +=$row6['amount'];
							  if($row6['payment']){
								  $pending = $row6['pamount'];
							  } else if($row6['payment']=="0"){
								  $pending = 0;
								  $ptype=0;
							  }
					}
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
									  $total1=$frvalue['dis_value'];
									  if($pending && $ptype=="1"){
									 	 $pendpay +=1;
								  }else if(!$pending && $ptype=="0"){
									  $fullpay +=1;
								  }else{
									  $nonpay +=1;
								  }
								  //echo $pending1;
								    $cartid=$frid.$fcount;
								   //echo $row3['name']."-";
								  //echo $frvalue['dis_value']."<br>";
								  $fcount++;							  
								  }
								  }	
									}
								  }
							/* echo  $fullpay;
							  echo "<br>";
							  echo  $pendpay;
							  echo "<br>";
							  echo  $nonpay;
							  echo "<br>";
							  echo "<br>";*/
							 
							if($fullpay!=0 && !$pendpay && !$nonpay && $ptype1=="All"){ 
							    
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board['b_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']."/".$section['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $discount['fdis_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ptypename); $column++;
							    
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
										$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;	
							}
							if((($pendpay && $fullpay) || ($pendpay && !$nonpay) || ($fullpay && $nonpay)) && $ptype1=='Pand'){
							    
							    
							  
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board['b_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']."/".$section['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $discount['fdis_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ptypename); $column++;
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
										$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;	   
							}if($nonpay!=0 && !$pendpay && !$fullpay && $ptype1=='Non'){
							    

							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board['b_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class['c_name']."/".$section['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $discount['fdis_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ptypename); $column++;
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
										$content .= stripslashes($ptypename). ',';
										$content .= "\n";
							$count++;    
							}
     


}
$objPHPExcel->getActiveSheet()->setTitle("Fees Paid Report");



$ptypename=str_replace(" ","",$ptypename);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Fees_Paid_report-list($ptypename$class_name-$section_name).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
