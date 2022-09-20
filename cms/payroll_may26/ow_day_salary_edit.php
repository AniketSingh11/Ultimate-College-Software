 <?php
 include("header.php");

$id=$_GET['id'];
$oid=$_GET['oid'];
  if(isset($_POST["submit"]))
  {
	$salary= mysql_real_escape_string($_POST["salary"]);
	$date1=date('d-m-Y H:i:s');

	$status= mysql_real_escape_string($_POST["status"]);
    
	$query=mysql_query("update staff_salary set salary='$salary',status='$status' where id=$id");
	if($query)
	{
		header("location:ow_day_salary_edit.php?id=$id&oid=$oid&msg=succ");		
	}
	else
	{
		header("location:ow_day_salary_edit.php?id=$id&oid=$oid&msg=err");		
	}
	
  }
   
    $query=mysql_query("select * from others where o_id='$oid'");
	$staffs=mysql_fetch_array($query);
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
			 <h1> <?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details Edit <a href="ow_day_salary_list.php?id=<?php echo $oid;?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
<?php
			
$emp_query1="select * from staff_salary where id='$id'";
$emp_result1=mysql_query($emp_query1);
$salarylist=mysql_fetch_array($emp_result1);

$salaryid=$salarylist['id'];
?>
				 <div class="portlet-header">			
					 <h3>						 
						<?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details Edit
					 </h3>			
                     <a href="##styledModal" title="Employee Salary Details" data-toggle="modal"><button type="button" class="btn btn-warning">View Details</button></a>	
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Profile Details :</p>    
	 <div class="col-sm-12">
     <div class="col-sm-6">
     	<div class="form-group">
									<label for="name">Salary</label>
									<input type="text" id="salary" name="salary" class="form-control" data-required="true" data-type="number" value="<?php echo $salarylist["salary"] ; ?>"  >
								</div>
	 </div>                      
     
 <div class="col-sm-6">
 <div class="form-group">	
									<label for="validateSelect">Status</label>
									<select name="status" id="status" class="form-control" data-required="true">
										<option value="0" <?php if($salarylist["status"]==0){ echo 'selected'; } ?>> Disable</option>
										<option value="1" <?php if($salarylist["status"]==1){ echo 'selected';}?>> Enable</option>
									</select>
								</div>
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
  			 </div>  <!-- /.portlet-content -->
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 
 <?php 
 $emp_query="select * from staff_salary where id='$salaryid'";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							$emp_display=mysql_fetch_array($emp_result);
						 $emp_id=$emp_display["id"];	
						$allowance = explode( ',', $emp_display["allowance"]);	
						$deduction = explode( ',', $emp_display["deduction"]);
								?>
 <div id="styledModal" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details</h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                            <tr>
					            <td colspan="3"><center><h4 class="heading1"><button type="button" class="btn btn-secondary">Rs/- <b><?php echo $emp_display["salary"] ; ?></b></button></h4></center></td>
					          </tr>
                               
                              <tr>
					            <td>date</td>
					            <td>:</td>
					            <td><?php echo $emp_display["date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?></td>
					          </tr>
					        </tbody>
					      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
 <?php 
 include("footer.php"); 
 ?>
 <?php include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>