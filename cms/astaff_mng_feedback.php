<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit'])) {
	  $title=$_POST['title'];
	  $msg=$_POST['msg'];
	  $stid=$_POST['stid'];
	  
	  $todaydate=date("d/m/Y H:i:s");
	  
	  $sql=mysql_query("INSERT INTO sfeedback (st_id,title,msg,date,ay_id,status,send) VALUES
('$stid','$title','$msg','$todaydate','$acyear','1','admin')");
	 if($sql){
		 	 header("Location:astaff_mng_feedback.php?stid=$stid&msg=succ");		 	 
	 }else{
		 header("Location:astaff_mng_feedback.php?stid=$stid&msg=err");
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
		$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
	?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="staff_mng_feed.php" title="Feedback">Feedback</a></li>
                <li class="no-hover">Feedback Details / Reply</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="staff_mng_feed.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            </div>
			<div class="grid_12">
				<h1><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname'];?> - Feedback Details and Reply</h1>                                  
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname'];?> Feedback Details and Reply</h1>                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example1" class="table">
					<?php 
					$qury1=mysql_query("SELECT * FROM sfeedback WHERE st_id=$stid AND ay_id=$acyear"); 
						$totasl =0;
					while($subject3=mysql_fetch_array($qury1))
					{ 
					 $sfid=$subject3['sf_id'];
					 $sql=mysql_query("UPDATE sfeedback SET status='0' WHERE sf_id='$sfid' AND send='staff'");
					//$stid=$subject3['st_id'];
					$send=$subject3['send'];
					?>
                  <tr style="border:1px solid #C1C0C0;">
                      <td width="150px;">
                          <?php if($send=="admin"){ echo "<strong>Admin<br></strong><span style=' font-size:12px'>".$subject3['date']."</span> "; } else { echo "<strong> ".$staff['fname']." ".$staff['mname']." ".$staff['lname']."<br></strong><span style=' font-size:12px'>".$subject3['date']."</span> ";}?>                      </td>
                      <td><?php echo "Title: <strong>".$subject3['title']."</strong><br> Msg : ".$subject3['msg'];?></td>
                  </tr>
                  <?php $totasl++; }
				  if($totasl==0){ echo "<br><center><p>Ther is no Feddbacks found ! </p></center>"; }?>
              </tbody>
            </table><br><hr>
            <h5>Feedback / Reply</h5>
            <form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_100">
							<p>
                                <label for="textfield">Title: <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                       <div class="_100">
							<p><label for="textarea">Message :</label>
                            <textarea id="textarea" name="msg" rows="5" cols="40"></textarea></p>
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="stid" value="<?php echo $_GET['stid'];?>" >
                            <li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
					</div>
				</div>
            </div>
            <div class="clear height-fix"></div>
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
			validateform.resetForm();
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
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