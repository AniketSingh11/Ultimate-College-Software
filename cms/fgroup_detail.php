<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 $montharray=array("January","February","March","April","May","June","July","August","September","October","November","December"); 
 $fgid=$_GET['fg_id'];
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
    	<?php include("nav.php");
		$fgruplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$fgid"); 
								  $fgroup=mysql_fetch_array($fgruplist);	 
		
		?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li><a href="fgroup.php" title="fees group">Fees Group</a></li>
				<li class="no-hover"><?php echo $fgroup['fg_name'];?> - Detail</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Fees Group Detail ( <?php echo $fgroup['fg_name'];?> )</h1>
                <a href="fgroup.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a> | <a href="fgroup_detail_add.php?fg_id=<?php echo $fgid;?>"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <?php if($fgroup['ftype']=="other"){?>
            
            	<div class="grid_12">
				<div class="block-border" id="tab-panel-2">
					<div class="block-header">
						<h1>Fees Group Detail ( <?php echo $fgroup['fg_name'];?> )</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-lorem">Other School Fees</a></li>
							<li><a href="#tab-dolor">Other Extra Fees</a></li>
						</ul>
                         <span></span>
					</div>
					<div class="block-content tab-container">
						<div id="tab-lorem" class="tab-content">
                        <br>
							<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Fees Group Name</center></th>
                                    <th><center>Fee Type</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid AND otherfees='0'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
                                    <td><center><?php echo $row['name']; ?></center></td>    
                                    <td><center><?php if($row['type']=="1"){ echo "Only New Student"; } else { echo "Comman"; } ?></center></td>                                
								<td class="action"><a href="fgroup_detail_edit.php?fgdid=<?php echo $row['fgd_id'];?>&fg_id=<?php echo $fgid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="fgroup_detail_delete.php?fgdid=<?php echo $row['fgd_id']; ?>&fg_id=<?php echo $fgid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
						</div>
						<div id="tab-dolor" class="tab-content">
							<br>
                            <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Fees Group Name</center></th>
                                    <th><center>Fees Amount</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid AND otherfees='1'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
                                    <td><center><?php echo $row['name']; ?></center></td>
                                   <td><center><?php echo $row['fees_amount']; ?></center></td>
								<td class="action"><a href="fgroup_detail_edit.php?fgdid=<?php echo $row['fgd_id'];?>&fg_id=<?php echo $fgid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="fgroup_detail_delete.php?fgdid=<?php echo $row['fgd_id']; ?>&fg_id=<?php echo $fgid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>            
            <?php } else {?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Fees Group Detail</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Fees Group Name</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM fgroup_detail where fg_id!=4");
							$count=1;
							  while($row=mysql_fetch_array($qry))
								{
								?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
                                    <td><center><?php echo $row['name']; ?></center></td>
                                <td class="action"><a href="fgroup_detail_edit.php?fgdid=<?php echo $row['fgd_id'];?>&fg_id=<?php echo $fgid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="fgroup_detail_delete.php?fgdid=<?php echo $row['fgd_id']; ?>&fg_id=<?php echo $fgid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
			</div>
            <?php } ?>
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
		$("#tab-panel-2").createTabs();
		
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