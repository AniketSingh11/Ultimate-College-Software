<?php
include("header.php");
?>
	<style type="text/css">
	.howler {
		margin: 0 .75em 1em 0;
	}
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
			 <h1>Relieve Details List</h1>
		 </div>  <!-- #content-header -->	


		 <div id="content-container">

 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-sucsess">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong>Your Record Successfully Edited 
			</div>            
<?php } ?>

 <?php if($_GET["msg"] == 'delete_succ') { ?>	
 <div class="alert alert-sucsess">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong>Your Record Successfully Deleted
			</div>
<?php } ?>

 <?php if($_GET["msg"] == 'err') { ?>	
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>Some Error On Your Data
			</div>
<?php } ?>

			 <div class="row">

				 <div class="col-md-12">

					 <div class="portlet">						 

				<div class="portlet-content">	
                         <ul id="myTab1" class="nav nav-tabs">
						<li class="active">
							<a href="#employeerelivedetail" data-toggle="tab">Employee Relieve Detail</a>
						</li>
                        <li>
							<a href="#otherworkerrelivedetail" data-toggle="tab">Other Worker Relieve Detail</a>
						</li>
						<li>
							<a href="#driverrelivedetail" data-toggle="tab">Driver Relieve Detail</a>
						</li>
                        
					</ul>

					<div id="myTab1Content" class="tab-content">
						<div class="tab-pane fade in active" id="employeerelivedetail">
<div class="table-responsive"> <center><h4>Employee Relieve Details List</h4></center>
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true"
							>
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											<th data-filterable="true" data-sortable="true">Emp Code </th>
											<th data-filterable="true" data-sortable="true" data-direction="asc">Emp Name </th>
                                            <th data-filterable="true" data-sortable="true">Role </th>											 
											<th data-filterable="true" class="hidden-xs hidden-sm">Email </th>
                                            <th data-filterable="true" data-sortable="true">Phone No </th>                                             
                                            <th data-filterable="true" data-sortable="true" >Position</th>
                                             
                                            <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
							
 $emp_query="select * from staff where relivestatus=1";
$emp_result=mysql_query($emp_query);
$emp_display=mysql_fetch_array($emp_result);

							?>
										<?php	
										
										if($filter=="Teaching"){
											$emp_query="select * from staff where s_type='Teaching' AND relivestatus=1 order by fname asc";
										}else if($filter=="Non-Teaching"){
											$emp_query="select * from staff where s_type='Non-Teaching' relivestatus=1 order by fname asc";
										}else{
											$emp_query="select * from staff where relivestatus=1 order   by fname asc";
										}
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["st_id"];		
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>
                                             <td><?php echo $emp_display["s_type"]; ?> </td>
                                             <td><?php echo $emp_display["email"]; ?> </td>
                                             <td><?php echo $emp_display["phone_no"]; ?></td> 
                                             <td><?php echo $emp_display['position'];?></td>	

                                             								 
											 <td><a title="view" href="#staffstyledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a>  </td>
										 </tr>
		<?php 
        
		$emp_count++;
		
        }
        
        ?>		
									</tbody>
								</table>
				</div>			
                </div>

						<div class="tab-pane fade" id="otherworkerrelivedetail">
									<div class="table-responsive">
                                    <center><h4>Other Workers Relieve Details List</h4></center>
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true"
							>
							<?php
 $emp_query="select * from others where relivestatus=1";
