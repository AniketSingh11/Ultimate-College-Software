<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	//$sname=$_POST['sname'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
		
		echo $filename=$_FILES["file"]["tmp_name"];
	
		 if($_FILES["file"]["size"] > 0)
		 {

		  	$file = fopen($filename, "r");
			$count=0;
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
				if($count>0){
					$gender=strtoupper($emapData[3]);
	          //It wiil insert a row to our subject table from our csv file`
	           $sql = "INSERT into student (`ss_roll`, `ss_name`, `ss_gender`,s_id, `c_id`) 
	            	values('$emapData[1]','$emapData[2]','$gender','$sid','$cid')";
	         //we are using mysql_query function. it returns a resource on true else False on error
	         $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if(! $result )
				{
					
						header("Location:student_new.php?sid=$sid&cid=$cid&msg=eonfile");
						exit;
				}
				header("Location:student_new.php?sid=$sid&cid=$cid&msg=succ");
				}
				$count++;
	         }
	         fclose($file);
	        
		 }
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
						<p>Student Records successfully created!!!</p>
					</div>
			<?php } elseif($msg === "eonfile"){ ?>
            <div class="notify notify-error">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Error Notifty</h3>						
						<p>Invalid File : Please Upload CSV File Only!!!</p>
					</div>
            <?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="student.php?sid=<?php echo $_GET['sid'];?>&cid=<?php echo $_GET['cid']; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Add New Student Details</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							
							<form class="form uniformForm validateForm" method="post" action="" enctype="multipart/form-data" >
								
								 <div class="field-group inlineField">	
									<label for="myfile">Student Records:</label>
			
									<div class="field">
										<input type="file" name="file" id="file" required />
									</div>	
                                    <span class="error">* CSV/Excel File</span>
								</div><div class="actions">						
                                <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                                 <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" > 		
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