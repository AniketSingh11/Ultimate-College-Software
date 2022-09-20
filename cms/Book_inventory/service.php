<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
?>
<body>

<div id="wrapper">
	
	<div id="header">
		<h1><a href="dashboard.php">Book Inventory</a></h1>		
		
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
			<h1>Service charges Management</h1>
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
                        <a href="service_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart">Data Table Plugin</h3>		
						</div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Class - Group/section Name</th>
								<th>Amount</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
							$qry=mysql_query("SELECT * FROM service WHERE brdid=$brdid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$cid=$row['c_id']; 
					$sid=$row['s_id']; 
					$class=mysql_query("SELECT * FROM class WHERE c_id=$cid");
			  		$classlist=mysql_fetch_array($class);
					$section=mysql_query("SELECT * FROM section WHERE s_id=$sid");
			  		$sectionlist=mysql_fetch_array($section);
				?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><strong><?php echo $classlist['c_name']." - ".$sectionlist['s_name']; ?></strong> Service charges</td>
                                <td><?php echo $row['se_price']; ?></td>
                                 <td class="action"><a href="service_edit.php?seid=<?php echo $row['se_id'];?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> <a href="service_delete.php?seid=<?php echo $row['se_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
							</tr>	
                            <?php // } } 
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