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
	  //die();
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
	$h_type= mysql_real_escape_string($_POST["h_type"]);
	
	
	$re_leave= mysql_real_escape_string($_POST["re_leave"]);
		
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
		      
	if(($l_total>$re_leave) && $re_leave!="other"){
		header("location:leave_add.php?msg=ltotal");
		exit;
	}		
	
	$from_date=$f_year."-".$f_month."-".$f_day;
	$to_date=$t_year."-".$t_month."-".$t_day;
	
$query="insert into staff_leave(st_id,o_id,d_id,staff_id,staff_name,l_type,l_type_name,a_date,f_date,t_date,l_total,l_des,h_type,day,month,year,f_day,f_month,f_year,t_day,t_month,t_year,status,from_date,to_date)values('$stid','$oid','$did','$staff_id','$staff_name','$l_type','$l_type_name','$a_date','$f_date','$t_date','$l_total','$l_dec','$h_type','$sdate_day','$sdate_month','$sdate_year','$f_day','$f_month','$f_year','$t_day','$t_month','$t_year','0','$from_date','$to_date')";
	$result=mysql_query($query) or die("Could not insert data into DB: " . mysql_error());
	//die();
	if($result)
	{	
		header("location:leave_add.php?msg=succ");
	}
	else
	{
		header("location:leave_add.php?msg=err");
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
	   $syear=$ay['s_year'];
	   $eyear=$ay['e_year'];
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Apply Leave <a href="leave_list.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php 
 if($_GET["msg"] == 'succ') { ?>	
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
<?php }
if($_GET["msg"] == 'ltotal') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Total Leaves greater than Remaining leaves!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Apply Leave  
					 </h3>			<?php if($s_id){ ?> <a href="leave_add.php" style="float:right;"><button type="button" class="btn btn-warning" > Select Another employee</button></a><?php } ?>
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
										$emp_query="select * from staff WHERE status='1' and relivestatus='0' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];		?>
                                        <option value="<?php echo $emp_id.",st";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from others WHERE status='1' and relivestatus='0' order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                        <option value="<?php echo $emp_id.",ow";?>"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from driver WHERE status='1' and relivestatus='0' order by fname asc";
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
				 }			
if($type=='st'){		
$emp_query11="select * from staff where st_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['staff_id'];

}else if($type=='ow'){		
$emp_query11="select * from others where o_id='$s_id'";
$emp_result11=mysql_query($emp_query11);
$employee11=mysql_fetch_array($emp_result11);	

$staffname=$employee11['fname']." ".$employee11['lname'];
$staffid=$employee11['others_id'];

}else if($type=='dr'){		
$emp_query11="select * from driver where d_id='$s_id'";
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
									<label for="name">Leave Apply Date</label>
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
									<label for="name">Leave Type</label><br>
									<select id="l_type" name="l_type" class="form-control" data-required="true">
                                    	<option value="">Plese select Employee</option>
                                        <?php 
										$emp_query1="select lt_id,other,l_total,lt_name from leavetype order by lt_id asc";
										$emp_result1=mysql_query($emp_query1);
										$error="";
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$lt_id=$emp_display1["lt_id"];	
											
											$other=$emp_display1["other"];
											$tleave=0;
											$emp_query2="select l_total from staff_leave where status='1' AND ((st_id=$stid AND o_id=$oid AND d_id=$did) AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";	
											$emp_result2=mysql_query($emp_query2);
											while($emp_display2=mysql_fetch_array($emp_result2))
											{
												$tleave +=$emp_display2['l_total'];
											}
											$rleave=$emp_display1["l_total"]-$tleave;	
											if(($rleave>0 && $other==0) || $other){
											?>
                                        <option value="<?php echo $lt_id;?>"><?php echo $emp_display1['lt_name']; ?></option>
                                  <?php }else{ $error .=$emp_display1['lt_name'].","; }
								   } ?>								
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
									<input class="form-control txt" type="text" placeholder="Start date" name="f_date" id="dpStart"  data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-required="true">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>
                                <div class="form-group">
									<label for="name">Total Leave</label>
									<input type="text" id="net_salary" name="l_total" class="form-control"  data-required="true" data-type="number" autocomplete="off" readonly>
								</div> 
                                <div class="form-group">
									<label for="name">If Any HalfDay Leave</label>
									<select id="h_type" name="h_type" class="form-control parsley-validated" onChange="leave_total()">
                                    	<option value="">No Halfday Leave</option>
                                        <option value="E">Evening Leave in From Date</option>
                                        <option value="M">Morning Leave In To Date</option>
                                        <option value="EM">Evening AND Morning</option>
                            		</select>
								</div>   
                                <div id="test">
                                <?php echo $error; if($error){?>
                                <div class="alert alert-danger">
                                    <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                                    <strong><?php echo $error;?></strong> leave type 0 day left for this employee!!!
                                </div>
                                <?php } ?>
        						</div>                             
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name">To Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%">
									<input class="form-control txt" type="text" name="t_date" placeholder="End date" id="dpEnd" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-required="true">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>
                                <div class="form-group">
									<label for="name">Description</label>
									<textarea id="deduction_total" name="l_dec" rows="5" class="form-control"></textarea>
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
 ?>
 <script type="text/javascript">
$(document).ready(function(){
    $("#l_type").change(function(){
        var thiss = $(this);
		var stid = document.first.st_id.value;
        var value = thiss.val(); 
        $.get("leave_calculate.php",{value:value, stid:<?php echo $s_id;?>, type:'<?php echo $type;?>',syear:'<?php echo $syear;?>',eyear:'<?php echo $eyear;?>'},function(data){
			$( "#test" ).html(data);
        });
    });
});
</script>
<?php
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
		  window.location="leave_add.php?emp="+arr[0]+"&type="+arr[1];
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

var ln=$("#h_type").val();
if(ln){
	if(ln=='EM'){
	timeDifferenceInDays=(timeDifferenceInDays-1);
	}else{
	timeDifferenceInDays=(timeDifferenceInDays-.5);
	}
}
if(timeDifferenceInDays=='0'){
	timeDifferenceInDays='0 - Days';
}
//alert(timeDifferenceInDays);
document.first.l_total.value = timeDifferenceInDays;
} 
</script>
</body>
</html>

 <? ob_flush(); ?>