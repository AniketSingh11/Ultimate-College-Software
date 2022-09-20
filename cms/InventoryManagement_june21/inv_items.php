<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
?>
<body>

<div id="wrapper">
	
	<div id="header">
		<h1><a href="dashboard.php">Inventory Management</a></h1>		
		
		<a href="javascript:;" id="reveal-nav">
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
		</a>
	</div> <!-- #header -->
	
	<div id="search">
		<form>
			<input type="text" name="search" placeholder="Search..." id="searchField" />
		</form>		
	</div> <!-- #search -->
	
	<div id="sidebar">		
		
		 <?php include 'sidebar.php';?>
				
	</div> <!-- #sidebar -->
	
	<div id="content">		
		
		<div id="contentHeader">
			<h1>Product Management</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			<?php 
		$msg=$_GET['msg'];
		if($msg === "dsucc"){
		?>
        <div class="notify notify-success">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Success Notifty</h3>						
						<p>Your data successfully Deleted!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget widget-table">
					
						<div class="widget-header">
                        <a href="inv_items_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart"> Products</h3>		
						</div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
                                <th>Item Name</th>
								<th>Category Name</th>
                                <th>Item Code</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
							$qry=mysql_query("SELECT * FROM inv_items where active=1");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{  
				?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['item_name']; ?></td>
                                
                                <td><?php 
								$catqry=mysql_query("SELECT category_name FROM inv_category where cat_id=".$row['cat_id']);
								$catrow=mysql_fetch_array($catqry);
								echo $catrow['category_name']; ?></td>
                                <td><?php echo $row['item_code']; ?></td>
                                <td><?php if($row['item_status']==1)
										echo "Enable";
									  else
									    echo "Disable";	?></td>
                                 <td class="action"><a href="inv_items_edit.php?itemid=<?php echo $row['item_id'];?>" title="Edit">
                                 <img src="./images/edit.png" alt="edit"></a> 
                                 <a href="inv_items_delete.php?itemid=<?php echo $row['item_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
							</tr>	
                            <?php 
							$count++;
							} ?>																						
						</tbody>
					</table>
						</div> <!-- .widget-content -->
				</div>
			</div> <!-- .grid -->			
		</div> <!-- .container -->		
	</div> <!-- #content -->
	
	<?php 
	include("includes/topnav.php");
	?> <!-- #topNav -->
	
	 <!-- .quickNav -->
	
	
</div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>

</body>
</html>
<? ob_flush(); ?>