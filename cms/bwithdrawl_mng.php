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
                <li class="no-hover">Bank Withdrawl Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">        		
			<div class="container_12">		
            <?php 
					$baid=$_GET['baid'];
					if($baid){
							 $classlist=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
							 echo "SELECT * FROM bank_account WHERE ba_id=$baid";die;
								  $class=mysql_fetch_array($classlist);
					}
								  ?>
			<div class="grid_12">
				<h1><?php if($baid){ echo $class['name']."-".$class['account_no'];} else{ echo "All Account";} ?>  Bank withdrawl Details</h1>
                <a href="bwithdrawl_mng_new.php?baid=<?php echo $baid;?>" title="add" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				 <a href="export_bankwithdrawl.php?baid=<?php echo $baid;?>" title="Download" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>
				
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }
				 
				 			$qry1 ="SELECT * FROM bank_withdrawl";
							//echo "SELECT * FROM bank_withdrawl";die;
							if($baid){
							$qry1 .=" WHERE ba_id=$baid";
						//	echo " WHERE ba_id=$baid";die;
							}					
							$qry1 .=" ORDER BY bc_id DESC";			
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['amount'];
					$total +=$tamount;					
				}?> 
                <div class="_25" style="float:right">
                <label for="select">Account Detail :</label>
                                	<?php
                                            $classl = "SELECT * FROM bank_account";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="baid" id="baid" class="required" onchange="change_function()">';
											echo "<option value='' selected>All</option>\n";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($baid ==$row1['ba_id']){
                                                echo "<option value='{$row1['ba_id']}' selected>{$row1['name']} - {$row1['account_no']}</option>\n";
												} else {
												echo "<option value='{$row1['ba_id']}'>{$row1['name']} - {$row1['account_no']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div> 
                 <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>                
			</div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php  if($baid){ echo $class['name']."-".$class['account_no'];} else{ echo "All Account";} ?> Bank withdrawl Details</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Date</center></th>
                                    <th><center>account No</center></th>
                                    <th><center>Bank</center></th>
                                    <th><center>withdrawled By</center></th>
                                    <th><center>type</center></th> 
                                    <th><center>Amount</center></th>                                    
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry1 ="SELECT * FROM bank_withdrawl";
							if($baid){
							$qry1 .=" WHERE ba_id=$baid";
							}
							$qry1 .=" ORDER BY bc_id DESC";
							$qry=mysql_query($qry1);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$baid1=$row['ba_id'];
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['account_no']; ?></center></td>
                                <td><center><?php echo $row['b_name']; ?></center></td>
                                <td><center><?php echo $row['withdrawl_by']; ?></center></td>
                                 <td><center><?php if($row['type']=='1'){ echo "Expence paid Cheque";}else{ echo "Self Cheque"; } ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['amount'],2); ?></center></td>                               
								 <td class="action" style="width:90px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <?php if($row['type']=='0'){ ?>
                                 <a href="bwithdrawl_mng_edit.php?bcid=<?php echo $row['bc_id'];?>&baid=<?php echo $baid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="bwithdrawl_mng_delete.php?bcid=<?php echo $row['bc_id']; ?>&baid=<?php echo $baid; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a><a href="bwithdrawl_mng_print.php?bcid=<?php echo $row['bc_id']; ?>&baid=<?php echo $baid; ?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 <?php } ?>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['b_name']."-".$row['account_no']; ?> Bank withdrawl Details" style="display: none;">
                    <p>Date : <strong><?php echo $row['date']; ?></strong></p>
                    <p>Account No : <strong><?php echo $row['account_no']; ?></strong></p> 
                    <p>Bank Name : <strong><?php echo $row['b_name']; ?></strong>  </p>   
                    <p>withdrawled By : <strong><?php echo $row['withdrawl_by']; ?></strong>  </p>   
                    <p>withdrawl Amount : <strong>Rs. <?php echo number_format($row['amount'],2); ?></strong>  </p>   
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
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
	 function change_function() { 
     var cid =document.getElementById('baid').value;
	 window.location.href = 'bwithdrawl_mng.php?baid='+cid;	  
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