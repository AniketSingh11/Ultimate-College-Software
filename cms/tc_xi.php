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
        <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_tc11.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Transfer Certificate</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="grid_12">
				<h1>Transfer Certificate</h1>
                <a href="board_select_tc11.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                <a href="tc_xi_new.php?bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Import Transfer Certificate Datas</button></a>
                <a href="tc_xi_single.php?bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png"> Add Single</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
      <div class="_25" style="float:left">
                <label for="select">Payment :</label>
                <select name="status" onchange="redirect(this.value);" id="status">
                    <option value="All" <?php if($_GET['payment']=="All"){echo 'selected';}?>>All</option>
                    <option value="0" <?php if($_GET['payment']=="0"){echo 'selected';}?>>Paid</option>
                    <option value="1" <?php if($_GET['payment']=="1"){echo 'selected';}?>>Pending</option>
                </select>
                 </div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1> Transfer Certificate</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									<th>TC No</th>
                                    <th>EMIS No</th>
                                    <th>Admin No</th>
                                    <th>Academic Year</th>
                                    <th><center>Student Name</center></th>
                                    <th>Parent's name</th>
                                    <th>Gender</th>                                    
                                    <th>Date of Birth</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                if(isset($_GET['payment'])) {             
              if($_GET['payment']=='All'){
							   $qry=mysql_query("SELECT * FROM tc_xi WHERE ay_id=$acyear AND b_id=$bid order by tno desc");
              }
               else{
                $pay=$_GET['payment'];
                $qry=mysql_query("SELECT * FROM tc_xi WHERE ay_id=$acyear AND b_id=$bid and status='$pay' order by tno desc");
              }
            } else {
                $qry=mysql_query("SELECT * FROM tc_xi WHERE ay_id=$acyear AND b_id=$bid order by tno desc");
            } 

							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					
					$ssid=$row['ss_id'];
								  
								  $ss_id=$ssid;
								$student=mysql_fetch_array(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
								$ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
				
				?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['tno']; ?></center></td>
                                <td><center><?php echo $row['eno']; ?></center></td>
                                <td><center><?php echo $row['ano']; ?></center></td>
                                <td><center><?php echo $row['academic_year']; ?></center></td>
                                <td><center><?php echo $row['sname']; ?></center></td>
                                <td><center><?php echo $row['fname']; ?></center></td>
                                <td><center><?php echo $row['sex'];?></center></td>                                
                                <td><center><?php echo $row['dobfigure']; ?></center></td>
								 <td class="action">
                                <a href="tc_amount.php?id=<?php echo $row['id'];?>" title="payment" target="_blank"><img src="./img/pay.png" alt="payment"></a>
                                 <a href="tc_xi_edit.php?tcid=<?php echo $row['id'];?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="tc_xi_delete.php?tcid=<?php echo $row['id'];?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="tc.php?tcid=<?php echo $row['id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr>             
                                 <?php 
							$count++;
							} ?>                               																
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
	$('#table-example').dataTable();		
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
  function redirect(val){
    window.location.href = "tc_xi.php?bid=<?= $bid?>&payment="+val;   
  }
  </script>
    <?php include("roll_footer.php");?> 
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