<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$baid=$_GET['baid'];
$querylist ="SELECT * FROM bank_deposit";
if($baid){
    $querylist .=" WHERE ba_id=$baid";
}
 
 
     $result = mysql_query($querylist) or die(mysql_error());
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
       $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Account No");$column++;
        
       $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bank");$column++;
       
       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Deposited By");$column++;
	   
	   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Type");$column++;

       $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
       
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
             $date=$row['date'];
           $account_no= $row['account_no'];
           $name=$row['name'];
           $b_name=$row['b_name'];
           $deposit_by=$row['deposit_by'];
		   $type=$row['type'];
          $amount=number_format($row['amount'],2);
		  if($type=='1'){
			  $typename="Cheque Pay";
		  }else{
			  $typename="Cash Deposit";
		  }
           
           $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $date);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $account_no);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $b_name); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $deposit_by); $column++;
			  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $typename); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $amount); $column++;
            
         
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("BankDeposit Account Report");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="BankDepositAccount_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