$emp_result=mysql_query($emp_query);
$emp_display=mysql_fetch_array($emp_result);
							
							
							?>	
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true">Emp Code </th>
											 <th data-filterable="true" data-sortable="true" data-direction="asc">Emp Name </th>
                                             <th data-filterable="true" data-sortable="true">Category </th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm">Email </th>
                                             <th data-filterable="true" data-sortable="true">Phone No </th>                                             
                                             <th data-filterable="true" data-sortable="true" >Position</th>
                                             
											 
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(!empty($cid) && $cid!="all")
                            {
							$emp_query="SELECT * FROM others where category_id='$cid'  AND relivestatus=1 order by fname asc";
                            }else{                                
                                $emp_query="SELECT * FROM others where  relivestatus=1 order by fname asc";
                            }		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["o_id"];	
			$ocid=$emp_display["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category  AND relivestatus=1 WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);	
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["others_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>
                                             <td><?php echo $ocategory["category_name"]; ?></td>
                                             <td><?php echo $emp_display["email"];?></td>
                                             <td><?php echo $emp_display["phone_no"];?></td>                                             
                                             <td><?php echo $emp_display['position'];?></td>	
                                                                                         								 
											 <td><a title="view" href="#otherstyledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> </td>
										 </tr>
		<?php         
		$emp_count++;
        }
        ?>					
		
									</tbody>
								</table>
				</div>
						</div>
                        <div class="tab-pane fade" id="driverrelivedetail">
								<div class="table-responsive">
                                <center><h4>Driver Relieve Details List</h4></center>
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true"
							>
							<?php
							
$emp_query="select * from driver where relivestatus=1";
$emp_result=mysql_query($emp_query);
$emp_display=mysql_fetch_array($emp_result);
							?>
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
                                            <th data-filterable="true" data-sortable="true">Emp Code </th>
											 <th data-filterable="true" data-sortable="true">Category Name </th>
                                             <th data-filterable="true" data-sortable="true">Category </th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm">Gender </th>
                                             <th data-filterable="true" data-sortable="true">Phone No </th>                                             
                                             <th data-filterable="true" data-sortable="true" >Position</th>
                                             
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
	$emp_query="select * from driver where relivestatus=1 order by fname asc";
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			
			$emp_id=$emp_display["d_id"];		
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["driver_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>
                                             <td><?php echo $emp_display["d_type"]; ?> </td>
                                             <td><?php if($emp_display['gender']=='M'){ echo 'Male'; }else{ echo"Female"; } ?> </td>
                                             <td><?php echo $emp_display["phone_no"]; ?> </td>
                                             
                                             <td><?php echo $emp_display['position'];?></td>	
                                             
                                             	<td><a title="view" href="#driverstyledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a>
												
											 
										 </tr>
						
				<?php         
		$emp_count++;		
        }        
        ?>		
									</tbody>
								</table>
				</div>
						</div>
					</div>					

							   <!-- /.table-responsive -->
                       
						 </div>  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 
<?php
					if($filter=="Teaching"){
						$emp_query="select * from staff where s_type='Teaching' AND relivestatus=1 order by fname asc";
					}else if($filter=="Non-Teaching"){
						$emp_query="select * from staff where s_type='Non-Teaching' AND relivestatus=1 order by fname asc";
					}else{
						$emp_query="select * from staff where relivestatus=1 order by fname asc";
					}
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["st_id"];		
		?>  
<div id="staffstyledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["fname"]." ".$emp_display["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="../img/Staff/<?php echo $emp_display['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
        <table class="table">
					        <!--<thead>
					          <tr>
					            <th width="5%">S.no</th>
					            <th>Tilte</th>
					            <th></th>
					            <th>Details</th>
					          </tr>
					        </thead>-->
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Personal Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["staff_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>First Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_pname"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $emp_display["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $emp_display["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($emp_display['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $emp_display["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $emp_display["blood"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $emp_display["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $emp_display["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $emp_display["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address1"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $emp_display["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $emp_display["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $emp_display["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display['relivestatus']=='1'){ ?>
                                <button class="btn btn-small btn-gray" >Inactive</button><?php }else{?> <button class="btn btn-small btn-success" >Active</button><?php } ?></td>
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
		$emp_count++;		
        }        
        ?>	
		
		
<!-- Other details		-->
						<?php
					if(!empty($cid) && $cid!="all")
                            {
							$emp_query="SELECT * FROM others where category_id='$cid' AND relivestatus=1 order by fname asc";
                            }else{                                
                                $emp_query="SELECT * FROM others where relivestatus=1 order by fname asc";
                            }							
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["o_id"];		
		?>  
<div id="otherstyledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["fname"]." ".$emp_display["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="../img/others/<?php echo $emp_display['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
        <table class="table">
					        <!--<thead>
					          <tr>
					            <th width="5%">S.no</th>
					            <th>Tilte</th>
					            <th></th>
					            <th>Details</th>
					          </tr>
					        </thead>-->
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Personal Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["others_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>First Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_pname"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $emp_display["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $emp_display["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($emp_display['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $emp_display["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $emp_display["blood"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $emp_display["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $emp_display["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $emp_display["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address1"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $emp_display["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $emp_display["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $emp_display["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					           <td><?php if($emp_display['relivestatus']=='1'){ ?>
                                <button class="btn btn-small btn-gray" >Inactive</button><?php }else{?> <button class="btn btn-small btn-success" >Active</button><?php } ?></td>
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
		$emp_count++;		
        }        
        ?>	
	<!-- employee   details		-->	
	<?php
					if($filter=="Driver"){
						$emp_query="select * from driver where d_type='Driver' AND relivestatus=1 order by fname asc";
					}else if($filter=="Non-Driver"){
						$emp_query="select * from driver where d_type='Non-Driver' AND relivestatus=1 order by fname asc";
					}else{
						$emp_query="select * from driver where relivestatus=1 order by fname asc";
					}
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		print_r($emp_display);
		while($emp_display=mysql_fetch_array($emp_result))
		{
			
			$emp_id=$emp_display["d_id"];		
		?>  
<div id="driverstyledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["fname"]." ".$emp_display["lname"]; ?> Driver Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="../img/driver/<?php echo $emp_display['photo']; ?>" alt="driver photo" width="200px" height="200px;"></center>
        <table class="table">
					        <!--<thead>
					          <tr>
					            <th width="5%">S.no</th>
					            <th>Tilte</th>
					            <th></th>
					            <th>Details</th>
					          </tr>
					        </thead>-->
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Personal Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Driver ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["driver_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>First Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["d_pname"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $emp_display["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $emp_display["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($emp_display['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $emp_display["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $emp_display["blood"] ; ?></td>
					          </tr>
                              <tr>
					            <td>driver Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["d_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $emp_display["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $emp_display["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $emp_display["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $emp_display["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $emp_display["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $emp_display["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					           <td><?php if($emp_display['relivestatus']=='1'){ ?>
                                <button class="btn btn-small btn-gray" >Inactive</button><?php }else{?> <button class="btn btn-small btn-success" >Active</button><?php } ?></td>
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
		$emp_count++;		
        }        
        ?>	
				
		
<?php
include("footer.php");
?>
<?php include("includes/script.php");?>

</body>
</html>

 <? ob_flush(); ?>
