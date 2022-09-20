<?php
require("../includes/config.php");

 
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

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

$filter=$_GET['filt'];
 
if($filter!=""){
    $result=mysql_query("SELECT * FROM lms_book   where category='$filter' and status='0' and specimen='1' order by b_id desc") or die(mysql_error());
  
}else{
        $result=mysql_query("SELECT * FROM lms_book  where status='0' and specimen='1' order by b_id desc") or die(mysql_error());
}
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Category");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Author name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Publisher");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Book Count");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Purchase Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
       
        
        
        $column++;
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
        while($emp_display = mysql_fetch_array($result))
        
        {
            $column = 'A';
            $b_id=$emp_display["b_id"];
            $res=mysql_query("select * from lms_category where c_id='$emp_display[category]'");
            $row=mysql_fetch_array($res);
            $cat_name=$row["category_name"];
            	
            
            $query1="select  * from `lms_book_snumber` where  b_id='$b_id' and   status='0'";
            $res1=mysql_query($query1) or die(mysql_error());
            $book_number="";
            while($row1=mysql_fetch_array($res1))
            {
                 
                $book_number.=$row1["ibs_id"]." ,";
                 
            }
            $book_number=rtrim($book_number,",");         
            
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cat_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $book_number);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["book_title"]);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["author_name"]);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["publisher"]);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["qty"]); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display["purchase_date"]); $column++;
                $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Library Book Report");
        

       // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=overall_speciman_Book_report-list.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
