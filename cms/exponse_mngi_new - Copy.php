<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname']; 
 if (isset($_POST['submit']))
{
	die();
	$date=$_POST['date'];
	$date_split1= explode('/', $date);
		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
		 
	$type=$_POST['type'];
		
		if($type=="2"){
	$title=$_POST['title'];
	$des=$_POST['des'];
	$r_no=$_POST['r_no'];
	$b_no=$_POST['b_no'];
	$amount=$_POST['amount'];
	$excid=$_POST['excid'];
	$exsid=$_POST['exsid'];
	$excid1=$_POST['excid1'];	
	
        $receiptlist=mysql_query("SELECT * FROM tc_no WHERE id='3'"); 
		$receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno1=$receiptcount['count'];
								  $receiptno2 =$receiptno1+1;
								  
								 $receiptno="EX".str_pad($receiptno1, 5, '0', STR_PAD_LEFT);
		
	$sql="INSERT INTO exponses (r_no,b_no,date_day,date_month,date_year,title,des,amount,exc_id,exs_id,ay_id,type) VALUES
('$receiptno','$b_no','$date_day','$date_month','$date_year','$title','$des','$amount','$excid','$exsid','$acyear','0')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	if($result){
		$sql1=mysql_query("UPDATE tc_no SET count='$receiptno2' WHERE id='3'");
     $msg="succ";    
	 }
		}else if($type=="1"){
			
	$r_no=$_POST['r_no'];
	$total_amount=addslashes(trim($_POST['overall_totamount']));
	$excid=$_POST['excid'];
	$exsid=$_POST['exsid'];
	$excid1=$_POST['excid1'];
	$n_sid=$_POST['n_sid'];	
	
	if($n_sid=="New"){
		$n_sid=0;
	}
        $receiptlist=mysql_query("SELECT * FROM tc_no WHERE id='3'"); 
		$receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno1=$receiptcount['count'];
								  $receiptno2 =$receiptno1+1;
								  
								 $receiptno="EX".str_pad($receiptno1, 5, '0', STR_PAD_LEFT);
	 $sql="INSERT INTO exponses (r_no,b_no,date_day,date_month,date_year,title,des,amount,exc_id,exs_id,ay_id,type,q_id) VALUES
('$receiptno','$b_no','$date_day','$date_month','$date_year','$title','$des','$total_amount','$excid','$exsid','$acyear','1','$n_sid')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$id=mysql_insert_id();
	if($result){
		for ($i=0;$i<=30;$i++){	    
	 
	    $names=$_POST["name"];
		$poqtys=$_POST["poqty"];
	    $qtys=$_POST["qty"];
	    $amounts=$_POST["amount"];
	    $total=$_POST["total"];
	   
	    $totals=$total[$i];
	    $name=$names[$i];
		$poqty=$poqtys[$i];
	    $qty=$qtys[$i];
	    $amount=$amounts[$i];
	  
	   if($totals=="" || $totals==0 ){}else{
		$sql=mysql_query("INSERT INTO expense_po_amount (ex_id,name,poqty,qty,amount,total) values('$id','$name','$poqty','$qty','$amount','$totals')") or die(mysql_error());
	    } 
	}
		if($n_sid){
			$sql1=mysql_query("UPDATE quotation SET status='1' WHERE q_id='$n_sid'");
		}
		$sql1=mysql_query("UPDATE tc_no SET count='$receiptno2' WHERE id='3'");
     	$msg="succ";    
	 }	
	 	}
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
    	<?php 
							$excid=$_GET['excid'];
							if($excid){
							 $classlist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid"); 
								  $class=mysql_fetch_array($classlist);}
								  
								   $receiptlist=mysql_query("SELECT * FROM tc_no WHERE id='3'"); 
								  $receiptcount=mysql_fetch_array($receiptlist);	  
								  
								  $receiptno=$receiptcount['count'];
								  
								 $receiptno="EX".str_pad($receiptno, 5, '0', STR_PAD_LEFT);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="exponse_mng.php?excid=<?php echo $excid; ?>" title="month"><?php  echo $class['ex_category'];?> Expenses Details</a></li>
                <li class="no-hover">Add New Expenses Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Expenses Details</h1>                
			<a href="exponse_mng.php?excid=<?php echo $excid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New <?php echo $class['ex_category'];?> Expenses Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    	<div class="_25">
							<p>
                                <label for="textfield">Date (DD/MM/YYYY) <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo date("d/m/Y");?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                            <label for="textfield">Expenses Category<span class="error">*</span></label>
                        <?php 
						$classl = "SELECT * FROM ex_category";
                                            $result1 = mysql_query($classl) or die(mysql_error());
								echo '<select name="excid" id="excid" class="required" onchange="showCategory(this.value)">';
											echo "<option value=''>Select category</option>";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($excid ==$row1['exc_id']){
                                                echo "<option value='{$row1['exc_id']}' selected>{$row1['ex_category']}</option>\n";
												} else {
												echo "<option value='{$row1['exc_id']}'>{$row1['ex_category']}</option>\n";
												}
										    endwhile;
                                            echo '</select>';
											?>
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Select Bill to Close : <span class="error">*</span></label>
                               <select name="exid" id="exid" class="required" class="_25">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Receipt No <span class="error">*</span></label>
                                <input id="textfield" name="r_no" class="required" type="text" value="<?php echo $receiptno;?>" readonly />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Expense Type: <span class="error">*</span></label>
                               <select id="test-1" multiple="multiple" size="5" class="_25">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                                <option value="option4">Option 4</option>
                                <option value="option5">Option 5</option>
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                                <option value="option4">Option 4</option>
                                <option value="option5">Option 5</option>
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                                <option value="option4">Option 4</option>
                                <option value="option5">Option 5</option>
                                </select>
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
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>-->
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
		$("#exsid option[data_value='<?=$excid?>']").show();
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		//$( "#datepicker" ).datepicker();	
		$( "#datepicker" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});					
	});
	
	function proposal_bill() {
			var x = document.getElementById("n_sid").value;
			$.get("proposal_bill.php",{value:x},function(data){
			$("#proposal_bill" ).html(data);
			});	
		}	
  </script>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
		if (str == "") {
            document.getElementById("exid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("exid").innerHTML = xmlhttp.responseText;
            }
        }
		
        xmlhttp.open("GET", "exbilllist.php?mmtid=" + str, true);
        xmlhttp.send();
    }   
</script>
 <link rel="stylesheet" type="text/css" href="assets/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="assets/prettify.css" />
<script src="js/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="assets/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/jquery.multiselect.js"></script>
<script type="text/javascript" src="assets/prettify.js"></script>
<script type="text/javascript">
$(function(){
	$("#test-1").multiselect({
		show: ["bounce", 200],
		hide: ["explode", 1000]
	});	
});
</script>
</body>
</html>
<? ob_flush(); ?>