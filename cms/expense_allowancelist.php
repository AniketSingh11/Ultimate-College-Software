<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
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
				<li class="no-hover">Daily Allowance Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<?php   $stype=$_GET['s_type'];
					
					      $sdate=$_GET['s_date'];
                            $date_split1=explode('/', $sdate);
                            $s_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
                            $edate=$_GET['e_date'];
                            $date_split1=explode('/', $edate);
                            $e_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
                             ?>
			<div class="grid_12">
				<h1>Daily Allowance Management</h1>
              
                 <a href="expense_allowance_add.php"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png">Add Allowance</button></a>
				 <a href="export_dailyallowance.php?s_date=<?=$sdate?>&e_date=<?=$edate?>&s_type=<?=$stype?>" title="Download" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>
				
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
			<select id="stype"  name="stype" style="width: 200px; float: right;"  class="required" onchange="lists()"  > 
                        <option value="">All</option>
                        <?php $qry1=mysql_query("select distinct type from exp_allowance");
                              while($trow1=mysql_fetch_array($qry1))
                              {  
                           ?>
                        <option value="<?php echo $trow1["type"]; ?>" <?php if($_GET['s_type']==$trow1["type"]){ echo "selected"; }?>><?php echo $trow1["type"]; ?></option>
                      <?php }?>
                      </select>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Daily Allowance Management</h1>
						<span></span>
						<div class="_25"><input id="datepicker" name="s_date" placeholder="Start Date" value="<?=$_GET["s_date"];?>"  style="width: 200px;"  class="required" type="text"  /></div>
                         <div class="_25"><input id="datepicker1" name="e_date" placeholder="End Date" value="<?=$_GET["e_date"];?>" style="width: 200px;"  class="required" type="text"  /> </div> 
                          <a href="expense_allowancelist.php"><button class="btn btn-small btn-primary">Clear</button></a>
					</div>
					<div class="block-content tab-container">
							<br>
							<table id="table-example" class="table">
							<thead>
								<tr>
                                    <th>S.No</th>
                                    <th><center>Receipt No</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>ID</center></th>
                                    <th><center>Name</center></th>
                                    <th><center>Type</center></th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Days</th>
                                    <th>Loss Days</th>
                                    <!--<th>Day</th>-->
                                    <th>Total Amount</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            $querylist="SELECT id,total_amount,from_date,to_date,receipt_no,name,type,working_days,loss_days,d_id,cdate FROM exp_allowance where d_id!='' ";
                            if($stype){
                                $querylist.=" AND type='$stype' ";
                            }
                           if($sdate && $edate){
                    	$querylist.=" AND ((from_date >= '$s_date' and from_date <= '$e_date') or (to_date >= '$s_date' and to_date <= '$e_date')) ";
                           }
						   $querylist.=" ORDER BY id DESC";
                           $qry1=mysql_query($querylist);
                         
                    	$count=1;
                    	$tot=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
        		    
                     $member_id=$row1["id"];
                     $total=$row1['total_amount'];
                     $tot=$total+$tot;
        		  
        		    $fromdate=$row1["from_date"];
        		    $date_split1=explode('-', $fromdate);
        		    	
        		    $from_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
        		    $todate=$row1["to_date"];
        		    $date_split1=explode('-', $todate);
        		    
        		    $to_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
					
					$cdate=$row1["cdate"];
        		    if($cdate){
					$date_split2=explode('-', $cdate);
        		    $c_date=$date_split2[2]."/".$date_split2[1]."/".$date_split2[0];
					}
        		    
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row1['receipt_no']; ?></center></td>
								<td><center><?php echo $c_date; ?></center></td>
                                <td><center><?php echo $member_id; ?></center></td>
                                <td><center><?php echo $row1['name']; ?></center></td>
                                <td><center><?php echo $row1['type'];?></center></td>
                                <td><center><?php echo $from_date; ?></center></td>
                                <td><center><?php echo $to_date; ?></center></td>
                                <td><center><?php echo $row1['working_days']; ?></center></td>
                                <td><center><?php echo $row1['loss_days']; ?></center></td>
                                <!--<td><center><?php //echo $row1['perday_amount']; ?></center></td>-->
                                <td><center><?php echo $row1['total_amount']; ?></center></td>
                                <td width="100px">
                               <!--   <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a> -->
                                 <a href="expense_allowance_edit.php?did=<?php echo $row1['d_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="expense_allowance_delete.php?did=<?php echo $row1['d_id']; ?>&s_date=<?=$_GET["s_date"]?>&e_date=<?=$_GET["e_date"]?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="expenseallowance_prt.php?did=<?php echo $row1['d_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
					 
					 					
					</div>
					<!--<div class="block-content dark-bg">
						<p>You see an other example on the <a href="charts.html">Charts-Page</a>.</p>
					</div>-->
				</div>
				<!--<div class="block-border">
					<div class="block-header">
                    	<h1>Staffs Management</h1>
                        <span></span>
					</div>
                    <div class="block-content">
						
					</div>
				</div>-->
			</div>
			
			  <div id="tot" style="float: right; width: 200px;" ><b>Total Amount : <?php echo "Rs.".number_format($tot,2); ?></b></div>
			
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable({
  'iDisplayLength': 25
});
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
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
		 $( "#tot" ).insertAfter( "#stype" );
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		$("#tab-panel-1").createTabs();
		

  $( "#datepicker").Zebra_DatePicker({
			 
			  pair: $('#datepicker1'),
			format: 'd/m/Y',
			onSelect: function(dateText) {
				var d=$("#datepicker").val(); 
				var d1=$("#datepicker1").val();
				var d2=$("#stype").val();
				if(d!="Start Date" && d1!="End Date"){    window.location.href="expense_allowancelist.php?s_date="+d+"&e_date="+d1+"&s_type="+d2;}
				 
				  }
		});	
	
		$( "#datepicker1" ).Zebra_DatePicker({
			direction: 1,
			format: 'd/m/Y',
			onSelect: function(dateText) {
				var d=$("#datepicker").val(); 
				var d1=$("#datepicker1").val();
				var d2=$("#stype").val();

				if(d!="Start Date" && d1!="End Date"){  
				window.location.href="expense_allowancelist.php?s_date="+d+"&e_date="+d1+"&s_type="+d2; }
				
				  }
		});	
	});


	function lists()
	{
		var d=$("#datepicker").val(); 
		var d1=$("#datepicker1").val();
		var d2=$("#stype").val();
 
		if(d=="Start Date"){ d=""; }if(d1=="End Date"){ d1=""; }
	 	window.location.href="expense_allowancelist.php?s_date="+d+"&e_date="+d1+"&s_type="+d2; 

	}
	   
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