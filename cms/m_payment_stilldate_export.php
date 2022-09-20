<?php

require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 	 

	 $acyear=$_GET['acid'];
	 
	 $ayear=mysql_query("SELECT * FROM year WHERE ay_id='$acyear'");
$ay=mysql_fetch_array($ayear);
$syear=$ay['s_year'];
$eyear=$ay['e_year'];

	  
	  $to=$_GET['to'];
					$cid=$_GET['cid'];
					$sid=$_GET['sid'];
					$bid=$_GET['bid'];
					$filt=$_GET['filt'];
					if(!$filt){
						$filt="all";
					}
					
					$ftypelist1=mysql_query("SELECT * FROM ftype WHERE fty_value=1"); 
																  $ftype1=mysql_fetch_array($ftypelist1);
														$ftyid1=$ftype1['fty_id'];	
									$ftypelist11=mysql_query("SELECT * FROM mfgroup WHERE fty_id=$ftyid1"); 
																  $ftype11=mysql_fetch_array($ftypelist11);
														$fgid1=$ftype11['fg_id'];	
					
	     $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
	     $section=mysql_fetch_array($sectionlist);
	     $class_name=$section["c_name"];
	  
	     $sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
	     $section=mysql_fetch_array($sectionlist);
	     $section_name=$section["s_name"];
	     
	    if(empty($cid)){  $class_name="All"; }
	    if(empty($sid)){  $section_name="All"; }
	   
	 
	
