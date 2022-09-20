<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

	  $ayid=mysql_real_escape_string($_POST['ayid']);
	  $mid=mysql_real_escape_string($_POST['mid']);
	  $download_type=mysql_real_escape_string($_POST['download_format']);
	  
	  switch ($download_type) {
	      case "CSV":
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=staff-sattendance.csv");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM staff";
$query = mysql_query($sql);
//die();
$content = '';
$title = "$school_name";
        $title.= "\n";
$count=1;
while($rs = mysql_fetch_array($query)) { 
	
	$stid=$rs['st_id'];   	
								   
	$content .= '"'.stripslashes($count). '",';
	$content .= '"'.stripslashes($rs["staff_id"]). '",';
	$content .= '"'.stripslashes($rs["fname"]." ".$rs["mname"]." ".$rs["lname"]). '",';
	$content .= '"'.stripslashes($rs["s_type"]). '",';
		$studentlist=mysql_query("SELECT * FROM sattendance WHERE `m_id`='$mid' AND `ay_id`='$ayid' AND `st_id`='$stid' ORDER BY day"); 
		$chk=0;$present=0;$absent=0;$absentoff=0;$workday=0;
		while($staff=mysql_fetch_array($studentlist)){
		    $chk=1;
			$result1=$staff['result'];			
			if($result1=='1'){
		$content .= '"'.stripslashes("P"). '",';
		$present++;
			}else if($result1=='0'){
		$content .= '"'.stripslashes("A"). '",';
		$absent++;
		}else{
			$content .= '"'.stripslashes("OFF"). '",';
			$absentoff++;
		}
		$workday++;
		//$total =$total + $result['mark'];
		}
		if($chk==0){
		
		    $studentlist1=mysql_query("SELECT distinct day FROM sattendance WHERE `m_id`='$mid' AND `ay_id`='$ayid' ORDER BY day");
		    while($staff1=mysql_fetch_array($studentlist1)){
		        $content .= "-". ',';
		    }
		}
		
		
		$op=$absentoff*.5;
		$persent=0;
		if($workday){
					$persent=round((($present+$op)/$workday)*100,2);
		}
	$content .= '"'.stripslashes($workday). '",';	
	$content .= '"'.stripslashes($present). '",';	
	$content .= '"'.stripslashes($absent). '",';	
	$content .= '"'.stripslashes($absentoff). '",';	
	$content .= '"'.stripslashes($persent). '",';	
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Staff ID,Student Name,Staff Type". ',';
$studentlist1=mysql_query("SELECT distinct day FROM sattendance WHERE `m_id`='$mid' AND `ay_id`='$ayid' ORDER BY day"); 
while($staff1=mysql_fetch_array($studentlist1)){
	$title .= stripslashes($staff1['day']). ',';
}
$title .= "Total Working day,Present,Absent,Offday Absent,Percentage". ',';
$title .= "\n";
echo $title;
echo $content;

break;
case "EXCEL":


$result = mysql_query("SELECT st_id,staff_id,fname,lname,s_type as TeachingType FROM staff WHERE status='1'");
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


$studentlist1=mysql_query("SELECT distinct day FROM sattendance WHERE `m_id`='$mid' AND `ay_id`='$ayid' ORDER BY day");
while($staff1=mysql_fetch_array($studentlist1)){
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staff1['day']);
    $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");
    $column++;
}

$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Working day"); $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Present"); $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Absent"); $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Halfday Absent"); $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");$column++;
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Percentage"); $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");$column++;
$column++;

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

$rowCount = 3;

$sql = "SELECT * FROM staff";
$query = mysql_query($sql);
//die();
$content = '';
$title = '';
$count=1;
while($rs = mysql_fetch_array($query)) {
    $column = 'E';
   	$stid=$rs['st_id'];   	

$studentlist=mysql_query("SELECT * FROM sattendance WHERE `m_id`='$mid' AND `ay_id`='$ayid' AND `st_id`='$stid' ORDER BY day"); 
		$chk=0;$present=0;$absent=0;$absentoff=0;$workday=0;
		while($staff=mysql_fetch_array($studentlist)){
		    $chk=1;
			$result1=$staff['result'];			
			if($result1=='1'){
		$content .= stripslashes("P"). ',';
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes("P"));  $column++;
		$present++;
			}else if($result1=='0'){
		$content .= stripslashes("A"). ',';
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  stripslashes("A"));  $column++;
		$absent++;
		}else{
		    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,  stripslashes("OFF"));  $column++;
			$content .= stripslashes("OFF"). ',';
			$absentoff++;
		}
		$workday++;
		//$total =$total + $result['mark'];
		}

    if($chk==0){

        $studentlist1=mysql_query("SELECT distinct day FROM sattendance WHERE `m_id`='$mid' AND `ay_id`='$ayid' ORDER BY day");
        while($staff1=mysql_fetch_array($studentlist1)){
            $content .= "-". ',';
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "-");
            $column++;
        }
    }

$op=$absentoff*.5;
		$persent=0;
		if($workday){
					$persent=round((($present+$op)/$workday)*100,2);
		}
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($workday));
    $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($present));  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($absent));  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($absentoff));  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($persent));  $column++;

    $content .= stripslashes($workday). ',';
    $content .= stripslashes($present). ',';
    $content .= stripslashes($absent). ',';
    $content .= stripslashes($absentoff). ',';
    $content .= stripslashes($persent). ',';
    $content .= "\n";
    $count++;
    $rowCount++;
}

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="staff-sattendance.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

default:
    echo "Download Failed!!!";
}




?>
