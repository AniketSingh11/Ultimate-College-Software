<?php
require("../includes/config.php");

 
  $fromdate=$_GET["from_date"];
                   $todate=$_GET["to_date"];
                   
                   $fo=explode("/",$fromdate);
                   $from_date=$fo[2]."-".$fo[1]."-".$fo[0];
                   $to=explode("/",$todate);
                   $to_date=$to[2]."-".$to[1]."-".$to[0];
                  
                     $filter=$_GET["filter"];
                   
                   if($filter=="join_student")
                   {  
                       $result="select * from hms_student_room  where 	status='0' and  join_date <= '$to_date' and join_date >= '$from_date'  order by category asc";
                       $result=mysql_query($result);
                        $takeid="admission_number";
                       	$type_format="Join";
                       	$type_value="join_date";
                       	$person="student";
                   }elseif ($filter=="vacate_student")
                   {
                       
                         $result="select * from hms_student_room  where 	status='1' and  vacate_date <= '$to_date' and vacate_date >= '$from_date'  order by category asc";
                         $result=mysql_query($result);
                         $takeid="admission_number";
                         $type_format="Vacate";
                         $type_value="vacate_date";
                         $person="student";
                   }elseif ($filter=="join_staff"){
                      
                       $takeid="staff_id";
                       $type_format="Join";
                       $type_value="join_date";
                       $person="staff";
                     $result="select * from hms_staff_room  where 	status='0' and  join_date <= '$to_date' and join_date >= '$from_date'  order by category asc";
                     $result=mysql_query($result);
                       
                   }else{
                       
                       $takeid="staff_id";
                       $type_format="Vacate";
                       $type_value="vacate_date";
                       $person="staff";
                      $result="select * from hms_staff_room  where 	status='1' and  vacate_date <= '$to_date' and join_date >= '$from_date'  order by category asc";
                
                      $result=mysql_query($result);
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
        
        
        if($person=="student")
        {
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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Hostel Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Floor");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Room Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Beds&Cart");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admission Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Section");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);cellFont("H1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$type_format Date");;$column++;
        
          $objPHPExcel->getActiveSheet()->getColumnDimension('i')->setWidth(20);cellFont("i1","Calibri");
        
        $column++;
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 2;
       
        while($emp_display = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
            $hsr_id=$emp_display["hsr_id"];
										    
										    $floor=$emp_display["floor"];
										    $category=$emp_display["category"];
										    $hr_id=$emp_display["hr_id"];
										    $hrc_id=$emp_display["hrc_id"];
										    
										    $res=mysql_query("select * from hms_category where h_id='$category'");
										    $row=mysql_fetch_array($res);
										    $hostel_name=$row["h_name"];
										    
										    $res=mysql_query("select * from hms_floor where hf_id='$floor'");
										    $row=mysql_fetch_array($res);
										    $floor_name=$row["floor_name"];
										    

										    $res=mysql_query("select * from hms_room where hr_id='$hr_id'");
										    $row=mysql_fetch_array($res);
										    $room_number=$row["room_number"];
										    
										    $res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
										    $row=mysql_fetch_array($res);
										    $cart_name=$row["cart_name"];
										     
										  
										      $q_date=date("d/m/Y",strtotime($emp_display["$type_value"]));
										    $student_number=$emp_display["admission_number"];
										     
										    
										    $res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
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
										    
          
            
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $hostel_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $floor_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $room_number);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cart_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $student_number);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $firstname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $class_name); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $section_name);  $column++;
  
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $q_date);    $column++;
             
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("Student Datewise Hostel Report");
        
        }else{

        
        //$objPHPExcel->createSheet(1);
        
        //  Attach the newly-cloned sheet to the $objPHPExcel workbook
         
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
          $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Hostel Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Floor");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Room Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Beds&Cart");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Number");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Staff Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F1","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$type_format Date");cellFont("F1","Calibri");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);cellFont("G1","Calibri");
        
        $column++;
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 2;

     //   $result=mysql_query("SELECT * FROM hms_staff_room  where $type='$id' and status='0' order by category desc");
        	
        while($emp_display = mysql_fetch_array($result))
        
        {
            $column = 'A';
        
            $hsr_id=$emp_display["hsr_id"];
            
            $floor=$emp_display["floor"];
            $category=$emp_display["category"];
            $hr_id=$emp_display["hr_id"];
            $hrc_id=$emp_display["hrc_id"];
            
            $res=mysql_query("select * from hms_category where h_id='$category'");
            $row=mysql_fetch_array($res);
            $hostel_name=$row["h_name"];
            
            $res=mysql_query("select * from hms_floor where hf_id='$floor'");
            $row=mysql_fetch_array($res);
            $floor_name=$row["floor_name"];
            
            
            $res=mysql_query("select * from hms_room where hr_id='$hr_id'");
            $row=mysql_fetch_array($res);
            $room_number=$row["room_number"];
            
            $res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
            $row=mysql_fetch_array($res);
            $cart_name=$row["cart_name"];
            	
            
           $q_date=date("d/m/Y",strtotime($emp_display["$type_value"]));
            
            $staff_id=$emp_display["staff_id"];
            $firstname=$emp_display["firstname"];
        
        
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $hostel_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $floor_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $room_number);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $cart_name);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staff_id);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $firstname);  $column++;
            
  
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $q_date);    $column++;
             
           
            $rowCount++;
        
        }
        $objPHPExcel->getActiveSheet()->setTitle("Staff Datewise Hostel Report");
        
        }
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="DatewiseHostel_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
