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

		 <div id="content-container">

			<!--<div>
				<h4 class="heading-inline">Payroll Status
				&nbsp;&nbsp;<small>For the week of <?php echo date("M d, Y");?></small>
				&nbsp;&nbsp;</h4>
			</div>  -->

			 <br />


			 <div class="row">

				 <div class="col-md-3 col-sm-6">

					 <a href="javascript:;" class="dashboard-stat primary">
						 <div class="visual">
							 <i class="fa fa-star"></i>
						 </div>  <!-- /.visual -->

						 <div class="details">
							 <span class="content">Total Number Of Student </span>
							 <span class="value"><?php  $stafflist=mysql_query("select * from hms_student_room where status='0'");
							  echo $num_rows = mysql_num_rows($stafflist);?>
							 </span>
						 </div>  <!-- /.details -->
						 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				 </div>  <!-- /.col-md-3 -->

				 <div class="col-md-3 col-sm-6">

					 <a href="javascript:;" class="dashboard-stat secondary">
						 <div class="visual">
							 <i class="fa fa-shopping-cart"></i>
						 </div>  <!-- /.visual -->

						 <div class="details">
							 <span class="content">Total Number Of Room </span>
							 <span class="value"> <?php  $stafflist=mysql_query("select * from hms_room where status='0'");
							  echo $num_rows = mysql_num_rows($stafflist);?>  
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
							 <span class="content">No of Staff Warden</span>
							 <span class="value"><?php  $stafflist=mysql_query("select * from hms_worker  where status='0' ");
							  echo $num_rows = mysql_num_rows($stafflist);?></span>
						 </div>  <!-- /.details -->

						 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				 </div>  <!-- /.col-md-3 -->

			<!--	 <div class="col-md-3 col-sm-6">

					 <a href="javascript:;" class="dashboard-stat">
						 <div class="visual">
							 <i class="fa fa-money"></i>
						 </div>  <!-- /.visual -->

						<!--   <div class="details">
							 <span class="content">Total Fine Amount</span>
							 <span class="value">Rs.5000</span>
						 </div> --> <!-- /.details -->

					<!--	 <i class="fa fa-play-circle more"></i>

					 </a>  <!-- /.dashboard-stat -->

				<!-- </div>   /.col-md-9 -->
				  
			 </div>  <!-- /.row -->
            
		 </div>  <!-- /#content-container -->
		

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
 </body>
 </html>