<?php
require("../includes/config.php");

$fromdate=$_GET["from_date"];
$todate=$_GET["to_date"];
$filter=$_GET["filter"];
$ayid=mysql_real_escape_string($_GET['ay_id']);

$fo=explode("/",$fromdate);
$from_date=$fo[2]."-".$fo[1]."-".$fo[0];
$to=explode("/",$todate);
$to_date=$to[2]."-".$to[1]."-".$to[0];


//echo $from_date."-".$to_date;
if($filter=="apply")
{  
   $result=mysql_query("select * from lms_student_borrowbook  where ay_id='$ayid' and  start_date <= '$to_date' and start_date >= '$from_date'  order by status asc") or die(mysql_error());

   $result1=mysql_query("select * from lms_staff_borrowbook  where  ay_id='$ayid' and start_date <= '$to_date' and start_date >= '$from_date'     order by status asc") or die(mysql_error());
     
  
     
}elseif ($filter=="renew")
{    $result=mysql_query("select * from  lms_book_renew  where  ay_id='$ayid' and renew_startdate  <= '$to_date' and renew_startdate >= '$from_date' and renew_status='0' ");
     
}elseif ($filter=="return"){
      $result=mysql_query("select * from lms_student_borrowbook  where ay_id='$ayid' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='0' ");
    $result1=mysql_query("select * from lms_staff_borrowbook  where  ay_id='$ayid' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='0' ");
     
     
}else{
     
    $result=mysql_query("select * from lms_student_borrowbook  where ay_id='$ayid' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='1'");
    $result1=mysql_query("select * from lms_staff_borrowbook  where  ay_id='$ayid' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='1' ");
     
     
}
 
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$ayid'");
$ay=mysql_fetch_array($ayear);
$ayid_name=$ay['y_name'];


       
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
 
        $rowCount = 1;
        
        
        //start of printing column names as names of MySQL fields
        
        $column = 'A';
        
     /*   for ($i = 1; $i < mysql_num_fields($result); $i++)
        
        {
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
            $column++;
        }
        */
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Person Type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E1","Calibri");
         $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class");$column++;
         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Section");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);cellFont("H1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Academic Year");;$column++;
        
          $objPHPExcel->getActiveSheet()->getColumnDimension('i')->setWidth(20);cellFont("i1","Calibri");
        
        $column++;
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 2;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
            $sb_id=$row["sb_id"];
            
            
            
            
            $student_id=$row["student_id"];
           
        if($filter=="renew"){
            
            $query="select * from  lms_student_borrowbook where sb_id='$sb_id'";
            $res=mysql_query($query);
            $row=mysql_fetch_array($res);
                $status="Renewed"; $color="1AE943";  }
           else{
              if($row["lost_bookstatus"]==1){ $status="Losted"; $color="E91A1A"; }
              elseif($row["status"]==0){ $status="Pending"; $color="E91A1A";}
              else{
                $status="Closed";
                 $color="1AE943";}
           }
            $book_id=$row["book_id"];
            $res=mysql_query("select * from lms_book where b_id='$book_id'");
            $row1=mysql_fetch_array($res);
            $book_title=$row1["book_title"];
            $book_no=$row1["book_no"];
            	
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
          
            
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $book_no);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $book_title);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student");  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student_number);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $firstname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class_name); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $section_name);  $column++;
  
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $status); cellColor($column.$rowCount, $color);   $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ayid_name);   $column++;
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Student Book Report");
        

        
        $objPHPExcel->createSheet(1);
        
        //  Attach the newly-cloned sheet to the $objPHPExcel workbook
         
        $objPHPExcel->setActiveSheetIndex(1);
        
        // Initialise the Excel row number
        
        $rowCount = 1;
        
        
        //start of printing column names as names of MySQL fields
        
        $column = 'A';
        
        /*   for ($i = 1; $i < mysql_num_fields($result); $i++)
        
        {
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
        $column++;
        }
        */
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Person Type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Status");cellFont("F1","Calibri");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);cellFont("F1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Academic Year");;$column++;
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G1","Calibri");
        $column++;
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 2;

        
        while($row = mysql_fetch_array($result1))
        
        {
            $column = 'A';
        
            $sb_id=$row["sfb_id"];
            $staff_id=$row["staff_id"];
            $status=$row["status"];
            $book_id=$row["book_id"];
        if($row["lost_bookstatus"]==1){ $status="Losted"; $color="E91A1A"; }
              elseif($row["status"]==0){ $status="Pending"; $color="E91A1A";}
              else{
                $status="Closed";
                 $color="1AE943";}
            $res=mysql_query("select * from lms_book where b_id='$book_id'");
            $row1=mysql_fetch_array($res);
            $book_title=$row1["book_title"];
            $book_no=$row1["book_no"];
             
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
           $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $ayid_name);   $column++;
           
            $rowCount++;
        
        }
        $objPHPExcel->getActiveSheet()->setTitle("Staff Book Report");
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="DatewiseBook_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
