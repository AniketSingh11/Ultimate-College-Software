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
			 <h1> Year Types List </h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>		
<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Your Record Successfully Deleted !!!
			</div>
<?php }
$filter=$_GET['filt'];	
?>		 <div class="row">
			 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Year Types List
							 </h3>
                             <a href="leave_type_add.php" title="Add Leave Type"><button type="button" class="btn btn-warning">Add Leave Type</button></a>                           </div>  <!-- /.portlet-header -->
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
											 <th data-filterable="true" data-sortable="true">Leave Type Name</th>
											 <th data-filterable="true" data-sortable="true">Total Leave</th>
                                             <th data-filterable="false" data-sortable="false">Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											$emp_query="select * from leavetype order by lt_id asc";										
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$lt_id=$emp_display["lt_id"];	
			$others=$emp_display["other"];	
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["lt_name"]; ?> </td>
                                             <td><?php echo $emp_display["l_total"]; ?> </td>                                        
                                             <td><?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                			 </td>  	
                                             <td><a title="edit" href="leave_type_edit.php?id=<?php echo $lt_id; ?>"><img src="img/layout/edit.png"/></a><?php if($others==0){?> <a title="delete" href="leave_type_delete.php?id=<?php echo $lt_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> <?php } ?> </td>
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
include("includes/script.php");?>
</body>
</html>
 <? ob_flush(); ?>