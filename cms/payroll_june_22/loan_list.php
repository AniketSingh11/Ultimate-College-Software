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
			 <h1> Loan Details List <?php if($year){ echo "(".$year.")";}?></h1><?php if($year || $ltype){?><span style="float:right; margin-right:30px;"><b>Filter by : </b><?php if($year){ echo " Year = ".$year;} if($ltype && $year){ echo " | "; } if($ltype){ echo " Loan Type = ".$ltype;}?></span><?php } ?>
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
								Loan Details List  <?php if($year){ echo "(".$year.")";}?>
							 </h3>
                             <a href="loan_add.php" title="Apply Loan"><button type="button" class="btn btn-warning">Apply Loan</button></a>
                             <a href="loan_type.php" title="Loan types List"><button type="button" class="btn btn-tertiary">Loan types List</button></a>
                             <a href="loan_down.php?ltype=<?php echo $ltype."&year=".$year."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-info">Download Report</button></a>
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Loan Type <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <li <?php if(!$ltype){ echo 'class="active"';}?>><a href="loan_list.php<?php if($year){ echo "?year=".$year;}?>">Over All</a></li>
                              <?php
							  $loan_typelist=mysql_query("select * from staff_loan_type order by lt_id asc");
						while($loantype=mysql_fetch_array($loan_typelist))
						{
							$lt_id=$loantype['lt_id'];
							?>
                                <li <?php if($ltype==$lt_id){ echo 'class="active"';}?>><a href="loan_list.php?ltype=<?php echo $lt_id;?><?php if($year){ echo "&year=".$year;}?>"><?php echo $loantype['name'];?></a></li>
                                <?php } ?>                                
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
							    Filter by Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                  <li <?php if(!$year){ echo 'class="active"';}?>><a href="loan_list.php<?php if($ltype){ echo "?ltype=".$ltype;}?>">Over All</a></li>
                                  <?php for($i=$start;$i<=$tyear;$i++){ ?>
                                  <li <?php if($year==$i){ echo 'class="active"';}?>><a href="loan_list.php?year=<?php echo $i;?><?php if($ltype){ echo "&ltype=".$ltype;}?>"><?php echo $i;?></a></li>
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
											 <th data-filterable="true" data-sortable="true">Emp Code</th>
											 <th data-filterable="true" data-sortable="true">Emp Name </th>
                                             <th data-filterable="true" data-sortable="true">Date </th>											 
											 <th data-filterable="true" data-sortable="true">Loan type</th>
                                             <th data-filterable="true" data-sortable="true">Amount</th>                                             
                                             <th data-filterable="true" data-sortable="true">monthly pay</th>
                                             <th data-sortable="true">Status</th>
                                             <th data-sortable="true">Payments</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											$emp_query="select * from staff_loan";										
											if($ltype && $year){
											$emp_query .=" where l_type=$ltype AND year=$year";										
											}else if($ltype && !$year){
											$emp_query .=" where l_type=$ltype";										
											}else if(!$ltype && $year){
												$emp_query .=" where year='$year'";										
											}
											$emp_query .=" order by l_id desc";	
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$l_id=$emp_display["l_id"];	
			$emp_id=$emp_display["st_id"];
			$emp_id1=$emp_display["o_id"];	
			$emp_id2=$emp_display["d_id"];	
			$status=$emp_display["status"];
			
			$loanpay1=mysql_query("SELECT * FROM staff_loan_pay WHERE l_id=$l_id"); 
								  $loanpay=mysql_fetch_array($loanpay1);
								  if($emp_display['status']=='0'){
									  $pament="Payment Processing";
								  }else{
									  $pament="Completely Paid";
								  }	
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["staff_name"]; ?> </td>
                                             <td><?php echo $emp_display["l_date"]; ?> </td>
                                             <td><?php echo $emp_display["l_type_name"]; ?> </td>
                                             <td>Rs. <?php echo $emp_display["l_amount"]; ?> </td> 
                                             <td>Rs. <?php echo $emp_display['l_m_pay'];?></td>	
                                             <td><?php if($status==1){ ?><button type="button" class="btn btn-success">Closed</button><?php } else{ ?><button type="button" class="btn btn-danger">Processing</button> <?php } ?></td>
                                             <td><a href="loan_pay_list.php?id=<?php echo $l_id;?>&stid=<?php if($emp_id){ echo $emp_id."&type=st";}else if($emp_id1){ echo $emp_id1."&type=ow";}else if($emp_id2){ echo $emp_id2."&type=dr";}?>"<button type="button" class="btn btn-secondary">View</button></a></td>	
                                             <td><a title="Loan Details" href="#loanModal<?php echo $emp_count.''.$l_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> 
                                             <a title="Employee Details" href="#styledModal<?php echo $emp_count.''.$l_id;?>" data-toggle="modal"><img src="img/layout/user.png"/></a>
                                             <a title="edit" href="loan_edit.php?id=<?php echo $l_id; ?>"><img src="img/layout/edit.png"/></a>
                                             <?php if(!$loanpay){?> <a title="delete" href="loan_delete.php?id=<?php echo $l_id;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> <?php }?> </td>
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
				$emp_query1="select * from staff_loan";										
				if($ltype && $year){
				$emp_query1 .=" where l_type=$ltype AND year=$year";										
				}else if($ltype && !$year){
				$emp_query1 .=" where l_type=$ltype";										
				}else if(!$ltype && $year){
					$emp_query1 .=" where year=$year";										
				}
				$emp_query1 .=" order by l_id desc";									
		$emp_result1=mysql_query($emp_query1);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$l_id=$emp_display1["l_id"];	
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
        
        <div id="loanModal<?php echo $emp_count.''.$l_id;?>" class="modal modal-styled fade">
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
                                    <b>Loan Details</b>
                                </h4></td>
					          </tr>
					          <tr>
					            <td>Date </td>
					            <td>:</td>
					            <td><?php echo $emp_display1["l_date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Loan Type Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["l_type_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Amount</td>
					            <td>:</td>
					            <td>Rs. <?php echo $emp_display1["l_amount"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Rate Of Interest</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["l_interest"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Terms Of Month</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["l_terms"] ; ?> Months</td>
					          </tr>
                              <tr>
					            <td>Monthly Payment</td>
					            <td>:</td>
					            <td>Rs. <?php echo $emp_display1["l_m_pay"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Total Inrest</td>
					            <td>:</td>
					            <td>Rs. <?php echo $emp_display1["l_t_interest"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Total Payment</td>
					            <td>:</td>
					            <td>Rs. <?php echo $emp_display1["l_pay"] ; ?> /-</td>
					          </tr> 
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display1['status']=='0'){ ?>
                                <button class="btn btn-small btn-success" >Payment Processing</button><?php }else{?><button class="btn btn-small btn-primary" >Completely Paid</button> <?php } ?></td>
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
<div id="styledModal<?php echo $emp_count.''.$l_id;?>" class="modal modal-styled fade">
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