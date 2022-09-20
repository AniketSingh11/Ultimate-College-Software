<?php
require("../includes/config.php");

 
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


$bid=mysql_real_escape_string($_GET['b_id']);
$ayid=mysql_real_escape_string($_GET['ay_id']);
 
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$ayid'");
$ay=mysql_fetch_array($ayear);
$acyear_name=$ay['y_name'];


        $result = mysql_query("SELECT distinct student_id from lms_student_borrowbook  where  ay_id='$ayid' and  b_id='$bid' and   status='1' and fine_amount!='0' and  paid_status='0'") or die(mysql_error());
        require_once '../Classes/PHPExcel.php';
        

        require_once '../Classes/PHPExcel/IOFactory.php';

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
       
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Admission Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
         $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class");$column++;
         $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Section");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Fine Amount");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Academic Year");;$column++;
        
          $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
        
        $column++;
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
           
            $student_id=$row["student_id"];
          
            $status="Pending";
         if($status==0){
                $status="Pending";  $color="E91A1A";}
           else{
                $status="Closed";
                 $color="1AE943";}
          
            	
            $res=mysql_query("select * from student where ss_id='$student_id'");
            $row1=mysql_fetch_array($res);
            $student_number=$row1["admission_number"];
            $firstname=$row1["firstname"];
            $c_id=$row1["c_id"];
            $section_id=$row1["s_id"];
            
            $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
            $res=mysql_fetch_array($query);
            $class_name=$res["c_name"];
            	
            $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
            $res=mysql_fetch_array($query);
            $section_name=$res["s_name"];
            $qry1=mysql_fetch_array(mysql_query("select sum(fine_amount) as total from  lms_student_borrowbook  where student_id='$student_id' and ay_id='$ayid' and  b_id='$bid' and  status='1' and fine_amount!='0' and  paid_status='0'"));
            $fine_amount=$qry1["total"];
            
            $fineamount=number_format($fine_amount,2);

             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student_number);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $firstname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class_name); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $section_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fineamount);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status); cellColor($column.$rowCount, $color);   $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acyear_name);   $column++;
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Student Fine  Report");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pending_StudentFine_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
