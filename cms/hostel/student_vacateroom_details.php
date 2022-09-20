<?php
include("header.php");
?>
<style type="text/css">

	.howler {
		margin: 0 .75em 1em 0;
	}
</style>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   $filter=$_GET['filt'];	
	   $res=mysql_query("select * from hms_category where h_id='$filter'");
	   $row=mysql_fetch_array($res);
	   $cat_name=$row["h_name"];
	    
	   
	   ?>	
     <div id="content">		
		
		 <div id="content-header">
			 <h1>Student Vacate Room Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'delete_succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>		

 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Room  Successfully Changed 
			</div>
<?php } ?>		
 <?php if($_GET["msg"] == 'err') { ?>	
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?php echo $_GET["err_msg"]; ?> 
			</div>
<?php } ?>	


<div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Student Vacate Room  Details List 
							 </h3>
                            
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Category Type <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <li <?php if(!$filter){ echo 'class="active"';}?>><a href="student_vacateroom_details.php">Over All</a></li>
                            <?php 
									$res=mysql_query("select * from hms_category where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<li   <?php if($_GET["filt"]==$row["h_id"]){?>class="active" <?php }?> ><a href="student_vacateroom_details.php?filt=<?=$row["h_id"]?>"><?=stripslashes($row["h_name"]);?></a></li>
									 <?php } ?>
									 
									
									
						 
							  </ul>
							</div>
						 </div>  <!-- /.portlet-header -->
						 <div class="portlet-content">
							 <div class="table-responsive">
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true">
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true" data-direction="asc">Hostel name</th>
										       <th data-filterable="true" data-sortable="true">Room Number / Beds&cart </th>	
										       <th data-filterable="true" data-sortable="true">Student name </th>	
                                             <th data-filterable="true" data-sortable="true">Class -Section </th>	
                                              <th data-filterable="true" data-sortable="true">Vacate Date </th>										 
											 <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										if($filter!=""){
											$emp_query="select * from  hms_student_room  where category='$filter' and  status='1' order by date_time desc";
										}else{
											$emp_query="select * from hms_student_room  where status='1' order by date_time desc";
										}
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$hsr_id=$emp_display["hsr_id"];
			$hr_id=$emp_display["hr_id"];
			$hrc_id=$emp_display["hrc_id"];
			
			
            $student_id=$emp_display["student_id"];	
            $vacate_date=$emp_display["vacate_date"];	
            
            $student_number=$emp_display["admission_number"];
            $firstname=$emp_display["firstname"];
           
            
            $res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
            $row1=mysql_fetch_array($res);
            $c_id=$row1["c_id"];	
		    $s_id=$row1["s_id"];
			
			$query=mysql_query("SELECT * FROM class where c_id='$c_id'");
			$res=mysql_fetch_array($query);
			$class_name=$res["c_name"];
			 
			$query=mysql_query("SELECT * FROM section where s_id='$s_id'");
			$res=mysql_fetch_array($query);
			$section_name=$res["s_name"];
			
			
			$res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
			$row=mysql_fetch_array($res);
			$cat_name=$row["h_name"];
			
			$res=mysql_query("select * from hms_room where hr_id='$hr_id'");
			$row=mysql_fetch_array($res);
			$room_number=$row["room_number"];
			
			$res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
			$row=mysql_fetch_array($res);
			$cart_name=$row["cart_name"];
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $cat_name ;?> </td>
                                             <td><?php echo $room_number." - ".$cart_name; ?> </td>
                                           
                                             <td><?php echo $student_number."-".$firstname; ?> </td>
                                            
                                             <td><?php echo $class_name."-".$section_name; ?> </td>
                                            <td><?php echo date("d/m/Y",strtotime($vacate_date));?></td>
                                             
                                             								 
					 <td> <a title="View" href="student_vacateroomdetails_view.php?id=<?php echo $hsr_id; ?>"><img src="img/layout/view.png"/></a>    </td>
										 </tr>
		<?php 
        
		$emp_count++;
		
        }
        
        ?>							
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
						 </div>  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->

		 
<?php
include("footer.php");
?>
<?php include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>