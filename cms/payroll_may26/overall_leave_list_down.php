<?php
require("../includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
					  
 	$month=date("M");
 $year=$_GET['year'];
$year=date("Y");	  
	  
 $m_value=$_GET['m'];
 //echo $m_value;
 
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
$sacyear=$_SESSION['acyear'];
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
if($m_value>5){
	$y_value=$syear;
}else if($m_value<=5){
	$y_value=$eyear;
}
$sacyear=$_SESSION['acyear'];


if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];
$sdate=mysql_real_escape_string($_GET['sdate']);
$edate=mysql_real_escape_string($_GET['edate']);


if(!$syear && !$eyear){
$syear=$ay['s_year'];
$eyear=$ay['e_year'];
}

  $sid=$_GET['id'];
	   
	  $filter=$_GET['filt'];
	   
	  
	    $cid=$_GET['cid'];	
		 $leaveid=$_GET['ltid'];
	 //  echo $leaveid;die;
	   
	   if($leaveid){
		   	$leavetype1=mysql_query("SELECT lt_name FROM leavetype WHERE lt_id='$leaveid'");
			$lleave=mysql_fetch_array($leavetype1);
			$leavetyname=$lleave['lt_name'];
	   }
  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT * FROM year");
							  while($row=mysql_fetch_array($qry))
								{
									
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];
									$leaveid=$_GET['lt_id'];
											//echo $leaveid;die;
											
								
							  $emp_query14="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
				$leaveid=$_GET['lt_id'];							
											 											 
		$emp_result14=mysql_query($emp_query14);
		
		while($emp_display14=mysql_fetch_array($emp_result14))
		{
			$lt_id=$emp_display14["lt_id"];	
			$others=$emp_display14["other"];	
							   
		}	
								}
                                  
                                    foreach($months as $x => $x_value) {}
								
								 if(!$syear && !$eyear){
$syear=$ay['s_year'];
$eyear=$ay['e_year'];
}
 





                              $m_value=$_GET['m'];
							  $emp_query13="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
				$leaveid=$_GET['lt_id'];							
											 											 
		$emp_result13=mysql_query($emp_query13);
		
		while($emp_display13=mysql_fetch_array($emp_result13))
		{
			$lt_id=$emp_display13["lt_id"];	
			$others=$emp_display13["other"];	
							   
							   
							   
		}
		  $emp_query12="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
											
											 											 
		$emp_result12=mysql_query($emp_query12);
		
		while($emp_display12=mysql_fetch_array($emp_result12))
		{
			$lt_id=$emp_display12["lt_id"];	
			$others=$emp_display12["other"];
		}
                                
                                								
$name="Employee Leave List  (".$syear." - ".$eyear." - ".$filter.")";
require_once '../Classes/PHPExcel.php';


require_once '../Classes/PHPExcel/IOFactory.php';

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

$objPHPExcel->getActiveSheet()->setCellValue("A2"," $name ");
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(50);cellFont("A2","Calibri");
//start of printing column names as names of MySQL fields

$rowCount = 3;

$column = 'A';

/*   for ($i = 1; $i < mysql_num_fields($result); $i++)

{
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
$column++;
}
*/

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Emp Code");$column++;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Emp Name");$column++;

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Emp Type");$column++;

$leaveid=$_GET['ltid'];
											//echo $leaveid;die;
											$emp_query11="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query11.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query11.="  order by lt_id asc";
											// echo  $emp_query11;die;
											 
		$emp_result11=mysql_query($emp_query11);
		
		while($emp_display11=mysql_fetch_array($emp_result11))
		{
			$lt_id=$emp_display11["lt_id"];	
			$others=$emp_display11["other"];	

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display11["lt_name"]);$column++;

 $emp_count++;	

		}
		
		
		
		

$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());

//end of adding column names
//start while loop to get data

