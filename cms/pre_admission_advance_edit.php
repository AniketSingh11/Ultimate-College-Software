<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 //echo $acyear;
  $ffi_id=$_GET['id'];
  $bid=$_GET['bid'];
 $montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 
if (isset($_POST['place-order']))
{
	   $ptype=$_POST['ptype'];
	   
	   $idate=$_POST['idate'];
	   $idatesplit=explode("/",$idate);  
	    $day=$idatesplit[0]; 
	    $month=$idatesplit[1];
	    $year=$idatesplit[2];
		
		$cdate=$year."-".$month."-".$year;
		
		$pay_number=$_POST['pay_number'];
		
	   $bank_name=$_POST['bank_name'];
	   $cheque_date=$_POST['cheque_date'];
	   $status=$_POST['status'];
		
	  //$seid=$_POST['se_id'];
	   $advance=$_POST['advance'];
	   
	  
	  $qry1=mysql_query("UPDATE pre_admission_advance  SET cdate='$cdate',cday='$day',cmonth='$month',cyear='$year',ptype='$ptype',pay_number='$pay_number',pay_number='$pay_number',bank_name='$bank_name',cheque_date='$cheque_date',status='$status',amount='$advance'  WHERE id='$ffi_id'") or die(mysql_error());
if($qry1){
			header("location:pre_admission_advance_edit.php?id=$ffi_id&bid=$bid&msg=succ");	
}
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
		
		$cids=$_GET['cid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT b_id FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT b_name,b_id FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="pre_admission_advance.php" title="<?php echo $board['b_name'];?>">Pre Admission Advance Payment</a></li>
				<li class="no-hover">Pre Admission Advance Payment</li> 
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1><a href="pre_admission_advance.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Pre Admission Advance Payment</h1>
                <?php $msg=$_GET['msg'];
				if($msg=="succ"){?>
                <div class="alert success"><span class="hide">x</span>Your Invoice Successfully Edited !!!</div>
                 <?php } ?>  
                <?php 
								  
								  $invoicelist1=mysql_query("SELECT * FROM pre_admission_advance WHERE id=$ffi_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
								  
								 	
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT c_name FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT s_name FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $amount=$invoice['amount'];
							?>
				         <br>
                <form name="form1" method="post" action="" id="validate-form" class="block-content-invoice form">
<input type="hidden" name="pid" />
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="command" />
                <?php 
				  
				  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
				  $row=mysql_fetch_array($qry);
				  
				  $ptype=$invoice['ptype'];
				  $status=$invoice['status'];
				  			  ?>
						
						<div id="invoice" class="widget widget-plain">				
				<ul class="client_details">
					<li><strong class="name">Rec No : <?php echo $invoice['rec_no'];?></strong></li>
                    <li>Class: <?php echo $row['c_name'];?></li>
					<li>Gender: <?php if($invoice['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $invoice['name'];?></strong></li>
					<li>Admission No: <?php echo $invoice['pre_admin'];?></li>
					<li>Father Name: <?php echo $invoice['fname'];?></li>					
				</ul>
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $invoice['a_year'];?></strong></li>
                    <li>Phone No: <?php echo $invoice['phone'];?></li>									
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info" style="background-color:#D75334">Closed</span></li>
					<li><strong>Invoice Date :</strong> <input id="datepicker" name="idate" type="text" value="<?php echo $invoice['cday']."/".$invoice['cmonth']."/".$invoice['cyear'];?>"  style="width:60%"/></li>                </ul>						
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th width="5%">S.No</th>
							<th><center>Fees Group Name</center></th>
							<th class="total">Total</th>
						</tr>
					</thead>						
					<tbody>
                    		<td>1</td>
                            <td><center>Advance Payment</center></td>
							<td class="total" width="120"><?php $samount=number_format($s,2);?></span>
                                   <input type="text" name="advance" id="advance" class="biginput txt required" id="autocomplete" autocomplete="off" value="<?=$amount?>"/>									
							  </td>
                            </tr>
						<tr>
							<td class="sub_total" colspan="1"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <span id="fstotal"><?=$amount?></span></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="1"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <span id="fgtotal"><?=$amount?></span><input type="hidden" class="medium" name="total" id="finaltotal" value="<?=$amount?>"/></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">	
									<div class="_25">
                                    <p>
                                    <label for="textfield">Payment Type:</label>
										<select name="ptype" id="ptype" class="required" onchange="paymet_type()">
                                            <option value="cash" <?php if($ptype=='cash'){ echo 'selected="selected"';}?>>Cash</option>	
                                            <option value="card" <?php if($ptype=='card'){ echo 'selected="selected"';}?>>Card</option>
                                            <option value="cheque" <?php if($ptype=='cheque'){ echo 'selected="selected"';}?>>cheque</option>								
										</select>
                                        </p>										
									</div>
                                    <div id="ajax_pay">
									</div>
                                    <div class="_25" id="pstatus"><p>
                                <label for="textfield">Status </label>
                               <select name="status" id="status"  class="required">
											 
											<option value="0" <?php if($status=='0'){ echo "selected";}?>>Process</option>
											 <option value="1" <?php if($status=='1'){ echo "selected";}?>>Closed</option>
                                            <option value="2" <?php if($status=='2'){ echo "selected";}?>>Returned</option>	
                                           
                                             								
										</select>
                            </p></div>
                                    </td>
						</tr>
				<tr>
                <td colspan="6" align="right">
                 <span id="billpay">
                <input type="submit" value="Submit" name="place-order" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px">
                </span>
                </td>
                </tr>
					</tbody>
				</table>
				
				<hr>
			</div>
            </form>
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
  <script defer src="js/zebra_datepicker.js"></script>
  
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php if(!$_GET['roll']){ include("pre_adminssion_auto.php"); }?>
<script type="text/javascript">
$().ready(function() {
	var validateform = $("#validate-form").validate();
    function languageChange()
    {
         var lang = $('#fgroup option:selected').val();
        return lang;
    }
	$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });
	function currencyFormat (num) {		
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	$(".txt").each(function() { 
            $(this).keyup(function(){
				var textBoxVal=Number(this.value);
				textBoxVal1=currencyFormat(textBoxVal);
				   $("#fgtotal").html(textBoxVal1);
				   $("#fstotal").html(textBoxVal1);
				   $("#finaltotal").val(textBoxVal1);
				//alert(textBoxVal);
               //$('#billupdate').show();
			   //$('#billpay').hide();
            });
        }); 	
});
function paymet_type() {
			var x = document.getElementById("ptype").value;
			if(x != "cash"){
				$('#cash_pay').hide();
			}else{
				$('#cash_pay').show();
			}
			$.get("pre_payment_type.php",{value:x,epid:<?=$ffi_id?>},function(data){
			$( "#ajax_pay" ).html(data);
			});	
		}
		paymet_type()
function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'pre_admission_advance_pay.php?bid='+cid;	  
	}
	function change_function2() { 
     var cid =document.getElementById('cid').value;
	 window.location.href = 'pre_admission_advance_pay.php?bid=<?php echo $bid;?>&cid='+cid;	  
	}
	function cancel_cart(){
		if(confirm('This will cancel your Bill, continue?')){
			window.location.href = 'pre_admission_advance_pay.php?bid=<?php echo $bid;?>';	
		}
	}
</script>
</body>
</html>
<? ob_flush(); ?>