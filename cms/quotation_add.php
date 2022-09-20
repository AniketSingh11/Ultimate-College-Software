<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['submit']))
{
	$name1=$_POST['name1'];
	$title=$_POST['title'];
	$bill_to=addslashes(trim($_POST['bill_to']));
	$total_amount=addslashes(trim($_POST['overall_totamount']));
	//echo $bill_to."-".$ship_to."<br>";
	$date=$_POST['date'];
	$date_split1= explode('/', $date);	
		 $date_day=$date_split1[0];
		 $date_month=$date_split1[1];
		 $date_year=$date_split1[2];
	
			$receiptlist=mysql_query("SELECT * FROM tc_no WHERE id='5'"); 
			$receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno=$receiptcount['count'];
								  $addno=$receiptno+1;
								  
								 $pono="PO".str_pad($receiptno, 3, '0', STR_PAD_LEFT);

	$sql=mysql_query("INSERT INTO quotation (bill_address,name,title,total_amount,date,po_no,day,month,year,ay_id) values('$bill_to','$name1','$title','$total_amount','$date','$pono','$date_day','$date_month','$date_year','$acyear')") or die(mysql_error());
	
	$id=mysql_insert_id();
	$sql1=mysql_query("UPDATE tc_no SET count='$addno' WHERE id='5'");
	
	for ($i=0;$i<=30;$i++){	    
	 
	    $names=$_POST["name"];
	    $qtys=$_POST["qty"];
	    $amounts=$_POST["amount"];
	    $total=$_POST["total"];
	   
	    $totals=$total[$i];
	    $name=$names[$i];
	    $qty=$qtys[$i];
	    $amount=$amounts[$i];
	  
	   if($totals=="" || $totals==0 ){}else{
	     $sql=mysql_query("INSERT INTO quotation_amount (q_id,name,qty,amount,total) values('$id','$name','$qty','$amount','$totals')") or die(mysql_error());
	    } 
	}
	header("Location:quotation_edit.php?msg=succ");    
}

 ?>
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
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="bonafide.php" title="Home">Proposal</a></li>
                <li class="no-hover">Add New Proposal</li>
			</ul>            
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1>Add New Proposal</h1>                
			<a href="quotation_list.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!
            <center><a href="bonafide_prt.php?bid=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Added Bonafide</button></a></center>
            </div>
            <?php } ?>            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Proposal</h1><span></span>
					</div>
                    <?php 
					$receiptlist=mysql_query("SELECT * FROM tc_no WHERE id='5'"); 
								  $receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno=$receiptcount['count'];
								  
								 $pono="PO".str_pad($receiptno, 3, '0', STR_PAD_LEFT);
								 ?>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">PO No<span class="error">*</span></label>
                                <input name="poid" class="required" type="text" value="<?php echo $pono;?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">PO Date<span class="error">*</span></label>
                                <input name="date" id="datepicker1" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Title<span class="error">*</span></label>
                                <input name="title" class="required" type="text" value="" />
                            </p>
						</div>
                    <div class="_25">
							<p>
                                <label for="textfield">Company Name / Name <span class="error">*</span></label>
                                <input name="name1" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="clear"></div>
						<div class="_50">
							<p>
                                <label for="textfield">Address</label>
                                <textarea name="bill_to" class="required"  value="" rows="5" ></textarea>
                            </p>
						</div>
                       <table class="table">
					        <thead>				        
                            <tr>
					          <th>Name /Description</th>
					           <th width="10%">Qty</th>
					            <th width="20%">Amount</th>
					           <th width="20%">Total</th>
					           <th width="5%"></th>
					          </tr>                              
					        </thead>					        
					        <tbody class="dfdf">
					       <?php for ($i=0;$i<=30;$i++){?>
					          <tr id="hide_tr<?=$i?>" <?php if($i!=0){?>style="display: none;"<?php }?>>
					            
					              <td> <input type="text" name="name[]" value="" /></td>
					            <td> <input type="text" data-required="true" id="qty<?=$i?>" <?php if($i!=0){?> disabled <?php }?> name="qty[]" onkeyup="calc(<?=$i?>)" data-type="digits" class="required"  name="quantity"> </td>
					            <td>  <input type="text"  data-required="true" data-type="digits" <?php if($i!=0){?>  disabled <?php }?> id="amount<?=$i?>" onkeyup="calc(<?=$i?>)" name="amount[]"  class="required" ></td>
					             <td width="20%">  <input type="text"  id="total<?=$i?>"    name="total[]" readonly></td>
					              <td> <?php if($i!=0){?>
					              <img onclick="hide_table_tr(<?=$i?>)" src="img/icons/packs/fugue/16x16/minus-button.png"> 
					             <?php }?>
					             <?php if($i==0){?>
					             <a id="addvalue<?=$i?>" onclick="add_table_tr(<?=$i+1?>)" style="cursor:pointer"> <img src="img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td><?php }?>
					          </tr>
					           <?php }?>
					        </tbody>
					      </table>						
						<div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount"  readonly style="border: none; width:20%;font-size:14px; font-weight:bold;" id="overall_totamount"> </div>                         
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
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });				
 });
    function hide_table_tr(n)
    {
   	 $("#hide_tr"+n).hide();
    	$("#qty"+n).val(0);
    	$("#amount"+n).val(0);
   	 $("#total"+n).val(0);
    	var input=$("#hide_tr"+n+' input[type="text"]');
    	input.attr("disabled","disabled");
   	 
     var vals=0;
     var checkboxes=$('input[name="total[]"]');
      	for (var i=0, no=checkboxes.length;i<no;i++) {
      		 if(checkboxes[i].value==""){}else{
      		 vals=parseInt(checkboxes[i].value)+vals;
      		 }
      	}
      	$("#overall_totamount").val(vals);
    }

    function calc(n)
    {
   var qty=parseFloat($("#qty"+n).val());
   var amt=parseFloat($("#amount"+n).val());
   var tot=parseFloat(qty * amt);
   if(isNaN(tot)){
	   tot=0;}
   $("#total"+n).val(tot);
   var vals=0;
   var checkboxes=$('input[name="total[]"]');
    	for (var i=0, no=checkboxes.length;i<no;i++) {
    		 if(checkboxes[i].value==""){}else{
    		 vals=parseFloat(checkboxes[i].value)+vals;
    		 }
    	}
    	$("#overall_totamount").val(vals);
    }
	
	 function add_table_tr(n)
	 {
		 var input=$("#hide_tr"+n+' input[type="text"]');
		 input.removeAttr("disabled");
		var m=parseFloat(n)+1;
		 $("#hide_tr"+n).show();
		 $("#addvalue0").attr("onclick","add_table_tr("+m+")");
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