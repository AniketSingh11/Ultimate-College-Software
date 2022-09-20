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
                <li class="no-hover">Apply Leave</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Apply Leave</h1>                
                <a href="sleave_apply.php"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Apply Leave</button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="dsucc"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully deleted!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Apply Leave List</h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th data-filterable="true" data-sortable="true">Applied Date</th>
									<th data-filterable="true" data-sortable="true">From Date</th>
                                    <th data-filterable="true" data-sortable="true">To Date</th>
                                    <th data-filterable="true" data-sortable="true">Total Days</th>	
                                     <th data-filterable="true" data-sortable="true">Leave Type</th>	
                                     <th data-filterable="true" data-sortable="true">Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php
										$emp_query="select * from staff_leave where st_id=$stid order by id desc";
										$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($row=mysql_fetch_array($emp_result))
		{
			$id=$row["id"];	
										?> 
                            	<tr class="gradeX">
									<td class="sno center"><center><?php echo $emp_count; ?></center></td>
								<td><?php echo $row["a_date"]; ?> </td>
                                             <td><?php echo $row["f_date"]; ?> </td>
                                             <td><?php echo $row["t_date"]; ?> </td>
                                             <td><?php echo $row["l_total"]; ?> </td>                                             
                                             <td><?php echo $row['l_type_name'];?></td>	
                                <td><center>
                                <?php 
				if($row['status']==1){?>
                <button class="btn btn-warning btn-small"> Pending </button>
				<?php } 
				 if($row['status']==2){?> 
                 <button class="btn btn-error btn-small"> Rejected </button>
				 <?php }
				 if($row['status']==3){?>
                 <button class="btn btn-success btn-small"> Approved </button>
                 <?php }				 			 
				  ?>
                                </center></td>
								 <td class="action">
                                 <?php if($row['status']!=3){?>
                                 <a href="sleave_edit.php?slid=<?php echo $row['id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> 
                                 <?php } ?>
                                 <a href="sleave_delete.php?slid=<?php echo $row['id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
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
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  <script defer src="js/zebra_datepicker.js"></script>
  
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>