<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
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
		$bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $rid=$_GET['rid'];
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="#" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Student Vehicle Attendance</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
                 <div class="_25" style="float:right">
                <label for="select">Route Master :</label>
                                	<?php
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid" class="required" onchange="change_function1()">
											<option value="">Select Route Master</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($rid ==$row1['r_id']){
                                                echo "<option value='{$row1['r_id']}' selected>{$row1['r_name']}</option>\n";
												} else {
                                                echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
                 </div>
            <?php
							$mid=$_GET['mid'];
							
							
				
					if($rid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  
								  if(!$mid){
								  $monthno=date("m");
				 			$monthqry1=mysql_query("SELECT * FROM month WHERE m_no=$monthno AND ay_id=$acyear");
							$monthqrylist=mysql_fetch_array($monthqry1);	
										$mid=$monthqrylist['m_id'];
								  }
							
							if($mid){
							$subjectlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($subjectlist);	  }
								  
								  $classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $class=mysql_fetch_array($classlist);
								  $vid=$class['v_id'];
							$did=$class['d_id'];
							$sdid=$class['sd_id'];
								$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid"); 
								$vehicle=mysql_fetch_array($vehiclelist);
								$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								$driver=mysql_fetch_array($driverlist);
								$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid"); 
								$driver1=mysql_fetch_array($driverlist1);
								
								 $myarray = array();
								  $qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($row=mysql_fetch_array($qry))
									{
										array_push($myarray,$row['stop_id']);										
									}
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
		<div class="grid_12">
				<h1><?php echo $class['r_name'];?> - Student Attendence <b><?php if($mid){?>( <?php echo $month['m_name'];?> )<?php } ?></b></h1>
                
                 <?php 
				 $qry2=mysql_query("SELECT * FROM year ORDER BY ay_id DESC LIMIT 1");
				$row2=mysql_fetch_array($qry2);
				
				$monthno=date("m");
				 			$qry1=mysql_query("SELECT * FROM month WHERE ay_id=$acyear");
							$mcount=1;
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$mno=$row1['m_no'];
					$lmid=$row1['m_id'];
					$btn="btn btn-small btn-error";
					if($mcount==1){
						if($mid==$row1['m_id']){
							$btn="btn btn-small btn-success";
						}
						?>
                 <a href="bus_att_mng.php?rid=<?php echo $rid;?>&mid=<?php echo $row1['m_id']; ?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="<?=$btn?>" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $row1['m_name']; ?></button></a>
                <?php }
				if($mno==$monthno && $row2['ay_id']==$acyear){
						$mcount=0;
					} }
					if(!$mid){
						$mid=$lmid;
					}?>
                <br>
                <br>
                <?php if($mid){?>
                <a href="bus_att_single.php?rid=<?php echo $rid;?>&mid=<?php echo $mid;?>&bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">Add Attendance</button></a>
                <span style="margin:0px 10px 0 0px; float:right;"><img src="./img/tick.png"> Present &nbsp; | &nbsp;<img src="./img/close.png"> Absent </strong>  
                <?php }?>                   
			</div>
            <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Attendance Detail Successfully Deleted !!!</div>
                 <?php } if($mid){
				
				$qry1=mysql_query("SELECT distinct day FROM attendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
				 $num_rows = mysql_num_rows($qry1);
				?>
            <div class="grid_12" style=" <?php if($num_rows >=14 && $num_rows <20){ echo "width:1100px;"; } else if($num_rows >=20){ echo "width:1200px;"; }?>">
				<div class="block-border" id="tab-panel-1">
					<div class="block-header">
                    	<h1><?php echo $class['r_name'];?> - Student Attendance <b><?php if($mid){?>(<?php echo $month['m_name'];?>)<?php } ?></b></h1>                        <ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">Morning</a></li>
							<li><a href="#tab-2">Evening</a></li>
						</ul>
                        <span></span>
					</div>
					<div class="block-content">
                    <div id="tab-1" class="tab-content">
							<br>
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th><center>Class-Section( Board )</center></th>
                                    <th><center>Stop Name</center></th>
                                    <?php 
						$select_record2=mysql_query("SELECT distinct day FROM battendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{	?>
                        <th><center> <?php echo $monthday['day'];?> </center></th>
                        <?php } ?>
								</tr>
							</thead>
							<tbody>                    			
                            <?php 
							//$qry=mysql_query("SELECT distinct ss_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear");
							$qry=mysql_query("SELECT ss_id,c_id,s_id,b_id,sp_id,busfeestype,admission_number,firstname,lastname FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$ssid=$row['ss_id'];
						$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  
								  $bid=$row['b_id'];
								$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								    
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];	
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['lastname']; ?></center></td>
                                <td><center><?php echo $class['c_name']." / ".$section['s_name']." ( ".$board['b_name']." )"; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <?php 
						$select_record2=mysql_query("SELECT distinct day FROM battendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{ 
						$day=$monthday['day'];
						$select_re=mysql_query("SELECT * FROM battendance WHERE sp_id IN (".implode(',',$myarray).") AND m_id=$mid AND ss_id=$ssid AND day=$day AND ay_id=$acyear ORDER BY day");
						$attend=mysql_fetch_array($select_re);
					
						$mresult=$attend['mresult'];
						?>
                                <?php if($mresult=='1'){?>
                                <td style="background:#66DD6C;border:1px solid #000000"><center><img src="./img/tick.png" alt="present" title="Present"></center></td>
								<?php }else if($mresult=='0'){?>
								<td style="background:#FC6366; border:1px solid #000000"><center><img src="./img/close.png" alt="absent" title="Absent"></center></td>
                                <?php } else {?>
                                <td style="background:#B3B3B3;border:1px solid #000000"><center> - </center></td>
								<?php } 
									 }
						 ?>
								</tr> 
                                 <?php 
							$count++;
							} ?>     
                            <?php if($count!=1){?> 
                            <tr class="gradeX">
                            		<td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                    				<td><center><strong>Action</strong> <img src="img/icons/packs/fugue/16x16/arrow-skip.png"></center></td>
                                    <?php 
						$select_recor=mysql_query("SELECT distinct day FROM battendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday1=mysql_fetch_array($select_recor))
					{  
					$emonth=$$monthday1['month'];
					$eday=$monthday1['day'];
					$eyear=$monthday1['year'];
						?>
                        <td><center><a href="bus_att_edit.php?rid=<?php echo $rid;?>&mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> 
                        <a href="bus_att_delete.php?rid=<?php echo $rid;?>&mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></center>
                        </td>
                        <?php } ?>
								</tr> 
                                <?php } ?>                         																
							</tbody>
						</table>
                        </div>
                        <div id="tab-2" class="tab-content">
							<br>
                            <table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th><center>Class-Section( Board )</center></th>
                                    <th><center>Stop Name</center></th>
                                    <?php 
						$select_record2=mysql_query("SELECT distinct day FROM battendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{	?>
                        <th><center> <?php echo $monthday['day'];?> </center></th>
                        <?php } ?>
								</tr>
							</thead>
							<tbody>                    			
                            <?php 
							//$qry=mysql_query("SELECT distinct ss_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear");
							$qry=mysql_query("SELECT ss_id,c_id,s_id,b_id,sp_id,busfeestype,admission_number,firstname,lastname FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$ssid=$row['ss_id'];
						$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  
								  $bid=$row['b_id'];
								$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								    
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];	
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['lastname']; ?></center></td>
                                <td><center><?php echo $class['c_name']." / ".$section['s_name']." ( ".$board['b_name']." )"; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <?php 
						$select_record2=mysql_query("SELECT distinct day FROM battendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{ 
						$day=$monthday['day'];
						$select_re=mysql_query("SELECT * FROM battendance WHERE sp_id IN (".implode(',',$myarray).") AND m_id=$mid AND ss_id=$ssid AND day=$day AND ay_id=$acyear ORDER BY day");
						$attend=mysql_fetch_array($select_re);
					
						$eresult=$attend['eresult'];
						?>
                                <?php if($eresult=='1'){?>
                                <td style="background:#66DD6C;border:1px solid #000000"><center><img src="./img/tick.png" alt="present" title="Present"></center></td>
								<?php }else if($eresult=='0'){?>
								<td style="background:#FC6366; border:1px solid #000000"><center><img src="./img/close.png" alt="absent" title="Absent"></center></td>
                                <?php } else {?>
                                <td style="background:#B3B3B3;border:1px solid #000000"><center> - </center></td>
								<?php } 
									 }
						 ?>
								</tr> 
                                 <?php 
							$count++;
							} ?>     
                            <?php if($count!=1){?> 
                            <tr class="gradeX">
                            		<td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                    				<td><center><strong>Action</strong> <img src="img/icons/packs/fugue/16x16/arrow-skip.png"></center></td>
                                    <?php 
						$select_recor=mysql_query("SELECT distinct day FROM battendance WHERE r_id=$rid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday1=mysql_fetch_array($select_recor))
					{  
					$emonth=$$monthday1['month'];
					$eday=$monthday1['day'];
					$eyear=$monthday1['year'];
						?>
                        <td><center><a href="bus_att_edit1.php?rid=<?php echo $rid;?>&mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> 
                        <a href="bus_att_delete1.php?rid=<?php echo $rid;?>&mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></center>
                        </td>
                        <?php } ?>
								</tr> 
                                <?php } ?>                         																
							</tbody>
						</table>
                        </div>
					</div>
				</div>
            </div> <?php } else {?>
            <center><h3 class="succ"> Please Select Month </h3></center> <?php } ?>
            <div class="clear height-fix"></div>
<?php }else{ ?>
<div class="grid_12">
<div class="alert error"><span class="hide">x</span>Please Select Route Master !!!</div>
</div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable({
  'iDisplayLength': 50
});
$('#table-example1').dataTable({
  'iDisplayLength': 50
});
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});	
		$("#tab-panel-1").createTabs();	
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'bus_att_mng.php?bid='+cid+'<?php echo "&rid=".$rid;?>';	  
	} 
	function change_function1() { 
     var rid =document.getElementById('rid').value;
	 window.location.href = 'bus_att_mng.php?rid='+rid+'<?php echo "&bid=".$bid."&mid=".$mid;?>';	  
	} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
<?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>