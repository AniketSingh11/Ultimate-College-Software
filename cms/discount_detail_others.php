<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 $did=$_GET['did'];
	$bid=$_GET['bid'];
	if(!$bid){
			$boardlist1=mysql_query("SELECT b_id FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
	$cids=$_GET['cid'];
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
		$id=$_GET['id'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  if($cids){
									  $classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cids"); 
								  	  $class=mysql_fetch_array($classlist);
								   }
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="#" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="discount_mng_others.php?cid=<?php echo $cid;?>&bid=<?php echo $bid;?>" title="<?php echo $board['b_name'];?>">Student Discount Management </a></li>
                <li class="no-hover">Discount Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Discount Details</h1>                
			<a href="discount_mng_others.php?cid=<?php echo $cid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            </div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Discount Successfully applied!!!</div>
            <?php }
			
							$discountlist=mysql_query("SELECT * FROM discount_others WHERE d_id=$did"); 
								  $discount=mysql_fetch_array($discountlist);
								  $id=$discount['ss_id'];
								  $totalamount=$discount['total'];
								  $cdate=$discount['cdate'];
            if($id){
				$studentlist=mysql_query("SELECT * FROM student WHERE ss_id='$id' AND ay_id=$acyear"); 
								  $student=mysql_fetch_array($studentlist);
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $latejoin=$student['late_join'];
								  
								  $fdisid1=$student['fdis_id'];
								  
								  $scateg=$student['scateg'];
								  $sfood=$student['sfood'];
								  if($scateg=='1'){
									  $rate="rate1";
								  }else{
									  $rate="rate";
								  }
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }		
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $row1=mysql_fetch_array($qry1);
								  ?>
          <form id="validate-form" class="block-content-invoice form" action="" method="post">
				<div id="invoice" class="widget widget-plain" class="widget-content">	
				<ul class="client_details">
					<li><strong class="name">Admission No : <?php echo $student['admission_number'];?></strong></li>
                    <li>Class: Class -section: <?php echo $class1['c_name']."-".$row1['s_name'];?></li>
					<li>Gender: <?php if($student['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $student['firstname']." ".$student['lastname'];?></strong> </li>
					<li>Parent's Name: <?php echo $student['fathersname'];?> </li>
					<li>Student Type : <b><?php echo $student['stype'];?></b> Student </li>
				</ul>
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong></li>
                    
                    <li><strong>Date : <?php echo $cdate;?> </strong> </li>              										
				</ul>
                    <?php 
							$classlist=mysql_query("SELECT * FROM frate WHERE fr_id=$frid");
								  $class=mysql_fetch_array($classlist);	
								  $fg_id1=$class['fg_id'];
							?>
					   <table id="table-example" class="table">
							<thead>
								<tr>
									<th width="5%">S.No</th>
                                    <th><center>Group Name</center></th>
                                    <th>Total</th>
                                    <th>Discount</th>
                                    <th>Status</th>
								</tr>
							</thead>
							<tbody>

                            <tr style="border:1px #B7B7B7 dotted;">
                                    <td><?=$count?></td>
                                    <td><?php echo 'Books, Notes & Other Items';?></td>
                                    <td> 
                                    <?php 
                         				$cid=$class1['c_id'];
                         				$fratelist=mysql_query("SELECT amount FROM others_bill_all WHERE std=$cid");
										$frate=mysql_fetch_array($fratelist)['amount'];
										echo $frate;
									
                                    ?></td>
                                    <td style="vertical-align: middle;">
                                    <?php
                                    	$ss_id=$student['ss_id'];
                                    	$discount=mysql_query("SELECT * FROM discount_others WHERE d_id=$did");

                                    	
                                    	$amt=0;
                                    	while ($ans=mysql_fetch_assoc($discount)) {
                                    		$amt+=$ans['total'];
                                    	}
                                    	$percent=($amt/$frate)*100;
                                    	echo $amt.' ('.round($percent,2).'% )';
                                    	$discount1=mysql_query("SELECT * FROM discount_others WHERE d_id=$did");
                                    	$status=mysql_fetch_array($discount1);
                                    	?>
                                    </td>
                                    <td style="vertical-align: middle;"><center><?php 
                                    $payment=$status['status'];
                                    if($payment=='0'){ ?>
                                <button class="btn btn-small btn-warning" >Process</button><?php }else{?><button class="btn btn-small btn-success" >Completed</button> <?php } ?>
                                </center></td>
                            </tr>
                             <tr class="">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Remark:</td>
							<td class="grand_total1"><span><?= $status['remark']?></span></td>
                           
						    </tr>

                             <tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total1">Rs. <span id="fgtotal"><?=number_format($totalamount,2)?></span><input type="hidden" class="medium" name="total" id="finaltotal" value="<?=$totalamount?>"/></td>
                           
						    </tr>
						    <tr>
                             <td colspan="5" align="right">
                <span id="billpay" style="float:right">
                <input class="btn btn-green" type="submit" style="width:120px" onclick="window.open('discount_prt_others.php?did=<?= $did?>&bid=<?= $bid?>')" name="Print" value="Print Discount">
                </td>
                             </tr>
<!-- *************************** Old Student Total End ************************** -->
							</tbody>
						</table>
                  </form>
				</div>
                <?php } ?>
			</div>
            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

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
			location.reload(); 			
		});	
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	function currencyFormat (num) {		
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	$(".txt").each(function() { 
            $(this).keyup(function(){
				var textBoxVal=0;
				var allInputs = document.getElementsByClassName("txt");
				//alert(allInputs.length);
				for (var i = 0; i < allInputs.length; i++)
				   if (allInputs[i].type === "text") {
					   var fvalue=allInputs[i].value;
					   textBoxVal = Number(fvalue)+textBoxVal;
				   } 
				   
				   textBoxVal1=currencyFormat(textBoxVal);
				   $("#fgtotal").html(textBoxVal1);
				   $("#finaltotal").val(textBoxVal);
				//alert(textBoxVal);
               //$('#billupdate').show();
			   //$('#billpay').hide();
            });
        });	
	});
	
	function change_function1() { 
     var cid =document.getElementById('cid').value;
	  window.location.href = 'discount_edit_others.php?cid='+cid+'&bid=<?php echo $bid;?>';	  
}
function change_function2(n){ 
		 window.location.href = 'discount_edit_others.php?bid=<?php echo $bid;?>&cid=<?php echo $cids;?>&id='+n;
		 	  
		}
  </script>
  
  <?php if(!$id){?>
   <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
   <script src="js/jquery-migrate-1.2.1.js"></script>
  	  <link rel="stylesheet" href="library/js/plugins/select2/select2.css" type="text/css" />
  	  <script src="library/js/plugins/select2/select2.js"></script> 
      <script type="text/javascript">
$().ready(function() {	

	 $('#n_sid').select2 ({
			allowClear: true,
			placeholder: "Please Select..."
		})  
		$('#o_sid').select2 ({
			allowClear: true,
			
			placeholder: "Please Select..."
		})  
		});
		</script>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php } ?>
</body>
</html>
<? ob_flush(); ?>