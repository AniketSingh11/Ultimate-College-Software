<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$cid=mysql_real_escape_string($_POST['cid']);
	 $sid=mysql_real_escape_string($_POST['sid']);
	  $bid=mysql_real_escape_string($_POST['bid']);
	  $ayid=mysql_real_escape_string($_POST['ayid']);
	  $eid=mysql_real_escape_string($_POST['eid']);
	  $download_type=mysql_real_escape_string($_POST['download_format']);
	   
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
	   switch ($download_type) {
	      case "CSV":	  
	  
	$slist=0;  

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Student-mark-report($class_name-$section_name).csv");
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
	
	$ssid=$rs['ss_id'];   	
								   
	$content .= '"'.stripslashes($count). '",';
	$content .= '"'.stripslashes($rs["admission_number"]). '",';
	$content .= '"'.stripslashes($rs["firstname"]." ".$rs["middlename"]." ".$rs["lastname"]). '",';
		$studentlist=mysql_query("SELECT * FROM subject WHERE `c_id`='$cid' AND `s_id`='$sid' AND `ay_id`='$ayid'"); 
		$total=0;
		while($staff=mysql_fetch_array($studentlist)){
			$subid=$staff['sub_id'];
			$slid=$staff['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
					 $paper=$slist['paper'];
			if($paper=='1'){
			$resultlist=mysql_query("SELECT * FROM result WHERE `sub_id`='$subid' AND `ss_id`='$ssid' AND `e_id`='$eid'"); 
								  $result=mysql_fetch_array($resultlist);
								//echo   $mark=$result['mark'];
								//echo $mark1=$result['mark1'];
								//echo $tot=$mark+$mark1;
	$content .= '"'.stripslashes($mark." - ".$mark1." = ".$tot). '",';
		$total =$total + $tot;
			}else {
				$resultlist=mysql_query("SELECT * FROM result WHERE `sub_id`='$subid' AND `ss_id`='$ssid' AND `e_id`='$eid'"); 
								  $result=mysql_fetch_array($resultlist);
	$content .= '"'.stripslashes($result['mark']). '",';
		$total =$total + $result['mark'];				
			}
		}
	$content .= '"'.stripslashes($total). '",';	
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Admin No,Student Name". ',';
if($slist){
$studentlist1=mysql_query("SELECT * FROM subject WHERE `c_id`='$cid' AND `s_id`='$sid' AND `ay_id`='$ayid'"); 
while($staff1=mysql_fetch_array($studentlist1)){
	$title .= '"'.stripslashes($slist['s_name']). '",';
}
}
$title .= "Total". ',';
$title .= "\n";
echo $title;
echo $content;
break;
case "EXCEL":
    
    $result = mysql_query("SELECT photo,admission_number,firstname,lastname FROM student  where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'");
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
    
    $studentlist1=mysql_query("SELECT * FROM subjectlist WHERE `c_id`='$cid' AND `s_id`='$sid' AND `ay_id`='$ayid'");
    while($staff1=mysql_fetch_array($studentlist1)){
         $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $staff1['s_name']);
         $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");
         $column++;
    }
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total");
    $objPHPExcel->getActiveSheet()->getColumnDimension("$column")->setWidth(20);cellFont($column."2","Calibri");
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
      
        $rowCount = 2;

        $sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'";
        $query = mysql_query($sql);
        //die();
        $content = '';
        $title = '';
        $count=1;
        while($rs = mysql_fetch_array($query)) {
            $column = 'D';
            $ssid=$rs['ss_id'];
          
           // $content .= stripslashes($count). ',';
           // $content .= stripslashes($rs["admission_number"]). ',';
           // $content .= stripslashes($rs["firstname"]." ".$rs["middlename"]." ".$rs["lastname"]). ',';
            $studentlist=mysql_query("SELECT * FROM subject WHERE `c_id`='$cid' AND `s_id`='$sid' AND `ay_id`='$ayid'");
            $total=0;
            while($staff=mysql_fetch_array($studentlist)){
              
                
                $subid=$staff['sub_id'];
                $slid=$staff['sl_id'];
                $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'");
                $slist=mysql_fetch_array($subjectlist1);
                $paper=$slist['paper'];
                if($paper=='1'){
                    $resultlist=mysql_query("SELECT * FROM result WHERE `sub_id`='$subid' AND `ss_id`='$ssid' AND `e_id`='$eid'");
                    $result=mysql_fetch_array($resultlist);
                    //echo   $mark=$result['mark'];
                    //echo $mark1=$result['mark1'];
                    //echo $tot=$mark+$mark1;
                    $content .= stripslashes($mark." - ".$mark1." = ".$tot). ',';

                    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($mark." - ".$mark1." = ".$tot));
                   
                   
                    $total =$total + $tot;
                }else {
                    $resultlist=mysql_query("SELECT * FROM result WHERE `sub_id`='$subid' AND `ss_id`='$ssid' AND `e_id`='$eid'");
                    $result=mysql_fetch_array($resultlist);
                    $content .= stripslashes($result['mark']). ',';
                    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($result['mark']));
                   
                    
                    $total =$total + $result['mark'];
                }
                $column++;
               
            }
            $content .= stripslashes($total). ',';
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, stripslashes($total));
            $content .= "\n";
            $count++;
            $rowCount++;
        }
       
        // Redirect output to a client???s web browser (Excel5)
        header("Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename=Student-mark-report($class_name-$section_name).xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
    
    break;
    
    default:
        echo "Download Failed!!!";
    }
   
?>
