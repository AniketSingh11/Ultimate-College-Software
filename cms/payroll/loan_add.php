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
	$user = $_SESSION['uname'];
	    /*$fdis="allowans34";
	echo $fdisvalue=$_POST[$fdis];*/
	
	$excistlist=mysql_query("SELECT * FROM staff_loan WHERE (st_id=$stid AND o_id=$oid AND d_id=$did) AND status='0'"); 
	$excist=mysql_fetch_array($excistlist);	
	if($excist){
		header("location:loan_add.php?msg=aerr");
	}else{	
  $query="insert into staff_loan(st_id,o_id,d_id,staff_id,staff_name,staff_type,l_date,l_type,l_type_name,l_amount,l_interest,l_terms,l_pay,l_m_pay,l_t_interest,day,month,year,status,login_user_name)values('$stid','$oid','$did','$staff_id','$staff_name','$role','$salary_date','$l_type','$l_type_name','$l_amount','$l_interest','$l_terms','$l_pay','$l_m_pay','$l_t_interest','$sdate_day','$sdate_month','$sdate_year','0','$user')";
	$result=mysql_query($query);
	if($result)
	{	
		header("location:loan_add.php?msg=succ");
	}
	else
	{
		header("location:loan_add.php?msg=err");
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
			 <h1> Apply Loan <a href="loan_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Apply Loan  
					 </h3>			<?php if($s_id){ ?> <a href="loan_add.php" style="float:right;"><button type="button" class="btn btn-warning" > Select Another employee</button></a><?php } ?>
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
										$emp_query="select * from staff WHERE relivestatus='0' and status='1' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];		?>
                                        <option value="<?php echo $emp_id.",st";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from others WHERE relivestatus='0' and status='1' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                        <option value="<?php echo $emp_id.",ow";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from driver WHERE relivestatus='0' and status='1' order by fname asc";
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
				 if($type=='st'){		
$emp_query11="select * from staff where st_id='$s_id' and relivestatus='0' and status='1'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['staff_id'];

}else if($type=='ow'){		
$emp_query11="select * from others where o_id='$s_id' and relivestatus='0' and status='1'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['others_id'];

}else if($type=='dr'){		
$emp_query11="select * from driver where d_id='$s_id' and relivestatus='0' and status='1'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['driver_id'];

}
if($s_id){
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
                                <div class="form-group">
									<label for="name">Loan Type</label><br>
									<select id="loan_type" name="loan_type" class="form-control" data-required="true">
                                    	<option value="">Plese select Employee</option>
                                        <?php 
										$emp_query1="select * from staff_loan_type order by lt_id asc";
										$emp_result1=mysql_query($emp_query1);
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$lt_id=$emp_display1["lt_id"];		?>
                                        <option value="<?php echo $lt_id;?>"><?php echo $emp_display1["name"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>                                   
                        </div>        
<div class="clear"></div><br>
				<div class="col-sm-6">
								<div class="form-group">
									<label for="name" class="title">Amount</label>
									<input type="text" id="gross_total" name="l_t_amount" class="form-control txt" data-required="true" data-type="number" autocomplete="off">
								</div>
                                <div class="form-group">
									<label for="name">Terms Of Month</label>
									<input type="text" id="net_salary" name="l_terms" class="form-control txt"  data-required="true" data-type="number" autocomplete="off">
								</div>
                                <div class="form-group">
									<label for="name" class="title">Total Inrest</label>
									<input type="text" id="deduction_total" name="l_t_inrest" class="form-control"  readonly >
								</div>
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Rate Of Interest</label>
									<input type="text" id="deduction_total" name="l_interest" class="form-control txt"  data-required="true" data-type="number" autocomplete="off">
								</div>
                                <div class="form-group">
									<label for="name" class="title">Monthly Payment</label>
									<input type="text" id="deduction_total" name="l_m_pay" class="form-control"  readonly >
								</div>
                                <div class="form-group">
									<label for="name" class="title">Total Payment</label>
									<input type="text" id="deduction_total" name="l_t_pay" class="form-control"  readonly >
								</div>
                    </div>
                    <div class="clear"></div>
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
     <?php }?>     
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
		  window.location="loan_add.php?emp="+arr[0]+"&type="+arr[1];
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