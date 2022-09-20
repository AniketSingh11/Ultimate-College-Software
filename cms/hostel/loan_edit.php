 <?php
 include("header.php");
 $l_id=$_GET["id"];
  if(isset($_POST["submit"]))
  {
	
	$sid1= mysql_real_escape_string($_POST["st_id"]);
	$salary_date= mysql_real_escape_string($_POST["date"]);
	$staff_name= mysql_real_escape_string($_POST["staff_name"]);
	$staff_id= mysql_real_escape_string($_POST["staff_id"]);
	$role= mysql_real_escape_string($_POST["role"]);
	
	$sdate_split1= explode('/', $salary_date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  
	$l_l_m_pay=mysql_real_escape_string($_POST["l_m_pay"]);
	 
	$l_type=mysql_real_escape_string($_POST["loan_type"]);
	
	$query=mysql_query("select * from staff_loan_type where lt_id='$l_type' ");
	$lv_display=mysql_fetch_array($query);
	$l_type_name=$lv_display["name"];
	
	$l_amount=mysql_real_escape_string($_POST["l_t_amount"]);
	$l_interest=mysql_real_escape_string($_POST["l_interest"]);
	$l_terms=mysql_real_escape_string($_POST["l_terms"]);
	$l_m_pay=mysql_real_escape_string($_POST["l_m_pay"]);
	$l_pay=mysql_real_escape_string($_POST["l_t_pay"]);
	$l_t_interest=mysql_real_escape_string($_POST["l_t_inrest"]);
	
	$query="update staff_loan set st_id='$sid1',staff_id='$staff_id', staff_name='$staff_name', staff_type='$role', l_date='$salary_date', l_type='$l_type', l_type_name='$l_type_name', l_amount='$l_amount', l_interest='$l_interest', l_terms='$l_terms', l_pay='$l_pay', l_m_pay='$l_m_pay', l_t_interest='$l_t_interest', day='$sdate_day', month='$sdate_month', year='$sdate_year' where l_id='$l_id' ";
	$result=mysql_query($query);
	if($result)
	{	
		header("location:loan_edit.php?id=$l_id&msg=succ");
	}
	else
	{
		header("location:loan_edit.php?id=$l_id&msg=err");
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
	   
	   $emp_query="select * from staff_loan where l_id='$l_id'";
$emp_result=mysql_query($emp_query);
$employee=mysql_fetch_array($emp_result);
  $s_id=$employee["st_id"];
  $emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);


$loanpay1=mysql_query("SELECT * FROM staff_loan_pay WHERE l_id=$l_id"); 
								  $loanpay=mysql_fetch_array($loanpay1);
								  
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> <?php echo $employee11['fname']." ".$employee11['lname'];?> - Loan Edit <a href="loan_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully edited 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						 <?php echo $employee11['fname']." ".$employee11['lname'];?> - Loan Edit Loan  
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
		     <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee Name</label>
									<input type="text" id="staff_name" name="staff_name" class="form-control" data-required="true" value="<?php echo $employee11['fname']." ".$employee11['lname'];?>" readonly>
								</div>  
                                <div class="form-group">
									<label for="name">Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="date" name="date" class="form-control" type="text" data-required="true" value="<?php echo $employee['l_date'];?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>                                                              
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staff_id" name="staff_id" class="form-control" data-required="true" value="<?php echo $employee11['staff_id'];?>" readonly>
								</div>								
                                <div class="form-group">
									<label for="name">Loan Type</label><br>
									<select id="loan_type" name="loan_type" class="form-control" data-required="true">
                                    	<option value="">Plese select Employee</option>
                                        <?php 
										$lt_id1=$employee['l_type'];
										$emp_query1="select * from staff_loan_type order by lt_id asc";
										$emp_result1=mysql_query($emp_query1);
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$lt_id=$emp_display1["lt_id"];		
											if($lt_id1==$lt_id){?>
                                        <option value="<?php echo $lt_id;?>" selected><?php echo $emp_display1["name"]; ?></option>
                                  <?php }else{ ?>
                                  <option value="<?php echo $lt_id;?>"><?php echo $emp_display1["name"]; ?></option>
                                  <?php } }?>								
                            		</select>
								</div>                                   
                        </div>        
<div class="clear"></div><br>
				<div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Amount</label>
									<input type="text" id="gross_total" name="l_t_amount" class="form-control txt" data-required="true" data-type="number" autocomplete="off" value="<?php echo $employee['l_amount'];?>">
								</div>
                                <div class="form-group">
									<label for="name">Terms Of Month</label>
									<input type="text" id="net_salary" name="l_terms" class="form-control txt"  data-required="true" data-type="number" autocomplete="off" value="<?php echo $employee['l_terms'];?>">
								</div>
                                <div class="form-group">
									<label for="name" class="title">Total Inrest</label>
									<input type="text" id="deduction_total" name="l_t_inrest" class="form-control"  readonly value="<?php echo $employee['l_interest'];?>" >
								</div>
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Rate Of Interest</label>
									<input type="text" id="deduction_total" name="l_interest" class="form-control txt"  data-required="true" data-type="number" autocomplete="off" value="<?php echo $employee['l_interest'];?>">
								</div>
                                <div class="form-group">
									<label for="name" class="title">Monthly Payment</label>
									<input type="text" id="deduction_total" name="l_m_pay" class="form-control"  readonly value="<?php echo $employee['l_m_pay'];?>">
								</div>
                                <div class="form-group">
									<label for="name" class="title">Total Payment</label>
									<input type="text" id="deduction_total" name="l_t_pay" class="form-control"  readonly value="<?php echo $employee['l_pay'];?>">
								</div>
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-12">
                    <?php if(!$loanpay){?>
                    <center>
<div class="form-group">
								<input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
                                <input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
					<?php } else { ?>
                    <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> You can't Edit this Loan Details... Now Loan Payment Processing!!!
			</div>
            <?php } ?>
                                </div>

     </div>        
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
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="loan_add.php?emp="+employee;
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
} 

</script>
</body>
</html>

 <? ob_flush(); ?>