<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit'])) {
	  $title=$_POST['title'];
	  $msg=$_POST['msg'];
	  $sid=$_POST['sid'];
	$cid=$_POST['cid'];
	$ssid=$_POST['ssid'];
	$bid=$_POST['bid'];
	  
	  $todaydate=date("d/m/Y H:i:s");
	  
	  $sql=mysql_query("INSERT INTO ssfeedback (st_id,ss_id,title,msg,date,c_id,s_id,b_id,ay_id,status,send) VALUES
('$stid','$ssid','$title','$msg','$todaydate','$cid','$sid','$bid','$acyear','1','staff')");
	 if($sql){
		 	 header("Location:sstudent_mng_feedback1.php?bid=$bid&cid=$cid&sid=$sid&ssid=$ssid&msg=succ");		 	 
	 }else{
		 header("Location:sstudent_mng_feedback1.php?bid=$bid&cid=$cid&sid=$sid&ssid=$ssid&msg=err");
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    <?php 
		$bid=$_GET['bid'];
		$cid=$_GET['cid'];
		$ssid=$_GET['ssid'];
		
							$sid=$_GET['sid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sboard_select_stu_feed1.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="sboard_select_class_feed1.php?bid=<?php echo $bid; ?>" title="Select Class">Class List</a></li>
                <li class="no-hover"><a href="sstudent_mng_feed1.php?bid=<?php echo $bid; ?>&cid=<?php echo $cid; ?>&sid=<?php echo $sid; ?>" title="Feedback list">Feedback list</a></li>
				<li class="no-hover">Feedback Details / Reply</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="sstudent_mng_feed1.php?bid=<?php echo $bid; ?>&cid=<?php echo $cid; ?>&sid=<?php echo $sid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            </div>
			<?php
							
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> Feedback Details and Reply</h1>                                  
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Feedback Details and Reply</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example1" class="table">
					<?php 
					$qury1=mysql_query("SELECT * FROM ssfeedback WHERE c_id=$cid AND s_id=$sid AND st_id=$stid AND ss_id=$ssid AND ay_id=$acyear AND b_id=$bid"); 
						$totasl =0;
					while($subject3=mysql_fetch_array($qury1))
					{ 
					 $ssfid=$subject3['ssf_id'];
					 $sql=mysql_query("UPDATE ssfeedback SET status='0' WHERE ssf_id='$ssfid' AND send='student'");
					//$stid=$subject3['ss_id'];
					$select_record7=mysql_query("SELECT * FROM student WHERE ss_id=$ssid");
					$result3=mysql_fetch_array($select_record7); 
					$send=$subject3['send'];
					?>
                  <tr style="border:1px solid #C1C0C0;">
                      <td width="150px;">
                          <?php if($send=="staff"){ echo "<strong> You<br></strong><span style=' font-size:12px'>".$subject3['date']."</span> "; } else { echo "<strong> ".$result3['firstname']." ".$result3['middlename']." ".$result3['lastname']."<br></strong><span style=' font-size:12px'>".$subject3['date']."</span> ";}?>                      </td>
                      <td><?php echo "Title: <strong>".$subject3['title']."</strong><br> Msg : ".$subject3['msg'];?></td>
                  </tr>
                  <?php $totasl++; }
				  if($totasl==0){ echo "<br><center><p>There is no Feedbacks found ! </p></center>"; }?>
              </tbody>
            </table><br><hr>
            <h5>Feedback / Reply</h5>
            <form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_100">
							<p>
                                <label for="textfield">Title: <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="<?php echo $result['mark'];?>" />
                            </p>
						</div>
                       <div class="_100">
							<p><label for="textarea">Message :</label>
                            <textarea id="textarea" name="msg" rows="5" cols="40"><?php echo $result['remark'];?></textarea></p>
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="ssid" value="<?php echo $_GET['ssid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            <li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
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