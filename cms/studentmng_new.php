<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
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
			  
			  		$emapData[1]=mysql_real_escape_string($emapData[1]);
					$emapData[2]=mysql_real_escape_string($emapData[2]);
					$emapData[3]=mysql_real_escape_string($emapData[3]);
					$emapData[4]=mysql_real_escape_string($emapData[4]);
					$emapData[5]=mysql_real_escape_string($emapData[5]);
					$emapData[6]=mysql_real_escape_string($emapData[6]);
					$emapData[7]=mysql_real_escape_string($emapData[7]);
					$emapData[8]=mysql_real_escape_string($emapData[8]);
					$emapData[9]=mysql_real_escape_string($emapData[9]);
					$emapData[10]=mysql_real_escape_string($emapData[10]);
					$emapData[11]=mysql_real_escape_string($emapData[11]);
					
						 $date_split1= explode('/', $emapData[11]);		 
						 $date_month=$date_split1[1];
						 $date_day=$date_split1[0];
						 $date_year=$date_split1[2];
		 
		 
					$emapData[12]=mysql_real_escape_string($emapData[12]);
					$emapData[13]=mysql_real_escape_string($emapData[13]);
					$emapData[14]=mysql_real_escape_string($emapData[14]);
					$emapData[15]=mysql_real_escape_string($emapData[15]);
					$emapData[16]=mysql_real_escape_string($emapData[16]);
					$emapData[17]=mysql_real_escape_string($emapData[17]);
					$emapData[18]=mysql_real_escape_string($emapData[18]);
					$emapData[19]=mysql_real_escape_string($emapData[19]);
					$emapData[20]=mysql_real_escape_string($emapData[20]);
					$emapData[21]=mysql_real_escape_string($emapData[21]);
					$emapData[22]=mysql_real_escape_string($emapData[22]);
					$emapData[23]=mysql_real_escape_string($emapData[23]);
					$emapData[24]=mysql_real_escape_string($emapData[24]);
					$emapData[25]=mysql_real_escape_string($emapData[25]);
					$emapData[26]=mysql_real_escape_string($emapData[26]);
					$emapData[27]=mysql_real_escape_string($emapData[27]);
					$emapData[28]=mysql_real_escape_string($emapData[28]);
					$emapData[29]=mysql_real_escape_string($emapData[29]);
					$emapData[30]=mysql_real_escape_string($emapData[30]);
					$emapData[31]=mysql_real_escape_string($emapData[31]);
					$emapData[32]=mysql_real_escape_string($emapData[32]);
					$emapData[33]=mysql_real_escape_string($emapData[33]);
					$emapData[34]=mysql_real_escape_string($emapData[34]);
					$emapData[35]=mysql_real_escape_string($emapData[35]);
					$emapData[36]=mysql_real_escape_string($emapData[36]);
					
					

			  $adminlist1=mysql_query("SELECT * FROM admin_no_count WHERE id='1'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="SKS".str_pad($adminno1, 4, '0', STR_PAD_LEFT);
								 
			  //$photo=$emapData[1].".jpg";
			  $photo=$emapData[1].".JPG";
			  $gender=ucfirst(trim($emapData[12]));
	           $sql="INSERT INTO student (admission_number,application,firstname,lastname,dob,day,month,year,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,country,pin,phone_number,user_status,joined_date,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,doa,mother_tongue,height,weight,remarks,b_id,stype,fdis_id,ay_id,photo,s_ship,s_reson,second_lang,phone2) 
	           VALUES('$emapData[1]','$emapData[29]','$emapData[2]','$emapData[3]','$emapData[11]','$date_day','$date_month','$date_year','$gender','$emapData[17]','$emapData[13]','$emapData[14]','$emapData[16]','$emapData[15]','$emapData[4]','$emapData[18]','$emapData[1]','$emapData[20]','$emapData[21]','$emapData[22]','$emapData[23]','$emapData[24]','$emapData[19]','1','$todaydate','$cid','$sid','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[25]','$emapData[26]','$emapData[27]','$emapData[28]','$bid','Old','1','$acyear','$photo','$emapData[29]','$emapData[30]','$emapData[31]','$emapData[32]')";
	         //we are using mysql_query function. it returns a resource on true else False on error
	         $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				
				$lastid = mysql_insert_id();
			 
			 $sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,admin_no,b_id) VALUES
('$emapData[4]','$emapData[19]','$emapData[19]','1','$todaydate','$cid','$sid','$emapData[5]','$acyear','$lastid','$admin_number1','$bid')";

$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());


				if(! $result || !$result1 )
				{	
						header("Location:studentmng_new.php?sid=$sid&cid=$cid&bid=$bid&msg=eonfile");
						exit;
				}
				$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");		
				header("Location:studentmng_new.php?sid=$sid&cid=$cid&bid=$bid&msg=succ");
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
    				<?php 
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_stu.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="student_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="Home">Student Management</a></li>
                <li class="no-hover">Import Student Datas</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Import Student Datas (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="student_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
             <a href="sample/student_sample.csv" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File</button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Records Successfully Imported!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Import Student Datas</h1><span></span>
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
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>">
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>">
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