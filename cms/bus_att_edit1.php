<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 							$rid=$_GET['rid'];
							$mid=$_GET['mid'];
							$eday=$_GET['eday'];
							
							$classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$subjectlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($subjectlist);	
								  
								  $sdate_month=str_pad($month['m_no'], 2, "0", STR_PAD_LEFT);
								  
								  if($sdate_month>5){
										$y_value=$syear;
									}else if($sdate_month<=5){
										$y_value=$eyear;
									}
									$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $y_value);
									
									$myarray = array();
								  $qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($row=mysql_fetch_array($qry))
									{
										array_push($myarray,$row['stop_id']);										
									}
									
 if (isset($_POST['submit']))
{
	$date=$_POST['date'];
	$date_split= explode('/', $date);
			$date_month=$date_split[1];
			$date_day=$date_split[0];		
			$date_year=$date_split[2];
			//echo $date_day."-".$date_month."-".$date_year;			
			
	$rid=$_POST['rid'];
	$mid=$_POST['mid'];
	$att=$_POST['att'];
	$bid=$_POST['bid'];	
	if($eday!=$date_day){
		$select_record1=mysql_query("SELECT * FROM battendance where (day='$date_day') AND m_id=$mid AND r_id=$rid AND ay_id=$acyear");
						$queryfetch1=mysql_fetch_array($select_record1);						 
						if($queryfetch1){
							header("Location:bus_att_edit1.php?rid=$rid&mid=$mid&bid=$bid&eday=$eday&msg=already");
							exit;
						}
	}
			$select_record=mysql_query("SELECT ss_id,c_id,s_id,b_id,sp_id,busfeestype,admission_number,firstname,lastname FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
					while($queryfetch=mysql_fetch_array($select_record))
					{ 
						$acyear;
						$stu_id=$queryfetch['ss_id'];
						$spid1=$queryfetch['sp_id'];
						$stu_name3=$queryfetch['firstname']." ".$queryfetch['lastname'];
						$stu_phone_no=$queryfetch['phone_number'];
						$postName = $queryfetch['ss_id'];
						
						$postTests = explode("-",$_POST[$postName]);
							
						$postTest=$postTests[0];
						
						$resulthalf=$postTests[1];		
						
						$select_record2=mysql_query("SELECT * FROM battendance WHERE ss_id='$stu_id' AND m_id='$mid' AND day=$eday");
						$check=mysql_fetch_array($select_record2);
						
						if($check){
						$sql=mysql_query("UPDATE battendance SET day='$date_day',month='$date_month',year='$date_year',eresult='$postTest',r_id='$rid',b_id='$bid' WHERE ss_id='$stu_id' AND m_id='$mid' AND day=$eday");
						}else{
							$qry=mysql_query("INSERT INTO `battendance` (`day`,`month`,`year`,`eresult`,`r_id`,`sp_id`,`m_id`,`ss_id`,`b_id`,`ay_id`) VALUES ('$date_day', '$date_month','$date_year','$postTest','$rid','$spid1','$mid','$stu_id','$bid','$acyear')");
						}
					    //
						}
						header("Location:bus_att_edit1.php?rid=$rid&mid=$mid&bid=$bid&eday=$date_day&msg=succ");
						exit;
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
                <li class="no-hover"><a href="#.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="bus_att_mng.php?rid=<?php echo $rid;?>&&mid=<?php echo $mid;?>&bid=<?php echo $bid;?>" title="Student Attendance Management">Student Vehicle Attendance</a></li>
                <li class="no-hover">Edit Attendance - <?php echo $class['r_name'];?></li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit <?php echo $class['r_name'];?> - Student Attendance <b>( <?php echo $month['m_name'];?> )</b></h1>                
			<a href="bus_att_mng.php?rid=<?php echo $rid;?>&&mid=<?php echo $mid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Attendance Details Successfully edited!!!</div>
            <?php } else if($msg=="already"){?>			
            <div class="alert warning"><span class="hide">x</span>Selected date Attendance Details Already Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit <?php echo $class['r_name'];?> - Student Attendance <b>( <?php echo $month['m_name'];?> )</b></h1><span></span>
                        <?php
						$editatt=mysql_query("SELECT * FROM battendance WHERE m_id=$mid AND day=$eday LIMIT 1"); 
								  $editdate=mysql_fetch_array($editatt);
								  $emonth=$editdate['month'];
								  $eyear=$editdate['year'];	
								  ?>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_25">
							<p>
                                <label for="textfield">Select Date: <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $eday."/".$emonth."/".$eyear;?>" readonly/>
                            </p>
						</div>
                         <div class="_100">
                         <p>
                         <label for="textfield">Fill Student Attendance: </label>
                        <table class="table">
                  	  <thead>
                    	<th><center>S.No</center></th>
                    	<th><center>Admin No</center></th>
                        <th><center>Student Name</center></th>
                        <th><center>Class/Section</center></th>
                        <th><center>Stopping Point</center></th>
                        <th><center>Present</center></th>
                        <th><center>Absent</center></th>
                      </thead>
                    <tbody>
                    	<?php 
						 $att=1;						 
					$qry=mysql_query("SELECT ss_id,c_id,s_id,b_id,sp_id,busfeestype,admission_number,firstname,lastname FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
							$count=1;
			  while($queryfetch=mysql_fetch_array($qry))
        		{
					$ssid=$queryfetch['ss_id'];
					$cid=$queryfetch['c_id'];
					$sid=$queryfetch['s_id'];
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  
								  $bid=$queryfetch['b_id'];
								  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								    
								  $spid1=$queryfetch['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];
								  
								  $dayatt1=mysql_query("SELECT * FROM battendance WHERE m_id=$mid AND day=$eday AND ss_id=$ssid"); 
								  $attday=mysql_fetch_array($dayatt1);
								  $result=$attday['eresult'];
								   if($result == null){
									   $result=$attday['mresult'];
								   }
								  ?>
                        <tr>
                        <td><center><?php echo $att;?></center></td>
                        <td><center><?php echo $queryfetch['admission_number']?></center></td>
                        <td><center><?php echo $queryfetch['firstname']." ".$queryfetch['lastname']; ?></center></td>
                        <td><center><?php echo $class['c_name']." / ".$section['s_name']; ?></center></td>
                        <td><center><?php echo $row6['stop_name']; ?></center></td>
                        <td><center><input type="radio" id="name"  name="<?php echo $queryfetch['ss_id']?>" class="text err" value="1" <?php if($result=='1'){ echo 'checked="checked"';}?>  /></center></td>
                        <td><center><input type="radio" id="name" name="<?php echo $queryfetch['ss_id']?>" class="text err" value="0"  <?php if($result=='0'){ echo 'checked="checked"';}?>/></center></td>
                        </tr>
                     <?php $att++; } ?>
                        <input type="hidden" name="yid" value="<?php echo $yid;?>" />
                        <input type="hidden" name="att" value="<?php echo $att;?>" /> 
                        <input type="hidden" name="bid" value="<?php echo $bid;?>" />                        
                    </tbody>
                  </table></p><br><br>	
                  </div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="rid" value="<?php echo $_GET['rid'];?>" >
                            <input type="hidden" class="medium" name="mid" value="<?php echo $_GET['mid'];?>" >
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
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y',
		direction: ['<?php echo "01/".$sdate_month."/".$y_value;?>', '<?php echo $numdays."/".$sdate_month."/".$y_value;?>']
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