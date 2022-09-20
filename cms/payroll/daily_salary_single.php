<?php
include("header.php");
function is_valid_type($file) {
$valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
if (in_array($file['type'], $valid_types))
return 1;
return 0;
}
$s_id=$_GET["emp"];
$type=$_GET["type"];
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
  if(isset($_POST["submit"]))
  {
	  //die();
	  $sid= mysql_real_escape_string($_POST["st_id"]);
	  $hide_advanceamt= mysql_real_escape_string($_POST["hide_advanceamt"]);
	  $hide_loadpay= mysql_real_escape_string($_POST["hide_loadpay"]);
	$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	
	$salary_date1= mysql_real_escape_string($_POST["salary_date1"]);
		  $sdate_split2= explode('-', $salary_date1);		 
		  $sdate_day1=$sdate_split2[0];
		  $sdate_month1=$sdate_split2[1];
		  $sdate_year1=$sdate_split2[2];
		 // $salary_date=$sdate_month1.'-'.$sdate_year1;
		   $sdate_split1= explode('-', $salary_date);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
		  $numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
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
	$d_d=date('d');
	if($type=='st'){
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE st_id=$sid AND month=$sdate_month AND year=$sdate_year and date_day=$d_d"); 
	$excist=mysql_fetch_array($excistlist);
	}else if($type=='ow'){
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE o_id=$sid AND month=$sdate_month AND year=$sdate_year  and date_day=$d_d"); 
	$excist=mysql_fetch_array($excistlist);	
	}else if($type=='dr'){
	$excistlist=mysql_query("SELECT * FROM staff_daily_salary WHERE d_id=$sid AND month=$sdate_month AND year=$sdate_year  and date_day=$d_d"); 
	$excist=mysql_fetch_array($excistlist);	
	}	
	if($excist){
		header("location:daily_salary_single.php?msg=aerr");
	}else{
		

		
		if($type=='ow')
		{	 
			$emp_query11="select * from others where o_id='$s_id' and relivestatus='0' and status='1'";
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
			$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid' ");
			$ocategory=mysql_fetch_array($categorys);
			$role=$ocategory["category_name"];
			$staffid=$employee11['others_id'];
			
			
		} 
		if($type=='dr')
		{	 
			$emp_query11="select * from driver where d_id='$s_id' and relivestatus='0' and status='1'";
			$emp_result11=mysql_query($emp_query11);
			$employee11=mysql_fetch_array($emp_result11);
			$staffid=$employee11['driver_id'];
			$staff_name= $employee11['fname']." ".$employee11['lname'];
			$staff_id= $employee11['driver_id'];
			$doj=$employee11['doj'];
			$position=$employee11['position'];
			$accno=$employee11['b_acc_no'];
			$role=$employee11['d_type'];
		}	
$gross_total= mysql_real_escape_string($_POST["gross_total"]);
$net_salary= mysql_real_escape_string($_POST["net_salary"]);
$l_id= mysql_real_escape_string($_POST["l_id"]);
$advance_pay= mysql_real_escape_string($_POST["advance_pay"]);
$loan_pay= mysql_real_escape_string($_POST["loan_pay"]);
 $deduction_total= mysql_real_escape_string($_POST["deduction_total"]);
$user = $_SESSION['uname'];
$query="insert into staff_daily_salary(st_id,o_id,d_id,staff_name,staff_id,date,day,month,year,g_salary,n_salary,d_total,doj,position,role,ay_id,date_day,date_month,date_year,login_user_name)values('$stid','$oid','$did','$staff_name','$staff_id','$salary_date','$sdate_day','$sdate_month','$sdate_year','$gross_total','$net_salary','$deduction_total','$doj','$position','$role','$acyear','$sdate_day1','$sdate_month1','$sdate_year1','$user')";
//die();
//echo $query;die;
	$result=mysql_query($query);
	$lastid=mysql_insert_id();	
	if($result)
	{
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
		/********* Loan Details **********/		
		
								if($l_id){
									$user = $_SESSION['uname'];	
if($hide_loadpay=='1')	{								
								$query1=mysql_query("insert into staff_daily_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','Loan Payment','$loan_pay','1')");
								$query3=mysql_query("insert into staff_loan_pay(st_ms_id,st_id,o_id,d_id,l_id,amount,balance,day,month,year,date,login_user_name)values('$lastid','$stid','$oid','$did','$l_id','$loan_pay','$balance','$sdate_day1','$sdate_month1','$sdate_year1','$salary_date1','$user')");
								$loanpayid=mysql_insert_id();	
								$query=mysql_query("update staff_daily_salary set lp_id='$loanpayid' where st_ms_id='$lastid' ");
									if($balance<=0){
										$query=mysql_query("update staff_loan set status='1' where l_id='$l_id' ");
									}
								}	
								}
					/********* Advance Salary Details **********/													
								if($advance_pay){	
if($hide_advanceamt=='1'){								
								$query1=mysql_query("insert into staff_daily_salary_summary(st_ms_id,st_id,o_id,d_id,name,amount,type)values('$lastid','$stid','$oid','$did','Advance Salary','$advance_pay','1')");
									foreach ($a_id as $a_value) {
										$query=mysql_query("update staff_advance set status='1',st_ms_id='$lastid' where a_id='$a_value' ");
										 //echo $a_value."<br>";
									 }
								}
								}
	}
	header("location:daily_salary_single.php?msg=succ");	
		/* else
		{
			header("location:daily_salary_single.php?msg=err");
		} */
	}
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
			 <h1> Employee Daily Salary Single Add <a href="daily_salary.php?m=<?php echo date("m");?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						Employee Daily Salary Single Add 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" name="monthlysal" enctype="multipart/form-data">
				 <div class="portlet-content">       
<div class="col-sm-12">
				            	<div class="form-group">
									<label for="name">Employee ID</label>
									<select id="employee" name="employee" class="form-control" style="width:50%" onchange="select_employee()">
                                    	
                                        <option value="">Please select Employee</option>
                                      
                                  <?php
$month=date('m');
$yr=date('Y');		
$d_d=date('d');						  
								  //$emp_query="select * from others WHERE status='1' and s_type='1' and o_id not in (select o_id FROM staff_daily_salary WHERE month =$month and year=$yr ) order by fname asc";
								  $emp_query="select * from others WHERE relivestatus='0' and status='1' and s_type='1' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                        <option value="<?php echo $emp_id.",ow";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $month=date('m');
$yr=date('Y');		
$d_d=date('d');	
								//$emp_query="select * from driver WHERE status='1' and s_type='1' and d_id not in (select d_id FROM staff_daily_salary WHERE month =$month and year=$yr)";
								  $emp_query="select * from driver WHERE relivestatus='0' and status='1' and s_type='1'";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["d_id"];?>
                                        <option value="<?php echo $emp_id.",dr";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["driver_id"]; ?></option>
                                  <?php }?>							
                            		</select>
								</div>                                
                                