$rowCount = 4;
//////////////////////////Staff////////////////////////

   
									if($filter=="staff"){
										$emp_query="SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";
									
										////echo "SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";die;
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		
		while($emp_display=mysql_fetch_array($emp_result))
			
		{
 
			$column = 'A';
			$emp_id=$emp_display["st_id"];
         $s_type=$emp_display["s_type"];		
		
											

 
		
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display["staff_id"]);  $column++;$rowcount++;	
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display["fname"]);  $column++;$rowcount++;										
											 
  if(($s_type=="Teaching") or ($s_type=="Non-Teaching") ) { 
  
  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"staff");  $column++;
}
										//	$emp_query1="select * from leavetype order by lt_id asc";
											
										          $leaveid=$_GET['ltid'];
											//$leaveid="1";
											$emp_query1="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query1.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query1.="  order by lt_id asc";	
											
											
										//	print_r(mysql_fetch_array($emp_result));										
		$emp_result1=mysql_query($emp_query1);
		
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			
			$other=$emp_display1["other"];
			$lt_id=$emp_display1["lt_id"];
			$tleave=0;
			
			$emp_query2="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query2.= "AND f_month=$m_value"; 
											 }
											
											 elseif(!$m_value)
											 {
												 
												$emp_query2.= "AND f_month=".date(['Month=m']);  
											 }
			
			
			///echo "select * from staff_leave where status='1' AND (st_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result2=mysql_query($emp_query2);
			while($emp_display2=mysql_fetch_array($emp_result2))
			{
				
				$tleave +=$emp_display2['l_total'];
			
			}
				
	   $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$tleave);$column++;	
		
		 
		}
		$rowCount++;
		}							
		}
			//////////////////////////Others////////////////////////
								elseif($filter=="others"){
									
									          
                                $emp_query3="SELECT * FROM others order by fname asc";
                            		
		$emp_result3=mysql_query($emp_query3);
		
		while($emp_display3=mysql_fetch_array($emp_result3))
		{
			 $column = 'A';	 
			$emp_id=$emp_display3["o_id"];	
			$ocid=$emp_display3["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			
		
                              
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display3["others_id"]);  $column++;
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display3["fname"]);  $column++;								
                                           
											  if($pos){
												  
											$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"others");$column++;	
												  }else{
										$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"others"); $column++;		  
												  }
								
                                              $leaveid=$_GET['ltid'];
											//$leaveid="1";
											$emp_query4="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query4.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query4.="  order by lt_id asc";


											
		$emp_result4=mysql_query($emp_query4);
		
		while($emp_display4=mysql_fetch_array($emp_result4))
		{
			 
			$other=$emp_display4["other"];
			$lt_id=$emp_display4["lt_id"];
			$tleave=0;
			$emp_query5="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query5.= "AND f_month=$m_value"; 
											 }
			//echo "select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result5=mysql_query($emp_query5);
			while($emp_display5=mysql_fetch_array($emp_result5))
			{
				$tleave +=$emp_display5['l_total'];
			}
			
	       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$tleave);  $column++;	


									   
                                            
                                                                              
        }
		
								
$rowCount++;
}		
		
								}
								//////////////////////////Driver////////////////////////
								elseif($filter=="driver"){
									
									
	$emp_query6="SELECT * FROM driver WHERE d_type in ('Driver','Non-Driver') order by fname asc";
								//echo "select * from driver where d_type='Driver' order by fname asc";die;
										
		
		$emp_result6=mysql_query($emp_query6);
		
		while($emp_display6=mysql_fetch_array($emp_result6))
		{
			$column = 'A';	  
			$emp_id=$emp_display6["d_id"];
		//	print_r($emp_id);die;
            $d_type=$emp_display6["d_type"];			
			
		
		 

		 
		
								$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $emp_display6["driver_id"]);  $column++;
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display6["fname"]);  $column++;						 
											if($d_type=="Driver"){
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"Driver");  $column++;								
												
												}else{
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"Driver");  $column++;
													} 
			
											 //$emp_query7="select * from leavetype order by lt_id asc";

