<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname']; 
 if (isset($_POST['submit']))
{
	 

		 
	$d_id=$_POST['did'];
	
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
 
	$loss_days=$_POST['lnum_days'];
	
 
		 $result=mysql_query("UPDATE exp_allowance SET  cdate='$c_date',from_date='$from_date',to_date='$to_date',working_days='$working_days',perday_amount='$perday_amount',total_amount='$total_amount',loss_days='$loss_days' WHERE d_id='$d_id'");
	 
	if($result){
	    header("Location:expense_allowance_edit.php?did=$d_id&msg=succ");
	    
       }else{
           
           header("Location:expense_allowance_edit.php?did=$d_id&msg=delsucc");
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
							$d_id=$_GET['did'];
					$qry=mysql_query("select * from  exp_allowance where  d_id='$d_id'");
					$row=mysql_fetch_array($qry);
					$receiptno=$row["receipt_no"];
					$member_id=$row["id"];
					$fromdate=$row["from_date"];
					$date_split1=explode('-', $fromdate);
					
					$from_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
					$todate=$row["to_date"];
					$date_split1=explode('-', $todate);
						
					$to_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
					$working_days=$row["working_days"];
					$loss_days=$row["loss_days"];
					$perday_amount=$row["perday_amount"];
					$total_amount=$row["total_amount"];	
							  
							  
							  $cdate=$row["cdate"];
							  if($cdate){
					$date_split1=explode('-', $cdate);
						
					$c_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
							  }
								   
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				          <li class="no-hover">Edit   Allowance Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit  Allowance Details</h1>                
			<a href="expense_allowancelist.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php  $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Updated!!!</div>
            <?php } if($msg=="delsucc"){?>			
            <div class="alert error"><span class="hide">x</span>Failed!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit  Allowance Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    	<div class="_25">
                                <p>
                                    <label for="textfield">Date  <span class="error">*</span></label>
                                    <input id="datepicker3" name="cdate" autocomplete="off" class="required" type="text" readonly value="<?=$c_date?>"  />
                                </p>
                            </div>
                    	 <div class="_25">
							<p>
                                <label for="textfield">Receipt No :  <?php echo $receiptno;?> </label>
                               
                            </p>
						</div>
                         <div class="_25">
                                    <p>
                                        <label for="textfield"> <?php echo $row['type'];?> :
										<?php echo $row['id']."-".$row['name'];?> </label>
                                        
									 </p>
                                    </div>
                                    
                                    <div class="_25"  >
							<p >
                                <label for="textfield">From Date  <span class="error">*</span></label>
                                <input id="datepicker" name="from_date"  value="<?=$from_date?>" class="required" type="text"  readonly/>
                            </p>
						</div>
						
						  <div class="_25">
							<p>
                                <label for="textfield">To Date  <span class="error">*</span></label>
                                <input id="datepicker1" name="to_date"  value="<?=$to_date?>" class="required" type="text"  readonly/>
                            </p>
						</div>
						
						 <div class="_25">
							<p>
                                <label for="textfield">Number of Days<span class="error">*</span></label>
                                <input  name="num_days"  id="num_days" value="<?=$working_days?>"   readonly class="digits" type="text"  />
                            </p>
							</div>
                          <div class="_25">
							<p>
                                <label for="textfield">Number of Loss Days<span class="error">*</span></label>
                                <select  name="lnum_days" onChange="count_days()" id="lnum_days"  >
                                <?php for($i==0.5;$i<=$loss_days;$i=($i+.5)){?>
                                <option value="<?=$i?>"<?php if($i==$loss_days){ echo "selected";}?>><?=$i?></option>
                                <?php //$i=($i+.5);
								} ?>
                                </select>
                            </p>
						</div>
						
                        <div class="_25">
							<p>
                                <label for="textfield">Per Day Allowance Amount <span class="error">*</span></label>
                                  <input  name="p_amount" id="p_amount" onkeyup="count_days()" value="<?=$perday_amount?>" class="required number" type="text"  />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Total Days Allowance Amount <span class="error">*</span></label>
                                <input id="amount"  name="amount" class="required number" value="<?=$total_amount?>" type="text" readonly />
                            </p>
						</div>
						<input  type="hidden" name="did" value="<?=$d_id?>">
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
		 
	}

	}
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