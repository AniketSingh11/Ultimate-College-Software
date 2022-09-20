<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
 $bid=$_GET['bid'];
 if($_SERVER['REQUEST_METHOD']=="POST"){
   
     $id=$_POST["id"];
     echo $ptype=$_POST["ptype"];
     $pay_number=$_POST["pay_number"];
     $c_status=$_POST["c_status"];
     if($c_status==""){
          
         $c_status=0;
     }
      
     if($ptype=="cash")
     {
         $pay_number="";
         $c_status="0";
     }elseif($ptype=="card")
     {
         
         $c_status="0";
    }else{
        
        
    }
    
	 $qry1=mysql_query("UPDATE mfinvoice  SET fi_ptype='$ptype',pay_number='$pay_number',c_status='$c_status'  WHERE fi_id='$id'") or die(mysql_error());
    header("location:mchequefeesinvoice_detail.php?fiid=$id&bid=$bid&msg=dsucc");
     
 }
 
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
	
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="mboard_select_feesinvoice.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="mcheque_feesinvoice.php?bid=<?php echo $bid;?>" title="Fees Payment">Cheque Fees Paymant </a></li> 
                <li> Cheque Fees Invoice Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
			
            <a href="mcheque_feesinvoice.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
				
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Invoice Successfully Updated !!!</div>
                 <?php } ?>   
				<h1>Cheque Fees Invoice Details</h1>
                <div id="invoice" class="widget widget-plain">			
				        <br>
                
               <?php $ffi_id=$_GET['fiid'];
						
						$invoicelist1=mysql_query("SELECT * FROM mfinvoice WHERE fi_id=$ffi_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
									
									$ssid=$invoice['ss_id'];
								  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $cstatus=$invoice['c_status'];
			?>
						
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
					<li>Category: <?php echo $invoice['category'];?></li>
                    <li> Student Type : <?php echo $invoice['stype'];?> Student</li>										
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info" style="background-color:#D75334">Closed</span></li>
					<li><strong>Invoice Date :</strong> <?php echo $invoice['fi_day']."/".$invoice['fi_month']."/".$invoice['fi_year'];?></li>                </ul>				
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th>S.No</th>
							<th>Fees Group Name</th>
							<th>Fees From</th>
							<th>Fees To</th>
							<th class="total">Total</th>
                            <th width="10"></th>
						</tr>
					</thead>						
					<tbody>
                    <?php 
					$count=1;
					$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
					$qry5=mysql_query("SELECT * FROM mfsalessumarry WHERE fi_id=$ffi_id");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffrom=$row5['ffrom'];
					$fto=$row5['fto'];
					$fgid=$row5['fg_id'];
					$fgdid=$row5['fgd_id'];
					if($fgid){?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><?php echo $row5['fg_name'];?></td>
							<td><?php echo $montharray[$ffrom-1];?></td>
							<td><?php echo $montharray[$fto-1];?></td>
							<td class="total">Rs. <?php echo $row5['amount'];?></td>
                            <!--<td><a href=""><img src="Book_inventory/images/del.png" alt="delete"></a></td>-->
                        </tr>
                        <?php } else if($fgdid){ ?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td><?php echo $row5['fg_name'];?></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total">Rs. <?php echo $row5['amount'];?></td>
                            <!--<td><a href=""><img src="Book_inventory/images/del.png" alt="delete"></a></td>-->
                        </tr>
							
						<?php } $count++;} ?>
						<tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <?php echo number_format($invoice['fi_total'],2);?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format($invoice['fi_total'],2);?></td>
						</tr>
						 <tr>
							<td colspan="7" align="right">Payment Type : <strong><?php echo $invoice['fi_ptype'];?></strong></td>
                      <form id="validate-form" class="block-content form" action="mchequefeesinvoice_detail.php?bid=<?=$bid?>" method="post">
                      <input type="hidden" name="id" value="<?=$ffi_id?>">
                      <?php if($invoice['fi_ptype']=="cheque")
                      {?>
                        <tr>
							<td colspan="7" align="right"> 
							<div class="_25">
                                    <p>
                                    <label for="textfield">Payment Type:</label>
										<select name="ptype" id="ptype" class="required" onchange="paymet_type()">
											<!--<option value="">Please select</option>-->
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>
                                            <option value="cheque" selected="selected">cheque</option>									
										</select>	
                                        </p>									
									</div>
                                    <div id="ajax_pay">
                                    <div class="_25"><p>
                                <label for="textfield">Number </label>
                                <input type="text" value="<?=$invoice['pay_number']?>" class="required"  name="pay_number" id="textfield">
                            </p></div>
                            <div class="_25" id="pstatus"><p>
                                <label for="textfield">Status </label>
                               <select name="c_status" id="c_status"  class="required">
											 
											 <option value="0" <?php if($cstatus==0){ echo "selected";}?>>Process</option>
											 <option value="1" <?php if($cstatus==1){ echo "selected";}?>>Bounce</option>
                                            <option value="2" <?php if($cstatus==2){ echo "selected";}?>>Paid</option>	
                                           
                                             								
										</select>
                            </p></div>
									</div>
									</td>
						</tr>
						<?php }?>
				<tr>
                <td colspan="6" style="background:none;">
                 <?php if($invoice['fi_ptype']=="cheque") {?>  <input type="submit" value="Update Cheque Status" name="Cheque Status"  class="btn btn-green" style="width:190px">&nbsp;&nbsp; <?php }?>
                
               <input type="button" value="Print Invoice" name="Print" onClick="window.open('mfinvoice_prt.php?fiid=<?php echo $ffi_id; ?>', '_blank');" class="btn btn-green" style="width:120px">&nbsp;&nbsp;
                </td>
                </tr></form>
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
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->
  <!-- JavaScript at the bottom for fast page loading -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  <!--jQuery UI -->
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
  $(document).ready(function() {
		var validateform = $("#validate-form1").validate();
  });
  function paymet_type() {
		var x = document.getElementById("ptype").value;
		if(x != "cash"){
			$('#ajax_pay').show();
			$('#pstatus').show();
			if(x == "card"){
				$('#pstatus').hide();
			} 
		}else{
			
			$('#ajax_pay').hide();
		}
		
	}
  paymet_type();
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