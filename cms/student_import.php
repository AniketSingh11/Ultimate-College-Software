<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	//echo "test";
	//$sname=$_POST['sname'];
	 $cid=$_POST['cid'];
	 $sid=$_POST['sid'];
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
			  
			  $adminlist1=mysql_query("SELECT * FROM admin_no_count WHERE id='1'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="SW".str_pad($adminno1, 5, '0', STR_PAD_LEFT);
								 
			  //$photo=$emapData[1].".jpg";
			  $photo=$admin_number1.".JPG";
	           $sql = "INSERT INTO student (admission_number,firstname,middlename,lastname,dob,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,country,pin,phone_number,user_status,joined_date,bar_code,c_id,s_id,fathersocupation,from_school,eslc,tc,doa,protected,mother_tongue,std_leaving,no_date_tran,dol,reason_leaving,school_pubil,remarks,b_id,ay_id,photo) values('$admin_number1','$emapData[2]','$emapData[4]','$emapData[3]','$emapData[11]','$emapData[12]','$emapData[18]','$emapData[14]','$emapData[15]','$emapData[16]','$emapData[17]','$emapData[5]','$emapData[19]','$admin_number1','$emapData[21]','$emapData[22]','$emapData[23]','$emapData[24]','$emapData[25]','$emapData[20]','1','$todaydate','','$cid','$sid','$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[13]','$emapData[26]','$emapData[27]','$emapData[28]','$emapData[29]','$emapData[30]','$emapData[31]','$emapData[32]','$bid','$acyear','$photo')";
	         //we are using mysql_query function. it returns a resource on true else False on error
	         $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				
				$lastid = mysql_insert_id();
			 
			 $sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,admin_no,b_id) VALUES
('$emapData[5]','$emapData[20]','$emapData[20]','1','$todaydate','$cid','$sid','$emapData[6]','$acyear','$lastid','$admin_number1','$bid')";

$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());


				if(! $result || !$result1 )
				{	
						header("Location:student_import.php?sid=$sid&cid=$cid&bid=$bid&msg=eonfile");
						exit;
				}
				$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");		
				header("Location:student_import.php?sid=$sid&cid=$cid&bid=$bid&msg=succ");
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
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">    				
    	<!-- Begin of titlebar/breadcrumbs -->
        <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_stuimp.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Import Student Datas</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_stuimp.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="student_import.php">
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
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
                
                <?php $msg=$_GET['msg'];
					$mcid=$_GET['mcid'];
					$msid=$_GET['msid'];
					
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span><strong>Your Records Successfully Imported!!!</strong>
            <center><a href="student_mng.php?cid=<?php echo $mcid;?>&sid=<?php echo $msid;?>"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To See the Imported datas </button></a></center></div>
            
            
            <?php } ?>
                
            </div>
			
            <?php 
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1>Import Student Datas (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			 <a href="sample/student_sample.csv" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File</button></a>
			</div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
						<h1>Import Student Datas</h1><span></span>
					</div>
					<form id="validate-form1" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
								<label for="file">Upload a file</label>
								<input type="file" name="file" id="file" class="required" required/>
							</p>
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form1" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
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
  
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		var validateform1 = $("#validate-form1").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$("#reset-validate-form1").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).datepicker();
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
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
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>