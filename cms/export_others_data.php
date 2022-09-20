<?php
require("includes/config.php");

 
 
 

   
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
        
        $qry=mysql_query("SELECT * FROM others_category order by category_name asc");
       $count=0;
        while($res=mysql_fetch_array($qry))
        {
        $oc_id=$res["oc_id"];
        $category_name=$res['category_name'];
        // Set the active Excel worksheet to sheet 0
        if($count!="0"){
        $objPHPExcel->createSheet($count);}
        
        $objPHPExcel->setActiveSheetIndex($count);
        
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Other Id");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "First Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Last Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Father Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "DOB");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Gender");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Religion");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Email");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);cellFont("H1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Contact No");;$column++;
        
          $objPHPExcel->getActiveSheet()->getColumnDimension('i')->setWidth(20);cellFont("i1","Calibri");
          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Address");;$column++;
          $objPHPExcel->getActiveSheet()->getColumnDimension('j')->setWidth(20);cellFont("j1","Calibri");
          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "City");;$column++;
          $objPHPExcel->getActiveSheet()->getColumnDimension('k')->setWidth(20);cellFont("k1","Calibri");
          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pincode");;$column++;
          
          $objPHPExcel->getActiveSheet()->getColumnDimension('l')->setWidth(20);cellFont("l1","Calibri");
          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Country");;$column++;
          $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);cellFont("m1","Calibri");
        $column++;
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 2;
        $result=mysql_query("select * from others where category_id='$oc_id'");
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
            $othersid=stripslashes($row['others_id']);
            $fname=stripslashes($row['fname']);
            $lname=stripslashes($row['lname']);
            $s_pname=stripslashes($row['s_pname']);
            
            $dob=stripslashes($row['dob']);
            $gender=stripslashes($row['gender']);
            
            $reg=stripslashes($row['reg']);
            $email=stripslashes($row['email']);
            $phone_no=stripslashes($row['phone_no']);
            $address1=stripslashes($row['address1']);
            $city=stripslashes($row['city']);
            $pincode=stripslashes($row['pincode']);
            $country=stripslashes($row['country']);
            
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $othersid);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $fname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $lname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $s_pname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $dob);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $gender); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $reg);  $column++;
  
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $email);   $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $phone_no);   $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $address1);   $column++;
           
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $city);   $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $pincode);   $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $country);   $column++;
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("$category_name");
        $count=$count+1;
        }
        
     
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Other Members-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
