<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$nname=htmlspecialchars($_POST['nname']);
	$qty=$_POST['qty'];
	$price=$_POST['price'];
	$aid=$_POST['agency'];
	$nid=$_POST['nid'];
	
	$m_price=trim($_POST['m_price']);
	$p_date=trim($_POST['p_date']);
		
		$qry=mysql_query("UPDATE notebook_purchese SET n_name='$nname',n_qtyleft='$qty',n_price='$price',a_id='$aid',m_price='$m_price',p_date='$p_date' WHERE n_id='$nid'");
    if($qry){
		$qry1=mysql_query("UPDATE book SET b_price='$price',a_id='$aid' WHERE n_id='$nid'");
        header("Location:notebook_edit.php?nid=$nid&msg=succ");
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
			<h1>Books Management</h1>
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
                         <a href="notebook_purchese.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit notebook Detail</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							<?php 
							$nid=$_GET['nid'];
							$booklist=mysql_query("SELECT * FROM notebook_purchese WHERE n_id=$nid"); 
								  $book=mysql_fetch_array($booklist);
								  $aid=$book['a_id'];								  
							?>
							<form class="form uniformForm validateForm" method="post" action="" >
								<div class="grid-8">	
						<div class="widget-content">
								<div class="field-group">		
									<label>Agency<span class="error"> * </span>:</label>			
									<div class="field">
                                     <?php
                                            $agencyl = "SELECT a_id,a_name FROM agency";
                                            $result = mysql_query($agencyl) or die(mysql_error());
                                            echo '<select name="agency" id="agency" class="validate[required]"> <option value="">Select Main menu </option>';
											while ($row = mysql_fetch_assoc($result)):
											$sel = ($aid == $row['a_id']) ? "Selected" : "";
                                                echo "<option value='{$row['a_id']}' $sel>{$row['a_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
								
								<!-- .field-group -->
								
                                <div class="field-group">
									<label for="required">Purchase Date<span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="p_date" id="datepicker" size="15" value="<?php echo $book['p_date'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								
                              </div>
                            </div>
                            <div class="grid-8">	
						<div class="widget-content"> 
								<div class="field-group">
									<label for="required">notebook Name <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="nname" id="nname" value="<?php echo htmlspecialchars($book['n_name']);?>" size="32" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                            <div class="field-group">
									<label for="required">Quantity <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="qty" id="qty" size="15" value="<?php echo $book['n_qtyleft'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								
								 <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Marketing price<span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="m_price" id="m_price" value="<?php echo $book['m_price'];?>" size="15" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								
                                <div class="field-group">
									<label for="required">Price <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="price" id="price" size="15" value="<?php echo $book['n_price'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                
								<div class="actions">		
                                <input type="hidden" class="medium" name="nid" value="<?php echo $nid;?>" > 				
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
$(document).ready(function() {
	 
	  $("#datepicker").datepicker();
});	
	
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