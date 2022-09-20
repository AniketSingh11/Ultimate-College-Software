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
        if($_POST['submit']){
        	//print_r($_POST);
        	$date_day=date('d');
        	$date_month=date('m');
        	$date_year=date('Y');
        	$id=$_POST['tc_id'];
        	$amt=$_POST['amount'];
        	$status=0;
        	$up=mysql_query("update tc_xi set status='0',tc_amount='$amt',date_day='$date_day',date_month='$date_month',date_year='$date_year' where id='$id'");
        	
        	if($up){
        		header('Location:tc_amount.php?id='.$id.'&update=success');
        		exit;
        	} else {
        			echo 'fsd';
        			die;
        	}	
        }
		
								  
								  $ffi_id=$_GET['id'];
								  $invoicelist1=mysql_query("SELECT * FROM tc_xi WHERE id=$ffi_id"); 
								  $tc=mysql_fetch_array($invoicelist1);
								  	
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_fees.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="billing.php?bid=<?php echo $bid;?>" title="Fees Payment">Certificate</a></li> 
                <li>TC</li>
			</ul>
		</div> <!--! end of #title-bar -->
		<div class="shadow-bottom shadow-titlebar"></div>
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>TC</h1>
                <?php
                if($_GET['update']=="success"){
			   	?>
               <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc.php?tcid=<?php echo $_GET['id'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Created Certificate</button></a></center>
            </div>
                <?php }?>
                <div id="invoice" class="widget widget-plain">			
				        <br>                
         
						<div class="widget-content">			
				<ul class="client_details">
					<li><strong class="name">TC Number : <?php echo $tc['tno'];?></strong></li>
                    <li>Class <?php echo $tc['standard'];?></li>
					<li>Gender: <?= $tc['sex']?></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <?php echo $tc['sname'];?></li>
					<li>Admission No: <?php echo $tc['ano'];?></li>
									
				</ul>
                <ul class="client_details">
					<li>Academic Year : <?php echo $tc['academic_year'];?></li>
                    <li>Parent's Name: <?php echo $tc['fname'];?></li>
															
				</ul>
				<ul class="client_details">
					
					<li><strong>Issued Date :</strong> <?php echo $tc['dtc'];?></li>                </ul>
                  			
				<form action="tc_amount.php" method="post">
				<input type="hidden" name="tc_id" value="<?= $_GET['id']?>">
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th width="10">S.No</th>
							<th><center>Fees Group Name</center></th>
							<th class="total" width="20%">Total</th>
                            
						</tr>
					</thead>						
					<tbody>
                    <tr>
                    <td>1</td>
                    <td>Certificate Issue Fee</td>
                    <td>
                    <?php if($tc['tc_amount']!=0) { ?>
                    <center><?= $tc['tc_amount']?></center>
                    <?php } else { ?>
                    	<input id="textfield" name="amount" class="required text valid" type="text">
                    <?php } ?>
                    </td>
                    </tr>
                    <tr>
                <td colspan="6" style="background:none;text-align: right;">
                <?php if($tc['status']=='1') { ?>
                <input type="submit" value="Submit" name="submit" class="btn btn-green" style="width:120px">
               	<?php }	else { ?>
               	<input type="button" value="Print" name="Print" onClick="window.open('tc_amount_prt.php?id=<?= $ffi_id?>')"  class="btn btn-green" style="width:120px">

               	<?php } ?>
               	<input type="button" value="Cancel" name="cancel" onClick="redirect();"  class="btn btn-red" style="width:120px">
                </td>
                </tr>
					</tbody>
                  </table>
				</form>
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
function redirect(){
	 document.location.href = "tc_xi.php?bid=1";
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