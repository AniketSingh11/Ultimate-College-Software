<?php

include("header.php");
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
			 <h1> Employee Allowance & Deduction Details </h1>
		 </div>  <!-- #content-header -->	


		 <div id="content-container">

 <?php if($_GET["msg"] == 'succ') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Your Record Successfully Edited </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>

<?php if($_GET["msg"] == 'delete_succ') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Your Record Successfully Deleted </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>

 <?php if($_GET["msg"] == 'err') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Query Failed </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>


			 <div class="row">

				 <div class="col-md-12">

					 <div class="portlet">

						 <div class="portlet-header">

							 <h3>
								Employee Allowance & Deduction List
							 </h3>                             
                             <p class="add_link"><a href="emp_allw_ded_add.php" ><img src="img/layout/add.png" /></a></p>
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
											 <th data-filterable="true" data-sortable="true">Type</th>
											 <th data-filterable="true" data-sortable="true">Name</th>
                                             <th data-filterable="true" data-sortable="true">Percentage</th>                                           
                                             <th data-filterable="false" data-sortable="true" >Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
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
										?>                                        
										<tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $emp_display["type"]; ?></td>
											 <td><?php echo $emp_display["name"]; ?></td>
											 <td><?php echo $emp_display["per_cent"]; ?></td>
                                             
											 <td><?php if($emp_display['status']==1){echo '<span class="status">Enable</span>';} else if($emp_display['status']==0){echo'<span class="status1">Disable</span>';} ?></td>		
                                             							 
											 <td><a title="view" href="emp_allw_ded_view.php?id=<?php echo $emp_id; ?>"><img src="img/layout/view.png"/></a> <a title="edit" href="emp_allw_ded_edit.php?id=<?php echo $emp_id; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="emp_allw_ded_delete.php?id=<?php echo $emp_id; ?>"><img src="img/layout/delete.png"/></a> </td>
                                             
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