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
			<h1>Books Management</h1>
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
                        <a href="book_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart">Overall Books and Things Details </h3>		
						</div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Book Name</th>
								<th>Qty Sold</th>
                                <th>Qty Left</th>
                                <th>Price</th>
                                <th>Class - Group</th>
                                <th>Category</th>
								<th>Agency</th>
                                <th>Qty to give</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
							$qry=mysql_query("SELECT * FROM book Where type='B' AND brdid=$brdid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{  
        		    $cid=$row['c_id']; 
					$sid=$row['s_id']; 
					$aid=$row['a_id']; 
					$class=mysql_query("SELECT * FROM class WHERE c_id=$cid");
			  		$classlist=mysql_fetch_array($class);
			  		$class_name=$classlist['c_name'];
			  		
			  		if($class_name=="XI STD" || $class_name=="XI" || $class_name=="XII STD" || $class_name=="XII")
			  		{
			  		    $section=mysql_query("SELECT * FROM section WHERE s_id=$sid");
			  		    $sectionlist=mysql_fetch_array($section);
			  		    $section_name=" - ".$sectionlist['s_name'];
			  		}else{
			  		    
			  		    $section_name="";
			  		}
			  		
					
					$agency=mysql_query("SELECT * FROM agency WHERE a_id=$aid");
			  		$agencylist=mysql_fetch_array($agency);
				
				?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['b_name']; ?></td>
                                <td><?php echo $row['b_qtysold']; ?></td>
                                <td><?php echo $row['b_qtyleft']; ?></td>
                                <td><?php echo $row['b_price']; ?></td>
                                <td><?php echo $class_name.$section_name; ?></td>
                                <td><?php if($row['category']=='C')
										echo "Common";
									  elseif($row['category']=='M')
									    echo "Male";
									  else
									    echo "Female";	?></td>
                                <td><?php echo $agencylist['a_name']; ?></td>
                                <td><?php echo $row['qty']; ?></td>
                                 <td class="action"><a href="book_edit.php?bid=<?php echo $row['b_id'];?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> <a href="book_delete.php?bid=<?php echo $row['b_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
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