$leaveid=$_GET['ltid'];
											//$leaveid="1";
											$emp_query7="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query7.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query7.="  order by lt_id asc";
											 
		$emp_result7=mysql_query($emp_query7);
		
		while($emp_display7=mysql_fetch_array($emp_result7))
		{
			 
			$other=$emp_display7["other"];
			$lt_id=$emp_display7["lt_id"];
			$tleave=0;
			 $emp_query8="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query8.= "AND f_month=$m_value"; 
											 }
			//echo "select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND month=$months AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result8=mysql_query($emp_query8);
			while($emp_display8=mysql_fetch_array($emp_result8))
			{
				$tleave +=$emp_display8['l_total'];
			}
			
		
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$tleave);  $column++;

			
        } 
      	$rowCount++;
        }
		
		
		}
					//////////////////////////Overall////////////////////////	
							

								elseif($filter==""){
								
							
							
							 
							$emp_query="SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";
									
										//echo "SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";die;
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		
		while($emp_display=mysql_fetch_array($emp_result))
			
		{
 
			$column = 'A';
			$emp_id=$emp_display["st_id"];
         $s_type=$emp_display["s_type"];		
		
											

 
		
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display["staff_id"]);  $column++;$rowcount++;	
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display["fname"]);  $column++;$rowcount++;										
											 
  if(($s_type=="Teaching") or ($s_type=="Non-Teaching") ) { 
  
  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"staff");  $column++;
}
										//	$emp_query1="select * from leavetype order by lt_id asc";
											
										          $leaveid=$_GET['ltid'];
											//$leaveid="1";
											$emp_query1="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query1.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query1.="  order by lt_id asc";	
											
											
										//	print_r(mysql_fetch_array($emp_result));										
		$emp_result1=mysql_query($emp_query1);
		
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			
			$other=$emp_display1["other"];
			$lt_id=$emp_display1["lt_id"];
			$tleave=0;
			
			$emp_query2="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query2.= "AND f_month=$m_value"; 
											 }
											
											 elseif(!$m_value)
											 {
												 
												$emp_query2.= "AND f_month=".date(['Month=m']);  
											 }
			
			
			///echo "select * from staff_leave where status='1' AND (st_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result2=mysql_query($emp_query2);
			while($emp_display2=mysql_fetch_array($emp_result2))
			{
				
				$tleave +=$emp_display2['l_total'];
			
			}
				
	   $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$tleave);$column++;	
		
		 
		}
		$rowCount++;
		}							
		
		 $emp_query3="SELECT * FROM others order by fname asc";
                        	
		$emp_result3=mysql_query($emp_query3);
		
		while($emp_display3=mysql_fetch_array($emp_result3))
		{
             $column = 'A';
			$emp_id=$emp_display3["o_id"];	
			$ocid=$emp_display3["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
 
		
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display3["others_id"] );  $column++;$rowcount++;
			  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display3["fname"] );  $column++;$rowcount++;
if($pos){
 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"others" );  $column++;
	}else{
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"others" );  $column++;
		}
											//$emp_query4="select * from leavetype order by lt_id asc";		

                                              $leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query4="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query4.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query4.="  order by lt_id asc";


											
		$emp_result4=mysql_query($emp_query4);
		
		while($emp_display4=mysql_fetch_array($emp_result4))
		{
			
			$other=$emp_display4["other"];
			$lt_id=$emp_display4["lt_id"];
			$tleave=0;
			$emp_query5="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query5.= "AND f_month=$m_value"; 
											 }
											  elseif(!$m_value)
											 {
												 
												$emp_query5.= "AND f_month=".date(['Month=m']);  
											 }
			//echo "select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result5=mysql_query($emp_query5);
			while($emp_display5=mysql_fetch_array($emp_result5))
			{
				$tleave +=$emp_display5['l_total'];
			}
			
	          		
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$tleave ); $column++;
        }
		$rowCount++;
	}		
													
										
	$emp_query6="SELECT * FROM driver WHERE d_type in ('Driver','Non-Driver') order by fname asc";
								///echo "select * from driver where d_type='Driver' order by fname asc";die;
										
		
		$emp_result6=mysql_query($emp_query6);
		
		while($emp_display6=mysql_fetch_array($emp_result6))
		{
			$column = 'A';
			$emp_id=$emp_display6["d_id"];
            $d_type=$emp_display6["d_type"];			
			
			
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display6["driver_id"] );  $column++;$rowcount++;
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$emp_display6["fname"] );  $column++;$rowcount++;
		
										
if($d_type=="Driver"){
	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"Driver");  $column++;$rowcount++;
	}else{
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,"Driver");  $column++;$rowcount++;
		} 
											 $emp_query7="select * from leavetype order by lt_id asc";

                                         $leaveid=$_GET['ltid'];
											//$leaveid="1";
											$emp_query7="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query7.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query7.="  order by lt_id asc";


											 
		$emp_result7=mysql_query($emp_query7);
		
		while($emp_display7=mysql_fetch_array($emp_result7))
		{
			 
			$other=$emp_display7["other"];
			$lt_id=$emp_display7["lt_id"];
			$tleave=0;
			 $emp_query8="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query8.= "AND f_month=$m_value"; 
											 }
											  elseif(!$m_value)
											 {
												 
												$emp_query8.= "AND f_month=".date(['Month=m']);  
											 }
			////echo "select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result8=mysql_query($emp_query8);
			while($emp_display8=mysql_fetch_array($emp_result8))
			{
				$tleave +=$emp_display8['l_total'];
			}
			
	
$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$tleave);  $column++;
			           
				
        }       	
         $rowCount++; 
     
   }									
										
								}

		
		
								
							  
							 
									
										
$objPHPExcel->getActiveSheet()->setTitle("Overall Leave List");
$ptypename=str_replace(" ","",$ptypename);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$name.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
