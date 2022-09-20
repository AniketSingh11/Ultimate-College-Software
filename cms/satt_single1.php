<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname']; 
 if (isset($_POST['submit']))
{
	$date=$_POST['date'];
	$date_split= explode('/', $date);
			$date_month=$date_split[0];
			$date_day=$date_split[1];		
			$date_year=$date_split[2];
			
	$mid=$_POST['mid'];
	$att=$_POST['att'];
	
	$select_record=mysql_query("SELECT * FROM staff ");
					while($queryfetch=mysql_fetch_array($select_record))
					{ 
						//echo $acyear;
						//die();
						$st_id=$queryfetch['st_id'];
						$postName = $queryfetch['staff_id'];
						$postTest = $_POST[$postName];
						$ltidcom="ltid".$postName;
						$ltid = $_POST[$ltidcom];
						$reasoncom="reason".$postName;
						$reason = $_POST[$reasoncom];
						
						$select_record1=mysql_query("SELECT * FROM sattendance where (day='$date_day') AND m_id=$mid AND st_id=$st_id AND ay_id=$acyear");
						$queryfetch1=mysql_fetch_array($select_record1);
						
						if($queryfetch1){
							header("Location:satt_single.php?mid=$mid&msg=already");
						}else{
							$qry=mysql_query("INSERT INTO `sattendance` (`day`,`month`,`year`,`result`,`m_id`,`st_id`,`lt_id`,`reason`,`ay_id`) VALUES ('$date_day', '$date_month','$date_year', '$postTest','$mid','$st_id','$ltid','$reason','$acyear')");
						}
					}					
		if(!$qry)
{
die("Query Failed: ". mysql_error());
}
else
{
 header("Location:satt_single.php?mid=$mid&msg=succ");
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
							$mid=$_GET['mid'];
							
							$syear=$ay['s_year'];
							$eyear1=$ay['e_year'];
							
							$day=date("d");
							$subjectlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($subjectlist);	
								  
								  $mno=str_pad($month['m_no'], 2, "0", STR_PAD_LEFT);
								  if($mno<='5'){
								$year=$eyear1;
							}else if($mno>5){
								$year=$syear;
							}
							$numdays = cal_days_in_month(CAL_GREGORIAN, $mno, $year); 
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="satt_mng.php?mid=<?php echo $mid;?>" title="Result Management">Staff Attendance managemrnt</a></li>
                <li class="no-hover">Add Staff Attendance</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Staffs Attendance <b>( <?php echo $month['m_name'];?> )</b></h1>                
			<a href="satt_mng.php?mid=<?php echo $mid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
						<h1>Add New Staff Attendance <b>( <?php echo $month['m_name'];?> )</b></h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
                                <label for="textfield">Select Date: <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $mno."/".$day."/".$year;?>" />
                            </p>
						</div>
                         <div class="_100">
                         <p>
                         <label for="textfield">Fill Staff Attendance: </label>
                        <table class="table">
                  	<thead>
                    	<th><center>S.No</center></th>
                    	<th><center>Staff ID</center></th>
                        <th><center>Staff Name</center></th>
                        <th><center>Present</center></th>
                        <th><center>Absent - FullDay</center></th>
                        <th><center>Absent - HalfDay </center></th>
                        <th><center>Leave Type</center></th>
                        <th><center>Reason </center></th>
                       </thead>
                    </thead>
                    <tbody>
                    	<?php 
						 $att=1;						 
					$select_record=mysql_query("SELECT * FROM staff");
					while($student12=mysql_fetch_array($select_record))
					{ 
					//$id=$queryfetch['admission_number'];?>
                        <tr>
                        <td><center><?php echo $att;?></center></td>
                        <td><center><?php echo $student12['staff_id']?></center></td>
                        <td><center><?php echo $student12['fname']." ".$student12['mname']." ".$student12['lname']; ?></center></td>
                        <td><center><input type="radio" id="name"  name="<?php echo $student12['staff_id']?>" class="text err" value="1" checked="checked"  /></center></td>
                        <td><center><input type="radio" id="name" name="<?php echo $student12['staff_id']?>" class="text err" value="0" /></center></td>
                        <td><center><input type="radio" id="name" name="<?php echo $student12['staff_id']?>" class="text err" value="off" /></center></td>
                        <td><?php
                                            $classl = "SELECT * FROM leavetype";
											$staffid=$student12['staff_id'];
                                            $result1 = mysql_query($classl) or die(mysql_error()); ?>
                                            <select name="ltid<?php echo $student12['staff_id']?>" id="ltid"> 
                                            <option value="">Select Leave Type</option>
											<?php while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['lt_id']}'>{$row1['lt_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?></td>
                        <td><center><input type="text" id="reason" name="reason<?php echo $student12['staff_id']?>" class="text err" /></center></td>                    
                        </tr>
                     <?php $att++; } ?>
                    </tbody>
                  </table></p><br><br>	
                  </div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" name="mid" value="<?php echo $mid;?>" />
                        <input type="hidden" name="att" value="<?php echo $att;?>" />   
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
        format: 'm/d/Y',
		direction: ['<?php echo $mno."/01/".$year;?>', '<?php echo $mno."/".$numdays."/".$year;?>'],
		disabled_dates: ['* * * 0']
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