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
	$aid=$_POST['aid'];
		
		$qry=mysql_query("UPDATE agency SET a_name='$aname',a_address='$address',a_person='$person',a_mobile='$mobile' WHERE a_id='$aid'");
    if($qry){
        header("Location:agency_edit.php?aid=$aid&msg=succ");
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
						<p>Your data successfully edited!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="agency.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit Agency</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							<?php 
							$aid=$_GET['aid'];
							$agencylist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
								  $agency=mysql_fetch_array($agencylist);	
							?>
							<form class="form uniformForm validateForm" method="post" action="" >
								
								<div class="field-group">
									<label for="required">Agency Name:</label>
									<div class="field">
										<input type="text" name="aname" id="aname" size="32" value="<?php echo $agency['a_name'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">		
								<label for="message">Address:</label>
			
								<div class="field">
									<textarea name="address" id="address" rows="5" cols="32"><?php echo $agency['a_address'];?></textarea>
								</div>		
							</div> <!-- .field-group -->
                            <div class="field-group">
									<label for="required">Conatct Person Name:</label>
									<div class="field">
										<input type="text" name="person" id="person" size="32" value="<?php echo $agency['a_person'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Mobile No:</label>
									<div class="field">
										<input type="text" name="mobile" id="mobile" size="32" value="<?php echo $agency['a_mobile'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                
								<div class="actions">		
                                <input type="hidden" class="medium" name="aid" value="<?php echo $aid;?>" > 				
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
	
	
</div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>

</body>
</html>
<? ob_flush(); ?>