<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$agencyname = $_POST['agency'];
	$itemname=$_POST['itemname'];
	$qty=$_POST['qty'];
	$uomname = $_POST['uomname'];
	$buyprice=$_POST['buy_price'];
	$sellprice=$_POST['selling_price'];
	$totalamt=$_POST['total_amt'];
	
		$sql="INSERT INTO inv_purchase (agency_id,item_id,uom_id,buy_price,sell_price,qty,total) VALUES
('$agencyname','$itemname','$uomname','$buyprice','$sellprice','$qty','$totalamt')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
		
		$result_select = mysql_query("select * from inv_items where item_id=$itemname");
		$row_items_select = mysql_fetch_assoc($result_select);
		//set total qty
		$tot_qty = $row_items_select['item_qty']+$qty;
		//update total qty
		$sql_item="UPDATE inv_items SET item_qty='$tot_qty' where item_id=$itemname";
		$result1 = mysql_query($sql_item) or die("Could not insert data into DB: " . mysql_error());
		
        header("Location:inv_purchase_new.php?msg=succ");
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
			<h1>Purchase Entry Management</h1>
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
                         <a href="inv_purchase.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Add New Purchase Entry</h3>
						</div> <!-- .widget-header -->
						<div class="widget-content">
							<form class="form uniformForm validateForm" method="post" action="" >
                            <div class="grid-8">	
						<div class="widget-content"> 	
                                 <div class="field-group">		
									<label>Agency<span class="error"> * </span>:</label>			
									<div class="field">
                                     <?php
                                            $agencyl = "SELECT agency_id,agency_name FROM inv_agency";
                                            $result = mysql_query($agencyl) or die(mysql_error());
                                            echo '<select name="agency" id="agency" class="validate[required]"> <option value="">Select Agency </option>';
											while ($row = mysql_fetch_assoc($result)):
                                                echo "<option value='{$row['agency_id']}'>{$row['agency_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
								<div class="field-group">		
									<label>Item Name<span class="error"> * </span>:</label>			
									<div class="field">
                                     <?php
                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1";
                                            $result = mysql_query($itemsql) or die(mysql_error());
                                            echo '<select name="itemname" id="itemname" class="validate[required]"> <option value="">Select Item </option>';
											while ($row = mysql_fetch_assoc($result)):
                                                echo "<option value='{$row['item_id']}'>{$row['item_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
                                
                                	
                                 <!-- .field-group -->
                            <div class="field-group">
									<label for="required">Quantity <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="qty" id="qty" size="15" class="validate[required]"  onkeypress="return isNumber(event);" onkeyup="calc_totalamount();"/>	
									</div>
								</div> 
                                <!-- .field-group -->
                                
                                 <div class="field-group">		
									<label>UOM<span class="error"> * </span>:</label>			
									<div class="field">
                                     <?php
                                            $agencyl = "SELECT uom_id,uom_name FROM inv_uom where uom_status=1";
                                            $result = mysql_query($agencyl) or die(mysql_error());
                                            echo '<select name="uomname" id="uomname" class="validate[required]"> <option value="">Select UOM </option>';
											while ($row = mysql_fetch_assoc($result)):
                                                echo "<option value='{$row['uom_id']}'>{$row['uom_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div>                                 
								 <!-- .field-group -->
                                
                              </div>
                            </div>
                            <div class="grid-8">	
						<div class="widget-content"> 
							
                                <div class="field-group">
									<label for="required">Buying price<span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="buy_price" id="buy_price" size="15" class="validate[required]" onkeyup="calc_totalamount();" onkeypress="return isDecimal(event,this);" />	
									</div>
								</div> <!-- .field-group -->
								
                                <div class="field-group">
									<label for="required">Selling Price <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="selling_price" id="selling_price" size="15" class="validate[required]" onkeypress="return isDecimal(event,this);" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Total Amount :</label>
									<div class="field">
										<input type="text" name="total_amt" id="total_amt" size="15" readonly value="0"/>	
									</div>
								</div>
								<div class="actions">						
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
	
    <script>
	
	function calc_totalamount(){
		
		var qty = ($('#qty').val()=="") ? 0 : $('#qty').val();
		var buyprice = ($('#buy_price').val()=="") ? 0 : $('#buy_price').val();
		
		
		var total = parseInt(qty) * parseFloat(buyprice);
		
		$('#total_amt').val(total);
		
		}
		
	function isNumber(evt) {		
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	
	function isDecimal(evt,element){
	   
		var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 45 ) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true; 
}  
	
	
	</script>
    
    
	<?php 
	include("includes/topnav.php");
	?> <!-- #topNav -->
	
	
	
	
</div> <!-- #wrapper -->



<?php include("includes/footer.php"); ?>
 <script type="text/javascript">
  $(document).ready(function() {
		 
		  $("#datepicker").datepicker();
	});	
 </script>
</body>
</html>
<? ob_flush(); ?>