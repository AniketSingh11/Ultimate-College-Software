<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 function is_valid_type($file) {
    $valid_types = array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "application/vnd.ms-excel" , "application/pdf", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "image/jpg","image/jpeg", "image/png");
    if (in_array($file['type'], $valid_types))
        return 1;
    return 0;
}

 if (isset($_POST['submit']))
{
	
	 $pdate=$_POST['pdate'];
	 $title=$_POST['title'];
	 $descript=addslashes($_POST['descript']);
	 $type=$_POST['type'];
	 $bid=$_POST['bid'];
	 $clid=$_POST['clid'];
	 $status=$_POST['status'];
	
	 $date_split= explode('/', $pdate);
	 
	  $publish_day=$date_split[1];
			 $publish_month=$date_split[0];
			 $publish_year=$date_split[2];
			
	
	$TARGET_PATH = "./circular/";
	$image = $_FILES['file'];
	$filesize = $_FILES["file"]["size"];
	$TARGET_PATH .= $image['name'];
	
	 $filename = addslashes($_FILES["file"]["name"]);
		
		  $filecon=$filename."_".$publish_day.$publish_month.$publish_year;
		  $filecon=str_replace(" ", "_",$filecon);
		   $filecon=str_replace(".", "_",$filecon);
		
		
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	
	$newfilename = $filecon . $file_ext;
	
	//echo '<pre>'; print_r($image); echo '</pre>';
	//die();
	
		if($image[error]!=4){	
			if (!is_valid_type($image) || $filesize>3000000){
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location: circular_edit.php?clid=$clid&msg=eronfile");
    		exit;
			}
			if (move_uploaded_file($_FILES["file"]["tmp_name"], "circular/" . $newfilename)) {
				
				$boardlist1=mysql_query("SELECT * FROM circular WHERE cl_id=$clid"); 
		$circular1=mysql_fetch_array($boardlist1);
		$file=$circular1['file'];
				
		unlink("circular/".$file);
				
				$sql="UPDATE circular SET cl_day='$publish_day',cl_month='$publish_month',cl_year='$publish_year',title='$title',descript='$descript',type='$type',file='$newfilename',status='$status',b_id='$bid' WHERE cl_id='$clid'";
				
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if($result){
					 header("Location:circular_edit.php?clid=$clid&msg=succ");
				}
			} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:circular_edit.php?clid=$clid&msg=eronfile");
				exit;
			}

		} else {			
			$sql="UPDATE circular SET cl_day='$publish_day',cl_month='$publish_month',cl_year='$publish_year',title='$title',descript='$descript',type='$type',status='$status',b_id='$bid' WHERE cl_id='$clid'";
			
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:circular_edit.php?clid=$clid&msg=succ");
    }
    exit;	
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
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="circular.php" title="Home">Circular Management</a></li>
                <li class="no-hover">Add New Circular Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Circular Details</h1>                
			<a href="circular.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.doc , .docx , .xls , .xlsx , .pdf , .png , .jpg)</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Circular Details</h1><span></span>
					</div>
                     <?php 
					$clid=$_GET['clid'];
							$circularlist=mysql_query("SELECT * FROM circular WHERE cl_id=$clid"); 
								  $circular=mysql_fetch_array($circularlist);
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Ref No :<?=$circular['ref_number'];?></label>
						</p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Published Date : <span class="error">*</span></label>
                                <input id="datepicker1" name="pdate" class="required"  type="text" value="<?php  echo $circular['cl_month']."/".$circular['cl_day']."/".$circular['cl_year'];?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="<?php  echo $circular['title'];?>" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea">Circular Description: <span class="error">*</span></label><textarea id="textarea" name="descript" class="required" rows="5" cols="40"><?php  echo $circular['descript'];?></textarea></p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
								<select name="bid" class="required">
									<option value="0">All</option>
                                    <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$bid1 = $circular['b_id'];
					if($bid1==$row['b_id']){
				?>
									<option value="<?php echo $row['b_id']; ?>" selected><?php echo $row['b_name']; ?></option>									
                            <?php }else { ?>
                            <option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>									
                            <?php } }?>
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Circular Type : <span class="error">*</span></label>
								<select name="type" class="required">
                                <?php if($circular['type']){?>
                                <option value="<?php echo $circular['type'];?>" selected><?php echo $circular['type'];?></option>
                                <?php } ?>
									<option value="All">All</option>
									<option value="Staff">Staff</option>									
                                    <option value="Student">Student</option>
									<option value="Parent">Parent</option>
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="file">Attachment File</label>
								<input type="file" name="file" id="file"/>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($circular['status']=='1'){ echo 'selected'; }?>>Enabled</option>
								<option value="0" <?php if($circular['status']=='0'){ echo 'selected'; }?>>Disabled</option>
											</select>								
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="clid" value="<?php echo $_GET['clid'];?>" >
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

<script src="js/tinyeditor/tinymce.min.js"></script>

<script   type="text/javascript">
tinymce.init({
    selector: "#textareas",
    theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
    font_size_style_values: "12px,13px,14px,16px,18px,20px",
    theme: "modern",
    //height:300,
    //width:500,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   
   toolbar: "insertfile undo redo | styleselect | bold italic | fontselect |  fontsizeselect |  alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons" 
   
 }); 
tinymce.init({
    selector: "#textarea",
    theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
    font_size_style_values: "12px,13px,14px,16px,18px,20px",
    theme: "modern",
    //height:300,
    //width:500,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   
   toolbar: "insertfile undo redo | styleselect | bold italic | fontselect |  fontsizeselect |  alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons" 
   
 }); 
</script>
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
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
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