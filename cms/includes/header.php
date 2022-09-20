<div id="header-surround"><header id="header">
    	
    	<!-- Place your logo here -->
		<img src="img/logo_sms.png" alt="SMS" class="logo">
		
		<!-- Divider between info-button and the toolbar-icons -->
		<div class="divider-header divider-vertical"></div>
		
		<!-- Info-Button -->
		<a href="javascript:void(0);" onclick="$('#info-dialog').dialog({ modal: true });"><span class="btn-info"></span></a>
		
			<!-- Modal Box Content -->
			<div id="info-dialog" title="About" style="display: none;">
				<p>Hey there! Welcome to the <strong>&quot;School/College Management Solution&quot;</strong> admin Panel.</p>
                <p> I hope you enjoy your stay and please make sure, that you visit the other pages.</p>				
			</div> <!--! end of #info-dialog -->
		
		<!-- Begin from Toolbox -->
        <?php if($user=='Administrator' || $user=='Principal'){?>
		<ul class="toolbox-header">
        	<li>
				<a rel="tooltip" title="Academic Year : <?php echo $acyear_name;?>" class="toolbox-action" href="javascript:void(0);"><span class="i-24-star"></span></a>
				</li>
					 <li>
				<a href="javascript:void(0);" rel="tooltip" onclick="$('#info-dialog12345').dialog({ modal: true, width: 800,
	                height: 600 });" title="Expire Vehicle Details : <?php echo $acyear_name;?>" class="toolbox-action" ><span style="color: red;"><img src="img/icons/packs/fugue/24x24/information.png"></img> </span></a>
			 
			 
			</li> 
        </ul>
		<?php } ?>
		
			<?php 
		
			$format = 'Y-m-d';
			
			$date = date ($format);
			
			// - 7 days from today
			
			$v_date=date ( $format, strtotime ( '+30 day' . $date ));
			
			
			 
			$qry=mysql_query("SELECT * FROM vehicle where vin_enddate < '$v_date' or vfc_enddate < '$v_date' order by  vin_enddate,vfc_enddate ASC");
			$count=0;
			while($row=mysql_fetch_array($qry))
			{
			  $count=$count+1; 
			  
			  
			  
			 /* $date1=date_create($date);
			  $date2=date_create($row['vin_enddate']);
			  $diff=date_diff($date1,$date2);
			  */
			  
			  $startTimeStamp = strtotime($date);
			  $endTimeStamp = strtotime($row['vin_enddate']);
			  
			  $timeDiff = abs($endTimeStamp - $startTimeStamp);
			  
			  $numberDays = $timeDiff/86400;  // 86400 seconds in one day
			  
			  // and you might want to convert to integer
			  $numberDays = intval($numberDays);
			  
			  
			  
			  /*  $startTimeStamp = strtotime("2011/07/01");
$endTimeStamp = strtotime("2011/07/17");

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);
			   */
			  $startTimeStamp1 = strtotime($date);
			  $endTimeStamp1 = strtotime($row['vfc_enddate']);
			  	
			  $timeDiff1 = abs($endTimeStamp1 - $startTimeStamp1);
			  	
			  $numberDays1 = $timeDiff1/86400;  // 86400 seconds in one day
			  	
			  // and you might want to convert to integer
			  $numberDays1 = intval($numberDays1);
			  
			  
			  
			  if($count==1){
		 ?> <div id="info-dialog12345" title="Expire Vehicle  :  details" style="display: none; width:900px;">
		 
		 <?php }  
		 
		 if($row['vin_enddate'] < $date) {
		                                        ?>
		 
		  <div class="alert error" style="float: left;">Vehicle no1 <?php echo $row['v_no'];?> is Already Insurance  Expire on <?php echo date("d/m/Y",strtotime($row['vin_enddate'])); ?> ( <?=$numberDays?> days before) &nbsp;<span class="hide">X </span></div>
		 <?php } 
		 if($row['vfc_enddate'] < $date) {
		     ?>
		 		 
		 		  <div class="alert error" style="float: left;">Vehicle no <?php echo $row['v_no'];?> is Already Vehicle FC  Expire on <?php echo date("d/m/Y",strtotime($row['vfc_enddate'])); ?> ( <?=$numberDays1;?> days before) &nbsp;<span class="hide">X </span></div>
		 		 <?php } 
		  if($row['vin_enddate'] == $date){?>
		 		 
		 	      <div class="alert error" style="float: left;">Vehicle no <?php echo $row['v_no'];?> is Insurance  Expire on <?php echo date("d/m/Y",strtotime($row['vin_enddate'])); ?>  ( Today Expire) &nbsp;<span class="hide">X  </span></div>
		 		 
		 		 <?php } 
		 		 if($row['vfc_enddate'] == $date){?>
		 		 		 		 
		 		 		 	      <div class="alert error" style="float: left;">Vehicle no <?php echo $row['v_no'];?> is Vehicle FC  Expire on <?php echo date("d/m/Y",strtotime($row['vfc_enddate'])); ?>  ( Today Expire) &nbsp;<span class="hide">X  </span></div>
		 		 		 		 
		 		 		 		 <?php } 
		  if($row['vin_enddate'] < $v_date && $row['vin_enddate'] > $date){?>
		 		 
		 	      <div class="alert warning" style="float: left;">Vehicle no <?php echo $row['v_no'];?> is Insurance  Expire on <?php echo date("d/m/Y",strtotime($row['vin_enddate'])); ?>  ( <?=$numberDays?> days ago) &nbsp;<span class="hide">X  </span></div>
		 		 
		 		 <?php }
		 		 if($row['vfc_enddate'] < $v_date && $row['vfc_enddate'] > $date){?>
		 		 		 		 
		 		 		 	      <div class="alert warning" style="float: left;">Vehicle no <?php echo $row['v_no'];?> is Vehicle FC  Expire on <?php echo date("d/m/Y",strtotime($row['vfc_enddate'])); ?>  ( <?=$numberDays1;?> days ago) &nbsp;<span class="hide">X  </span></div>
		 		 		 		 
		 		 		 		 <?php }
		 		 ?>
		
		 
	 
               
                <?php  } ?> 
                
                
                <?php   if($count!=0){ ?>
		   </div>
		 
		 <?php } ?>
		
		
		<!-- Begin of #user-info -->
		<div id="user-info">
			<p>
				<span class="messages">Academic Year : <?php echo $acyear_name;?> | Hello <a href="javascript:void(0);"><?php echo $user;?></a><?php if($stid){ 		$select_rec2=mysql_query("SELECT * FROM feedback WHERE st_id=$stid AND ay_id=$acyear AND status='1' AND send='parent'");						
								$unread=0;
								$unread=mysql_num_rows($select_rec2);
					if($unread){?> ( <a href="sboard_select_stu_feed.php"><img src="img/icons/packs/fugue/16x16/mail.png" alt="Messages"> <?php echo $unread;?> new messages</a> ) <?php } } ?></span>
	<?php 	$log_type=$_SESSION['log_type'];
	         
	$qry=mysql_query("SELECT * FROM staff WHERE  st_id='$stid' and admin_permission='1'");
	$chk1=mysql_fetch_array($qry);
	
    	if($chk1['s_type']=="Teaching" && mysql_num_rows($qry)!=0){ ?><a href="dashboard.php" class="button">Admin Profile</a><a href="dashboard1.php" class="button">Staff Profile</a> <?php }?>
				<a href="<?php if($_SESSION['log_type']=="admin"){?>setting.php<?php } else { ?>ssetting.php<?php } ?>" class="button">Settings</a> <a href="logout.php" class="button red">Logout</a>
			</p>
		</div> <!--! end of #user-info -->
		
    </header></div>