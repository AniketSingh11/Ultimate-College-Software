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
			 <h1> Room Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
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
								Room  Details List 
							 </h3>
                             <a href="room_details_add.php" title="Add Employee"><button type="button" class="btn btn-warning">Add Room</button></a>
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Category Type <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <li <?php if(!$filter){ echo 'class="active"';}?>><a href="room_details_list.php">Over All</a></li>
                            <?php 
									$res=mysql_query("select * from hms_category where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<li   <?php if($_GET["filt"]==$row["h_id"]){?>class="active" <?php }?> ><a href="room_details_list.php?filt=<?=$row["h_id"]?>"><?=stripslashes($row["h_name"]);?></a></li>
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
								data-paginate="true">
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true" data-direction="asc">Category</th>
											 <th data-filterable="true" data-sortable="true" >Floor</th>
                                             <th data-filterable="true" data-sortable="true">Room Number </th>		
                                             <th data-filterable="true" data-sortable="true">No.of beds/cart </th>										 
											 <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										if($filter!=""){
											$emp_query="select * from hms_room  where category='$filter' and  status='0' order by date_time desc";
										}else{
											$emp_query="select * from hms_room  where status='0' order by date_time desc";
										}
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$hr_id=$emp_display["hr_id"];
			$category=$emp_display["category"];	
			
			
			$res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
			$row=mysql_fetch_array($res);
			$cat_name=$row["h_name"];
			
			$res=mysql_query("select * from hms_floor where hf_id='$emp_display[floor]'");
			$row=mysql_fetch_array($res);
			$floor_name=$row["floor_name"];
			
			 
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $cat_name; ?> </td>
                                             <td><?php echo $floor_name; ?> </td>
                                             <td><?php echo $emp_display["room_number"]; ?> </td>
                                            
                                             <td><?php echo $emp_display["no_cart"]; ?> </td>
                                            
                                             
                                             								 
											 <td> <a title="edit" href="room_details_edit.php?id=<?php echo $hr_id; ?>"><img src="img/layout/edit.png"/></a>   <a title="delete" href="room_details_delete.php?id=<?php echo $hr_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>   </td>
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
if($filter!=""){
											$emp_query="select * from lms_book  where category='$filter' and status='0' order by book_title asc";
										} else{
											$emp_query="select * from lms_book where status='0'  order by book_title asc";
										}
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["b_id"];		
		?>  
<div id="styledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo   $emp_display["book_title"]; ?> Book Details</h3>
      </div>
      <div class="modal-body">
     
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
                                    <b>Book Details</b>
                                </h4></td>
					          </tr>
                              
                              <tr>
					            <td>Book Titles</td>
					            <td>:</td>
					            <td><?php echo $emp_display["book_title"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Category</td>
					            <td>:</td>
					            <td><?php
					            $res=mysql_query("select * from lms_category where c_id='$emp_display[category]'");
					            $row=mysql_fetch_array($res);
					            $cat_name=$row["category_name"];
					            
					            echo $cat_name; ?></td>
					          </tr>
					          <tr>
					            <td>Author Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["author_name"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Publisher</td>
					            <td>:</td>
					            <td><?php echo $emp_display["publisher"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Edition</td>
					            <td>:</td>
					            <td><?php echo $emp_display["edition"] ; ?></td>
					          </tr>
                            
                              <tr>
					            <td>Book Number</td>
					            <td>:</td>
					            <td><?php echo  $emp_display['book_no'];?></td>
					          </tr>
                              <tr>
					            <td>Book copies(Qty) </td>
					            <td>:</td>
					            <td><?php echo $emp_display["qty"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Shelf No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["shelf_no"] ; ?></td>
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