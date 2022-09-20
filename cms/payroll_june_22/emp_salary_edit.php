 <?php
 include("header.php");

$id=$_GET['id'];
$stid=$_GET['stid'];
  if(isset($_POST["submit"]))
  {
	$salary= mysql_real_escape_string($_POST["salary"]);
	$ex_salary= mysql_real_escape_string($_POST["ex_salary"]);
	$extrasalary_type= mysql_real_escape_string($_POST["extrasalary_type"]);
	$date1=date('d-m-Y H:i:s');
	foreach($_POST['allowance'] as $value)
  {
     $allowance.=$value.",";	 
  }
  foreach($_POST['deduction'] as $value1)
  {
     $deduction.=$value1.",";	 
  }
    $allowance=rtrim($allowance, ",");
    $deduction=rtrim($deduction, ",");
	$status= mysql_real_escape_string($_POST["status"]);
    
	$query=mysql_query("update staff_salary set salary='$salary',allowance='$allowance',deduction='$deduction',status='$status',extra_salary='$ex_salary',extra_salary_type='$extrasalary_type' where id=$id");
	if($query)
	{
		$querys=mysql_query("update staff set extra_salary_type='$extrasalary_type',extra_salary='$ex_salary' where st_id=$stid");
		header("location:emp_salary_edit.php?id=$id&stid=$stid&msg=succ");		
	}
	else
	{
		header("location:emp_salary_edit.php?id=$id&stid=$stid&msg=err");		
	}
	
  }
   
    $query=mysql_query("select * from staff where st_id='$stid'");
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
			 <h1> <?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details Edit <a href="emp_salary_list.php?id=<?php echo $stid;?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
     <div class="col-sm-4">
     	<div class="form-group">
									<label for="name">Salary</label>
									<input type="text" id="salary" name="salary" class="form-control" data-required="true" data-type="number" value="<?php echo $salarylist["salary"] ; ?>"  >
								</div>
	 </div>     
<div class="col-sm-4">
     	<div class="form-group">
									<label for="name">Extra Salary</label>
									<input type="text" id="ex_salary" name="ex_salary" class="form-control"  data-type="number"  value="<?php echo $salarylist["extra_salary"]; ?>">
								</div>
	 </div> 
 <div class="col-sm-4">
<div class="form-group">	
									<label for="validateSelect">Extra Salary Type</label>
									<select name="extrasalary_type" class="form-control" data-required="true">
									<option value="">please select</option>
										<option value="0" <?php if($salarylist['extra_salary_type']==0){ echo "selected";}?>>Bank</option>
										<option value="1" <?php if($salarylist['extra_salary_type']==1){ echo "selected";}?>>In Hand</option>
									</select>
								</div>	 
								</div>	 
     <div class="clear"></div>   
<div class="col-sm-6">
                                <h4>Allowance</h4>
	                        <div class="form-group">
                            <?php
							$allowance = explode( ',', $salarylist["allowance"]);	
										$emp_query="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];	
										$basic=$emp_display["basic"];
										foreach ($allowance as $id) {
											if($emp_id==$id){
												$allow=1;
											}
										}?>
				                <div class="checkbox">
									<label>
									    <input type="checkbox" name="allowance[]" class="" <?php if($allow=='1'){ echo "checked";}?>  value="<?php echo $emp_display["id"]; ?>" data-required="true" data-mincheck="1">
									    <?php echo $emp_display["name"]; ?>
                                        <div align="center" class="progress progress-striped active">
			  <div class="progress-bar progress-bar-success btn-success" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div>
									</label>
								</div>
                                <?php $allow=0;} ?>				                
							</div> <!-- /.form-group -->
                                
</div>
<div class="col-sm-6">
                                <h4>Deductions</h4>
	                        <div class="form-group">
				                <?php
								$deduction = explode( ',', $salarylist["deduction"]);		
										$emp_query="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];	
												foreach ($deduction as $id) {
													if($emp_id==$id){
														$deduc=1;
													}
												}?>
				                <div class="checkbox">
									<label>
									    <input type="checkbox" name="deduction[]" class="" <?php if($deduc=='1'){ echo "checked";}?> value="<?php echo $emp_display["id"]; ?>">
									    <?php echo $emp_display["name"]; ?>
                                        <div align="center" class="progress progress-striped active">
			  <div class="progress-bar progress-bar-primary btn-warning" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div>
									</label>
								</div>
                                <?php $deduc=0; } ?>					                
							</div> <!-- /.form-group -->
                            <div class="form-group">	
									<label for="validateSelect">Status</label>
									<select name="status" id="status" class="form-control" data-required="true">
										<option value="0" <?php if($salarylist["status"]==0){ echo 'selected'; } ?>> Disable</option>
										<option value="1" <?php if($salarylist["status"]==1){ echo 'selected';}?>> Enable</option>
									</select>
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
					            <td colspan="3"><h4 class="heading1">
                                    <b>Allowance</b>
                                </h4></td>
					          </tr>
                                <?php
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
														
										?>
                                      <tr>
                                        <td><?php echo $emp_display1["name"];?> </td>
                                        <td>:</td>
                                        <td><div class="progress progress-striped active">
                                          <div class="progress-bar progress-bar-success btn-success" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
                                            <span class="sr-only"> <?php echo $percent; ?>% Complete</span>
                                          </div> <?php echo $percent; ?> % 
                                        </div>
                                        </td>
                                     </tr>
                                    <?php 
														}
													}
                                    $emp_count1++;
                                    }
                                    ?>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Deductions</b>
                                </h4></td>
					          </tr>
                                <?php
										$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;
														
										?>
                                      <tr>
                                        <td><?php echo $emp_display1["name"];?> </td>
                                        <td>:</td>
                                        <td><div class="progress progress-striped active">
                                          <div class="progress-bar progress-bar-primary btn-warning" role="progressbar" aria-valuenow="<?php echo $emp_display1["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display1["per_cent"]; ?>%;">
                                            <span class="sr-only"> <?php echo $emp_display1["per_cent"]; ?>% Complete</span>
                                          </div> <?php echo $emp_display1["per_cent"]; ?> % 
                                        </div>
                                        </td>
                                     </tr>
                                    <?php 
														}
													}
                                    $emp_count1++;
                                    }
                                    ?>      
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