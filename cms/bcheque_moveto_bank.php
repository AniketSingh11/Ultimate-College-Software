<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$baid=mysql_real_escape_string($_POST['baid']);
	$date=$_POST['debited_date'];
	$date_split1= explode('/', $date);
		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
		//$msg1=str_replace(' ','%20',$msg); 
			 foreach ($_POST['ms_example'] as $selectedOption)
    { 
	 $bfiid=$selectedOption;
	 $invoicelist1=mysql_query("SELECT * FROM bfinvoice WHERE bfi_id=$bfiid"); 
								  $invoice=mysql_fetch_array($invoicelist1);
								  $oldamount=$invoice['fi_total'];
	 $cashqry=mysql_query("UPDATE bfinvoice SET ba_id='$baid',c_status='2' WHERE bfi_id=$bfiid");
	 
	 $classlist1=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
		  $class1=mysql_fetch_array($classlist1);
			$acc_no=$class1['account_no'];
			$b_name=$class1['b_name'];
			$baid1=$class1['ba_id'];
			$amount=$oldamount;
$sql="INSERT INTO bank_deposit (date,date_day,date_month,date_year,account_no,b_name,deposit_by,amount,ba_id,ay_id,type,bfi_id) VALUES
('$date','$date_day','$date_month','$date_year','$acc_no','$b_name','Bus Fees Cheque Pay','$amount','$baid','$acyear','1','$bfiid')";
$result1 = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
			$accountamount=$class1['amount'];
			$accountcash=$accountamount+$amount;
			  $cashqry=mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$baid1");
	}
	$msg2="succ";
}
	
if(empty ($buffer))
{
    // echo " buffer is empty ";
}else{
}
?>
 <link href="css/multiselect/multiselect.css" rel="stylesheet" type="text/css" />
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
         <?php $bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);		
		?>
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="bchequeinvoice.php" title="Cheque Fees Payment">Cheque Fees Payment</a></li>
                <li class="no-hover">Fees Cheque Payment Move To Bank Account:</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Fees Cheque Payment Move To Bank Account:</h1>                
			<a href="bchequeinvoice.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg2=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Cheque Successfully Moved!!!</div>
            <?php }
			if($error){?>			
            <div class="alert error"><span class="hide">x</span><?php echo $error;?></div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>SMS To Specific Staff</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_100">
                    <p>
                    	<select name="ms_example[ ]" multiple="multiple" id="msc" class="required">
                            <?php
							
                            $select_record1=mysql_query("SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear and fi_ptype='cheque' AND i_status='0' AND ba_id='0'");
							$nofcheque=mysql_num_rows($select_record1);
							$succ="";
							$error="";
							while($queryfetch1=mysql_fetch_assoc($select_record1))
							{ 
							$ssid=$queryfetch1['ss_id'];
							$studentlist=mysql_query("SELECT admission_number FROM student WHERE ss_id=$ssid"); 
							  $student=mysql_fetch_array($studentlist);	?>
                                            <option value="<?php echo $queryfetch1['bfi_id'];?>"><?php echo $student['admission_number']."/Cheque No: ".$queryfetch1['pay_number']." - Cash:".$queryfetch1['fi_total']." Rs/-";?></option>
                              <?php } ?>
                                        </select>
                                        <div class="btn-group">
                                            <span class="button blue" id="ms_select">Select all</span>
                                            <span class="button blue" id="ms_deselect">Deselect all</span>
                  						</div>
                                        No of Unmove Cheques : <?=$nofcheque?>
                                      </p>  
						</div>
						<div class="_25">
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
                        <div class="_25"><p>
                                <label for="textfield">Debited Date</label>
                                <input id="datepicker1" name="debited_date" class="required" type="text" value="" />
                            </p></div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
   <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
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
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });		
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachNEWS('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
 <script src="js/jquery-migrate-1.2.1.js"></script>
  <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
<script type="text/javascript">
$().ready(function() {		
		if($("#msc").length > 0){
        $("#msc").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
            selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
            afterSelect: function(value, text){
                //action
            },
            afterDeselect: function(value, text){
                //action
            }            
        });        
        $("#ms_select").click(function(){
            $('#msc').multiSelect('select_all');
        });
        $("#ms_deselect").click(function(){
            $('#msc').multiSelect('deselect_all');
        });        
    }    	
	});
	</script>
  
</body>
</html>
<? ob_flush(); ?>