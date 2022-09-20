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
	   $cid=$_GET['cid'];	
	   ?>	
     <div id="content">		
		
		 <div id="content-header">
			 <h1> Other Workers Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> Employee Type = <?php echo $filter;?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>		 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Other Workers Details List 
							 </h3>
                             <a href="ow_details_add.php" title="Add Employee"><button type="button" class="btn btn-warning">Add New</button></a>
							 
							 <?php 
							 $stype=$_GET['stype'];
							 $cid=$_GET['cid'];
							 ?>
							<div class="btn-group" style="float:right; margin-left:10px;">
							<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by salary Type <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <li <?php if($stype==""){?> class="active"<?php }?>><a href="ow_list.php?stype=&cid=<?php if($cid!="") { echo $cid; }?>">Over All</a></li>
                             <li <?php if($stype=="1") { ?> class="active" <?php } ?> ><a href="ow_list.php?stype=1&cid=<?php if($cid!=""){ echo $cid;}?>">Day Salary</a></li>
                             <li  <?php if($stype=="0") { ?> class="active" <?php } ?> ><a href="ow_list.php?stype=0&cid=<?php if($cid!=""){ echo $cid;}?>">Month Salary</a></li>
							  </ul>
							  </div>
							
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Category <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <li <?php if(empty($cid)){?> class="active"<?php }?>><a href="ow_list.php?stype=<?php if($stype!=""){ echo $style; }?>&cid=">All</a></li>
                              <?php 
							  		$classl = "SELECT * FROM others_category";
                                    $result1 = mysql_query($classl) or die(mysql_error());
									while ($row1 = mysql_fetch_assoc($result1)){
								?>
                                <li <?php if($cid==$row1['oc_id']){?> class="active"<?php }?>><a href="ow_list.php?stype=<?php if($stype!=""){ echo $stype;}?>&cid=<?=$row1['oc_id']?>"><?=$row1['category_name']?></a></li><?php } ?>
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
											 <th data-filterable="true" data-sortable="true" data-direction="asc">Emp Name </th>
                                             <th data-filterable="true" data-sortable="true">Category </th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm">Email </th>
                                             <th data-filterable="true" data-sortable="true">Phone No </th>                                             
                                             <th data-filterable="true" data-sortable="true" >Position</th>
                                             <th data-filterable="true" data-sortable="true" >Salary Type</th>
                                             <th data-filterable="false" data-sortable="true" >Salary</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										/* if(!empty($cid) && $cid!="all" && $stype="")
                            {
							$emp_query="SELECT * FROM others where category_id='$cid' AND relivestatus=0 order by fname asc";
                            } */
							 if($cid!="" && $stype=="")
							{                          
                                $emp_query="SELECT * FROM others where category_id='$cid' and relivestatus=0 order by fname asc";
                            }
else if($cid=="" && $stype!="")		
{
	$emp_query="SELECT * FROM others where s_type='$stype' and relivestatus=0 order by fname asc";
}	
else if($cid!="" && $stype!="")		
{
	$emp_query="SELECT * FROM others where s_type='$stype' and category_id='$cid' and relivestatus=0 order by fname asc";
}
else{
	$emp_query="SELECT * FROM others where relivestatus=0 order by fname asc";
}

		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["o_id"];	
			$ocid=$emp_display["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid' AND relivestatus=0");
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
<td><?php if($emp_display['s_type']=="1"){ echo "Day Salary";} else { echo "Month Salary";}?></td>											 
										 	 <?php if($emp_display['s_type']=="0" || $emp_display['s_type']==""){?>
                                             <td><a href="ow_salary_list.php?id=<?php echo $emp_id; ?>" title="Salary Details"><button type="button" class="btn btn-sm btn-success">
								<i class="fa fa-cogs"></i> View
											 </button></a></td><?php } else { ?>  <td><a href="ow_day_salary_list.php?id=<?php echo $emp_id; ?>" title="Salary Details"><button type="button" class="btn btn-sm btn-success">
								<i class="fa fa-cogs"></i> View
											 </button></a></td><?php } ?>                                             								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="ow_details_edit.php?id=<?php echo $emp_id; ?>"><img src="img/layout/edit.png"/></a> 
											  <?php if($_SESSION['admin_type']=="0" || in_array("ow_list.php", $permissions_record_delete) ){ ?>
											 <a title="delete" href="ow_details_delete.php?id=<?php echo $emp_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>
											  <?php } ?>
											 </td>
										 </tr>
		<?php         
		$emp_count++;
        }
        ?>						</tbody>
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
					if(!empty($cid) && $cid!="all")
                            {
							$emp_query="SELECT * FROM others where category_id='$cid' AND relivestatus=0 order by fname asc";
                            }else{                                
                                $emp_query="SELECT * FROM others where  relivestatus=0 order by fname asc";
                            }							
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["o_id"];		
		?>  
<div id="styledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
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
?>
<?php include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>