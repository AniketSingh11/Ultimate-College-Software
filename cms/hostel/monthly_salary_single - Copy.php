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
	  die();
	  $sid= mysql_real_escape_string($_POST["st_id"]);
	$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	
	$sdate_split1= explode('-', $salary_date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  
		  /*$fdis="allowans34";
	echo $fdisvalue=$_POST[$fdis];*/
	
	$excistlist=mysql_query("SELECT * FROM staff_month_salary WHERE st_id=$sid AND month=$sdate_month AND year=$sdate_year"); 
	$excist=mysql_fetch_array($excistlist);
	
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
	 
	 $loanlist1=mysql_query("select * from staff_loan_pay where l_id=$l_id order by lp_id desc");
	 $loan1=mysql_fetch_array($loanlist1);
	 $l_balance= $loan1["balance"];	
	 if($l_balance){
	 $balance=$l_balance-$loan_pay;			  
	 }else{
		 $balance=$l_pay-$loan_pay;
	 }			  
$query="insert into staff_month_salary(st_id,staff_name,staff_id,date,day,month,year,g_salary,n_salary,d_total,loan_pay,total_leave,doj,position,role,accno)values('$sid','$staff_name','$staff_id','$salary_date','$sdate_day','$sdate_month','$sdate_year','$gross_total','$net_salary','$deduction_total','','','$doj','$position','$role','$accno')";
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
										 $query1="insert into staff_month_salary_summary(st_ms_id,st_id,name,amount,type)values('$lastid','$sid','$aname','$value','0')";
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
										$query1="insert into staff_month_salary_summary(st_ms_id,st_id,name,amount,type)values('$lastid','$sid','$dname','$value1','1')";
	$result1=mysql_query($query1);
										$emp_count1++;
										}
										
								if($l_id){	
								
								$query1=mysql_query("insert into staff_month_salary_summary(st_ms_id,st_id,name,amount,type)values('$lastid','$sid','Loan Payment','$loan_pay','1')");
										$query3=mysql_query("insert into staff_loan_pay(st_ms_id,st_id,l_id,amount,balance,month,year,date)values('$lastid','$sid','$l_id','$loan_pay','$balance','$sdate_month','$sdate_year','$salary_date')");
									if($balance==0){
										$query="update staff_loan set status='1' where l_id='$l_id' ";
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
                                        <?php 
										$emp_query="select * from staff order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];		?>
                                        <option value="<?php echo $emp_id;?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>                                
                                
</div>
  			 </div>  <!-- /.portlet-content -->
             <?php 
			 $s_id=$_GET["emp"];
$emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	if($s_id){
	$emp_query0="select * from staff_salary where st_id=$s_id order by id desc";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$allowance = explode( ',', $salarylist["allowance"]);
$deduction = explode( ',', $salarylist["deduction"]); 
if($salarylist){	
$fixed=$salarylist['salary'];

$loanlist=mysql_query("select * from staff_loan WHERE st_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);
$monthly_pay=$loan['l_m_pay'];
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
?>
             <div class="portlet-content">
     <p class="title">Salary Details :</p> 
     <div class="col-sm-6">
     <div class="form-group">
									<label for="name">Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date" name="salary_date" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
								<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staff_id" name="staff_id" class="form-control" data-required="true" value="<?php echo $employee11['staff_id'];?>" readonly>
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
                                <input type="hidden" name="Accno" value="<?php echo  $employee11['b_acc_no'];?>"/>
                                <input type="hidden" name="doj" value="<?php echo  $employee11['doj'];?>"/>
                                <input type="hidden" name="position" value="<?php echo $employee11['position'];?>"/>
                                <input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
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
  <div id="hiddendata">                  
     <div class="col-sm-6">
                                <p class="title">Allowance :</p> 
                                <div class="form-group">
                            <?php
							$gross_total=0;
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
											?>
                                        <div class="form-group">
                                            <label for="name"><?php echo $emp_display1["name"];?> </label>
                                            <input type="text" id="allowans<?php echo $emp_count1."".$emp_id1;?>" name="allowans<?php echo $emp_count1."".$emp_id1;?>" class="form-control" data-required="true" value="<?php echo $a_salary; ?>" readonly>
                                        </div>                                        
                                        <?php }else{ ?>
                                        <div class="form-group">
                                            <label for="name"><?php echo $emp_display1["name"];?> </label>
                                            <input type="text" id="allowans<?php echo $emp_count1."".$emp_id1;?>" name="allowans<?php echo $emp_count1."".$emp_id1;?>" class="form-control" data-required="true" value="0" readonly>
                                        </div>
										<?php
										}
										$deduc=0;
                                    $emp_count1++;
                                    }
                                    ?>				              			                
							</div>
                                
</div>
	<div class="col-sm-6">  
                                
                                <p class="title">Deductions :</p> 
                                <?php
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
											?>
                                        <div class="form-group">
                                            <label for="name"><?php echo $emp_display1["name"];?> </label>
                                            <input type="text" id="deduction<?php echo $emp_count1."".$emp_id1;?>" name="deduction<?php echo $emp_count1."".$emp_id1;?>" class="form-control" data-required="true" value="<?php echo $d_salary; ?>" readonly>
                                        </div>                                        
                                        <?php }else{ ?>
                                        <div class="form-group">
                                            <label for="name"><?php echo $emp_display1["name"];?> </label>
                                            <input type="text" id="deduction<?php echo $emp_count1."".$emp_id1;?>" name="deduction<?php echo $emp_count1."".$emp_id1;?>" class="form-control" data-required="true" value="0" readonly>
                                        </div>
                                    <?php 
										}
										$deduc=0;
                                    $emp_count1++;
                                    }
                                    
									if($monthly_pay){
										$deduc_total +=$monthly_pay;?> 
                                    <div class="form-group">
									<label for="name">Loan Payment</label>
									<input type="text" id="loan_pay" name="loan_pay" class="form-control" data-required="true" value="<?php echo $monthly_pay;?>" readonly>
                                    <input type="hidden" id="l_id" name="l_id" class="form-control" value="<?php echo $l_id;?>">
                                    <input type="hidden" id="l_pay" name="l_pay" class="form-control" value="<?php echo $l_pay;?>">
								</div>               
                                <?php } ?>             
                                
</div>
<div class="clear"></div><br>
				<div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Gross Total </label>
									<input type="text" id="gross_total" name="gross_total" class="form-control" data-required="true" value="<?php echo $gross_total;?>" readonly>
								</div>
                                <div class="form-group">
									<label for="name" class="title">Net Salary</label>
									<input type="text" id="net_salary" name="net_salary" class="form-control" value="<?php echo $gross_total-$deduc_total;?>" readonly>
								</div>
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Total Deduction</label>
									<input type="text" id="deduction_total" name="deduction_total" class="form-control" value="<?php echo $deduc_total;?>" readonly>
								</div>
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

     </div>
     <?php }else{ ?>
     <br>
     	<div class="alert alert-warning">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">??</a>
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
		//alert("test");
		var stid = document.monthlysal.st_id.value;
		//alert(stid);
        var value = thiss.val(); 
        $.get("check.php",{value:value, stid:stid},function(data){
            //thiss.parent('li').siblings('li').html(data);			
			$('#hiddendata').hide();
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
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="monthly_salary_single.php?emp="+employee;
	  }	
}
</script>
</body>
</html>

 <? ob_flush(); ?>