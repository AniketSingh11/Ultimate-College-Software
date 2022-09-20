 <?php
 include("header.php");
 $id=$_GET['id'];
$emp_rest=mysql_query("select * from staff_salary_report where id=$id");
							$salary=mysql_fetch_assoc($emp_rest);
  if(isset($_POST["submit"]))
  {
	 // $sid= mysql_real_escape_string($_POST["st_id"]);
	$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	$to=addslashes(trim($_POST["to"]));
	$subject= mysql_real_escape_string($_POST["subject"]);
	$cheque_no= mysql_real_escape_string($_POST["cheque_no"]);
	
	$sdate_split1= explode('-', $salary_date);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
		  
		  $date=mysql_real_escape_string($_POST["date"]);
	$total=$_POST["total"];
	
	$query="update staff_salary_report set date='$date',to_address='$to',subject='$subject',cheque_no='$cheque_no',amount='$total' where id='$id' ";
	$result=mysql_query($query);
	$lastid=mysql_insert_id();
	if($result)
	{	
		header("location:salary_report_edit.php?id=$id&msg=succ");
	}
	else
	{
		header("location:salary_report_add.php?id=$id&msg=err");
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
			 <h1> Salary Report Generate Edit  <a href="salary_report.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Edited 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php }?>
				 <div class="portlet-header">			
					 <h3>						 
						Salary Report Generate Edit 
					 </h3>
                     <?php if($_GET["id"]){?>
                     <a style="float:right" href="salary_report_prt.php?id=<?=$_GET["id"]?>" title="Salary Report Print" target="_blank"><button type="button" class="btn btn-warning">Salary Report Print</button></a>
                     <?php } ?>
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
		     <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
    				 <div class="form-group">
									<label for="name">date</label>
                                    <div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="date" name="date" class="form-control" type="text" data-required="true" value="<?php echo $salary['date'];?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
								<div class="form-group">
									<label for="name">Salary Month</label>
                                    <div class="input-group" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date" name="salary_date" class="form-control" type="text" data-required="true" value="<?php echo $salary['month']."-".$salary['year'];?>" readonly>
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                <div class="form-group">
									<label for="name">Subject</label>
									<input type="text" id="subject" name="subject" class="form-control" data-required="true" value="<?php echo $salary['subject'];?>" />
								</div> 
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">To</label>
									<textarea type="text" id="to" name="to" class="form-control" data-required="true" rows="5"><?php echo $salary['to_address'];?></textarea>
								</div> 
								<div class="form-group">
									<label for="name">Cheque No <span class="error"></span></label>
									<input type="text" id="cheque_no" name="cheque_no" class="form-control" data-required="true" autocomplete="off" value="<?php echo $salary['cheque_no'];?>">
								</div>                                 
                        </div>       
<div class="clear"></div><br>
			         <div class="col-sm-12">
                     <div id="salary">
                     <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">
        					<tr>
                            <th>S.No</th>
                            <th>Teacher's Name</th>
                            <th>Designation</th>
                            <th>AC/No</td>
                            <th>Salary</th>
                            </tr> 
                            <?php
							$sdate_month=$salary['month'];
							$sdate_year=$salary['year'];
							$emp_query="select st_ms_id,st_id,o_id,d_id,n_salary,staff_name,position,accno,n_salary from staff_month_salary where month=$sdate_month and year=$sdate_year order by st_ms_id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							$total=0;
							while($emp_display=mysql_fetch_assoc($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];	
								$bank=0;
								$st_id=$emp_display["st_id"];
								if($st_id && mysql_num_rows(mysql_query("SELECT st_id FROM staff WHERE salarytype=0 AND st_id=$st_id"))){
									$bank=1;
								}
								$o_id=$emp_display["o_id"];	
								if($o_id && mysql_num_rows(mysql_query("SELECT o_id FROM others WHERE salarytype=0 AND o_id=$o_id"))){
									$bank=1;
								}
								$d_id=$emp_display["d_id"];	
								if($d_id && mysql_num_rows(mysql_query("SELECT d_id FROM driver WHERE salarytype=0 AND d_id=$d_id"))){
									$bank=1;
								}
								if($bank=='1'){
									$total +=$emp_display["n_salary"];
									//echo $emp_display["st_ms_id"];
								?>                         
                           <tr>
                           <td><?=$emp_count?></td>
                           <td><?=$emp_display["staff_name"]?></td>
                           <td><?=$emp_display["position"]?></td>
                           <td><?=$emp_display["accno"]?></td>
                           <td><?=$emp_display["n_salary"]?></td>
                           </tr>
                           <?php $emp_count++; }} ?>
                           <tr>
                           <td colspan="4"><b style="float:right">Total</b></td>
                           <td><b><?=$total?></b></td>
                           </tr>
					      </table>
                     </div>
                    <center>
<div class="form-group">
								<input type="hidden" id="total" name="total" class="form-control" value="<?=$total?>">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>
     </div>  
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>