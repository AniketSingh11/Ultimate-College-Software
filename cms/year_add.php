<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");


 if (isset($_POST['submit']))
{
	$syear=$_POST['syear'];
	$eyear=$_POST['eyear'];
	$yname=$_POST['yname'];
	
	  $yearlist=mysql_query("SELECT * FROM year WHERE y_name='$yname'"); 
	  $year1=mysql_fetch_array($yearlist);
	  
	  if($year1){
		  header("Location:year_add.php?msg=aerr");
	  }else{		 
	
	$sql="INSERT INTO year (y_name,s_year,e_year) VALUES('$yname','$syear','$eyear')";
	$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	$lastid=mysql_insert_id();
    if($result){
		$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May");
		$mno=6;
		for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
			$mname=$montharray[$cmonth-1];
			if($mno>12){
				$mno=$mno-($cmonth+4);
				}
		$sql1=mysql_query("INSERT INTO month (m_id,m_name,m_no,ay_id) VALUES ('','$mname','$mno','$lastid')");
		$mno++;
		}
       
    }
    echo $acyear.'<br>';
   	$ayid=$lastid;
   	echo $ayid;
   	$frate_sec_com=array();
   	$frate_others=array();
   	//class clone
    $allclass=mysql_query("select * from class where ay_id=$acyear");
    while($classiter = mysql_fetch_assoc($allclass)){
    			$classiter['ay_id']=$ayid;
    			$cid_old=$classiter['c_id'];
    			unset($classiter['c_id']);
    			$columns = implode(",",array_keys($classiter));
				$escaped_values = array_map('mysql_real_escape_string', array_values($classiter));
				$values  = implode("','", $escaped_values);
				$sql = "INSERT INTO class($columns) VALUES ('$values')";
    			//echo 'class';
    			$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    			$c_id=mysql_insert_id();
    			$frate_others[$cid_old]=$c_id;
    			//section clone
    			$allsec=mysql_query("select * from section where ay_id=$acyear AND c_id=$cid_old");
    			while($sec = mysql_fetch_assoc($allsec)){
    				$sec['ay_id']=$ayid;
    				$sec['c_id']=$c_id;
    				$sid_old=$sec['s_id'];
    				unset($sec['s_id']);
    				$columns = implode(",",array_keys($sec));
					$escaped_values = array_map('mysql_real_escape_string', array_values($sec));
					$values  = implode("','", $escaped_values);
    				$sql = "INSERT INTO section($columns) VALUES ('$values')";
    				//echo $sql.'<br>';
    				$result = mysql_query($sql) or die("Section Could not insert data into DB: " . mysql_error());
    				$s_id=mysql_insert_id();
    				if(($classiter['c_name']=="XI") || ($classiter['c_name']=="XII")){
    					$frate_sec_com[$sid_old]=$s_id;
    				}
    				//subject list
    				$suball=mysql_query("select * from subjectlist where ay_id=$acyear and c_id=$cid_old and s_id=$sid_old");
    				while($sub=mysql_fetch_assoc($suball)){
    					echo '<pre>';
    					print_r($sub);
    					echo '</pre>';
    					unset($sub['sl_id']);
    					$sub['ay_id']=$ayid;
    					$sub['c_id']=$c_id;
    					$sub['s_id']=$s_id;
    					$columns = implode(",",array_keys($sub));
						$escaped_values = array_map('mysql_real_escape_string', array_values($sub));
						$values  = implode("','", $escaped_values);
    					$sql = "INSERT INTO subjectlist($columns) VALUES ('$values')";
    					$result = mysql_query($sql) or die("Section Could not insert data into DB: " . mysql_error());
    				}	
    			}
    			//fee rate
    			$termfee=mysql_query("select * from frate where ay_id=$acyear and c_id=$cid_old");
				while($frate = mysql_fetch_assoc($termfee)){
    				unset($frate['fr_id']);
    				$frate['ay_id']=$ayid;
    				$frate['c_id']=$c_id;
    				if(($classiter['c_name']=="XI") || ($classiter['c_name']=="XII")){
    					foreach ($frate_sec_com as $key => $value) {
    						if($key==$frate['s_id'])
    						$frate['s_id'] = $value;	
    					}
    					$columns = implode(",",array_keys($frate));
						$escaped_values = array_map('mysql_real_escape_string', array_values($frate));
						$values  = implode("','", $escaped_values);
    					$sql = "INSERT INTO frate($columns) VALUES ('$values')";
    					echo 'frate';
    					$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());		
    				} else {
    				$columns = implode(",",array_keys($frate));
					$escaped_values = array_map('mysql_real_escape_string', array_values($frate));
					$values  = implode("','", $escaped_values);
    				$sql = "INSERT INTO frate($columns) VALUES ('$values')";
    				echo 'frate';
    				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    				}
    			}		
	  	}
	  	//Book fee setings
	  	$allbook=mysql_query("select * from others_bill_all where ay_id=$acyear");
	  	while($book = mysql_fetch_assoc($allbook)){
	  		unset($book['others_id']);
	  		$book['ay_id']=$ayid;
	  		foreach ($frate_others as $key => $value) {
	  			if($key==$book['std'])
	  				$book['std']=$value;
	  		}
	  		$columns = implode(",",array_keys($book));
			$escaped_values = array_map('mysql_real_escape_string', array_values($book));
			$values  = implode("','", $escaped_values);
    		$sql = "INSERT INTO others_bill_all($columns) VALUES ('$values')";
    		echo 'frate';
    		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	  	}
	  	//Fee invoice FR number 
	  	$sql="INSERT INTO finvoice_no(count,ay_id,category) VALUES('1',$ayid,'CL')";
	  	$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	  	$sql="INSERT INTO finvoice_no(count,ay_id,category) VALUES('1',$ayid,'CM')";
	  	$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	  	$sql="INSERT INTO finvoice_no(count,ay_id,category) VALUES('1',$ayid,'CH')";
	  	$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

	  	//Book fee invoice FR number
	  	$sql="INSERT INTO finvoice_no_others(count,ay_id,category) VALUES('1',$ayid,'book')";
	  	$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	 header("Location:year_add.php?msg=succ");
	 die;
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
				<li class="no-hover"><a href="year.php" title="Home">Academic Year list</a></li>
                <li class="no-hover">Add New Academic Year</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New </h1>                
			<a href="year.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } 
			if($msg=="aerr"){?>			
            <div class="alert error"><span class="hide">x</span>This Academic Year Already Added!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Academic Year</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    	<?php 
						$startyearlist=mysql_query("SELECT s_year FROM year order by s_year asc");
						$startyear=mysql_fetch_array($startyearlist);
						$styear=$startyear['s_year']-1;
						$endyearlist=mysql_query("SELECT e_year FROM year order by e_year desc");
						$endyear=mysql_fetch_array($endyearlist);
						$edyear=$endyear['e_year'];
						?>
						<div class="_25">
							<p>
								<label for="select">Start Year</label>
								<select class="required" name="syear" id="syear" onchange="change_year()">
									<option value="">Please Select Year</option>
                                    <?php for($i=$edyear;$i>=$styear;$i--){?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">End Year</label>
								<input name="eyear" id="eyear" type="text" value="" readonly class="required" />
							</p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Academic Year</label>
                                <input name="yname" id="yname" type="text" value="" readonly class="required"/>
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
	});
	function change_year() { 	
      var syear = parseInt(document.getElementById('syear').value);
	  if(syear>1){
		  var eyearvalue = syear+1;		  
		  var ynamevalue = syear+"-"+eyearvalue;		  
	  }		   
	  
	  eyear = document.getElementById('eyear');
	  eyear.value = eyearvalue;
	  yname = document.getElementById('yname');	  
	  yname.value = ynamevalue;
}
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