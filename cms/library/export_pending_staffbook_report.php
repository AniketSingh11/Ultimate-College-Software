<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

 
$s_id=mysql_real_escape_string($_GET['s_id']);
$ayid=mysql_real_escape_string($_GET['ay_id']);
 
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$ayid'");
$ay=mysql_fetch_array($ayear);
$acyear_name=$ay['y_name'];


       
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
        
      
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Person Type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);cellFont("F1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Academic Year");;$column++;
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G1","Calibri");
        $column++;
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;

        $result=mysql_query("select * from lms_staff_borrowbook  where   ay_id='$ayid' and status='0'  order by date_time asc");
        	
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
        
            $sb_id=$row["sfb_id"];
            $staff_id=$row["staff_id"];
            $book_id=$row["book_id"];
            $status=$row["status"];
            $book_no=$row["book_number"];
            
            if($status==0){
                $status="Pending";  $color="E91A1A";}
           else{
                $status="Closed";
                 $color="1AE943";}
            $res=mysql_query("select * from lms_book where b_id='$book_id'");
            $row1=mysql_fetch_array($res);
            $book_title=$row1["book_title"];
           
             
            $res=mysql_query("select * from staff where st_id='$staff_id'");
            $row1=mysql_fetch_array($res);
            $staff_number=$row1["staff_id"];
			$fname=$row1["fname"];
			$lname=$row1["lname"];
			$staff_name=$fname." ".$lname;
            $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
            $res=mysql_fetch_array($query);
            $class_name=$res["c_name"];
             
            $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
            $res=mysql_fetch_array($query);
            $section_name=$res["s_name"];
        
        
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $book_no);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $book_title);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff");  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staff_number);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staff_name);  $column++;
            
           $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status);  cellColor($column.$rowCount, $color);  $column++;
           $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acyear_name);   $column++;
           
            $rowCount++;
        
        }
        $objPHPExcel->getActiveSheet()->setTitle("Staff Book Report");
        
        
        // Redirect output to a client???s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pending_StaffBook_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
