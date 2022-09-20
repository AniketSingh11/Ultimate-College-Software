<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=boarding-point-report.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/

function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
									  $ptotal=0;
								      $tquery2=mysql_query("select * from bfinvoice  where ss_id='$ssid' and c_id='$c'and bid='$b' and  ay_id='$acyear'");
								      while($trow2=mysql_fetch_array($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								           $ptotal=$trow2['fi_total']+$ptotal;
								      }
								      return $ptotal;
								      	
								  } 
								  
	 		$rid=$_GET['rid'];
			$acyear=$_GET['ayid'];
			
			$ptype1=$_GET['ptype'];
			
				
			if($ptype1 && $rid){
			    	
			   if($ptype1=='All'){
						$ptypename="Fully Paid";
					}else if($ptype1=='Non'){
						$ptypename="Non Pay";
					}else if($ptype1=='Pand'){
						$ptypename="Payment Pending";
					}
			    	
			    //echo $ptype1;
			    	
			    if(!empty($rid)) {$classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid");
			    $route=mysql_fetch_array($classlist);
			    $vid=$route['v_id'];
			    $did=$route['d_id'];
			    $sdid=$route['sd_id'];
			    $vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid");
			    $vehicle=mysql_fetch_array($vehiclelist);
			    $driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did");
			    $driver=mysql_fetch_array($driverlist);
			    $driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid");
			    $driver1=mysql_fetch_array($driverlist1);
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
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No/Staff ID");$column++;
								$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student/Staff Name");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Board");$column++;
								 
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Booarding Point");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Type");$column++;
								
								 
							 
								
								$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
								
								
								//end of adding column names
								//start while loop to get data
								
								$rowCount = 3;
								
								
								
								
								
								
								
								
								
								
$content = '';
$title = '';
 $myrt=$route['r_name'];			
 $qry="SELECT * FROM student WHERE ay_id='" . $acyear. "' and r_id=1";
							if(!empty($rid)) { $qry .= " AND route = '" . $myrt. "'"; }	
							$qry=mysql_query($qry);
					
				//	$qry=mysql_query("SELECT * FROM student WHERE r_id=$rid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
        		    $column = 'A';
        		    
					 $ssid=$row['ss_id'];
					  $ss_gender=$row['	gender'];
					  $cid=$row['c_id'];
					  $sid=$row['s_id'];
					  $bid=$row['b_id'];
					  $s_type=$row['stype'];
					  $fdisid1=$row['fdis_id'];
					  $rid=$row['r_id'];
					  $spid=$row['sp_id'];
					  $busfeestype=$row['busfeestype'];
					  $mlate_join=$row['mlate_join'];
					  $blate_join=$row['blate_join'];
					  //echo "<br>";
				 				$nonpay=0;
								$pendpay=0;
								$fullpay=0;
				 
				 $totalpending=0;
				 $totalamount=0;
				 
				 $rid1=$row['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
								  
								  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board1=mysql_fetch_array($boardlist);
				
				$sql1=mysql_query("SELECT * FROM busfees WHERE r_id=$rid AND sp_id=$spid AND ay_id=$acyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 				
									$fendmonth=$row2['end'];
					 				if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
									
									
									if($f_to12){
										$tcalfrom=$f_to12+1;
									}else{
										$tcalfrom=1;
									}
										
									
									
					 $fesstypearray=array("fees","sp_fees","sp_fees_onetime","one_time"); 
					 
					 $tablefield=$fesstypearray[$busfeestype];
					 $frateamount2=$row2[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($ftypevalue==1){
								$f_to12=$blate_join;	
							}else{
								$f_to12="";	
							}
							
							
							
							//echo $f_to12;
							
										if(!empty($bfid)) { 
					 $qry3="SELECT * FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "'";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_array($qry3))
							{
								$f_to12=$row3['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
							
						}
						
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$frateamount2;							
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
						 $rmonth=($tomonth-$fratefrom2)+1;
						 
						if($frateamount12>0){
							$totalpending +=$frateamount12*$rmonth;
							//echo $bfid.",".$fratefrom2.",".$frateto12.",".$frateamount12.",".$ftyid.",".$ftypevalue.",".$frateamount12.",".$frateamount2.",".$tomonth;
						 }
										
									}
					
					$totalamount=(($tomonth-$tcalfrom)+1)*$frateamount2;
					$paid=paid_amount($bid,$cid,$sid,$acyear,$ssid);
								
								if(!$paid){
									  $nonpay++;
								  }if($totalpending){
									  $pendpay++;
								  }
								  if(!$totalpending && $paid){
									  $fullpay++;
								  }
							    
	if($fullpay && $pendpay==0 && $ptype1=="All"){
		
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['admission_number']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['firstname']." ".$row['middlename']." ".$row['lastname']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']." / ".$section1['s_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board1['b_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  $route['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row6['stop_name']); $column++;
//	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fesstypearray1[$busfeestype1]); $column++;
//	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student"); $column++;
$rowCount++;
	}
	if(($pendpay && !$nonpay) && $ptype1=='Pand'){
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['admission_number']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['firstname']." ".$row['middlename']." ".$row['lastname']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']." / ".$section1['s_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board1['b_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  $route['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row6['stop_name']); $column++;
	$rowCount++;
		
	}if($nonpay!=0 && $ptype1=='Non'){
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['admission_number']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['firstname']." ".$row['middlename']." ".$row['lastname']);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class1['c_name']." / ".$section1['s_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $board1['b_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  $route['r_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row6['sp_name']); $column++;
	$rowCount++;
	}
 
}
 



$objPHPExcel->getActiveSheet()->setTitle("Bus Fee Paid Report");


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Bus_FeePaidReport-list($ptypename-$row5[r_name]).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

			}
?>
