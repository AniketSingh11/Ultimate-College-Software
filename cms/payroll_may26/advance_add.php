<?php
 include("header.php");
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
			$advancetotal=0;
			$emp_query="select a_amount from staff_advance WHERE st_id=$stid AND o_id=$oid AND d_id=$did AND status=0";
				$emp_result=mysql_query($emp_query);
				while($emp_display=mysql_fetch_array($emp_result))
				{
					$advancetotal +=$emp_display["a_amount"];	
				}
  if(isset($_POST["submit"]))
  {
	 // $sid= mysql_real_escape_string($_POST["st_id"]);
	$salary_date= mysql_real_escape_string($_POST["date"]);
	$staff_name= mysql_real_escape_string($_POST["staff_name"]);
	$staff_id= mysql_real_escape_string($_POST["staff_id"]);
	$role= mysql_real_escape_string($_POST["role"]);
	
	$sdate_split1= explode('-', $salary_date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  
	$l_amount=mysql_real_escape_string($_POST["l_amount"]);
	
  	$query="insert into staff_advance(st_id,o_id,d_id,staff_id,staff_name,staff_type,a_date,a_amount,day,month,year,status)values('$stid','$oid','$did','$staff_id','$staff_name','$role','$salary_date','$l_amount','$sdate_day','$sdate_month','$sdate_year','0')";
	$result=mysql_query($query);
	if($result)
	{	
		header("location:advance_add.php?msg=succ");
	}
	else
	{
		header("location:advance_add.php?msg=err");
    }
	}
   ?>
   <style type="text/css">
   .error{ color:#FF0004;}
   </style>
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
			 <h1> Apply Advance Salary <a href="advance_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
				<strong>Error!</strong> This employee already Got Advance amount!!!
			</div>
<?php }if($_GET["msg"] == 'aderr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Too Much Advance amount (or) Loan Payment!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Advance Salary  
					 </h3>			<?php if($s_id){ ?> <a href="advance_add.php" style="float:right;"><button type="button" class="btn btn-warning" > Select Another employee</button></a><?php } ?>
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				<?php if(!$s_id){ ?>  
				 <div class="portlet-content">                      
					<div class="col-sm-12">
				            	<div class="form-group">
									<label for="name">Employee ID</label>
									<select id="employee" name="employee" class="form-control" style="width:50%" onchange="select_employee()">
                                    	<option value="">Plese select Employee</option>
                                        <?php 
										$emp_query="select * from staff WHERE status='1' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];		?>
                                        <option value="<?php echo $emp_id.",st";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from others WHERE status='1' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                        <option value="<?php echo $emp_id.",ow";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from driver WHERE status='1' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["d_id"];?>
                                        <option value="<?php echo $emp_id.",dr";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["driver_id"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>                                
                                
</div>
  			 </div>  <!-- /.portlet-content -->
             <?php 
				 }	
				 $monthly_pay=0;
				 if($type=='st'){		
$emp_query11="select fname,lname,staff_id,s_type from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['staff_id'];
$stype="";

							$emp_rest=mysql_query("select salary from staff_salary where st_id=$s_id order by id desc");
							$emp_salary=mysql_fetch_array($emp_rest);
							$salary=$emp_salary['salary'];
							
							/**************************Loan amount *******************************/	
					$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE st_id=$s_id AND status='0'");
					$loan=mysql_fetch_array($loanlist);
					
					$l_tpay=$loan['l_pay'];
					$totalpay=0;
					
					$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE st_id=$s_id AND l_id='$l_id'");
					while($loanpay1=mysql_fetch_array($loanpaylist))
					{
						$totalpay +=$loanpay1['amount'];
					}
					
					$loanbalance=$l_tpay-$totalpay;
					
					$salary_date1=date("Y-m");
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
					}

}else if($type=='ow'){		
//$emp_query11="select fname,lname,others_id from others where o_id='$s_id'";
$emp_query11="select * from others where o_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	
$stype=$employee11['s_type'];

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['others_id'];

$emp_rest=mysql_query("select salary from staff_salary where o_id=$s_id order by id desc");
							$emp_salary=mysql_fetch_array($emp_rest);
							$salary=$emp_salary['salary'];
							
							
							/**************************Loan amount *******************************/	
					$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE o_id=$s_id AND status='0'");
					$loan=mysql_fetch_array($loanlist);
					
					$l_tpay=$loan['l_pay'];
					$totalpay=0;
					
					$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE o_id=$s_id AND l_id='$l_id'");
					while($loanpay1=mysql_fetch_array($loanpaylist))
					{
						$totalpay +=$loanpay1['amount'];
					}
					
					$loanbalance=$l_tpay-$totalpay;
					
					$salary_date1=date("Y-m");
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
					}

}else if($type=='dr'){		
//$emp_query11="select fname,lname,driver_id from driver where d_id='$s_id'";
$emp_query11="select * from driver where d_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['driver_id'];
$stype=$employee11['s_type'];

$emp_rest=mysql_query("select salary from staff_salary where d_id=$s_id order by id desc");
							$emp_salary=mysql_fetch_array($emp_rest);
							$salary=$emp_salary['salary'];						
							
					
					/**************************Loan amount *******************************/	
					$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE d_id=$s_id AND status='0'");
					$loan=mysql_fetch_array($loanlist);
					
					$l_tpay=$loan['l_pay'];
					$totalpay=0;
					
					$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE d_id=$s_id AND l_id='$l_id'");
					while($loanpay1=mysql_fetch_array($loanpaylist))
					{
						$totalpay +=$loanpay1['amount'];
					}
					
					$loanbalance=$l_tpay-$totalpay;
					
					$salary_date1=date("Y-m");
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
					}
}
if($s_id){
	$salary = $salary-$advancetotal-$monthly_pay;
	if($salary<0){
		$salary=0;
	}
?>
             <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee Name</label>
									<input type="text" id="staff_name" name="staff_name" class="form-control" data-required="true" value="<?php echo $staffname;?>" readonly>
								</div>  
                                <div class="form-group">
									<label for="name">Date</label>
                                    <div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="date" name="date" class="form-control" type="text" data-required="true" value="<?php echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>                                                              
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staff_id" name="staff_id" class="form-control" data-required="true" value="<?php echo $staffid;?>" readonly>
								</div>  
<?php 

if($stype=="0" || $stype==""){?>                                
                                <div class="form-group">
									<label for="name">Amount <span class="error">(Max Amount = <?php echo $salary;?> )</span></label>
									<input type="text" id="gross_total" name="l_amount" class="form-control" data-required="true" data-type="number" data-max="<?php echo $salary;?>"  autocomplete="off">
</div><?php } else {
 $salarys=$emp_salary['salary'];
$sal=$salarys*10;
	?>
<div class="form-group">
									<label for="name">Amount - Your one day salary is <?php echo $salarys.'/-';?>  <span class="error">(Max Amount = <?php echo $sal;?> )</span></label>
									<input type="text" id="gross_total" name="l_amount" class="form-control" data-required="true" data-type="number" data-max="<?php echo $sal;?>"  autocomplete="off">

<?php } ?>
                        </div>        
<div class="clear"></div><br>
			         <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>

     </div>
     <?php } ?>     
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">
 $('#employee').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})
	
 function select_employee() { 
      //var employee = parseFloat(document.getElementById('employee').value);
	  var t=$("#employee").val();
	  //alert(t);
	  var arr = t.split(',');
	  if(t){
		  window.location="advance_add.php?emp="+arr[0]+"&type="+arr[1];
	  }	
}
    $(document).ready(function(){ 
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".txt").each(function() { 
            $(this).keyup(function(){
                loan();
            });
        }); 
    });
	
 function loan() {	 
var a = document.first.l_t_amount.value;
var b = document.first.l_interest.value;
var c = document.first.l_terms.value;

//var n = c * 12;
var n = c;
var r = b/(12*100);
var p = (a * r *Math.pow((1+r),n))/(Math.pow((1+r),n)-1);
var prin = Math.round(p);
var total = Math.round(p*c);
var total_inrest = Math.round(total-a);
document.first.l_m_pay.value = prin;
document.first.l_t_inrest.value = total_inrest;
document.first.l_t_pay.value = total;
/*var mon = Math.round(((n * prin) - a)*100)/100;
document.first.r2.value = mon;
alert(mon);
var tot = Math.round((mon/n)*100)/100;
document.first.r3.value = tot;
for(var i=0;i<n;i++)
{
var z = a * r * 1;
var q = Math.round(z*100)/100;
var t = p - z;
var w = Math.round(t*100)/100;
var e = a-t;
var l = Math.round(e*100)/100;
a=e;
}*/
} 

</script>
</body>
</html>

 <? ob_flush(); ?>