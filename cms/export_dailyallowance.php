<?php
require("includes/config.php");


$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


    $stype=$_GET['s_type'];
	
$sdate=$_GET['s_date'];
$date_split1=explode('/', $sdate);
$s_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
$edate=$_GET['e_date'];
$date_split1=explode('/', $edate);
$e_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
 
 
 
  $querylist="SELECT * FROM exp_allowance where d_id!='' ";
                            if($stype){
                                $querylist.=" AND type='$stype' ";
                            }
                           if($sdate && $edate){
                    	$querylist.=" AND ((from_date >= '$s_date' and from_date <= '$e_date') or (to_date >= '$s_date' and to_date <= '$e_date')) ";
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Receipt No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
    
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "ID");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Start Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "End Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Days");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Amount");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
           $member_id=$row["id"];
           $rec= $row['receipt_no'];
           $name=$row['name'];
           $type=$row['type'];
           $working_days=$row['working_days'];
           $tot=$row['total_amount'];
           $fromdate=$row["from_date"];
           $date_split1=explode('-', $fromdate);
            
           $from_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
           $todate=$row["to_date"];
           $date_split1=explode('-', $todate);
           
           $to_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
           
           $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $rec);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $member_id);  $column++;
 
            
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $name); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $type);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $from_date);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $to_date);  $column++;
             
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $working_days);  $column++;
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rs.".$tot);  $column++;
         
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Daily Allowance Report");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="DailyAllowance_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
