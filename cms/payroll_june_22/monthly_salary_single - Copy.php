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
		}
		if($type=='ow'){	
			$stid=0;
			$oid=$s_id;		
		}
		
  if(isset($_POST["submit"]))
  {
	  //die();
	  $sid= mysql_real_escape_string($_POST["st_id"]);
	$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	
	$sdate_split1= explode('-', $salary_date);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
		  $numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $sdate_year);
		  
		  $sdate_day=$numdays;
		  
		  /*$fdis="allowans34";
	echo $fdisvalue=$_POST[$fdis];*/
	if($type=='st'){
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE st_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);
	}
	if($type=='ow'){
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE o_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);	
	}	
	if($excist){
		header("location:monthly_salary_single.php?msg=aerr");
	}else{
			  
	$staff_name= mysql_real_escape_string($_POST["staff_name"]);
	$staff_id= mysql_real_escape_string($_POST["staff_id"]);
	$fixed_salary= mysql_real_escape_string($_POST["fixed_salary"]);
	
	$gross_total= mysql_real_escape_string($_POST["gross_total"]);
	$deduction_total= mysql_real_escape_string($_POST["deduction_total"]);
	$net_salary= mysql_real_escape_string($_POST["net_salary"]);
	
	$doj= mysql_real_escape_string($_POST["doj"]);
	$position= mysql_real_escape_string($_POST["position"]);
	$role= mysql_real_escape_string($_POST["role"]);
	$accno= mysql_real_escape_string($_POST["accno"]);	
	 $l_id= mysql_real_escape_string($_POST["l_id"]);	
	 $loan_pay= mysql_real_escape_string($_POST["loan_pay"]);
	 $l_pay= mysql_real_escape_string($_POST["l_pay"]);	
	 
	 
	   $lob= mysql_real_escape_string($_POST["lob"]);	
	   $tleave= mysql_real_escape_string($_POST["tleave"]);	
	   $tlob= mysql_real_escape_string($_POST["tlob"]);	
	  
	  /*echo $lob." - ".$tleave." - ".$tlob;
	  echo "-".$acyear; 
	  die();*/	  
	  
	 
	 $loanlist1=mysql_query("select * from staff_loan_pay where l_id=$l_id order by lp_id desc");
	 $loan1=mysql_fetch_array($loanlist1);
	 $l_balance= $loan1["balance"];	
	 if($l_balance){
	 $balance=$l_balance-$loan_pay;			  
	 }else{
		 $balance=$l_pay-$loan_pay;
	 }			  
$query="insert into staff_month_salary(st_id,o_id,staff_name,staff_id,date,day,month,year,g_salary,n_salary,d_total,loan_pay,total_leave,doj,position,role,accno,tleave,tlob,ay_id)values('$stid','$oid','$staff_name','$staff_id','$salary_date','$sdate_day','$sdate_month','$sdate_year','$gross_total','$net_salary','$deduction_total','','','$doj','$position','$role','$accno','$tleave','$tlob','$acyear')";
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
										$value=$_POST[$all];
										 $query1="insert into staff_month_salary_summary(st_ms_id,st_id,o_id,name,amount,type)values('$lastid','$stid','$oid','$aname','$value','0')";
	$result1=mysql_query($query1);
										$emp_count1++;
										}
										
	$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										$dname=$emp_display1["name"];		
										$deducs="deduction".$emp_count1."".$emp_id1;
										$value1=$_POST[$deducs];
										$query1="insert into staff_month_salary_summary(st_ms_id,st_id,o_id,name,amount,type)values('$lastid','$stid','$oid','$dname','$value1','1')";
										$result1=mysql_query($query1);
										$emp_count1++;
										}
										
				/************ Leave Details *****************/	
				$leavename="LOB ( Days - ".$tlob." )";						
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,o_id,name,amount,type)values('$lastid','$stid','$oid','$leavename','$lob','2')");
								
					/********* Loan Details **********/													
								if($l_id){									
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,o_id,name,amount,type)values('$lastid','$stid','$oid','Loan Payment','$loan_pay','1')");
										$query3=mysql_query("insert into staff_loan_pay(st_ms_id,st_id,o_id,l_id,amount,balance,month,year,date)values('$lastid','$stid','$oid','$l_id','$loan_pay','$balance','$sdate_month','$sdate_year','$salary_date')");
									if($balance==0){
										$query=mysql_query("update staff_loan set status='1' where l_id='$l_id' ");
									}
								}	
		header("location:monthly_salary_single.php?msg=succ");		
	}
	else
	{
		header("location:monthly_salary_single.php?msg=err");
    }
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
<form id="validate-enhanced" action="" class="form parsley-form" method="post" name="monthlysal" enctype="multipart/form-data">
				 <div class="portlet-content">       
<div class="col-sm-12">
				            	<div class="form-group">
									<label for="name">Employee ID</label>
									<select id="employee" name="employee" class="form-control" style="width:50%" onchange="select_employee()">
                                    	<option value="">Plese select Employee</option>
                                        <option value="">Plese select Employee</option>
                                        <?php 
										$emp_query="select * from staff order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];		?>
                                        <option value="<?php echo $emp_id.",st";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from others order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                        <option value="<?php echo $emp_id.",ow";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from driver order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["b_id"];?>
                                        <option value="<?php echo $emp_id.",dr";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["driver_id"]; ?></option>
                                  <?php }?>							
                            		</select>
								</div>                                
                                
</div>
  			 </div>  <!-- /.portlet-content -->
             <?php 
		if($type=='st'){	 
$emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	$staffid=$employee11['staff_id'];
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
		}
		if($type=='ow'){	 
$emp_query11="select * from others where o_id='$s_id'";
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
		}
		
		
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
}
if($type=='ow'){
$loanlist=mysql_query("select * from staff_loan WHERE o_id=$s_id AND status='0'");
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
                                <input type="hidden" name="role" value="<?php if($type=='st'){echo $employee11['s_type'];}else if($type=='ow'){ echo $ocategory["category_name"];}?>"/>
								</div> 
       </div>                          
       <div id="test">
        </div>
        <div class="clear"></div>
                    <div class="col-sm-12">
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
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#salary_date").change(function(){
        var thiss = $(this);
		var stid = document.monthlysal.st_id.value;
        var value = thiss.val(); 
        $.get("check.php",{value:value, stid:stid, type:'<?php echo $type;?>'},function(data){
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
		  window.location="monthly_salary_single.php?emp="+arr[0]+"&type="+arr[1];
	  }	
 }
</script>
</body>
</html>

 <? ob_flush(); ?>