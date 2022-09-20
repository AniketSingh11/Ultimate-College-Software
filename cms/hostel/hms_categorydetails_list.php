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
	   $filter=$_GET['filt'];	
	   ?>	
     <div id="content">		
		
		 <div id="content-header">
			 <h1> Hostel Category Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> Category Type = <?php echo $filter;?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'delete_succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>	

 <?php if($_GET["msg"] == 'err') { ?>	
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?php echo $_GET["err_msg"]; ?> 
			</div>
<?php } ?>	

<div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Hostel Category Details List 
							 </h3>
                             <a href="hms_categoryhostel_add.php" title="Add Employee"><button type="button" class="btn btn-warning">Add  Hostel Category</button></a>
							 
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
								data-paginate="true">
									<thead>
										<tr>
											<th data-sortable="true" width="8%">S.No</th>
											 <th data-filterable="true" data-sortable="true"><center>Hostel name</center></th>
											  <th data-filterable="true" data-sortable="true"><center>Total Floor</center></th>
											  <th data-filterable="true" data-sortable="true"><center>Total Room</center></th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										 
											$emp_query="select * from hms_category where status='0'";
									 
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$h_id=$emp_display["h_id"];		
			
			$qry1=mysql_query("select * from hms_floor where category='$h_id' and status='0'");
			$tot_floor=mysql_num_rows($qry1);
			
			$qry2=mysql_query("select * from hms_room where category='$h_id' and status='0'");
			$tot_room=mysql_num_rows($qry2);
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><center><?php echo stripslashes($emp_display["h_name"]); ?> </center></td>
                                             <td><center><?php echo $tot_floor." - Floors" ;?> </center></td>
                                              <td><center><?php echo $tot_room." - Rooms" ;?> </center> </td>
                                             								 
											 <td> <a title="edit" href="hms_categorydetails_edit.php?id=<?php echo $h_id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="hms_categorydetails_delete.php?id=<?php echo $h_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>
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
include("footer.php");
?>
<?php include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>