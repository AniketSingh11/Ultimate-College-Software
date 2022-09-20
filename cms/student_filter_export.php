<?php
require("includes/config.php");
error_reporting(0);

$qry=mysql_fetch_assoc(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$query=mysql_fetch_assoc(mysql_query("select * from typelist_student"));
$type_list=$query["type_list"];
$setting_on=$type_list;


if($setting_on==1)
{
    $setting_field="'M','F'";
    
}else{
    
    $setting_field="'F','M'";
    
}

 
$cid=mysql_real_escape_string($_POST['cid']);
$sid=mysql_real_escape_string($_POST['sid']);
$bid=mysql_real_escape_string($_POST['bid']);
$ayid=mysql_real_escape_string($_POST['ayid']);
$filter=mysql_real_escape_string($_POST['filter']);
$download_type=mysql_real_escape_string($_POST['download_format']);
//$filter_value=mysql_real_escape_string($_POST['filter_value']);

//echo $sid;




$class_name=$cid;
$section_name=$sid;


 
$down_field="";
foreach ($_POST['down_id'] as $val)
{

    $down_field.=$val.",";
}

if (strpos($down_field,"$filter") !== false) {
    
}else{
    if($filter!="All"){
    $down_field.=$filter.",";
    
    $down_field=str_replace("fdis_id","fdis_id AS StudentCategory","$down_field");
    }
}



$filter_value="";
foreach ($_POST['filter_value'] as $fval)
{
 // array_push($fil_val,$fval);
 
    
    $filter_value.="'".$fval."'".",";
    
    
    
    if($fval=="All"){

        $qry = mysql_query("SELECT distinct $filter  FROM student where ay_id='$ayid' and b_id='$bid'");
        while($row=mysql_fetch_assoc($qry))
        {
            $filter_value.="'".$row[$filter]."'".",";
        }   
        
    }
}

 
 
$filter_value=rtrim($filter_value,",");
//echo $down_field."<br>";
$down_field=trim($down_field ,",");


if($filter=="All"){

 $sql = "SELECT $down_field FROM student where  `b_id`='$bid' AND `ay_id`='$ayid'";
    
}else{

$sql = "SELECT $down_field FROM student where  `b_id`='$bid' AND `ay_id`='$ayid'  AND $filter in ($filter_value)";
}

if($cid!="All"){
    
    $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
    $section=mysql_fetch_assoc($sectionlist);
    $class_name=$section["c_name"];
   
    $sql.=" and c_id='$cid'";
}


if($sid!="All"){
    $sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
    $section=mysql_fetch_assoc($sectionlist);
    $section_name=$section["s_name"];
    
    
    $sql.=" and s_id='$sid'";

}

 

switch ($download_type) {
    case "CSV":
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=student-list($class_name-$section_name).csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        

        if($filter=="All"){
            $query=mysql_query($sql." ORDER BY FIELD(gender,$setting_field),firstname ASC");
        }else{
            $query=mysql_query($sql." ORDER BY FIELD(gender,$setting_field),FIELD($filter,$filter_value),firstname ASC");
            
        }
       // $sql = "SELECT $down_field FROM student where  `b_id`='$bid' AND `ay_id`='$ayid'";
     
        //die();
        $content = '';
        $title = "$school_name";
        $title.= "\n";
        $title.= 's.no,';
        $count=1;
        while($rs = mysql_fetch_row($query)) {
            
            if($count==1){
                for($i=0;$i<=count($rs);$i++){
                $title.= mysql_field_name($query,$i). ',';
                }
            }
            
            $content .= '"'.stripslashes($count). '",';

            for($i=0;$i<=count($rs);$i++){ 
                
                if(mysql_field_name($query,$i)=="fdis_id" || mysql_field_name($query,$i)=="StudentCategory"){
                     
                    $qry1=mysql_fetch_assoc(mysql_query("select fdis_name from fdiscount where fdis_id='$rs[$i]'"));
                    $content .= '"'.$qry1[fdis_name]. '",';
                }else if(mysql_field_name($query,$i)=="sp_id" || mysql_field_name($query,$i)=="StoppingPoint"){
                     
                    $qry2=mysql_fetch_assoc(mysql_query("select stop_name from trstopping where stop_id='$rs[$i]'"));
                    $content .= '"'.$qry2[stop_name]. '",';
                }else if(mysql_field_name($query,$i)=="c_id" || mysql_field_name($query,$i)=="Class"){
					
                    $qry3=mysql_fetch_assoc(mysql_query("select c_name from class where c_id='$rs[$i]'"));
                    $content .= '"'.$qry3[c_name]. '",';
                }else if(mysql_field_name($query,$i)=="s_id" || mysql_field_name($query,$i)=="Section"){
					
                    $qry4=mysql_fetch_assoc(mysql_query("select s_name from section where s_id='$rs[$i]'"));
                    $content .= '"'.$qry4[s_name]. '",';
                }else{
            
            $content .= '"'.stripslashes($rs[$i]). '",';
               }
           
            }
            $content .= "\n";
            $count++;
        }
        
        
        
        $title .="\n";
        //$title .= "s.no,Admin No,First Name of Pupil,Middle Name of Pupil,Last Name of Pupil ,Name of Parent / Guardian,Occupation of Parent or Guardian,Standard & School from which pupil has come,Whether an ESLC issued by the Dept. was produced on admission,Whether a T.C. from a secondary school was produced on admission,Date of admission,Date Of Birth,Gender,Whether protected from small-pox or not,Nationality & state to which the pupil belongs,Religion,Caste,Subcaste,Blood Group,Email,Phone,Residence Address1,Residence Address2,Town or village Name,Country ,Pin Code,Mother Tongue of the Pubil,Std. on leaving,No. & Date of Transfer Certificate produced ,Date of leaving,Reason for leaving,School to which the pubil has gone,Remarks"."\n";
        echo $title;
        echo $content;
        break;
        
    case "EXCEL":
      //  $result = mysql_query("SELECT photo,admission_number AS AdmissionNo,firstname,lastname,fathersname,fathersocupation,p_income AS Income,m_name AS MotherName,m_occup AS MotherOccuption ,m_income AS MotherIncome ,doa,dob,gender,nation,reg,caste,sub_caste,blood,email,phone_number,address1,address2,city_id AS City,country,pin,mother_tongue,height,weight,remarks,stype FROM student  where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'");
        if($filter=="All"){
            $result = mysql_query($sql."ORDER BY FIELD(gender,$setting_field),firstname ASC");
        }else{
            $result = mysql_query($sql."ORDER BY FIELD(gender,$setting_field),FIELD($filter,$filter_value),firstname ASC");
        }
        
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
        
         for ($i = 0; $i < mysql_num_fields($result); $i++)
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
        
            for($j=0; $j<=mysql_num_fields($result);$j++)
            {
                if(!isset($row[$j]))
        
                    $value = NULL;
        
                elseif ($row[$j] != "")
        
                $value = strip_tags($row[$j]);
                
                 else
        
                    $value = "";
                 
                 if(mysql_field_name($result,$j)=="StudentCategory"){
                     $qry1=mysql_fetch_assoc(mysql_query("select fdis_name from fdiscount where fdis_id='$value'"));
                     $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $qry1[fdis_name]);
                 }else if(mysql_field_name($result,$j)=="StoppingPoint"){
                     
                    $qry2=mysql_fetch_assoc(mysql_query("select stop_name from trstopping where stop_id='$value'"));
                    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $qry2[stop_name]);
                }else if(mysql_field_name($result,$j)=="Class"){
                     
                    $qry3=mysql_fetch_assoc(mysql_query("select c_name from class where c_id='$value'"));
                    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $qry3[c_name]);
                }else if(mysql_field_name($result,$j)=="Section"){
                     
                    $qry4=mysql_fetch_assoc(mysql_query("select s_name from section where s_id='$value'"));
                    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $qry4[s_name]);
                }else{
                     $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
                 }
              
                $column++;
            }
        
            $rowCount++;
        }
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=student-list($class_name-$section_name).xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        
        break;
        
    default:
        echo "Download Failed!!!";
}
 
?>
