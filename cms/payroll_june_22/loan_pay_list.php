<?php
include("header.php");
include_once("amount_in_word.php");
$months = array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"); 
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
	   $l_id=$_GET["id"];
	   			$loanlist1=mysql_query("SELECT * FROM staff_loan WHERE l_id=$l_id"); 
								  $loandetails=mysql_fetch_array($loanlist1);
								  $s_id=$_GET["stid"];
			$type=$_GET["type"];
			if($type=='st'){
			$stid=$s_id;
			$oid=0;
			$did=0;
			$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
			  $staff1=mysql_fetch_array($stafflist);
			  $staffid=$staff1['staff_id'];
			  $path="../img/Staff/";
			}else if($type=='ow'){
				$stid=0;
				$oid=$s_id;
				$did=0;
				$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$oid"); 
			  $staff1=mysql_fetch_array($stafflist);
			  $staffid=$staff1['others_id'];			  
			  $ocid=$staff1["category_id"];			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			  $path="../img/others/";
			}else if($type=='dr'){
				$stid=0;
				$oid=0;
				$did=$s_id;
				$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
			  $staff1=mysql_fetch_array($stafflist);
			  $staffid=$staff1['driver_id'];			  
			  $path="../img/driver/";
			}
	   /*$st_id=$_GET["stid"];
								$stafflist1=mysql_query("SELECT * FROM staff WHERE st_id=$st_id"); 
								  $staff1=mysql_fetch_array($stafflist1);*/
	   ?>	
     <div id="content">	
		 <div id="content-header">
			 <h1><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> - Loan Payment List <a href="loan_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->
		 <div id="content-container">
	 <div class="row">
			 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								<?php echo $staff1["fname"]." ".$staff1["lname"]; ?> - Loan Payment List 
							 </h3>     
                             <a href="#staffModal" title="Employee Details" style="float:right;"  data-toggle="modal"><button type="button" class="btn btn-warning">Employee Details</button></a> 
                             <a href="#loanModal" title="Loan Details" style="float:right; margin-right:10px;"  data-toggle="modal"><button type="button" class="btn btn-info">Loan Details</button></a>  
                             <a href="loan_pay_down.php?id=<?php echo $l_id."&stid=".$s_id."&type=".$type."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-info">Download Report</button></a>                    
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
                                             <th data-filterable="true" data-sortable="true">Date</th> 
                                             <th data-filterable="true" data-sortable="true">Pay Amount</th> 
                                             <th data-filterable="true" data-sortable="true">Total Payment</th>                                             <th data-filterable="true" data-sortable="true">Balance</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Payslip</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										$loanlist=mysql_query("SELECT * FROM staff_loan WHERE l_id=$l_id"); 
								  $loan=mysql_fetch_array($loanlist);
								  $lpay=$loan['l_pay'];
											$emp_query="select * from staff_loan_pay where l_id=$l_id order by l_id asc";										
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		$total_pay=0;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$emp_id=$emp_display["lp_id"];	
			$emp_id=$emp_display["lp_id"];	
			$total_pay +=$emp_display["amount"];
			
			$balance=$lpay-$total_pay;
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["date"]; ?> </td>
                                             <td>Rs. <?php echo $emp_display["amount"]; ?> </td>
                                             <td>Rs. <?php echo $total_pay; ?> </td> 
                                             <td>Rs. <?php echo $balance;?></td>	
                                             <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="Print" href="monthly_salary_print.php?id=<?php echo $emp_display["st_ms_id"]; ?>&stid=<?php if($stid){ echo $stid."&type=st";}else if($oid){ echo $oid."&type=ow";}else if($did){ echo $did."&type=dr";}?>" target="_blank"><img src="img/layout/print.png"/></a></td>
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
					$loan_query1="select * from staff_loan_pay where l_id=$l_id order by l_id asc";										
		$loan_result1=mysql_query($loan_query1);
		$emp_count=1;
		while($load_display1=mysql_fetch_array($loan_result1))
		{
			$st_ms_id=$load_display1['st_ms_id'];			
			$emp_query="select * from staff_month_salary where st_ms_id=$st_ms_id";										
		$emp_result=mysql_query($emp_query);
		$emp_display=mysql_fetch_array($emp_result);
		
								$emp_id=$emp_display["st_ms_id"];
								$month=$emp_display["month"];
								$year=$emp_display["year"];
								
								$stid=$emp_display["st_id"];
								$oid=$emp_display["o_id"];
								if($stid){
								$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								  $staffid=$staff['staff_id'];
								}
								if($oid){
								$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$oid"); 
								  $staff=mysql_fetch_array($stafflist);
								  $staffid=$staff['others_id'];
								}
								if($did){
								$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								  $staff=mysql_fetch_array($stafflist);
								  $staffid=$staff['driver_id'];
								}
								
								/*$stid=$emp_display["st_id"];
								$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);*/
		?>  
<div id="styledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $months[$month]." - ".$year;?> Salary Details for <?php echo $emp_display['staff_name'];?></h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                            <tr>
                                <td width="50%" style="border-right:1px solid #CCCCCC">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Name</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b><?php echo $emp_display['staff_name'];?></b></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">Des.</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php if($emp_display['position']){ echo $emp_display['position'];}else{ echo $staff['position'];}?></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">DOJ</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php if($emp_display['doj']){ echo $emp_display['doj'];}else{ echo $staff['doj'];}?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Emp.Code</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b><?php if($emp_display['staff_id']){ echo $staffid;}else{ echo $staff['staff_id'];}?></b></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">Acc.No.</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php if($emp_display['accno']){ echo $emp_display['accno'];}else{ echo $staff['b_acc_no'];}?></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">PF No.</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php if($emp_display['pfno']){ echo $emp_display['pfno'];}else{ echo $staff['pf_no'];}?></td>
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td  colspan="3" style="border:none;"><h4>GROSS PAY</h4></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td colspan="3"  style="border:none;"><h4>DEDUCTIONS</h4></td>
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td width="50%" style="border-right:1px solid #CCCCCC">
                                	<table>
                                    <?php
									    $emp_query1="select * from staff_month_salary_summary where type='0' and st_ms_id=$emp_id and st_id=$stid order by sum_id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										?>
                                    	<tr>
                                        	<td width="50%" style="border:none;"><?php echo $emp_display1['name'];?></td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $emp_display1['amount'];?></td>
                                        </tr> 
                                        <?php } ?>                                       
                                    </table>
                                </td>
                                <td width="50%">
                                	<table>
                                    	<?php
									    $emp_query1="select * from staff_month_salary_summary where type='1' and st_ms_id=$emp_id and st_id=$stid order by sum_id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										?>
                                    	<tr>
                                        	<td width="50%" style="border:none;"><?php echo $emp_display1['name'];?></td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $emp_display1['amount'];?></td>
                                        </tr> 
                                        <?php } ?>  
                                    </table>
                                </td>
					          </tr>
                               <tr>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Gross Pay</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b><?php echo $emp_display["g_salary"];?></b></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Total Ded.</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b><?php echo $emp_display["d_total"];?></b></td>
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td colspan="2">
                                	<table width="100%">
                                    	<tr>
                                        	<td colspan="3" style="border:none;"><b>NET SALARY : Rs. <?php echo $emp_display["n_salary"];?></b> (
                                            Rupees <?php $amount=$emp_display["n_salary"];
							 					echo convert_number_to_words($amount);?> Only
                         )</td>
                                        </tr>
                                    </table>
                                </td>                                
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
        
        ?>	
        
        
        <div id="loanModal" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> - Loan Details</h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $loandetails["staff_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Employee Name</td>
					            <td>:</td>
					            <td><?php echo $loandetails["staff_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Loan Details</b>
                                </h4></td>
					          </tr>
					          <tr>
					            <td>Date </td>
					            <td>:</td>
					            <td><?php echo $loandetails["l_date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Loan Type Name</td>
					            <td>:</td>
					            <td><?php echo $loandetails["l_type_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Amount</td>
					            <td>:</td>
					            <td>Rs. <?php echo $loandetails["l_amount"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Rate Of Interest</td>
					            <td>:</td>
					            <td><?php echo $loandetails["l_interest"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Terms Of Month</td>
					            <td>:</td>
					            <td><?php echo $loandetails["l_terms"] ; ?> Months</td>
					          </tr>
                              <tr>
					            <td>Monthly Payment</td>
					            <td>:</td>
					            <td>Rs. <?php echo $loandetails["l_m_pay"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Total Inrest</td>
					            <td>:</td>
					            <td>Rs. <?php echo $loandetails["l_t_interest"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Total Payment</td>
					            <td>:</td>
					            <td>Rs. <?php echo $loandetails["l_pay"] ; ?> /-</td>
					          </tr>  
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($loandetails['status']=='0'){ ?>
                                <button class="btn btn-small btn-success" >Payment Processing</button><?php }else{?><button class="btn btn-small btn-primary" >Completely Paid</button> <?php } ?></td>
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
        
        
        
        <div id="staffModal" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="<?php echo $path.$staff1['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
        <table class="table">
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
					            <td><?php echo $staff1["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["lname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php if($did){ echo $staff1["d_pname"]; }else{ echo $staff1["s_pname"]; }?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $staff1["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $staff1["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($staff1['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $staff1["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $staff1["blood"] ; ?></td>
					          </tr>
                              <?php if($stid){?>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $staff1["s_type"] ; ?></td>
					          </tr>
                              <?php }else if($oid){?>
                              <tr>
					            <td>Category</td>
					            <td>:</td>
					            <td><?php echo $ocategory["category_name"]; ?></td>
					          </tr>
                              <?php }else if($did){?>
                              <tr>
					            <td>Driver type</td>
					            <td>:</td>
					            <td><?php echo $staff1["d_type"]; ?></td>
					          </tr>
                              <?php } ?>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $staff1["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $staff1["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $staff1["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $staff1["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php if($did){ echo $staff1["address"]; }else{ echo $staff1["address1"]; }?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $staff1["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $staff1["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $staff1["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $staff1["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $staff1["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $staff1["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $staff1["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $staff1["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $staff1["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $staff1["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $staff1["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $staff1["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($staff1['status']=='1'){ ?>
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
include("footer.php");
include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>