</div>
  			 </div>  <!-- /.portlet-content -->
             <?php 
		if($type=='st'){	 
$emp_query11="select * from staff where st_id='$s_id' and relivestatus='0' and status='1'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['staff_id'];
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}else if($type=='ow'){	 
$emp_query11="select * from others where o_id='$s_id' and relivestatus='0' and status='1'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);

$ocid=$employee11["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
				
	$staffid=$employee11['others_id'];
	$emp_query0="select * from staff_salary where o_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}else if($type=='dr'){	 
$emp_query11="select * from driver where d_id='$s_id' and relivestatus='0' and status='1'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['driver_id'];
	$emp_query0="select * from staff_salary where d_id=$s_id order by id desc";
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
									<label for="name">One Day Salary</label>
									<input type="text" id="fixed_salary" name="fixed_salary" class="form-control" data-required="true" value="<?php echo $fixed;?>" readonly>
                                    <input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
                                <input type="hidden" name="accno" value="<?php echo  $employee11['b_acc_no'];?>"/>
                                <input type="hidden" name="doj" value="<?php echo  $employee11['doj'];?>"/>
                                <input type="hidden" name="position" value="<?php echo $employee11['position'];?>"/>
                                <input type="hidden" name="role" value="<?php if($type=='st'){echo $employee11['s_type'];}else if($type=='ow'){ echo $ocategory["category_name"];}else if($type=='dr'){ echo $employee11['d_type'];}?>"/>
								</div> 
       </div>    
<div id="test">	   </div><div id="test_new" style="display:none;">
       <div class="clear"></div>                  
    
        <div class="clear"></div><div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
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
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div> </div></div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 ?>
<script type="text/javascript">
$(document).ready(function(){
  $("#salary_date").change(function(){
        var thiss = $(this);
		var stid = document.monthlysal.st_id.value;
        var value = thiss.val(); 
        $.get("daily_salary_check.php",{value:value, stid:stid, type:'<?php echo $type;?>', gender:'<?php echo $gender;?>'},function(data){
			$( "#test" ).html(data);
        });
    }); 
});
</script>
<?php include("includes/script.php");?>
<script type="text/javascript">
 $('#employee').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})	
 function select_employee() { 
 var t=$("#employee").val();
	  //alert(t);
	  var arr = t.split(',');
	  if(t){
		  window.location="daily_salary_single.php?emp="+arr[0]+"&type="+arr[1];
	  }	
 }
 

 
 
 /* function adv_amt(val)
 {
	// alert(val);
	if($("#ad_amt").is(':checked')){
	var advc_amt=$("#advance_pay").val();
	var deduction_total=$("#deduction_total").val();
	var deduction_total1=$("#deduction_total1").val();
	if($("#loan_amt").is(':checked'))
	{ 
	var loan_amt= $("#loan_pay").val();
	var tot=deduction_total1-advc_amt-loan_amt;
	}
	else
	{
		var tot=deduction_total1-advc_amt;
	}
	$("#deduction_total").val(tot);
	 var net_salary=$("#net_salary").val();
	var gross_total=$("#gross_total").val();
	var fin_tot= gross_total - tot;
	$("#net_salary").val(fin_tot);
	}
	 else{
		
	if($("#loan_amt").is(':checked')){ 
	var loan_amt= $("#loan_pay1").val();
	var deduction_total=$("#deduction_total").val();
	var tot=deduction_total-loan_amt;
	}
	else{
		var tot=$("#deduction_total1").val();
	}

	$("#deduction_total").val(tot);
	var net_salary=$("#net_salary1").val();
$("#net_salary").val(net_salary);
	} 
 } 
 
 function loanamt(val)
 {
	 
	if($("#loan_amt").is(':checked')){
	var loan_pay=$("#loan_pay").val();
	var deduction_total=$("#deduction_total").val();
	if($("#ad_amt").is(':checked'))
	{ 
	var advc_amt=$("#advance_pay").val();
	var tot=deduction_total-advc_amt-loan_pay;
	}
	else
	{
		var tot=deduction_total-loan_pay;
	}
	
	
	$("#deduction_total").val(tot);
	 var net_salary=$("#net_salary").val();
	var gross_total=$("#gross_total").val();
	var fin_tot= gross_total - tot;
	$("#net_salary").val(fin_tot); 
	}
	
	else
	{
	var deduction_total=$("#deduction_total").val();
	if($("#ad_amt").is(':checked'))
	{ 
	var advc_amt=$("#advance_pay1").val();
	var tot=deduction_total-advc_amt;
	}
else{
	var tot=$("#deduction_total1").val();
}	
$("#deduction_total").val(tot);
	}
 } */
 function adv_amt(val)
 {
	var deduction_total1=$("#deduction_total1").val();
	if($("#ad_amt").is(':checked') &&  $("#loan_amt").is(':checked'))
	{
		
		var deduction_total=$("#deduction_total").val();
		var advc_amt1=$("#advance_pay").val();
		var loan_pay1=$("#loan_pay").val();
		if(loan_pay1==undefined)
		{
		var loan_pay=0;	
		}
		else{
		var loan_pay=loan_pay1;	
		}
		if(advc_amt1==undefined)
		{
		var advc_amt=0;	
		}
		else{
		var advc_amt=advc_amt1;	
		}
		//var tot = deduction_total1 - advc_amt - loan_pay;
		var tot = deduction_total1 ;
		var net1 = $("#gross_total").val();
		var fin_tot= net1 - tot;
		if(fin_tot>0)
		{
			$("#test_new").show();
		}
		else
		{
			$("#test_new").hide();
		}
	$("#hide_loadpay").val(1);
	$("#hide_advanceamt").val(1);
	} 
	else if($("#ad_amt").is(':checked') &&  $("#loan_amt").not(':checked'))
	{
		//alert('d');
		var deduction_total=$("#deduction_total").val();
		var advc_amt1=$("#advance_pay").val();
		//var tot = deduction_total1 - advc_amt;
		if(advc_amt1==undefined)
		{
		var advc_amt=0;	
		}
		else{
		var advc_amt=advc_amt1;	
		}
		var tot =  advc_amt;
		var net1 = $("#gross_total").val();
		var fin_tot= net1 - tot;
		if(fin_tot>0)
		{
			$("#test_new").show();
			$("#hiddenid").hide();
		}
		else
		{
			$("#test_new").hide();
		}
	$("#hide_loadpay").val(0);
	$("#hide_advanceamt").val(1);
	}
	else if($("#ad_amt").not(':checked') &&  $("#loan_amt").is(':checked'))
	{
		//alert('e');
		var deduction_total=$("#deduction_total").val();
		var loan_pay1=$("#loan_pay").val();
		//var tot = deduction_total1 - loan_pay;
		var advc_amt1=$("#advance_pay").val();
		
		if(loan_pay1==undefined)
		{
		var loan_pay=0;	
		}
		else{
		var loan_pay=loan_pay1;	
		}
		
		var tot =  loan_pay;
		var net1 = $("#gross_total").val();
		var fin_tot= net1 - tot;
		if(fin_tot>0)
		{
			$("#test_new").show();
			$("#hiddenid").hide();
		}
		else
		{
			$("#test_new").hide();
		}
	$("#hide_loadpay").val(1);
	$("#hide_advanceamt").val(0);
	}
	else
	{
		//alert('f');
		var deduction_total1=$("#deduction_total1").val();
		var advc_amt1=$("#advance_pay").val();
		var loan_pay1=$("#loan_pay").val();
		if(loan_pay1==undefined)
		{
		var loan_pay=0;	
		}
		else{
		var loan_pay=loan_pay1;	
		}
		if(advc_amt1==undefined)
		{
		var advc_amt=0;	
		}
		else{
		var advc_amt=advc_amt1;	
		}
		var tot = deduction_total1 - advc_amt - loan_pay;
		//var tot = deduction_total;
		var net1 = $("#gross_total").val();
		var fin_tot= net1 -  tot;
		if(fin_tot>0)
		{
			$("#test_new").show();
			$("#hiddenid").hide();
		}
		else
		{
			$("#test_new").hide();
		}
	$("#hide_loadpay").val(0);
	$("#hide_advanceamt").val(0);
	}
	$("#deduction_total").val(tot);
	$("#net_salary").val(fin_tot);
 }

</script>
</body>
</html>

 <? ob_flush(); ?>