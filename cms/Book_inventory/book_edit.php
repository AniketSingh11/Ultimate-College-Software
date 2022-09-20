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
	$cid=$_POST['class'];
	$sid=$_POST['section'];
	$bid=$_POST['bid'];
	
    $m_price=trim($_POST['m_price']);
	$p_date=trim($_POST['p_date']);
	
	$qty1=$_POST['qty1'];
	
		
		$qry=mysql_query("UPDATE book SET b_name='$bname',b_qtyleft='$qty',b_price='$price',category='$category',c_id='$cid',s_id='$sid',a_id='$aid',m_price='$m_price',p_date='$p_date',qty='$qty1' WHERE b_id='$bid'");
    if($qry){
        header("Location:book_edit.php?bid=$bid&msg=succ");
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
			<?php }if($msg === "err"){
		?>
        <div class="notify notify-error">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Error Notifty</h3>						
						<p>This Notebook already assigned!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="book.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit Book Detail</h3>
						</div> <!-- .widget-header -->
						<div class="widget-content">
							<?php 
							$bid=$_GET['bid'];
							$booklist=mysql_query("SELECT * FROM book WHERE b_id=$bid"); 
								  $book=mysql_fetch_array($booklist);
								  $aid=$book['a_id'];
								  $cid=$book['c_id'];	
								  $sid=$book['s_id'];
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
                                            $classl = "SELECT c_id,c_name FROM class where c_id='$cid'";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="class" id="class" class="validate[required]" onchange="showCategory(this.value)">';
											while ($row1 = mysql_fetch_assoc($result1)):
											$sel1 = ($cid == $row1['c_id']) ? "Selected" : "";
                                                echo "<option value='{$row1['c_id']}' $sel1>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
									</div>		
								</div> <!-- .field-group -->
								<?php 
								$row1=mysql_fetch_array(mysql_query("select * from class where c_id='$cid'"));
								 
								if($row1['c_name']=="XI"||$row1['c_name']=="XII")
								{ ?>
								
                                <div class="field-group">		
									<label>Section / Group<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="section" id="section" class="validate[required]">
											<?php 
						 //echo $msid;
						 	$qry3=mysql_query("SELECT * FROM section WHERE c_id=$cid");
							$row3=mysql_fetch_array($qry3);
							 ?>
                            <option value="<?php echo $row3['s_id']; ?>" <?php if($sid==$row3['s_id']){echo "selected";}?>><?php echo $row3['s_name']; ?></option>										
										</select>										
									</div>		
								</div> <!-- .field-group -->
								<?php } ?>
								
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