<?php
include("header.php");
$sid=$_GET['id'];
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
	   $emp_query1="select * from staff where st_id='$sid'";
		$emp_result1=mysql_query($emp_query1);
		$staff1=mysql_fetch_array($emp_result1);
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> - Leave Details  <a href="emp_leave_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
            <span style="float:right; margin-right:30px;"><b>Filter by Academic Year: </b><?php if($syear && $eyear){ echo $syear." - ".$eyear;}?></span>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">						 
				<div class="portlet-content">	
                         <ul id="myTab1" class="nav nav-tabs">
						<li class="active">
							<a href="#overall" data-toggle="tab">applied Leaves </a>
						</li>
                        <li>
							<a href="#allowance" data-toggle="tab">Yearly Leaves</a>
						</li>
                        <a href="#staffModal" title="Employee Details" style="float:right;"  data-toggle="modal"><button type="button" class="btn btn-warning">Employee Details</button></a> 
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
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="leave_detail.php?syear=<?php echo $syear1."&eyear=".$eyaer1;?>&id=<?php echo $sid;?>"><?php echo $row['y_name'];?></a></li>
                                  <?php } ?>
							  </ul>
							</div>
                    </ul>
                    <div id="myTab1Content" class="tab-content">
						<div class="tab-pane fade in active" id="overall">
<div class="table-responsive"> <center><h4>Applied Leaves ( <?php echo $syear." - ".$eyear;?> )</h4></center>
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
											<th data-sortable="true" width="7%">S.No</th>
											 <th data-filterable="true" data-sortable="true">Applied Date</th>
											 <th data-filterable="true" data-sortable="true">From Date</th>
                                             <th data-filterable="true" data-sortable="true">To Date</th>
                                             <th data-filterable="true" data-sortable="true">Total Days</th>	
                                             <th data-filterable="true" data-sortable="true">Leave Type</th>	
                                             <th data-filterable="true" data-sortable="true">Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$emp_query="select * from staff_leave where st_id=$sid AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5')) order by id desc";
										$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$id=$emp_display["id"];	
			$emp_id=$emp_display["st_id"];	
										?>                          
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["a_date"]; ?> </td>
                                             <td><?php echo $emp_display["f_date"]; ?> </td>
                                             <td><?php echo $emp_display["t_date"]; ?> </td>
                                             <td><?php echo $emp_display["l_total"]; ?> </td>                                             
                                             <td><?php echo $emp_display['l_type_name'];?></td>	
                                             <td><?php if($emp_display['status']=='0'){ ?>
                                <button class="btn btn-small btn-warning" >Pending</button><?php }else if($emp_display['status']=='1'){?><button class="btn btn-small btn-success" >Approved</button> <?php } else{?><button class="btn btn-small btn-primary">Rejected</button><?php } ?></td>
                                             								 
											 <td><a title="view" href="#styledModal<?php echo $id.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="leave_detail_edit.php?id=<?php echo $id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="leave_delete1.php?id=<?php echo $id; ?>&stid=<?php echo $sid;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>
										 </tr>
		<?php 
        
		$emp_count++;
		
        }
        
        ?>							
									</tbody>
								</table>
				</div>			
                </div>

						<div class="tab-pane fade" id="allowance">
									<div class="table-responsive">
                                    <center><h4>Allowance Details</h4></center>
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
											 <th data-filterable="true" data-sortable="true">Leave Type Name</th>
											 <th data-filterable="true" data-sortable="true">approval leave</th>
                                             <th data-filterable="true" data-sortable="true">Total Leave Taken</th>
                                             <th data-filterable="true" data-sortable="true">Leave Remains</th>
                                             <th data-filterable="false" data-sortable="false">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											$emp_query="select * from leavetype order by lt_id asc";										
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$other=$emp_display["other"];
			$lt_id=$emp_display["lt_id"];
			$tleave=0;
			$emp_query1="select * from staff_leave where status='1' AND (st_id=$sid AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			$emp_result1=mysql_query($emp_query1);
			while($emp_display1=mysql_fetch_array($emp_result1))
			{
				$tleave +=$emp_display1['l_total'];
			}
			$rleave=$emp_display["l_total"]-$tleave;
		?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><?php echo $emp_display["lt_name"]; ?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $emp_display["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td>                                   
                                             <td><?php if($other){ echo '<button class="btn btn-small btn-success" >Open</button>';}else{if($rleave<'1'){ ?>
                                <button class="btn btn-small btn-danger" >Closed</button><?php }else{?><button class="btn btn-small btn-success" >Open</button> <?php } }?>
                                			 </td> 
										 </tr>
		<?php         
		$emp_count++;
		$rleave=0;		
        }        
        ?>							
									</tbody>
								</table>
				</div>
						</div>                        
					</div>					

							   <!-- /.table-responsive -->
                               <br>			
                		  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 
 <div id="staffModal" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="../img/Staff/<?php echo $staff1['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
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
					            <td><?php echo $staff1["staff_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>First Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["lname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["s_pname"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $staff1["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $staff1["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($staff1['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $staff1["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $staff1["blood"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $staff1["s_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $staff1["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $staff1["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $staff1["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $staff1["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php echo $staff1["address1"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $staff1["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $staff1["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $staff1["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $staff1["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $staff1["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $staff1["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $staff1["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $staff1["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $staff1["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $staff1["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $staff1["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($staff1['status']=='1'){ ?>
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
										$emp_query1="select * from staff_leave where st_id=$sid AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5')) order by id desc";
		$emp_result1=mysql_query($emp_query1);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$id1=$emp_display1["id"];	
			$emp_id1=$emp_display1["st_id"];			
		?>  
<div id="styledModal<?php echo $id1.$emp_id1;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> - Leave Details</h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Leave Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>From Date</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["f_date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>To Date</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["t_date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Total Leave</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["l_total"] ; ?> Days</td>
					          </tr>
					          <tr>
					            <td>Description</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["l_des"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display1['status']=='0'){ ?>
                                <button class="btn btn-small btn-warning" >Pending</button><?php }else if($emp_display1['status']=='1'){?><button class="btn btn-small btn-success" >Approved</button> <?php } else{?><button class="btn btn-small btn-primary">Rejected</button><?php } ?></td>
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
<script type="text/javascript">
function donut1 () {
	$('#donut-chart1').empty ();

	Morris.Donut({
        element: 'donut-chart1',
        data: [
						<?php
										$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										while($emp_display1=mysql_fetch_array($emp_result1))
										{?>
            {label: '<?php echo $emp_display1["name"]; ?>', value: <?php echo $emp_display1["per_cent"]; ?> },
			<?php } ?>
        ],
        colors: App.chartColors,
        hideHover: true,
        formatter: function (y) { return y + "%" }
    });
}
</script>
</body>
</html>

 <? ob_flush(); ?>
