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
   //echo $commondeduction." - ".$deductionname;
   if($type=='st'){
	   
	$sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE st_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	
$leave1=0;
$lob1=0;
for($i=1;$i<=$numdays;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
 $emp_query1="select l_type,l_total,from_date,to_date,h_type from staff_leave where (from_date<='$fdate' AND to_date>='$fdate') AND (st_id='$s_id' AND status='1' )";
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
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
$fixed=$salarylist['salary'];

$extra_salary=$salarylist['extra_salary'];
$extra_salary_type=$salarylist['extra_salary_type'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select * from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$l_terms=$loan['l_terms'];

$totalpay=0;
//$loanpaylist=mysql_query("select * from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id' order by lp_id desc");
$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id'");
$count_loanpay=mysql_fetch_array(mysql_query("select count(lp_id) from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id'"));
$chk_term=$l_terms-$count_loanpay[0];
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
	/* if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	} */

	if($chk_term>1)
{
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
	echo '<div class="col-sm-6">
                                <p class="title">Allowance :</p> 
                                <div class="form-group">';
                            
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
											$deduc=0;
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
											
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="allowans'.$emp_count1.''.$emp_id1.'" name="allowans'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="'.$a_salary.'" readonly>
                                        </div>';                                        
                                         }else{ 
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="allowans'.$emp_count1.''.$emp_id1.'" name="allowans'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="0" readonly>
                                        </div>';
										}
										$deduc=0;
                                    $emp_count1++;
                                    }           
									if($extra_salary!=""){
	$gross_total +=$extra_salary;
	echo '<div class="form-group">
                                            <label for="name">Extra Salary</label>
							<input type="text" id="extra_salary" name="extra_salary" class="form-control" data-required="true" value="'.$extra_salary.'" readonly>
							<input type="hidden" id="extra_salary_type" name="extra_salary_type" class="form-control" data-required="true" value="'.$extra_salary_type.'" >
                                
</div>';
}                        			              			                
							echo '</div>
							<input type="hidden" id="basicsalary" name="basicsalary" class="form-control" data-required="true" value="'.$basicsalary.'">
                                
</div>';

/*********************** Deductions *******************************/
					echo '<div class="col-sm-6">                                  
                                <p class="title">Deductions :</p>';
                                
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
													  $lob_deduc=0;
									if($lob1>0){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
									//	$deduc_total +=$lob_deduc;
									}
									
									$lob_ded_salary1=$basicsalary-$lob_deduc;
									if($lob_ded_salary1>0)
									{
										$lob_ded_salary=$lob_ded_salary1;
									}
									else
									{
										$lob_ded_salary=0;
									}
									
										if($deduc==1){	
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												$d_salary=$lob_ded_salary*($decu/100);
												//$d_salary=$basicsalary*($decu/100);
											}else{
												//$d_salary=$lob_ded_salary*($decu/100);
												$d_salary=$fixed*($decu/100);
											}
											$deduc_total+=$d_salary;
											
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="deduction'.$emp_count1.''.$emp_id1.'" name="deduction'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="'.$d_salary.'" readonly>
                                        </div>';                                        
                                        }else{
                                    echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="deduction'.$emp_count1.''.$emp_id1.'" name="deduction'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="0" readonly>
                                        </div>';
										
										}
										$deduc=0;
                                    $emp_count1++;
                                    }
                                  
									$lob_deduc=0;
									if($lob1){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									}
									
									 echo '<div class="form-group">
									<label for="name">LOB ( Days - '.$lob1.' )</label>
									<input type="text" id="lob" name="lob" class="form-control" data-required="true" value="'.$lob_deduc.'" readonly>
                                    <input type="hidden" id="l_id" name="tleave" class="form-control" value="'.$leave1.'">
                                    <input type="hidden" id="l_pay" name="tlob" class="form-control" value="'.$lob1.'">
								</div>'; 
								
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
								if($commondeduction){
										$deduc_total +=$commondeduction;
																				
                               echo '<div class="form-group">
									<label for="name">'.$deductionname.'</label>
									<input type="text" id="cdeduction" name="cdeduction" class="form-control" data-required="true" value="'.$commondeduction.'" readonly>
                                    <input type="hidden" id="cdeducionname" name="cdeducionname" class="form-control" value="'.$deductionname.'">
								</div>';               
                                }
                                
							echo '</div>';
							
	/*********************** Calculation *******************************/						
							echo '<div class="clear"></div><br>
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
   
   /***************************************************Other Workers*********************************************************/
   if($type=='ow'){
	   
	   
	   $sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE o_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
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
//$fixed=$salarylist['salary'];
$fixed=$salarylist['salary'];

$extra_salary=$salarylist['extra_salary'];
$extra_salary_type=$salarylist['extra_salary_type'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select * from staff_loan WHERE o_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$l_terms=$loan['l_terms'];
$totalpay=0;

$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE o_id=$s_id AND l_id='$l_id'");
$count_loanpay=mysql_fetch_array(mysql_query("select count(lp_id) from staff_loan_pay WHERE o_id=$s_id AND l_id='$l_id'"));
$chk_term=$l_terms-$count_loanpay[0];
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
	/* if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	} */
	if($chk_term>1)
{
	$monthly_pay=$loan['l_m_pay'];
}else{
	$monthly_pay=$loanbalance;
}
	//}
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
	echo '<div class="col-sm-6">
                                <p class="title">Allowance :</p> 
                                <div class="form-group">';
                            
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
											
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="allowans'.$emp_count1.''.$emp_id1.'" name="allowans'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="'.$a_salary.'" readonly>
                                        </div>';                                        
                                         }else{ 
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="allowans'.$emp_count1.''.$emp_id1.'" name="allowans'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="0" readonly>
                                        </div>';
										}
										$deduc=0;
                                    $emp_count1++;
                                    } 
									if($extra_salary!=""){
	$gross_total +=$extra_salary;
	echo '<div class="form-group">
                                            <label for="name">Extra Salary</label>
							<input type="text" id="extra_salary" name="extra_salary" class="form-control" data-required="true" value="'.$extra_salary.'" readonly>
							<input type="hidden" id="extra_salary_type" name="extra_salary_type" class="form-control" data-required="true" value="'.$extra_salary_type.'" >
                                
</div>';
}                                  			              			                
							echo '</div>
							<input type="hidden" id="basicsalary" name="basicsalary" class="form-control" data-required="true" value="'.$basicsalary.'">
                                
