<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$incid=$_GET['incid'];

$sdate=$_GET['sdate'];
$edate=$_GET['edate'];
 
$sdate_split1= explode('/', $sdate);
$sdate_month=$sdate_split1[0];
$sdate_day=$sdate_split1[1];
$sdate_year=$sdate_split1[2];
$startdate= $sdate_year.$sdate_month.$sdate_day;

$edate_split1= explode('/', $edate);
$edate_month=$edate_split1[0];
$edate_day=$edate_split1[1];
$edate_year=$edate_split1[2];

$enddate= $edate_year.$edate_month.$edate_day;
 
$qry1 ="SELECT * FROM income where inc_id!='' ";
if($sdate){
$qry1 .=" and (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "'";
}
if($incid && $incid!='All'){
    $qry1 .=" and  inc_id=$incid";
}
 


        $result = mysql_query($qry1) or die(mysql_error());
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Category");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
    
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Receipt No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Description");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
    
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
            $incid1=$row['inc_id'];
            $expenselist=mysql_query("SELECT * FROM in_category WHERE inc_id=$incid1");
            $Income=mysql_fetch_array($expenselist);
            $category=$Income['in_category'];
           
           
           $date=$row['date_day']."/".$row['date_month']."/".$row['date_year'];
           $title=$row['title'];
           $desc=$row['des'];
            $r_no=$row['r_no'];
            
            $paid_amount=number_format($row['amount'],2);
           
          
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $category);  $column++;
 
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $r_no);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $date); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $title);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $desc);  $column++;
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rs.".$paid_amount);  $column++;
         
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Income Report");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Income_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
