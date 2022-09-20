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
				<li class="no-hover">Couriers Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Couriers Management</h1>
                <a href="coureir_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border" id="tab-panel-1">
					<div class="block-header">
                    	<h1>Couriers Management</h1>
                        <ul class="tabs" style="margin-right:20px;">
							<li><a href="#tab-1">Coureir</a></li>
							<li><a href="#tab-2">Dispatches</a></li>
						</ul>
                        <span></span>
					</div>
					<div class="block-content">
                    <br>
                    <div id="tab-1" class="tab-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Courier From</center></th>
                                    <th><center>Courier To </center></th>
                                    <th><center>Description</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Time</center></th>
                                    <th><center>Contact No</center></th>
                                    <th><center>Received By</center></th>
                                    <th><center>Remarks</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM courier WHERE ay_id=$acyear AND type='1' ORDER BY id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
                                    <td><center><?php echo $row['c_from']; ?></center></td>
								<td><center><?php echo $row['c_to']; ?></center></td>
                                <td><center><?php echo $row['descri']; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['time']; ?></center></td>
                                <td><center><?php echo $row['mobile']; ?></center></td>
                                <td><center><?php echo $row['received']; ?></center></td>
                                 <td><center><?php echo $row['remark']; ?></center></td>
                                <td class="action"><a href="coureir_edit.php?nid=<?php echo $row['id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="coureir_delete.php?nid=<?php echo $row['id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        </div>
                        <div id="tab-2" class="tab-content">
						<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Courier From</center></th>
                                    <th><center>Courier To </center></th>
                                    <th><center>Description</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Time</center></th>
                                    <th><center>Contact No</center></th>
                                    <th><center>Received By</center></th>
                                    <th><center>Remarks</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM courier WHERE ay_id=$acyear AND type='2' ORDER BY id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
                                    <td><center><?php echo $row['c_from']; ?></center></td>
								<td><center><?php echo $row['c_to']; ?></center></td>
                                <td><center><?php echo $row['descri']; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['time']; ?></center></td>
                                <td><center><?php echo $row['mobile']; ?></center></td>
                                <td><center><?php echo $row['received']; ?></center></td>
                                 <td><center><?php echo $row['remark']; ?></center></td>
                                <td class="action"><a href="coureir_edit.php?nid=<?php echo $row['id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="coureir_delete.php?nid=<?php echo $row['id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
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
		$("#tab-panel-1").createTabs();
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachNEWS('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>