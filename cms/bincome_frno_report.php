<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
                <li> Fees Income Report Based FR.No</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Start and End Date And Board</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
						<div class="_25">
							<p>
								<label for="select">Start FR Number : <span class="error">*</span></label>
                               <input id="s_erno" name="s_erno" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">End ER Number : <span class="error">*</span></label>
                               <input id="e_erno" name="e_erno" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
                       <select name="b_id" id="b_id" class="required">
						  <option value="All">All Board</option>
                             <?php  $qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{	?> 
							<option value="<?php echo $row['b_id'];?>"><?php echo $row['b_name'];?></option>                                                           
               <?php  } ?>
               </select>
               			</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 
					$s_erno=$_GET['s_erno'];
					$e_erno=$_GET['e_erno'];
					$bid=$_GET['b_id'];
					if(!empty($bid) && $bid!='All') {
					$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
					}
					
					
					if($s_erno && $e_erno && $bid){ 
					
					$qry1="SELECT * FROM bfinvoice WHERE (fr_no >=" . $s_erno. " AND fr_no <=" . $e_erno. ") AND ay_id=$acyear AND c_status!='1' AND i_status='0'";
							if(!empty($bid) && $bid!='All') { $qry1 .= " AND bid = '" . $bid. "'"; }
							//echo $qry1;
							//die();
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$total +=$row1['fi_total'];
				}?>
                <div class="grid_12"><br>
                <h1> Bus Fees Income Report Based FR.No</h1>
                <span style="">Board Name : <strong><?php if($bid=='All'){ echo "All";}else{ echo $board['b_name']; }?></strong></span>
               <span style="margin-left:20px;"><a href="bfrincome_export.php?s_erno=<?php echo $s_erno;?>&e_erno=<?php echo $e_erno;?>&b_id=<?php echo $bid;?>&ayid=<?php echo $acyear;?>" style="width:100px"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report</button></a></span>
                <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start FR No : <strong> <?php echo $s_erno; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End FR No : <strong><?php echo $e_erno; ?></strong> | <img src="img/icons/packs/fugue/16x16/calculator-scientific.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>
                <br><br>
				<div class="block-border">
					<div class="block-header">
                    	<h1> Bus Fees Income Report (<?php if($bid=='All'){ echo "All";}else{ echo $board['b_name']; }?>)</h1>                       
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>FR No</center></th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                   	<th>Board</th>
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th>Stopping</th>
                                    <th>Inovice By</th>
                                    <th width="10%">Amount</th>
                                    <th>Inovice Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry="SELECT * FROM bfinvoice WHERE (fr_no >=" . $s_erno. " AND fr_no <=" . $e_erno. ") AND ay_id=$acyear AND c_status!='1' AND i_status='0'";
							if(!empty($bid) && $bid!='All') { $qry .= " AND bid = '" . $bid. "'"; }
							$qry=mysql_query($qry);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$bid1=$row['bid'];
					$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
					$boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);
					$boardname=$board1['b_name'];
					
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $rid1=$row6['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
					
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['fr_no']; ?></center></td>
                                <td><center><?php echo $row['fi_name']; ?></center></td>
                                <td><center><?php echo $row['fi_day']."/".$row['fi_month']."/".$row['fi_year']; ?></center></td>
                                <td><center><?php echo $boardname;?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row5['r_name']; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <td><center><?php echo $row['bfi_by']; ?></center></td>
                                <td>Rs. <?php echo number_format($row['fi_total'],2); ?></td>
								<td class="view"><center><a href="bfeesinvoice_report_detail.php?bfiid=<?php echo $row['bfi_id'];?>&bid=<?php echo $bid1;?>&bid1=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>			
		<div class="clear height-fix"></div>
        </div>
        <?php } ?>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
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
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).datepicker();
		$( "#datepicker1" ).datepicker();
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