<?php
require("includes/config.php");
session_start();
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

$syear=$ay['s_year'];
$eyear=$ay['e_year'];

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];



                    $cid = $_GET['cid'];
                    $sid = $_GET['sid'];
                    $bid = $_GET['bid'];
                    $ddlterm = $_GET["ddlterm"];
                    $feesub = $_GET["fees_sub"];
                    $status=$_GET['status'];
                   // echo $status;
                    if ($cid && $sid) {
                        $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                        $class = mysql_fetch_array($classlist);
                        $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                        $section = mysql_fetch_array($sectionlist);
                        //echo $class['c_name']."-".$section['s_name'];
                    }

                                        if(!empty($ddlterm)){ 
                                        
                                        
                                        $qry = "SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype,s.s_id,phone_number FROM student AS s 
                                                INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='" . $acyear . "' ";
                                        if ($cid != "all") {
                                            $qry = $qry . " AND s.c_id='" . $cid . "'";
                                        }
                                        if ($sid != "all" && $sid != "Old") {
                                            $qry = $qry . "  AND s.s_id='" . $sid . "'";
                                        }
                                        if ($sid == "Old") {
                                            $qry = $qry . "  AND s.s_id!=0";
                                        }
                                        $qry = $qry . " AND s.b_id='" . $bid . "' ORDER BY s.c_id ASC";
                                        
                                        $result = mysql_query($qry);
                                        //echo $qry;
                                        $oin="SELECT * FROM finvoice_others as fin";
                                        $oin1=$oin;
                                        
                                        $result1 = mysql_query($oin);
                                        //echo $oin;
                                        $detail=array();
                                        $gdetail=array();
                                        while ($allin = mysql_fetch_assoc($result1)) {
                                            $detail[]=$allin;
                                        }
                                        $grt=mysql_query($oin1);
                                        while ($all = mysql_fetch_assoc($result)) {
                                            $gdetail[]=$all;
                                        }
                                       
                                    }
                                        
  
	
						
			 
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
		
	
		$cid=$_GET['cid'];
		$bid=$_GET['bid'];
			$sid=$_GET['sid'];
			
           			
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
	//	echo "SELECT * FROM board WHERE b_id=$bid";die;
								  $board=mysql_fetch_array($boardlist);		
								  
				$ss_id=$_GET['ssid'];
 $ssid=$ss_id;	
 
					$cid=$_GET['cid'];
				$sid=$_GET['sid'];		
				$sid=$_GET['sid'];								
				$ddlterm=$_GET["ddlterm"];
				  $otherfees_qry = "SELECT * FROM fgroup_detail where fg_id='4' AND otherfees='0'";
                                            $qry = mysql_query($otherfees_qry);
                                            while ($row = mysql_fetch_array($qry)) {
											}
			 $feesub = $_GET["fees_sub"];
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
                           // echo "SELECT * FROM class WHERE c_id=$cid";die;							
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
					//	echo "SELECT * FROM section WHERE s_id=$sid";die;
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
				}
		
			
 
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
		
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Admission  No");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Class Name");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student type");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("E2","Calibri");
		 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Student Phone no");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("E2","Calibri");
		
			
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Books, Notes, Other Items");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("F2","Calibri");
				
				
			 
			 $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Paid");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);cellFont("G2","Calibri");
			 	
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Pending");$column++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);cellFont("H2","Calibri");
			
       //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
        $n=1;
        foreach ($gdetail as $tmp) {

        	$cidd=$tmp['c_id'];
                                             $sid=$tmp['s_id'];

                                            $getsec=mysql_query("select * from section where s_id=$sid AND c_id=$cid");
                                            $gname=mysql_fetch_assoc($getsec)['g_name'];
                                           //echo "select * from others_bill_all where std=$cidd AND gname=$gname";
                                            $clss = mysql_query("select * from others_bill_all where std=$cidd AND gname='$gname' AND ay_id=$acyear");
            
            $ans=mysql_fetch_array($clss)['amount'];
        	$paid=0;
 			foreach ($detail as $sub) {
                if($tmp['ss_id']==$sub['ss_id']){
                    $paid+=$sub['fi_total']+$sub['discount'];
                }
            }
            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            if($disalloc['total'])
                                                $paid=$paid+$disalloc['total'];

            $pen=$ans-$paid; 
            if($ans) {
			if($status=="Fully" && $pen==0){
        	$column = 'A';
        	$admin_mo=$tmp['admission_number'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$admin_mo");$column++;
       		$name=$tmp['firstname'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$name");$column++;
       		$cname=$tmp['c_name'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$cname");$column++;
			$stype=$tmp['stype'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$stype");$column++;
       		$pno=$tmp['phone_number'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$pno");$column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$ans");$column++;
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid.' ( * : '.$distot.')');
                                                $column++;
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0){
                                                  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid.' ( * : '.$disapp.')');
                                                  $column++;
                                                }
                                                else{
                                                  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid);
                                                  $column++;
                                                }
                                            }
            
            //$pen=$ans-$paid;              
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$pen");$column++;
			$rowCount++;
			}
			if($status=="Pending" && $pen!=0){
        	$column = 'A';
        	$admin_mo=$tmp['admission_number'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$admin_mo");$column++;
       		$name=$tmp['firstname'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$name");$column++;
       		$cname=$tmp['c_name'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$cname");$column++;
			$stype=$tmp['stype'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$stype");$column++;
       		$pno=$tmp['phone_number'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$pno");$column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$ans");$column++;
           $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid.' ( * : '.$distot.')');
                                                $column++;
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0){
                                                  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid.' ( * : '.$disapp.')');
                                                  $column++;
                                                }
                                                else{
                                                  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid);
                                                  $column++;
                                                }
                                            }
            //$pen=$ans-$paid;              
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$pen");$column++;
			$rowCount++;
			}
			if($status=="Select"){
        	$column = 'A';
        	$admin_mo=$tmp['admission_number'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$admin_mo");$column++;
       		$name=$tmp['firstname'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$name");$column++;
       		$cname=$tmp['c_name'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$cname");$column++;
			$stype=$tmp['stype'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$stype");$column++;
       		$pno=$tmp['phone_number'];
       		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$pno");$column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$ans");$column++;
            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid.' ( * : '.$distot.')');
                                                $column++;
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0){
                                                  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid.' ( * : '.$disapp.')');
                                                  $column++;
                                                }
                                                else{
                                                  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $paid);
                                                  $column++;
                                                }
                                            }
            //$pen=$ans-$paid;              
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "$pen");$column++;
			$rowCount++;
			}
            }
		}		
		
		
        $objPHPExcel->getActiveSheet()->setTitle($class_name."-".$section_name." Student_FeesInvoice_Download");
        

       
  
        // Redirect output to a client’s web browser (Excel5)
      header('Content-Type: application/vnd.ms-excel');
      header("Content-Disposition: attachment;filename= Student_FeesInvoice_Download-list.xls");
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');  
        
       
 
?>
