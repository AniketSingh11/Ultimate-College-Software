<?php
include("../includes/config.php"); 
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['stid']) && $_GET['stid']!='') )
{
   $value=$_GET['value'];
   $s_id=$_GET['stid'];	
   $type=$_GET['type'];
   $gender=$_GET['gender'];
   
    $sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];	
	if($type=='st'){
		$afor='1';
	}else if($type=='ow'){
		$afor='2';
	}else if($type=='dr'){
		$afor='3';
	}
	
	  $sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];	
		  
		  if($sdate_month=='01')
		  {
			  $mon="January";
		  }
		   if($sdate_month=='02')
		  {
			  $mon="February";
		  }
		   if($sdate_month=='03')
		  {
			  $mon="March";
		  }
		   if($sdate_month=='04')
		  {
			  $mon="April";
		  }
		   if($sdate_month=='05')
		  {
			  $mon="May";
		  } if($sdate_month=='06')
		  {
			  $mon="June";
		  }
		   if($sdate_month=='07')
		  {
			  $mon="July";
		  }
		   if($sdate_month=='08')
		  {
			  $mon="August";
		  }
		   if($sdate_month=='09')
		  {
			  $mon="September";
		  }
		   if($sdate_month=='10')
		  {
			  $mon="October";
		  } if($sdate_month=='11')
		  {
			  $mon="November";
		  } if($sdate_month=='12')
		  {
			  $mon="December";
		  } 
	
	
   /***************************************************Other Workers*********************************************************/
   if($type=='ow'){
	   
	   
	   $sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE o_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	
$leave1=0;
$lob1=0;
for($i=1;$i<=$numdays;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select l_type,l_total,from_date,to_date,h_type from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (o_id='$s_id' AND status='1' )";
										$emp_result1=mysql_query($emp_query1);
					$emp_display1=mysql_fetch_array($emp_result1);
					if($emp_display1){
						$ltype=$emp_display1['l_type'];
						$ltotal=$emp_display1['l_total'];
						$fromdate=$emp_display1['from_date'];
						$todate=$emp_display1['to_date'];
						$h_type=$emp_display1['h_type'];
						$leavelist=mysql_query("SELECT lt_id FROM leavetype WHERE lt_id=$ltype AND other='1'"); 
								  $othrleave=mysql_fetch_array($leavelist);
								  if($othrleave){
									  if($h_type){
										  if(($h_type=="E" || $h_type=="EM") && $fdate==$fromdate){
											  $lob1=$lob1+.5;
										  }else if(($h_type=="M" || $h_type=="EM") && $fdate==$todate){
											  $lob1=$lob1+.5;
										  }else{
										   $lob1++;
										  }
									  }else{
									  $lob1++;
									  }
								  }
								
								  if($h_type){
										  if(($h_type=="E" || $h_type=="EM") && $fdate==$fromdate){
											  $leave1=$leave1+.5;
										  }else if(($h_type=="M" || $h_type=="EM") && $fdate==$todate){
											  $leave1=$leave1+.5;
										  }else{
										   $leave1++;
										  }
									  }else{
									  $leave1++;
									  }
						
					}
}		
		//echo $leave1." - ".$lob1;
	if($lob1)
	{
		$lob_deduc=round(($fixed/$numdays)*$lob1);
		$deduc_total +=$lob_deduc;
	}
	if($excist){
		echo '<div class="clear"></div><br>
			<div class="col-sm-12">
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> '.$months[$sdate_month].' - '.$sdate_year.' already payslip generated for this employee!!!
			</div>
			</div>';
	}else{
	$emp_query0="select * from staff_salary where o_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
$fixed=$salarylist['salary'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE o_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$totalpay=0;

$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE o_id=$s_id AND l_id='$l_id'");
while($loanpay1=mysql_fetch_array($loanpaylist))
{
	$totalpay +=$loanpay1['amount'];
}

 $loanbalance=$l_tpay-$totalpay;

/*echo $salary_date = array_search($sdate_month, array_keys($months)); 
echo $loan_apply_date = array_search($lmonthdate, array_keys($months)); */

$salary_date1=$sdate_year."-".$sdate_month;
$loan_apply_date1=$loan['year']."-".$loan['month'];

if($salary_date1 >= $loan_apply_date1){
	/*if($loanbalance){
	if(($loan['l_m_pay']*2)>$loanbalance){
		$monthly_pay=$loanbalance;
	}else{
		$monthly_pay=$loan['l_m_pay'];
	}
	}else{*/
	if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	}
	//}
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}


$emp_query0="select * from staff_salary where o_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$fixed=$salarylist['salary'];
//echo "select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id ";die;
$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);


$emp_que1="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='off'";
$emp_res1=mysql_query($emp_que1);
$salarylistt1=mysql_fetch_array($emp_res1);
$cnt2=$salarylistt1[0]/2;
$att_cnt=$salarylistt[0]+$cnt2;
$gross_total=$fixed*$att_cnt;
//echo $att_cnt;die;

//$gross_total=$fixed*$salarylistt[0];

	$test =$value+$s_id;	
	
							$advancetotal=0;
							$myarray = array();
							$cur_Date=date('d-m-Y');
							 /* $sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1]; */	
							//echo "select a_amount,a_id from staff_advance WHERE o_id=$s_id AND status=0 and month <= '$sdate_month' and year='$sdate_year' ";die;
										$emp1_result=mysql_query("select a_amount,a_id from staff_advance WHERE o_id=$s_id AND status=0 and month <= '$sdate_month' and year='$sdate_year'");
										while($emp1_display=mysql_fetch_array($emp1_result))
										{
											$advancetotal +=$emp1_display["a_amount"];
											array_push($myarray,$emp1_display["a_id"]);		
										}
										$str = serialize($myarray);
    									$strids = urlencode($str);
	
	if($monthly_pay!="" || $advancetotal!=""){
					echo '<div class="col-sm-6">                                  
                                <p class="title"> Deductions :</p>';
								
								?>
		
	
								<?php
	}       
								$deduc_total=0;
									
									
									
									if($monthly_pay){
										$deduc_total +=$monthly_pay;
																				
                               echo '	<input type="checkbox" name="loan_amt" id="loan_amt" value="loan_amt"  onclick="adv_amt(this.value);" checked>  Take loan amount for '.$mon.' month salary<br><div class="form-group">
									<label for="name">Loan Payment</label>
									<input type="text" id="loan_pay" name="loan_pay" class="form-control" data-required="true" value="'.$monthly_pay.'" readonly>
									<input type="hidden" id="loan_pay1" name="loan_pay1" class="form-control" data-required="true" value="'.$monthly_pay.'" >
                                    <input type="hidden" id="l_id" name="l_id" class="form-control" value="'.$l_id.'">
                                    <input type="hidden" id="l_pay" name="l_pay" class="form-control" value="'.$l_pay.'">
									<input type="hidden" name="hide_loadpay" id="hide_loadpay" value="1">
								</div>';               
                                }
								if($advancetotal){
										$deduc_total +=$advancetotal;
																				
                               echo '<input type="checkbox" name="ad_amt" id="ad_amt" value="ad_amt" onclick="adv_amt(this.value);" checked>  Take advance amount for  '.$mon.' month salary<br><div class="form-group">
									<label for="name">Advance Salary</label>
									<input type="text" id="advance_pay" name="advance_pay" class="form-control" data-required="true" value="'.$advancetotal.'" readonly>
									<input type="hidden" id="advance_pay1" name="advance_pay1" class="form-control" data-required="true" value="'.$advancetotal.'" readonly>
                                    <input type="hidden" id="a_id" name="a_id" class="form-control" value="'.$strids.'">
									<input type="hidden" name="hide_advanceamt" id="hide_advanceamt" value="1">
								</div>';               
                                }
							
							echo '</div>';
							
	/*********************** Calculation *******************************/						
							echo '
				<div class="clear"></div><div class="col-sm-12"> <p class="title">Salary Details :</p><div class="form-group"><label for="name"><font color="red">'.$mon.' Month working days count :  '.$att_cnt.'  </font></label></div>
			<div class="form-group"><label for="name"><font color="red">One-day salary :  '.$fixed.'  </font></label></div>
			<div class="form-group"><label for="name"><font color="red">Total salary :  '.$fixed.' * '.$att_cnt.' = '.$gross_total.'</font></label></div>
			
				
				<div class="clear"></div><br>
								<div class="col-sm-6"><div class="form-group">
									<label for="name" class="title">Gross Total </label>
									<input type="text" id="gross_total" name="gross_total" class="form-control" data-required="true" value="'.$gross_total.'" readonly>
									<input type="hidden" id="gross_total1" name="gross_total1" class="form-control" data-required="true" value="'.$gross_total.'" >
								</div>
                                <div class="form-group">
									<label for="name" class="title">Net Salary</label>
									<input type="text" id="net_salary" name="net_salary" class="form-control" value="'.($gross_total-$deduc_total).'" readonly>
									<input type="hidden" id="net_salary1" name="net_salary1" class="form-control" value="'.($gross_total-$deduc_total).'" >
								</div>
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Total Deduction</label>
									<input type="text" id="deduction_total" name="deduction_total" class="form-control" value="'.$deduc_total.'" readonly>
									<input type="hidden" id="deduction_total1" name="deduction_total1" class="form-control" value="'.$deduc_total.'" >
								</div>
                    </div>
					';
        
	}
	
	$val=$gross_total-$deduc_total;
