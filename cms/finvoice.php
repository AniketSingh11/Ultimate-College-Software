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
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  
								  $ffi_id=$_GET['fiid'];
								  $invoicelist1=mysql_query("SELECT * FROM finvoice WHERE fi_id=$ffi_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
								  
								  if(isset($_GET['del_succ']))
					{
					    
					    if($_GET['del_succ']=="delete")
					    {
							$fitotal=$invoice['fi_total'];
               					$qry=mysql_query("update finvoice set i_status='1' where fi_id=$ffi_id");
								$qry5=mysql_query("SELECT dv_id FROM fsalessumarry WHERE fi_id=$ffi_id AND dv_id");
							  while($row5=mysql_fetch_array($qry5))
								{
									$dvid=$row5['dv_id'];
									$qry1=mysql_query("UPDATE discount_value SET payment='0' WHERE dv_id='$dvid'");
								}
								
								$cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
							  $cash=mysql_fetch_array($cashlist);
							  $currentcash=$cash['amount'];
							  $updatecash=$currentcash-$fitotal;
							  $cashqry=mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
			   			$msg="dsucc";
						}
					}
								  
								  
								  
								  $i_status=$invoice['i_status'];
									
									$ssid=$invoice['ss_id'];
								  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  
								  $scateg=$student1['scateg'];
								  $sfood=$student1['sfood'];
								  $rid=$student1['r_id'];
								  
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_fees.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="billing.php?bid=<?php echo $bid;?>" title="Fees Payment">Fees Paymant </a></li> 
                <li> Fees Invoice <?php if($i_status==1){ echo "( rejected Invoice)";}?></li>
			</ul>
		</div> <!--! end of #title-bar -->
		<div class="shadow-bottom shadow-titlebar"></div>
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>Fees Invoice <?php if($i_status==1){ echo "( rejected Invoice)";}?></h1>
                <?php
                if($msg=="dsucc"){
			   	?>
                <div class="alert success"><span class="hide">x</span>Your Invoice bill successfully Rejected!!!</div>
                <?php }?>
                <div id="invoice" class="widget widget-plain">			
				        <br>                
               <?php 
						
						
			?>
						
						<div class="widget-content">			
				<ul class="client_details">
					<li><strong class="name">FR Number : <?php echo $invoice['fr_no'];?></strong></li>
                    <li>Class - Section: <?php echo $row['c_name']." - ".$row1['s_name'];?></li>
					<li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $student1['firstname']." ".$student1['lastname'];?></strong></li>
					<li>Admission No: <?php echo $student1['admission_number'];?></li>
						<li> Student Type : <?php echo $invoice['stype'];?> Student</li>			
				</ul>
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong></li>
                    <li>Parent's Name: <?php echo $student1['fathersname'];?></li>
															
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info" style="background-color:#D75334">Closed</span></li>
					<li><strong>Invoice Date :</strong> <?php echo $invoice['fi_day']."/".$invoice['fi_month']."/".$invoice['fi_year'];?></li>                </ul>
                    <?php if($rid){
						$roll=$student1['admission_number']."-".$student1['firstname']." ".$student1['lastname'];?>
                 <a href="busfeesbilling.php?roll=<?=$roll?>&bid=<?=$bid?>&fee=1" title="Vehicle Fees Payment" class="btn btn-small btn-success" style="color:#FFFFFF" target="_blank"><img src="img/icons/packs/fugue/16x16/table--plus.png"> Vehicle Fees Payment</a><?php } ?>				
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th width="10">S.No</th>
							<th><center>Fees Group Name</center></th>
							<th class="total" width="20%">Total</th>
                            <th width="10"></th>
						</tr>
					</thead>						
					<tbody>
                    <?php 
					$count=1;
					$myarray = array();
					//$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
					$qry5=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id");
			  while($row5=mysql_fetch_array($qry5))
        		{ 
				$fssid=$row5['fss_id'];
				$fgd_id=$row5['fgd_id'];
				$type=$row5['type'];
				if($type=="terms"){
						
						
						//$qry6=mysql_query("SELECT SUM(amount) AS amount1 FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgd_id");
						//$row6=mysql_fetch_array($qry6);
						$amount=$row5['amount'];
						
						
				?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php 
							if($row5['fg_id']==4)
								echo $row5['name'];
							else {
								$fgid=$row5['fg_id'];
								$fgp=mysql_query("select * from fgroup where fg_id=$fgid");
									 $gname=mysql_fetch_array($fgp)['fg_name'];
									 echo $gname.' Fees';
							}
							if($row5['discount']!=0){
                              $reson='';
                            if($row5['discount_remark']!="")
                              $reson=' for '.$row5['discount_remark'];
                          	$wamt=mysql_query("select sum(rate) as wtot from frate where ay_id='$acyear' AND c_id='$cid1'");
                          	$totamt=mysql_fetch_assoc($wamt)['wtot'];
                            $percent=($row5['discount']/$totamt)*100;
                            echo '<br>Fees Concession Rs '.$row5['discount'].'( '.round($percent,2).'% )'.$reson;
                            }
                            ?></center></td>
							<td class="total"><?php echo number_format($amount,2);
							?></td>
                            <!--<td><a href=""><img src="Book_inventory/images/del.png" alt="delete"></a></td>-->
                        </tr>
                        <?php $count++;  }
						else{ ?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo $row5['name'];
							if($row5['discount']!=0){
                              $reson='';
                            if($row5['discount_remark']!="")
                              $reson=' for '.$row5['discount_remark'];
                            $percent=($row5['discount']/$row5['tamount'])*100;
                            echo '<br>Fees Concession Rs '.$row5['discount'].'( '.round($percent,2).'% )'.$reson;
                            
                            }
                            ?>
							</center></td>
							<td class="total"><?php echo number_format($row5['amount'],2);
							?></td>
                            <!--<td><a href=""><img src="Book_inventory/images/del.png" alt="delete"></a></td>-->
                        </tr>
                        <?php $count++;} }?>
                        <?php 
                        //echo $invoice['cheque_service'];
                        //  cheque bounce dev-sri
                        if($invoice['cheque_service']!=0) { ?>
                        <tr>
							<td class="sub_total" colspan="1"></td>
							<td class="sub_total">Cheque Bounce Charges:</td>
							<td class="sub_total">Rs. <?php echo number_format($invoice['cheque_service'],2);?></td>
						</tr>
						<?php } ?>
						<tr>
							<td class="sub_total" colspan="1"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <?php echo number_format($invoice['fi_total'],2);?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="1"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format($invoice['fi_total'],2);?></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">Payment Type : <strong><?php echo $invoice['fi_ptype'];?></strong></td>
						</tr>
				<tr>
                <td colspan="6" style="background:none;">
                <input type="button" value="Make Another Payment" onClick="window.location.href='billing.php?bid=<?php echo $bid; ?>';" class="btn  btn-blue" style="width:200px">&nbsp;&nbsp;
                <input type="submit" value="Print Invoice" name="Print" onClick="window.open('finvoice_prt.php?fiid=<?php echo $ffi_id; ?>&type=new')"  class="btn btn-green" style="width:120px">&nbsp;&nbsp;
                <?php if($invoice['funds']=="1"){?>
                <input type="submit" value="Print Discount Receipt" name="Print" onClick="window.open('fundinvoice_prt.php?fiid=<?php echo $ffi_id; ?>&type=new')"  class="btn btn-warning" style="width:150px">&nbsp;&nbsp;
                <?php } ?>
                <?php if($i_status!=1 && $_SESSION['admin_type']=="0"){?>
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
  
  <script>
function clear_cart(){
	if(confirm('Are You Reject this Bill invoice, continue?')){

		window.location.href='finvoice.php?fiid=<?=$ffi_id?>&del_succ=delete';
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
</body>
</html>
<? ob_flush(); ?>