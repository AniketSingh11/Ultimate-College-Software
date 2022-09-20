<?php
include("header.php");
include_once("amount_in_word.php");
$month=date("M");
$year=date("Y");
$o_id=$_GET['id'];
$stafflist1=mysql_query("SELECT * FROM others WHERE o_id=$o_id"); 
								  $staff1=mysql_fetch_array($stafflist1);								  
								  $ocid=$staff1["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);	
								  
$y_value=$_GET['y'];
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May");

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
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
	   ?>
     <div id="content">		
		<?php
		/*$stid=$_GET['id'];
$query=mysql_query("select * from others where o_id='$stid'");
$staffs=mysql_fetch_array($query);*/
?>
		 <div id="content-header">
			 <h1> <?php echo $staff1['fname']." ".$staff1['lname']." - (".$syear."-".$eyear.")";?> Salary Details <a href="ow_day_salary_detail.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 			 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								<?php echo $staff1['fname']." ".$staff1['lname']." - (".$syear."-".$eyear.")";?> Salary Details List 
							 </h3>    
                             <a href="#staffModal" title="Employee Details" style="float:right;"  data-toggle="modal"><button type="button" class="btn btn-warning">Employee Details</button></a>   
                              <a href="daily_salary_detail1_down.php?id=<?php echo $o_id."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-success">Download Report</button></a>                       
                             <div class="btn-group" style="float:right;margin-right:10px;">
                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <?php 
							  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT * FROM year");
							  while($row=mysql_fetch_array($qry))
								{
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];?>
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="daily_salary_detail1.php?id=<?php echo $o_id;?>&syear=<?php echo $syear1."&eyear=".$eyaer1;?>"><?php echo $row['y_name'];?></a></li>
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
                                            <th data-sortable="true">Month</th>
                                            <th data-sortable="true">Net Salary</th>
                                            <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											 $emp_query="select * from staff_daily_salary where o_id=$o_id AND ((year=$syear AND month>5) OR (year=$eyear AND month<=5)) order by st_ms_id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];								
							?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><?php echo $months[$emp_display["month"]]." - ".$emp_display["year"]; ?></td>
                                           
                                             <td>Rs. <?php echo $emp_display["n_salary"]; ?> /-</td>
                                             <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="Print" href="daily_salary_print.php?id=<?php echo $emp_id; ?>&stid=<?php echo $o_id."&type=ow"; ?>" target="_blank"><img src="img/layout/print.png"/></a> </td>
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
					$emp_query="select * from staff_daily_salary where o_id=$o_id AND ((year=$syear AND month>5) OR (year=$eyear AND month<=5)) order by st_ms_id desc";																						
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];
								$stid=$emp_display["o_id"];
								$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								  
								  if($emp_display["month"]>5){
	$y_value=$syear;
}else if($emp_display["month"]<=5){
	$y_value=$eyear;
}
		?>  
<div id="styledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $months[$m_value]." - ".$y_value;?> Salary Details for <?php echo $emp_display['staff_name'];?></h3>
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
                                            <td width="48%" style="border:none;"><b><?php if($emp_display['staff_id']){ echo $emp_display['staff_id'];}else{ echo $staffid;}?></b></td>
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
									
									    $emp_query1="select * from staff_daily_salary_summary where type='0' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
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
									    $emp_query1="select * from staff_daily_salary_summary where type='1' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
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
                                        <?php } 
										$emp_query1="select * from staff_daily_salary_summary where type='2' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										?>
                                    	<tr>
                                        	<td width="50%" style="border:none;"><?php echo $emp_display1['name'];?></td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $emp_display1['amount']."&nbsp;&nbsp;&nbsp;&nbsp;( Leave - ".$emp_display["tleave"]." ) ";?></td>
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
        
        <div id="staffModal" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staff1["fname"]." ".$staff1["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      <center><img class="thumbnail" src="../img/others/<?php echo $staff1['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
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
					            <td><?php echo $staff1["others_id"] ; ?></td>
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
					            <td><?php echo $staff1["s_pname"] ; ?></td>
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
                              <tr>
					            <td>Category</td>
					            <td>:</td>
					            <td><?php echo $ocategory["category_name"]; ?></td>
					          </tr>
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
					            <td><?php echo $staff1["address1"] ; ?></td>
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