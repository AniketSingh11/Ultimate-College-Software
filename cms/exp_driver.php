<?php
require("includes/config.php");
$type=mysql_real_escape_string($_GET['type']);
$download_type=mysql_real_escape_string($_GET['download_format']);


$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

switch ($download_type) {
    case "EXCEL":

$result = mysql_query("select d_id,driver_id,fname as FirstName,lname as LastName,D_type as DriverType,d_pname as FatherName,dob,gender,reg,blood,position,expriences,email,phone_no,address,city,country,pincode FROM driver where `d_type`='$type' AND status=1");
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
            header("Content-Disposition: attachment;filename='Driver-'.$type.'-report.xls'");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            break;
            case "CSV":
 
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Driver-$type-report.csv");
header("Pragma: no-cache");
header("Expires: 0");
	 
$sql = "SELECT * FROM driver where `d_type`='$type' AND status=1";
$query = mysql_query($sql);
//die();
$content = '';
 $title = "$school_name";
        $title.= "\n";
$count=1;
while($rs = mysql_fetch_assoc($query)) { 
	$content .= stripslashes($count). ',';
	$content .= '"'.stripslashes($rs["driver_id"]). '",';
	$content .= '"'.stripslashes($rs["fname"]). '",';
	$content .= '"'.stripslashes($rs["lname"]). '",';
	$content .= '"'.stripslashes($rs["d_type"]). '",';
	$content .= '"'.stripslashes($rs["d_pname"]). '",';
	$content .= '"'.stripslashes($rs["dob"]). '",';
	$content .= '"'.stripslashes($rs["gender"]). '",';
	$content .= '"'.stripslashes($rs["reg"]). '",';
	$content .= '"'.stripslashes($rs["blood"]). '",';
	$content .= '"'.stripslashes($rs["position"]). '",';
	$content .= '"'.stripslashes($rs["expriences"]). '",';
	$content .= '"'.stripslashes($rs["email"]). '",';
	$content .= '"'.stripslashes($rs["phone_no"]). '",';
	$content .= '"'.stripslashes($rs["address"]). '",';
	$content .= '"'.stripslashes($rs["city"]). '",';
	$content .= '"'.stripslashes($rs["country"]). '",';
	$content .= '"'.stripslashes($rs["pincode"]). '",';
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Driver ID,First Name,Last Name,Driver Type,Father's Name,Date Of Birth,Gender,Religion ,Blood Group,Position ,Expriences,Email ,Phone No,Address,City,Country ,Pin Code"."\n";
echo $title;
echo $content;

break;

default:
    echo "Download Failed!!!";
}
?>