</div>';

/*********************** Deductions *******************************/
					echo '<div class="col-sm-6">                                  
                                <p class="title">Deductions :</p>';
                                
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
													 $lob_deduc=0;
									if($lob1>0){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										//$deduc_total +=$lob_deduc;
									}
									
									$lob_ded_salary1=$basicsalary-$lob_deduc;
									if($lob_ded_salary1>0)
									{
										$lob_ded_salary=$lob_ded_salary1;
									}
									else
									{
										$lob_ded_salary=0;
									}
										if($deduc==1){
												
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												//$d_salary=$basicsalary*($decu/100);
												$d_salary=$lob_ded_salary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
												//$d_salary=$lob_ded_salary*($decu/100);
											}
											$deduc_total+=$d_salary;
											
											
                                        /*$decu=$emp_display1["per_cent"];			
											$d_salary=$fixed*($decu/100);
											$deduc_total+=$d_salary;*/
											
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="deduction'.$emp_count1.''.$emp_id1.'" name="deduction'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="'.$d_salary.'" readonly>
                                        </div>';                                        
                                        }else{
                                    echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="deduction'.$emp_count1.''.$emp_id1.'" name="deduction'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="0" readonly>
                                        </div>';
										
										}
										$deduc=0;
                                    $emp_count1++;
                                    }
                                    $lob_deduc=0;
									if($lob1){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									} 
									
									
									 echo '<div class="form-group">
									<label for="name">LOB ( Days - '.$lob1.' )</label>
									<input type="text" id="lob" name="lob" class="form-control" data-required="true" value="'.$lob_deduc.'" readonly>
                                    <input type="hidden" id="l_id" name="tleave" class="form-control" value="'.$leave1.'">
                                    <input type="hidden" id="l_pay" name="tlob" class="form-control" value="'.$lob1.'">
								</div>'; 
								
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
								if($commondeduction){
										$deduc_total +=$commondeduction;
																				
                               echo '<div class="form-group">
									<label for="name">'.$deductionname.'</label>
									<input type="text" id="cdeduction" name="cdeduction" class="form-control" data-required="true" value="'.$commondeduction.'" readonly>
                                    <input type="hidden" id="cdeducionname" name="cdeducionname" class="form-control" value="'.$deductionname.'">
								</div>';               
                                }
                                
							echo '</div>';
							
	/*********************** Calculation *******************************/						
							echo '<div class="clear"></div><br>
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
   /***************************************************Driver Workers*********************************************************/
   if($type=='dr'){
	   
	$sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE d_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
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
$extra_salary=$salarylist['extra_salary'];
$extra_salary_type=$salarylist['extra_salary_type'];
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select * from staff_loan WHERE d_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];

