<?php
include("header.php");
include_once("amount_in_word.php");
			$emp_id=$_GET["id"];
			$emp_result=mysql_query("SELECT * FROM staff_month_salary WHERE st_ms_id=$emp_id"); 
			  $emp_display=mysql_fetch_array($emp_result);
			$s_id=$_GET["stid"];
			$type=$_GET["type"];
			if($type=='st'){
			$stid=$s_id;
			$oid=0;
			$did=0;
			$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
			  $staff=mysql_fetch_array($stafflist);
			  $staffid=$staff['staff_id'];
			}else if($type=='ow'){
				$stid=0;
				$oid=$s_id;
				$did=0;
				$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$oid"); 
			  $staff=mysql_fetch_array($stafflist);
			  $staffid=$staff['others_id'];
			}
			else if($type=='dr'){
				$stid=0;
				$oid=0;
				$did=$s_id;
				$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
			  $staff=mysql_fetch_array($stafflist);
			  $staffid=$staff['driver_id'];
			}
			
		
			  $months = array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"); 	
		
  if(isset($_POST["submit"]))
  {
	  $salary_date1= mysql_real_escape_string($_POST["salary_date1"]);
	
		  $sdate_split2= explode('-', $salary_date1);		 
		  $sdate_day1=$sdate_split2[0];
		  $sdate_month1=$sdate_split2[1];
		  $sdate_year1=$sdate_split2[2];
		  
		   $qry="UPDATE staff_month_salary SET date_day='$sdate_day1',date_month='$sdate_month1',date_year='$sdate_year1' WHERE st_ms_id='$emp_id'";
$result = mysql_query($qry) or die("Could not edit data into DB: " . mysql_error());

if($result){
	header("location:monthly_salary_edit.php?id=$emp_id&stid=$s_id&type=$type&msg=succ");	
}else{
	header("location:monthly_salary_edit.php?id=$emp_id&stid=$s_id&type=$type&msg=err");	
}
		  }
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
			 <h1> Employee Salary Add <a href="monthly_salary.php?m=<?php echo date("m");?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This Month already payslip generated for that employee!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Employee Salary Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" name="monthlysal" enctype="multipart/form-data">
				 <div class="portlet-content">
     
      <div class="col-sm-12">
     <div class="col-sm-6">
     <div class="form-group">
									<label for="name">Date</label>
                                    <div>
		                                <input id="salary_date" name="salary_date" class="form-control parsley-validated parsley-success" type="text" data-required="true" value="<?php echo $months[$emp_display['month']]." - ". $emp_display['year'];?>" readonly>
		                            </div>
								</div>
								<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staff_id" name="staff_id" class="form-control parsley-validated" data-required="true" value="<?php if($emp_display['staff_id']){ echo $emp_display['staff_id'];}else{ echo $staffid;}?>" readonly="">
								</div>
                       </div>
    
     <div class="col-sm-6">
     <div class="form-group">
									<label for="name">Employee Name</label>
									<input type="text" id="staff_name" name="staff_name" class="form-control parsley-validated" data-required="true" value="<?php echo $emp_display['staff_name'];?>" readonly="">
								</div>
                                <div class="form-group">
									<label for="name">Salary Given Date</label>
                                <div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date1" name="salary_date1" class="form-control" type="text" data-required="true" value="<?php echo $emp_display['date_day']."-".$emp_display['date_month']."-".$emp_display['date_year'];?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
       </div>               
       </div>           
       <div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>
</form>
        <div class="clear"></div>
        <p class="title">Salary Details :</p> 
       <div class="col-sm-12">
       	<table class="table">
					        <tbody>
                            <tr>
                                <td width="50%" style="border:1px solid #CCCCCC">
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
                                <td width="50%" style="border:1px solid #CCCCCC">
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
                                        	<td  colspan="3" style="border:none;"><h5>GROSS PAY</h5></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td colspan="3"  style="border:none;"><h5>DEDUCTIONS</h5></td>
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    <?php
									    $emp_query1="select * from staff_month_salary_summary where type='0' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
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
                                        <?php } if($emp_display['extra_salary']!=""){ ?>    
<tr>
                                        	<td width="50%" style="border:none;"><?php echo "Extra Salary";?></td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $emp_display["extra_salary"];?></td>
                                        </tr> 
										<?php } ?>                                      
                                    </table>
                                </td>
                                <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    	<?php
									    $emp_query1="select * from staff_month_salary_summary where type='1' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
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
										
									    $emp_query1="select * from staff_month_salary_summary where type='2' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
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
        
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 ?>
<script type="text/javascript">
$(document).ready(function(){});
</script>
<?php include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>