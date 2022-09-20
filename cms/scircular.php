<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover">Circulars</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Circulars</h1>
    		</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Circulars</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">All Circular</a></li>
							<li><a href="#tab-2">Your Circular</a></li>
						</ul>
                        <span></span>
					</div>
					<div class="block-content tab-container">
						<div id="tab-1" class="tab-content">
							<br>
							<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Type</th>
                                    <th>Board</th>
                                    <th width="80px;">Circular File</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM circular WHERE ay_id='$acyear' AND (type='Staff' OR type='All') AND status='1' ORDER BY cl_id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
								$bid=$row['b_id'];
								  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['cl_day']."-".$row['cl_month']."-".$row['cl_year']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo $row['descript'];  ?></center></td>
                                <td><center><?php echo $row['type']; ?></center></td>
                                <td><center><?php if($board['b_name']){ echo $board['b_name'];} else { echo "All";} ?></center></td>
                                <td><?php if($row['file']){?><center><a href="circular/<?php echo $row['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center><?php } ?></td>
                                <td width="20px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row['cl_day']."-".$row['cl_month']."-".$row['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                
                <p>Description : <strong><?php echo $row['descript']; ?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board['b_name']){ echo $board['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row['file']){?><a href="circular/<?php echo $row['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                </div>
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>
						<div id="tab-2" class="tab-content">
                        <br>
							<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Type</th>
                                    <th>Board</th>
                                    <th>Circular File</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry1=mysql_query("SELECT * FROM circular WHERE type='Staff' AND ay_id=$acyear AND status='1' ORDER BY cl_id DESC");
							$count11=1;
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				
						$bid1=$row1['b_id'];
								  $boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);?>
								<tr class="gradeX">
                                <td class="sno center"><center><?php echo $count11; ?></center></td>
								<td><center><?php echo $row1['cl_day']."-".$row1['cl_month']."-".$row1['cl_year']; ?></center></td>
                                <td><center><?php echo $row1['title']; ?></center></td>
                                <td><center><?php echo $row1['descript'];  ?></center></td>
                                <td><center><?php echo $row1['type']; ?></center></td>
                                <td><center><?php if($board1['b_name']){ echo $board1['b_name'];} else { echo "All";} ?></center></td>
                                <td><center><a href="circular/<?php echo $row1['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center></td>
                                <td width="20px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog11<?php echo $count11;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog11<?php echo $count11;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row1['cl_day']."-".$row1['cl_month']."-".$row1['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row1['title']; ?></strong></p> 
                
                <p>Description : <strong><?php echo $row1['descript']; ?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row1['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board1['b_name']){ echo $board1['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row1['file']){?><a href="circular/<?php echo $row1['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                </div>
                                 <?php 
							$count11++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
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
		/*
		 * DataTables
		 */
		
		$("#tab-panel-1").createTabs();
		
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