$l_terms=$loan['l_terms'];
$totalpay=0;

$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE d_id=$s_id AND l_id='$l_id'");
$count_loanpay=mysql_fetch_array(mysql_query("select count(lp_id) from staff_loan_pay WHERE d_id=$s_id AND l_id='$l_id'"));
$chk_term=$l_terms-$count_loanpay[0];
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
	/* if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	} */
	if($chk_term>1)
{
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
	
	/*********************** Allowance *******************************/
	echo '<div class="col-sm-6">
                                <p class="title">Allowance :</p> 
                                <div class="form-group">';
                            
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
											
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="allowans'.$emp_count1.''.$emp_id1.'" name="allowans'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="'.$a_salary.'" readonly>
                                        </div>';                                        
                                         }else{ 
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="allowans'.$emp_count1.''.$emp_id1.'" name="allowans'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="0" readonly>
                                        </div>';
										}
										$deduc=0;
                                    $emp_count1++;
                                    }         
if($extra_salary!=""){
	$gross_total +=$extra_salary;
	echo '<div class="form-group">
                                            <label for="name">Extra Salary</label>
							<input type="text" id="extra_salary" name="extra_salary" class="form-control" data-required="true" value="'.$extra_salary.'" readonly>
							<input type="hidden" id="extra_salary_type" name="extra_salary_type" class="form-control" data-required="true" value="'.$extra_salary_type.'" >
                                
</div>';
}									
							echo '</div>
							<input type="hidden" id="basicsalary" name="basicsalary" class="form-control" data-required="true" value="'.$basicsalary.'">
                                
</div>';

/*********************** Deductions *******************************/
					echo '<div class="col-sm-6">                                  
                                <p class="title">Deductions :</p>';
                                
								$deduc_total=0;
										$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$deduc=0;	
										$emp_id1=$emp_display1["id"];
										$pe_type=$emp_display1["pe_type"];
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;			
														}
													}
									$lob_deduc=0;
									if($lob1>0){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										
									}
									
									$lob_ded_salary1=$basicsalary-$lob_deduc;
									if($lob_ded_salary1>0)
									{
										$lob_ded_salary=$lob_ded_salary1;
									}
									else
									{
										$lob_ded_salary=0;
									}
													
										if($deduc==1){	
										
										$decu=$emp_display1["per_cent"];
											if($pe_type=='1'){			
												//$d_salary=$basicsalary*($decu/100);
												$d_salary=$lob_ded_salary*($decu/100);
											}else{
												$d_salary=$fixed*($decu/100);
												//$d_salary=$lob_ded_salary*($decu/100);
											}
											$deduc_total+=$d_salary;
											
										/*$decu=$emp_display1["per_cent"];			
											$d_salary=$fixed*($decu/100);
											$deduc_total+=$d_salary;*/
											
                                        echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="deduction'.$emp_count1.''.$emp_id1.'" name="deduction'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="'.$d_salary.'" readonly>
                                        </div>';                                        
                                        }else{
                                    echo '<div class="form-group">
                                            <label for="name">'.$emp_display1["name"].'</label>
                                            <input type="text" id="deduction'.$emp_count1.''.$emp_id1.'" name="deduction'.$emp_count1.''.$emp_id1.'" class="form-control" data-required="true" value="0" readonly>
                                        </div>';
										
										}
										//$deduc=0;
                                    $emp_count1++;
                                    }
                                    $lob_deduc=0;
									if($lob1){
										$lob_deduc=round(($gross_total/$numdays)*$lob1);
										$deduc_total +=$lob_deduc;
									}
								
									
									 echo '<div class="form-group">
									<label for="name">LOB ( Days - '.$lob1.' )</label>
									<input type="text" id="lob" name="lob" class="form-control" data-required="true" value="'.$lob_deduc.'" readonly>
                                    <input type="hidden" id="l_id" name="tleave" class="form-control" value="'.$leave1.'">
                                    <input type="hidden" id="l_pay" name="tlob" class="form-control" value="'.$lob1.'">
								</div>'; 
								
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
								
								if($commondeduction){
										$deduc_total +=$commondeduction;
																				
                               echo '<div class="form-group">
									<label for="name">'.$deductionname.'</label>
									<input type="text" id="cdeduction" name="cdeduction" class="form-control" data-required="true" value="'.$commondeduction.'" readonly>
                                    <input type="hidden" id="cdeducionname" name="cdeducionname" class="form-control" value="'.$deductionname.'">
								</div>';               
                                }
                                
							echo '</div>';
							
	/*********************** Calculation *******************************/						
							echo '<div class="clear"></div><br>
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
