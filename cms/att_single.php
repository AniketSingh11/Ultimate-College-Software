<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$date=$_POST['date'];
	$date_split= explode('/', $date);
			$date_month=$date_split[1];
			$date_day=$date_split[0];		
			$date_year=$date_split[2];
			//echo $date_day."-".$date_month."-".$date_year;			
			
	$sid=$_POST['sid'];
	$cid=$_POST['cid'];
	$mid=$_POST['mid'];
	$att=$_POST['att'];
	$bid=$_POST['bid'];
	
	$select_record=mysql_query("SELECT * FROM student where c_id=$cid AND s_id=$sid AND ay_id=$acyear AND user_status=1");
					while($queryfetch=mysql_fetch_array($select_record))
					{ 
						$acyear;
						$stu_id=$queryfetch['ss_id'];
						$stu_name3=$queryfetch['firstname']." ".$queryfetch['middlename']." ".$queryfetch['lastname'];
						$stu_phone_no=$queryfetch['phone_number'];
						$postName = $queryfetch['ss_id'];
						
						
						$postTests = explode("-",$_POST[$postName]);
							
						$postTest=$postTests[0];
						
						
						$resulthalf=$postTests[1];
						
						$select_record1=mysql_query("SELECT * FROM attendance where (day='$date_day') AND m_id=$mid AND c_id=$cid AND ss_id=$stu_id AND ay_id=$acyear");
						$queryfetch1=mysql_fetch_array($select_record1);
						 
						if($queryfetch1){
							header("Location:att_single.php?cid=$cid&sid=$sid&mid=$mid&bid=$bid&msg=already");
						}else {
							$qry=mysql_query("INSERT INTO `attendance` (`day`,`month`,`year`,`result`,`c_id`,`s_id`,`m_id`,`ss_id`,`b_id`,`ay_id`,`result_half`) VALUES ('$date_day', '$date_month','$date_year', '$postTest','$cid','$sid','$mid','$stu_id','$bid','$acyear','$resulthalf')");
						/*if($postTest=='0'){
							$url="http://59.162.167.52/api/MessageCompose?admin=alanatechnology@gmail.com";
							$msg = "Dear Parent, ".$stu_name3." is absent on ".$date_day."-".$date_month."-".$date_year.", as per school regards. If He / She is not feeling well, we pray for their speedy recovery. Regards,Principal";
								 $ch = curl_init();
                                 curl_setopt($ch,CURLOPT_URL, $url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 curl_setopt($ch, CURLOPT_POST, 1);
                                 curl_setopt($ch, CURLOPT_POSTFIELDS, "user=sms4sdamaduraicentral@gmail.com:NY1C3K7&senderID=SDASMS&receipientno=$stu_phone_no&cid=&msgtxt=$msg");
                                 $buffer = curl_exec($ch);
                                if(empty ($buffer))
                                { echo " buffer is empty "; }else{ echo $buffer; } 
                                curl_close($ch);
						}else if($postTest=='off'){
							$url="http://59.162.167.52/api/MessageCompose?admin=alanatechnology@gmail.com";
							$msg = "Dear Parent, ".$stu_name3." is HalfDay absent on ".$date_day."-".$date_month."-".$date_year.", as per school regards. If He / She is not feeling well, we pray for their speedy recovery. Regards,Principal";
								 $ch = curl_init();
                                 curl_setopt($ch,CURLOPT_URL, $url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 curl_setopt($ch, CURLOPT_POST, 1);
                                 curl_setopt($ch, CURLOPT_POSTFIELDS, "user=sms4sdamaduraicentral@gmail.com:NY1C3K7&senderID=SDASMS&receipientno=$stu_phone_no&cid=&msgtxt=$msg");
                                 $buffer = curl_exec($ch);
                                if(empty ($buffer))
                                { echo " buffer is empty "; }else{ echo $buffer; } 
                                curl_close($ch);
						}*/
						}
					}					
		if(!$qry)
{
die("Query Failed: ". mysql_error());
}
else
{
 header("Location:att_single.php?cid=$cid&sid=$sid&mid=$mid&bid=$bid&msg=succ");
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
							$mid=$_GET['mid'];
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							$subjectlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($subjectlist);	
								  
								  $sdate_month=str_pad($month['m_no'], 2, "0", STR_PAD_LEFT);
								  
								  if($sdate_month>5){
										$y_value=$syear;
									}else if($sdate_month<=5){
										$y_value=$eyear;
									}
									$numdays = cal_days_in_month(CAL_GREGORIAN, $sdate_month, $y_value);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_att.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="att_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&bid=<?php echo $bid;?>" title="Student Attendance Management">Student Attendance managemrnt</a></li>
                <li class="no-hover">Add Student Attendance</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New <?php echo $class['c_name']."-".$section['s_name'];?> Student Attendance <b>( <?php echo $month['m_name'];?> )</b></h1>                
			<a href="att_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Attendance Details Successfully Created!!!</div>
            <?php } else if($msg=="already"){?>			
            <div class="alert warning"><span class="hide">x</span>This date Attendance Details Already Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New <?php echo $class['c_name']."-".$section['s_name'];?> Student Attendance <b>( <?php echo $month['m_name'];?> )</b></h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
                                <label for="textfield">Select Date: <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="" />
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
                        <th><center>Present</center></th>
                        <th><center>Absent - FullDay</center></th>
                        <th><center>Absent - HalfDay </center></th>
                       </thead>
                    </thead>
                    <tbody>
                    	<?php 
						 $att=1;						 
					$select_record=mysql_query("SELECT * FROM student where c_id=$cid AND s_id=$sid AND ay_id=$acyear AND user_status=1");
					while($student12=mysql_fetch_array($select_record))
					{ 
					$ssid=$queryfetch['ss_id'];
					$id=$queryfetch['admission_number'];?>
                        <tr>
                        <td><center><?php echo $att;?></center></td>
                        <td><center><?php echo $student12['admission_number']?></center></td>
                        <td><center><?php echo $student12['firstname']." ".$student12['middlename']." ".$student12['lastname']; ?></center></td>
                        <td><center><input type="radio" id="name"  name="<?php echo $student12['ss_id']?>" class="text err" value="1" checked="checked"  /></center></td>
                        <td><center><input type="radio" id="name" name="<?php echo $student12['ss_id']?>" class="text err" value="0" /></center></td>
                        <td><center><input type="radio" id="name" name="<?php echo $student12['ss_id']?>" class="text err" value="off-M" />Morning
                        <input type="radio" id="name" name="<?php echo $student12['ss_id']?>" class="text err" value="off-E" />Afternoon</center></td>
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
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
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
		$( "#datepicker" ).Zebra_DatePicker({
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