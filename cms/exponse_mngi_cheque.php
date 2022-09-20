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
                <li class="no-hover"> Cheque Bill Paid Manage</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">        		
			<div class="container_12">		
            <?php 
					$aid=$_GET['aid'];
					if($aid){
							 $agencylist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
								  $agency=mysql_fetch_assoc($agencylist);
					}
								  ?>
			<div class="grid_12">
				<h1><?php  if($aid){ echo $agency['a_name'];} else{ echo "All";} ?> Cheque Bill Paid Manage</h1>
                <a href="exponse_mngi_new.php" title="add" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
			 	<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Rejected !!!</div>
                 <?php }
				 
				 			$qry1 ="SELECT amount FROM exponses_bill WHERE ay_id=$acyear";
							if($excid){
							$qry1 .=" AND a_id=$aid";
							}
							$qry1 .=" AND p_type='cheque'";
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$tamount=$row1['amount'];
					$total +=$tamount;					
				}?> 
				<div class="_25" style="float:right">
                <label for="select">Agencies:</label>
                                	<?php
                                            $classl = "SELECT * FROM agency WHERE status=0";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="aid" id="aid" class="required" onchange="change_function()">';
											echo "<option value=''>All</option>\n";
											while ($row1 = mysql_fetch_assoc($result1)):
											if($row1['a_id']==$aid){
												echo "<option value='{$row1['a_id']}' selected>{$row1['a_name']}</option>\n";
											}else{
												echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
											}
                                            endwhile;
                                            echo '</select>';
                                            ?>
                 </div>  
                 <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>                
			</div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php  if($aid){ echo $agency['a_name'];} else{ echo "All";} ?> Cheque Bill Paid Details</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Agency Name</center></th>
                                    <th><center>Paid No</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Amount</center></th>  
                                    <th>Cheque  Status</th>                                  
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry2="SELECT * FROM exponses_bill WHERE ay_id=$acyear";
							if($aid){
							$qry2 .="  AND a_id=$aid";
							}
							$qry2 .=" AND p_type='cheque' ORDER BY ep_id DESC";
							$qry=mysql_query($qry2);
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{
					$c_status=$row['c_status'];
						if($c_status==0 || $c_status==2 ){				    
							if($c_status==0){
							$cstat="warning";
							}else{
								$cstat="success";
							}
							if($c_status==2){
							$csen="Finished";}else{
								$csen="Process";
							}
						}else{
							$csen="Bounce";
							$cstat="error";
						}	
					$aid1=$row['a_id'];
					 $agencylist1=mysql_query("SELECT * FROM agency WHERE a_id=$aid1"); 
								  $agency1=mysql_fetch_assoc($agencylist1);
								  $agencyname=$agency1['a_name'];
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                                <td><center><?php echo $agencyname; ?></center></td>
                                <td><center><?php echo $row['bill_no']; ?></center></td>
                                 <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
								<td><center>Rs. <?php echo number_format($row['amount'],2); ?></center></td>                               
                                <td><button class="btn btn-<?=$cstat?> btn-small"><?=$csen?></button></td>
								 <td  width="12%">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="exponse_mngi_cheque_edit.php?epid=<?php echo $row['ep_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="exponsei_prt.php?id=<?php echo $row['ep_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 <a href="exponse_mngi_delete.php?epid=<?php echo $row['ep_id']; ?>" class="delete" title="Bill Reject" rel="tooltip-top" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $agencyname; ?> Bill Paid Details" style="display: none;">
                                <p>Date : <strong><?php echo $row['date']; ?></strong></p>
                                <p>Bill No : <strong><?php echo $row['bill_no']; ?></strong></p>
                                <p>Title : <strong><?php echo $row['title']; ?></strong></p>   
                                <p>Amount : <strong>Rs. <?php echo number_format($row['amount'],2); ?></strong>  </p>   
                                </div>                				
                            </div> <!--! end of #info-dialog -->
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
	$('#table-example').dataTable({
  'iDisplayLength': 25
});
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
		$("#exsid option[data_value='<?=$excid?>']").show();
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
	 function change_function() { 
     var cid =document.getElementById('aid').value;
	 window.location.href = 'exponse_mngi.php?aid='+cid;	  
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