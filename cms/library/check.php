<?php
include("../includes/config.php"); 
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['stid']) && $_GET['stid']!='') )
{
   $value=$_GET['value'];
   $s_id=$_GET['stid'];
	
	$sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1]; 
		  
					
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE st_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);
	

$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	
$leave1=0;
$lob1=0;
for($i=1;$i<=31;$i++){
	$fdate=$sdate_year."-".$sdate_month."-".str_pad($i, 2, "0", STR_PAD_LEFT);
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
    
	$monthly_pay=0;
	
	$loanlist=mysql_query("select * from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$lmonthdate=$loan['month'];

$loanpaylist=mysql_query("select * from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id' order by lp_id desc");
$loanpay1=mysql_fetch_array($loanpaylist);

$loanbalance=$loanpay1['balance'];

/*echo $salary_date = array_search($sdate_month, array_keys($months)); 
echo $loan_apply_date = array_search($lmonthdate, array_keys($months)); */

$salary_date1=$sdate_year."-".$sdate_month;
$loan_apply_date1=$loan['year']."-".$loan['month'];

if($salary_date1 >= $loan_apply_date1){
	if($loanbalance){
	if(($loan['l_m_pay']*2)>$loanbalance){
		$monthly_pay=$loanbalance;
	}else{
		$monthly_pay=$loan['l_m_pay'];
	}
	}else{
		$monthly_pay=$loan['l_m_pay'];
	}
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}
	$test =$value+$s_id;	
	
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
							echo '</div>
                                
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
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;														
														}
													}
										if($deduc==1){	
										$decu=$emp_display1["per_cent"];			
											$d_salary=$fixed*($decu/100);
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
?>
