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
	   $res=mysql_query("select * from lms_category where c_id='$filter'");
	   $row=mysql_fetch_array($res);
	   $cat_name=$row["category_name"];
	    
	   
	   ?>	
     <div id="content">		
		
		 <div id="content-header">
			 <h1>Lost Book Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
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
								Lost Book  Details List 
							 </h3>
                             
							 
						 </div>  <!-- /.portlet-header -->
						 <div class="portlet-content">
						 
						   <center> <a href="export_overall_lost_book_report.php"> <button type="button" class="btn btn-warning">Download Excel</button></a></center>
						   
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
										    <th data-filterable="true" data-sortable="true">Category</th>
											 <th data-filterable="true" data-sortable="true" >Book Title</th>
											  <th data-filterable="true" data-sortable="true" >Book Number</th>
                                             <th data-filterable="true" data-sortable="true">Author Name </th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm">Publisher </th>
                                              <th data-filterable="true" data-sortable="true">Purchase Date</th> 
                                             <th data-filterable="false" data-sortable="true" >Shelf No</th>
                                             
										</tr>
									</thead>
									<tbody>
										<?php	
										
										 
											$emp_query="select * from lms_lostbooks order by lb_id desc";
										 
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result))
		{
		    
		    
			$b_id=$emp_display1["book_id"];
			$book_number=$emp_display1["book_number"];
			$emp_display=mysql_fetch_array(mysql_query("select * from lms_book  where b_id='$b_id'"));
			
			$res=mysql_query("select * from lms_category where c_id='$emp_display[category]'");
			$row=mysql_fetch_array($res);
			$cat_name=$row["category_name"];
			
			 
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $cat_name; ?> </td>
                                             <td><?php echo $emp_display["book_title"]; ?> </td>
                                              <td><?php echo $book_number; ?> </td>
                                             <td><?php echo $emp_display["author_name"]; ?> </td>
                                             <td><?php echo $emp_display["publisher"]; ?> </td>
                                            
                                             <td><?php echo $emp_display["purchase_date"]; ?> </td>
                                             
                                             <td><?php echo $emp_display['shelf_no'];?></td>	
                                             
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