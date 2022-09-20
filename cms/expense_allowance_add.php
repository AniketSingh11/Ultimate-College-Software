<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname']; 
 if (isset($_POST['submit']))
{
		 
	$idtype=explode(",",$_POST['driver_id']);
	
	$id=$idtype[0];
	$name=$idtype[1];
	$type=$idtype[2];
	
	
	$fromdate=$_POST['from_date'];
	$date_split1=explode('/', $fromdate);

	$from_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
	$todate=$_POST['to_date'];
	$date_split1=explode('/', $todate);
	$to_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
	
	$cdate=$_POST['cdate'];
	$date_split1=explode('/', $cdate);
	$c_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
	
	$working_days=$_POST['num_days'];
	$perday_amount=$_POST['p_amount'];
	$total_amount=$_POST['amount'];
	$date=date("Y-m-d");
	 
	
	$loss_days=$_POST['lnum_days'];
	
	$receiptlist=mysql_query("SELECT * FROM exp_allowance_count"); 
								  $receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno1=$receiptcount['count'];
								 
								  $receiptno2=$receiptno1+1;
								  
								 $receiptno="AL".str_pad($receiptno1, 5, '0', STR_PAD_LEFT);
		
	$sql="INSERT INTO exp_allowance (receipt_no,id,cdate,name,type,from_date,to_date,working_days,perday_amount,total_amount,ay_id,date,loss_days,bill_by) VALUES
('$receiptno','$id','$c_date','$name','$type','$from_date','$to_date','$working_days','$perday_amount','$total_amount','$acyear','$date','$loss_days','$user')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	if($result){
		$sql1=mysql_query("UPDATE exp_allowance_count SET count='$receiptno2' WHERE id='1'");
     $msg="succ";    
	}
}

 ?>
</head>

