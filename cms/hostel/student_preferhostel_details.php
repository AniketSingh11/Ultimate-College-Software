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
			 <h1>Prefer Hostel Student  Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
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
							Prefer Hostel	Student   Details List 
							 </h3>
                            
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
											    <th data-filterable="true" data-sortable="true">Board</th>
											   <th data-filterable="true" data-sortable="true">Admission Number</th>
										       <th data-filterable="true" data-sortable="true">Student name </th>	
                                               <th data-filterable="true" data-sortable="true">Class -Section </th>	
                                               <th data-filterable="true"  data-sortable="true" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
									 
											$emp_query="select * from student  where  ay_id='$acyear' and sel_hostel='Yes' order by firstname asc";
										 
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
		    $c_id=$emp_display["c_id"];	
		    $s_id=$emp_display["s_id"];
		    $b_id=$emp_display["b_id"];
		    
		    $admission_number=$emp_display["admission_number"];
		    
		    $firstname=stripslashes($emp_display["firstname"]);
		    $lastname=stripslashes($emp_display["lastname"]);
		    
		    
			$query=mysql_query("SELECT * FROM class where c_id='$c_id'");
			$res=mysql_fetch_array($query);
			$class_name=$res["c_name"];
			 
			$query=mysql_query("SELECT * FROM section where s_id='$s_id'");
			$res=mysql_fetch_array($query);
			$section_name=$res["s_name"];
			
			$query=mysql_query("SELECT * FROM board where b_id='$b_id'");
			$res=mysql_fetch_array($query);
			$board_name=$res["b_name"];
			
			
			$qry1=mysql_query("select * from hms_student_room where admission_number='$admission_number' and status='0' ");
			
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $board_name ;?> </td>
                                             <td><?php echo $admission_number; ?> </td>
                                           
                                             <td><?php echo $firstname."-".$lastname; ?> </td>
                                            
                                             <td><?php echo $class_name."-".$section_name; ?> </td>
                                           
                        <td>                     
                     <?php if(mysql_num_rows($qry1)==0){?>                        								 
					  <a class="btn btn-primary" type="button" <button>Register Pending</a><?php }else{?>
					                      								 
					  <a class="btn btn-success" type="button" <button>Registered</a><?php }?>
					      </td>
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