<?php
require("includes/config.php");

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_assoc($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_assoc($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


$excid=$_GET['excid'];
$exsid=$_GET['exs_id'];
$aid=$_GET['aid'];
$aname1="ALL";
  if($aid){
		 $agencylist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
			  $agency=mysql_fetch_array($agencylist);
			  $aname1=$agency['a_name'];
					}

if($exsid){
		$classlist1=mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id='$exsid'");
		$class1=mysql_fetch_array($classlist1);
		
		for($j=1;$j<=20;$j++)
				{
				$sub_id=$class1["sub".$j."_id"];
				
				if($sub_id!=0){
				   $field=$j;
				}
				}
				$fieldno=$field+1;
				$myarray = array();
				array_push($myarray,$exsid);
				$subname="sub".$fieldno."_id";
				$classlist2=mysql_query("SELECT * FROM ex_insubcategory WHERE $subname='$exsid'");
				while($class2=mysql_fetch_array($classlist2))
				{
					//$sub_id=$class1["sub".$j."_id"];
					array_push($myarray,$class2['exs_id']);
				}
				}
 
$qry1="SELECT status,amount FROM exponses WHERE ay_id=$acyear";
							if($excid || $aid){
								$qry1 .=" AND";
							}
							if($excid && !$aid){
							$qry1 .=" exc_id=$excid";
							}else if(!$excid && $aid){
								$qry1 .=" aid=$aid";
							}else if($excid && $aid){
								$qry1 .=" exc_id=$excid AND aid=$aid";
							}
							if($exsid){
							    $qry1 .=" AND  exs_id IN (".implode(',',$myarray).")";
							}
							$qry1 .=" ORDER BY ex_id DESC";
							$qry1=mysql_query($qry1);
							$total=0;
							$paitotal=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$status=$row1['status'];
					$tamount=$row1['amount'];
					$total +=$tamount;		
					if($status=='1'){
						$paitotal +=$tamount;	
					}
				}
				$pending=$total-$paitotal;
				
				$qry2="SELECT * FROM exponses WHERE ay_id=$acyear";
							if($excid || $aid){
								$qry2 .=" AND";
							}
							if($excid && !$aid){
							$qry2 .=" exc_id=$excid";
							}else if(!$excid && $aid){
								$qry2 .=" aid=$aid";
							}else if($excid && $aid){
								$qry2 .=" exc_id=$excid AND aid=$aid";
							}
							if($exsid){
							    $qry2 .=" AND  exs_id IN (".implode(',',$myarray).")";
							}
							$qry2 .=" ORDER BY ex_id DESC";


        $result = mysql_query($qry2) or die(mysql_error());
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
        
        $objPHPExcel->getActiveSheet()->setCellValue("A2","Total Amount: $total ");
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(50);cellFont("A2","Calibri");

$objPHPExcel->getActiveSheet()->setCellValue("C2","Paid Amount: $paitotal ");
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(50);cellFont("C2","Calibri");

$objPHPExcel->getActiveSheet()->setCellValue("E2","Pending Amount: $pending ");
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(50);cellFont("E2","Calibri");
//start of printing column names as names of MySQL fields

$rowCount = 3;

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
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Agency Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Receipt No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Title");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
     $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Receiver");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);cellFont("I2","Calibri");
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bill Generated By");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(J0);cellFont("J2","Calibri");
    
        
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 4;
       
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
            $excid1=$row['exc_id'];
			$aid1=$row['aid'];
            $exsid=$row['exs_id'];
            $qry1=mysql_fetch_array(mysql_query("select * from ex_insubcategory where exs_id='$exsid'"));
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
			$status=$row['status'];
			if($row['type']=='0'){
				$type="Expences";
			}else if($row['type']=='1' && $status=='1'){
				$type="Paid";
			}else if($row['type']=='1'){
				$type="Invoiced";
			}
			$agencylist1=mysql_query("SELECT * FROM agency WHERE a_id=$aid1"); 
								  $agency1=mysql_fetch_array($agencylist1);
								  
								  $agencyname=$agency1['a_name'];
								  if($agencyname){
									  $aname=$agencyname;
								  }else {
									  $aname=" - ";
								  }
          
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $category);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $insub_name.$subcname);  $column++;
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $aname);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $r_no);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $date); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $title);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $type);  $column++;
             //$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Rs.".$paid_amount);  $column++;
			  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['receiver']);  $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['billgenerate']);  $column++;
             $rowCount++;
        }
        $objPHPExcel->getActiveSheet()->setTitle("Expenses Report");
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Expenses_report-list("'.$aname1.'").xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
