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
		 $salary_date= $_POST["salary_date1"];
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
		  
		
if($type=='ow')
		{	
			$emp_query11="select * from others where o_id='$s_id'";
			$emp_result11=mysql_query($emp_query11);
			$employee11=mysql_fetch_array($emp_result11);
			$staffid=$employee11['others_id'];
			$staff_name= $employee11['fname']." ".$employee11['lname'];
			$staff_id= $employee11['others_id'];
			$doj=$employee11['doj'];
			$position=$employee11['position'];
			$accno=$employee11['b_acc_no'];
			//$role=$employee11['s_type'];
			$ocid=$employee11["category_id"];
			$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
			$ocategory=mysql_fetch_array($categorys);
			$role=$ocategory["category_name"];
			$staffid=$employee11['others_id'];
			
$emp_query0="select * from staff_salary where o_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$fixed=$salarylist['salary'];
//echo "select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id ";die;
$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='1'";
$emp_res=mysql_query($emp_que);
$salarylist=mysql_fetch_array($emp_res);



$emp_que1="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='off'";
$emp_res1=mysql_query($emp_que1);
$salarylistt1=mysql_fetch_array($emp_res1);
$att_cnt=$salarylistt[0]+$salarylistt1[0];
$gv_salary=$fixed*$att_cnt;


//$gv_salary=$fixed*$salarylist[0];
		} 
		else
		{	 
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

$fixed=$salarylist['salary'];
$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and d_id=$s_id and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);

$emp_que1="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and d_id=$s_id and result='off'";
$emp_res1=mysql_query($emp_que1);
$salarylistt1=mysql_fetch_array($emp_res1);
$att_cnt=$salarylistt[0]+$salarylistt1[0];
$gv_salary=$fixed*$att_cnt;

		}	
//echo "select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and d_id=$s_id";die;
	$gender=$employee11['gender'];
	
