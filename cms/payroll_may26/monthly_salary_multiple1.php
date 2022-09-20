<?php
include("header.php");
function is_valid_type($file) {
$valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
if (in_array($file['type'], $valid_types))
return 1;
return 0;
}
	
 if(isset($_POST["submit"]))
  {
	  //die();
	//  $sid= $_POST["st_id"];
	  $sstid= $_POST["emp_values"];
	  $val=explode(',',$sstid);
	  //print_r($val);die;
	foreach($val as $vall)
	{
		$valuez=explode('.',$vall);
		
		$s_id=$valuez[0];
		$type=$valuez[1];
		
		//$s_id=$_GET["emp"];
//$type=$_GET["type"];
		if($type=='st'){
			$stid=$s_id;
			$oid=0;
			$did=0;
		}else if($type=='ow'){	
			$stid=0;
			$oid=$s_id;	
			$did=0;	
		}else if($type=='dr'){	
			$stid=0;
			$oid=0;	
			$did=$s_id;	
		}	
		
		
if($type=='st'){	 
$emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['staff_id'];
	$staff_name= $employee11['fname']." ".$employee11['lname'];
	$staff_id= $employee11['staff_id'];
	$doj=$employee11['doj'];
	
	$position=$employee11['position'];
	$accno=$employee11['b_acc_no'];
	$role=$employee11['job_type'];
	
	
	
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}
		else if($type=='ow'){	 
$emp_query11="select * from others where o_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);


$staffid=$employee11['others_id'];
	$staff_name= $employee11['fname']." ".$employee11['lname'];
	$staff_id= $employee11['others_id'];
	$doj=$employee11['doj'];
	
	$position=$employee11['position'];
	$accno=$employee11['b_acc_no'];
	$role=$employee11['s_type'];

$ocid=$employee11["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
				
	$staffid=$employee11['others_id'];
	$emp_query0="select * from staff_salary where o_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}else if($type=='dr'){	 
$emp_query11="select * from driver where d_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['driver_id'];
	
	
	$staff_name= $employee11['fname']." ".$employee11['lname'];
	$staff_id= $employee11['driver_id'];
	$doj=$employee11['doj'];
	
	$position=$employee11['position'];
	$accno=$employee11['b_acc_no'];
	$role=$employee11['d_type'];
	
	
	$emp_query0="select * from staff_salary where d_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}	
	$gender=$employee11['gender'];
	
if($s_id){
//$numdays = cal_days_in_month(CAL_GREGORIAN, $mno, $year);

/*$leave1=0;
$lob1=0;
for($i=1;$i<=31;$i++){
	$fdate="2014-12-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select * from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (st_id='$s_id' AND status='1')";
										$emp_result1=mysql_query($emp_query1);
					$emp_display1=mysql_fetch_array($emp_result1);
					if($emp_display1){
						$ltype=$emp_display1['l_type'];
						$leavelist=mysql_query("SELECT * FROM leavetype WHERE lt_id=$ltype AND other='1'"); 
								  $othrleave=mysql_fetch_array($leavelist);
								  if($othrleave){
									  $lob1++;
								  }
					$leave1++;
					}
}		
		echo $leave1." - ".$lob1;*/
	
					
if($salarylist){

$fixed=$salarylist['salary'];
$extra_salary=$salarylist['extra_salary'];


if($type=='st'){
$loanlist=mysql_query("select * from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}else if($type=='ow'){
$loanlist=mysql_query("select * from staff_loan WHERE o_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}else if($type=='dr'){
$loanlist=mysql_query("select * from staff_loan WHERE d_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}
$fixed_salary=$fixed;

		
		
	
	//$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	//$salary_date1= mysql_real_escape_string($_POST["salary_date1"]);
	 $salary_date= $_POST["salary_date"];
	$salary_date1= date('d-m-Y');
	
	
	
		  $sdate_split1= explode('-', $salary_date);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
		  $numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
		  
		  $sdate_split2= explode('-', $salary_date1);		 
		  $sdate_day1=$sdate_split2[0];
		  $sdate_month1=$sdate_split2[1];
		  $sdate_year1=$sdate_split2[2];
		  
		  $sdate_day=$numdays;
		  
				if($sdate_month>=5){
					$y_value=$sdate_year+1;
				}else if($sdate_month<5){
					$y_value=$sdate_year;
				}  
				$emp_result2=mysql_query("select ay_id from year where e_year='$y_value'");
				$accc=mysql_fetch_assoc($emp_result2);
				$ayid1=$accc['ay_id'];
		  /*$fdis="allowans34";
	echo $fdisvalue=$_POST[$fdis];*/
	if($type=='st'){
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE st_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);
	}else if($type=='ow'){
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE o_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	}else if($type=='dr'){
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE d_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	}	
	if($excist){
		header("location:monthly_salary_multiple.php?msg=aerr");
	}else{
		
		
		
		//$sdate_split1= explode('-', $value);
		$sdate_split1= explode('-', $salary_date);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];	
	if($type=='st'){
		$afor='1';
	}else if($type=='ow'){
		$afor='2';
	}else if($type=='dr'){
		$afor='3';
	}
		  $commondeduction=0;
					$deduc1=mysql_query("select sd_id,name from staff_deduction where (month=$sdate_month AND year=$sdate_year) AND status=0");
					while($deduc=mysql_fetch_array($deduc1))
					{		
					$sd_id=$deduc["sd_id"];
					$deductionname=$deduc["name"];
						$deduc2=mysql_query("select amount,type from staff_ded_detail where sd_id=$sd_id AND status=0 AND (a_for='0' OR a_for=$afor)");
						while($deducd=mysql_fetch_array($deduc2))
						{
							$detype=$deducd['type'];
							if($detype=="C"){		
						$commondeduction +=$deducd['amount'];
							}else if($detype=="M" && $gender=="M"){
								$commondeduction +=$deducd['amount'];
							}else if($detype=="W" && $gender=="F"){
								$commondeduction +=$deducd['amount'];
							}
							
						}
						
					}
  // echo $commondeduction." - ".$deductionname;die;
   if($type=='st'){
	   
	//$sdate_split1= explode('-', $value);
	$sdate_split1= explode('-', $salary_date);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE st_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	
$leave1=0;
$lob1=0;
for($i=1;$i<=$numdays;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select l_type,l_total,from_date,to_date,h_type from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (st_id='$s_id' AND status='1')";
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
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc limit 0,1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
$fixed=$salarylist['salary'];
$extra_salary=$salarylist['extra_salary'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$totalpay=0;
//$loanpaylist=mysql_query("select * from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id' order by lp_id desc");
$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id'");
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
	
						    $advancetotal=0;
							$myarray = array();
										$emp1_result=mysql_query("select a_amount,a_id from staff_advance WHERE st_id=$s_id AND status=0");
										while($emp1_display=mysql_fetch_array($emp1_result))
										{
											$advancetotal +=$emp1_display["a_amount"];
											array_push($myarray,$emp1_display["a_id"]);		
										}
										$str = serialize($myarray);
    									$strids = urlencode($str);
	
	/*********************** Allowance *******************************/

							$gross_total=0;
							$tallow=0;
								$emp_query2="select * from staff_allw_ded where type='Allowance' and basic='0'";
										$emp_result2=mysql_query($emp_query2);
										while($emp_display2=mysql_fetch_array($emp_result2))
										{
										$emp_id2=$emp_display2["id"];	
												foreach ($allowance as $id) {
													if($emp_id2==$id){
														$tallow +=$emp_display2["per_cent"];
													}
												}
										}
										//echo $tallow;
										$basic=100-$tallow;
										$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										if($emp_display1["basic"]=='1'){
											$percent=$basic;
										}else{
											$percent=$emp_display1["per_cent"];
										}
										foreach ($allowance as $id) {
													if($emp_id1==$id){
														$deduc=1;
													}
										}
										if($lob1>0){
										$lob_deduc=round(($fixed/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									}
									else
									{
										$deduc_total =0;
									}
										if($deduc==1){
											//$a_salary=$fixed*($percent/100);
											$a_salary=($fixed*($percent/100))-$deduc_total;
											$gross_total+=$a_salary;
											if($emp_display1["basic"]=='1'){
												$basicsalary=$a_salary;
												$basiczsalary=$a_salary;
											}
											else
											{
											$a_salary=($fixed*($percent/100));
											$gross_total+=$a_salary;
											$basicsalary=$a_salary;
											}
											
                                       $a_salary=$a_salary;                                   
                                         }else{ 
                                       //$a_salary='0';
									   $a_salary=$fixed*($percent/100);
											$gross_total+=$a_salary;
											if($emp_display1["basic"]=='1'){
												$basicsalary=$a_salary;
											}
                                       $a_salary=$a_salary; 
										}
										$deduc=0;
                                    $emp_count1++;
                                    }
if($extra_salary!=""){
	$gross_total +=$extra_salary;
}	
						
$basicsalary=$basicsalary;

/*********************** Deductions *******************************/
				
								$deduc_total=0;
										$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										$pe_type=$emp_display1["pe_type"];
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;														
														}
													}
										if($deduc==1){	
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												//$d_salary=$basicsalary*($decu/100);
												$d_salary=$basiczsalary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;
											
                                     $d_salary=$d_salary;                                  
                                        }else{
                                  // $d_salary='0';
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												$d_salary=$basicsalary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;
										}
										$deduc=0;
                                    $emp_count1++;
                                    }
                                    $lob_deduc=0;
									if($lob1){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									}
									
									
											
									$lob= $lob_deduc;	
									$tleave= $leave1;	
									$tlob= $lob1;	
										
								
									if($monthly_pay){
										$deduc_total +=$monthly_pay;
										
								$l_id= $l_id;	
								$loan_pay= $monthly_pay;
								$l_pay= $l_pay;								
                                }
								
							
								if($advancetotal){
										$deduc_total +=$advancetotal;	
                                
								$a_id = unserialize(urldecode($strids));
								 $advance_pay= $advancetotal;									
                                }
								
							
							if($commondeduction){
										$deduc_total +=$commondeduction;
$cdeduction=$commondeduction;	
$cdeducionname=$deductionname;				
                                }
							
	/*********************** Calculation *******************************/						
									
					$deduction_total=$deduc_total;
					$net_salary=$gross_total-$deduc_total;
					$gross_total=$gross_total;
        
        
	}
   }
   
   /***************************************************OtherWorkers*********************************************************/
   /***************************************************Other Workers*********************************************************/
   if($type=='ow'){
	   
	   $sdate_split1= explode('-', $salary_date);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	//echo "SELECT * FROM staff_month_salary WHERE o_id=$s_id AND month=$sdate_month AND year=$sdate_year";die;
	 $excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE o_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);

$leave1=0;
$lob1=0;
for($i=1;$i<=$numdays;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select l_type,l_total,from_date,to_date,h_type from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (o_id='$s_id' AND status='1')";
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
	$emp_query0="select * from staff_salary where o_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
$fixed=$salarylist['salary'];
$extra_salary=$salarylist['extra_salary'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE o_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$totalpay=0;
//$loanpaylist=mysql_query("select * from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id' order by lp_id desc");
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
	if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	}
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}
	$test =$value+$s_id;	
	
						    $advancetotal=0;
							$myarray = array();
										$emp1_result=mysql_query("select a_amount,a_id from staff_advance WHERE o_id=$s_id AND status=0");
										while($emp1_display=mysql_fetch_array($emp1_result))
										{
											$advancetotal +=$emp1_display["a_amount"];
											array_push($myarray,$emp1_display["a_id"]);		
										}
										$str = serialize($myarray);
    									$strids = urlencode($str);
	
	/*********************** Allowance *******************************/

							$gross_total=0;
							$tallow=0;
								$emp_query2="select * from staff_allw_ded where type='Allowance' and basic='0'";
										$emp_result2=mysql_query($emp_query2);
										while($emp_display2=mysql_fetch_array($emp_result2))
										{
										$emp_id2=$emp_display2["id"];	
												foreach ($allowance as $id) {
													if($emp_id2==$id){
														$tallow +=$emp_display2["per_cent"];
													}
												}
										}
										//echo $tallow;
										$basic=100-$tallow;
										$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										if($emp_display1["basic"]=='1'){
											$percent=$basic;
										}else{
											$percent=$emp_display1["per_cent"];
										}
										foreach ($allowance as $id) {
													if($emp_id1==$id){
														$deduc=1;
													}
										}
										if($deduc==1){
											$a_salary=$fixed*($percent/100);
											$gross_total+=$a_salary;
											if($emp_display1["basic"]=='1'){
												$basicsalary=$a_salary;
											}
											
                                       $a_salary=$a_salary;                                   
                                         }else{ 
                                     
									   $a_salary=$fixed*($percent/100);
											$gross_total+=$a_salary;
											if($emp_display1["basic"]=='1'){
												$basicsalary=$a_salary;
											}
											$a_salary=$a_salary;   
										}
										$deduc=0;
                                    $emp_count1++;
                                    }  
if($extra_salary!=""){
	$gross_total +=$extra_salary;
}	
										
						
$basicsalary=$basicsalary;

/*********************** Deductions *******************************/
				
								$deduc_total=0;
										$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										$pe_type=$emp_display1["pe_type"];
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;														
														}
													}
										if($deduc==1){	
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												$d_salary=$basicsalary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;
											
                                     $d_salary=$d_salary;                                  
                                        }else{
                                  // $d_salary='0';
								   $decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												$d_salary=$basicsalary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;
										}
										//$deduc=0;
                                    $emp_count1++;
                                    }
                                    $lob_deduc=0;
									if($lob1){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									}
									
									
											
									$lob= $lob_deduc;	
									$tleave= $leave1;	
									$tlob= $lob1;	
										
								
									if($monthly_pay){
										$deduc_total +=$monthly_pay;
										
								$l_id= $l_id;	
								$loan_pay= $monthly_pay;
								$l_pay= $l_pay;								
                                }
								
							
								if($advancetotal){
										$deduc_total +=$advancetotal;	
                                
								$a_id = unserialize(urldecode($strids));
								 $advance_pay= $advancetotal;									
                                }
								
							
							if($commondeduction){
										$deduc_total +=$commondeduction;
$cdeduction=$commondeduction;	
$cdeducionname=$deductionname;				
                                }
							
	/*********************** Calculation *******************************/						
									
					$deduction_total=$deduc_total;
					$net_salary=$gross_total-$deduc_total;
					$gross_total=$gross_total;
        
        
	}
	   
//echo  $deduction_total.'dsdf'.$net_salary.'fff'.$gross_total;die;
   }
   
   /***************************************************Driver Workers*********************************************************/
   if($type=='dr'){
	   
	//sdate_split1= explode('-', $value);
	$sdate_split1= explode('-', $salary_date);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE d_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	
$leave1=0;
$lob1=0;
for($i=1;$i<=$numdays;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select l_type,l_total,from_date,to_date,h_type from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (d_id='$s_id' AND status='1')";
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
	$emp_query0="select * from staff_salary where d_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
$fixed=$salarylist['salary'];
$extra_salary=$salarylist['extra_salary'];
    
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
	

                            
							$gross_total=0;
							$tallow=0;
								$emp_query2="select * from staff_allw_ded where type='Allowance' and basic='0'";
										$emp_result2=mysql_query($emp_query2);
										while($emp_display2=mysql_fetch_array($emp_result2))
										{
										$emp_id2=$emp_display2["id"];	
												foreach ($allowance as $id) {
													if($emp_id2==$id){
														$tallow +=$emp_display2["per_cent"];
													}
												}
										}
										//echo $tallow;
										$basic=100-$tallow;
										$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										if($emp_display1["basic"]=='1'){
											$percent=$basic;
										}else{
											$percent=$emp_display1["per_cent"];
										}
										foreach ($allowance as $id) {
													if($emp_id1==$id){
														$deduc=1;
													}
										}
										if($deduc==1){
											$a_salary=$fixed*($percent/100);
											$gross_total+=$a_salary;
											if($emp_display1["basic"]=='1'){
												$basicsalary=$a_salary;
											}
											
                                          
											$a_salary=$a_salary;
                                         }else{ 
                                       
										//$a_salary='0';
										$a_salary=$fixed*($percent/100);
											$gross_total+=$a_salary;
											if($emp_display1["basic"]=='1'){
												$basicsalary=$a_salary;
											}
											
                                          
											$a_salary=$a_salary;
										}
										$deduc=0;
                                    $emp_count1++;
                                    }   
									if($extra_salary!=""){
	$gross_total +=$extra_salary;
}	
	
$basicsalary=$basicsalary;

/*********************** Deductions *******************************/
					
                           
								$deduc_total=0;
										$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										$pe_type=$emp_display1["pe_type"];
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;														
														}
													}
													
										if($deduc==1){	
										
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												$d_salary=$basicsalary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;
										
										/*$decu=$emp_display1["per_cent"];			
											$d_salary=$fixed*($decu/100);
											$deduc_total+=$d_salary;*/
											$d_salary=$d_salary;                                    
                                        }else{
                                  //  $d_salary='0'; 
									//$deduc_total+=$deduc_total;			
 $decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												$d_salary=$basicsalary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;									
                                        }
										
										//$deduc=0;
                                    $emp_count1++;
                                    }
                                    $lob_deduc=0;
									if($lob1){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									}
										
									$lob= $lob_deduc;	
									$tleave= $leave1;	
									$tlob= $lob1;	
										
									if($monthly_pay){
										$deduc_total +=$monthly_pay;
										
								$l_id= $l_id;	
								$loan_pay= $monthly_pay;
								$l_pay= $l_pay;								
                                }
								if($advancetotal){
										$deduc_total +=$advancetotal;	
                                
								$a_id = unserialize(urldecode($strids));
								 $advance_pay= $advancetotal;									
                                }
							
								
								if($commondeduction)
								{
										$deduc_total +=$commondeduction;
										$cdeduction=$commondeduction;
										$cdeducionname=$deductionname;
								}
					$gross_total=$gross_total;
					$net_salary=$gross_total-$deduc_total;
					$deduction_total=$deduc_total;
   }
		
   }  
	
	 
	 $advace_id="";
	 foreach ($a_id as $a_value) {
	  $advace_id.=$a_value.",";
	 }
	 $advace_id=substr_replace($advace_id, "", -1);
	 //die();
	 
	  
	  /*echo $lob." - ".$tleave." - ".$tlob;
	  echo "-".$acyear; 
	  die();*/	  
	  
	 $totalpay=0;
