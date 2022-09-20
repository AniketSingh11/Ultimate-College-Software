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
			
	$mid=$_GET['mid'];
	$att=$_POST['att'];
	$eday=$_GET['eday'];
	
	$select_record=mysql_query("SELECT * FROM driver WHERE status='1'");
					while($queryfetch=mysql_fetch_array($select_record))
					{ 
						//echo $acyear;
						//die();
						$d_id=$queryfetch['d_id'];
						$postName = $queryfetch['d_id'];
						//$postTest = $_POST[$postName];
						
						$postTests = explode("-",$_POST[$postName]);
							
						$postTest=$postTests[0];
						
						
						$resulthalf=$postTests[1];
						
						$ltidcom="ltid".$postName;
						$ltid = $_POST[$ltidcom];
						$reasoncom="reason".$postName;
						$reason = $_POST[$reasoncom];
						
						$select_record2=mysql_query("SELECT satt_id,l_apply FROM sattendance WHERE d_id='$d_id' AND m_id='$mid' AND day=$eday");
						$check=mysql_fetch_array($select_record2);
						$lapply1=0;
						if($check){
							$lapply1=$check['l_apply'];
							if(!$lapply1){
								if(($postTest=='0' || $postTest=='off') && !$apply1){
								$staff_id=$queryfetch['driver_id'];
								$staff_name=$queryfetch['fname']." ".$queryfetch['lname'];
									//echo "test";
									$query=mysql_query("select lt_name from leavetype where lt_id='$ltid' ");
										$lv_display=mysql_fetch_array($query);
										$l_type_name=$lv_display["lt_name"];
									$date1=$date_day."-".$date_month."-".$date_year;
									$date2=$date_year."-".$date_month."-".$date_day;
									
									$query=mysql_query("insert into staff_leave(d_id,staff_id,staff_name,l_type,l_type_name,a_date,f_date,t_date,l_total,l_des,h_type,day,month,year,f_day,f_month,f_year,t_day,t_month,t_year,status,from_date,to_date)values('$d_id','$staff_id','$staff_name','$ltid','$l_type_name','$date1','$date1','$date1','1','$reason','$resulthalf','$date_day','$date_month','$date_year','$date_day','$date_month','$date_year','$date_day','$date_month','$date_year','1','$date2','$date2')");
									$lapply1=mysql_insert_id();
								}
						$sql=mysql_query("UPDATE sattendance SET result='$postTest',lt_id='$ltid',reason='$reason',result_half='$resulthalf',l_apply='$lapply1' WHERE d_id='$d_id' AND m_id='$mid' AND day=$eday");
							}
						}else{
							if(($postTest=='0' || $postTest=='off') && !$apply1){
								$staff_id=$queryfetch['others_id'];
								$staff_name=$queryfetch['fname']." ".$queryfetch['lname'];
									//echo "test";
									$query=mysql_query("select lt_name from leavetype where lt_id='$ltid' ");
										$lv_display=mysql_fetch_array($query);
										$l_type_name=$lv_display["lt_name"];
									$date1=$date_day."-".$date_month."-".$date_year;
									$date2=$date_year."-".$date_month."-".$date_day;
									
									$query=mysql_query("insert into staff_leave(o_id,staff_id,staff_name,l_type,l_type_name,a_date,f_date,t_date,l_total,l_des,h_type,day,month,year,f_day,f_month,f_year,t_day,t_month,t_year,status,from_date,to_date)values('$o_id','$staff_id','$staff_name','$ltid','$l_type_name','$date1','$date1','$date1','1','$reason','$resulthalf','$date_day','$date_month','$date_year','$date_day','$date_month','$date_year','$date_day','$date_month','$date_year','1','$date2','$date2')");
									$lapply1=mysql_insert_id();
								}
							$sql=mysql_query("INSERT INTO `sattendance` (`day`,`month`,`year`,`result`,`m_id`,`d_id`,`lt_id`,`reason`,`ay_id`,`result_half`,`l_apply`) VALUES ('$date_day', '$date_month','$date_year', '$postTest','$mid','$d_id','$ltid','$reason','$acyear','$resulthalf','$lapply1')");
						}
					}
		if(!$sql)
{
die("Query Failed: ". mysql_error());
}
else
{
 header("Location:datt_edit.php?mid=$mid&eday=$eday&msg=succ");
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
							$eday=$_GET['eday'];
							
							$syear=$ay['s_year'];
							$eyear1=$ay['e_year'];
							
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
				<li class="no-hover"><a href="datt_mng.php?mid=<?php echo $mid;?>" title="Result Management">Staff Attendance managemrnt</a></li>
                <li class="no-hover">Edit Staff Attendance</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Driver Attendance <b>( <?php echo $month['m_name'];?> )</b></h1>                
			<a href="datt_mng.php?mid=<?php echo $mid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Attendance Details Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Driver Attendance <b>( <?php echo $month['m_name'];?> )</b></h1><span></span>
					</div>
                    <?php 
					$editatt=mysql_query("SELECT * FROM sattendance WHERE m_id=$mid AND day=$eday LIMIT 1"); 
								  $editdate=mysql_fetch_array($editatt);
								  $emonth=$editdate['month'];
								  $eyear=$editdate['year'];	
								  							  
								  
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_25">
							<p>
                                <label for="textfield">Select Date: <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $eday."/".$mno."/".$year;?>"  disabled/>
                                <input type="hidden" name="date" value="<?php echo $eday."/".$mno."/".$year;?>" />
                            </p>
						</div>
                         <div class="_100">
                         <p>
                         <label for="textfield">Fill Driver Attendance: </label>
                        <table class="table">
                  	<thead>
                    	<th><center>S.No</center></th>
                    	<th><center>Driver ID</center></th>
                        <th><center>Driver Name</center></th>
                        <th><center>Present</center></th>
                        <th><center>Absent - FullDay</center></th>
                        <th><center>Absent - OffDay </center></th>
                        <th><center>Leave Type</center></th>
                        <th><center>Reason </center></th>
                       </thead>
                    </thead>
                    <tbody>
                    	<?php 
						 $att=1;						 
					$select_record=mysql_query("SELECT * FROM driver WHERE status='1'");
					while($student12=mysql_fetch_array($select_record))
					{ 
					//$id=$queryfetch['admission_number'];
					$did=$student12['d_id'];?>
                        <tr>
                        <td><center><?php echo $att;?></center></td>
                        <td><center><?php echo $student12['driver_id']?></center></td>
                        <td><center><?php echo $student12['fname']." ".$student12['mname']." ".$student12['lname']; ?></center></td>
                        <?php //echo $ssid ." / ".$mid." / ".$eday;
						 $dayatt1=mysql_query("SELECT * FROM sattendance WHERE m_id=$mid AND day=$eday AND d_id=$did"); 
								  $attday=mysql_fetch_array($dayatt1);
								  $result=$attday['result'];
								  $result_half=$attday['result_half'];
								  $lapply=$attday['l_apply'];
								  ?>
                        <td><center><input type="radio" id="name"  name="<?php echo $student12['d_id']?>" class="text err" value="1" <?php if($result=='1'){ echo 'checked="checked"';}if($lapply){ echo " disabled";}?>/></center></td>
                        <td><center><input type="radio" id="name" name="<?php echo $student12['d_id']?>" class="text err" value="0" <?php if($result=='0'){ echo 'checked="checked"';}if($lapply){ echo " disabled";}?> /></center></td>
                        <td><input type="radio" id="name" name="<?php echo $student12['d_id']?>" class="text err" value="off-M" <?php if($result=='off' && $result_half=="M"){ echo 'checked="checked"';}if($lapply){ echo " disabled";}?> />Morning<br>
                        <input type="radio" id="name" name="<?php echo $student12['d_id']?>" class="text err" value="off-E" <?php if($result=='off' && $result_half=="E"){ echo 'checked="checked"';}if($lapply){ echo " disabled";}?> />Afternoon</td>
                        <td><?php
											$ltid1=$attday['lt_id'];
                                            $classl = "SELECT * FROM leavetype";
											$staffid=$student12['driver_id'];
                                            $result1 = mysql_query($classl) or die(mysql_error()); ?>
                                            <select name="ltid<?php echo $student12['d_id']?>" id="ltid" <?php if($lapply){ echo " disabled";}?>> 
                                            <option value="">Select Leave Type</option>
											<?php while ($row1 = mysql_fetch_assoc($result1)):
													if($ltid1==$row1['lt_id']){
                                                echo "<option value='{$row1['lt_id']}' selected>{$row1['lt_name']}</option>\n";
													}else{
												echo "<option value='{$row1['lt_id']}'>{$row1['lt_name']}</option>\n";
													}
                                            endwhile;
                                            echo '</select>';
                                            ?></td>
                        <td><center><input type="text" id="reason" name="reason<?php echo $student12['d_id']?>" class="text err" value="<?php echo $attday['reason']?>" /></center></td>
                        </tr>
                     <?php $att++; } ?>
                        <input type="hidden" name="mid" value="<?php echo $mid;?>" />
                        <input type="hidden" name="eday" value="<?php echo $eday;?>" />
                        <input type="hidden" name="att" value="<?php echo $att;?>" />                        
                    </tbody>
                  </table></p><br><br>	
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
		direction: ['<?php echo "01/".$mno."/".$year;?>', '<?php echo $numdays."/".$mno."/".$year;?>'],
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