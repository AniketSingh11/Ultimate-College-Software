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
			 <h1> Employee Allowance & Deduction Details </h1>
		 </div>  <!-- #content-header -->	


		 <div id="content-container">

			 <div class="portlet">

				 <div class="portlet-header">
			
					 <h3>						 
						Employee Allowance & Deduction 
					 </h3>
			 
				 </div>  <!-- /.portlet-header -->
			
				 <div class="portlet-content">
			
<?php 

$s_id=$_GET["id"];

$emp_query="select * from staff_allw_ded where id='$s_id'";
$emp_result=mysql_query($emp_query);
if($emp_display=mysql_fetch_array($emp_result))
{
?>

<table class="table_bg">

<tr>
<td>Type :</td>
<td><?php echo $emp_display["type"]; ?></td>
</tr>

<tr>
<td>Name :</td>
<td><?php echo $emp_display["name"]; ?></td>
</tr>

<tr>
<td>Percentage :</td>
<td><?php echo $emp_display["per_cent"]; ?></td>
</tr>

<tr>
<td>Description :</td>
<td><?php echo $emp_display["descrip"]; ?></td>
</tr>

<tr>
<td>Status :</td>
<td><?php if($emp_display['status']==1){echo '<span class="status">Enable</span>';} else if($emp_display['status']==0){echo'<span class="status1">Disable</span>';} ?></td>	
</tr>


</table>	
    
<?php } ?>

				 </div>  <!-- /.portlet-content -->
			
			 </div>  <!-- /.portlet -->




		 </div>  <!-- /#content-container -->
		

	 </div>  <!-- #content -->
	
	
 </div>  <!-- #wrapper -->
 
 
 <?php
 
 include("footer.php");
 
 ?>
