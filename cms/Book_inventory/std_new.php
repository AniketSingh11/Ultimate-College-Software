<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$cname=$_POST['cname'];
		
		$sql="INSERT INTO class (c_id,c_name) VALUES
('','$cname')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:std_new.php?msg=succ");
    }
    exit;
}

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
			</li>-->			
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
			<h1>Class Management</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
        <?php 
		$msg=$_GET['msg'];
		if($msg === "succ"){
		?>
        <div class="notify notify-success">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Success Notifty</h3>						
						<p>Your data successfully created!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="std.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Add New Class</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							
							<form class="form uniformForm validateForm" method="post" action="" >
								
								<div class="field-group">
									<label for="required">Class Name:</label>
									<div class="field">
										<input type="text" name="cname" id="cname" size="20" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								<div class="actions">						
									<button type="submit" name="submit" class="btn btn-error">Submit</button>
								</div> <!-- .actions -->
								
							</form>
							
							
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