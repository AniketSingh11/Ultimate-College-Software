<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
							 $cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$slid=$_GET['slid'];
							$bid=$_GET['bid'];
 if (isset($_POST['timing-submit']))
{
												$qry11=mysql_query("SELECT * FROM exam Where ay_id=$acyear");
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{
					$eid=$row11['e_id'];
					$date=date.$count;
					$date=$_POST[$date];
					$covered=covered.$count;
					  $covered=$_POST[$covered];
					 
					 $allid=allid.$count;
					 $allid=$_POST[$allid];
					 
					 if($allid){
						$sql=mysql_query("UPDATE syllabus_assign SET e_id='$eid',c_id='$cid',s_id='$sid',sl_id='$slid',b_id='$bid',date='$date',covered='$covered',ay_id='$acyear' WHERE id='$allid'");
					}else{
						echo $sql=mysql_query("INSERT INTO syllabus_assign (e_id,c_id,s_id,sl_id,b_id,date,covered,ay_id) VALUES
('$eid','$cid','$sid','$slid','$bid','$date','$covered','$acyear')");						
					}
						$count++;
				}
				//header("Location:syllabus_assign.php?cid=$cid&sid=$sid&eid=$eid&bid=$bid&msg=succ");	
				$msg="succ";
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
				if($cid && $sid && $slid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							if($cname == 'XI STD' || $cname == 'XII STD'){ 
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								  }
								  if($slid){
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist1=mysql_fetch_array($subjectlist1);
								   $paper=$slist1['paper'];
								   }
								  ?>
			<div class="grid_12">
				<?php //$msg=$_GET['msg'];
				if($msg=="succ"){?>
                <div class="alert success"><span class="hide" onClick="window.location='http://localhost/sms/syllabus_assign.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&slid=<?php echo $slid;?>&bid=<?php echo $bid;?>';">x</span>Your Record Successfully Edited !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']; if($cname == 'XI STD' || $cname == 'XII STD'){ echo "-".$section['s_name']; }?> Syllabus List <b><?php if($slid){?>( <?php echo $slist1['s_name'];?> )<?php } ?></b></h1>                        
                        <span></span>
					</div>
                    <div class="block-content">
                     <form id="validate-form" class="block-content form" action="" method="post" action="">
                    	<table id="table-example" class="table" align="center">
							<thead>
								<tr>
									<th width="10%"><center>S.No</center></th>
                                    <th width="25%;"><center>Exam Name</center></th>
                                    <th width="22%;"><center>due Date (DD/MM/YYYY)</center></th>
                                    <th><center>Syllabus to Covered</center></th>                                    
								</tr>
							</thead>
							<tbody>
								<?php 
												$qry11=mysql_query("SELECT * FROM exam Where ay_id=$acyear");
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{			
				$eid=$row11['e_id'];
							if(($classname == 'XI STD') || $classname == 'XII STD'){
							$qry=mysql_query("SELECT * FROM syllabus_assign WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sl_id=$slid AND b_id=$bid AND ay_id=$acyear");
							}else{
								$qry=mysql_query("SELECT * FROM syllabus_assign WHERE c_id=$cid AND e_id=$eid AND sl_id=$slid AND b_id=$bid AND ay_id=$acyear");
							}
			  $row=mysql_fetch_array($qry);
			  if($row['id']){        		
						?>
                        <input type="hidden" class="medium" name="allid<?php echo $count; ?>" value="<?php echo $row['id'];?>" >
                        <?php } ?>       		
								<tr class="gradeX" style="border-bottom:1px #ABABAB dotted;">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row11['e_name']; ?></center></td>
                                <td><center><input id="datepicker<?php echo $count; ?>" name="date<?php echo $count; ?>" class="required" type="text" value="<?php echo $row['date']; ?>" /></center></td>
                                <td><center><textarea name="covered<?php echo $count; ?>" rows="3" class="required"><?php echo $row['covered'];?></textarea></center></td>
                                </tr> 
                                 <?php 
							$count++;
							} ?>                                                                						
							</tbody>
						</table> 
                        <div class="clear"></div>
                         <div align="center" style="padding:5px 0;">
                            
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
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		<?php 
							
												$qry11=mysql_query("SELECT * FROM exam Where ay_id=$acyear");
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{	
							       		
						?>
		$( "#datepicker<?php echo $count;?>" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	<?php $count++;} ?>
		
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