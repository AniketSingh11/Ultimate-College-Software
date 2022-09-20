 <?php
 include("header.php");  
  $id=$_GET["id"];
  if(isset($_POST["submit"]))
  {
	$sid= mysql_real_escape_string($_POST["st_id"]);
	$a_date= mysql_real_escape_string($_POST["date"]);
	$staff_name= mysql_real_escape_string($_POST["staff_name"]);
	$staff_id= mysql_real_escape_string($_POST["staff_id"]);
	
	$l_type=mysql_real_escape_string($_POST["l_type"]);
	
	$query=mysql_query("select * from leavetype where lt_id='$l_type' ");
	$lv_display=mysql_fetch_array($query);
	$l_type_name=$lv_display["lt_name"];	
	
	$f_date= mysql_real_escape_string($_POST["f_date"]);
	$t_date= mysql_real_escape_string($_POST["t_date"]);
	$l_total= mysql_real_escape_string($_POST["l_total"]);
	$l_dec= mysql_real_escape_string($_POST["l_dec"]);
	$status= mysql_real_escape_string($_POST["status"]);
		
	$sdate_split1= explode('-', $a_date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];	
		  
	$sdate_split2= explode('-', $f_date);		 
		  $f_day=$sdate_split2[0];
		  $f_month=$sdate_split2[1];
		  $f_year=$sdate_split2[2];	
		  
		$sdate_split3= explode('-', $t_date);		 
		  $t_day=$sdate_split3[0];
		  $t_month=$sdate_split3[1];
		  $t_year=$sdate_split3[2];
		  
		  $from_date=$f_year."-".$f_month."-".$f_day;
	$to_date=$t_year."-".$t_month."-".$t_day;	
	
	$query="update staff_leave set st_id='$sid',staff_id='$staff_id', staff_name='$staff_name', l_type='$l_type', l_type_name='$l_type_name', a_date='$a_date', f_date='$f_date', t_date='$t_date', l_total='$l_total', l_des='$l_dec', day='$sdate_day', month='$sdate_month', year='$sdate_year', f_day='$f_day', f_month='$f_month', f_year='$f_year', t_day='$t_day', t_month='$t_month', t_year='$t_year', status='$status', from_date='$from_date', to_date='$to_date' where id='$id' ";
	$result=mysql_query($query);
	
	if($result)
	{	
		header("location:leave_detail_edit.php?id=$id&msg=succ");
	}
	else
	{
		header("location:leave_detail_edit.php?id=$id&msg=err");
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
	   
	   $emp_query="select * from staff_leave where id='$id'";
$emp_result=mysql_query($emp_query);
$employee=mysql_fetch_array($emp_result);
  $s_id=$employee["st_id"];
  $l_status=$employee["status"];
  $emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1><?php echo $employee11['fname']." ".$employee11['lname'];?> - Leave Edit <a href="leave_detail.php?id=<?php echo $s_id;?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						<?php echo $employee11['fname']." ".$employee11['lname'];?> - Leave Edit   
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				<?php 	
if($s_id){
?>
             <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee Name</label>
									<input type="text" id="staff_name" name="staff_name" class="form-control" data-required="true" value="<?php echo $employee11['fname']." ".$employee11['lname'];?>" readonly>
								</div>  
                                <div class="form-group">
									<label for="name">Leave Apply Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="date" name="date" class="form-control" type="text" data-required="true" value="<?php echo date('d-m-Y');?>">
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
									<label for="name">Leave Type</label><br>
									<select id="l_type" name="l_type" class="form-control" data-required="true">
                                    	<option value="">Plese select Employee</option>
                                        <?php 
										$l_type1=$employee['l_type'];
										$emp_query1="select * from leavetype order by lt_id asc";
										$emp_result1=mysql_query($emp_query1);
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$lt_id=$emp_display1["lt_id"];		
											if($l_type1==$lt_id){?>
                                        <option value="<?php echo $lt_id;?>" selected><?php echo $emp_display1["lt_name"]; ?></option>
                                        	<?php } else{?>
                                            <option value="<?php echo $lt_id;?>"><?php echo $emp_display1["lt_name"]; ?></option>
                                  <?php } } ?>								
                            		</select>
								</div>                                   
                        </div>        
<div class="clear"></div><br>
                    <h4 class="heading1">
                                        <b>Leave Details</b>
                                    </h4>
				<div class="col-sm-6">
								<div class="form-group">
									<label for="name">From Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%">
									<input class="form-control txt" type="text" placeholder="Start date" name="f_date" id="dpStart" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-required="true" value="<?php echo $employee['f_date'];?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>
                                <div class="form-group">
									<label for="name">Total Leave</label>
									<input type="text" id="net_salary" name="l_total" class="form-control"  data-required="true" data-type="number" autocomplete="off" readonly value="<?php echo $employee['l_total'];?>">
								</div>   
                                <div class="form-group">
									<label for="name">status</label><br>
									<select id="status" name="status" class="form-control" data-required="true">
                                    	<option value="0" <?php if($l_status == 0){ echo 'selected'; } ?>  >Pending</option>
<option value="2" <?php if($l_status == 2){ echo 'selected'; } ?>  >Rejected</option>
<option value="1" <?php if($l_status == 1){ echo 'selected'; } ?>  >Approved</option>							
                            		</select>
								</div>                              
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name">To Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%">
									<input class="form-control txt" type="text" name="t_date" placeholder="End date" id="dpEnd" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-required="true" value="<?php echo $employee['t_date'];?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>
                                <div class="form-group">
									<label for="name">Description</label>
									<textarea id="deduction_total" name="l_dec" rows="5" class="form-control"><?php echo $employee['l_des'];?></textarea>
								</div>
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
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
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="leave_add.php?emp="+employee;
	  }	
}
$(document).ready(function(){ 
        $(".txt").each(function() { 
            $(this).change(function(){
                leave_total();
            });
        }); 
    });
	
 function leave_total() {	
var a = document.first.f_date.value;
var b = document.first.t_date.value;

var date1 = a;
var date2 = b;

// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
date1 = date1.split('-');
date2 = date2.split('-');

// Now we convert the array to a Date object, which has several helpful methods
date1 = new Date(date1[2], date1[1], date1[0]);
date2 = new Date(date2[2], date2[1], date2[0]);

// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
date1_unixtime = parseInt(date1.getTime() / 1000);
date2_unixtime = parseInt(date2.getTime() / 1000);

// This is the calculated difference in seconds
var timeDifference = date2_unixtime - date1_unixtime;

// in Hours
var timeDifferenceInHours = timeDifference / 60 / 60;

// and finaly, in days :)
var timeDifferenceInDays = timeDifferenceInHours  / 24;

var timeDifferenceInDays =timeDifferenceInDays+1;
//alert(timeDifferenceInDays);
document.first.l_total.value = timeDifferenceInDays;
} 
</script>
</body>
</html>

 <? ob_flush(); ?>