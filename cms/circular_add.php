<? ob_start(); ?>
<?php
//error_reporting(E_ALL ^ E_NOTICE);
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
	
	
	$adminlist=mysql_query("SELECT * FROM circular_ref_count WHERE crc_id='1'");
	$admincount=mysql_fetch_array($adminlist);
	
	$refno=$admincount['count'];
	$refno2=$refno+1;
	$ref_number="Cir".str_pad($refno, 3, '0', STR_PAD_LEFT);
	
	$sql1=mysql_query("UPDATE circular_ref_count SET count='$refno2' WHERE crc_id='1'");
	
	 
	
	//echo '<pre>'; print_r($image); echo '</pre>';
	//die();
	
		if($image[error]!=4){	
			if (!is_valid_type($image) || $filesize>3000000){
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location: circular_add.php?msg=eronfile");
    		exit;
			}
			if (move_uploaded_file($_FILES["file"]["tmp_name"], "circular/" . $newfilename)) {
				
				$sql="INSERT INTO circular (cl_day,cl_month,cl_year,title,descript,type,file,status,b_id,ay_id,ref_number) VALUES
('$publish_day','$publish_month','$publish_year','$title','$descript','$type','$newfilename','1','$bid','$acyear','$ref_number')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if($result){/*
					if($type=='Staff'){
						$select_record1=mysql_query("SELECT * FROM staff where s_type='Teaching' AND status='1'");
							while($queryfetch1=mysql_fetch_array($select_record1))
							{ 
							$phone_no=$queryfetch1['phone_no'];
							$url="http://59.162.167.52/api/MessageCompose?admin=alanatechnology@gmail.com";
							$msg = "Dear Parent, Title :".$title." ,Desc :".$descript.".Regards,Principal";
								 $ch = curl_init();
                                 curl_setopt($ch,CURLOPT_URL, $url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 curl_setopt($ch, CURLOPT_POST, 1);
                                 curl_setopt($ch, CURLOPT_POSTFIELDS, "user=sms4sdamaduraicentral@gmail.com:NY1C3K7&senderID=SDASMS&receipientno=$phone_no&cid=&msgtxt=$msg");
                                 $buffer = curl_exec($ch);
                                if(empty ($buffer))
                                { echo " buffer is empty "; }else{ echo $buffer; } 
                                curl_close($ch);
							}	
					}else if($type=='Parent'){
						$qry2="SELECT * FROM parent where ay_id='$acyear'";
						if($bid && $bid>0){
							$qry2.=" AND b_id='$bid'";
						}
						$qry2;
						$select_record2=mysql_query($qry2);
					while($queryfetch2=mysql_fetch_array($select_record2))
					{ 
					 $pphone_no=$queryfetch2['phone_number'];
					 $url="http://59.162.167.52/api/MessageCompose?admin=alanatechnology@gmail.com";
							$msg = "Dear Parent, Title :".$title." ,Desc :".$descript.".Regards,Principal";
								 $ch = curl_init();
                                 curl_setopt($ch,CURLOPT_URL, $url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 curl_setopt($ch, CURLOPT_POST, 1);
                                 curl_setopt($ch, CURLOPT_POSTFIELDS, "user=sms4sdamaduraicentral@gmail.com:NY1C3K7&senderID=SDASMS&receipientno=$pphone_no&cid=&msgtxt=$msg");
                                 $buffer = curl_exec($ch);
                                if(empty ($buffer))
                                { echo " buffer is empty "; }else{ echo $buffer; } 
                                curl_close($ch);
					}
					 
				}*/
				header("Location:circular_add.php?msg=succ");
			} 
			}else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:circular_add.php?msg=eronfile");
				exit;
			}

		} else {
			//echo "test";
			//die();
			$sql="INSERT INTO circular (cl_day,cl_month,cl_year,title,descript,type,status,b_id,ay_id,ref_number) VALUES
('$publish_day','$publish_month','$publish_year','$title','$descript','$type','1','$bid','$acyear','$ref_number')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
			/*if($type=='Staff'){
						$select_record1=mysql_query("SELECT * FROM staff where s_type='Teaching' AND status='1'");
							while($queryfetch1=mysql_fetch_array($select_record1))
							{ 
							$phone_no=$queryfetch1['phone_no'];
							$url="http://59.162.167.52/api/MessageCompose?admin=alanatechnology@gmail.com";
							$msg = "Dear Parent, Title :".$title." ,Desc :".$descript.".Regards,Principal";
								 $ch = curl_init();
                                 curl_setopt($ch,CURLOPT_URL, $url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 curl_setopt($ch, CURLOPT_POST, 1);
                                 curl_setopt($ch, CURLOPT_POSTFIELDS, "user=sms4sdamaduraicentral@gmail.com:NY1C3K7&senderID=SDASMS&receipientno=$phone_no&cid=&msgtxt=$msg");
                                 $buffer = curl_exec($ch);
                                if(empty ($buffer))
                                { echo " buffer is empty "; }else{ echo $buffer; } 
                                curl_close($ch);
							}	
					}else if($type=='Parent'){
						$qry2="SELECT * FROM parent where ay_id='$acyear'";
						if($bid && $bid>0){
							$qry2.=" AND b_id='$bid'";
						}
						$qry2;
						$select_record2=mysql_query($qry2);
					while($queryfetch2=mysql_fetch_array($select_record2))
					{ 
					 $pphone_no=$queryfetch2['phone_number'];
					 $url="http://59.162.167.52/api/MessageCompose?admin=alanatechnology@gmail.com";
							$msg = "Dear Parent, Title :".$title." ,Desc :".$descript.".Regards,Principal";
								 $ch = curl_init();
                                 curl_setopt($ch,CURLOPT_URL, $url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 curl_setopt($ch, CURLOPT_POST, 1);
                                 curl_setopt($ch, CURLOPT_POSTFIELDS, "user=sms4sdamaduraicentral@gmail.com:NY1C3K7&senderID=SDASMS&receipientno=$pphone_no&cid=&msgtxt=$msg");
                                 $buffer = curl_exec($ch);
                                if(empty ($buffer))
                                { echo " buffer is empty "; }else{ echo $buffer; } 
                                curl_close($ch);
					}
					 
				}*/
        header("Location:circular_add.php?msg=succ");
    }
    exit;	
			}			
}
if (isset($_POST['submit1']))
{
	 $pdate=$_POST['pdate'];
	 $title=$_POST['title'];
	 $descript=$_POST['descript'];
	 $bid=$_POST['bid'];
	 $cid=$_POST['cid'];
	 $sid=$_POST['sid'];
	
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
	
	
	$adminlist=mysql_query("SELECT * FROM circular_ref_count WHERE crc_id='1'");
	$admincount=mysql_fetch_array($adminlist);
	
	$refno=$admincount['count'];
	$refno2=$refno+1;
	$ref_number="Cir".str_pad($refno, 3, '0', STR_PAD_LEFT);
	
	$sql1=mysql_query("UPDATE circular_ref_count SET count='$refno2' WHERE crc_id='1'");
	
	//echo '<pre>'; print_r($image); echo '</pre>';
	//die();
	
		if($image[error]!=4){	
			if (!is_valid_type($image) || $filesize>3000000){
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location:circular_add.php?msg=eronfile");
    		exit;
			}
			if (move_uploaded_file($_FILES["file"]["tmp_name"], "circular/" . $newfilename)) {
				
				$sql="INSERT INTO circular (cl_day,cl_month,cl_year,title,descript,type,file,status,b_id,c_id,s_id,ay_id,ref_number) VALUES
('$publish_day','$publish_month','$publish_year','$title','$descript','Student','$newfilename','1','$bid','$cid','$sid','$acyear','$ref_number')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if($result){
					 header("Location:circular_add.php?msg=succ");
				}
			} else {
				header("Location:circular_add.php?msg=eronfile");
				exit;
			}

		} else {
			
			$sql="INSERT INTO circular (cl_day,cl_month,cl_year,title,descript,type,status,b_id,c_id,s_id,ay_id,ref_number) VALUES
('$publish_day','$publish_month','$publish_year','$title','$descript','Student','1','$bid','$cid','$sid','$acyear','$ref_number')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:circular_add.php?msg=succ");
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
				<h1>Add New Circular Details</h1>                
			<a href="circular.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.doc , .docx , .xls , .xlsx , .pdf , .png , .jpg)</div>
            <?php } ?>
            
          
            
            
				<div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Add New Circular Details</h1>
                        <ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">All Circular</a></li>
							<li><a href="#tab-2">Specific Standard Circular</a></li>
						</ul>
                        <span></span>
					</div>
                    <div class="block-content tab-container" >
						<div id="tab-1" class="tab-content">
							<br>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
                                <label for="textfield">Published Date : <span class="error">*</span></label>
                                <input id="datepicker2" name="pdate" class="required"  type="text" value="" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea">Circular Description: <span class="error">*</span></label><textarea id="textarea" name="descript"   rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
								<select name="bid" class="required">
									<option value="">Select one</option>
									<option value="0">All</option>
                                    <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
									<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>									
                            <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Circular Type : <span class="error">*</span></label>
								<select name="type" class="required">
									<option value="">Select one</option>
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
                    <div id="tab-2" class="tab-content">
                        <br>
                        <form id="validate-form1" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
                                <label for="textfield">Published Date : <span class="error">*</span></label>
                                <input id="datepicker1" name="pdate" class="required"  type="text" value="" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea">Circular Description: <span class="error">*</span></label><textarea id="textareas" name="descript" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
								<select name="bid" class="required" onchange="showCategory1(this.value)">
									<option value="">Select Board</option>
                                    <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
									<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>									
                            <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<select name="cid" id="cid" class="required" onchange="showCategory(this.value)">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Section / Group :</label>
                               <select name="sid" id="sid">
											<option value="All">All</option>											
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="file">Attachment File</label>
								<input type="file" name="file" id="file"/>
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form1" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="submit1" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
                     </div>   
                    </div>
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
		var validateform1 = $("#validate-form1").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$("#reset-validate-form1").click(function() {
			validateform1.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$("#tab-panel-1").createTabs();
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
    function showCategory1(str) {
        if (str == "") {
            document.getElementById("cid").innerHTML = "";
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
                document.getElementById("cid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "standardlist.php?mmtid=" + str, true);
        xmlhttp.send();
    } function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "<option value='All'>All</option>";
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
                document.getElementById("sid").innerHTML = "<option value='All'>All</option>"+xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script> 
  
            
</body>
</html>
<? ob_flush(); ?>