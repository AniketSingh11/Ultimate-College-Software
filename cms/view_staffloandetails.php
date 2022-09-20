<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover">Loan Details</li>
              
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			 			<div class="grid_12">
				<h1>Loan Pay Date Details</h1>                
                 <a onclick="history.go(-1);"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back</button></a>
                
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="dsucc"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully deleted!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Loan Pay Date Details List</h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true">Date</th>
											 <th data-filterable="true" data-sortable="true" >Pay Amount </th>
                                             <th data-filterable="true" data-sortable="true">Total Amount </th>											 
											 <th data-filterable="true" data-sortable="true">Balance</th>
                                            
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                       
                     $l_id=$_GET["id"];
                     $st_id=$_GET["stid"];
                     
                            
                            $emp_query="select * from staff_loan_pay where l_id='$l_id' and st_id='$st_id' order by l_id asc";
                        
                            $emp_result=mysql_query($emp_query);
                            $emp_count=1;
                            $total_pay=0;
                            while($emp_display=mysql_fetch_array($emp_result))
                            {
                                $emp_id=$emp_display["lp_id"];
                                $emp_id=$emp_display["lp_id"];
                                $total_pay +=$emp_display["amount"];
                            		    ?>
                            										 <tr>
                            											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["date"]; ?> </td>
                                             <td>Rs. <?php echo $emp_display["amount"]; ?> </td>
                                             <td>Rs. <?php echo $total_pay; ?> </td> 
                                             <td>Rs. <?php echo $emp_display['balance'];?></td>	
                                           <td>  <a title="Print" href="monthly_salary_print.php?id=<?php echo $emp_display["st_ms_id"]; ?>&stid=<?php echo $emp_display["st_id"]; ?>" target="_blank"><img src="./img/print.png" alt="print"></a>  </td>                           
                                                                          
                                                                                            </tr>
								   <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $emp_count;?>" title="<?php echo $emp_display["staff_name"]; ?>, This Salary details" style="display: none;">
             
				<p>Employee ID : <strong><?php echo $emp_display["staff_id"]; ?></strong></p>
                
                 <p>Employee Name : <strong><?php echo $emp_display["staff_name"];?></strong></p> 
                
                <p>Date  : <strong><?php echo $emp_display["l_date"]; ?></strong>  </p>   
                
                <p>Loan Type Name: <strong><?php echo $emp_display["l_type_name"]; ?></strong>  </p>   
                
                <p>Amount : <strong><?php echo $emp_display["l_amount"];?></strong>  </p> 
                
                <p>Rate Of Interest: <strong><?php echo $emp_display['l_m_pay']; ?></strong>  </p> 
                
                <p>Terms Of Month : <strong><?php echo $emp_display['l_terms']; ?></strong>  </p> 
                
                <p>Monthly Payment : <strong><?php echo $emp_display["l_m_pay"] ; ?></strong>  </p> 
                
                <p>Total Intrest : <strong><?php echo $emp_display["l_t_interest"] ; ?></strong>  </p>   
                
                <p>Total Payment :  <strong><?php echo $emp_display["l_pay"]; ?></strong>  </p>   
                
                <p>Status : <strong><?php if($emp_display['status']=='0'){ ?>
                                <button class="btn btn-small btn-success" >Payment Processing</button><?php }else{?><button class="btn btn-small btn-primary" >Completely Paid</button> <?php } ?></strong> </p>   
                
              
                </div>
                
              
                
                
                				
			</div> <!--! end of #info-dialog -->
                            	
                                 <?php 
							$emp_count++;
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