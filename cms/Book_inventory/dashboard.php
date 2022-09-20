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
			<h1>Dashboard</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-17">
				
				<div class="widget widget-plain">
					
					<div class="widget-content">
				
						<h2 class="dashboard_title">
							Sales Status
							<span>For Books And Things</span>
						</h2>				
						
						<div class="dashboard_report first activeState">
							<div class="pad">
                            <?php 
							$qry=mysql_query("SELECT * FROM invoice");							
							$num_rows = mysql_num_rows($qry);	
							$qry1=mysql_query("SELECT * FROM book WHERE type='B'");							
							$num_rows1= mysql_num_rows($qry1);	
							$qry2=mysql_query("SELECT * FROM book WHERE type='N'");							
							$num_rows2= mysql_num_rows($qry2);
							$qry3=mysql_query("SELECT * FROM student");							
							$num_rows3= mysql_num_rows($qry3);	
							?>
								<span class="value"><?php echo $num_rows;?></span> Completed Invoice
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $num_rows1;?></span> Books and Things
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $num_rows2;?></span>Type of Notebooks
							</div> <!-- .pad -->
						</div>
						
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $num_rows3;?></span> Students
							</div> <!-- .pad -->
						</div>
					</div> <!-- .widget-content -->
				</div> <!-- .widget -->
				<div class="widget">
						
						<div class="widget-header">
                        	<span class="icon-article"></span>
							<h3>Select Class and Section/Group</h3>
						</div> <!-- .widget-header -->
						
						<div class="widget-content">
							
							<form class="form uniformForm validateForm" method="get" action="dashboard.php" >
								
                   <div class="grid-8">	
						<div class="widget-content">    
                                <div class="field-group">		
									<label>Class<span> * </span>:</label>			
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
                                <div class="field-group">		
									<label>Section / Group<span> * </span>:</label>			
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
						
					</div> <!-- .widget -->
                    <?php if($_GET['cid'] && $_GET['sid']){
				
				$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
				
				?>
                <center><h3>Class : <span class="error"><?php echo $class['c_name'];?></span> -> Section/Group : <span class="error"><?php echo $section['s_name'];?> </span></h3></center>
                
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
            <div class="widget widget-table">
					
						<div class="widget-header">
                       	<span class="icon-list"></span>
							<h3 class="icon chart"><?php
							 	  echo $class['c_name']."-".$section['s_name'];?> Books and Things Details </h3>
                       </div>
					
						<div class="widget-content">
                        	
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Book Name</th>
								<th>Qty Sold</th>
                                <th>Qty Left</th>
                                <th>Price</th>
                                <th>Category</th>
								<th>Agency</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$cname=$class['c_name'];
						if($cname == 'XI STD' AND $cname == 'XII STD'){ 
							$qry=mysql_query("SELECT * FROM book Where c_id=$cid AND s_id=$sid AND type='B' AND brdid=$brdid AND ay_id=$acyear");
						}else{
							$qry=mysql_query("SELECT * FROM book Where c_id=$cid AND type='B' AND brdid=$brdid AND ay_id=$acyear");
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
                                <td><?php echo $row['b_qtysold']; ?></td>
                                <td><?php echo $row['b_qtyleft']; ?></td>
                                <td><?php echo $row['b_price']; ?></td>
                                <td>
                                <?php if($row['category']=='C')
										echo "Common";
									  elseif($row['category']=='M')
									    echo "Male";
									  else
									    echo "Female";	?>
                                </td>
                                <td><?php echo $agencylist['a_name']; ?></td>
								 <td class="action"><a href="booklist_edit.php?sid=<?php echo $sid;?>&cid=<?php echo $cid;?>&bid=<?php echo $row['b_id'];?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> <a href="booklist_delete.php?sid=<?php echo $sid;?>&cid=<?php echo $cid;?>&bid=<?php echo $row['b_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
							</tr>	
                            <?php // } } 
							$count++;
							} ?>																						
						</tbody>
					</table>
						</div> <!-- .widget-content -->
					
				</div>
                <?php } ?>
			</div> <!-- .grid -->			
			<div class="grid-7">
				<div id="gettingStarted" class="box">
					<h3>Getting Started</h3>

					<p>Completing your bio will bring you to 58%.</p>

					<div class="progress-bar secondary">
						<div class="bar" style="width: 42%;">42%</div>
					</div>

					<ul class="bullet secondary">
						<li><a href="javascript:;">Complete Your Profile</a></li>
						<li><a href="javascript:;">Add Your Photo</a></li>
						<li><a href="javascript:;">Create Reports</a></li>
						<li><a href="javascript:;">Invite Peoople to Join</a></li>
					</ul>
				</div>
					<div class="box">
					<h3>Recent Activity</h3>
					<ul class="bullet secondary">
						<li>Lorem ipsum dolor sit amet</li>
						<li>Quisque ornare ultricies lectus, quis aliquet lorem malesuada ac.</li>
						<li>Vivamus hendrerit malesuada elit</li>
						<li>Maecenas venenatis ante ut mi</li>
					</ul>
					
					<ul class="bullet primary">
						<li>Maecenas venenatis ante ut mi</li>
						<li>Praesent ac elit neque, sed faucibus eros.</li>
						<li>Vivamus hendrerit malesuada elit</li>
					</ul>
				</div> <!-- .box -->				
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
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>