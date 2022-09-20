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
	   $l_type1=$_GET['ltype'];	
	   
	   if($l_type1){
		   	$leavetype1=mysql_query("SELECT lt_name FROM leavetype WHERE lt_id='$l_type1'");
			$lleave=mysql_fetch_array($leavetype1);
			$leavetyname=$lleave['lt_name'];
	   }
	   ?>	
     <div id="content">	
		 <div id="content-header">
			 <h1> Employee Leave Details ( <?php echo $syear." - ".$eyear;?> )</h1><?php if($filter || ($syear && $eyear)){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php if($l_type1){?>Leave Type = <?php echo $leavetyname." | "; }?> <?php if($filter){?>Status = <?php echo $filter." | "; }?> Year : <?php if($syear && $eyear){ echo $syear." - ".$eyear;}?></span><?php } ?>
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
                             <a href="leave_list_down.php?filt=<?php echo $filter."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear."&ltype=".$l_type1;?>" title="Download Report"><button type="button" class="btn btn-success">Download Report</button></a> 
				             <a href="leave_list_print.php?filt=<?php echo $filter."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear."&ltype=".$l_type1;?>" title="Print" target="_blank"><button type="button" class="btn btn-success">Print</button></a> 
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Status <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <li <?php if(!$filter){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;if($l_type1){ echo "&ltype=".$l_type1;}?>">Over All</a></li>
							    <li <?php if($filter=="Pending"){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=Pending<?php if($l_type1){ echo "&ltype=".$l_type1;}?>">Pending</a></li>
							    <li <?php if($filter=="Approved"){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=Approved<?php if($l_type1){ echo "&ltype=".$l_type1;}?>">Approved</a></li>
                                <li <?php if($filter=="Rejected"){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=Rejected<?php if($l_type1){ echo "&ltype=".$l_type1;}?>">Rejected</a></li>
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Academic Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <?php 
							  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT s_year,e_year,y_name FROM year ORDER BY ay_id DESC");
							  while($row=mysql_fetch_array($qry))
								{
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];?>
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear1."&eyear=".$eyaer1; if($filter){ echo "&filt=".$filter;}?>"><?php echo $row['y_name'];?></a></li>
                                  <?php } ?>
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Leave Type <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <li <?php if(!$l_type1){ echo 'class="active"';}?>><a href="leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear; if($filter){ echo "&filt=".$filter;}?>">Over All</a></li>
                                <?php 
							  $yearstring=$syear."-".$eyear;
							 $emp_query1="select lt_id,other,l_total,lt_name from leavetype order by lt_id asc";
								$emp_result1=mysql_query($emp_query1);
								while($emp_display1=mysql_fetch_array($emp_result1))
								{
									$lt_id=$emp_display1["lt_id"];	
									$other=$emp_display1["other"];?>
                                  <li <?php if($l_type1==$lt_id){ echo 'class="active"';}?>><a href="leave_list.php?ltype=<?=$lt_id?>&syear=<?php echo $syear;?>&eyear=<?php echo $eyear; if($filter){ echo "&filt=".$filter;}?>"><?php echo $emp_display1["lt_name"];?></a></li>
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
										$emp_query="select * from staff_leave where ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
										if($filter=="Pending"){
											$emp_query.=" AND status='0'";
										}else if($filter=="Approved"){
											$emp_query.=" AND status='1'";
										}else if($filter=="Rejected"){
											$emp_query.=" AND status='2'";
										}
										if($l_type1){
											$emp_query.=" AND l_type='$l_type1'";
										}											
										$emp_query.=" order by id desc";									
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
                                             								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="leave_edit.php?id=<?php echo $id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="leave_delete.php?id=<?php echo $id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>
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
										$emp_query1="select * from staff_leave where ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
										if($filter=="Pending"){
											$emp_query1.=" AND status='0'";
										}else if($filter=="Approved"){
											$emp_query1.=" AND status='1'";
										}else if($filter=="Rejected"){
											$emp_query1.=" AND status='2'";
										}
										if($l_type1){
											$emp_query1.=" AND l_type='$l_type1'";
										}
											
										$emp_query.=" order by id desc";
		$emp_result1=mysql_query($emp_query1);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$id=$emp_display1["id"];	
			$emp_id=$emp_display1["st_id"];
			$st_id=$emp_display1["st_id"];	
			$o_id=$emp_display1["o_id"];
			$d_id=$emp_display1["d_id"];	
			/*$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$emp_id"); 
								  $emp_display=mysql_fetch_array($stafflist);*/
								  
								  if($st_id){		
			$emp_query11="select * from staff where st_id='$st_id'";
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['staff_id'];
			$path="../img/Staff/";
			}
			if($o_id){		
			$emp_query11="select * from others where o_id='$o_id'";
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);	
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['others_id'];
			$ocid=$emp_display["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			$path="../img/others/";
			}
			if($d_id){		
			$emp_query11="select * from driver where d_id='$d_id'";
			$emp_result11=mysql_query($emp_query11);
			$employee11=mysql_fetch_array($emp_result11);	
			
			$staffname=$employee11['fname']." ".$employee11['lname'];
			$staffid=$employee11['driver_id'];
			$path="../img/driver/";
			}
					
		?>  
<div id="styledModal<?php echo $emp_count.''.$id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staffname; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="<?php echo $path.$emp_display['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
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
					            <td><?php echo $staffid; ?></td>
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
					            <td><?php if($d_id){ echo $emp_display["d_pname"]; }else{ echo $emp_display["s_pname"]; }?></td>
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
                              <?php if($st_id){?>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_type"] ; ?></td>
					          </tr>
                              <?php } if($o_id){?>
                              <tr>
					            <td>Category</td>
					            <td>:</td>
					            <td><?php echo $ocategory["category_name"]; ?></td>
					          </tr>
                              <?php } ?>
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
					            <td><?php  if($d_id){ echo $emp_display["address"]; }else{ echo $emp_display["address1"]; } ?></td>
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