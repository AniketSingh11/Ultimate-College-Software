<?php
require_once 'includes/config.php';
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

$gexcid=$_GET['excid'];
$gexsid=$_GET['exsid'];
$lastyear=$_GET['lastyear'];
$specific=$_GET['specific'];
			 					
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
								$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(50);cellFont("B1","Calibri");
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
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Category");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Sub Category");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension($column.$rowCount)->setWidth(20);cellFont($column.$rowCount,"Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bill No");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Closed Date");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Closed Amount");$column++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending Amount");$column++;				 
								
								$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
								//end of adding column names
								//start while loop to get data
								$rowCount = 3;
								
$content = '';
$title = '';	
					$totalbill=0;
   					$totalamount=0;
					$totalcbill=0;
					$totalcamount=0;
					$totalpamount=0;
					if($gexsid){
					    $classlist1=mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id='$gexsid'");
					    $class1=mysql_fetch_assoc($classlist1);
						
						for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$class1["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$gexsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT * FROM ex_insubcategory WHERE $subname='$gexsid'");
					    		while($class2=mysql_fetch_assoc($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					}
					$qery="SELECT exc_id,ex_category FROM ex_category";
					if($gexcid){
						$qery .=" WHERE exc_id=$gexcid";
					}
					$qery .=" ORDER BY ex_category ASC";
   $agencylist=mysql_query($qery);
							$count=1;
			  while($agency=mysql_fetch_assoc($agencylist))
        		{	
				$excid=$agency['exc_id'];
				 /*for($i=0;$i<=20;$i++)
                                {*/
                                $classl = "SELECT * FROM ex_insubcategory where count='$i' AND category=$excid";
								if($gexsid){
									if($specific){
										$classl .= " AND exs_id='$gexsid'";
									}else{
										$classl .= " AND exs_id IN (".implode(',',$myarray).")";
									}
								}
								$result1 = mysql_query($classl) or die(mysql_error());
                                while ($row1 = mysql_fetch_assoc($result1))
                                {                                 
                                
                                $subcat=array();
                                for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$row1["sub$j"."_id"];
                                
                                if($sub_id!=0){
                                    array_push($subcat,$sub_id);
                                }
                                }
                                    $insub_name="";
                                        foreach ($subcat as $val){                                
                                            $qry1=mysql_fetch_assoc(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                                            $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
											}
                                           
																/*if($exsid==$row1['exs_id']){ 
															   echo $selectsubname=$insub_name.$row1['sub_name'];
															   }*/
															  $exsid=$row1['exs_id'];
															  //echo $insub_name;
															  //echo $row1['sub_name']."<br>";
						$tamount=0;
					$tcbill=0;
					$tcamount=0;
					$tpamount=0;					
							$excid=$agency['exc_id'];							
							$qry2="SELECT distinct a.* FROM exponses a LEFT JOIN exponses_bill_summary b ON a.ex_id = b.ex_id AND b.ay_id=$acyear WHERE (a.ay_id=$acyear OR b.ay_id=$acyear";
							if($lastyear){
								$qry2 .=" OR (a.ay_id<$acyear AND status=0))";
							}else{
								$qry2 .=")";
							}
							if($excid){
								$qry2 .=" AND a.exc_id=$excid AND a.exs_id='$exsid'";
							}
							$qry2 .=" ORDER BY a.ex_id DESC";
							$qry=mysql_query($qry2);
							$excount=mysql_num_rows($qry);
					if($excount>0){	
					while($row=mysql_fetch_assoc($qry))
        		{
					$aid1=$row['aid'];
					$exid=$row['ex_id'];
					$excid1=$row['exc_id'];
					$exsid1=$row['exs_id'];
					$status=$row['status']; 
					$type=$row['type']; 
					$cdate="";
					$camount="";
					$pending="";
					$epid="";
					$cayid=$row['ay_id'];
					
					$ayear1=mysql_query("SELECT e_year FROM year WHERE ay_id='$cayid'");
					$ay1=mysql_fetch_assoc($ayear1);
					$myarray = array();
					$ceyear=$ay1['e_year'];
					$ayear2=mysql_query("SELECT ay_id FROM year WHERE (e_year>='$ceyear' AND e_year<='$eyear')");
					while($ay2=mysql_fetch_assoc($ayear2)){
						array_push($myarray,$ay2['ay_id']);	
					}
					
					$agencylist1=mysql_query("SELECT * FROM agency WHERE a_id=$aid1"); 
					  $agency1=mysql_fetch_assoc($agencylist1);
					  
					  $agencyname=$agency1['a_name'];
								
        		    $column = 'A';
					
	$content .= stripslashes($count). ',';
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
	$content .= stripslashes($agency['ex_category']).',';
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $agency['ex_category']);  $column++;
	$content .= stripslashes($insub_name.$row1['sub_name']).',';
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $insub_name.$row1['sub_name']);  $column++;
	$content .= stripslashes($row['r_no']).',';
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['r_no']);  $column++;
	$content .= stripslashes($row['date_day']."/".$row['date_month']."/".$row['date_year']).',';
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$row['date_day']."/".$row['date_month']."/".$row['date_year']);  $column++;
	$content .= stripslashes($row['amount']).',';
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['amount']); $column++;
	if($type=="0"){
		$cdate=$row['date_day']."/".$row['date_month']."/".$row['date_year'];
		if($cdate){
			$content .= stripslashes($cdate).',';
			$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cdate); $column++;
			$tcbill++;
		}else{
			$content .= '- ,';
			$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ' - '); $column++;
		}
	}else{ 
		if($status=='1'){
			$exsam1=mysql_query("SELECT ep_id FROM exponses_bill_summary WHERE ex_id=$exid ORDER BY ep_id DESC"); 
			$exsamry1=mysql_fetch_assoc($exsam1);
			$epid1=$exsamry1['ep_id'];
			if($epid1){
				$bexsam1=mysql_query("SELECT date_day,date_month,date_year FROM exponses_bill WHERE ep_id=$epid1"); 
				$bexsamry1=mysql_fetch_assoc($bexsam1);
					$cdate=$bexsamry1['date_day']."/".$bexsamry1['date_month']."/".$bexsamry1['date_year'];
			 }
	}else{
			$cdate="";
		}
		if($cdate){
			$content .= stripslashes($cdate).',';
			$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cdate); $column++;
			$tcbill++;
		}else{
			$content .= '- ,';
			$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ' - '); $column++;
		}
	}
	if($type==0){ 
		$camount=$row['amount'];
							  	
				if($camount){ 
				$content .= stripslashes($camount).',';
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $camount); $column++;
				$tcamount +=$camount; 
				}else { 
				$content .= '- ,';
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ' - '); $column++;}
	}else{
			$exsam=mysql_query("SELECT * FROM exponses_bill_summary WHERE ex_id=$exid");
							$exbillcounts =mysql_num_rows($exsam);
							 if($exbillcounts=='0'){ 
							 	$content .= '- ,';
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ' - '); $column++; }
							 else if($exbillcounts=='1' && $status=='1'){
									 $exsamry=mysql_fetch_assoc($exsam);
								$epid=$exsamry['ep_id'];
								if($epid){
									$bexsam=mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid"); 
									$bexsamry=mysql_fetch_assoc($bexsam);
										$cdate=$bexsamry['date_day']."/".$bexsamry['date_month']."/".$bexsamry['date_year'];
										$camount=$row['amount'];
										$pending=0;
								 }
								$content .= stripslashes($camount).',';
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $camount); $column++;
								 $tcamount +=$camount;
							 }else{
								 $singlecamount=0;
								 while($exsamry=mysql_fetch_assoc($exsam)){
								$epid=$exsamry['ep_id'];
								if($epid){
									$bexsam=mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid"); 
									$bexsamry=mysql_fetch_assoc($bexsam);
										$cdate=$bexsamry['date_day']."/".$bexsamry['date_month']."/".$bexsamry['date_year'];
										$camount=$exsamry['amount'];
										$tcamount +=$camount;
								 } 
						   				$singlecamount +=$camount;
						   		}
								if($singlecamount){
								$content .= stripslashes($singlecamount).',';
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $singlecamount); $column++;
								}else{
								$content .= '- ,';
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ' - '); $column++;	
								}
				}}
   $tamount +=$row['amount'];
   
   $totalpayamount=0;
   if(!empty($myarray)){
   				$qry12=mysql_query("SELECT amount FROM exponses_bill_summary WHERE ex_id=$exid AND ay_id IN (".implode(',',$myarray).") ");
			  while($row12=mysql_fetch_array($qry12))
        		{
					$totalpayamount+=$row12['amount'];
				}
   }
				$pending=$row['pending'];
				if($totalpayamount){
					$pending=$row['amount']-$totalpayamount;
				}
				if(!$pending && $status=="0"){
					$pending=$row['amount'];
				}
   	if($pending){ 
		$content .= stripslashes($pending).',';
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $pending); $column++;
		$tpamount +=$pending;
		}else { 
		$content .= '- ,';
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ' - '); $column++;
		}
				
	$content .= "\n";
	$rowCount++;
	$count++;
					} $rowCount++;
					
					$totalbill +=$excount;
   					$totalamount +=$tamount;
					$totalcbill +=$tcbill;
					$totalcamount +=$tcamount;
					$totalpamount +=$tpamount; $count++;					
					} } 
					//}
						}
	$rowCount++;
		$rowCount++;
		$column = 'A';
					
	$content .= ',';
	$content .= ',';
	$content .= 'Overall Details ,';
	$content .= 'No.B: '.stripslashes($totalbill).',';
	$content .= 'No.D: '.stripslashes($totalbill).',';
	$content .= 'T:  '.stripslashes( round($totalamount,2)).',';
	$content .= 'No.CB:  '.stripslashes($totalcbill).',';
	$content .= 'C.T:  '.stripslashes( round($totalcamount,2)).',';
	$content .= 'P.T:  '.stripslashes( round($totalpamount,2)).',';
	$content .= "\n";
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, '');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'Overall Details');  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No.B: '.$totalbill);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No.D: '.$totalbill);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'T: '.round($totalamount, 2));  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'No.CB: '.$totalcbill);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'C.T: '.round($totalcamount, 2));  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, 'P.T: '.round($totalpamount, 2));  $column++;
	$rowCount++;
																																
	/*****************************************sheet 2 *************************************************/
$objPHPExcel->getActiveSheet()->setTitle("Finance Sub Categorywise Report");

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Finance Sub Ctageorywise Report.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
