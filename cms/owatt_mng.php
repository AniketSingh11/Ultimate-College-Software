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
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover">Other Staff Attendance Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
                                	if(isset($_GET['cid']))
                                	{                                	     
                                	    $cid=$_GET['cid'];
                                	}else{
										$cid="all";
									}
                                            ?>
			<?php
							//$eid=$_GET['eid'];
							$mid=$_GET['mid'];
							if($mid){
							$subjectlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($subjectlist);	  } ?>
				
		<div class="grid_12">
				<h1>Other Staff Attendance <b><?php if($mid){?>( <?php echo $month['m_name'];?> )<?php } ?></b></h1>
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
					if($mcount==1){?>
                 <a href="owatt_mng.php?mid=<?php echo $row1['m_id']; ?>&cid=<?php echo $cid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $row1['m_name']; ?></button></a>
                <?php }
				if($mno==$monthno && $row2['ay_id']==$acyear){
						$mcount=0;
					} }?>
                <br>
                <br>
                <?php if($mid){?>
                <a href="owatt_single.php?mid=<?php echo $mid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png"> Add Attendance</button></a>
                <a href="staffleavetype.php?mid=<?php echo $mid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-warning1 btn-small "><img src="img/icons/packs/fugue/16x16/lifebuoy--plus.png"> Employee Leave Types</button></a>
                <div class="_25" style="float:right">
                <label for="select">Category :</label>
                                	       <select name="cid" id="cid" class="required" onchange="change_function1()">
                                            <option value="all">All</option>
                                        <?php 
                                            $classl = "SELECT * FROM others_category";
                                            $result1 = mysql_query($classl) or die(mysql_error());
											while ($row1 = mysql_fetch_assoc($result1)){
											?>
												
                                               <option value='<?=$row1['oc_id']?>'<?php if($cid==$row1['oc_id']){?> selected<?php }?>><?=$row1['category_name']?></option>
                                               <?php }?>
											</select>
                              </div>
                              <span style="margin:0px 10px 0 0px; float:right;"><img src="./img/tick.png"> Present &nbsp; | &nbsp;<img src="./img/close.png"> Absent </strong> &nbsp; | &nbsp;<img src="./img/off-m.png"> Morning Absent &nbsp; | &nbsp;<img src="./img/off-e.png"> Afternoon Absent </span> 
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Attendance Detail Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($mid){
				$qry1=mysql_query("SELECT distinct day FROM sattendance WHERE m_id=$mid AND ay_id=$acyear AND o_id ORDER BY day");
				 $num_rows = mysql_num_rows($qry1);
				?>
            <div class="grid_12" style=" <?php if($num_rows >=14 && $num_rows <20){ echo "width:1100px;"; } else if($num_rows >=20){ echo "width:1200px;"; }?>">
            	<div class="block-border">
					<div class="block-header">
                    	<h1>Staff Attendance <b><?php if($mid){?>(<?php echo $month['m_name'];?>)<?php } ?></b></h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Staff ID</th>
                                    <th><center>Staff Name</center></th>
                                    <?php 
						$select_record2=mysql_query("SELECT distinct day FROM sattendance WHERE m_id=$mid AND ay_id=$acyear AND o_id ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{ 
						?>
                        <th><center> <?php echo $monthday['day'];?> </center></th>
                        <?php } ?>
								</tr>
							</thead>
							<tbody>                    			
                            <?php 							
							if(isset($_GET['cid']) && $cid!="all")
                            {
							$qry=mysql_query("SELECT * FROM others where category_id='$cid' order by fname asc");
                            }else{                                
                                $qry=mysql_query("SELECT * FROM others WHERE status='1' order by fname asc");
                            }
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$oid=$row['o_id'];
							/*$qry=mysql_query("SELECT distinct st_id FROM sattendance WHERE m_id=$mid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$stid=$row['st_id'];
								   $studentlist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								   $staff=mysql_fetch_array($studentlist);	*/
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['others_id']; ?></center></td>
                                <td><center><?php echo $row['fname']."  ".$row['lname']; ?></center></td>
                                <?php 
						$select_record2=mysql_query("SELECT distinct day FROM sattendance WHERE m_id=$mid AND ay_id=$acyear AND o_id ORDER BY day");
						$count1=1;
					while($monthday=mysql_fetch_array($select_record2))
					{ 
						$day=$monthday['day'];
						$select_re=mysql_query("SELECT * FROM sattendance WHERE o_id=$oid AND m_id=$mid AND day=$day AND ay_id=$acyear ORDER BY day");
						$attend=mysql_fetch_array($select_re);
						$result=$attend['result'];
						$result_half=$attend['result_half'];
						?>
                                <?php if($result=='1'){?>
                                <td style="background:#66DD6C;border:1px solid #000000"><center><img src="./img/tick.png" alt="present" title="Present"></center></td>
								<?php }else if($result=='0'){?>
								<td style="background:#FC6366; border:1px solid #000000"><center><a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count."".$count1;?>').dialog({ modal: true });"><img src="./img/close.png" alt="absent" title="Absent"></a></center></td>
                                <!-- Info-Button -->
			<!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count."".$count1;?>" title="Employee Leave Detail" style="display: none;">
				<p><b>Employee Leave Type </b>: &quot;<?php 
				$ltid=$attend['lt_id'];
				$leavetypelist=mysql_query("SELECT * FROM leavetype WHERE lt_id='$ltid'");
				$leavetype=mysql_fetch_array($leavetypelist);
echo $leavetype['lt_name'];?>&quot;</p>
                <p><b>Reason  </b>: <?php echo $attend['reason'];?></p>				
			</div> <!--! end of #info-dialog -->
                                <?php }else if($result=='off'){?>
                                <td style="background:#FF0004;border:1px solid #000000"><center><a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count."".$count1;?>').dialog({ modal: true });"><?php if($result_half=="M"){?><img src="./img/off-m.png" alt="Morning absent" title="Morning Absent"><?php }else if($result_half=="E"){?><img src="./img/off-e.png" alt="Afternoon absent" title="Afternoon Absent"><?php }?></a></center></td>
                                <!-- Info-Button -->
			<!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count."".$count1;?>" title="Employee Leave Detail" style="display: none;">
            <p><?php if($result_half=="M"){?><img src="./img/off-m.png" alt="Morning absent" title="Morning Absent"> Morning Absent<?php }else if($result_half=="E"){?><img src="./img/off-e.png" alt="Afternoon absent" title="Afternoon Absent"> Afternoon Absent<?php }?></p>
				<p><b>Employee Leave Type </b>: &quot;<?php 
				$ltid=$attend['lt_id'];
				$leavetypelist=mysql_query("SELECT * FROM leavetype WHERE lt_id='$ltid'");
				$leavetype=mysql_fetch_array($leavetypelist);
echo $leavetype['lt_name'];?>&quot;</p>
                <p><b>Reason  </b>: <?php echo $attend['reason'];?></p>				
			</div> <!--! end of #info-dialog -->
								<?php } else {?>
                                <td style="background:#B3B3B3;border:1px solid #000000"><center> - </center></td>
								<?php } ?>
                                <?php $count1++; } ?>
								</tr> 
                                 <?php 
							$count++;
							} ?>     
                           <?php if($count!=1){?> 
                            <tr class="gradeX">
                            		<td></td>
                                    <td></td>
                    				<td><center><strong>Action</strong> <img src="img/icons/packs/fugue/16x16/arrow-skip.png"></center></td>
                                    <?php 
						$select_recor=mysql_query("SELECT distinct day FROM sattendance WHERE m_id=$mid AND ay_id=$acyear AND o_id ORDER BY day");
					while($monthday1=mysql_fetch_array($select_recor))
					{  
					$emonth=$$monthday1['month'];
					$eday=$monthday1['day'];
					$eyear=$monthday1['year'];
						?>
                        <td><center><a href="owatt_edit.php?mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&cid=<?php echo $cid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> 
                        <a href="owatt_delete.php?mid=<?php echo $mid;?>&eday=<?php echo $eday;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></center>
                        </td>
                        <?php } ?>
								</tr>  <?php } ?>                        																
							</tbody>
						</table>
					</div>
				</div>
            </div> <?php } else { ?>
            <center><h3 class="succ"> Please Select Month </h3></center> <?php } ?>
            <div class="clear height-fix"></div>
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
			validateform.resetForm();
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	function change_function1(){ 		
	    var bid=document.getElementById('cid').value;
		 window.location.href = 'owatt_mng.php?cid='+bid+'&mid='+<?php echo $mid;?>;		 	  
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