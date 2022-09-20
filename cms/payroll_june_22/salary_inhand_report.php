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
	   $ltype=$_GET['ltype'];	
 	   $year=$_GET['year'];
	   $tyear=date("Y");
	   					  	$ayear1=mysql_query("SELECT * FROM year ORDER BY s_year ASC");
								$ay1=mysql_fetch_array($ayear1);
								$start=$ay1['s_year'];
								?>
     <div id="content">		
		
		 <div id="content-header">
			 <h1> Salary Report Generate <?php if($year){ echo "(".$year.")";}?></h1><?php if($year){?><span style="float:right; margin-right:30px;"><b>Filter by : </b><?php if($year){ echo " Year = ".$year;}?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>	 <div class="row">
			 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Salary Report Generate <?php if($year){ echo "(".$year.")";}?>
							 </h3>
                             <a href="salary_inhand.php" title="Salary Report Generate"><button type="button" class="btn btn-warning">Salary Report Generate</button></a>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
							    Filter by Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <li <?php if(!$year){ echo 'class="active"';}?>><a href="salary_inhand_filter.php">Over All</a></li>
                              <?php for($i=$start;$i<=$tyear;$i++){ ?>
                               <li <?php if($year==$i){ echo 'class="active"';}?>><a href="salary_inhand_filter.php?year=<?php echo $i;?>"><?php echo $i;?></a></li>
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
								data-paginate="true"
							>
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true">Months</th>
                                             
											 <th data-filterable="true" data-sortable="true">Title </th>
                                            
                                             <th data-filterable="true" data-sortable="true">Amount</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="12%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											$emp_query="select * from salary_inhand";										
											if($year){
											$emp_query .=" WHERE year=$year";
											}
											$emp_query .=" order by month DESC";	
											
											//echo $emp_query; die;
								$emp_result=mysql_query($emp_query);
								
								$emp_count=1;
								while($emp_display=mysql_fetch_array($emp_result))
								{
								
									$id=$emp_display["id"];	
									$month=$emp_display["month"];
									$year=$emp_display["year"];		
									$total=$emp_display["total"];	
								?>                         
										<tr>
											 <td><?php echo $emp_count++;?> </td>
                                             <td><?php echo $emp_display["month"]."-".$emp_display["year"]; ?> </td>
                                            
                                             <td><?php echo $emp_display["title"]; ?> </td>
                                            
                                             <td>Rs. <?php echo round($total); ?> </td> 
                                             <td>
                                             <a title="edit" href="salary_inhand_edit.php?id=<?php echo $id; ?>"><img src="img/layout/edit.png"/></a>
                                              <a title="delete" href="salary_inhand_delete.php?id=<?php echo $id;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>
                                              <a title="Print" href="salary_inhand_prt.php?id=<?php echo $id; ?>" target="_blank"><img src="img/layout/print.png"/></a></td>
										 </tr>
		<?php         
				
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
				$emp_query1="select * from staff_advance";										
											if($year){
											$emp_query1 .=" where year=$year";										
											}
											$emp_query1 .=" order by a_id desc";	
		$emp_result1=mysql_query($emp_query1);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$a_id=$emp_display1["a_id"];
			$status=$emp_display1["status"];		
			
			$st_id=$emp_display1["st_id"];	
			$o_id=$emp_display1["o_id"];	
			$d_id=$emp_display1["d_id"];	
			/*$emp_query=mysql_query("select * from staff where st_id='$emp_id'");
			$emp_display=mysql_fetch_array($emp_query);	*/
			
			if($st_id){		
			$emp_query11="select * from staff where st_id='$st_id'";
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['staff_id'];
			$path="../img/Staff/";
			}
			if($o_id){		
			$emp_query11="select * from others where o_id='$o_id'";
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);	
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['others_id'];
			$ocid=$emp_display["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			$path="../img/others/";
			}
			if($d_id){		
			$emp_query11="select * from driver where d_id='$d_id'";
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);	
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['driver_id'];
			$path="../img/driver/";
			}

		?>  
        
        <div id="loanModal<?php echo $emp_count.''.$a_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staffname; ?> - Loan Details</h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                            <tbody>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["staff_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Employee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["staff_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Advance Details</b>
                                </h4></td>
					          </tr>
					          <tr>
					            <td>Date </td>
					            <td>:</td>
					            <td><?php echo $emp_display1["a_date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Amount</td>
					            <td>:</td>
					            <td>Rs. <?php echo $emp_display1["a_amount"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display1['status']=='0'){ ?>
                                <button class="btn btn-small btn-success" >Pending</button><?php }else{?><button class="btn btn-small btn-primary" >Received</button> <?php } ?></td>
					          </tr>                            
					        </tbody>
					      </table>
					        </tbody>
					      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div id="styledModal<?php echo $emp_count.''.$a_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["fname"]." ".$emp_display["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      
      <center><img class="thumbnail" src="<?php echo $path.$emp_display['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
        <table class="table">
					        <!--<thead>
					          <tr>
					            <th width="5%">S.no</th>
					            <th>Tilte</th>
					            <th></th>
					            <th>Details</th>
					          </tr>
					        </thead>-->
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Personal Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $staffid; ?></td>
					          </tr>
					          <tr>
					            <td>First Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lname"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php if($d_id){ echo $emp_display["d_pname"]; }else{ echo $emp_display["s_pname"]; }?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $emp_display["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $emp_display["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($emp_display['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $emp_display["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $emp_display["blood"] ; ?></td>
					          </tr>
                              <?php if($st_id){?>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_type"] ; ?></td>
					          </tr>
                              <?php }else if($o_id){?>
                              <tr>
					            <td>Category</td>
					            <td>:</td>
					            <td><?php echo $ocategory["category_name"]; ?></td>
					          </tr>
                              <?php }else if($d_id){?>
                              <tr>
					            <td>Driver type</td>
					            <td>:</td>
					            <td><?php echo $ocategory["d_type"]; ?></td>
					          </tr>
                              <?php } ?>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $emp_display["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $emp_display["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $emp_display["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php  if($d_id){ echo $emp_display["address"]; }else{ echo $emp_display["address1"]; } ?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $emp_display["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $emp_display["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $emp_display["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?></td>
					          </tr>
					        </tbody>
					      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<?php         
		$emp_count++;		
        }
include("footer.php");
include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>