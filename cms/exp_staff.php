<?php
require("includes/config.php");
$type=mysql_real_escape_string($_GET['type']);
$download_type=mysql_real_escape_string($_GET['download_format']);


$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

switch ($download_type) {
    case "EXCEL":

$result = mysql_query("select st_id,staff_id,fname as FirstName,mname as MiddleName,lname as LastName,s_type as TeachingType,s_pname as FatherName,dob,gender,reg,blood,position,expriences,email,phone_no,address1,address2,city,country,pincode,r_id,sp_id FROM staff where `s_type`='$type' AND status=1");
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

$rowCount =2;

$objPHPExcel->getActiveSheet()->setCellValue("D1"," $school_name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(50);cellFont("D1","Calibri");
//start of printing column names as names of MySQL fields

$column = 'A';

 
for ($i = 1; $i < mysql_num_fields($result); $i++)

{
     if(mysql_field_name($result,$i)=="r_id"){
         
         $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bus Route");
            ;
     }elseif (mysql_field_name($result,$i)=="sp_id"){
         $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Stopping Point");
         
     }else{
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
     }
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
        if(mysql_field_name($result,$j)=="r_id"){
            
            $qry5=mysql_query("SELECT * FROM route WHERE r_id=$value");
            $row5=mysql_fetch_array($qry5);
             
            $value= stripslashes($row5['r_name']);
            
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
        }elseif (mysql_field_name($result,$j)=="sp_id")
        {
            $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$value");
            $row6=mysql_fetch_array($qry6);
            $value= stripslashes($row6['sp_name']);
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
            
        }

           
            $column++;
            }

            $rowCount++;
            }

            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename='staffs-'.$type.'-report.xls'");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            break;
            case "CSV":
 
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=staffs-$type-report.csv");
header("Pragma: no-cache");
header("Expires: 0");

	 
	 
$sql = "SELECT * FROM staff where `s_type`='$type'";
$query = mysql_query($sql);
//die();
$content = '';
 $title = "$school_name";
        $title.= "\n";
$count=1;
while($rs = mysql_fetch_array($query)) { 
	$content .= stripslashes($count). ',';
	$content .= '"'.stripslashes($rs["staff_id"]). '",';
	$content .= '"'.stripslashes($rs["fname"]). '",';
	$content .= '"'.stripslashes($rs["mname"]). '",';
	$content .= '"'.stripslashes($rs["lname"]). '",';
	$content .= '"'.stripslashes($rs["s_type"]). '",';
	$content .= '"'.stripslashes($rs["s_pname"]). '",';
	$content .= '"'.stripslashes($rs["dob"]). '",';
	$content .= '"'.stripslashes($rs["gender"]). '",';
	$content .= '"'.stripslashes($rs["reg"]). '",';
	$content .= '"'.stripslashes($rs["blood"]). '",';
	$content .= '"'.stripslashes($rs["position"]). '",';
	$content .= '"'.stripslashes($rs["expriences"]). '",';
	$content .= '"'.stripslashes($rs["email"]). '",';
	$content .= '"'.stripslashes($rs["phone_no"]). '",';
	$content .= '"'.stripslashes($rs["address1"]). '",';
	$content .= '"'.stripslashes($rs["address2"]). '",';
	$content .= '"'.stripslashes($rs["city"]). '",';
	$content .= '"'.stripslashes($rs["country"]). '",';
	$content .= '"'.stripslashes($rs["pincode"]). '",';
	
	$rid=$rs['r_id'];
	$spid=$rs['sp_id'];
	if($rid){
	    //$rid1=$invoice['r_id'];
	    $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid");
	    $row5=mysql_fetch_array($qry5);
	  
	                	$content .= stripslashes($row5['r_name']). ',';    
	}
	                 if($spid){
						 $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid"); 
									  $row6=mysql_fetch_array($qry6); 			
	                $content .= stripslashes($row6['sp_name']). ',';
	                
	                } 
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Staff ID,First Name,Middle Name,Last Name,Staff Type,Father's Name,Date Of Birth,Gender,Religion ,Blood Group,Position ,Expriences,Email ,Phone No,Residence Address1,Residence Address2 ,Town or village Name ,Country ,Pin Code,Bus Route,Stopping Point"."\n";
echo $title;
echo $content;

break;

default:
    echo "Download Failed!!!";
}
?>
