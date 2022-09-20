<?php
require("includes/config.php");


$qry=mysql_fetch_array(mysql_query("select * from school_name"));

$school_name=$qry["sc_name"];


$cid=mysql_real_escape_string($_POST['cid']);
$sid=mysql_real_escape_string($_POST['sid']);
$bid=mysql_real_escape_string($_POST['bid']);
$ayid=mysql_real_escape_string($_POST['ayid']);
$download_type=mysql_real_escape_string($_POST['download_format']);

$class_name=$cid;
$section_name=$sid;

if($cid!="All"){
    $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
    $section=mysql_fetch_array($sectionlist);
    $class_name=$section["c_name"];
}
if($sid!="All"){
    $sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
    $section=mysql_fetch_array($sectionlist);
    $section_name=$section["s_name"];
}
$result = mysql_query("SELECT photo,admission_number AS AdmissionNo,firstname,lastname,fathersname,fathersocupation,p_income AS Income,m_name AS MotherName,m_occup AS MotherOccuption ,m_income AS MotherIncome ,doa,dob,gender,nation,reg,caste,sub_caste,blood,email,phone_number,address1,address2,city_id AS City,country,pin,mother_tongue,height,weight,remarks,stype FROM student  where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'");
        require_once 'Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        
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
        // Set the active Excel worksheet to sheet 0
        
        $objPHPExcel->setActiveSheetIndex(0);
        
        // Initialise the Excel row number
        
        $rowCount = 2;
        
        $objPHPExcel->getActiveSheet()->setCellValue("D1"," $school_name ");
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(50);cellFont("D1","Calibri");
        
        //start of printing column names as names of MySQL fields
        
        $column = 'A';
        
        for ($i = 1; $i < mysql_num_fields($result); $i++)
        
        {
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
            $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");
            $column++;
           
        }
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
        
        while($row = mysql_fetch_row($result))
        {
            $column = 'A';
        
            for($j=1; $j<mysql_num_fields($result);$j++)
            {
                if(!isset($row[$j]))
                    $value = NULL;
                elseif ($row[$j] != "")
                $value = strip_tags($row[$j]);
                else
                    $value = "";
                $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
                $column++;
            }
        
            $rowCount++;
        }
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=inactive-student-list($class_name-$section_name).xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
?>
