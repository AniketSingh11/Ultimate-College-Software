<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 if (isset($_POST['timing-submit']))
{
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	$bid=$_POST['bid'];
	$eid=$_POST['eid'];
	
	$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
	$class=mysql_fetch_array($classlist);
	
	$classname=$class['c_name'];
											if(($cname == 'XI STD') || ($cname == 'XII STD') || ($cname == 'XI') || ($cname == 'XII')){ 
												$qry11=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear AND extra_sub=0");
											}else{
												$qry11=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear AND extra_sub=0");
											}
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{
					$date=date.$count;
					$date=$_POST[$date];
					$day=day.$count;
					 $day=$_POST[$day];
					$ftime=ftime.$count;
					 $ftime=$_POST[$ftime];
					$ttime=ttime.$count;
					 $ttime=$_POST[$ttime];
					$slid=slid.$count;
					 $slid=$_POST[$slid];
					 $ettid=ettid.$count;
					$ettid=$_POST[$ettid];
					if($ettid){
						$sql=mysql_query("UPDATE examtimetable SET date='$date',day='$day',sub_id='$slid',ftime='$ftime',ttime='$ttime' WHERE ett_id='$ettid'");
					}else{
						$sql=mysql_query("INSERT INTO examtimetable (date,day,sub_id,ftime,ttime,c_id,s_id,e_id,b_id,ay_id) VALUES
('$date','$day','$slid','$ftime','$ttime','$cid','$sid','$eid','$bid','$acyear')");						
					}
						$count++;
				}
				header("Location:examtimetable_assign.php?cid=$cid&sid=$sid&eid=$eid&bid=$bid&msg=succ");	
}
 ?>
</head>
<body>
<?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
  	<div id="main" role="main">
    	<div class="shadow-bottom shadow-titlebar"></div>
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
				if($cid && $sid && $eid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  $examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							 	  //echo $class['c_name']."-".$section['s_name'];
								  $classname=$class['c_name'];
								  ?>
			<div class="grid_12">
				<?php $msg=$_GET['msg'];
				if($msg=="succ"){?>
                <div class="alert success"><span class="hide" onClick="window.location='http://localhost/sms/examtimetable_assign.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>';">x</span>Your Record Successfully Edited !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $exam['e_name'];?> - Exam TimeTable For <?php echo $class['c_name']; if( ($classname == 'XI STD') || ($classname == 'XII STD') || ($classname == 'XI') || ($classname == 'XII')){ 
						echo "-".$section['s_name']; }?></h1>                        
                        <span></span>
					</div>
                    <div class="block-content">
                     <form id="validate-form" class="block-content form" action="" method="post" action="">
                    	<table id="table-example" class="table" align="center">
							<thead>
								<tr>
									<th width="25px"><center>S.No</center></th>
                                    <th width="150px;"><center>Date (DD/MM/YYYY)</center></th>
                                    <th width="13%;"><center>Day</center></th>
                                    <th><center>Timing</center></th>
                                    <th width="30%;"><center>Subject Name</center></th>                                    
								</tr>
							</thead>
							<tbody>
								<?php 
							
if(($classname == 'XI STD') || ($classname == 'XII STD') || ($classname == 'XI') || ($classname == 'XII') ){ 
												$qry11=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear  AND extra_sub=0");
											}else{
												$qry11=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear  AND extra_sub=0");
											}
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{	
							$slid=$row11['sl_id'];
							if(($classname == 'XI STD') || ($classname == 'XII STD') || ($classname == 'XI') || ($classname == 'XII')){
							$qry=mysql_query("SELECT * FROM examtimetable WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$slid AND b_id=$bid AND ay_id=$acyear");
							}else{
								$qry=mysql_query("SELECT * FROM examtimetable WHERE c_id=$cid AND e_id=$eid AND sub_id=$slid AND b_id=$bid AND ay_id=$acyear");
							}
			  $row=mysql_fetch_array($qry);
			  if($row['ett_id']){        		
						?>
                        <input type="hidden" class="medium" name="ettid<?php echo $count; ?>" value="<?php echo $row['ett_id'];?>" >
                        <?php } ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><input id="datepicker<?php echo $count; ?>" name="date<?php echo $count; ?>" class="required" type="text" value="<?php echo $row['date']; ?>" /></center></td>
                                <?php 
				$maritalarray=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"); 
				?>	
                                <td><center><select name="day<?php echo $count; ?>" class="required">
                                <option value="">Select Day</option>
                                <?php
				for ($cmarital = 1; $cmarital <= 6; $cmarital++) { 
				if($row['day']==$maritalarray[$cmarital-1]){?>
                                				<option value='<?php echo $maritalarray[$cmarital-1]; ?>' selected><?php echo $maritalarray[$cmarital-1]; ?></option> 
                                                 <?php }else { ?>
                                	            <option value='<?php echo $maritalarray[$cmarital-1]; ?>'><?php echo $maritalarray[$cmarital-1]; ?></option> 
                                                <?php } }?>
								</select></center></td>
                                <td><center><input style="width:40%" id="ft<?php echo $count; ?>" class="required" value="<?php echo $row['ftime']; ?>" data-format="hh:mm A" class="input-small" type="text" name="ftime<?php echo $count; ?>"> to <input id="tt<?php echo $count; ?>" class="required" style="width:40%" value="<?php echo $row['ttime']; ?>" data-format="hh:mm A" class="input-small"  type="text" name="ttime<?php echo $count; ?>"></center></td>
                                <td><center>
                                	<?php
                                            $cname=$class['c_name'];
												if(($cname == 'XI STD') || ($cname == 'XII STD') || ($cname == 'XI') || ($cname == 'XII')){ 
												$qry1=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear  AND extra_sub=0");
											}else{
												$qry1=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear  AND extra_sub=0");
											}?>
                                            <select name="slid<?php echo $count; ?>" id="slid<?php echo $count; ?>" class="required"> 
											<option value="">Select Subject</option>
                                            <?php
											while ($row2 = mysql_fetch_array($qry1)): 
											if($row['sub_id']==$row2['sl_id']){
											?>
                                                <option value='<?php echo $row2['sl_id'];?>' selected><?php echo $row2['s_name'];?></option>
                         <?php              }else{?>
                         <option value='<?php echo $row2['sl_id'];?>'><?php echo $row2['s_name'];?></option>                         
                         <?php }
                         					endwhile;
                                            echo '</select>';
                                            ?>
								</select></center></td>
                                
                                </tr> 
                                 <?php 
							$count++;
							} ?>                                                                						
							</tbody>
						</table> 
                        <div class="clear"></div>
                         <div align="center" style="padding:5px 0;">
                         <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            <input type="hidden" class="medium" name="eid" value="<?php echo $_GET['eid'];?>" >
                            
                <input type="submit" value="Submit" name="timing-submit" class="btn btn-green" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="Reset" class="btn btn-blue" onClick="location.reload()" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="Close Window" class="btn  btn-red" onclick="window.close()" style="width:100px">   </div> 
                     </form>                     
					</div>
				</div>
            </div>
            <div class="clear height-fix"></div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <!--<script defer src="js/mylibs/jquery.uniform.min.js"></script>  Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
   <script defer src="js/zebra_datepicker.js"></script>
   <link rel="stylesheet" type="text/css" href="src/jquery.ptTimeSelect.css" />
<script type="text/javascript" src="src/jquery.ptTimeSelect.js"></script>
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		<?php 
		if(($cname == 'XI STD') || ($cname == 'XII STD') || ($cname == 'XI') || ($cname == 'XII')){ 
												$qry11=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear AND extra_sub=0");
											}else{
												$qry11=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear  AND extra_sub=0");
											}
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{ 	?>
		$( "#datepicker<?php echo $count;?>" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	$('#ft<?php echo $count;?>').ptTimeSelect();
	$('#tt<?php echo $count;?>').ptTimeSelect();
	<?php $count++; } ?>
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
</body>
</html>
<? ob_flush(); ?>