//$loanpaylist=mysql_query("select * from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id' order by lp_id desc");
$loanlist1=mysql_query("select * from staff_loan_pay WHERE l_id='$l_id'");
while($loan1=mysql_fetch_array($loanlist1))
{
	$totalpay +=$loan1['amount'];
}
	  $l_balance= $l_pay-$totalpay;
		 if($l_balance){
			$balance=$l_balance-$loan_pay;			  
		 }else{
			 $balance=$l_pay-$loan_pay;
		 }		  
						
$query="insert into staff_month_salary(st_id,o_id,d_id,staff_name,staff_id,date,day,month,year,g_salary,n_salary,d_total,loan_pay,total_leave,doj,position,role,accno,tleave,tlob,ay_id,a_id,date_day,date_month,date_year,extra_salary)values('$stid','$oid','$did','$staff_name','$staff_id','$salary_date','$sdate_day','$sdate_month','$sdate_year','$gross_total','$net_salary','$deduction_total','$l_pay','$tleave','$doj','$position','$role','$accno','$tleave','$tlob','$acyear','$advace_id','$sdate_day1','$sdate_month1','$sdate_year1','$extra_salary')";
//echo $query;
//die();
	$result=mysql_query($query);
	$lastid=mysql_insert_id();	
	if($result)
	{
			$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
			$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];	
										$aname=$emp_display1["name"];								
										$all="allowans".$emp_count1.$emp_id1;
										//$value=$_POST[$all];
										/* if($a_salary=="")
										{
											$value='0';
										}
										else{
										$value=$a_salary;
										} */
										
										if($aname=='Basic')
										{
											//$d_salary=$basicsalary*($decu/100);
											$value=$fixed*($emp_display1['per_cent']/100);
											$bax=$value;
										}
										else
										{
											$value=$fixed*($emp_display1['per_cent']/100);
										}
										$query1="insert into staff_month_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type,ad_id)values('$lastid','$stid','$oid','$did','$aname','$value','0','$emp_id1')";
	$result1=mysql_query($query1);
										$emp_count1++;
										}
										
	$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$emp_id1=$emp_display1["id"];
											$pe_type=$emp_display1["pe_type"];
											$pevalue=0;
											if($pe_type=='1' || $pe_type=='2'){					
												$emp_result12=mysql_query("select per_cent from staff_mcontribution where ay_id=$ayid1 AND ad_id=$emp_id1");
												$mcount=mysql_num_rows($emp_result12);
												if($mcount>0){
												$emp_display=mysql_fetch_assoc($emp_result12);
												$mcpercent=$emp_display['per_cent'];
												}else{
													$emp_result12=mysql_query("select per_cent from staff_mcontribution where ad_id=$emp_id1 ORDER BY id DESC");
													$emp_display=mysql_fetch_assoc($emp_result12);
													$mcpercent=$emp_display['per_cent'];
												}
												if($mcpercent && $pe_type=='1'){
													$pevalue=$basicsalary*($mcpercent/100);
												}else if($mcpercent && $pe_type=='2'){
													$pevalue=$fixed_salary*($mcpercent/100);
												}
											}
											
											$dname=$emp_display1["name"];		
											$deducs="deduction".$emp_count1."".$emp_id1;
											//$value1=$_POST[$deducs];
											if($d_salary=="")
											{
												$value1='0';
											}
											else
											{
												$value1=$d_salary;
											}
											$decu=$emp_display1["per_cent"];
											
											if(!$value1){
												$pevalue=0;
											}
											
											if($pe_type=='1'){	
								
											//	$d_salary=$basicsalary*($decu/100);
												//$d_salary=($fixed*($decu/100))-$ded_total;
												$value1=$basicsalary*($decu/100);
												$val=round($d_salary);
											}else{
												
												$value1=$fixed*($decu/100);
												$val=round($d_salary);
											}
											
											$query1="insert into staff_month_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type,ad_id,pevalue)values('$lastid','$stid','$oid','$did','$dname','$value1','1','$emp_id1','$pevalue')";
											$result1=mysql_query($query1);
											$emp_count1++;
										}
				/************ Leave Details *****************/	
				$leavename="LOB ( Days - ".$tlob." )";						
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','$leavename','$lob','2')");
								
					/********* Loan Details **********/													
								if($l_id){									
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','Loan Payment','$loan_pay','1')");
								$query3=mysql_query("insert into staff_loan_pay(st_ms_id,st_id,o_id,d_id,l_id,amount,balance,day,month,year,date)values('$lastid','$stid','$oid','$did','$l_id','$loan_pay','$balance','$sdate_day1','$sdate_month1','$sdate_year1','$salary_date1')");
								$loanpayid=mysql_insert_id();	
								$query=mysql_query("update staff_month_salary set lp_id='$loanpayid' where st_ms_id='$lastid' ");
									if($balance<=0){
										$query=mysql_query("update staff_loan set status='1' where l_id='$l_id' ");
									}
								}	
					/********* Advance Salary Details **********/													
								if($advance_pay){									
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','Advance Salary','$advance_pay','1')");
									foreach ($a_id as $a_value) {
										$query=mysql_query("update staff_advance set status='1',st_ms_id='$lastid' where a_id='$a_value' ");
										 //echo $a_value."<br>";
									 }
								}
					/************ Common Deduction Details *****************/	
				if($cdeduction){				
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','$cdeducionname','$cdeduction','1')");	
				}
		//header("location:monthly_salary_single.php?msg=succ");		
	}
	/* 	else
		{
			header("location:monthly_salary_single.php?msg=err");
		} */
	}
  }
  }
	}
	header("location:monthly_salary_multiple.php?msg=succ");
  }
  
   ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");	   
	   include("includes/top_nav.php");	   
	   include("sidebar.php");
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Employee Salary Add <a href="monthly_salary.php?m=<?php echo date("m");?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This Month already payslip generated for that employee!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Employee Salary Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="monthsal_multi" action="" class="form parsley-form" method="post" name="monthlysal" enctype="multipart/form-data">
				 <div class="portlet-content">     

