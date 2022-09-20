<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 //echo $acyear;
 $montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 
if (isset($_POST['place-order']))
{
	   $recno=$_POST['rec_no'];
	   $ptype=$_POST['ptype'];
	   $paid=$_POST['paid'];
	   $ss_name=$_POST['ss_name'];
	   $father=$_POST['father'];
	   $adminid=$_POST['adminid'];
	   $phone=$_POST['phone'];
	   $cid1=$_POST['cid1'];
	   $sid1=$_POST['sid1'];
	   
	   $idate=$_POST['idate'];
	   $idatesplit=explode("/",$idate);  
	    $day=$idatesplit[0]; 
	    $month=$idatesplit[1];
	    $year=$idatesplit[2];
		
		$cdate=$year."-".$month."-".$year;
		
		$pay_number=$_POST['pay_number'];
		$gender=$_POST['gender'];
	   
	   $bank_name=$_POST['bank_name'];
	   $cheque_date=$_POST['cheque_date'];
		
	  //$seid=$_POST['se_id'];
	   $advance=$_POST['advance'];
	   $bid1=$_POST['bid1'];
	   $qry31=mysql_query("SELECT * FROM mfinvoice_no WHERE id='2'"); 
								  $row31=mysql_fetch_array($qry31);
								  $invoice_no=$row31['count'];
	  
	 
	 $sql="INSERT INTO pre_admission_advance (rec_no,pa_id,pre_admin,name,fname,phone,cdate,cday,cmonth,cyear,cby,gender,ptype,pay_number,bank_name,cheque_date,c_id,s_id,b_id,ay_id,amount,a_year) VALUES
('$recno','$paid','$adminid','$ss_name','$father','$phone','$cdate','$day','$month','$year','$user','$gender','$ptype','$pay_number','$bank_name','$cheque_date','$cid1','$sid1','$bid1','$acyear','$advance','$acyear_name')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid = mysql_insert_id();
if($result){
			 $inovoice=$invoice_no+1;
			$qry1=mysql_query("UPDATE finvoice_no SET count='$inovoice' WHERE id='2'");
			header("location:pre_admission_advance_paid.php?id=$lastid&bid=$bid1");	
}
die();
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
		$bid=$_GET['bid'];
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
            		<div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
                 <div class="_25" style="float:right">
                <label for="select">Standard</label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="change_function2()"> <option value="">All</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($cids==$row1['c_id']){
                                                echo "<option value='{$row1['c_id']}' selected>{$row1['c_name']}</option>\n";
												} else {
												echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
				<h1><a href="pre_admission_advance.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Pre Admission Advance Payment</h1>
                <?php if($_GET['roll']){
					
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];
					//die();
					
				  $studentlist=mysql_query("SELECT * FROM pre_admission WHERE pa_admission_no LIKE '$rollno' AND ay_id=$acyear"); 
				  $student=mysql_fetch_array($studentlist);
				  $ssid=$student['pa_id'];
				  $ss_gender=$student['gender'];
				  $cid=$student['c_id'];
				  $sid=$student['s_id'];
				  if(!$student){
						header("location:pre_admission_advance_pay.php?bid=$bid");
					}
							?>
				         <br>
                <form name="form1" method="post" action="" id="validate-form" class="block-content-invoice form">
<input type="hidden" name="pid" />
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="command" />
                <?php 
				//$ssid=$_GET['ss_id'];
				  $studentlist1=mysql_query("SELECT * FROM pre_admission WHERE pa_id=$ssid"); 
				  $student1=mysql_fetch_array($studentlist1);
				  $cid1=$student1['c_id'];
				  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
				  $row=mysql_fetch_array($qry);
				  
				  $sid1=$student1['s_id'];
				  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
				  $row1=mysql_fetch_array($qry1);
				  
				  $qry3=mysql_query("SELECT * FROM finvoice_no WHERE id='2'"); 
				  $row3=mysql_fetch_array($qry3);
				  $invoice_no=$row3['count'];
				  			  ?>
						
						<div id="invoice" class="widget widget-plain">				
				<ul class="client_details">
					<li><strong class="name">Rec No : <?php echo $invoice_no;?></strong><input type="hidden" class="medium" name="rec_no" value="<?php echo $invoice_no;?>"/></li>
                    <li>Class: <?php echo $row['c_name'];?><input type="hidden" class="medium" name="cid1" value="<?php echo $cid;?>"/></li>
					<li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?><input type="hidden" class="medium" name="bid1" value="<?php echo $bid;?>"/><input type="hidden" class="medium" name="gender" value="<?php echo $student1['gender'];?>"/></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $student1['firstname']." ".$student1['lastname'];?></strong> <input type="hidden" class="medium" name="ss_name" value="<?php echo $student1['firstname']." ".$student1['lastname'];?>"/></li>
					<li>Admission No: <?php echo $student1['pa_admission_no'];?> <input type="hidden" class="medium" name="adminid" value="<?php echo $student1['pa_admission_no'];?>"/></li>
					<li>Father Name: <?php echo $student1['fathersname'];?><input type="hidden" class="medium" name="father" value="<?php echo $student1['fathersname'];?>"/></li>					
				</ul>
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong><input type="hidden" class="medium" name="paid" value="<?php echo $ssid; ?>"/></li>
					<li>Phone No: <?php echo $student1['phone_number'];?> <input type="hidden" class="medium" name="phone" value="<?php echo $student1['phone_number'];?>"/></li>
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info">Open</span></li>
					<li><strong>Invoice Date :</strong> <input id="datepicker" name="idate" type="text" value="<?php echo date("d/m/Y");?>"  style="width:60%"/></li>                   
				</ul>				
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
                                   <input type="text" name="advance" id="advance" class="biginput txt required" id="autocomplete"/>									
							  </td>
                            </tr>
						<tr>
							<td class="sub_total" colspan="1"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <span id="fstotal"></span></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="1"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <span id="fgtotal"></span><input type="hidden" class="medium" name="total" id="finaltotal" value=""/></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">	
									<div class="_25">
                                    <p>
                                    <label for="textfield">Payment Type:</label>
										<select name="ptype" id="ptype" class="required" onchange="paymet_type()" >
											<option value="cash">Cash</option>	
                                            <option value="card">Card</option>
                                            <option value="cheque">cheque</option>									
										</select>
                                        </p>										
									</div>
                                    <div id="ajax_pay">
									</div>
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
		<?php } else { 
		?>
        <div class="field-group">
                            <form id="validate-form" class="block-content form" method="get" action="">
                            <div class="_75">
                            <p>
                            <label for="required">Student Pre Admin No:</label>
                            <input type="text" name="roll" class="biginput" id="autocomplete" /> 
                            </p>
                            </div>
                            <div class="_25">
                            <p style="margin-top:25px;">
                            <input name="bid" value="<?php echo $bid;?>" type="hidden" />
                            <button type="submit" name="" class="btn btn-error">Submit</button>
                             </p>
                            </div>
                            </form>											
                        </div> <!-- .field-group -->        
        <?php  } ?>
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
			$.get("payment_type.php",{value:x},function(data){
			$( "#ajax_pay" ).html(data);
			});	
		}
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