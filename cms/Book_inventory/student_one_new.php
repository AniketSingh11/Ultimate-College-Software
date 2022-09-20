<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$ss_roll=$_POST['roll'];
	$ss_name=$_POST['name'];
	$ss_gender=$_POST['gender'];
	$sid=$_POST['sid'];
	$cid=$_POST['cid'];
		
		
		$qry=mysql_query("INSERT into student (`ss_roll`, `ss_name`, `ss_gender`,s_id, `c_id`) 
	            	values('$ss_roll','$ss_name','$ss_gender','$sid','$cid')");
    if($qry){
        header("Location:student_one_new.php?sid=$sid&cid=$cid&msg=succ");
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
			<h1>Student Management</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
        <?php 
		$msg=$_GET['msg'];
		if($msg === "succ"){
		?>
        <div class="notify notify-success">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Success Notifty</h3>						
						<p>Your data successfully Created!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="student.php?sid=<?php echo $_GET['sid'];?>&cid=<?php echo $_GET['cid'];?>" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>New Student Details</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							<?php 
							$sid=$_GET['sid'];
							$cid=$_GET['cid'];
							?>
							<form class="form uniformForm validateForm" method="post" action="" >
								
								<div class="field-group">
									<label for="required">Roll No:</label>
									<div class="field">
										<input type="text" name="roll" id="roll" size="32"  class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Student Name:</label>
									<div class="field">
										<input type="text" name="name" id="name" size="32"  class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                 <div class="field-group">		
									<label>Gender<span> * </span>:</label>			
									<div class="field">
										<select name="gender" id="gender" class="validate[required]">
                                        <option value="">Select Gender</option>
											<option value="M">Male</option>
								<option value="F">Female</option>										
										</select>										
									</div>		
								</div> <!-- .field-group -->
                                
								<div class="actions">		
                                <input type="hidden" class="medium" name="sid" value="<?php echo $sid;?>" > 				
								<input type="hidden" class="medium" name="cid" value="<?php echo $cid;?>" > 				
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