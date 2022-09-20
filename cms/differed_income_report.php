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
		$bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_differed_report.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li>Differed Income Report</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_differed_report.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Start and End Date And Class,Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
						<div class="_25">
							<p>
								<label for="select">Start Date : <span class="error">*</span></label>
                               <input id="datepicker" name="sdate" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">End Date : <span class="error">*</span></label>
                               <input id="datepicker1" name="edate" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard : </label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : </label>
                               <select name="sid" id="sid">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 
					$sdate=$_GET['sdate'];
					$edate=$_GET['edate'];
					$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							
					$sdate_split1= explode('/', $sdate);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_day=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		 			
					$edate_split1= explode('/', $edate);		 
		  $edate_month=$edate_split1[0];
		  $edate_day=$edate_split1[1];
		  $edate_year=$edate_split1[2];
		  
		  $enddate= $edate_year.$edate_month.$edate_day;
					
					if($sdate && $edate && $bid ){ 
					
					if(!empty($cid)) {
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
					}
								  
					
					$qry1="SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND bid= '" . $bid."' and c_status!='1'";
					
					if(!empty($cid)) { $qry1 .= " AND c_id = '" . $cid. "'"; }
					if(!empty($sid)) { $qry1 .= " AND s_id = '" . $sid. "'"; }					
					$qry1 .=" AND ay_id='" . $acyear. "'";
											$qry1=mysql_query($qry1);
							$total=0;
			  while($row=mysql_fetch_array($qry1))
        		{
					$ffi_id=$row['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fg_id='3' AND type='terms'");
							  $row6=mysql_fetch_array($qry6);
							  if($row6){
							  $tamount=$row6['tamount'];
							  $twomonth_amount=($tamount/2);
							  $amount=$row6['amount'];
							  $pamount=$row6['pamount'];
							  //$twomonth_amount." > ".$pamount." - ";
							  if($twomonth_amount > $pamount){
								  $testbalance=$amount+$pamount;
								  if($testbalance>$twomonth_amount){
									   $first_haft_pay=$testbalance-$twomonth_amount;									   
									   $differ_amount=($amount-$first_haft_pay);
								  }else{
									  $differ_amount=($testbalance-$pamount);
								  }
								 $total +=$differ_amount;
							  } }
				}?>
                <div class="grid_12"><br>
                <h1> <?php echo $class['c_name']; if(!empty($sid)) { echo "-".$section['s_name'];}?> Differed Income Report</h1>
               <span style="margin-left:20px;"><a href="differed_income_export.php?sdate=<?php echo $sdate;?>&edate=<?php echo $edate;?>&b_id=<?php echo $bid;?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&ayid=<?php echo $acyear;?>" style="width:100px"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report</button></a></span>
                <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo$sdate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calculator-scientific.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>
                <br><br>
				<div class="block-border">
					<div class="block-header">
                    	<h1>Fees Income Report (<?php echo $class['c_name']; if(!empty($sid)) { echo "-".$section['s_name'];}?>)</h1>                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>FR No</center></th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                   	<th>Board</th>
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th width="4%">Student type</th>
                                    <th>Inovice By</th>
                                    <th width="8%">Differed Amount</th>
                                    <th>Inovice Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry="SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND bid= '" . $bid. "' and c_status!='1'";
							if(!empty($cid)) { $qry .= " AND c_id = '" . $cid. "'"; }
							if(!empty($sid)) { $qry .= " AND s_id = '" . $sid. "'"; }
							$qry .=" AND ay_id='" . $acyear. "'";
							$qry=mysql_query($qry);
							$count=1;
							$tdiffer_amount=0;
			  while($row=mysql_fetch_array($qry))
        		{
					$bid1=$row['bid'];
					$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
							$sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
					$boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);
					$boardname=$board1['b_name'];
					$ffi_id=$row['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fg_id='3' AND type='terms'");
							  $row6=mysql_fetch_array($qry6);
							  if($row6){
							  $tamount=$row6['tamount'];
							  $twomonth_amount=($tamount/2);
							  $amount=$row6['amount'];
							  $pamount=$row6['pamount'];
							  //$twomonth_amount." > ".$pamount." - ";
							  if($twomonth_amount > $pamount){
								  $testbalance=$amount+$pamount;
								  if($testbalance>$twomonth_amount){
									   $first_haft_pay=$testbalance-$twomonth_amount;									   
									   $differ_amount=($amount-$first_haft_pay);
								  }else{
									  $differ_amount=($testbalance-$pamount);
								  }
								 $tdiffer_amount +=$differ_amount;
					
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['fr_no']; ?></center></td>
                                <td><center><?php echo $row['fi_name']; ?></center></td>
                                <td><center><?php echo $row['fi_day']."/".$row['fi_month']."/".$row['fi_year']; ?></center></td>
                                <td><center><?php echo $boardname;?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $row['category']; ?></center></td>
                                <td><center><?php echo $row['stype']; ?></center></td>
                                <td><center><?php echo $row['fi_by']; ?></center></td>
                                <td><center>Rs. <?php echo number_format($differ_amount,2); ?></center></td>
								<td class="view"><center><a href="feesinvoice_report_detail.php?fiid=<?php echo $row['fi_id'];?>&bid=<?php echo $bid1;?>&bid1=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
								$count++;
							  } }
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>			
		<div class="clear height-fix"></div>
        </div>
        <?php } ?>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable();
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  <script defer src="js/zebra_datepicker.js"></script>
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'differed_income_report.php?bid='+cid;	  
	} 
  </script>
  <!-- end scripts-->

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
            document.getElementById("sid").innerHTML = "";
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
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>