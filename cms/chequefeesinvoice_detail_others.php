<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
 $bid=$_GET['bid'];
 $ffi_id=$_GET['fiid'];
 if(isset($_POST['place-order'])){
	 $id=$ffi_id;
     $ptype=$_POST["ptype"];
	 $baid=$_POST["baid"]; 
     $pay_number=$_POST["pay_number"];
     $c_status=$_POST["c_status"];
     $cdate=$_POST['receive_cdate'];
	 $cbank=$_POST['receive_cbank'];
     if($c_status==""){
         $c_status=0;
     }
     if($ptype=="cash")
     {
         $pay_number="";
         $c_status="0";
		 $baid="0";
     }elseif($ptype=="card")
     {   
         $c_status="0";
    }else{
    }
	$invoicelist=mysql_query("SELECT * FROM finvoice_others WHERE fi_id=$id"); 
			  $exbill=mysql_fetch_array($invoicelist);
			$oldamount=$exbill['fi_total'];
			$oldcstatus=$exbill['c_status'];
			$ba_id=$exbill['ba_id'];
     $qry1=mysql_query("UPDATE finvoice_others  SET fi_ptype='$ptype',ba_id='$baid',pay_number='$pay_number',c_status='$c_status',receive_cdate='$cdate',receive_cbank='$cbank'  WHERE fi_id='$id'") or die(mysql_error());
	 if($c_status=='1'){
		 $qry5=mysql_query("SELECT dv_id FROM fsalessumarry WHERE fi_id=$id AND dv_id");
							  while($row5=mysql_fetch_array($qry5))
								{
									$dvid=$row5['dv_id'];
									$qry2=mysql_query("UPDATE discount_value SET payment='0' WHERE dv_id='$dvid'");
									 
								}
	 }else{
		  $qry5=mysql_query("SELECT dv_id FROM fsalessumarry WHERE fi_id=$id AND dv_id");
							  while($row5=mysql_fetch_array($qry5))
								{
									$dvid=$row5['dv_id'];
									$qry2=mysql_query("UPDATE discount_value SET payment='1' WHERE dv_id='$dvid'");
									 
								}
	 }
	 if($qry1){
		 if($c_status=='2'){
			 
			 $date=$_POST['debited_date'];
	$date_split1= explode('/', $date);
		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
		 
			if($c_status!=$oldcstatus){
		$classlist1=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
		  $class1=mysql_fetch_array($classlist1);
			$acc_no=$class1['account_no'];
			$b_name=$class1['b_name'];
			$baid1=$class1['ba_id'];
			$amount=$oldamount;
$sql="INSERT INTO bank_deposit (date,date_day,date_month,date_year,account_no,b_name,deposit_by,amount,ba_id,ay_id,type,fi_id) VALUES
('$date','$date_day','$date_month','$date_year','$acc_no','$b_name','Fees Cheque Pay','$amount','$baid','$acyear','1','$id')";
$result1 = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
			$accountamount=$class1['amount'];
			$accountcash=$accountamount+$amount;
			  $cashqry=mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$baid1");
			}else{
				$cashqry=mysql_query("UPDATE bank_deposit SET date='$date',date_day='$date_day',date_month='$date_month',date_year='$date_year' WHERE fi_id='$id' AND ba_id=$ba_id");
			}
		}else{
			if($oldcstatus=='2'){
				$delete1="Delete from bank_deposit where fi_id='$id' AND ba_id='$ba_id'";
				$result2=mysql_query($delete1);
				$classlist1=mysql_query("SELECT * FROM bank_account WHERE ba_id=$ba_id"); 
				$class1=mysql_fetch_array($classlist1);
				$amount=$oldamount;
				$accountamount=$class1['amount'];
				$accountcash=$accountamount-$amount;
				  $cashqry=mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$ba_id");
			}
		}
	 }
    header("location:chequefeesinvoice_detail_others.php?fiid=$id&bid=$bid&msg=dsucc");
     
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
                <li class="no-hover"><a href="board_select_feesinvoice.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="cheque_feesinvoice.php?bid=<?php echo $bid;?>" title="Fees Payment">Cheque Fees Paymant </a></li> 
                <li> Cheque Fees Invoice Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
			
            <a href="cheque_feesinvoice_others.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
				
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Invoice Successfully Updated !!!</div>
                 <?php } ?>   
				<h1>Cheque Fees Invoice Details</h1>
                <form id="validate-form" class="block-content form" action="" method="post">
                      <input type="hidden" name="id" value="<?=$ffi_id?>">
                <div id="invoice" class="widget widget-plain">			
				        <br>
                
               <?php 
						
						$invoicelist1=mysql_query("SELECT * FROM finvoice_others WHERE fi_id=$ffi_id"); 
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
					<li>Parent's Name: <?php echo $student1['fathersname'];?></li>
                    <li> Student Type : <?php echo $invoice['stype'];?> Student</li>										
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info" style="background-color:#D75334">Closed</span></li>
					<li><strong>Invoice Date :</strong> <?php echo $invoice['fi_day']."/".$invoice['fi_month']."/".$invoice['fi_year'];?></li>                </ul>				
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
                    
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo 'Books, Notes & Other Items'?></center></td>
							<td class="total"><?php echo number_format($invoice['fi_total'],2);?></td>
                            <!--<td><a href=""><img src="Book_inventory/images/del.png" alt="delete"></a></td>-->
                        </tr>
                        
						
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
							<td colspan="7" align="right">Payment Type : <strong><?php echo $invoice['fi_ptype'];?></strong></td>
                      
                      <?php //if($invoice['fi_ptype']=="cheque")
                      //{
						  $c_status=$invoice['c_status'];
						  $ptype=$invoice['fi_ptype'];
						  $baid=$invoice['ba_id'];?>
                        <tr>
							<td colspan="7" align="right" class="block-content form"> 
							<div class="_25">
                                    <p>
                                    <label for="textfield">Payment Type:</label>
										<select name="ptype" id="ptype" class="required" onchange="paymet_type()">
											<!--<option value="">Please select</option>-->
                                            <?php if($c_status!='2'){ ?>
                                            <!--<option value="cash" <?php //if($ptype=='cash'){ echo 'selected="selected"';}?>>Cash</option>	
                                            <option value="card" <?php //if($ptype=='card'){ echo 'selected="selected"';}?>>Card</option>-->
                                            <?php } ?>
                                            <option value="cheque" <?php if($ptype=='cheque'){ echo 'selected="selected"';}?>>cheque</option>								
										</select>	
                                        </p>									
									</div>
                                    <div id="ajax_pay">
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Bank Name </label>
                                        <input  name="receive_cbank" id="cbank" type="text" value="<?php echo $invoice['receive_cbank']?>" />
                                    </p>
                                    </div>
                                    <div class="_25"><p>
                                <label for="textfield">Cheque Number </label>
                                <input type="text" value="<?=$invoice['pay_number']?>" class="required"  name="pay_number" id="textfield">
                            </p></div>
                            <div class="_25">
                                    <p>
                                        <label for="textfield">Cheque Date </label>
                                       
                                        <input  name="receive_cdate" id="cdate"  type="text" style="width: 206px;" value="<?php echo $invoice['receive_cdate']?>" />
                                    </p>
                                    </div>
                            <span id="pstatus">
                            <?php 
							if($baid){ 
							$banklist1=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
								  $bank=mysql_fetch_array($banklist1);?>
                            <div class="_25">
                            <p>
                             <label for="textfield">Bank Account:</label>
                            	<?php 
								  
									$classl = "SELECT * FROM bank_account";
                                            $result1 = mysql_query($classl) or die(mysql_error());
								echo '<select name="baid" id="baid" class="required">';
										if($baid && $c_status!='2'){
											echo "<option value=''>Select Account</option>";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($baid ==$row1['ba_id']){
                                                echo "<option value='{$row1['ba_id']}' selected>{$row1['name']} - {$row1['account_no']}</option>\n";
												} else {
												echo "<option value='{$row1['ba_id']}'>{$row1['name']} - {$row1['account_no']}</option>\n";
												}
										    endwhile;
										}else{
											echo "<option value='{$baid}'>{$bank['name']} - {$bank['account_no']}</option>\n";
										}
                                            echo '</select>';
											?>
                                            </p>
                            </div>
                            <?php } ?>
                            <div class="_25"><p>
                                <label for="textfield">Status </label>
                               <select name="c_status" id="c_status"  class="required" onchange="process_type()">
											 
											<option value="0" <?php if($c_status=='0'){ echo "selected";}?>>Process</option>
											 <option value="1" <?php if($c_status=='1'){ echo "selected";}?>>Bounce</option>
                                            <option value="2" <?php if($c_status=='2'){ echo "selected";}?>>Paid</option>	
                                           
                                             								
										</select>
                            </p></div>
                            
									
                            </span>
                            <div class="_25" id="acdetails" style="display: none;">
							<p>
                       <label for="textfield">Account Details<span class="error">*</span></label>
                        <?php 
						$classl = "SELECT * FROM bank_account";
                                            $result1 = mysql_query($classl) or die(mysql_error());
								echo '<select name="baid" id="baid" class="required">';
											echo "<option value=''>Select Account</option>";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($baid ==$row1['ba_id']){
                                                echo "<option value='{$row1['ba_id']}' selected>{$row1['name']} - {$row1['account_no']}</option>\n";
												} else {
												echo "<option value='{$row1['ba_id']}'>{$row1['name']} - {$row1['account_no']}</option>\n";
												}
										    endwhile;
                                            echo '</select>';
											?>
                            </p>
						</div>
                            <div id="debitdate">
                                    </div>
                            
									</div>
									</td>
						</tr>
						<?php //}?>
                        <?php 
			  $depositlist=mysql_query("SELECT * FROM bank_deposit WHERE fi_id=$ffi_id"); 
								  $deposit=mysql_fetch_array($depositlist); 
								  ?>
				<tr>
                <td colspan="6" style="background:none;">
                 <?php if($invoice['fi_ptype']=="cheque") {?>  <input type="submit" value="Update Cheque Status" name="place-order"  class="btn btn-green" style="width:190px">&nbsp;&nbsp; <?php }?>
                
               <input type="button" value="Print Invoice" name="Print" onClick="window.open('finvoice_prt_others.php?fiid=<?php echo $ffi_id; ?>', '_blank');" class="btn btn-green" style="width:120px">&nbsp;&nbsp;
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
  
  <script>
  $(document).ready(function() {
		var validateform = $("#validate-form1").validate();
		$( "#c_status" ).change(function() {
  if($(this).val()==2){
  	$('#acdetails').show();
  } else{
  	$('#acdetails').hide();
  }
});
		$("#cdate" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
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
			  
  function process_type() {
			var x = document.getElementById("c_status").value;
			$.get("expayment_type.php",{feecheck:x,date:'<?=$deposit['date']?>'},function(data){
				$( "#debitdate" ).html(data);
				
			});	
		}
		process_type();
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