if($val>0){	
	echo '  <div class="clear"></div>                  
    
        <div class="clear"></div><div class="col-sm-12">
                    <center>
<div class="form-group" id="hiddenid">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>';
}
	   
   }
   /***************************************************Driver Workers*********************************************************/
   if($type=='dr'){
	   
	$sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE d_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	
$leave1=0;
$lob1=0;
for($i=1;$i<=$numdays;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select l_type,l_total,from_date,to_date,h_type from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (d_id='$s_id' AND status='1' )";
										$emp_result1=mysql_query($emp_query1);
					$emp_display1=mysql_fetch_array($emp_result1);
					if($emp_display1){
						$ltype=$emp_display1['l_type'];
						$ltotal=$emp_display1['l_total'];
						$fromdate=$emp_display1['from_date'];
						$todate=$emp_display1['to_date'];
						$h_type=$emp_display1['h_type'];
						$leavelist=mysql_query("SELECT lt_id FROM leavetype WHERE lt_id=$ltype AND other='1'"); 
								  $othrleave=mysql_fetch_array($leavelist);
								  if($othrleave){
									  if($h_type){
										  if(($h_type=="E" || $h_type=="EM") && $fdate==$fromdate){
											  $lob1=$lob1+.5;
										  }else if(($h_type=="M" || $h_type=="EM") && $fdate==$todate){
											  $lob1=$lob1+.5;
										  }else{
										   $lob1++;
										  }
									  }else{
									  $lob1++;
									  }
								  }
					  if($h_type){
							  if(($h_type=="E" || $h_type=="EM") && $fdate==$fromdate){
								  $leave1=$leave1+.5;
							  }else if(($h_type=="M" || $h_type=="EM") && $fdate==$todate){
								  $leave1=$leave1+.5;
							  }else{
							   $leave1++;
							  }
						  }else{
						  $leave1++;
						  }
					}
}		
		//echo $leave1." - ".$lob1;
	if($excist){
		echo '<div class="clear"></div><br>
			<div class="col-sm-12">
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> '.$months[$sdate_month].' - '.$sdate_year.' already payslip generated for this employee!!!
			</div>
			</div>';
	}else{
	$emp_query0="select * from staff_salary where d_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
$fixed=$salarylist['salary'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE d_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$totalpay=0;

$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE d_id=$s_id AND l_id='$l_id'");
while($loanpay1=mysql_fetch_array($loanpaylist))
{
	$totalpay +=$loanpay1['amount'];
}

 $loanbalance=$l_tpay-$totalpay;

/*echo $salary_date = array_search($sdate_month, array_keys($months)); 
echo $loan_apply_date = array_search($lmonthdate, array_keys($months)); */

$salary_date1=$sdate_year."-".$sdate_month;
$loan_apply_date1=$loan['year']."-".$loan['month'];

if($salary_date1 >= $loan_apply_date1){
	if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	}
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}
	$test =$value+$s_id;	
	
	$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and d_id=$s_id and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);


$emp_que1="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and d_id=$s_id and result='off'";
$emp_res1=mysql_query($emp_que1);
$salarylistt1=mysql_fetch_array($emp_res1);
$att_cnt=$salarylistt[0]+$salarylistt1[0];
$gross_total=$fixed*$att_cnt;

//$gross_total=$fixed*$salarylistt[0];
	
									$advancetotal=0;
							$myarray = array();
										$emp1_result=mysql_query("select a_amount,a_id from staff_advance WHERE d_id=$s_id AND status=0");
										while($emp1_display=mysql_fetch_array($emp1_result))
										{
											$advancetotal +=$emp1_display["a_amount"];
											array_push($myarray,$emp1_display["a_id"]);		
										}
										$str = serialize($myarray);
    									$strids = urlencode($str);
	
	if($monthly_pay!="" || $advancetotal!=""){
					echo '<div class="col-sm-6">                                  
                                <p class="title">Deductions :</p>';
	}              
								$deduc_total=0;
							
									
									if($monthly_pay){
										$deduc_total +=$monthly_pay;
																				
                               echo '<div class="form-group">
									<label for="name">Loan Payment</label>
									<input type="text" id="loan_pay" name="loan_pay" class="form-control" data-required="true" value="'.$monthly_pay.'" readonly>
                                    <input type="hidden" id="l_id" name="l_id" class="form-control" value="'.$l_id.'">
                                    <input type="hidden" id="l_pay" name="l_pay" class="form-control" value="'.$l_pay.'">
								</div>';               
                                }
								if($advancetotal){
										$deduc_total +=$advancetotal;
																				
                               echo '<div class="form-group">
									<label for="name">Advance Salary</label>
									<input type="text" id="advance_pay" name="advance_pay" class="form-control" data-required="true" value="'.$advancetotal.'" readonly>
                                    <input type="hidden" id="a_id" name="a_id" class="form-control" value="'.$strids.'">
								</div>';               
                                }
								
							
                                
							echo '</div>';
							
	/*********************** Calculation *******************************/						
							echo '<div class="clear"></div><div class="col-sm-12"> <p class="title">Salary Details :</p><div class="form-group"><label for="name"><font color="red">'.$mon.' Month working days count :  '.$salarylistt[0].'  </font></label></div>
			<div class="form-group"><label for="name"><font color="red">One-day salary :  '.$fixed.'  </font></label></div><div class="clear"></div>
				<div class="form-group"><label for="name"><font color="red">Total salary :  '.$fixed.' * '.$salarylistt[0].' = '.$gross_total.'</font></label></div><div class="clear"></div>
			<br>
							
							
				<div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Gross Total </label>
									<input type="text" id="gross_total" name="gross_total" class="form-control" data-required="true" value="'.$gross_total.'" readonly>
								</div>
                                <div class="form-group">
									<label for="name" class="title">Net Salary</label>
									<input type="text" id="net_salary" name="net_salary" class="form-control" value="'.($gross_total-$deduc_total).'" readonly>
								</div>
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Total Deduction</label>
									<input type="text" id="deduction_total" name="deduction_total" class="form-control" value="'.$deduc_total.'" readonly>
								</div>
                    </div>
					';
        
	}
   }
}
?>
