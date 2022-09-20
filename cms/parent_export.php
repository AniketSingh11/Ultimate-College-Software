<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));

$school_name=$qry["sc_name"];

$cid=mysql_real_escape_string($_POST['cid']);
$sid=mysql_real_escape_string($_POST['sid']);
$bid=mysql_real_escape_string($_POST['bid']);
$ayid=mysql_real_escape_string($_POST['ayid']);
$download_type=mysql_real_escape_string($_POST['download_format']);


$sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
$section=mysql_fetch_array($sectionlist);
$class_name=$section["c_name"];

$sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
$section=mysql_fetch_array($sectionlist);
$section_name=$section["s_name"];
	
if(empty($cid)){  $class_name="All"; }
if(empty($sid)){  $section_name="All"; }

switch ($download_type) {
    case "CSV":

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=parent-list($class_name-$section_name).csv");
header("Pragma: no-cache");
header("Expires: 0");

	
	 
$sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid' AND user_status='1'";
$query = mysql_query($sql);
//die();
$content = '';
$title = "$school_name";
        $title.= "\n";
$count=1;
while($rs = mysql_fetch_array($query)) { 
	$content .= '"'.stripslashes($count). '",';
	$content .= '"'.stripslashes($rs["admission_number"]). '",';
	$content .= '"'.stripslashes($rs["firstname"]." ".$rs["middlename"]." ".$rs["lastname"]). '",';
	$content .= '"'.stripslashes($rs["fathersname"]). '",';
	$content .= '"'.stripslashes($rs["fathersocupation"]). '",';
	$content .= '"'.stripslashes($rs["email"]). '",';
	$content .= '"'.stripslashes($rs["phone_number"]). '",';
	$content .= '"'.stripslashes($rs["address1"]). '",';
	$content .= '"'.stripslashes($rs["address2"]). '",';
	$content .= '"'.stripslashes($rs["city_id"]). '",';
	$content .= '"'.stripslashes($rs["country"]). '",';
	$content .= '"'.stripslashes($rs["pin"]). '",';
	$content .= '"'.stripslashes($rs["mother_tongue"]). '",';
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Admin No,Student Name,Name of Parent,Occupation,Email,Phone,Residence Address1,Residence Address2,City,Country ,Pin Code,Mother Tongue"."\n";
echo $title;
echo $content;
break;
case "EXCEL":
    
    
    $result = mysql_query("SELECT photo,admission_number,firstname,lastname,fathersname,fathersocupation,email,phone_number,address1,address2,city_id as City,country,pin,mother_tongue FROM student  where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'");
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
                header("Content-Disposition: attachment;filename=parent-list($class_name-$section_name).xls");
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
    
        break;
    
    default:
        echo "Download Failed!!!";
}
?>
