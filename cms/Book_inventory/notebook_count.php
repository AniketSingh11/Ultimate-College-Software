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
		
		<ul id="mainNav">			
			<li id="navDashboard" class="nav">
				<span class="icon-home"></span>
				<a href="dashboard.php">Dashboard</a>				
			</li>
            <li id="navInterface" class="nav">
				<span class="icon-movie"></span>
				<a href="book_sale.php">Book Billing</a>	
			</li>
			<!--<li id="navClass" class="nav">
				<span class="icon-equalizer"></span>
				<a href="std.php">Class Management</a>				
			</li>	-->		
			<li id="navPages" class="nav">
				<span class="icon-document-alt-stroke"></span>
				<a href="studentlist.php">Student Management</a>				
			</li>	
			
			<li id="navForms" class="nav">
				<span class="icon-article"></span>
				<a href="agency.php">Agency Management</a>
			</li>
			
			<li id="navType" class="nav">
				<span class="icon-info"></span>
				<a href="javascript:;">Book Management</a>	
                <ul class="subNav">
					<li><a href="book.php">Book and Things Overall</a></li>
					<li><a href="booklist.php">Book and Things Single</a></li>					
				</ul>
       			</li>
			<li id="navType" class="nav active">
				<span class="icon-book"></span>
				<a href="javascript:;">NoteBook Management</a>	
                <ul class="subNav">
					<li><a href="notebook_purchese.php">NoteBook Purchase</a></li>
					<li><a href="notebook_alert.php">NoteBook Assign Overall</a></li>
                    <li><a href="notebook_list.php">NoteBook Assign single</a></li>				
				</ul>
			</li>
            <li id="navGrid" class="nav">
				<span class="icon-share"></span>
				<a href="service.php">Service Charges</a>                	
			</li>
			<li id="navGrid" class="nav">
				<span class="icon-layers"></span>
				<a href="invoicelist.php">Invoice Management</a>	
			</li>
		</ul>
				
	</div> <!-- #sidebar -->
	
	<div id="content">		
		
		<div id="contentHeader">
			<h1>Notebook Management</h1>
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
                        	<span class="icon-list"></span>
							<h3 class="icon chart">Low Qty Notebook Details</h3>		
						</div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>NoteBook Name</th>
								<th>Qty Sold</th>
                                <th>Qty Left</th>
                                <th>Price</th>
                                <th>Agency</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
							$qry=mysql_query("SELECT * FROM notebook_purchese WHERE n_qtyleft<'10'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$aid=$row['a_id']; 
					$agency=mysql_query("SELECT * FROM agency WHERE a_id=$aid");
			  		$agencylist=mysql_fetch_array($agency);
				
				?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['n_name']; ?></td>
                                <td><?php echo $row['n_qtysold']; ?></td>
                                <td><?php echo $row['n_qtyleft']; ?></td>
                                <td><?php echo $row['n_price']; ?></td>
                                <td><?php echo $agencylist['a_name']; ?></td>
                                 <td class="action"><a href="notebook_edit.php?nid=<?php echo $row['n_id'];?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> <a href="notebook_delete.php?nid=<?php echo $row['n_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
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