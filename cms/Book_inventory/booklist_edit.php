<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$bname=$_POST['bname'];
	$category=$_POST['category'];
	$qty=$_POST['qty'];
	$price=$_POST['price'];
	$aid=$_POST['agency'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	$bid=$_POST['bid'];
	$qty1=$_POST['qty1'];
	
	$m_price=trim($_POST['m_price']);
	$p_date=trim($_POST['p_date']);
		
		$qry=mysql_query("UPDATE book SET b_name='$bname',b_qtyleft='$qty',b_price='$price',category='$category',c_id='$cid',s_id='$sid',a_id='$aid',qty='$qty1',m_price='$m_price',p_date='$p_date' WHERE b_id='$bid'");
    if($qry){
        header("Location:booklist_edit.php?cid=$cid&sid=$sid&bid=$bid&msg=succ");
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
			<h1>Books / Things Management</h1>
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
						<?php 
						$cid=$_GET['cid'];	
								  $sid=$_GET['sid'];	
								  ?>
						<div class="widget-header">
                         <a href="booklist.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit Book/Things Detail</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							<?php 
							$bid=$_GET['bid'];
							$booklist=mysql_query("SELECT * FROM book WHERE b_id=$bid"); 
								  $book=mysql_fetch_array($booklist);
								  $aid=$book['a_id'];
								  $qty1=$book['qty'];									  	
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
                                <div class="field-group">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    <?php
                                            $classl = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                                            $row4=mysql_fetch_array($classl);?>
                                             <input type="text" name="cname" id="cname" value="<?php echo $row4['c_name'];?>" size="32" class="validate[required]" readonly />	
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>Section / Group<span class="error"> * </span>:</label>			
									<div class="field">
											<?php 
						 //echo $msid;
						 	$qry3=mysql_query("SELECT * FROM section WHERE s_id=$sid");
							$row3=mysql_fetch_array($qry3);
							 ?>
                            <input type="text" name="sname" id="sname" value="<?php echo $row3['s_name'];?>" size="32" class="validate[required]" readonly />	
                            		</div>		
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>Category<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="category" id="category" class="validate[required]">
											<option value="">Please select</option>	
                                            <option value="C" <?php if($book['category']=='C'){ echo 'selected'; }?>>Common</option>
                                            <option value="M" <?php if($book['category']=='M'){ echo 'selected'; }?>>Male</option>
								<option value="F" <?php if($book['category']=='F'){ echo 'selected'; }?>>Female</option>										
										</select>										
									</div>	
                                    </div>
                                    <div class="field-group">
									<label for="required">Purchase Date :</label>
									<div class="field">
										<input type="text" name="p_date" id="datepicker1" size="15" value="<?php echo $row3['p_date'];?>" />	
									</div>
								</div> <!-- .field-group -->
                              </div>
                            </div>
                            <div class="grid-8">	
						<div class="widget-content"> 
								<div class="field-group">
									<label for="required">Book/Things Name <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="bname" id="bname" value="<?php echo $book['b_name'];?>" size="32" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                            <div class="field-group">
									<label for="required">Quantity <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="qty" id="qty" size="15" value="<?php echo $book['b_qtyleft'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Marketing price<span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="m_price" id="m_price" size="15" class="validate[required]" value="<?php echo $book['m_price'];?>" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Price <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="price" id="price" size="15" value="<?php echo $book['b_price'];?>" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>No of Qty (give to the student)<span class="error"> * </span>:</label>			
									<div class="field">
                                             <input type="text" name="qty1" id="qty1" value="<?php echo $qty1;?>" size="32" class="validate[required]" />	
									</div>		
								</div> <!-- .field-group -->
                                
								<div class="actions">		
                                <input type="hidden" class="medium" name="cid" value="<?php echo $cid;?>" > 
                                <input type="hidden" class="medium" name="sid" value="<?php echo $sid;?>" > 
                                <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" > 				
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
	  $("#datepicker1").datepicker();
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