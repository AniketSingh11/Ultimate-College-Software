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
			 <h1> Employee Bank Details </h1>
		 </div>  <!-- #content-header -->	


		 <div id="content-container">

			 <div class="portlet">

				 <div class="portlet-header">
			
					 <h3>						 
						Employee Bank Details
					 </h3>
			 <p class="add_link"><a href="emp_details_list.php" ><img src="img/layout/back.png" /></a></p>
				 </div>  <!-- /.portlet-header -->
			
				 <div class="portlet-content">
			
<?php 

$s_id=$_GET["id"];

$emp_query="select * from staff where st_id='$s_id'";
$emp_result=mysql_query($emp_query);
if($emp_display=mysql_fetch_array($emp_result))
{
?>
<?php if($emp_display["photo"]){ ?>
<img src="../img/Staff/<?php echo $emp_display["photo"]; ?>" width="200" height="120" style=" border:1px solid #ccc; margin-bottom:10px;" />
<?php } else { echo'<p  style=" width:150px; text-align:center; background:#f00; color:#fff;  padding:5px; margin-bottom:20px;  ">  No images </p>';} ?>

<br/>

<p class="title"> Personal Details : </p>
<table class="table_bg">

<tr>
<td>Employee Code :</td>
<td><?php echo $emp_display["staff_id"]; ?></td>
</tr>

<tr>
<td>First Name :</td>
<td><?php echo $emp_display["fname"]; ?></td>

<td>Last Name :</td>
<td><?php echo $emp_display["lname"]; ?></td>
</tr>

<tr>
<td>Father Name :</td>
<td><?php echo $emp_display["s_pname"]; ?></td>

<td>Date Of Birth :</td>
<td><?php echo $emp_display["dob"]; ?></td>
</tr>

<tr>
<td>Age :</td>
<td><?php echo $emp_display["age"]; ?></td>

<td>Gender :</td>
<td><?php echo $emp_display["gender"]; ?></td>
</tr>

<tr>
<td>Religion :</td>
<td><?php echo $emp_display["reg"]; ?></td>

<td>Blood Group :</td>
<td><?php echo $emp_display["blood"]; ?></td>
</tr>

<tr>
<td>Marital Status : </td>
<td><?php echo $emp_display["marriage"]; ?></td>

<td>Date Of Joining : </td>
<td><?php echo $emp_display["doj"]; ?></td>
</tr>
<tr>

<td>Role : </td>
<td><?php echo $emp_display["s_type"]; ?></td>

<td>Designation : </td>
<td><?php echo $emp_display["position"]; ?></td>
</tr>

<tr>
<td>Job Type : </td>
<td><?php echo $emp_display["job_type"]; ?></td>

<td>Qualification : </td>
<td><?php echo $emp_display["qualf"]; ?></td>
</tr>

<tr>
<td>Permanent Address : </td>
<td><?php echo $emp_display["address1"]; ?></td>

<td>Residential Address : </td>
<td><?php echo $emp_display["address2"]; ?></td>
</tr>

<tr>
<td>State : </td>
<td><?php echo $emp_display["state"]; ?></td>

<td>Country : </td>
<td><?php echo $emp_display["country"]; ?></td>
</tr>

<tr>
<td>Land Line No : </td>
<td><?php echo $emp_display["lline"]; ?></td>

<td>Phone No : </td>
<td><?php echo $emp_display["phone_no"]; ?></td>
</tr>

<tr>
<td>Email Id : </td>
<td><?php echo $emp_display["email"]; ?></td>

<td>Transport :  </td>
<td><?php echo $emp_display["transport"]; ?></td>
</tr>

</table>
<br/>
<p class="title"> Bank Details : </p>

<table class="table_bg" >

<tr>
<td>Bank Name : </td>
<td><?php echo $emp_display["b_name"]; ?></td>

<td>Bank Acc No : </td>
<td><?php echo $emp_display["b_acc_no"]; ?></td>
</tr>

<tr>
<td>PF No : </td>
<td><?php echo $emp_display["pf_no"]; ?></td>

<td>Nominee: </td>
<td><?php echo $emp_display["nominee"]; ?></td>
</tr>

<tr>
<td>Name : </td>
<td><?php echo $emp_display["n_name"]; ?></td>

<td>Phone No : </td>
<td><?php echo $emp_display["n_phone_no"]; ?></td>
</tr>

<tr>
<td>Email Id :   </td>
<td><?php echo $emp_display["n_email"]; ?></td>

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
