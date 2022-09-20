<?php
require("../includes/config.php");
$brdid=$_GET["b_id"];
$acyear=$_GET["ay_id"];
 $qry="";
                        if(isset($_GET["agency"]))
                        {
                            
                        $agency_val=$_GET["agency"];
                        
                        $class=$_GET["class"];
                        
                        if($agency_val=="All"){
                            $qry.="  brdid=$brdid AND ay_id=$acyear ";
                        }else{
                            
                            $qry.=" a_id=$agency_val AND brdid=$brdid AND ay_id=$acyear ";
                        }
                        
                        if($class=="All"){
                            $qry.=" AND c_id!=''";
                        }else{
                            $qry.=" AND c_id='$class'";
                        }
                        }else{
                            $qry.=" brdid=$brdid AND ay_id=$acyear ";
                        }
 $result = mysql_query("SELECT * FROM book  where ".$qry);
        require_once '../Classes/PHPExcel.php';
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
        
        $rowCount = 1;
        
        
        //start of printing column names as names of MySQL fields
        
        $column = 'A';
        
     $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Agency");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "ThingsName");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "QtySold");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "QtyLeft");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("D1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "MarketPrice");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Price");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G1","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Category");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("G1","Calibri");

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 2;
        
        while($row = mysql_fetch_array($result))
        
        {
            $column = 'A';
            
            $bname=$row["b_name"];
            /*$b_qtysold=$row["b_qtysold"];
            $b_qtyleft=$row["b_qtyleft"];
            $m_price=$row["m_price"];*/
            $b_price=$row["b_price"];
            
            if($row['category']=='C')
               $category="Common";
            elseif($row['category']=='M')
            $category="Male";
            else
               $category="Female";
            
            $cid=$row['c_id'];
            $sid=$row['s_id'];
            $aid=$row['a_id'];
            $class=mysql_query("SELECT * FROM class WHERE c_id=$cid");
            $classlist=mysql_fetch_array($class);
            $class_name=$classlist['c_name'];
             
            if($class_name=="XI STD" || $class_name=="XI" || $class_name=="XII STD" || $class_name=="XII")
            {
                $section=mysql_query("SELECT * FROM section WHERE s_id=$sid");
                $sectionlist=mysql_fetch_array($section);
                $section_name=" - ".$sectionlist['s_name'];
            }else{
                	
                $section_name="";
            }
             
            	
           $std=$class_name.$section_name;
		   
		   $sold=$row['b_qtysold'];
					$left=$row['b_qtyleft'];
					$mprice=$row['m_price'];
					$nid=$row['n_id']; 
					if($nid>0){
						$note=mysql_query("SELECT * FROM notebook_purchese WHERE n_id=$nid");
			  			$notebook=mysql_fetch_array($note);
						$sold=$notebook['n_qtysold'];
						$left=$notebook['n_qtyleft'];
						$mprice=$notebook['m_price'];						
					}
            
            $agency=mysql_query("SELECT * FROM agency WHERE a_id=$aid");
            $agencylist=mysql_fetch_array($agency);
            
            $a_name=$agencylist['a_name'];
        
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $a_name);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $bname);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $sold);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $left); $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $mprice);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $b_price);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $std);  $column++;
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $category);  $column++;
            $rowCount++;
        }
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="AgencyReport-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        
        
?>
