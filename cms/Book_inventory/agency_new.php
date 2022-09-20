<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$aname=$_POST['aname'];
	$address=$_POST['address'];
	$person=$_POST['person'];
	$mobile=$_POST['mobile'];
		
		$sql="INSERT INTO agency (a_id,a_name,a_address,a_person,a_mobile) VALUES
('','$aname','$address','$person','$mobile')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:agency_new.php?msg=succ");
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
		
		
		  <?php include 'sidebar.php';?>
	 </div> <!-- #sidebar -->
	
	<div id="content">		
		
		<div id="contentHeader">
			<h1>Agency Management</h1>
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
                         <a href="agency.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Add New Agency Details</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							
							<form class="form uniformForm validateForm" method="post" action="" >
								
								<div class="field-group">
									<label for="required">Agency Name:</label>
									<div class="field">
										<input type="text" name="aname" id="aname" size="32" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">		
								<label for="message">Address:</label>
			
								<div class="field">
									<textarea name="address" id="address" rows="5" cols="32"></textarea>
								</div>		
							</div> <!-- .field-group -->
                            <div class="field-group">
									<label for="required">Conatct Person Name:</label>
									<div class="field">
										<input type="text" name="person" id="person" size="32" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Mobile No:</label>
									<div class="field">
										<input type="text" name="mobile" id="mobile" size="32" class="validate[required]" />	
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
</html><? ob_flush(); ?>