if($s_id){

if($salarylist){

$fixed=$salarylist['salary'];
/* if($type=='st'){
$loanlist=mysql_query("select * from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}else */ if($type=='ow'){
$loanlist=mysql_query("select * from staff_loan WHERE o_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
} else{
$loanlist=mysql_query("select * from staff_loan WHERE d_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}
$fixed_salary=$fixed;

	//$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	//$salary_date1= mysql_real_escape_string($_POST["salary_date1"]);
	 $salary_date= $_POST["salary_date1"];
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
	/* if($type=='st'){
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE st_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);
	}else  */if($type=='ow'){
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE o_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	}else {
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE d_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	}	

	if($excist){
		header("location:daily_salary_multiple.php?msg=aerr");
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
	
   /***************************************************Other Workers*********************************************************/
   if($type=='ow'){
	  
	   
	   $sdate_split1= explode('-', $salary_date);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];				
	//echo "SELECT * FROM staff_month_salary WHERE o_id=$s_id AND month=$sdate_month AND year=$sdate_year";die;
	 $excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE o_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);

		
	if(empty($excist)){
	
		/* echo '<div class="clear"></div><br>
			<div class="col-sm-12">
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> '.$months[$sdate_month].' - '.$sdate_year.' already payslip generated for this employee!!!
			</div>
			</div>';
	}else{ */
	$emp_query0="select * from staff_salary where o_id=$s_id order by id desc limit 1";
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
	
	
				
								$deduc_total=0;
								
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
								
							
							
							
							$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);



$emp_que1="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='off'";
$emp_res1=mysql_query($emp_que1);
$salarylistt1=mysql_fetch_array($emp_res1);
$att_cnt=$salarylistt[0]+$salarylistt1[0];
$gross_total=$fixed*$att_cnt;

//$gross_total=$fixed*$salarylistt[0];
							
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
	
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE d_id=$s_id AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
	

		//echo $leave1." - ".$lob1;
	if(empty($excist)){
		/* echo '<div class="clear"></div><br>
			<div class="col-sm-12">
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> '.$months[$sdate_month].' - '.$sdate_year.' already payslip generated for this employee!!!
			</div>
			</div>';
	}else{ */
		
$emp_query0="select * from staff_salary where d_id=$s_id order by id desc limit 1";
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
	

                            
							
							
/*********************** Deductions *******************************/
					
                           
								$deduc_total=0;
										
										
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
							
								
										
							$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);


$emp_que1="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and o_id=$s_id and result='off'";
$emp_res1=mysql_query($emp_que1);
$salarylistt1=mysql_fetch_array($emp_res1);
$att_cnt=$salarylistt[0]+$salarylistt1[0];
$gross_total=$fixed*$att_cnt;


//$gross_total=$fixed*$salarylistt[0];

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
	 
			if($net_salary>0){			
$query="insert into staff_daily_salary(st_id,o_id,d_id,staff_name,staff_id,date,day,month,year,g_salary,n_salary,d_total,loan_pay,total_leave,doj,position,role,accno,tleave,tlob,ay_id,a_id,date_day,date_month,date_year)values('$stid','$oid','$did','$staff_name','$staff_id','$salary_date','$sdate_day','$sdate_month','$sdate_year','$gross_total','$net_salary','$deduction_total','$l_pay','$tleave','$doj','$position','$role','$accno','$tleave','$tlob','$acyear','$advace_id','$sdate_day1','$sdate_month1','$sdate_year1')";

	$result=mysql_query($query);
	$lastid=mysql_insert_id();	
	if($result)
	{
		
					/********* Loan Details **********/													
								if($l_id){									
								$query1=mysql_query("insert into staff_daily_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','Loan Payment','$loan_pay','1')");
								$query3=mysql_query("insert into staff_loan_pay(st_ms_id,st_id,o_id,d_id,l_id,amount,balance,day,month,year,date)values('$lastid','$stid','$oid','$did','$l_id','$loan_pay','$balance','$sdate_day1','$sdate_month1','$sdate_year1','$salary_date1')");
								$loanpayid=mysql_insert_id();	
								$query=mysql_query("update staff_daily_salary set lp_id='$loanpayid' where st_ms_id='$lastid' ");
									if($balance<=0){
										$query=mysql_query("update staff_loan set status='1' where l_id='$l_id' ");
									}
								}	
					/********* Advance Salary Details **********/													
								if($advance_pay){									
								$query1=mysql_query("insert into staff_daily_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','Advance Salary','$advance_pay','1')");
									foreach ($a_id as $a_value) {
										$query=mysql_query("update staff_advance set status='1',st_ms_id='$lastid' where a_id='$a_value' ");
										 //echo $a_value."<br>";
									 }
								}
						
	}
	
	}
	}
  }
  }
	}
	header("location:daily_salary_multiple.php?msg=succ");
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
			 <h1> Employee Daily Salary Multiple Add <a href="daily_salary.php?m=<?php echo date("m");?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						Employee Daily Salary Multiple Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="monthsal_multi" action="" class="form parsley-form" method="post" name="monthlysal" enctype="multipart/form-data">
				 <div class="portlet-content">     

<div class="col-sm-6">
<div class="form-group">
									<label for="name">Date</label>
                                    <div class="input-group date ui-datepicker2" style="width: 90%;float: right;" data-date-format="dd-mm-yyyy" >
		                                <input id="salary_date1" name="salary_date1" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>" >
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>	

	<!--<div class="form-group">
									<label for="name">Salary Given Date</label>
                                <div id="dp-ex-3" class="input-group date ui-datepicker1" style="width: 75%;float: right;" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date1" name="salary_date1" class="form-control parsley-validated" type="text" data-required="true" value="">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>-->
								
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
    $("#salary_date1").change(function(){
		//alert('dfdfd');
        var thiss = $(this);
        var value = thiss.val(); 
		//alert(value);
        $.get("daily_salary_multiple_ajax.php",{value:value},function(data){
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
	  /* var arr = mon.split('-');
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
		{*/
		//$("form[name='monthlysal']").submit();
		$("form").submit();
		//}
  });
});


</script>


</body>
</html>

 <? ob_flush(); ?>