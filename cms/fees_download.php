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
		$bid=$_GET['bid'];

			if(!$bid){
			$boardlist1=mysql_query("SELECT b_id,b_name FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT b_id,b_name FROM board WHERE b_id=$bid"); 
	
								  $board=mysql_fetch_array($boardlist);
								  
		
			if($_GET['status']) {
              if($_GET['status']=="All") {
              $qry1=mysql_query("SELECT fi_total FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1'");
              }  if($_GET['status']=="Paid") {
              $qry1=mysql_query("SELECT fi_total FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' AND i_status='0'");
              } 
              if($_GET['status']=="Rejected") {
              $qry1=mysql_query("SELECT fi_total FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' AND i_status='1'");
              } 
            } else {
              $qry1=mysql_query("SELECT fi_total FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1'");
            }
			//echo "SELECT fi_total FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' AND i_status='0'";
		
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['fi_total'];
					 $total +=$tamount;					
									  
				}
	
 
        $rowCount = 2;
		
			
        $objPHPExcel->getActiveSheet()->setCellValue("D1"," $school_name ");
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(50);cellFont("D1","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue("I1","Total : $total ");
					$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(50);cellFont("I1","Calibri");
        //start of printing column names as names of MySQL fields
				
        $column = 'A';
        
     /*   for ($i = 1; $i < mysql_num_fields($result); $i++)
        
        {
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
            $column++;
        }
        */
		
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "FR No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin N0");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class-Section");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student_Type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Invoice By");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("I2","Calibri");
		
     
       //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
					




					
				
			
								  
								  
								  
								  
								  
      if($_GET['status']) {
              if($_GET['status']=="All") {
                            $qry=mysql_query("SELECT c_id,s_id,fr_no,fi_name,fi_day,fi_month,fi_year,stype,fi_by,fi_total,fi_id,ss_id,i_status FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' ORDER BY fi_id DESC");
              }  if($_GET['status']=="Paid") {
              $qry=mysql_query("SELECT c_id,s_id,fr_no,fi_name,fi_day,fi_month,fi_year,stype,fi_by,fi_total,fi_id,ss_id,i_status FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' and i_status!='1' ORDER BY fi_id DESC");
              } 
              if($_GET['status']=="Rejected") {
              $qry=mysql_query("SELECT c_id,s_id,fr_no,fi_name,fi_day,fi_month,fi_year,stype,fi_by,fi_total,fi_id,ss_id,i_status FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' and i_status='1' ORDER BY fi_id DESC");
              } 
            } else {
              $qry=mysql_query("SELECT c_id,s_id,fr_no,fi_name,fi_day,fi_month,fi_year,stype,fi_by,fi_total,fi_id,ss_id,i_status FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' ORDER BY fi_id DESC");
            }

	 // echo "SELECT c_id,s_id,fr_no,fi_name,fi_day,fi_month,fi_year,stype,fi_by,fi_total,fi_id,ss_id FROM finvoice WHERE bid=$bid AND ay_id=$acyear and c_status!='1' AND i_status='0' ORDER BY fi_id DESC";
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$ssid=$row['ss_id'];
				$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT c_id,c_name FROM class WHERE c_id=$cid");
//echo "SELECT c_id,c_name FROM class WHERE c_id=$cid";				
				  $class=mysql_fetch_array($classlist);
				  $sectionlist=mysql_query("SELECT s_id,s_name FROM section WHERE s_id=$sid");
//echo "SELECT s_id,s_name FROM section WHERE s_id=$sid";				  
				  $section=mysql_fetch_array($sectionlist);	  
				  $studentlist=mysql_query("SELECT admission_number FROM student WHERE ss_id=$ssid"); 
				 // echo "SELECT admission_number FROM student WHERE ss_id=$ssid";
				  $student=mysql_fetch_array($studentlist);	
				  
				  
				  
            $column = 'A';
            
           
         
				  
				  $frno=$row['fr_no'];
				  $adminno=$student['admission_number'];
				  $finame=$row['fi_name'];
				   $date=$row['fi_day']."/".$row['fi_month']."/".$row['fi_year'];
				   $classsec=$class['c_name']."/".$section['s_name'];
				    $stype=$row['stype'];
					 $fiby=$row['fi_by'];
					 $total=number_format($row['fi_total'],2);
				   $status='';
                   if($row['i_status']==0) { 
                    $status='Paid';
                    } else { 
                      $status='Rejected';               
                               }    
          
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $frno);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $adminno);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  $finame);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $date); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $classsec);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $stype);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fiby);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $total);  $column++;
              $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status);  $column++;
            
             
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             
        
             //$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acyear_name);   $column++;
             $rowCount++;
            
        
							$count++;
							}  
		
		
		
		
        $objPHPExcel->getActiveSheet()->setTitle($class_name."-".$section_name."Fees Invoice");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
       header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=Fees Invoice-list.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
