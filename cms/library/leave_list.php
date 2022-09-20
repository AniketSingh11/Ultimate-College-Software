<?php
include("header.php");
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
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
	   $filter=$_GET['filt'];	
	   ?>	
     <div id="content">	
		 <div id="content-header">
			 <h1> Employee Leave Details ( <?php echo $syear." - ".$eyear;?> )</h1><?php if($filter || ($syear && $eyear)){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php if($filter){?>Status = <?php echo $filter." | "; }?> Year : <?php if($syear && $eyear){ echo $syear." - ".$eyear;}?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>
 	 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Employee Leave List  ( <?php echo $syear." - ".$eyear;?> )
							 </h3>
                             <a href="leave_add.php" title="Apply Leave"><button type="button" class="btn btn-warning">Apply Leave</button></a>
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Status <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <li <?php if(!$filter){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>">Over All</a></li>
							    <li <?php if($filter=="Pending"){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=Pending">Pending</a></li>
							    <li <?php if($filter=="Approved"){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=Approved">Approved</a></li>
                                <li <?php if($filter=="Rejected"){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=Rejected">Rejected</a></li>
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Academic Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <?php 
							  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT * FROM year");
							  while($row=mysql_fetch_array($qry))
								{
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];?>
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear1."&eyear=".$eyaer1; if($filter){ echo "&filt=".$filter;}?>"><?php echo $row['y_name'];?></a></li>
                                  <?php } ?>
							  </ul>
							</div>
						 </div>  <!-- /.portlet-header -->
						 <div class="portlet-content">
							 <div class="table-responsive">
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
											 <th data-filterable="true" data-sortable="true">Emp Name </th>
                                             <th data-filterable="true" data-sortable="true">From Date</th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm">To Date</th>
                                             <th data-filterable="true" data-sortable="true">Total Leave</th>                                            
                                             <th data-filterable="true" data-sortable="true" >Leave type</th>
                                             <th data-filterable="false" data-sortable="true" >Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($filter=="Pending"){
											$emp_query="select * from staff_leave where status='0' AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5')) order by id desc";
										}else if($filter=="Approved"){
											$emp_query="select * from staff_leave where status='1' AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5')) order by id desc";
										}else if($filter=="Rejected"){
											$emp_query="select * from staff_leave where status='2' AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5')) order by id desc";
										}else{
											$emp_query="select * from staff_leave where (year=$syear AND month>'5') OR (year=$eyear AND month<='5') order by id desc";
										}										
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$id=$emp_display["id"];	
			$emp_id=$emp_display["st_id"];		
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["staff_name"]; ?> </td>
                                             <td><?php echo $emp_display["f_date"]; ?> </td>
                                             <td><?php echo $emp_display["t_date"]; ?> </td>
                                             <td><?php echo $emp_display["l_total"]; ?> </td>                                             
                                             <td><?php echo $emp_display['l_type_name'];?></td>	
                                             <td><?php if($emp_display['status']=='0'){ ?>
                                <button class="btn btn-small btn-warning" >Pending</button><?php }else if($emp_display['status']=='1'){?><button class="btn btn-small btn-success" >Approved</button> <?php } else{?><button class="btn btn-small btn-primary">Rejected</button><?php } ?></td>
                                             								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="leave_edit.php?id=<?php echo $id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="leave_delete.php?id=<?php echo $id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>
										 </tr>
		<?php         
		$emp_count++;		
        }        
        ?>							
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
						 </div>  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
				<?php
										if($filter=="Pending"){
											$emp_query1="select * from staff_leave where status='0' order by id desc";
										}else if($filter=="Approved"){
											$emp_query1="select * from staff_leave where status='1' order by id desc";
										}else if($filter=="Rejected"){
											$emp_query1="select * from staff_leave where status='2' order by id desc";
										}else{
											$emp_query1="select * from staff_leave order by id desc";
										}
		$emp_result1=mysql_query($emp_query1);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$emp_id=$emp_display1["st_id"];
			$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$emp_id"); 
								  $emp_display=mysql_fetch_array($stafflist);		
		?>  
<div id="styledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["fname"]." ".$emp_display["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="../img/Staff/<?php echo $emp_display['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
        <table class="table">
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
		$emp_count++;		
        }
        ?>	
<?php
include("footer.php");
include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>