<div class="col-sm-6">
<div class="form-group">
									<label for="name">Date</label>
                                    <div class="input-group date ui-datepicker2" style="width: 90%;float: right;" data-date-format="dd-mm-yyyy" >
		                                <input id="salary_date" name="salary_date" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>" >
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>		
<input type="hidden" name="emp_values" id="emp_values" value="">	
</div>					 
<div class="col-sm-6">
<div id="new_emp_div"></div>
				            	<div class="form-group" id="hide_emp_div">
									<label for="name">Employee ID</label>
									<select id="employeez" name="employee" class="" style="width:50%" onchange="select_employee()"  multiple="multiple">
                                    	
                            		</select>
								</div>
								</div> 

	

 <div class="col-sm-6">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<!--<button type="submit" class="btn btn-primary" name="submit">Submit</button>-->
									<button type="submit" class="btn btn-primary" name="submit" id="aaa" >Submit</button>
								</div>
</center>
                                </div>							
                                						
                                

  			 </div>  <!-- /.portlet-content -->
			 <form/>
             <?php 
		if($type=='st'){	 
$emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['staff_id'];
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}else if($type=='ow'){	 
$emp_query11="select * from others where o_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);

$ocid=$employee11["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
				
	$staffid=$employee11['others_id'];
	$emp_query0="select * from staff_salary where o_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}else if($type=='dr'){	 
$emp_query11="select * from driver where d_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['driver_id'];
	$emp_query0="select * from staff_salary where d_id=$s_id order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}	
	$gender=$employee11['gender'];
if($s_id){
//$numdays = cal_days_in_month(CAL_GREGORIAN, $mno, $year);

/*$leave1=0;
$lob1=0;
for($i=1;$i<=31;$i++){
	$fdate="2014-12-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select * from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (st_id='$s_id' AND status='1')";
										$emp_result1=mysql_query($emp_query1);
					$emp_display1=mysql_fetch_array($emp_result1);
					if($emp_display1){
						$ltype=$emp_display1['l_type'];
						$leavelist=mysql_query("SELECT * FROM leavetype WHERE lt_id=$ltype AND other='1'"); 
								  $othrleave=mysql_fetch_array($leavelist);
								  if($othrleave){
									  $lob1++;
								  }
					$leave1++;
					}
}		
		echo $leave1." - ".$lob1;*/
					
if($salarylist){	
$fixed=$salarylist['salary'];
$extra_salary=$salarylist['extra_salary'];

if($type=='st'){
$loanlist=mysql_query("select * from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}else if($type=='ow'){
$loanlist=mysql_query("select * from staff_loan WHERE o_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}else if($type=='dr'){
$loanlist=mysql_query("select * from staff_loan WHERE d_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}

?>
             <div class="portlet-content">
     <p class="title">Salary Details :</p> 
     <div class="col-sm-6">
     <div class="form-group">
									<label for="name">Date</label>
                                    <div class="input-group date ui-datepicker2" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date" name="salary_date" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
								<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staff_id" name="staff_id" class="form-control" data-required="true" value="<?php echo $staffid;?>" readonly>
								</div>
                                <div class="form-group">
									<label for="name">Salary Given Date</label>
                                <div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date1" name="salary_date1" class="form-control" type="text" data-required="true" value="<?php echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                       </div>
    
     <div class="col-sm-6">
     <div class="form-group">
									<label for="name">Employee Name</label>
									<input type="text" id="staff_name" name="staff_name" class="form-control" data-required="true" value="<?php echo $employee11['fname']." ".$employee11['lname'];?>" readonly>
								</div>
                                <div class="form-group">
									<label for="name">Fixed Salary</label>
									<input type="text" id="fixed_salary" name="fixed_salary" class="form-control" data-required="true" value="<?php echo $fixed;?>" readonly>
                                    <input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
                                <input type="hidden" name="accno" value="<?php echo  $employee11['b_acc_no'];?>"/>
                                <input type="hidden" name="doj" value="<?php echo  $employee11['doj'];?>"/>
                                <input type="hidden" name="position" value="<?php echo $employee11['position'];?>"/>
                                <input type="hidden" name="role" value="<?php if($type=='st'){echo $employee11['s_type'];}else if($type=='ow'){ echo $ocategory["category_name"];}else if($type=='dr'){ echo $employee11['d_type'];}?>"/>
								</div> 
       </div>        
       <div class="clear"></div>                  
       <div id="test">
        </div>
        <div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<!--<button type="button" class="btn btn-primary" name="submit" onclick="dialog();">Submit</button>-->
								</div>
</center>
                                </div>
     </div>
     <?php }else{ ?>
     <br>
     	<div class="alert alert-warning">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>
				<strong>Oops!</strong> This Employee Does Not have Fixed Salary! Please Add Fixed Salary first!!!
			</div>
     <?php }  }	?>

		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 


 <link rel="stylesheet" href="css/jquery-ui.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
 <?php 
 include("footer.php"); 
 ?>
 
<link href="http://wenzhixin.net.cn/p/multiple-select/multiple-select.css" rel="stylesheet"/>
<script src="http://wenzhixin.net.cn/p/multiple-select/docs/assets/jquery.min.js" type="text/javascript"></script>
<script src="http://wenzhixin.net.cn/p/multiple-select/multiple-select.js"></script>
 <script type="text/javascript">
 var jq = $.noConflict();
jq(document).ready(function(){
	
	jq('#employeez').multipleSelect();
});
$(document).ready(function(){
    $("#salary_date").change(function(){
		//alert('dfdfd');
        var thiss = $(this);
        var value = thiss.val(); 
		//alert(value);
        $.get("multiple_salary_ajax_dropdown.php",{value:value},function(data){
			//alert(data);
			$("#hide_emp_div").hide();
			$( "#new_emp_div" ).html(data);
			//$('#employeez').multipleSelect();
			jq('#employeez').multipleSelect();
        });
    });
});


</script>

<?php include("includes/script.php");?>
<script type="text/javascript">

 /* function select_employee() { 
 var t=$("#employee").val();
	  //alert(t);
	  var arr = t.split(',');
	  if(t){
		  window.location="monthly_salary_single.php?emp="+arr[0]+"&type="+arr[1];
	  }	
 } */
</script>

<script>
function select_employee()
{
	var emp_id=$('#employeez').val();
	$("#emp_values").val(emp_id);
}

function get_multi_userid()
{
	var emp_id=$('#emp_values').val();
	alert(emp_id);
}

function dialog()
{
	$('#dialog').toggle();
	//alert('ss');
}
$(document).ready(function(){
  $("#aaa").click(function(){
	var mon=$('#salary_date').val();
	 //alert(mon);
	  var arr = mon.split('-');
	  if(arr[0]=='01')
	  {
		  var monthname='January';
	  }
	   if(arr[0]=='02')
	  {
		  var monthname='February';
	  }
	   if(arr[0]=='03')
	  {
		  var monthname='March';
	  }
	   if(arr[0]=='04')
	  {
		  var monthname='April';
	  }
	   if(arr[0]=='05')
	  {
		  var monthname='May';
	  }
	   if(arr[0]=='06')
	  {
		  var monthname='June';
	  }
	   if(arr[0]=='07')
	  {
		  var monthname='July';
	  }
	   if(arr[0]=='08')
	  {
		  var monthname='August';
	  }
	   if(arr[0]=='09')
	  {
		  var monthname='september';
	  }
	   if(arr[0]=='10')
	  {
		  var monthname='October';
	  }
	   if(arr[0]=='11')
	  {
		  var monthname='November';
	  }
	   if(arr[0]=='12')
	  {
		  var monthname='December';
	  }
    if (!confirm("Are you approved for "+monthname+" Leave type!!!")){
      return false;
    }
	else
		{
		//$("form[name='monthlysal']").submit();
		$("form").submit();
		}
  });
});


</script>


</body>
</html>

 <? ob_flush(); ?>