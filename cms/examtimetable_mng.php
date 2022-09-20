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
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_examtable.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Exam TimeTable Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		<?php 
		$eid=$_GET['eid'];
		if(!$eid){
			$boardlist1=mysql_query("SELECT * FROM exam"); 
								  $examw3=mysql_fetch_array($boardlist1);
		 $eid=$examw3['e_id'];
		}
		$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
								  ?>
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_examtable.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
            
            <form class="form" action="examtimetable_mng.php" method="get">
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <!--<div class="grid_6 alert success"><span class="hide">x</span>Your Board Successfully Deleted !!!</div>-->
                 <?php } ?> 
                <div class="form _25" style="float:right; margin-top:-25px;">
								<label for="select1">Exam Names</label>
								<select name="eid" onchange="this.form.submit();">
                                	<?php 
									$qry=mysql_query("SELECT * FROM exam WHERE ay_id=$acyear");
								  while($row=mysql_fetch_array($qry))
									{ if($eid==$row['e_id']){?>
                                    <option value="<?php echo $row['e_id']; ?>" selected><?php echo $row['e_name']; ?></option><?php } else { ?>
									<option value="<?php echo $row['e_id']; ?>"><?php echo $row['e_name']; ?></option>
									<?php } } ?>
								</select>
                                <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>">
                                
						</div>
                        </form>
            
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1><?php echo $exam['e_name'];?> - Exam TimeTable</h1><span></span>
					</div>
                    <div class="block-content">
                    <div class="akordeon" id="buttons">
                    <?php 
							$qry=mysql_query("SELECT * FROM class WHERE ay_id=$acyear AND b_id=$bid ORDER BY c_id");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$cid=$row['c_id'];
				?>
            <div class="akordeon-item expanded">
                <div class="akordeon-item-head">
                    <div class="akordeon-item-head-container">
                        <div class="akordeon-heading">
                            <?php echo $row['c_name']; ?>
                        </div>
                    </div>
                </div>
                <div class="akordeon-item-body">
                    <div class="akordeon-item-content">
                       <table id="table-example" class="table">
							<thead>
								<tr style="color:#212121;">
									<th>S.no</th>
									<th><center>Section/Group</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody style="color:#5A5959;">
                            <?php 
							$count=1;
                            $qry2=mysql_query("SELECT * FROM section WHERE c_id=$cid AND ay_id=$acyear");
							$count=1;
			  while($row2=mysql_fetch_array($qry2))
        		{ ?>
								<tr class="gradeX">
									<td class="sno center"><?php echo $count;?></td>
                                    <td><center><?php echo $row['c_name']." - ".$row2['s_name']; ?></center></td>
									<td class="action"><a href="javascript: void(0)"  onclick="popup('examtimetable_assign.php?sid=<?php echo $row2['s_id'];?>&cid=<?php echo $cid;?>&bid=<?php echo $bid;?>&eid=<?php echo $eid;?>')" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="examtimetable_prt.php?sid=<?php echo $row2['s_id'];?>&cid=<?php echo $cid;?>&bid=<?php echo $bid;?>&eid=<?php echo $eid;?>" target="_blank" class="delete" title="details"><img src="./img/detail.png" alt="delete"></a></td>
								</tr>
                     <?php $count++; } ?> 
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
	 window.location.href = 'examtimetable_mng.php?bid='+cid;	  
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