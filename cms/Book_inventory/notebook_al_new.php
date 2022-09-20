<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit']))
{
	$nid=$_POST['notebook'];
	$cid=$_POST['class'];
	$sid=$_POST['section'];
	$type='N';
	$category='C';
	$qty=$_POST['qty'];
	
	$booklist1=mysql_query("SELECT * FROM book WHERE n_id=$nid AND c_id='$cid' AND s_id='$sid'"); 
			$book1=mysql_fetch_array($booklist1);
			if($book1){
				header("Location:notebook_al_new.php?msg=err");
				exit;
			}
			
	
	$nbooklist=mysql_query("SELECT * FROM notebook_purchese WHERE n_id=$nid"); 
								  $nbook=mysql_fetch_array($nbooklist);
				$nname=$nbook['n_name'];
				$nprice=$nbook['n_price'];
				$aid=$nbook['a_id'];
		
		$sql="INSERT INTO book (b_name,b_price,category,c_id,s_id,a_id,n_id,type,brdid,ay_id,qty) VALUES
('$nname','$nprice','$category','$cid','$sid','$aid','$nid','$type','$brdid','$acyear','$qty')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:notebook_al_new.php?msg=succ");
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
						<p>Your data successfully created!!!</p>
					</div>
			<?php } if($msg === "err"){
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
                         <a href="notebook_alert.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
							<span class="icon-article"></span>
							<h3>Add New noteBook Details</h3>
						</div> <!-- .widget-header -->
						<div class="widget-content">
							<form class="form uniformForm validateForm" method="post" action="" >
                            <div class="grid-8">	
						<div class="widget-content"> 	
                                <div class="field-group">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    <?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$brdid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="class" id="class" class="validate[required]" onchange="showCategory(this.value)"> <option value="">Select Main menu </option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group" id="showclass" style="display: none;">		
									<label>Section / Group<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="section" id="section" class="validate[required]">
											<option value="">Please select</option>											
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
                                                echo "<option value='{$row['n_id']}'>{$row['n_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>      																				
									</div>		
								</div> <!-- .field-group -->
                                <div class="field-group">		
									<label>No of Qty<span class="error"> * </span>:</label>			
									<div class="field">
                                             <input type="text" name="qty" id="qty" value="1" size="32" class="validate[required]" />	
									</div>		
								</div> <!-- .field-group -->
                                
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
	
	<?php 
	include("includes/topnav.php");
	?> <!-- #topNav -->
	
	
	
	
</div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>

 <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
         var clas=$("#class option[value="+str+"]").text();
         if (clas.indexOf("XI") >= 0){

          	  $("#showclass").show();
              }else{
            	  $("#showclass").hide();
              }
         
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

           $('#section option:eq(1)').attr('selected', 'selected');
                
           var s=$('#section').val();
           
    		    var c=$("#section option[value="+s+"]").text();
    		    
    		    
    		   $("#uniform-section span").html(c);
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>