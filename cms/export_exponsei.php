<?php
require("includes/config.php");
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
$qry=mysql_fetch_assoc(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
$aid=$_GET['aid'];
$exsid=$_GET['exs_id'];
if($aid){
							 $classlist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
								  $class=mysql_fetch_assoc($classlist);
					}
 
$qry1 ="SELECT amount FROM exponses_bill WHERE ay_id=$acyear";
							if($aid){
							$qry1 .=" AND a_id=$aid";
							}
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$tamount=$row1['amount'];
					$total +=$tamount;					
				}
				
				$qry2="SELECT * FROM exponses_bill WHERE ay_id=$acyear";
							if($excid){
							$qry2 .=" AND a_id=$aid";
							}

        $result = mysql_query($qry2) or die(mysql_error());
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
if($aid){ 
			$cname=$class['a_name'];
			$objPHPExcel->getActiveSheet()->setCellValue("A2","$cname");
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(50);cellFont("A2","Calibri");

}
        
        $objPHPExcel->getActiveSheet()->setCellValue("F2","Total Amount: $total ");
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(50);cellFont("F2","Calibri");
//start of printing column names as names of MySQL fields

$rowCount = 3;

$column = 'A';
        
     /*   for ($i = 1; $i < mysql_num_fields($result); $i++)
        
        {
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
            $column++;
        }
        */
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "S.no");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Expense Category");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri"); 
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Receiver");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri"); 
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bill Generated By");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri"); 
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 4;
       $count=1;
        while($row = mysql_fetch_assoc($result))
        
        {
            $column = 'A';
            
            $excid1=$row['exc_id'];
					 $expenselist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid1"); 
								  $expenses=mysql_fetch_assoc($expenselist);
           
          
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $count);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['a_name']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['bill_no']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['date']); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['title']);  $column++;
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rs.".number_format($row['amount'],2));  $column++;
          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['receiver']);  $column++;
		   $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['billgenerate']);  $column++;
             $rowCount++;
			 $count++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Expenses Paid Report");
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Expenses-Paid-report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
?>
