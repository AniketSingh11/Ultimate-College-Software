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
                <li class="no-hover">Salary Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Salary Details</h1>                
               
                <div class="_25" style="float:right">
                <label for="select">Year :</label>
                                	<?php
                                	$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May");
                                	$year=$_GET['year'];
                                	if(!$year){
                                	    $year=$acyear;
                                	}
                                      ?>    
                                             <select name="year" id="year" class="required" onchange="change_function()">';
                                             <?php $qry=mysql_query("select * from year order by status  desc");
                                                  while($row=mysql_fetch_array($qry))
                                                  {
                                                            
                                             ?>
											 <option value="<?=$row[ay_id]?>" <?php if($row[ay_id]==$year){ echo "selected";}?>><?=$row[y_name]?></option>
											 <?php }?>
								             </select>
                 </div>
               
			</div>
			
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="dsucc"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully deleted!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Salary Details</h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
							 	<th  data-sortable="true">S.No</th>
							 	 
                                    <th data-filterable="true" data-sortable="true">Staff Name</th>
									 <th data-filterable="true" data-sortable="true">Month</th>
									 <th data-filterable="true" data-sortable="true">Gross Salary</th>
                                     <th data-filterable="true" data-sortable="true">Deduction</th>
                                     <th data-filterable="true" data-sortable="true">Net Salary</th>
                                      
                                     <th data-filterable="false" >Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            
                           
										$emp_query="select * from staff_month_salary where ay_id='$year' and st_id='$stid' order by month desc";
										$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($row=mysql_fetch_array($emp_result))
		{
		
			$emp_id=$row["st_ms_id"];
			$stid1=$row["st_id"];
			$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid");
			$staff=mysql_fetch_array($stafflist);
			
			if($row["month"]>5){
			    $y_value=$syear;
			}else if($row["month"]<=5){
			    $y_value=$eyear;
			}
			
			
										?> 
                            	<tr class="gradeX">
									<td class="sno center"><center><?php echo $emp_count; ?></center></td>
								             <td><?php echo  $row["staff_name"]; ?> </td>
                                             <td><?php echo $months[$row["month"]]." - ".$row["year"]; ?> </td>
                                             <td>Rs. <?php echo $row["g_salary"]; ?> /-</td>
                                             <td>Rs. <?php echo $row["d_total"]; ?> /-</td>                                             
                                             <td>Rs. <?php echo $row["n_salary"]; ?> /-</td>	
                              
								<td> <a title="Print" href="monthly_salary_print.php?id=<?php echo $emp_id; ?>&stid=<?php echo $stid1; ?>" target="_blank"><img src="./img/print.png"/></a></td>
								</tr> 
								
								
							 	
								
                                 <?php 
							$emp_count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
			</div>
            
            
            
            <?php  
            
            $emp_result=mysql_query($emp_query);
            $emp_count=1;
            while($row=mysql_fetch_array($emp_result))
            {
               
            
            ?>
            
            
<?php         
		$emp_count++;		
        }        
        ?>	  
            
            
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

	 function change_function() { 
	     var year =document.getElementById('year').value;
		 window.location.href = 'staff_salarydetails.php?year='+year;	  
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