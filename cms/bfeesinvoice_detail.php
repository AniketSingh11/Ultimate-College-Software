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
    	
        <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_bfeesinvoice.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="bfeesinvoice.php?bid=<?php echo $bid;?>" title="Bus Fees Invoice">Bus Fees Invoice </a></li> 
                <li>Bus Fees Invoice Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="bfeesinvoice.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			<div class="grid_12">
            <?php $ffi_id=$_GET['bfiid'];
			$invoicelist1=mysql_query("SELECT * FROM bfinvoice WHERE bfi_id=$ffi_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
			   
			   if(isset($_GET['del_succ']))
					{
					    if($_GET['del_succ']=="delete")
					    {
							$fitotal=$invoice['fi_total'];
               					$qry=mysql_query("update bfinvoice set i_status='1' where bfi_id=$ffi_id");
								
								$cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
							  $cash=mysql_fetch_array($cashlist);
							  $currentcash=$cash['amount'];
							  $updatecash=$currentcash-$fitotal;
							  $cashqry=mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
			   			$msg="dsucc";
						}
					}
						
						
								  
								   $i_status=$invoice['i_status'];
								    $c_status=$invoice['c_status'];
									
									$ssid=$invoice['ss_id'];
								  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $spid1=$invoice['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $rid1=$row6['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $fesstypearray1=array("Normal Fees","Sp.Fees","Onetime Sp.Fees","Onetime Fees"); 
								  $busfeestype1=$invoice['busfeestype'];
			?>
				<h1>Bus Fees Invoice Details <?php if($i_status==1){ echo "<span style='color: #D75334'>( Rejected Bill )</span>";}?></h1>
                <div id="invoice" class="widget widget-plain">			
				        <br>
                
               		<div class="widget-content">			
				<ul class="client_details">
					<li><strong class="name">FR Number : <?php echo $invoice['fr_no'];?></strong></li>
                    <li>Class: <?php echo $row['c_name'];?></li>
					<li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?></strong></li>
					<li>Admission No: <?php echo $student1['admission_number'];?></li>
					<li>Section/Group: <?php echo $row1['s_name'];?></li>					
				</ul>
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong></li>
					<li>Route Name: <?php echo $row5['r_name'];?></li>
                    <li><strong>Stopping Point 	:</strong> <?php echo $row6['stop_name'];?></li>										
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info" style="background-color:#D75334">Closed</span></li>
					<li><strong>Invoice Date :</strong> <?php echo $invoice['fi_day']."/".$invoice['fi_month']."/".$invoice['fi_year'];?></li>                	<li><strong>BusFees Type 	:</strong> <?php echo $fesstypearray1[$busfeestype1];?></li>  
                    </ul>				
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th>S.No</th>
							<th>Type of Fees Name</th>
							<th>Fees Month From</th>
							<th>Fees Month To</th>
							<th class="total">Total</th>
                            <th width="10"></th>
						</tr>
					</thead>						
					<tbody>
                    <?php 
					$count=1;
					$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
					//$qry5=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id");
			  //while($row5=mysql_fetch_array($qry5))
        		//{
					$ffrom=$invoice['ffrom'];
					$fto=$invoice['fto'];					
					$pmfrom=$invoice['pmfrom'];
					$pmto=$invoice['pmto'];
					$pending=$invoice['pending'];
					$feestotal=$invoice['fi_total']-$invoice['pending'];
						if($pending){?>
						<tr>
							<td>1</td>			
							<td><b>Last Year Pending Amount</b></td>
							<td><center><?php echo $montharray[$pmfrom-1];?></center></td>
							<td><center><?php echo $montharray[$pmto-1];?></center></td>
							<td class="total">Rs. <?php echo number_format($pending,2);?></td>
                        </tr>
                        <?php if($feestotal){?>
                        <tr>
							<td>2</td>			
							<td>Bus Fees</td>
							<td><center><?php echo $montharray[$ffrom-1];?></center></td>
							<td><center><?php echo $montharray[$fto-1];?></center></td>
							<td class="total">Rs. <?php echo number_format($feestotal,2);?></td>
                        </tr>
                        <?php } }else{ ?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td>Bus Fees</td>
							<td><center><?php echo $montharray[$ffrom-1];?></center></td>
							<td><center><?php echo $montharray[$fto-1];?></center></td>
							<td class="total">Rs. <?php echo number_format($invoice['fi_total'],2);?></td>
                        </tr>
                        <?php } //$count++;} ?>
                         <?php if($invoice['cheque_service']!=0) { ?>
                        <tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Cheque Service Charge: </td>
							<td class="sub_total"><?php echo number_format($invoice['cheque_service'],2);?></td>
						</tr>
                        <?php }	?>
						<tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <?php echo number_format($invoice['fi_total']+$invoice['cheque_service'],2);?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format($invoice['fi_total']+$invoice['cheque_service'],2);?></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">Payment Type : <strong><?php echo $invoice['fi_ptype'];?></strong></td>
						</tr>
				<tr>
                <td colspan="6" style="background:none;">
                <input type="button" value="Make Another Payment" onClick="window.location.href='busfeesbilling.php?bid=<?php echo $bid; ?>';" class="btn  btn-blue" style="width:200px">&nbsp;&nbsp;
                <input type="submit" value="Print Invoice" name="Print" onClick="window.open('bfinvoice_prt1.php?bfiid=<?php echo $ffi_id; ?>')"  class="btn btn-green" style="width:120px">&nbsp;&nbsp;
                <?php if($i_status!=1 && $c_status!=2){
					?>
                <input type="button" value="Reject Invoice" onClick="clear_cart()" class="btn btn-red" style="width:120px">
                <?php } ?>
                </td>
                </tr>
					</tbody>
                  </table>
				
				<hr>
			</div>
			</div>
		<div class="clear height-fix"></div>
        </div>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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
function clear_cart(){
	if(confirm('Are You Reject this Bill invoice, continue?')){

		window.location.href='bfeesinvoice_detail.php?bfiid=<?=$ffi_id?>&del_succ=delete';
		//document.form1.command.value='clear';
		//document.form1.submit();
	}
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