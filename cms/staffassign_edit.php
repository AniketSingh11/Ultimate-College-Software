<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/subject_management.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$slid=$_POST['slid'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	$slid1=$_POST['slid1'];
	$cid1=$_POST['cid1'];
	$sid1=$_POST['sid1'];
	$stid=$_POST['stid'];
	$subid=$_POST['subid'];
	$bid=$_POST['bid'];
	if($cid!=$cid1 || $sid!=$sid1 || $slid!=$slid1){
	$alreadylist=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND sl_id=$slid AND b_id=$bid AND ay_id=$acyear"); 
								  $already=mysql_fetch_array($alreadylist);	}
if(!$already){
	//echo "test";
	//die();	
	$sql="UPDATE subject SET sl_id='$slid',c_id='$cid',s_id='$sid',ay_id='$acyear' WHERE sub_id='$subid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:staffassign_edit.php?stid=$stid&bid=$bid&subid=$subid&msg=succ");
    }
    exit;
}else{
	header("Location:staffassign_edit.php?stid=$stid&bid=$bid&subid=$subid&msg=alerr");
}
}

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
					$stid=$_GET['stid'];
					$subid=$_GET['subid'];
		$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
							$bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);	
						 $subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $row=mysql_fetch_array($subjectlist);	
								  $cid=$row['c_id'];
								  $sid=$row['s_id'];					  
								  $slid=$row['sl_id'];					  
					  	$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
						$subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id=$slid"); 
								  $subject1=mysql_fetch_array($subjectlist1);	
					  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li><a href="stafflist.php" title="Staff List">Staff List</a></li>
				<li><a href="staff-assign.php?stid=<?php echo $stid;?>&bid=<?php echo $bid;?>" title="Staff List">Staff Class Assign</a></li>
                <li class="no-hover">Edit Staff Class</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname']; ?> - Edit Class ( <?php echo $board['b_name'];?> )</h1>                
			<a href="staff-assign.php?stid=<?php echo $stid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } else if($msg=="alerr") {?>			
            <div class="alert warning"><span class="hide">x</span>This subject already assigned for other Staff!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Staff Class</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class where b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($row1['c_id']==$row['c_id']){
                                                echo "<option value='{$row1['c_id']}' selected>{$row1['c_name']}</option>\n";
											}else{
												 echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
											}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" onchange="showCategory1(this.value)" class="required" >
											<option value="<?php echo $sid;?>"><?php echo $section['s_name'];?></option>											
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Subject Name : <span class="error">*</span></label>
                               <select name="slid" id="slid" class="required" >
											<option value="<?php echo $slid;?>"><?php echo $subject1['s_name'];?></option>											
								</select>
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid1" value="<?php echo $cid;?>" >
                            <input type="hidden" class="medium" name="sid1" value="<?php echo $sid;?>" >
                            <input type="hidden" class="medium" name="slid1" value="<?php echo $slid;?>" >
                            <input type="hidden" class="medium" name="stid" value="<?php echo $_GET['stid'];?>" >
                            <input type="hidden" class="medium" name="subid" value="<?php echo $_GET['subid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */		
	});
  </script>

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

                showCategory1($("#sid").val());
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }  
	function showCategory1(str) {
        if (str == "") {
            document.getElementById("slid").innerHTML = "";
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
                document.getElementById("slid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "s-list.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>