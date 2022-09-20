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
			<!--<li id="navClass" class="nav active">
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
            <li id="navType" class="nav">
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
			<h1>Section/Group Management</h1>
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
                         <a href="std.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                        <a href="section_new.php?cid=<?php echo $_GET['cid']; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart"><?php
							$cid=$_GET['cid'];
							 $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  echo $class['c_name'];?> Section Details </h3>		
						</div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Section/Group</th>
                                <th>Student details</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
							$cid=$_GET['cid'];
							$qry=mysql_query("SELECT * FROM section WHERE c_id=$cid");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['s_name']; ?></td>
								<td><a href="student.php?sid=<?php echo $row['s_id'];?>&cid=<?php echo $cid;?> "><button class="btn btn-primary btn-small">View</button></a></td>
								 <td class="action"><a href="section_edit.php?sid=<?php echo $row['s_id'];?>&cid=<?php echo $cid;?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> <a href="section_delete.php?sid=<?php echo $row['s_id']; ?>&cid=<?php echo $cid; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
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