if(!empty($sid)) {$classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
	$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  
    $studentlist="SELECT ss_id,gender,c_id,s_id,stype,mlate_join,fdis_id,sp_id,r_id,busfeestype,mlate_join,blate_join,mpd_id,admission_number,firstname,lastname,fathersname,stype,phone_number FROM student WHERE b_id='" . $bid. "' AND ay_id='" . $acyear. "'";
    if(!empty($cid)) { $studentlist .= " AND c_id = '" . $cid. "'"; }
    if(!empty($sid)) { $studentlist .= " AND s_id = '" . $sid. "'"; }
	//$studentlist .=" AND ss_id='253'";
	$studentlist .=" ORDER BY gender DESC, firstname ASC";

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

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Category");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Phone No");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);cellFont("J2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Tution Fees");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);cellFont("K2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "School Fees");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);cellFont("L2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Fees");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);cellFont("M2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Last Year Pending");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);cellFont("M2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total");$column++;

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;
$grandtotal=0;
while($student = mysql_fetch_array($result))

{
	    $column = 'A';
   $ssid=$student['ss_id'];
								  
								  $ss_id=$ssid;
								//$student=mysql_fetch_assoc(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
								$ss_gender=$student['gender'];
								$rollno=$student['admission_number'];
								  $cid1=$student['c_id'];
								  $sid1=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  $spid=$student['sp_id'];
								  $busstudent=$student['r_id'];
								  $busfeestype=$student['busfeestype'];
								  $mlate_join=$student['mlate_join'];
								  $blate_join=$student['blate_join'];
								  
								  $classlist1=mysql_query("SELECT c_name FROM class WHERE c_id=$cid1"); 
								  $class1=mysql_fetch_assoc($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT s_name FROM section WHERE s_id=$sid1"); 
								  $section1=mysql_fetch_assoc($sectionlist1);	
								  
								  
								  
								  
								  /*$qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid1'"); 
								  $discount1=mysql_fetch_assoc($qry4);*/
								  
								  $mpdid=$student['mpd_id'];
								  $discount=0;
								  if($mpdid){
									  $paytypelist=mysql_query("SELECT value,discount FROM mpaydiscount WHERE mpd_id=$mpdid"); 
								  	  $mpaydiscount=mysql_fetch_assoc($paytypelist);
									  $dismonth=$mpaydiscount['value'];
									  $disamount=$mpaydiscount['discount'];	
								  }
								   if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD") || ($class1['c_name']=="XI") || ($class1['c_name']=="XII")){
									 $sid21 = $sid1;
								  }else {
									  $sid21 = "0";
								  }								   
								    /*******************************Lastyear Pending *************************************/
								  $layear=mysql_query("SELECT * FROM year WHERE e_year=$syear");
				$lay=mysql_fetch_assoc($layear);  
				$lacyear=$lay['ay_id'];
				
				/****************************************** Pending Amount Start **********************************/
					$totalpending=0;
					if($lacyear){
									$lstudentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$lacyear"); 
								  $lstudent=mysql_fetch_assoc($lstudentlist);
								  $lssid=$lstudent['ss_id'];
								  $lcid=$lstudent['c_id'];
								  	$lsid=$lstudent['s_id'];
									$ls_type=$lstudent['stype'];
									$lfdisid1=$lstudent['fdis_id'];
									$mpdid=$lstudent['mpd_id'];
									$lrid=$lstudent['r_id'];
								  $lspid=$lstudent['sp_id'];
								  $lbusfeestype=$lstudent['busfeestype'];
								  $lmlate_join=$lstudent['mlate_join'];
								  $lblate_join=$lstudent['blate_join'];
									
									$lclasslist1=mysql_query("SELECT c_name FROM class WHERE c_id=$lcid"); 
								    $lclass1=mysql_fetch_assoc($lclasslist1);
									
									if(($lclass1['c_name']=="XI STD") || ($lclass1['c_name']=="XII STD") || ($lclass1['c_name']=="XI") || ($lclass1['c_name']=="XII")){
									 $lsid21 = $lsid;
								  }else {
									  $lsid21 = "0";
								  }
						
								  
				$sql1=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$lcid AND b_id=$bid AND ay_id=$lacyear AND rate='$ls_type' AND s_id=$lsid21 ORDER BY fgd_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];
									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
									
							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
									$ftype=mysql_fetch_assoc($ftypelist);
									$ftypevalue=$ftype['fty_value'];	  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
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
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto,amount FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
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
								
						if($frateto12>$tomonth){
							$frateto12=$tomonth;							
						}
						if($ftypevalue==1 && $mpdid){
							 //echo "((".$frateto12."-(".$fratefrom2."-1))/".$frateto2.")*".$frateamount2."<br>";
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 //echo "((".$frateto12."-(".$fratefrom2."-1))/".$frateto2.")*".$frateamount2."<br>";
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
						if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						if($frateamount12>0){
							$totalpending +=$frateamount12;
						 }
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									$fgrouplist=mysql_query("SELECT dis_value FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
														$ftypevalue=12;
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
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
							$totalpending +=$frateamount12;
						 }
				}/************************ Other Fees end*********************************/
			}
				/****************************************** Pending Amount End **********************************/
					}
				//echo $totalpending;
				//die();
				$ptypepay=0;
				$qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_assoc($qry3))
							{
							$fiid1=$row3['fi_id'];
							$fsummaylist=mysql_query("SELECT ftype FROM mfsalessumarry where fi_id=$fiid1 AND fty_id='2'"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 if($fsummay['ftype']=="pending"){
									 $ptypepay=1;
									 }
								 }
							}
							if($ptypepay==1){
								$totalpending=0;
								//echo $totalpending."<br>";	
							}
						
								  /*******************************Lastyeasr Pending End**********************************/	
								  
								  /*******************************Lastyear Bus Pending Fees Strat ********************************/
								 $btotalpending=0;
								  $sql1=mysql_query("SELECT bf_id,ftyid,end,fees,sp_fees,sp_fees_onetime,one_time FROM trbusfees WHERE sp_id=$lspid AND ay_id=$lacyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 				
									$fendmonth=$row2['end'];
					 				if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
					 $fesstypearray=array("fees","sp_fees","sp_fees_onetime","one_time"); 
					 
					 $tablefield=$fesstypearray[$lbusfeestype];
					 $frateamount2=$row2[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($ftypevalue==1){
								$f_to12=$lblate_join;	
							}else{
								$f_to12="";	
							}
							
							//echo $f_to12;
							
										if(!empty($bfid)) { 
					 $qry3="SELECT fto FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_assoc($qry3))
							{
								if($row3['fto']>$f_to12){
								$f_to12=$row3['fto'];
								}
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
						}
						//echo '(('.$frateto12.'-('.$fratefrom2.'-1))/'.$frateto2.')*'.$frateamount2;
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 $frateamount2;
						if($frateamount12>0){
							$onemonth=$frateamount12/$ftypevalue;
							$totalmonth=$tomonth-$fratefrom2+1;
							$btotalpending +=($onemonth*$totalmonth);
						 }			
									}
									
						/****************************************** Pending Amount End **********************************/
							$bptypepay=0;
				$qry3="SELECT pending FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_assoc($qry3))
							{
							$pending=$row3['pending'];
									 if($pending){
									 $bptypepay=1;									 
								 }
							}
				if($btotalpending>0 && $bptypepay==0){
						$totalpending +=$btotalpending;		
						}
						/*************************************************lastyear Bus Pending Fees End *************************************/
								  /*****************************************Yearly Fees Start****************************/
								  $tot=0;
								$totalamount=0;
								$totaolpaid=0;
								      $tquery=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$cid1 AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 AND fg_id!=$fgid1 ORDER BY fgd_id");
								      while($row2=mysql_fetch_assoc($tquery)){									  
										   
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];												
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
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
					 $yf_to12=0;
					 					if(!empty($frid)) { 
					 $qry31="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ss_id. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry31=mysql_query($qry31);
							$fratelist11=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate11=mysql_fetch_assoc($fratelist11);
					$ffgid21=$frate11['fg_id'];
					$ffgdid21=$frate11['fgd_id'];	 
					
							if($ftypevalue==1){
								$yf_to12=$mlate_join;	
							}else{
								$yf_to12="";	
							}
								$paidamount=0;
						  while($row31=mysql_fetch_assoc($qry31))
							{
								$fullpaid2=0;
								$fiid1=$row31['fi_id'];
								$fsummaylist1=mysql_query("SELECT fto,amount FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay1=mysql_fetch_assoc($fsummaylist1)){
									 $yf_to12=$fsummay1['fto'];
									 $paidamount +=$fsummay1['amount'];
									 if($yf_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					//echo $yf_to12;
					if($yf_to12){
						$fratefrom2=$yf_to12+1;
						
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
								 //echo "((".$frateto12."-(".$fratefrom2."-1))/".$frateto2.")*".$frateamount2."<br>";
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
						//if($frateamount12>0){
							 $tot +=$frateamount12;
							 $totaolpaid +=$paidamount;
							//echo $paidamount;
							//echo "<br>";
						 //}
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									/*$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);*/
														$ftypevalue=12;
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $yf_to12=0;
										if(!empty($frid)) { 
					 $qry31="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry31=mysql_query($qry31);							
							
							$fratelist11=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate11=mysql_fetch_assoc($fratelist11);
					$ffgid21=$frate11['fg_id'];
					$ffgdid21=$frate11['fgd_id'];	 
					
							$f_to12="";	
							$paidamount=0;
						  while($row31=mysql_fetch_assoc($qry31))
							{
								$fullpaid2=0;
								$fiid1=$row31['fi_id'];
								$fsummaylist1=mysql_query("SELECT fto,amount FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay1=mysql_fetch_assoc($fsummaylist1)){
									 $f_to12=$fsummay1['fto'];
									 $paidamount +=$fsummay1['amount'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($yf_to12){
						$fratefrom2=$yf_to12+1;
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
						 }
						 //echo $paidamount."<br>";
						 $totaolpaid +=$paidamount;
						 $totalamount +=$frateamount2;
				}/************************ Other Fees end*********************************/
									}
									/************************ Year Fees end*********************************/
									//echo $totalamount."-".$totaolpaid."<br>";
							$totalyearly=($totalamount-$totaolpaid);	
								  $tot=0;
								$totalamount=0;
								      $tquery=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$cid1 AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 AND fg_id=$fgid1 ORDER BY fgd_id");
								      while($row2=mysql_fetch_assoc($tquery)){
										  
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];
																		
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
							$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
						    $ftype=mysql_fetch_assoc($ftypelist);
							$ftypevalue=$ftype['fty_value'];													
							
			//$_SESSION['frate']['ffrom'] = '1';
			//$_SESSION['frate']['fto'] = $ftypevalue;		  						
					$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
													  $class=mysql_fetch_assoc($classlist);
																	
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
					 if($ftypevalue=='1'){
						 $feesamount=$class['dis_value'];
					 }
					 
										if(!empty($frid) && $ftypevalue=='1') { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
										}
								//echo $f_to12;
								if($spid && $busstudent){
								/****************************************BUS FEES START***********************************/
								$sql11=mysql_query("SELECT bf_id,ftyid,end,fees,sp_fees,sp_fees_onetime,one_time FROM trbusfees WHERE sp_id=$spid AND ay_id=$acyear");
									while($row21=mysql_fetch_assoc($sql11))
									{ 
									$bfid=$row21['bf_id'];
									$ftyid1=$row21['ftyid'];
							
								$ftypelist1=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid1"); 
																  $ftype1=mysql_fetch_assoc($ftypelist1);
														$bftypevalue=$ftype1['fty_value'];
					 $fratefrom2='1';
					 $frateto2=$bftypevalue;
					 				
									$fendmonth=$row21['end'];
					 				if($fendmonth){
										$btomonth=$fendmonth;
									}else{
										$btomonth=12;
									}
					 $fesstypearray1=array("fees","sp_fees","sp_fees_onetime","one_time"); 
					 
					 $tablefield=$fesstypearray1[$busfeestype];
					 $bfrateamount2=$row21[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($bftypevalue==1){
								$bf_to12=$blate_join;	
							}else{
								$bf_to12="";	
							}
							
							//echo $bf_to12;
							
										if(!empty($bfid)) { 
					 $qry31="SELECT fto FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry31=mysql_query($qry31);
						while($row31=mysql_fetch_assoc($qry31))
							{
								if($row31['fto']>$bf_to12){
								$bf_to12=$row31['fto'];
								}
									 if($bf_to12==$btomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($bf_to12){
						$fratefrom2=$bf_to12+1;
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$btomonth){
							$frateto12=$btomonth;
							
						}
						
						//echo $btomonth;
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$bfrateamount2;							
						//echo '(('.$frateto12.'-('.$fratefrom2.'-1))/'.$frateto2.')*'.$bfrateamount2;
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$bfrateamount2;
						
					}else {
							$frateto12=$frateto2;
							$frateamount12=$bfrateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 $bfrateamount2;
						 //echo $fratefrom2."-".$frateamount12."-".$btomonth."-".$bfrateamount2."<br>";
						if($frateamount12>0){
							//echo $bf_to12."-".$frateamount12."-".$btomonth;
							//addtocart($bfid,$fratefrom2,$frateto12,$frateamount12,$ftyid1,$bftypevalue,$frateamount12,$bfrateamount2,$tomonth,"fees");
							
						 }
									}
						/****************************************BUS FEES END***********************************/	
								}
								$totalpending =round($totalpending,2);
								$totalmonth=0; $btotal=0; $total=0;
								for($i=$from;$i<=$to;$i++){
									/*********monthly****************/
                                     if($f_to12>=$i){
										 //echo "paid";
										 }else{ 
												if($i<=$tomonth){
												$totalmonth+=round($feesamount,2);}}
									/*********Transport****************/
									if($spid && $busstudent){
										 if($fratefrom2<=$i){
											 if($i<=$btomonth){
													$btotal+=round($bfrateamount2,2);}
											 }	
										} 
									}
									$totalyearly=round($totalyearly,2);
									$total=$totalmonth+$btotal+$totalyearly+$totalpending;
									if($filt=='np' && $total){
									$grandtotal +=$total;
									//echo $totalamount."-".$btotal."-".$totalyearly."<br>";
									
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']."/".$section1['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalmonth); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalyearly); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $btotal); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalpending); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total); $column++;
								
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($class1['c_name']."/".$section1['s_name']). ',';
										$content .= stripslashes($student['stype']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($totalmonth). ',';
										$content .= stripslashes($totalyearly). ',';
										$content .= stripslashes($btotal). ',';
										$content .= stripslashes($totalpending). ',';
										$content .= stripslashes($total). ',';
										$content .= "\n";
										$count++;
									}else if($filt=='p' && !$total){
										$grandtotal +=$total;
									//echo $totalamount."-".$btotal."-".$totalyearly."<br>";
									
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']."/".$section1['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalmonth); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalyearly); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $btotal); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalpending); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total); $column++;
								
							    $rowCount++;
								$content .= stripslashes($count). ',';
								$content .= stripslashes($student['admission_number']). ',';
								$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
								$content .= stripslashes($student['fathersname']). ',';
								$content .= stripslashes($class1['c_name']."/".$section1['s_name']). ',';
								$content .= stripslashes($student['stype']). ',';
								$content .= stripslashes($student['phone_number']). ',';
								$content .= stripslashes($totalmonth). ',';
								$content .= stripslashes($totalyearly). ',';
								$content .= stripslashes($btotal). ',';
								$content .= stripslashes($totalpending). ',';
								$content .= stripslashes($total). ',';
								$content .= "\n";
								$count++;
									}else if($filt=="all"){
										$grandtotal +=$total;
									//echo $totalamount."-".$btotal."-".$totalyearly."<br>";
									
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['admission_number']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['firstname']." ".$student['lastname']);  $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['fathersname']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']."/".$section1['s_name']); $column++;
							    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['stype']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student['phone_number']); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalmonth); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalyearly); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $btotal); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $totalpending); $column++;
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total); $column++;
								
							    $rowCount++;
										$content .= stripslashes($count). ',';
										$content .= stripslashes($student['admission_number']). ',';
										$content .= stripslashes($student['firstname']." ".$student['lastname']). ',';
										$content .= stripslashes($student['fathersname']). ',';
										$content .= stripslashes($class1['c_name']."/".$section1['s_name']). ',';
										$content .= stripslashes($student['stype']). ',';
										$content .= stripslashes($student['phone_number']). ',';
										$content .= stripslashes($totalmonth). ',';
										$content .= stripslashes($totalyearly). ',';
										$content .= stripslashes($btotal). ',';
										$content .= stripslashes($totalpending). ',';
										$content .= stripslashes($total). ',';
										$content .= "\n";
										$count++;
									}
							}
										}

}
$rowCount++;
$rowCount++;
$column = 'A';
					
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= 'Total ,';
	$content .= stripslashes(round($grandtotal, 2)).',';
	$content .= "\n";
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Total');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, round($grandtotal, 2));  $column++;
	$rowCount++;
	
$objPHPExcel->getActiveSheet()->setTitle("Monthly Fees Pending Report");

$ptypename=str_replace(" ","",$ptypename);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=MonthlyFees_Pending_report-list($class_name-$section_name).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
