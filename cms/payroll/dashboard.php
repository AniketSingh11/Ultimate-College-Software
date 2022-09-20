<?php 
include("header.php");
?>
  </head>
 <body>

 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   ?>

	 <div id="content">		
		 <div id="content-header">
			 <h1>Dashboard </h1>
		 </div>  <!-- #content-header -->	
         <?php
		   if($_SESSION['admin_type']=="0" || in_array("payrolldashboard", $permissions_submenu)){
					?>		
		 <div id="content-container">

			<div>
				<h4 class="heading-inline">Payroll Status
				&nbsp;&nbsp;<small>For the week of <?php echo date("M d, Y");?></small>
				&nbsp;&nbsp;</h4>
			</div>

			 <br />


			 <div class="row">

				 <div class="col-md-3 col-sm-6">

					 <a href="javascript:;" class="dashboard-stat primary" style="padding:24px 20px;">
						 <div class="visual">
							 <i class="fa fa-star"></i>
						 </div>  <!-- /.visual -->

						 <div class="details">
							<span><h4>Total Employees : 
							 <?php $stafflist=mysql_query("select * from staff where relivestatus=0");
							 echo $num_rows = mysql_num_rows($stafflist);?>
							
						 </div> </h4> </span><!-- /.details --><br>
						 <div class="details" style="margin-left:5%;">
							<span><h4> Total Others   : 
							<?php $others=mysql_query("select * from others where relivestatus=0");
							 echo $num_rows = mysql_num_rows($others);?>
							
						 </div> </h4></span> <!-- /.details --><br>
						 <div class="details" style="margin-left:5%;">
							<span><h4>Total Drivers    : 
							<?php $driver=mysql_query("select * from driver where relivestatus=0");
							 echo $num_rows = mysql_num_rows($driver);?>
							 
						 </div> </h4> </span><!-- /.details -->
						 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				 </div>  <!-- /.col-md-3 -->
                 
				 <div class="col-md-3 col-sm-6">

					 <a href="javascript:;" class="dashboard-stat secondary">
						 <div class="visual">
							 <i class="fa fa-shopping-cart"></i>
						 </div>  <!-- /.visual -->

						 <div class="details">
							 <span class="content">Loan Amount</span>
							 <span class="value"><?php 
							 $emp_query=mysql_query("select * from staff_loan WHERE status='0'");	
							 $totalloan=0;
							 while($emp_display=mysql_fetch_array($emp_query))
								{
									$amount=$emp_display["l_amount"];
									$totalloan +=$amount;
								}
								echo $totalloan;
								?>
                              </span>
						 </div>  <!-- /.details -->

						 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				 </div>  <!-- /.col-md-3 -->

				 <div class="col-md-3 col-sm-6">
					 <a href="javascript:;" class="dashboard-stat tertiary">
						 <div class="visual">
							 <i class="fa fa-clock-o"></i>
						 </div>  <!-- /.visual -->

						 <div class="details">
							 <span class="content">No of Loans</span>
							 <span class="value"><?php echo $no_of_loan = mysql_num_rows($emp_query);?></span>
						 </div>  <!-- /.details -->

						 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				 </div>  <!-- /.col-md-3 -->

				 <div class="col-md-3 col-sm-6">

					 <a href="javascript:;" class="dashboard-stat">
						 <div class="visual">
							 <i class="fa fa-money"></i>
						 </div>  <!-- /.visual -->
						<?php $lmonth=date('m', strtotime(date('Y-m')." -1 month"));
							  $lyear=date('Y', strtotime(date('Y-m')." -1 month"));
							  $lmonthsalary=0;
							  $qryselect=mysql_query("SELECT n_salary FROM staff_month_salary WHERE month='$lmonth' AND year='$lyear'");
							   while($row=mysql_fetch_array($qryselect))
								{
									$lmonthsalary +=$row['n_salary'];
								}
							  ?>
						 <div class="details">
							 <span class="content">Last Month Salary</span>
							 <span class="value"><?php echo $lmonthsalary;?></span>
						 </div>  <!-- /.details -->

						 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				 </div>  <!-- /.col-md-9 -->
			 </div>  <!-- /.row -->
             <div class="row">
             <div class="col-md-6">
					<div class="portlet">
						<div class="portlet-header">
							<h3>
								<i class="fa fa-bar-chart-o"></i>
								Allowance Chart
							</h3>
						</div> <!-- /.portlet-header -->
						<div class="portlet-content">
							<div id="donut-chart1" class="chart-holder" style="height: 250px"></div>
						</div> <!-- /.portlet-content -->
					</div> <!-- /.portlet -->
				</div>
                <div class="col-md-6">
					<div class="portlet">
						<div class="portlet-header">
							<h3>
								<i class="fa fa-compass"></i>
								Deductions Overview
							</h3>
						</div> <!-- /.portlet-header -->
						<div class="portlet-content">
<?php
										$emp_query2="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result2=mysql_query($emp_query2);
										while($emp_display2=mysql_fetch_array($emp_result2))
										{?>
							<div class="progress-stat">
							
								<div class="stat-header">
									
									<div class="stat-label">
										% <?php echo $emp_display2["name"]; ?> 
									</div> <!-- /.stat-label -->
									
									<div class="stat-value">
										<?php echo $emp_display2["per_cent"]; ?> %
									</div> <!-- /.stat-value -->
									
								</div> <!-- /stat-header -->
								
								<div class="progress progress-striped active">
								  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?php echo $emp_display2["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="50" style="width: <?php echo $emp_display2["per_cent"]; ?>%">
								    <span class="sr-only"><?php echo $emp_display2["per_cent"]; ?> %  Rate</span>
								  </div>
								</div> <!-- /.progress -->
								
							</div> <!-- /.progress-stat -->
<?php } ?>
						</div> <!-- /.portlet-content -->

					</div> <!-- /.portlet -->
                </div>
             </div>
             		<br /><br />
		 </div>  <!-- /#content-container -->
		   <?php } ?>
	 </div>  <!-- #content -->	
 </div>  <!-- #wrapper -->
 <?php
 include("footer.php");
 ?>
 <?php include("includes/script.php");?>
 <script type="text/javascript">
function donut1 () {
	$('#donut-chart1').empty ();

	Morris.Donut({
        element: 'donut-chart1',
        data: [
						<?php
										$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										while($emp_display1=mysql_fetch_array($emp_result1))
										{?>
            {label: '<?php echo $emp_display1["name"]; ?>', value: <?php echo $emp_display1["per_cent"]; ?> },
			<?php } ?>
        ],
        colors: App.chartColors,
        hideHover: true,
        formatter: function (y) { return y + "%" }
    });
}
</script>
<style>
.dashboard-stat .content {
    display: block;
    margin-bottom: 1em;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}
</style>
 </body>
 </html>