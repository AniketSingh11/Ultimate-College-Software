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
			 <h1>Allowance & Deduction Details </h1>
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
							<a href="#overall" data-toggle="tab">Overall</a>
						</li>
                        <li>
							<a href="#allowance" data-toggle="tab">Allowance</a>
						</li>
						<li>
							<a href="#deductions" data-toggle="tab">Deductions</a>
						</li>
                        <a style="float:right;" href="allw_ded_add.php" title="Add New"><button type="button" class="btn btn-warning">Add New</button></a>
					</ul>

					<div id="myTab1Content" class="tab-content">
						<div class="tab-pane fade in active" id="overall">
<div class="table-responsive"> <center><h4>Allowance & Deduction Details</h4></center>
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
											 <th data-filterable="true" data-sortable="true">TYPE</th>
											 <th data-filterable="true" data-sortable="true">NAME</th>
                                             <th data-filterable="true" data-sortable="true">PERCENTAGE</th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm" width="10%">STAUS </th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$emp_query="select * from staff_allw_ded order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];	
										
										if($emp_display["type"]=="Allowance"){
											$process="progress-bar-primary btn-success";
										}else{
											$process="progress-bar-secondary btn-warning";
										}
										?>                          
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $emp_display["type"]; ?></td>
											 <td><?php echo $emp_display["name"]; ?></td>
											 <td><div class="progress progress-striped active">
			  <div class="progress-bar <?php echo $process;?>" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div></td>
                                             
											 <td>
                                             <?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-sm btn-success" >Active</button><?php }else{?><button class="btn btn-sm btn-gray" >Inactive</button> <?php } ?>
                                </td>		
                                             <td>
                                             <?php if($emp_display['basic']!='1'){ ?>
                                             <a title="edit" href="allw_ded_edit.php?id=<?php echo $emp_id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="allw_ded_delete.php?id=<?php echo $emp_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> 
                                             <?php }?>
                                             </td>	
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
											<th data-sortable="true" width="7%">S.No</th>
											 <th data-filterable="true" data-sortable="true">TYPE</th>
											 <th data-filterable="true" data-sortable="true">NAME</th>
                                             <th data-filterable="true" data-sortable="true">PERCENTAGE</th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm" width="10%">STAUS </th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$emp_query="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];	
										
										if($emp_display["type"]=="Allowance"){
											$process="progress-bar-primary btn-success";
										}else{
											$process="progress-bar-secondary btn-warning";
										}
										?>                          
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $emp_display["type"]; ?></td>
											 <td><?php echo $emp_display["name"]; ?></td>
											 <td><div class="progress progress-striped active">
			  <div class="progress-bar <?php echo $process;?>" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div></td>
                                             
											 <td>
                                             <?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-sm btn-success" >Active</button><?php }else{?><button class="btn btn-sm btn-gray" >Inactive</button> <?php } ?>
                                </td>		
                                             <td>
                                             <?php if($emp_display['basic']!='1'){ ?>
                                             <a title="edit" href="allw_ded_edit.php?id=<?php echo $emp_id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="allw_ded_delete.php?id=<?php echo $emp_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> 
                                             <?php }?>
                                              </td>	
										 </tr>
		<?php 
		$emp_count++;
        }
        ?>							
									</tbody>
								</table>
				</div>
						</div>
                        <div class="tab-pane fade" id="deductions">
								<div class="table-responsive">
                                <center><h4>Deductions Details</h4></center>
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
											 <th data-filterable="true" data-sortable="true">TYPE</th>
											 <th data-filterable="true" data-sortable="true">NAME</th>
                                             <th data-filterable="true" data-sortable="true">PERCENTAGE</th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm" width="10%">STAUS </th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$emp_query="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];	
										
										if($emp_display["type"]=="Allowance"){
											$process="progress-bar-primary btn-success";
										}else{
											$process="progress-bar-secondary btn-warning";
										}
										?>                          
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $emp_display["type"]; ?></td>
											 <td><?php echo $emp_display["name"]; ?></td>
											 <td><div class="progress progress-striped active">
			  <div class="progress-bar <?php echo $process;?>" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div></td>
                                             
											 <td>
                                             <?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-sm btn-success" >Active</button><?php }else{?><button class="btn btn-sm btn-gray" >Inactive</button> <?php } ?>
                                </td>		
                                             <td><a title="edit" href="allw_ded_edit.php?id=<?php echo $emp_id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="allw_ded_delete.php?id=<?php echo $emp_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>	
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
                               <br>			
                		<div class="col-md-6">

					<div class="portlet">

						<div class="portlet-header">

							<h3>
								<i class="fa fa-bar-chart-o"></i>
								Allowance Chart
							</h3>

						</div> <!-- /.portlet-header -->

						<div class="portlet-content">

							<div id="donut-chart1" class="chart-holder" style="height: 250px"></div>
							

						</div> <!-- /.portlet-content -->

					</div> <!-- /.portlet -->
				</div>
                <div class="col-md-6">
					<div class="portlet">
						<div class="portlet-header">
							<h3>
								<i class="fa fa-compass"></i>
								Deductions Overview
							</h3>
						</div> <!-- /.portlet-header -->
						<div class="portlet-content">
<?php
										$emp_query2="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result2=mysql_query($emp_query2);
										while($emp_display2=mysql_fetch_array($emp_result2))
										{?>
							<div class="progress-stat">
							
								<div class="stat-header">
									
									<div class="stat-label">
										% <?php echo $emp_display2["name"]; ?> 
									</div> <!-- /.stat-label -->
									
									<div class="stat-value">
										<?php echo $emp_display2["per_cent"]; ?> %
									</div> <!-- /.stat-value -->
									
								</div> <!-- /stat-header -->
								
								<div class="progress progress-striped active">
								  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?php echo $emp_display2["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="50" style="width: <?php echo $emp_display2["per_cent"]; ?>%">
								    <span class="sr-only"><?php echo $emp_display2["per_cent"]; ?> %  Rate</span>
								  </div>
								</div> <!-- /.progress -->
								
							</div> <!-- /.progress-stat -->
<?php } ?>
						</div> <!-- /.portlet-content -->

					</div> <!-- /.portlet -->
                </div>
						 </div>  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
<?php
include("footer.php");
?>
<?php include("includes/script.php");?>
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
