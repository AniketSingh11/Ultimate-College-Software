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
		$ffi_id=$_GET['fiid'];
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_fundinvoice.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="fundinvoice.php?bid=<?php echo $bid;?>" title="Fees Payment">Student Discount Fund</a></li> 
                <li> Student Discount Fund Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
            <a href="mfundinvoice.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <a href="mfeesinvoice_detail.php?fiid=<?php echo $ffi_id;?>&bid=<?php echo $bid;?>" target="_blank" style=" float:right"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Fee Invoice Details</button></a>
				<h1>Student Discount Fund Details</h1>
                <div id="invoice" class="widget widget-plain">			
				        <br>
                
               <?php 	
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
							<th width="10">S.No</th>
							<th><center>Fees Name</center></th>
							<th class="total" width="20%">Total</th>
                            <th width="10"></th>
						</tr>
					</thead>						
					<tbody>
                        <tr>
							<td>1</td>			
							<td><center>Total Fees Amount</center></td>
							<td class="total"><?php echo number_format($invoice['fi_total'],2);?></td>
                        </tr>
                        <tr>
							<td>2</td>			
							<td><center>Student Paid Amount</center></td>
							<td class="total"><?php echo number_format($invoice['poor_student_pay'],2);?></td>
                        </tr>
                        <tr>
							<td class="sub_total"></td>
							<td class="sub_total">Subtotal : ( <?php echo number_format($invoice['fi_total'],2)." - ".number_format($invoice['poor_student_pay'],2);?> ) </td>
							<td class="sub_total">Rs. <?php echo number_format($invoice['fund_amount'],2);?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="1"></td>
							<td class="grand_total">Total Discount From School:</td>
							<td class="grand_total">Rs. <?php echo number_format($invoice['fund_amount'],2);?></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">Payment Type : <strong><?php echo $invoice['fi_ptype'];?></strong></td>
						</tr>
				<tr>
                <td colspan="6" style="background:none;">
                <input type="submit" value="Print" name="Print" onClick="window.open('mfundinvoice_prt.php?fiid=<?php echo $ffi_id; ?>')" class="btn btn-green" style="width:120px; float:right;">&nbsp;&nbsp;
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