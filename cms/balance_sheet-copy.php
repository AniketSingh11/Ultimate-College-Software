<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
 <style type="text/css">
.table tr{
border:1px #B7B7B7 dotted !important;
}
</style>
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
		/*$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);*/
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li> Income & Expense Ledger</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Start and End Date</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
						<div class="_50">
							<p>
								<label for="select">Start Date : <span class="error">*</span></label>
                               <input id="datepicker" name="sdate" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">End Date : <span class="error">*</span></label>
                               <input id="datepicker1" name="edate" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 
					$sdate=$_GET['sdate'];
					$edate=$_GET['edate'];
					
					$sdate_split1= explode('/', $sdate);		 
		  $sdate_month=$sdate_split1[1];
		  $sdate_day=$sdate_split1[0];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		  $startdate1= $sdate_year."-".$sdate_month."-".$sdate_day;
		 			
					$edate_split1= explode('/', $edate);		 
		  $edate_month=$edate_split1[1];
		  $edate_day=$edate_split1[0];
		  $edate_year=$edate_split1[2];
		  
		  $enddate= $edate_year.$edate_month.$edate_day;
		  $enddate1= $edate_year."-".$edate_month."-".$edate_day;
					
					if($sdate && $edate){ ?>
			<div class="grid_12">
            	<h1>Income & Expense Ledger</h1>
                <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo$sdate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong> </span> 
                <div id="invoice" class="widget widget-plain">			
				        <br>
						<div class="widget-content">
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th width="5%">S.No</th>
							<th width="50%"><center>Particular</center></th>
							<th class="total"><center>Expenses</center></th>
							<th class="total"><center>Income</center></th>
						</tr>
					</thead>						
					<tbody>
                    <?php 
					$count=1;
					$total=0;
					$indisplay=1;
			 			$qry5=mysql_query("SELECT fg_id,fg_name FROM mfgroup");
						while($row5=mysql_fetch_array($qry5))
						{
						    $fg_id=$row5['fg_id'];
						    $fg_amount=0;
						    $feeslist=mysql_query("SELECT fi_id FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
						    while($fees=mysql_fetch_array($feeslist))
						    {
						        $fi_id=$fees['fi_id'];
						        $feesummarry=mysql_query("SELECT amount FROM mfsalessumarry WHERE fi_id=$fi_id AND fg_id=$fg_id");
						        while($fsummarry=mysql_fetch_array($feesummarry)){
						            $amount=$fsummarry['amount'];
						            $fg_amount += $amount;
						        }
						    }
						    	
						    if($fg_amount!=0){
								$total += $fg_amount;
								
								if($indisplay=='1'){
                            ?>
                            <tr>
                        <td></td>
                        <td><b>Monthly Fees:</b></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php $indisplay=0;} ?>
												<tr>
													<td><?php echo $count;?></td>			
													<td><center><?php echo $row5['fg_name'];?></center></td>
													<td class="total"><center>-</center></td>
													<td class="total"><center>Rs. <?php echo number_format($fg_amount,2);?></center></td>
						                        </tr>
						                        <?php $count++; } 
						                        
												 } 
												
						/*********************************Other Fees********************************/						
						$qry5=mysql_query("SELECT fgd_id,name FROM mfgroup_detail");
						while($row5=mysql_fetch_array($qry5))
						{
						    $fgd_id=$row5['fgd_id'];
						    $fg_amount=0;
						    $feeslist=mysql_query("SELECT fi_id FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
						    while($fees=mysql_fetch_array($feeslist))
						    {
						        $fi_id=$fees['fi_id'];
						        $feesummarry=mysql_query("SELECT amount FROM mfsalessumarry WHERE fi_id=$fi_id AND fgd_id=$fgd_id");
						        while($fsummarry=mysql_fetch_array($feesummarry)){
						            $amount=$fsummarry['amount'];
						            $fg_amount += $amount;
						            	
						        }
						    }
						    	
						    if($fg_amount!=0){
								$total += $fg_amount;
						        ?>
												<tr>
													<td><?php echo $count;?></td>			
													<td><center><?php echo $row5['name'];?></center></td>
													<td class="total"><center>-</center></td>
													<td class="total"><center>Rs. <?php echo number_format($fg_amount,2);?></center></td>
						                        </tr>
						                        <?php $count++; } 
						                        
												 } 
												
						 /************************************************lastyesr Pending Fees ******************************************/
						 $fg_amount=0;
						    $feeslist=mysql_query("SELECT fi_id FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
						    while($fees=mysql_fetch_array($feeslist))
						    {
						        $fi_id=$fees['fi_id'];
						        $feesummarry=mysql_query("SELECT amount FROM mfsalessumarry WHERE fi_id=$fi_id AND ftype='pending'");
						        while($fsummarry=mysql_fetch_array($feesummarry)){
						            $amount=$fsummarry['amount'];
						            $fg_amount += $amount;
						            	
						        }
						    }
						    	
						    if($fg_amount!=0){
								$total += $fg_amount;
						        ?>
												<tr>
													<td><?php echo $count;?></td>			
													<td><b><center>Last Year Pending Fees</center></b></td>
													<td class="total"><center>-</center></td>
													<td class="total"><center>Rs. <?php echo number_format($fg_amount,2);?></center></td>
						                        </tr>
						                        <?php $count++; } 
												$etotal=0;
$qry1=mysql_query("SELECT fund_amount FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear AND funds='1' and c_status!='1' AND i_status='0'");
$sdf_total=0;
while($row1=mysql_fetch_array($qry1))
{
    $sdf_tamount=$row1['fund_amount'];
    $sdf_total +=$sdf_tamount;
}
				if($sdf_total){
					$etotal += $sdf_total;?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Student Discount Funds</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($sdf_total,2);?></center></td>
							<td class="total"><center>-</center></td>
                        </tr>
<?php $count++;  }?>
							<!--<tr>
                            	<td colspan="4" class="sub_total"><center><b>Other Fees</b></center></td>
                            </tr>-->
						<?php $book_amount=0;
					$booklist=mysql_query("SELECT i_total FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and i_status='0'"); 
								  while($book1=mysql_fetch_array($booklist))
								  {
									   $bamont=$book1['i_total'];
									   $book_amount += $bamont;
								  }
					if($book_amount!=0){
						$total +=$book_amount;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Book Fees</center></b></td>
							<td class="total"><center>-</center></td>
							<td class="total"><center>Rs. <?php echo number_format($book_amount,2);?></center></td>
                        </tr>
                        <?php $count++; }  						
						
						$bus_amount=0;
					$booklist1=mysql_query("SELECT fi_total FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear AND c_status!='1' AND i_status='0'"); 
								  while($bus1=mysql_fetch_array($booklist1))
								  {
									   $bamont1=$bus1['fi_total'];
									   $bus_amount += $bamont1;
								  }
					if($bus_amount!=0){
						$total +=$bus_amount;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Bus Fees</center></b></td>
							<td class="total"><center>-</center></td>
							<td class="total"><center>Rs. <?php echo number_format($bus_amount,2);?></center></td>
                        </tr>
                        <?php $count++; }  
?>
                        <?php 
						$indisplay=1;
						$classl = mysql_query("SELECT inc_id,in_category FROM in_category");
						while ($row1 = mysql_fetch_assoc($classl)){
							$incid=$row1['inc_id'];
						$in_amount=0;
                        $booklist1=mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND inc_id=$incid");
                        while($bus1=mysql_fetch_array($booklist1))
                        {
                            $bamont1=$bus1['amount'];
                            $in_amount += $bamont1;
                       
                        $total +=$in_amount;
                        }
                        if($in_amount!=0){
								if($indisplay=='1'){
                            ?>
                            <tr>
                        <td></td>
                        <td><b>Income Categories:</b></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php $indisplay=0;} ?>
                            <tr>
                                <td><?php echo $count;?></td>			
                                <td><center><?=$row1['in_category']?></center></td>
                                <td class="total"><center>-</center></td>
                                <td class="total"><center>Rs. <?php echo number_format($in_amount,2);?></center></td>
                            </tr>
                            <?php $count++;  }  }
						?>
<!-- ****************Expenses *************************--> 
						<?php  
						$qry6=mysql_query("SELECT exc_id,ex_category FROM ex_category");
						$excount=1;
						$indisplay=1;
						while($row6=mysql_fetch_array($qry6))
        		{
					$exc_id=$row6['exc_id'];
					$exsqry=mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
							$cont=1;
			  while($exrow=mysql_fetch_array($exsqry))
        		{
                  $category_id=$exrow["category"];
				  $exsid=$exrow["exs_id"];
                  $count1=$exrow["count"];
				  $subexname=$exrow["sub_name"];
				  if($count1==0){
				 			 for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$exrow["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$exsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
					    		while($class2=mysql_fetch_array($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					
					$exc_amount=0;
					$feeslist1=mysql_query("SELECT type,status,amount,pending FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND exc_id=$exc_id  AND  exs_id IN (".implode(',',$myarray).")"); 
								  while($fees1=mysql_fetch_array($feeslist1))
								  {
									  $type=$fees1['type'];
									  $status=$fees1['status'];
									  $amount1=$fees1['amount'];
									  if($type=='0'){
									  $exc_amount += $amount1;
									  }else if($type=='1' && $status=='1'){
										  $exc_amount += $amount1;
									  }else{
										  $pending=$fees1['pending'];
										  if(!$pending){
									  	  $pending=$amount1;
										  }
										  $exc_amount += ($amount1-$pending);
									  }
								  }
					if($exc_amount!=0){
						if($indisplay=='1'){
                            ?>
                        <tr>
                            <td></td>
                            <td><b>Expence Categories :</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php $indisplay=0;} 
						if($cont=='1'){
                            ?>
                            <tr>
                        <td></td>
                        <td style="padding-left:25px;"><?php echo $excount.". ".$row6['ex_category']?> :</td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php $cont=0; $excount++;} ?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo $subexname;?></center></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount,2);?></center></td>
							<td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++;  }
						$etotal += $exc_amount; } } 
						} 
			/**********************************daily Allowance *********************************/
			$d_amount=0;
					$booklist1=mysql_query("SELECT total_amount FROM exp_allowance WHERE (cdate >= '$startdate1' AND cdate <= '$enddate1')"); 
								  while($bus1=mysql_fetch_array($booklist1))
								  {
									   $bamont1=$bus1['total_amount'];
									   $d_amount += $bamont1;
								  }
					if($d_amount!=0){
						$etotal +=$d_amount;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Daily Allowance</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($d_amount,2);?></center></td>
							<td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++; }  
			
						$exc_amount1=0;
					$feeslist2=mysql_query("SELECT n_salary FROM staff_month_salary WHERE (year*10000) + (month*100) + day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear"); 
								  while($fees2=mysql_fetch_array($feeslist2))
								  { 
									  $amount2=$fees2['n_salary'];
									  $exc_amount1 += $amount2;
								  }
							$etotal +=$exc_amount1;
					if($exc_amount1!=0){
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center>Staffs Salary</center></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount1,2);?></center></td>
							<td class="total"><center>-</center></td>
                        </tr>
                     <?php } ?>
                        <tr>
							<td class="sub_total" colspan="2"> Total </td>
							<td class="sub_total"><center><?php echo "Rs. ".number_format($etotal,2);?></center></td>
                            <td class="sub_total"><center><?php echo "Rs. ".number_format($total,2);?></center></td>
						</tr>
						<tr class="total_bar">
							<td class="sub_total" colspan="2"><?php $finaltotal =$total-$etotal; echo "Income : <b>Rs. ".number_format($total,2)."</b> | Expenses : <b>Rs. ".number_format($etotal,2)."</b> ( ".number_format($total,0)." - ".number_format($etotal,0)." )";?></td>
							<td class="grand_total sub_total">Profit Total:</td>
							<td class="grand_total sub_total">Rs. <?php echo number_format($finaltotal,2);?></td>
						</tr>                        
					</tbody>
                  </table>
				
				<hr>
                <h2>Liabilities :</h2>
                <table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th width="5%">S.No</th>
							<th width="50%"><center>Particular</center></th>
							<th class="total"><center>Pending</center></th>
						</tr>
					</thead>						
					<tbody>
                    <?php  
					$count=1;
					$etotal1=0;
						$qry6=mysql_query("SELECT exc_id,ex_category FROM ex_category");
						$excount=1;
						$indisplay=1;
						while($row6=mysql_fetch_array($qry6))
        		{
					$exc_id=$row6['exc_id'];
					$exsqry=mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
							$cont=1;
			  while($exrow=mysql_fetch_array($exsqry))
        		{
                  $category_id=$exrow["category"];
				  $exsid=$exrow["exs_id"];
                  $count1=$exrow["count"];
				  $subexname=$exrow["sub_name"];
				  if($count1==0){
				 			 for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$exrow["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$exsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
					    		while($class2=mysql_fetch_array($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					
					$exc_amount=0;
					$feeslist1=mysql_query("SELECT type,status,amount,pending FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND exc_id=$exc_id AND ay_id=$acyear AND  exs_id IN (".implode(',',$myarray).")"); 
								  while($fees1=mysql_fetch_array($feeslist1))
								  {
									  $type=$fees1['type'];
									  $status=$fees1['status'];
									  $amount1=$fees1['amount'];
									  if($type=='0'){
									  //$exc_amount += $amount1;
									  }else if($type=='1' && $status=='0'){
										  $pending=$fees1['pending'];
										  if(!$pending){
									  	  $pending=$amount1;
										  }
										  $exc_amount += $pending;
									  }
								  }
					if($exc_amount!=0){
						if($cont=='1'){
							
                            ?>
                            <tr>
                        <td></td>
                        <td style="padding-left:25px;"><b><?php echo $excount.". ".$row6['ex_category']?> :</b></td>
                        <td></td>
                        </tr>
                        <?php $cont=0; $excount++;} ?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo $subexname;?></center></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount,2);?></center></td>
                        </tr>
                        <?php $count++;  }
						$etotal1 += $exc_amount; } } 
						} ?>
                        <tr>
							<td class="sub_total" colspan="2"> Total </td>
							<td class="sub_total"><center><?php echo "Rs. ".number_format($etotal1,2);?></center></td>
						</tr>
						<tr class="total_bar">
							<td class="sub_total" colspan="2"><?php $finaltotal1 =$finaltotal-$etotal1; echo "Profit Total : <b>Rs. ".number_format($finaltotal,2)."</b> | Liabilities  : <b>Rs. ".number_format($etotal1,2)."</b> ( ".number_format($finaltotal,0)." - ".number_format($etotal1,0)." )";?></td>
							<td class="grand_total sub_total"><span style="float:left">Profit Total:</span>Rs. <?php echo number_format($finaltotal1,2);?></td>
						</tr> 
                    </tbody>
                   </table>
			</div>
			</div>
            <a href="balancesheet_prt.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>" target="_blank"><input type="submit" value="Print Income & Expense Ledger" name="Print" class="btn btn-green" style="width:250px"> </a>
             <a href="invoice_pdf.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>" target="_blank"><input type="submit" value="Download Income & Expense Ledger" name="Download" class="btn btn-green" style="width:280px"> </a>
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

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
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
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
	});
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