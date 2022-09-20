<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/timetable_management.php");
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
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_staff_free.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Staff Free Periods</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_staff_free.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Staff Free Periods</h1><span></span>
					</div>
                    <div class="block-content">
                    <div class="akordeon" id="buttons">
                    <?php 
							$qry=mysql_query("SELECT * FROM timetable_timing WHERE c_id='0' AND b_id='0' AND ay_id=$acyear");
							$dttiming=mysql_fetch_array($qry);
							$ds_period=$dttiming['ds_period'];
			 for($i=0;$i<$ds_period;$i++){ 
				?>
            <div class="akordeon-item expanded">
                <div class="akordeon-item-head">
                    <div class="akordeon-item-head-container">
                        <div class="akordeon-heading">
                            <?php echo $i+1; ?> Period
                        </div>
                    </div>
                </div>
                <div class="akordeon-item-body">
                    <div class="akordeon-item-content">
                       <table id="table-example" class="table">
							<thead>
								<tr style="color:#212121;">
									<th>S.no</th>
									<th><center>Staff Names</center></th>
								</tr>
							</thead>
							<tbody style="color:#5A5959;">
                            <?php 
							$qry1=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
							$count=1;
			  while($day=mysql_fetch_array($qry1))
        		{
					$did=$day['d_id'];
			  ?>
								<tr class="gradeX" style="border-bottom:1px solid #B2B4B4;">
									<td class="sno center"><?php echo $day['d_name'];?></td>
									<td><center><?php 
									$staff=mysql_query("SELECT * FROM staff WHERE s_type='Teaching'");							
			  while($staflist=mysql_fetch_array($staff))
        		{
									$stid=$staflist['st_id'];
									$timelist=mysql_query("SELECT * FROM timetable WHERE d_id=$did AND b_id=$bid AND ay_id=$acyear");      					    				 						while($timetable=mysql_fetch_array($timelist))
							{
							$value=$i+1;
							$p="p".$value;
							$subid=$timetable[$p];
							$timeli=mysql_query("SELECT * FROM subject WHERE sub_id='$subid'"); 
									  $subject=mysql_fetch_array($timeli);
							$sub_stid=$subject['st_id'];
							$tid=$timetable['tt_id'];
							//echo "<br>".$stid."/".$sub_stid."/".$tid."/".$subid;
							if($stid == $sub_stid){
								break;
							}else{ 
							
							$timeli15=mysql_query("SELECT * FROM subject WHERE st_id='$stid' AND b_id=$bid AND ay_id=$acyear"); 
						while($subject15=mysql_fetch_array($timeli15))
						{
							$subid5=$subject15['sub_id'];
							$cid5=$subject15['c_id'];
							$sid5=$subject15['s_id'];
							$timelist5=mysql_query("SELECT * FROM timetable WHERE d_id=$did AND $p=$subid5 AND b_id=$bid AND ay_id=$acyear");      					    				 						$timetable5=mysql_fetch_array($timelist5);
							if($timetable5['tt_id']){
								$test=1;
							}
						
						}
							//echo $test;
							if(!$test){
							
							echo "<a href='javascript:void(0);' rel='tooltip-html' title='";
							$timeli1=mysql_query("SELECT * FROM subject WHERE st_id='$stid' AND b_id=$bid AND ay_id=$acyear"); 
						while($subject1=mysql_fetch_array($timeli1))
						{
							$cid=$subject1['c_id'];
							$sid=$subject1['s_id'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
							echo $class['c_name']." - ".$section['s_name']."&lt;br&gt;";
						}
							echo "'> <button rel='tooltip-html' class='btn btn-small btn-success'>".$staflist['fname']." ".$staflist['mname']." ".$staflist['lname']."</button></a> ";	
							break;
							} $test=0; }							
							}
				}
									 ?></center></td>
								</tr>
                     <?php  } ?> 
							</tbody>
						</table>
                    </div>
                </div>
            </div>
            <?php } ?>            
            
        </div>
                    </div>
				</div>
            </div>
            
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
  
  <link href="css/jquery.akordeon.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery.akordeon.js" type="text/javascript"></script>
  <script type="text/javascript">
	$(document).ready(function () {
            $('#buttons').akordeon();
            $('#button-less').akordeon({ buttons: false, toggle: true, itemsOrder: [2, 0, 1] });
        });
		function popup(url) 
{
 /*params  = 'width='+screen.width;
 params += ', height='+screen.height;
 params += ', top=0, left=0'
 params += ', fullscreen=no';

 newwin=window.open(url,'windowname4', params);
 if (window.focus) {newwin.focus()}
 return false;*/
 var width  = 1100;
 var height = 700;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=no';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'staff_free_periods.php?bid='+cid;	  
	} 
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