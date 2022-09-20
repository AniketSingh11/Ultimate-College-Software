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
		
	$cid=$_GET['cid'];
		$bid=$_GET['bid'];
			$sid=$_GET['sid'];
			
           			
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
	//	echo "SELECT * FROM board WHERE b_id=$bid";die;
								  $board=mysql_fetch_array($boardlist);		
								  
				$ss_id=$_GET['ssid'];
 $ssid=$ss_id;	
 
					$cid=$_GET['cid'];
				$sid=$_GET['sid'];		
				$sid=$_GET['sid'];								
				$ddlterm=$_GET["ddlterm"];
			$ddlterm1=$_GET["ddlterm1"];
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
                           // echo "SELECT * FROM class WHERE c_id=$cid";die;							
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
					//	echo "SELECT * FROM section WHERE s_id=$sid";die;
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
				}
		
		
			
 
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
		
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admission  No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
		
			if($ddlterm=="1")
			{ 
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "I Term Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				
				
			  if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
			  }
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
		
			}
		if($ddlterm=="2")
			{
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "II Term Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				
				
				  if($ddlterm1=="2"){
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				else if($ddlterm1=="3"){
					
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
else if($ddlterm1=="1"){
					
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
			}
			
			if($ddlterm=="3")
			{
				  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "III Term Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				
				
				 if($ddlterm1=="1"){
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				else if($ddlterm1=="2"){
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
				}
else if($ddlterm1=="3"){
					
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");;
				}
			}
				if($ddlterm=="4")
			{
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "OtherFees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				
				
				 if($ddlterm1=="1"){
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");	
				}
				else if($ddlterm1=="2"){
					
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
			}
			
			
			if($ddlterm=="all")
			{
			 
			
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "I Term Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
			 
			
		
			  if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "II Term Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				
			
		
			 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "III Term Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
			
			 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "OtherFees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		
			
				
			 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
				
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
			$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "TotalFees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				
			 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}				
				else{
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Fees");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}
			
			}
			
			
		
		
		
		
     
       //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
		
			
			$qry="SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype FROM student AS s INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='".$acyear."' ";
			//echo "SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype FROM student AS s INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='".$acyear."' ";die;
			if($cid!="all")
			{
				$qry=$qry."	AND s.c_id='".$cid."'";
			}
			if($sid!="all")
			{
				$qry=$qry."  AND s.s_id='".$sid."'";
			}
			 $qry=$qry." AND s.b_id='".$bid."' ORDER BY s.c_id ASC";
			$result=mysql_query($qry);
			$cnt=0;
			//echo "test"; die;
			while($rs=mysql_fetch_assoc($result))
			{
					$cnt+=1;
					//getting the total fees for a student 
					$qry1="SELECT fg.fg_id,fg.fg_name,fgd.type,fr.ay_id,fr.c_id,sum(rate) as rate FROM fgroup AS fg INNER JOIN fgroup_detail AS fgd  ON fgd.fg_id=fg.fg_id  INNER JOIN frate AS fr ON fr.fg_id=fg.fg_id  GROUP BY fg.fg_id,fgd.type,fr.c_id,fr.ay_id  having fr.ay_id='".$acyear."' AND fr.c_id='".$rs["c_id"]."'";
					//echo "SELECT fg.fg_id,fg.fg_name,fgd.type,fr.ay_id,fr.c_id,sum(rate) as rate FROM fgroup AS fg INNER JOIN fgroup_detail AS fgd  ON fgd.fg_id=fg.fg_id  INNER JOIN frate AS fr ON fr.fg_id=fg.fg_id  GROUP BY fg.fg_id,fgd.type,fr.c_id,fr.ay_id  having fr.ay_id='".$acyear."' AND fr.c_id='".$rs["c_id"]."'";die;
					//echo $qry1;
					$qry1="SELECT fg_id,ay_id,c_id,sum(rate) as rate from frate AS fr group by  fg_id,ay_id,c_id having fr.ay_id='".$acyear."' AND fr.c_id='".$rs["c_id"]."'";
					//echo "SELECT fg_id,ay_id,c_id,sum(rate) as rate from frate AS fr group by  fg_id,ay_id,c_id having fr.ay_id='".$acyear."' AND fr.c_id='".$rs["c_id"]."'";die;
					$result1=mysql_query($qry1);
					$t1_fees=0;
					$t2_fees=0;
					$t3_fees=0;
					$other_fees=0;
					while($rs1=mysql_fetch_assoc($result1))
					{
						if($rs['stype']=="New" && $rs1['type']=="1") 
						 $fees+=$rs1['rate'];
						else
						 $fees+=$rs1['rate'];
						switch($rs1['fg_id'])
						{
							case "1":
								$t1_fees+=$rs1['rate'];
							break;
							case "2":
								$t2_fees+=$rs1['rate'];
							break;
							case "3":
								$t3_fees+=$rs1['rate'];
							break;
							case "4":
								if($rs['stype']=="New" && $rs1['type']=="1") 
									$other_fees+=$rs1['rate'];
								else
									$other_fees+=$rs1['rate'];
							break;
						}
					 
					}
					$qry2="Select fs.fg_id,ss_id,sum(amount) as amount from fsalessumarry AS fs INNER JOIN finvoice AS fi ON fi.fi_id=fs.fi_id INNER JOIN frate AS fr ON fr.fr_id=fs.fr_id  WHERE  ss_id='".$rs["ss_id"]."' GROUP BY ss_id,fg_id";
				//	echo "Select fs.fg_id,ss_id,sum(amount) as amount from fsalessumarry AS fs INNER JOIN finvoice AS fi ON fi.fi_id=fs.fi_id INNER JOIN frate AS fr ON fr.fr_id=fs.fr_id  WHERE  ss_id='".$rs["ss_id"]."' GROUP BY ss_id,fg_id";die;
					$qry2="select  amount,fg_id from finvoice as fi INNER JOIN fsalessumarry AS fs ON fs.fi_id=fi.fi_id WHERE fi.ss_id='".$rs["ss_id"]."'";
				//	echo "select  amount,fg_id from finvoice as fi INNER JOIN fsalessumarry AS fs ON fs.fi_id=fi.fi_id WHERE fi.ss_id='".$rs["ss_id"]."'";die;
					$result2=mysql_query($qry2);
					$t1_amount=0;
					$t2_amount=0;
					$t3_amount=0;
					$other_amount=0;
					while($rs2=mysql_fetch_assoc($result2))
					{
						switch($rs2['fg_id'])
						{
							case "1":
								$t1_amount+=$rs2['amount'];
							break;
							case "2":
								$t2_amount+=$rs2['amount'];
							break;
							case "3":
								$t3_amount+=$rs2['amount'];
							break;
							case "4":
								$other_amount+=$rs2['amount'];
							break;
						}
					}

				
            $column = 'A';
            
           
         
				  
			
				  $adminno=$rs['admission_number'];
				  $finame=$rs['firstname'];
				  $cname=$rs['c_name'];
				  // $date=$row['fi_day']."/".$row['fi_month']."/".$row['fi_year'];
				  // $classsec=$class['c_name']."/".$section['s_name'];
				  //  $stype=$row['stype'];
					// $fiby=$row['fi_by'];
					 //$total=number_format($row['fi_total'],2);
					  // $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cnt);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $adminno);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  $finame);  $column++;
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,   $cname);  $column++;
             
             
				   	
					 $csv_content=$csv_content.$cnt.",".$rs["admission_number"].",".$rs["firstname"].",".$rs["c_name"];
					if($ddlterm=="all")
					{
					  $csv_content=$csv_content.",".$t1_fees.",".$t1_amount.",".$t1_fees-$t1_amount;
					
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
		
					  if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t1_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("E3","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t1_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("F3","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t1_fees-$t1_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("G3","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t1_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t1_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t1_fees-$t1_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				
				 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t2_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t2_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t2_fees-$t2_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t2_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t2_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t2_fees-$t2_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		
				 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t3_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t3_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t3_fees-$t3_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t3_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t3_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t3_fees-$t3_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		
				 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$other_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $other_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($other_fees-$other_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$other_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $other_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($other_fees-$other_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
				
				
				
				
				
					
					$csv_content=$csv_content.",".$total_fees.",".$total_amount.",".$total_pending_amount."\n";
					$total_fees=$t1_fees+$t2_fees+$t3_fees+$other_fees;
					$csv_content=$csv_content.",".$total_fees;
					$total_amount=$t1_amount+t2_amount+t3_amount+$other_amount;
					$csv_content=$csv_content.",".$total_amount;
					$total_pending_amount=$total_fees-$total_amount;
					$csv_content=$csv_content.",".$total_pending_amount."\n";
					
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
					
				 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$total_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($total_pending_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$total_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($total_pending_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
				}
					}
					if($ddlterm=="1")
					{
 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,'');$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D3","Calibri");
 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t1_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("E3","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t1_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t1_fees-$t1_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t1_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t1_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t1_fees-$t1_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
				}

				
				}
					if($ddlterm=="2")
					{
						$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,'');$column++;
                       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D3","Calibri");
						 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t2_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t2_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t2_fees-$t2_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t2_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t2_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t2_fees-$t2_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
				}
				
					}
					
					if($ddlterm=="3")
					{
				
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,'');$column++;
                       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D3","Calibri");
						 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t3_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t3_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t3_fees-$t3_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$t3_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $t3_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($t3_fees-$t3_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				}
							
					}
					if($ddlterm=="4")
					{
						$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,'');$column++;
                       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D3","Calibri");
					 if($ddlterm1=="1"){
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$other_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
				else if($ddlterm1=="2"){
					
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $other_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
else if($ddlterm1=="3"){
					
					 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($other_fees-$other_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}				
				else{
					  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$other_fees);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $other_amount);$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, ($other_fees-$other_amount));$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
				}
					
						
						
						
					}
				

				
					
					
					$t1_fees=0;
					$t2_fees=0;
					$t3_fees=0;
					$other_fees=0;
			
			
          
          
            
             
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             
        
             //$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acyear_name);   $column++;
             $rowCount++;
            
        
							$count++;
							
			}
		
		
		
        $objPHPExcel->getActiveSheet()->setTitle($class_name."-".$section_name." Student_FeesInvoice_Download");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
      header('Content-Type: application/vnd.ms-excel');
       header("Content-Disposition: attachment;filename= Student_FeesInvoice_Download-list.xls");
       header('Cache-Control: max-age=0');
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
       $objWriter->save('php://output');  
        
       
 
?>
