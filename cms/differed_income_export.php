<?php
require("includes/config.php");
/*header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Fees-income-report.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

	 		$sdate=$_GET['sdate'];
			$edate=$_GET['edate'];
			$bid=$_GET['b_id'];
			$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$acyear=$_GET['ayid'];
							
							$sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
							$section=mysql_fetch_array($sectionlist);
							$class_name=$section["c_name"];
							 
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
							$section=mysql_fetch_array($sectionlist);
							$section_name=$section["s_name"];
							
							if(empty($cid)){  $class_name="All"; }
							if(empty($sid)){  $section_name="All"; }
			
					$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
			$b_name=$board['b_name'];
			
			if(!empty($cid)) {
			$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  $cname=$class['c_name']; 
			}
			if(empty($cname)){
				$cname="All Classes";
			}					  
								  
								   $sname="";
				if(!empty($sid)) { $sname="-".$section['s_name'];}		
					$sdate_split1= explode('/', $sdate);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_day=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		 			
					$edate_split1= explode('/', $edate);		 
		  $edate_month=$edate_split1[0];
		  $edate_day=$edate_split1[1];
		  $edate_year=$edate_split1[2];
		  
		  
		  
		
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
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "FR No");$column++;
		  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Board");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Category");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student type");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Inovice By");$column++;
		  
		  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Differed Amount");$column++;
		  
		  $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
		  
		  
		  //end of adding column names
		  //start while loop to get data
		  
		  $rowCount = 3;
		  
		  
		  
		  
		  $enddate= $edate_year.$edate_month.$edate_day;
	 $qry="SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND bid= '" . $bid."' and c_status!='1'";
	 						if(!empty($cid)) { $qry .= " AND c_id = '" . $cid. "'"; }
							if(!empty($sid)) { $qry .= " AND s_id = '" . $sid. "'"; }					
					$qry .=" AND ay_id='" . $acyear. "'";
							$qry=mysql_query($qry);
$total=0;
$content = '';
$title = '';
$count=1;
while($rs=mysql_fetch_array($qry)) { 
    
    $column = 'A';
    
$bid1=$rs['bid'];
$cid=$rs['c_id'];
				$sid=$rs['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
$boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);
					$boardname=$board1['b_name'];
					$ffi_id=$rs['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fg_id='3' AND type='terms'");
							  $row6=mysql_fetch_array($qry6);
							  if($row6){
							  $tamount=$row6['tamount'];
							  $twomonth_amount=($tamount/2);
							  $amount=$row6['amount'];
							  $pamount=$row6['pamount'];
							  //$twomonth_amount." > ".$pamount." - ";
							  if($twomonth_amount > $pamount){
								  $testbalance=$amount+$pamount;
								  if($testbalance>$twomonth_amount){
									   $first_haft_pay=$testbalance-$twomonth_amount;									   
									   $differ_amount=($amount-$first_haft_pay);
								  }else{
									  $differ_amount=($testbalance-$pamount);
								  }
								 $total +=$differ_amount;
		
	$amount =$rs["fi_total"];
	$content .= stripslashes($count). ',';
	$content .= stripslashes($rs["fr_no"]). ',';
	$content .= stripslashes($rs["fi_name"]). ',';
	$content .= stripslashes($rs["fi_day"]." / ".$rs["fi_month"]." / ".$rs["fi_year"]). ',';
	$content .= stripslashes($boardname). ',';
	$content .= stripslashes($class["c_name"]."/".$section['s_name']). ',';
	$content .= stripslashes($rs["category"]). ',';
	$content .= stripslashes($rs["stype"]). ',';
	$content .= stripslashes($rs["fi_by"]). ',';
	$content .= $differ_amount. ',';
	$content .= "\n";
	$count++;	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fr_no"]);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fi_name"]);  $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fi_day"]." / ".$rs["fi_month"]." / ".$rs["fi_year"]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $boardname); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class["c_name"]."/".$section['s_name']); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$rs["category"]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["stype"]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rs["fi_by"]); $column++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $differ_amount); $column++;
	
	 
	$rowCount++;
	
	
							  } }
}
$content .= " Totol : ".$total."\n";
$title .= "Differed Income Report ".$cname."".$sname."\n";
$title .= "s.no,FR No,Student Name,Date,Board,Class-Section,Student Category,Student type,Inovice By,Differed Amount"."\n";
//echo $title;
//echo $content;

$objPHPExcel->getActiveSheet()->setTitle("Differed Income Report");





// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=DifferedIncome_report-list($class_name-$section_name).xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');



?>
