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
                <li class="no-hover">Expenses Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">        		
			<div class="container_12">		
            <?php 
					$exid=$_GET['exid'];
					$expenselist=mysql_query("SELECT * FROM exponses WHERE ex_id=$exid"); 
					$expense=mysql_fetch_assoc($expenselist);
					
					$excid=$expense['excid'];
					$exsid=$expense['exsid'];
					$aid=$expense['aid'];
					if($excid){
							 $classlist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid"); 
								  $class=mysql_fetch_assoc($classlist);
					}
					if($aid){
							 $agencylist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
								  $agency=mysql_fetch_assoc($agencylist);
					}
					if($exsid){
					    $classlist1=mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id='$exsid'");
					    $class1=mysql_fetch_assoc($classlist1);
						
						for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$class1["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$exsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT * FROM ex_insubcategory WHERE $subname='$exsid'");
					    		while($class2=mysql_fetch_assoc($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					}				
								  ?>
			<div class="grid_12">
				<h1><?php echo $expense['r_no'];?> - Paid Expenses Details <?php if($aid){ echo "(".$agency['a_name'].")";}?></h1>
                <a href="exponse_mng.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			  <a href="export_exponse.php?excid=<?php echo $excid;?>&exs_id=<?=$exsid?>&aid=<?=$aid?>" title="Download" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>
			
				<?php
				$qry2="SELECT * FROM exponses_bill_summary WHERE ex_id=$exid ORDER BY ex_id DESC";
				$qry=mysql_query($qry2);
				$norow=mysql_num_rows($qry);
				$total=$expense['amount'];
				$pending=$expense['pending'];
				if($norow){
				$paitotal=$total-$pending;
				}else{
				 $paitotal=0;
				 $pending=$total;
				}
				?> 
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Pending : <strong>Rs. <?php echo number_format($pending,2); ?></strong> </span> 
				  <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Paid : <strong>Rs. <?php echo number_format($paitotal,2); ?></strong> </span> 
                  <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>
                 <div class="clear"></div>  
			</div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php if($excid){ echo $class['ex_category'];} else{ echo "All";} ?> Expenses Details <?php  if($exsid){ echo "(".$selectsubname.")"; } ?></h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Paid No</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Amount</center></th>
                                    <th width="8%"><center>paid Bill</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php 
				
				$count=1;
				  while($row=mysql_fetch_assoc($qry))
					{
					$epid=$row['ep_id'];
					$qry1=mysql_fetch_assoc(mysql_query("select * from exponses_bill where ep_id='$epid'"));
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                                <td><center><?php echo $qry1['bill_no']; ?></center></td>
                                <td><center><?php echo $qry1['date']; ?></center></td>
                                <td><center><?php echo $qry1['title']; ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['amount'],2); ?></center></td>
                                <td><a href="exponsei_prt.php?id=<?php echo $epid;?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a></td>                               
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
                
			</div>
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
  <script type="text/javascript">
	$().ready(function() {
		$("#exsid option[data_value='<?=$excid?>']").show();
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	 function change_function() { 
     var cid =document.getElementById('excid').value;
	 window.location.href = 'exponse_mng.php?excid='+cid+'<?php echo "&aid=".$aid;?>';	  
	}
	function change_function1() { 
     var cid =document.getElementById('aid').value;
	 window.location.href = 'exponse_mng.php?aid='+cid+'<?php echo "&excid=".$excid."&exsid=".$exsid;?>';	  
	}
	 $( "#exsid" ).change(function() {
			var cid=$( "#excid" ).val();
			var sid=$( "#exsid" ).val();
			 window.location.href = 'exponse_mng.php?excid='+cid+"&exsid="+sid+'<?php echo "&aid=".$aid;?>';
			}); 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>