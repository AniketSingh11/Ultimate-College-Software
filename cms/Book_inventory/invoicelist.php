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
			<h1>Invoice Management</h1>
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
                        <a href="book_sale.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart">Data Table Plugin</h3>		
						</div>
						<div class="widget-content">
                    		<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Invoice No</th>
								<th>Name</th>
                                <th>Class-Group</th>
                                <th>Total</th>
                                <th>Pay Type</th>
								<th>Date</th>
								<th>Details</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
							$count=1;
							$qry=mysql_query("SELECT * FROM invoice WHERE brdid=$brdid AND ay_id=$acyear and i_status='0'");
			  while($row=mysql_fetch_array($qry))
        		{
					$cid=$row['c_id']; 
					$sid=$row['s_id']; 
					$ssid=$row['ss_id']; 
					$class=mysql_query("SELECT * FROM class WHERE c_id=$cid");
			  		$classlist=mysql_fetch_array($class);
					$section=mysql_query("SELECT * FROM section WHERE s_id=$sid");
			  		$sectionlist=mysql_fetch_array($section);
					$agency=mysql_query("SELECT * FROM student WHERE ss_id=$ssid");
			  		$agencylist=mysql_fetch_array($agency);
				
				?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['i_no']; ?></td>
                                <td><?php echo $row['i_name']; ?></td>
                                <td><?php echo $classlist['c_name']." - ".$sectionlist['s_name']; ?></td>
                                <td>Rs <?php echo $row['i_total']; ?></td>
                                <td><?php echo $row['i_ptype']; ?></td>
                                <td><?php echo $row['i_day']." / ".$row['i_month']." / ".$row['i_year']; ?></td>
                                <td class="action"><a href="invoice.php?iid=<?php echo $row['i_id'];?>"><button class="btn btn-primary btn-small">View</button></a></td>
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