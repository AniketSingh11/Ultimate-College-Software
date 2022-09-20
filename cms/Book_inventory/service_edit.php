<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$amount=$_POST['amount'];
	$cid=$_POST['class'];
	$sid=$_POST['section'];
	$seid=$_POST['seid'];
	
		$qry=mysql_query("UPDATE service SET se_price='$amount',c_id='$cid',s_id='$sid' WHERE se_id='$seid'");
    if($qry){
        header("Location:service_edit.php?seid=$seid&msg=succ");
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
			<h1>Service Charges Management</h1>
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
                         <a href="service.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit Service charges Detail</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							<?php 
							$seid=$_GET['seid'];
							$booklist=mysql_query("SELECT * FROM service WHERE se_id=$seid"); 
								  $book=mysql_fetch_array($booklist);
								  $cid=$book['c_id'];	
								  $sid=$book['s_id'];								  
							?>
							<form class="form uniformForm validateForm" method="post" action="" >
								<div class="grid-8">	
						<div class="widget-content">
								 <div class="field-group">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    <?php
                                            $classl = "SELECT c_id,c_name FROM class";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="class" id="class" class="validate[required]" onchange="showCategory(this.value)"> <option value="">Select Class </option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											$sel1 = ($cid == $row1['c_id']) ? "Selected" : "";
                                                echo "<option value='{$row1['c_id']}' $sel1>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>Section / Group<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="section" id="section" class="validate[required]">
											<?php 
						 //echo $msid;
						 	$qry3=mysql_query("SELECT * FROM section WHERE s_id=$sid");
							$row3=mysql_fetch_array($qry3);
							 ?>
                            <option value="<?php echo $row3['s_id']; ?>"><?php echo $row3['s_name']; ?></option>										
										</select>										
									</div>		
								</div> <!-- .field-group -->
                              </div>
                            </div>
                            <div class="grid-8">	
						<div class="widget-content"> 
								<div class="field-group">		
									<label>Notebook Name<span class="error"> * </span>:</label>			
									<div class="field">
                                     <input type="text" name="amount" id="amount" value="<?php echo $book['se_price'];?>" size="32" class="validate[required]" />																				
									</div>		
								</div> <!-- .field-group -->
                            <div class="actions">		
                                <input type="hidden" class="medium" name="seid" value="<?php echo $seid;?>" > 				
									<button type="submit" name="submit" class="btn btn-error">Submit</button>
								</div> <!-- .actions -->
                                </div>
                                </div>
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
<script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("section").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("section").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>