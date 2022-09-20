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
    <?php $bid=$_GET['bid'];
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
                <li class="no-hover"><a href="#" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"> Roll of Student</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
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
				<h1> Roll of Student</h1>
			</div>
            <a href="roll_of_student_prt.php" style="margin:3px 0 0 20px;" target="_blank"><button class="btn btn-small btn-success"><img src="img/icons/packs/fugue/16x16/printer--pencil.png"> Print </button></a>
            <?php
			$student1=mysql_query("SELECT ss_id FROM student WHERE ay_id=$acyear AND gender='M' AND user_status=1");
						$tboys=mysql_num_rows($student1);
			$student2=mysql_query("SELECT ss_id FROM student WHERE ay_id=$acyear AND gender='F' AND user_status=1");
						$tgirls=mysql_num_rows($student2);
						?>
            <center>
                  <span style="margin:0px 50px 0 0px;"><img src="img/icons/packs/fugue/16x16/users.png"> Total Student : <strong> <?php echo $tboys+$tgirls;?></strong> </span>
				  <span style="margin:0px 50px 0 0px;"><img src="img/icons/packs/fugue/16x16/user-green.png"> Boys : <strong> <?php echo $tboys;?></strong> </span> 
                  <span style="margin:0px 50px 0 0px;"><img src="img/icons/packs/fugue/16x16/user-green-female.png"> Girls : <strong> <?php echo $tgirls;?></strong> </span> </center>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1> Roll of Student</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table" border="1">
							<thead>
								<tr>
									<th>S.No</th>
									<th><center>Class</center></th>
                                    <th><center>Boys</center></th>
                                    <th><center>Girls</center></th>
                                    <th><center>Total</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT c_id,c_name FROM class WHERE ay_id=$acyear AND b_id=$bid ORDER BY c_id");
							$count=1;
							$totalboys=0;
							$totalgirl=0;
							$total=0;							
			  while($row=mysql_fetch_array($qry))
        		{  
				$cid=$row['c_id'];
				
							$stotalboys=0;
							$stotalgirl=0;
							$subtotal=0;	
							
						$qry1=mysql_query("SELECT s_id,s_name FROM section WHERE c_id=$cid AND ay_id=$acyear");
					  while($row1=mysql_fetch_array($qry1))
						{ $sid=$row1['s_id']; 
						
						$student1=mysql_query("SELECT ss_id FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear AND gender='M' AND user_status=1");
						$boys=mysql_num_rows($student1);
						$student2=mysql_query("SELECT ss_id FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear AND gender='F' AND user_status=1");
						$girls=mysql_num_rows($student2);
							$stotal=$boys+$girls;
						?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
									<td><center><?php echo $row['c_name']."-".$row1['s_name']; ?></center></td>
								<td><center><?php echo $boys; ?></center></td>
								<td><center><?php echo $girls; ?></center></td>
								<td><center><?php echo $stotal; ?></center></td>
								</tr> 
                                 <?php 
								 $totalboys+=$boys;
							$totalgirl+=$girls;
							$total+=$stotal;
							
							$stotalboys+=$boys;
							$stotalgirl+=$girls;
							$subtotal+=$stotal;
							$count++;
							} ?>
                            <tr class="gradeX">
									<td class="sno center"></td>
									<td><span style="float:right; font-weight:bold"><?php echo $row['c_name']; ?></span></td>
								<td><center><b><?php echo $stotalboys; ?></center></td>
								<td><center><b><?php echo $stotalgirl; ?></center></td>
								<td><center><b><?php echo $subtotal; ?></center></td>
								</tr> 
                               <?php  } ?>  
                               <tr class="gradeX">
									<td class="sno center"></td>
									<td><span style="float:right; font-weight:bold">Grand Total</span></td>
								<td><center><b><?php echo $totalboys; ?></b></center></td>
								<td><center><b><?php echo $totalgirl; ?></b></center></td>
								<td><center><b><?php echo $total; ?></b></center></td>
								</tr>                              																
							</tbody>
						</table>
					</div>
				</div>
			</div>
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
	$('#table-example1').dataTable();
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
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
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
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'roll_of_student.php?bid='+cid;	  
	} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php  include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>