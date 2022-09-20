<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	//echo "test";
	//$sname=$_POST['sname'];
	 $cid=$_POST['cid'];
	 $sid=$_POST['sid'];
	 $eid=$_POST['eid'];
	 $subid=$_POST['subid'];
	 $bid=$_POST['bid'];
	 $todaydate=date("d/m/Y H:i:s");
		
		$filename=$_FILES["file"]["tmp_name"];
	
		 if($_FILES["file"]["size"] > 0)
		 {

		  	$file = fopen($filename, "r");
			$count=0;
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
				if($count>0){
					//$gender=strtoupper($emapData[3]);
					//echo "test : ".$emapData[21];
	          //It wiil insert a row to our subject table from our csv file`
			   $sql = "INSERT INTO result (mark,mark1,result,remark,c_id,s_id,e_id,sub_id,ss_id,admin_no,b_id,ay_id) values('$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$cid','$sid','$eid','$subid','$emapData[1]','$emapData[2]','$bid','$acyear')";
	         //we are using mysql_query function. it returns a resource on true else False on error
	         $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				
				if(! $result )
				{	
						header("Location:sresult_impt.php?sid=$sid&cid=$cid&eid=$eid&subid=$subid&bid=$bid&msg=eonfile");
						exit;
				}
				header("Location:sresult_impt.php?sid=$sid&cid=$cid&eid=$eid&subid=$subid&bid=$bid&msg=succ");
				}
				$count++;
	         }
	         fclose($file);
	        
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
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
							$subid=$_GET['subid'];
							
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_array($subjectlist);	
								  $slid=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1); 
								  $paper=$slist['paper'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sboard_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="sboard_select_classexam.php?bid=<?php echo $bid; ?>&eid=<?php echo $eid;?>" title="Select Class">Class List</a></li>
				<li class="no-hover"><a href="sresult_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Exam Result Management">Exam Result Management</a></li>
                
                <li class="no-hover">Import <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $subject['s_name'];?>)</b></li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Import <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $slist['s_name'];?>)</b></h1>                
			<a href="sresult_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
             <?php if($class['c_name']=='XI STD' || $class['c_name']=='XII STD'){?>
             <a href="student_mark1.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>&ayid=<?php echo $acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File, Fill it and then import</button></a>
             <?php }else{?>
             <a href="student_mark.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>&ayid=<?php echo $acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File, Fill it and then import</button></a>
             <?php } ?>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Records Successfully Imported!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Import <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $slist['s_name'];?>)</b></h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
								<label for="file">Upload a file</label>
								<input type="file" name="file" id="file" required/>
							</p>
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="" onClick="window.location.reload(true)">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="eid" value="<?php echo $_GET['eid'];?>" >
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
			//$.jGrowl("Form was Reset.", { theme: 'error' });
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
  
</body>
</html>
<? ob_flush(); ?>