<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$nid=$_POST['notebook'];
	$cid=$_POST['class'];
	$sid=$_POST['section'];
	$bid=$_POST['bid'];
	$qty=$_POST['qty'];
	$nid1=$_POST['nid1'];
	
	$booklist1=mysql_query("SELECT * FROM book WHERE n_id=$nid AND c_id='$cid' AND s_id='$sid'"); 
			$book1=mysql_fetch_array($booklist1);
			if($book1 && ($nid!=$nid1)){
				header("Location:notebook_al_edit.php?bid=$bid&msg=err");
				exit;
			}
	
	$nbooklist=mysql_query("SELECT * FROM notebook_purchese WHERE n_id=$nid"); 
								  $nbook=mysql_fetch_array($nbooklist);
				$nname=$nbook['n_name'];
				$nprice=$nbook['n_price'];
				$aid=$nbook['a_id'];
		
		$qry=mysql_query("UPDATE book SET b_name='$nname',b_price='$nprice',c_id='$cid',s_id='$sid',n_id='$nid' WHERE b_id='$bid'");
    if($qry){
        header("Location:notebook_al_edit.php?bid=$bid&msg=succ");
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
			<h1>NoteBook Management</h1>
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
			<?php }  ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         <a href="notebook_alert.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Edit NoteBook Assign Detail</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							<?php 
							$bid=$_GET['bid'];
							$booklist=mysql_query("SELECT * FROM book WHERE b_id=$bid"); 
								  $book=mysql_fetch_array($booklist);
								  $aid=$book['a_id'];
								  $cid=$book['c_id'];	
								  $sid=$book['s_id'];
								  $nid=$book['n_id'];		
								  $class=mysql_query("SELECT * FROM class WHERE c_id=$cid");
								  $classlist=mysql_fetch_array($class);
								  $class_name=$classlist['c_name'];
								  $qty1=$book['qty'];	
							?>
							<form class="form uniformForm validateForm" method="post" action="" >
								<div class="grid-8">	
						<div class="widget-content">
								 <div class="field-group">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    <?php //onchange="showCategory(this.value)"> <option value="">Select Class </option>
                                            $classl = "SELECT c_id,c_name FROM class  where c_id='$cid'";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="class" id="class" class="validate[required]" >';
											while ($row1 = mysql_fetch_assoc($result1)):
											$sel1 = ($cid == $row1['c_id']) ? "Selected" : "";
                                                echo "<option value='{$row1['c_id']}' $sel1>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group" <?php if($class_name=="XI STD" || $class_name=="XI" || $class_name=="XII STD" || $class_name=="XII"){}else{?> style="display:none;" <?php }?>>		
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
                                     <?php
                                            $agencyl = "SELECT n_id,n_name FROM notebook_purchese";
                                            $result = mysql_query($agencyl) or die(mysql_error());
                                            echo '<select name="notebook" id="notebook" class="validate[required]"> <option value="">Select Notebook </option>';
											while ($row = mysql_fetch_assoc($result)):
											$sel = ($nid == $row['n_id']) ? "Selected" : "";
                                                echo "<option value='{$row['n_id']}' $sel>{$row['n_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>No of Qty<span class="error"> * </span>:</label>			
									<div class="field">
                                             <input type="text" name="qty" id="qty" value="<?php echo $qty1;?>" size="32" class="validate[required]" />	
									</div>		
								</div> <!-- .field-group -->
                            <div class="actions">		
                                <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" > 
                                <input type="hidden" class="medium" name="nid1" value="<?php echo $nid;?>" >					
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