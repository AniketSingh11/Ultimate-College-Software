<?php
require("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];

$baid=$_GET['baid'];
$querylist ="SELECT * FROM bank_deposit";
if($baid){
    $querylist .=" WHERE ba_id=$baid";
}

$qry1 ="SELECT * FROM bank_deposit";
							if($baid){
							$qry1 .=" WHERE ba_id=$baid";
							}							
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['amount'];
					$total +=$tamount;					
				}
				
				$qry2 ="SELECT * FROM bank_withdrawl";
							if($baid){
							$qry2 .=" WHERE ba_id=$baid";
							}					
							$qry2 .=" ORDER BY bc_id DESC";			
							$qry=mysql_query($qry2);
							$withdrawlamount_total=0;
			  while($row=mysql_fetch_array($qry))
        		{
					$withdrawlamount=$row['amount'];
					$withdrawlamount_total +=$withdrawlamount;					
				}
				
				/* if($total>$withdrawlamount_total)
				{
				 $final_total=$total-$withdrawlamount_total;
				}
				else
				{
				 $final_total=$withdrawlamount_total-$total;
				} */
  $final_total=$total-$withdrawlamount_total;
 
 
 
 
 //$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit  ORDER BY withdrawl_date_time ASC";
 
 $acc_value=$_GET['acc_value'];
 $startdate1=$_GET['startdate'];
						$startdate1_val=explode('/',$startdate1);
					 //print_r($val);
					$startdate1_val1=$startdate1_val[0];
					$startdate1_val2=$startdate1_val[1];
					$startdate1_val3=$startdate1_val[2];
					$startdate_exp=$startdate1_val3.$startdate1_val2.$startdate1_val1;
					$enddate1=$_GET['enddate'];
					$enddate1_val=explode('/',$enddate1);
					 //print_r($val);
					$enddate1_val1=$enddate1_val[0];
					$enddate1_val2=$enddate1_val[1];
					$enddate1_val3=$enddate1_val[2];
					$enddate1_exp=$enddate1_val3.$enddate1_val2.$enddate1_val1;
					$baid=$_GET['baid'];
					/*//echo "select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";die;
					if($startdate1!=""){
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					else
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit ORDER BY withdrawl_date_time ASC";
					}
					//$qry1 ="select * from bank_withdrawl union all select -1 * from bank_deposit order by date";
							
							 if($baid){
							$qry1 .=" WHERE ba_id=$baid";
							} */
							
							if($startdate!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE  (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					if($baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1!="" && $baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE ba_id='$baid' and (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE ba_id='$baid' and (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					//$qry1 ="select * from bank_withdrawl union all select -1 * from bank_deposit order by date";
					if($startdate1=="" && $baid=="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl where date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1=="" && $baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1!="" && $baid=="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
							$qry=mysql_query($qry1);
							$count=1;
							$i=1;
						//print_r(mysql_fetch_array($qry));die;
			   
					
     $result = mysql_query($qry1) or die(mysql_error());
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
   
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);cellFont("A2","Calibri");
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Date");$column++;
       $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);cellFont("B2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Account No");$column++;
        
       $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("C2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bank");$column++; 
	   
	   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);cellFont("D2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Cheque No");$column++;
	   
	   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);cellFont("E2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Amount");$column++;
       
       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("F2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Deposited By");$column++;
	   
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);cellFont("G2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Withdrwal By");$column++;
	   
	   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("H2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Bank Amount");$column++;
	   
	   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);cellFont("I2","Calibri");
       $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, "Total Bank Balance");$column++;

       
       
        $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
		
		  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $acc_value);  $column++;
        
        //end of adding column names
        //start while loop to get data
        
        $rowCount = 3;
       
      //  while($row = mysql_fetch_array($result))
		  
	   while($row=mysql_fetch_array($qry))
        		{
					//echo "sdfsdfs";die;
					// $bc_id=$row['bc_id'];
					 $date=$row['date'];
					 $withdrawl_date_time=$row['withdrawl_date_time'];
					 $val=explode('/',$date);
					 //print_r($val);
					$val1=$val[0];
					$val2=$val[1];
					$val3=$val[2];
					$startdate=$val3.'-'.$val2.'-'.$val1;
						//echo "SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "'";die;
						//echo "SELECT * FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) + date_day < '" . $startdate. "'";
						
						//$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE (date_year*10000) + (date_month*100) + date_day < '" . $startdate. "' ");
						//$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) + date_day < '" . $startdate. "' ");
						/* $qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE deposit_date_time < '" . $withdrawl_date_time. "'");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "'"); */
						if($baid==""){
						$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' ");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "'");
							}
							else
							{
								$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid' ");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid'");
							}
						$value1=mysql_fetch_array($qrys);
					$value2=mysql_fetch_array($qryz);
					//print_r($value1);
					//print_r($value2);
					
					/* if($value1[0] > $value2[0]){
						
					$tot=$value1[0]-$value2[0];
					}
					else
					{
						$tot=$value2[0]-$value1[0];
					} */
					
					$tot=$value1[0]-$value2[0];
					//echo $tot;
					
					
					if($row['withdrawl_by']=="")
					{
						//echo "test";
						//echo $row['amount'];
						 $val=$tot+$row['amount'];
					}
					
					else
					{
						//echo "priya2";
						// echo $tot;
						// echo $row['amount'];
						 $val=$tot-$row['amount'];
					}
					
					
	/* 				$baid1=$row['ba_id'];
        
        { */
		
		if($row['cheque_no']!=""){ $ch_no=$row['cheque_no']; }
		if($row['NULL']!="") { $dep= $row['NULL'];}
		if($row['withdrawl_by']!=""){ $with_drwal=['withdrawl_by'];}
            $column = 'A';
           
         
           $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $date);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['account_no']);  $column++;
            $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['b_name']); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$ch_no); $column++;
			  $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row['amount']); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $dep ); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $with_drwal); $column++;
             $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,number_format($val) ); $column++;
            
            
         
             $rowCount++;
            
        }
        $objPHPExcel->getActiveSheet()->setTitle("BankDeposit Account Report");
        

       
        
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="BankDepositAccount_report-list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
       
 
?>
