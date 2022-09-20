<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$category=$_POST['category'];
	$itemname=$_POST['itemname'];
	$itemcode=$_POST['itemcode'];
	$status=$_POST['status'];
	$itemid=$_POST['itemid'];
	
	$qry=mysql_query("UPDATE inv_items SET cat_id='$category',item_name='$itemname',item_code='$itemcode',item_status='$status' WHERE item_id='$itemid'");
    if($qry){
        header("Location:inv_items_edit.php?itemid=$itemid&msg=succ");
    }
    exit;
}

?>
<body>

<div id="wrapper">
	
	<div id="header">
		<h1><a href="dashboard.php">Inventory Management</a></h1>		
		
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
			<h1>Products</h1>
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
						<p>Your data has not been edited!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="inv_items.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit Product</h3>
						</div> <!-- .widget-header -->
						<div class="widget-content">
							<?php 
							$itemid=$_GET['itemid'];
							$itemslist=mysql_query("SELECT * FROM inv_items WHERE item_id=$itemid"); 
								  $items=mysql_fetch_array($itemslist);
								  	
							?>
							<form class="form uniformForm validateForm" method="post" action="" >
								
                            <div class="grid-8">	
						<div class="widget-content"> 
								<div class="field-group">		
									<label>Category<span class="error"> * </span>:</label>			
									<div class="field">
                                     <?php
                                            $category = "SELECT cat_id,category_name FROM inv_category where cat_status=1";
                                            $result = mysql_query($category) or die(mysql_error());
                                            echo '<select name="category" id="category" class="required select2"> <option value="">Select Category</option>';
											while ($row = mysql_fetch_assoc($result)):
												
                                                echo "<option value='{$row['cat_id']}'"; 
												if($items['cat_id']==$row['cat_id']){
													echo 'selected';
													}
												echo " >{$row['category_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
                                
                                <div class="field-group">
									<label for="required">Item Name <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="itemname" id="itemname" size="32" class="validate[required]" value="<?php echo $items['item_name'];?>" />	
									</div>
								</div> 
                                
                                <div class="field-group">
									<label for="required">Item Code <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="itemcode" id="itemcode" size="32" class="validate[required]"  value="<?php echo $items['item_code'];?>"/>	
									</div>
								</div> 
                                
                                <div class="field-group">		
									<label>Status<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="status" id="status" class="required select2">
											<option value="">Please select</option>	
                                            <option value="1" <?php if($items['item_status']=='1'){ echo 'selected'; }?>>Enable</option>
                                            <option value="0" <?php if($items['item_status']=='0'){ echo 'selected'; }?>>Disable</option>									
										</select>										
									</div>	
                                    </div>
                                
								<div class="actions">		
                                <input type="hidden" class="medium" name="itemid" value="<?php echo $itemid;?>" > 				
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