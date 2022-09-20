<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
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
     <?php 
		$bid=$_GET['bid'];
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
                <li class="no-hover"><a href="board_select_parent.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Parents Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
             <a href="board_select_parent.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
                                            $classl = "SELECT c_id,c_name FROM class where b_id=$bid AND ay_id=$acyear";
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
                            	<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
			<?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> Parents List</h1>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Parents List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Parent's name</th>
                                    <th>Phone No</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear ORDER BY firstname ASC");
							$count=1;
			  while($student=mysql_fetch_array($qry))
        		{
					$ssid=$student['ss_id'];
					$pid=$student['p_id'];
							if(!$pid){
									  $parentlist=mysql_query("SELECT * FROM sibling WHERE ss_id=$ssid"); 
								  	  $parent=mysql_fetch_array($parentlist);
									  $pid=$parent['p_id'];
								  }
								  if(!$pid){
									  $parentlist=mysql_query("SELECT * FROM parent WHERE ss_id=$ssid"); 
								  	  $parent=mysql_fetch_array($parentlist);
									  $pid=$parent['p_id'];									  
								  }
					$studentlist=mysql_query("SELECT * FROM parent WHERE p_id=$pid"); 
								  $row=mysql_fetch_array($studentlist);	  
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $row['p_name']; ?></center></td>
                                <td><center><?php echo $row['phone_number']; ?></center></td>
                                <td><center><?php echo $row['email']; ?></center></td>
                                <td><center><?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
								 <td width="100px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="parentmng_edit.php?ssid=<?php echo $row['ss_id'];?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&pid=<?php echo $row['p_id'];?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <!--<a href="studentmng_delete.php?ssid=<?php #echo $row['ss_id']; ?>&cid=<?php #echo $cid; ?>&sid=<?php #echo $sid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>-->
                                <!-- <a href="parent_prt.php?ssid=<?php #echo $row['ss_id'];?>&cid=<?php #echo $cid;?>&sid=<?php #echo $sid;?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>-->
                                 </td>
								</tr> 
                                                     <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count;?>" title="<?php echo $student['admission_number']; ?>, This student details" style="display: none;">
				<p>Admin NO : <strong><?php echo $student['admission_number']; ?></strong></p>
                
                 <p>First Name of Pupil : <strong><?php echo $student['firstname']; ?></strong></p> 
                
                <p>Middle Name : <strong><?php echo $student['lastname']; ?></strong>  </p>   
                
                <p>Last Name of Pupil : <strong><?php echo $student['middlename']; ?></strong>  </p>   
                
                <p>Name of Parent / Guardian : <strong><?php echo $student['fathersname']; ?></strong>  </p>   
                
                <p>Occupation of Parent or Guardian : <strong><?php echo $student['fathersocupation']; ?></strong>  </p>   
                
                <p>Standard & School from which pupil has come :  <strong><?php echo $student['from_school']; ?> </strong></p>   
                
                <p>Whether an ESLC issued by the Dept. was produced on admission : <strong><?php echo $student['eslc']; ?></strong>  </p>   
                
                <p>Whether a T.C. from a secondary school was produced on admission : <strong><?php echo $student['tc']; ?></strong>  </p>   
                
                <p>Date of admission :  <strong><?php echo $student['doa']; ?></strong>  </p>   
                
                <p>Date Of Birth : <strong><?php echo $student['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($student['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Whether protected from small-pox or not : <strong><?php echo $student['protected']; ?></strong> </p>   
                
                <p>Nationality & state to which the pupil belongs : <strong><?php echo $student['nation']; ?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $student['reg']; ?></strong> </p>   
                
                <p>Caste : <strong><?php echo $student['caste']; ?></strong>  </p>   
                
                <p>Subcaste : <strong><?php echo $student['sub_caste']; ?></strong>  </p>   
                
                <p>Blood Group : <strong><?php echo $student['blood']; ?></strong> </p>   
                
                <p>Email : <strong><?php echo $student['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $student['phone_number']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $student['address1']; ?></strong>  </p>   
                
                <p>Residence Address2 : <strong><?php echo $student['address2']; ?></strong> </p>   
                
                <p>Town or village Name : <strong><?php echo $student['city_id']; ?></strong> </p>   
                
                <p>Country : <strong><?php echo $student['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $student['pin']; ?></strong> </p>   
                
                <p>Mother Tongue of the Pubil : <strong><?php echo $student['mother_tongue']; ?></strong> </p>   
                
                <p>Std. on leaving : <strong><?php echo $student['std_leaving']; ?></strong>  </p>   
                
                <p>No. & Date of Transfer Certificate produced : <strong><?php echo $student['no_date_tran']; ?></strong>  </p>   
                
                <p>Date of leaving : <strong><?php echo $student['dol']; ?> </strong></p>  
                
                <p>Reason for leaving : <strong><?php echo $student['reason_leaving']; ?></strong> </p>
                
                <p>School to which the pubil has gone : <strong><?php echo $student['school_pubil']; ?></strong> </p>
                
                <p>Remarks : <strong><?php echo $student['remarks']; ?></strong> </p>
                <p>Status  : <?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </p>
                </div>
                				
			</div> <!--! end of #info-dialog -->
            
                                 <?php 
							$count++;
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
	$('#table-example').dataTable({
		'iDisplayLength': 25
	});	
		
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
	 window.location.href = 'parent_mng.php?bid='+cid;	  
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
<?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>