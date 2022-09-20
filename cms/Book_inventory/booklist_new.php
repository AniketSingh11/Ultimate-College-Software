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
	$type='B';
	
	$qty1=$_POST['qty1'];
	
	$m_price=trim($_POST['m_price']);
	$p_date=trim($_POST['p_date']);
		
		$sql="INSERT INTO book (b_name,b_qtysold,b_qtyleft,b_price,category,c_id,s_id,a_id,type,brdid,ay_id,m_price,p_date,qty) VALUES
('$bname','0','$qty','$price','$category','$cid','$sid','$aid','$type','$brdid','$acyear','$m_price','$p_date','$qty1')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:booklist_new.php?cid=$cid&sid=$sid&msg=succ");
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
						<p>Your data successfully created!!!</p>
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
							<h3>Add New Book Details</h3>
						</div> <!-- .widget-header -->
						<div class="widget-content">
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
                                                echo "<option value='{$row['a_id']}'>{$row['a_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>Category<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="category" id="category" class="validate[required]">
											<option value="">Please select</option>	
                                            <option value="C">Common</option>	
                                            <option value="M">Male</option>	
                                            <option value="F">Female</option>											
										</select>										
									</div>		
								</div> <!-- .field-group -->
								
								<!-- .field-group -->
								
                                <div class="field-group">
									<label for="required">Purchase Date<span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="p_date" id="datepicker" size="15" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								
								
                              </div>
                            </div>
                            <div class="grid-8">	
						<div class="widget-content"> 
								<div class="field-group">
									<label for="required">Book / Things Name <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="bname" id="bname" size="32" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                            <div class="field-group">
									<label for="required">Quantity <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="qty" id="qty" size="15" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								
								 <!-- .field-group -->
                                <div class="field-group">
									<label for="required">Marketing price<span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="m_price" id="m_price" size="15" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
								
                                <div class="field-group">
									<label for="required">Price <span class="error"> * </span>:</label>
									<div class="field">
										<input type="text" name="price" id="price" size="15" class="validate[required]" />	
									</div>
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>No of Qty (give to the student)<span class="error"> * </span>:</label>			
									<div class="field">
                                             <input type="text" name="qty1" id="qty1" value="1" size="32" class="validate[required]" />	
									</div>		
								</div> <!-- .field-group -->
                                
								<div class="actions">	
                                <input type="hidden" class="medium" name="cid" value="<?php echo $cid;?>" > 
                                <input type="hidden" class="medium" name="sid" value="<?php echo $sid;?>" > 					
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