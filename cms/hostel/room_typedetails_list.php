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
	   $res=mysql_query("select * from hms_category where h_id='$filter'");
	   $row=mysql_fetch_array($res);
	   $cat_name=$row["h_name"];
	   ?>	
     <div id="content">		
		
		 <div id="content-header">
			 <h1> Room Type Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
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
							 <h3> Room Type  Details List </h3>
                             <a href="room_typedetails_add.php" title="Add Employee"><button type="button" class="btn btn-warning">Add room type</button></a>
						 
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
											<th data-sortable="true">S.No</th>
										 
											 
                                             <th data-filterable="true" data-sortable="true">Room type Name </th>											 
											  
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
	 $emp_query="select * from hms_room_type  where status='0' order by room_type asc";
	 $emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$hrt_id=$emp_display["hrt_id"];	
			 $room_type=stripslashes($emp_display["room_type"]);
			 ?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                            <td><?php echo $room_type;?> </td>
                                            <td> <a title="edit" href="room_typedetails_edit.php?id=<?php echo $hrt_id;?>"><img src="img/layout/edit.png"/></a>   <a title="delete" href="room_typedetails_delete.php?id=<?php echo $hrt_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>   </td>
										 </tr>
		<?php 
        
		$emp_count++; } ?>							
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