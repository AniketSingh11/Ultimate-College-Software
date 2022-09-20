<?php
require("includes/config.php");
/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=exponse-report.csv");
header("Pragma: no-cache");
header("Expires: 0");

	 		$sdate=$_GET['sdate'];
			$edate=$_GET['edate'];
			$excid=$_GET['exc_id'];
			
			if(!empty($excid) && $excid!='All') {
					$exclist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid"); 
								  $ecategory=mysql_fetch_array($exclist);
					}
			if($excid=='All'){ 
			$ex_name="All"; } else { 
			$ex_name=$ecategory['ex_category'];
			 }
			
					
					$sdate_split1= explode('/', $sdate);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_day=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		 			
					$edate_split1= explode('/', $edate);		 
		  $edate_month=$edate_split1[0];
		  $edate_day=$edate_split1[1];
		  $edate_year=$edate_split1[2];
		  
		  $enddate= $edate_year.$edate_month.$edate_day;
		  
		  if(!empty($excid) && $excid!='All') {
					$exclist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid"); 
								  $ecategory=mysql_fetch_array($exclist);
					}
	 
	 $qry="SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "'";
							if(!empty($excid) && $excid!='All') { $qry .= " AND exc_id = '" . $excid. "'"; }
							$qry=mysql_query($qry);
//die();
$total=0;
$content = '';
$title = '';
$count=1;
while($rs=mysql_fetch_array($qry)) { 
		$total +=$rs['amount'];
	$amount =$rs["amount"];
	$content .= stripslashes($count). ',';
	$content .= stripslashes($rs["title"]). ',';
	$content .= stripslashes($rs["date_day"]." / ".$rs["date_month"]." / ".$rs["date_year"]). ',';
	$content .= stripslashes($rs["des"]). ',';
	$content .= stripslashes($rs["r_no"]). ',';
	$content .= stripslashes($amount). ',';
	$content .= "\n";
	$count++;	
}
$content .= " Totol : ".$total."\n";
$title .= "Expenses Report ".$ex_name."\n";
$title .= "s.no,Title,Date,Description,Receipt No,Amount"."\n";
echo $title;
echo $content;
*/
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


$sdate=$_GET['sdate'];
$edate=$_GET['edate'];
$excid=$_GET['exc_id'];
 $exsid=$_GET['exs_id'];	
if(!empty($excid) && $excid!='All') {
    $exclist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid");
    $ecategory=mysql_fetch_array($exclist);
}
if($excid=='All'){
    $ex_name="All"; } else {
        $ex_name=$ecategory['ex_category'];
    }
    	
    	
    $sdate_split1= explode('/', $sdate);
    $sdate_month=$sdate_split1[0];
    $sdate_day=$sdate_split1[1];
    $sdate_year=$sdate_split1[2];
    $startdate= $sdate_year.$sdate_month.$sdate_day;

    $edate_split1= explode('/', $edate);
    $edate_month=$edate_split1[0];
    $edate_day=$edate_split1[1];
    $edate_year=$edate_split1[2];

    $enddate= $edate_year.$edate_month.$edate_day;

    if(!empty($excid) && $excid!='All') {
        $exclist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid");
        $ecategory=mysql_fetch_array($exclist);
    }

    $qry="SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "'";
    if(!empty($excid) && $excid!='All') { $qry .= " AND exc_id = '" . $excid. "'"; }

    if($exsid && $exsid!='All'){
        $qry.=" and  exs_id=$exsid";
    }

 

$result = mysql_query($qry) or die(mysql_error());
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
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Sub Category");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Receipt No");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Title");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Description");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");


$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());


//end of adding column names
//start while loop to get data

$rowCount = 3;
 
while($row = mysql_fetch_array($result))

{
    $column = 'A';

    $excid1=$row['exc_id'];
    $exsid=$row['exs_id'];
    $qry1=mysql_fetch_array(mysql_query("select * from ex_subcategory where exs_id='$exsid'"));
  $subcname=$qry1["sub_name"];
            $qry1=mysql_fetch_array(mysql_query("select * from ex_insubcategory where exs_id='$exsid'"));
            $sb_count=$qry1["count"];
            $subcname=$qry1["sub_name"];
            $subcat=array();
            for($j=1;$j<=20;$j++)
            {
            $sub_id=$qry1["sub$j"."_id"];
                	
            if($sub_id!=0){
            array_push($subcat,$sub_id);
            }
            }
            $insub_name="";
            foreach ($subcat as $val){
            	
            $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
            $insub_name.=$qry1["sub_name"].">";
            	
            }
    $expenselist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid1");
    $expenses=mysql_fetch_array($expenselist);
    $category=$expenses['ex_category'];
    $date=$row['date_day']."/".$row['date_month']."/".$row['date_year'];
    $title=$row['title'];
    $desc=$row['des'];
    $r_no=$row['r_no'];

    $paid_amount=number_format($row['amount'],2);
     

    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $category);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $insub_name.$subcname);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $r_no);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $date); $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $title);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $desc);  $column++;
    //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rs.".$paid_amount);  $column++;
     
    $rowCount++;

}
$objPHPExcel->getActiveSheet()->setTitle("Expenses Report");


 


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Expenses_report-list.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');















?>
