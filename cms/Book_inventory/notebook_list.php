<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
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
			<h1>Notebook Assign Management</h1>
		</div> <!-- #contentHeader -->	
		<div class="container">
        <div class="grid-24">
				<div class="widget">
						
						<div class="widget-header">
                        	<span class="icon-article"></span>
							<h3>Select Class and Section/Group</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							
							<form class="form uniformForm validateForm" method="get" action="notebook_list.php" >
								
                   <div class="grid-8">	
						<div class="widget-content">    
                                <div class="field-group">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    <?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$brdid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="validate[required]" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
									</div>		
								</div> <!-- .field-group -->
                            </div>  
                           </div> 
                           <div class="grid-8">	
						<div class="widget-content">    
                                <div class="field-group" id="show_section" style="display: none;">		
									<label>Section / Group<span class="error"> * </span>:</label>			
									<div class="field">
										<select name="sid" id="sid" class="validate[required]">
											<option value="">Please select</option>											
										</select>										
									</div>		
								</div> <!-- .field-group -->
                              </div>
                             </div>
                             <div class="grid-8">	
						<div class="widget-content">    
								<div class="actions">						
									<button type="submit" class="btn btn-error">Submit</button>
								</div> <!-- .actions -->
                              </div>
                       		</div>	
							</form>
						</div> <!-- .widget-content -->
					</div>
			</div> <!-- .grid -->
            <?php if($_GET['cid'] && $_GET['sid']){
				$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $class_name=$class['c_name'];
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								  $section_name=$section['s_name'];
				
				?>
                <center><h3>Class : <span class="error"><?php echo $class_name;?></span> <?php   if($class_name=="XI STD" || $class_name=="XI" || $class_name=="XII STD" || $class_name=="XII"){?> -> Section/Group : <span class="error"><?php echo $section_name;?> </span><?php }?></h3></center>
                
                <?php 
		$msg=$_GET['msg'];
		if($msg === "dsucc"){
		?>
        <div class="notify notify-success">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Success Notifty</h3>						
						<p>Your data successfully Deleted!!!</p>
					</div>
			<?php } ?>
            
            <div class="grid-24">
				
				<div class="widget widget-table">
					
						<div class="widget-header">
                        <a href="notebook_list_new.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-orange ">Add New</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart">							<?php  	  echo $class['c_name'];
							    if($class_name=="XI STD" || $class_name=="XI" || $class_name=="XII STD" || $class_name=="XII"){ 	  echo "-".$section['s_name']; }?>  Notebook Details </h3>
                       </div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Notebook Name</th>
                                <th>Qty</th>
								<th>Price</th>
                                <th>Agency</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$cname=$class['c_name'];
						if($cname == 'XI STD' || $cname == 'XII STD' ||  $cname=="XII STD" || $cname=="XII"){ 
							$qry=mysql_query("SELECT * FROM book Where c_id=$cid AND s_id=$sid AND type='N'");
						}else{
							$qry=mysql_query("SELECT * FROM book Where c_id=$cid  AND type='N'");
						}
						
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
							$aid=$row['a_id']; 
					$agency=mysql_query("SELECT * FROM agency WHERE a_id=$aid");
			  		$agencylist=mysql_fetch_array($agency);
						?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['b_name']; ?></td>
                                <td><?php echo $row['qty']; ?></td>
                                <td><?php echo $row['b_price']; ?></td>
                                <td><?php echo $agencylist['a_name']; ?></td>
								 <td class="action"><a href="notebook_list_edit.php?sid=<?php echo $sid;?>&cid=<?php echo $cid;?>&bid=<?php echo $row['b_id'];?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> <a href="notebook_list_delete.php?sid=<?php echo $sid;?>&cid=<?php echo $cid;?>&bid=<?php echo $row['b_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
							</tr>	
                            <?php // } } 
							$count++;
							} ?>																						
						</tbody>
					</table>
						</div> <!-- .widget-content -->
					
				</div>
				
			</div>
            <?php } ?>
			
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

   	 var clas=$("#cid option[value="+str+"]").text();
     if (clas.indexOf("XI") >= 0){

      	  $("#show_section").show();
          }else{
        	  $("#show_section").hide();
          }
        if (str == "") {
            document.getElementById("sid").innerHTML = "";
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
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
                $('#sid option:eq(1)').attr('selected', 'selected');
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>