<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$bid=$_GET['bid'];
							
 if (isset($_POST['submit']))
{
	$slid=$_POST['slid'];
	
	$subjectlist=mysql_query("SELECT * FROM subjectlist WHERE sl_id=$slid"); 
								  $subject1=mysql_fetch_array($subjectlist);
	$scode=$subject1['s_name']."_".$subject1['s_code'];
	
	$filename = addslashes($_FILES["file"]["name"]);
		
		  $filecon=$scode.$cid.$bid.$acyear;
		  $filecon=str_replace(" ", "_",$filecon);
		
		
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	 $filesize = $_FILES["file"]["size"];
	$allowed_file_types = array('.pdf');	
 
 	//echo $filename;
	if (in_array($file_ext,$allowed_file_types) && ($filesize < 5000000))
	{	
		// Rename file		
		$newfilename = $filecon . $file_ext;	
		if (file_exists("reports/" . $newfilename))
		{
			$msg="falready";
		}
		else
		{		
			move_uploaded_file($_FILES["file"]["tmp_name"], "syllabus/" . $newfilename);
			//echo "File uploaded successfully.";	
				
		 $sql="INSERT INTO syllabus (sl_id,c_id,s_id,b_id,ay_id,status,files) VALUES
('$slid','$cid','$sid','$bid','$acyear','1','$newfilename')";
				
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if($result){
					//header("Location:subjectmng_single1.php?cid=$cid&sid=$sid&bid=$bid&msg=succ");
					$msg="succ";
				}
		}
	}
	else if (empty($file_basename))
	{	
		// file selection error
	//echo "Please select a file to upload.";
	$msg="fill";
	} 
	else if ($filesize > 5000000)
	{	
		// file size error
		//echo "The file you are trying to upload is too large.";
		unlink($_FILES["file"]["tmp_name"]);
		//header("location:record-add.php?error=eonfilesize");
		$msg="eonfilesize";
	}
	else
	{
		// file type error
		//echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
		unlink($_FILES["file"]["tmp_name"]);
		//header("location:record-add.php?error=eonfiletype");
		$msg="eonfiletype";
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
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $cname=$class['c_name'];
								  if($cname == 'XI STD' || $cname == 'XII STD'){ 
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								  }
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_syllabus.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="syllabus.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="Home">Syllabus management</a></li>
                <li class="no-hover">Add Syllabus</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1> New Syllabus (<?php echo $class['c_name']; if($cname == 'XI STD' || $cname == 'XII STD'){ echo "-".$section['s_name']; }?>)</h1>               
			<a href="syllabus.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            
            <?php if($msg=="succ"){?>
            <div class="alert success"><span class="hide">x</span><strong>Success!</strong> The Record has been added.</div>
             <?php } ?>
             <?php if($msg=="eonfiletype"){?>
             <div class="alert error"><span class="hide">x</span><strong>Success!</strong> <strong>Error!</strong> Please upload file type PDF only.</div>
             <?php } ?>
             <?php if($msg=="eonfilesize"){?>
             <div class="alert error"><span class="hide">x</span><strong>Success!</strong> <strong>Error!</strong> Please upload file size below 5MB.</div>
             <?php } ?>
             <?php if($msg=="falready"){?>
             <div class="alert error"><span class="hide">x</span><strong>Success!</strong> <strong>Error!</strong> This Report PDF File Already uploaded!!!</div>            
             <?php } ?>
             
				<div class="block-border">
					<div class="block-header">
						<h1>Assign New Staff details </h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_50">
							<p>
								<label for="select">Subject : </label>
                                	<?php
                                            	if($cname == 'XI STD' || $cname == 'XII STD'){ 
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
											}else{
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear");
											}
                                            echo '<select name="slid" id="slid" class="required"> 
											<option value="">Select Subject</option>';
											while ($row2 = mysql_fetch_array($qry)): ?>
                                                <option value='<?php echo $row2['sl_id'];?>'><?php echo $row2['s_name'];?></option>
                         <?php              endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="file">Upload a Syllabus PDF</label>
								<input type="file" name="file" id="file" class="required"/>
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
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
  
</body>
</html>
<? ob_flush(); ?>