<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/subject_management.php"); 
 ?>
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");?>
    <!--! end of #header -->
    
    <div class="fix-shadow-bottom-height"></div>
	
	<!-- Begin of Sidebar -->
    <aside id="sidebar">
    	
    	<!-- Search -->
    	    	<?php include("includes/search.php"); ?>
 <!--! end of #search-bar -->
		
		<!-- Begin of #login-details -->
		<?php include("includes/login-details.php");?>
         <!--! end of #login-details -->
    	
    	<!-- Begin of Navigation -->
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    <?php $bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_cstaff.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Classwise Staffs List</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
        <div class="container_12">
        <div class="grid_12">
				<h1>Classwise Staffs List</h1>
                <a href="board_select_cstaff.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
			</div>
			<div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="student_mng.php">
						<div class="_50">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" class="required">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>                       
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
			<?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid "); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> Staffs List</h1>                
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Staffs List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Subject Name</center></th>
                                    <th><center>Staff ID</center></th>
                                    <th><center>Staff Name</center></th>
                                    <th>Type</th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							
				$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$stid=$row1['st_id'];
					$slid=$row1['sl_id'];
								   $subjectlist=mysql_query("SELECT * FROM subjectlist WHERE sl_id=$slid"); 
								   $slist=mysql_fetch_array($subjectlist);
								   $stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								   $row=mysql_fetch_array($stafflist);
								   if($stid){
								   ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                                <td><center><?php echo $slist['s_name']; ?></center></td>
								<td><center><?php echo $row['staff_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['mname']." ".$row['lname'];  ?></center></td>
                                <td><center><?php echo $row['s_type']; ?></center></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['position']; ?></center></td>
                                <td><center><?php echo $row['email']; ?></center></td>
                                <td><center><?php echo $row['phone_no']; ?></center></td>
                                <td><center><img src="./img/staff/<?php echo $row['photo']; ?>" alt="staff photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="70px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="staff_prt.php?stid=<?php echo $row['st_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['staff_id']; ?>, This Staff details" style="display: none;">
                                <center><img src="./img/staff/<?php echo $row['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Staff ID : <strong><?php echo $row['staff_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                
                <p>Middle Name : <strong><?php echo $row['mname']; ?></strong>  </p>   
                
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>   
                
                <p>Staff Type : <strong><?php echo $row['s_type']; ?></strong>  </p>   
                
                <p>Father's Name : <strong><?php echo $row['s_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong></strong> <?php echo $row['expriences']; ?></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong> </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong>  </p>   
                
                <p>Town or village Name  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>  
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                				
			</div> <!--! end of #info-dialog -->
                                 <?php 
							$count++; }
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
            </div>
            <div class="clear height-fix"></div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable();
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'classwise_staff.php?bid='+cid;	  
	} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
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