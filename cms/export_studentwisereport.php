<?php
require("includes/config.php");

 
$b_id=mysql_real_escape_string($_GET['b_id']);
$cid=$_GET['cid'];
$sid=$_GET['sid'];
$ayid=mysql_real_escape_string($_GET['ay_id']);
 
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$ayid'");
$ay=mysql_fetch_array($ayear);
$acyear_name=$ay['y_name'];


        $result = mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$ayid ORDER BY firstname ASC ") or die(mysql_error());
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admin No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Parent's name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Section");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "DOB");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Gender");$column++;
      
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
     
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Phone");$column++;
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Religion");$column++;
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);cellFont("I2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Academic Year");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);cellFont("J2","Calibri");
        
        
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
           
            $c_id=$row["c_id"];
            $section_id=$row["s_id"];
            
            $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
            $res=mysql_fetch_array($query);
            $class_name=$res["c_name"];
            	
            $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
            $res=mysql_fetch_array($query);
            $section_name=$res["s_name"];
          
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['admission_number']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['firstname']." ".$row['middlename']." ".$row['lastname']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  $row['fathersname']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class_name); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $section_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['dob']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['gender']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['phone_number']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['reg']);  $column++;
             
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             
        
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acyear_name);   $column++;
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle($class_name."-".$section_name."Student Report");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$class_name-$section_name-Studentreport-list.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