<body id="top">
  <link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
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
							$excid=$_GET['excid'];
							 
								  
								   $receiptlist=mysql_query("SELECT * FROM exp_allowance_count"); 
								  $receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno=$receiptcount['count'];
								  
								 $receiptno="AL".str_pad($receiptno, 5, '0', STR_PAD_LEFT);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				 
                <li class="no-hover">Add Daily Allowance Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add Daily Allowance Details</h1>                
			<a  href="expense_allowancelist.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add Daily Allowance Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                        <div class="_25">
                                <p>
                                    <label for="textfield">Date  <span class="error">*</span></label>
                                    <input id="datepicker3" name="cdate" autocomplete="off" class="required" type="text" readonly value="<?=date("d/m/Y")?>"  />
                                </p>
                            </div>
                    	 <div class="_25">
							<p>
                                <label for="textfield">Receipt No <span class="error">*</span></label>
                                <input id="textfield" name="r_no" class="required" type="text" value="<?php echo $receiptno;?>" readonly />
                            </p>
						</div>
                         <div class="_50">
                                    <p>
                                        <label for="textfield">Select Member </label>
                                        <select name="driver_id"  class="required form-control select2-input" id="sibling" style="width:100%">
										<option value="">Please Select</option> 
                                        <?php
											$sql = mysql_query("SELECT others_id as id,fname,lname,'others' as source FROM `others` union SELECT driver_id,fname,lname,'driver' as source FROM `driver` union SELECT staff_id,fname,lname,'staff' as source FROM `staff` ");
											while ($thisrow = mysql_fetch_array($sql)){	
											    $stype=$thisrow['source'];
                                               if($stype=="others"){
                                                   $qry2=mysql_fetch_array(mysql_query("select * from others where others_id='$thisrow[id]'"));
                                                  
											  $qry1=mysql_fetch_array(mysql_query("select * from others_category where oc_id='$qry2[category_id]'"));
											  $stype=$qry1["category_name"];
											  
                                               }
											$sname=$thisrow['fname']." ".$thisrow['lname'];?>
									  <option value="<?php echo $thisrow['id'].",".$sname.",".$stype;?>"><?php echo $thisrow['id']."-".$sname." - ".$stype;?></option>  
                                        <?php } ?>
									</select>
                                    </p>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="_25"  >
                                        <p >
                                            <label for="textfield">From Date  <span class="error">*</span></label>
                                            <input id="datepicker" name="from_date" autocomplete="off"  class="required" type="text" readonly  />
                                        </p>
                                     </div>
                                  <div class="_25">
                                    <p>
                                        <label for="textfield">To Date  <span class="error">*</span></label>
                                        <input id="datepicker1" name="to_date" autocomplete="off" class="required" type="text" readonly />
                                    </p>
                                </div>
						
						 <div class="_25">
							<p>
                                <label for="textfield">Number of Total Days<span class="error">*</span></label>
                                <input  name="num_days"  id="num_days"   readonly class="digits" type="text"  />
                            </p>
						</div>
						
						<div class="_25">
							<p>
                                <label for="textfield">Number of Loss Days<span class="error">*</span></label>
                                <select  name="lnum_days" onChange="count_days()" id="lnum_days"  >
                                <option value='0'>0</option>
                                </select>
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Per Day Allowance Amount <span class="error">*</span></label>
                                  <input  name="p_amount" id="p_amount" onkeyup="count_days()" autocomplete="off"  class="required number" type="text"  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Total Days Allowance Amount <span class="error">*</span></label>
                                <input id="amount"  name="amount" class="required number" type="text" readonly value="" />
                            </p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="excid1" value="<?php echo $_GET['excid'];?>">
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
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
 <!-- <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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
		$( "#datepicker" ).Zebra_DatePicker({
			 
			  pair: $('#datepicker1'),
			format: 'd/m/Y',
			onSelect: function(dateText) {
				count_days();
				  }
		});	
	
		$( "#datepicker1" ).Zebra_DatePicker({
			direction: 1,
			format: 'd/m/Y',
			onSelect: function(dateText) {
				count_days();
				  }
		});	
		$( "#datepicker3" ).Zebra_DatePicker({
			format: 'd/m/Y',
		});	

		$(".Zebra_DatePicker").css('top', "303px");
		$(".Zebra_DatePicker .dp_monthpicker").css('width', "203px");
		$(".Zebra_DatePicker .dp_yearpicker").css('width', "203px");
   });
	function count_days()
	{
	var a =$("#datepicker").val();
	var b =$("#datepicker1").val();
	var date1 = a;
	var date2 = b;

	// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
	date1 = date1.split('/');
	date2 = date2.split('/');

	// Now we convert the array to a Date object, which has several helpful methods
	date1 = new Date(date1[2], date1[1], date1[0]);
	date2 = new Date(date2[2], date2[1], date2[0]);
 
	// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
	date1_unixtime = parseInt(date1.getTime() / 1000);
	date2_unixtime = parseInt(date2.getTime() / 1000);

	// This is the calculated difference in seconds
	var timeDifference = date2_unixtime - date1_unixtime;

	// in Hours
	var timeDifferenceInHours = timeDifference / 60 / 60;

	// and finaly, in days :)
	var timeDifferenceInDays = timeDifferenceInHours  / 24;

	var timeDifferenceInDays =timeDifferenceInDays+1;

	 var loss_day="<option value='0'>0</option>";
	 
	if(!isNaN(timeDifferenceInDays) && timeDifferenceInDays > 0 ){
	 $("#num_days").val(timeDifferenceInDays);

	var ln=$("#lnum_days").val();
	var lns = document.getElementById("lnum_days")
	var selectedValue = lns.selectedIndex;
	//alert(selectedValue);
	 
	
	 for(x=1; x<=timeDifferenceInDays;x++)
	 {
		 x1=x-.5;

		 loss_day+="<option value="+x1+">"+x1+"</option>";
		 loss_day+="<option value="+x+">"+x+"</option>";
		 
	 }

	 
	 $("#lnum_days").html(loss_day);

	 document.getElementById("lnum_days").selectedIndex = selectedValue;
	
	 var q= $("#lnum_days").val();
		var q1=$("#p_amount").val();
		 var l_tot=parseFloat(q) * parseFloat(q1);
		 if(!isNaN(l_tot)){ }else{ l_tot=0; }
		 
	var p= $("#num_days").val();
	var p1=$("#p_amount").val();
	 var tot=parseInt(p) * parseFloat(p1);
	 if(!isNaN(tot)){ }else{ tot=0; }

	 var tot=parseFloat(tot) - parseFloat(l_tot);
	 
	 $("#amount").val(tot);
	}else{
		 $("#num_days").val("");
		  $("#amount").val(0);
		  $("#lnum_days").html(loss_day);
	}
	}
  </script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
  <script src="payroll/js/plugins/select2/select2.js"></script>
  <script>
$(function () {
	$('.select2-input').select2({
					placeholder: "Select..."
				});
			// Just for the demo
});
</script> 
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
</body>
</html>
<? ob_flush(); ?>