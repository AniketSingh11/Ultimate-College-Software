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
		$cid=$_GET['cid'];
		$pid=$_GET['pid'];
		$stid=$_GET['stid'];
		$ssid=$_GET['ssid'];
		$subid=$_GET['subid'];
		
							$sid=$_GET['sid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_feedback.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="feedback_mng.php?bid=<?php echo $bid; ?>&cid=<?php echo $cid; ?>&sid=<?php echo $sid; ?>&subid=<?php echo $subid; ?>" title="Feedback list">Feedback list</a></li>
				<li class="no-hover">Conversation</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="feedback_mng.php?bid=<?php echo $bid; ?>&cid=<?php echo $cid; ?>&sid=<?php echo $sid; ?>&subid=<?php echo $subid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            </div>
			<?php
							
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  $stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);	
								  $select_record7=mysql_query("SELECT * FROM parent WHERE p_id=$pid");
					$result3=mysql_fetch_array($select_record7); 
					$select_reco7=mysql_query("SELECT * FROM student WHERE ss_id=$ssid");
					$student=mysql_fetch_array($select_reco7); 
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> Conversation</h1>  
                <span style="margin:0px 10px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Student - <strong><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname'];?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/users.png"> Parent - <strong><?php echo $result3['p_name'];?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-business.png"> Staff - <strong><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname'];?></strong></span>                                
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Conversation</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example1" class="table">
					<?php 
					$qury1=mysql_query("SELECT * FROM feedback WHERE c_id=$cid AND s_id=$sid AND st_id=$stid AND p_id=$pid AND ay_id=$acyear AND b_id=$bid"); 
						$totasl =0;
					while($subject3=mysql_fetch_array($qury1))
					{ 
					 $fid=$subject3['f_id'];
					 $sql=mysql_query("UPDATE feedback SET status='0' WHERE f_id='$fid' AND send='parent'");
					//$stid=$subject3['p_id'];
					$send=$subject3['send'];
					?>
                  <tr style="border:1px solid #C1C0C0;">
                      <td width="150px;">
                          <?php if($send=="staff"){ echo "<strong> ".$staff['fname']." ".$staff['mname']." ".$staff['lname']."-</strong> Staff<br><span style=' font-size:12px'>".$subject3['date']."</span> "; } else { echo "<strong> ".$result3['p_name']."</strong>- Parent<br><span style=' font-size:12px'>".$subject3['date']."</span> ";}?>                      </td>
                      <td><?php echo "Title: <strong>".$subject3['title']."</strong><br> Msg : ".$subject3['msg'];?></td>
                  </tr>
                  <?php $totasl++; }
				  if($totasl==0){ echo "<br><center><p>Ther is no Feddbacks found ! </p></center>"; }?>
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
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		$('#table-example').dataTable();
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