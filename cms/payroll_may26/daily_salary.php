<?php
include("header.php");
include_once("amount_in_word.php");
$month=date("M");
$year=date("Y");
$m_value=$_GET['m'];
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];

if($m_value>5){
	$y_value=$syear;
}else if($m_value<=5){
	$y_value=$eyear;
}
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
$query=mysql_query("select * from staff where st_id='$stid'");
$staffs=mysql_fetch_array($query);*/
?>
		 <div id="content-header">
			 <h1> <?php echo $months[$m_value]." - ".$y_value;?> Daily Salary Details </h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
         <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>
 			 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								<?php echo  $months[$m_value]." - ".$y_value;?> Daily Salary Details List 
							 </h3>  <a href="daily_salary_multiple.php" title="Add Employee Salary"><button type="button" class="btn btn-warning" style="font-size: 13px;">Multiple Salary Generate</button></a>   
                             <a href="daily_salary_single.php" title="Add Employee Salary"><button type="button" class="btn btn-warning" style="font-size: 13px;">Single Salary Generate</button></a>           
                             <a href="daily_salary_down.php?m=<?php echo $m_value."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-success" style="font-size: 13px;">Download Report</button></a> 
                            <!-- <a href="daily_salary_down_full.php?m=<?php echo $m_value."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-warining" style="font-size: 13px;">Download FullReport</button></a> -->    
<a href="daily_salary_prt_full.php?m=<?php echo $m_value."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear;?>" title="Print Report" target="_blank"><button type="button" class="btn btn-warining" style="font-size: 13px;">Print Report</button></a>								 
                             <div class="btn-group" style="float:right;padding-top: 12px;">
                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" >
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
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="daily_salary.php?m=<?php echo $m_value;?>&syear=<?php echo $syear1."&eyear=".$eyaer1;?>"><?php echo $row['y_name'];?></a></li>
                                  <?php } ?>                             		
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;padding-top: 12px;">
                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Month <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <?php                                  
                                    foreach($months as $x => $x_value) {
									   if($x==$m_value){
                                    ?>
                                <li class="active"><a href="daily_salary.php?m=<?php echo $x;?>&syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>"><?php echo $x_value; ?></a></li>
                                <?php }else{ ?>
                                <li><a href="daily_salary.php?m=<?php echo $x;?>&syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>"><?php echo $x_value; ?></a></li>
                                <?php } }?>
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
											 <th data-sortable="true">Name</th>
                                             <th data-sortable="true">Role </th>		 
											 <th data-sortable="true">Position </th>
											 <th data-sortable="true">One day Salary </th>
											 <th data-sortable="true">No of Working Days </th>
											 <th data-sortable="true">Gross Salary </th>
											 <th data-sortable="true">Deduction</th>
                                             <th data-sortable="true">Net Salary</th>
                                             <th data-sortable="true">Salary Date</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
$cur_date=date('d');
//echo "select * from staff_daily_salary where month=$m_value and year=$y_value order by staff_id desc";die;
										$emp_query="select * from staff_daily_salary where month=$m_value and year=$syear order by staff_id desc";
										//echo $emp_query;die;									
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];	
								$st_id=$emp_display["st_id"];
								$o_id=$emp_display["o_id"];	
								$d_id=$emp_display["d_id"];	
if($d_id!=0){
								$emp_que="select count(satt_id) from sattendance where month='$m_value' and year='$y_value' and d_id='$d_id' and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);
$gross_total=$fixed*$salarylistt[0];

$emp_query0="select * from staff_salary where d_id='$d_id' order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$fixed=$salarylist['salary'];
								}
								if($o_id!=0){
								$emp_que="select count(satt_id) from sattendance where month='$m_value' and year='$y_value' and o_id='$o_id' and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);
$gross_total=$fixed*$salarylistt[0];
$emp_query0="select * from staff_salary where o_id='$o_id' order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$fixed=$salarylist['salary'];
								}
											
							?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><?php echo $emp_display["staff_name"]; ?> </td>
                                             <td><?php echo $emp_display["role"]; ?> </td>
                                             <td><?php echo $emp_display["position"]; ?> </td>
                                             <td><?php echo $fixed; ?> </td>
                                             <td><?php echo $salarylistt[0]; ?> </td>
                                             <td>Rs. <?php echo round($emp_display["g_salary"]); ?> /-</td>
                                             <td>Rs. <?php echo round($emp_display["d_total"]); ?> /-</td>
                                             <td>Rs. <?php echo round($emp_display["n_salary"]); ?> /-</td>
                                             <td><?php echo $emp_display["date_day"]."-".$emp_display["date_month"]."-".$emp_display["date_year"]; ?></td>
                                             <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="Print" href="daily_salary_print.php?id=<?php echo $emp_id; ?>&stid=<?php if($st_id){ echo $st_id."&type=st";}else if($o_id){ echo $o_id."&type=ow";}else if($d_id){ echo $d_id."&type=dr";}?>" target="_blank"><img src="img/layout/print.png" /></a>
                                             <a title="Edit" href="daily_salary_edit.php?id=<?php echo $emp_id; ?>&stid=<?php if($st_id){ echo $st_id."&type=st";}else if($o_id){ echo $o_id."&type=ow";}else if($d_id){ echo $d_id."&type=dr";}?>" target="_blank"><img src="img/layout/edit.png"/></a>
                                             <a title="delete" href="daily_salary_delete.php?id=<?php echo $emp_id."&m=".$m_value."&syear=".$syear."&eyear=".$eyear;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>
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
                         <br>
                         <div class="portlet-header">
							 <h3>
								<?php echo $months[$m_value]." - ".$y_value;?> Daily Salary Not Genreated List
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
								data-paginate="true"
							>
									<thead>
										<tr>
											<th data-sortable="true" data-direction="asc">S.No</th>
											 <th data-filterable="true" data-sortable="true">Emp Code </th>
											 <th data-filterable="true" data-sortable="true">Emp Name </th>
                                             <th data-filterable="true" data-sortable="true">Role </th>											 
											 <th data-filterable="true" class="hidden-xs hidden-sm">Email </th>
                                             <th data-filterable="true" data-sortable="true">Phone No </th>                                             
                                             <th data-filterable="true" data-sortable="true" >Position</th>
										</tr>
									</thead>
									<tbody>
												
        <?php	
							$emp_query="select t1.others_id,t1.fname,t1.category_id,t1.email,t1.phone_no,t1.position from others t1 LEFT JOIN staff_daily_salary t2 ON t1.o_id = t2.o_id AND t2.month=$m_value AND t2.year=$syear WHERE t2.o_id IS NULL AND t1.status='1' and t1.s_type='1' ";
							
							$emp_result=mysql_query($emp_query);
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["o_id"];	
								$ocid=$emp_display["category_id"];
								
									$categorys=mysql_query("SELECT category_name FROM others_category WHERE oc_id='$ocid'");
									$ocategory=mysql_fetch_array($categorys);	
							?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["others_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>
                                             <td><?php echo $ocategory["category_name"]; ?></td>
                                             <td><?php echo $emp_display["email"];?></td>
                                             <td><?php echo $emp_display["phone_no"];?></td>                                             
                                             <td><?php echo $emp_display['position'];?></td>	
                                         </tr>
		<?php 
		$emp_count++;
        }
        ?>		
        <?php	
							$emp_query="select t1.driver_id,t1.fname,t1.d_type,t1.email,t1.phone_no,t1.position from driver t1 LEFT JOIN staff_daily_salary t2 ON t1.d_id = t2.d_id AND t2.month=$m_value AND t2.year=$y_value WHERE t2.d_id IS NULL AND t1.status='1' and t1.s_type='1'";
							$emp_result=mysql_query($emp_query);
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["d_id"];	
							?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["driver_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>
                                             <td><?php echo $emp_display["d_type"]; ?> </td>
                                             <td><?php echo $emp_display["email"];?></td>
                                             <td><?php echo $emp_display["phone_no"];?></td>                                             
                                             <td><?php echo $emp_display['position'];?></td>	
                                         </tr>
		<?php 
		$emp_count++;
        }
        ?>				
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
						 </div>
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper --> 
 
<?php
				/* 	$emp_query="select * from staff_daily_salary where month=$m_value and year=$y_value order by st_ms_id desc";								
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];
								//$emp_id=$emp_display["st_ms_id"];
								//$stid=$emp_display["st_id"];
								$oid=$emp_display["o_id"];
								$did=$emp_display["d_id"];
								
								if($oid){
								$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$oid"); 
								  $staff=mysql_fetch_array($stafflist);
								  $staffid=$staff['others_id'];
								}
								if($did){
								$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								  $staff=mysql_fetch_array($stafflist);
								  $staffid=$staff['driver_id'];
								} */
								
								$cur_date=date('d');
//echo "select * from staff_daily_salary where month=$m_value and year=$y_value order by staff_id desc";die;
										$emp_query="select * from staff_daily_salary where month=$m_value and year=$y_value order by staff_id desc";
										//echo $emp_query;die;									
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];	
								$st_id=$emp_display["st_id"];
								$o_id=$emp_display["o_id"];	
								$d_id=$emp_display["d_id"];	
if($d_id!=0){
								$emp_que="select count(satt_id) from sattendance where month='$m_value' and year='$y_value' and d_id='$d_id' and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);
$gross_total=$fixed*$salarylistt[0];

$emp_query0="select * from staff_salary where d_id='$d_id' order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$fixed=$salarylist['salary'];
								}
								if($o_id!=0){
								$emp_que="select count(satt_id) from sattendance where month='$m_value' and year='$y_value' and o_id='$o_id' and result='1'";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);
$gross_total=$fixed*$salarylistt[0];
$emp_query0="select * from staff_salary where o_id='$o_id' order by id desc limit 1";
$emp_result0=mysql_query($emp_query0);
$salarylist=mysql_fetch_array($emp_result0);
$fixed=$salarylist['salary'];
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
                                        	<td  colspan="3" style="border:none;"><h4>SALARY DETAILS</h4></td>
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
                               <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    <?php
									   /*  $emp_query1="select * from staff_daily_salary_summary where type='0' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{ */
									
									
									
										?>
                                    	 <tr>
                                        	<td width="50%" style="border:none;">One day Salary</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $fixed;?></td>
                                            
											</tr>
											 <tr>
											<td width="50%" style="border:none;">No of Working days</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $salarylistt[0]; ?> </td>
											
                                        </tr>
                                        <?php //} ?>                                       
                                    </table>
                                </td>
                                <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    	<?php
										//echo "select * from staff_daily_salary_summary where type='1' and st_ms_id=$emp_id and (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) order by sum_id asc";
									    $emp_query1="select * from staff_daily_salary_summary where type='1' and st_ms_id=$emp_id and (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) order by sum_id asc";
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
										
									   /*  $emp_query1="select * from staff_daily_salary_summary where type='2' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";
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
                                        <?php }  */?>  
                                    </table>
                                </td>
					          </tr>
                              
                               <tr>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Gross Pay</td>
                                            <td style="border:none;">:</td>
                                            <!--<td width="48%" style="border:none;"><b><?php echo $emp_display["g_salary"];?></b></td>-->
											<td width="48%" style="border:none;"><b><?php echo $fixed.' * '.$salarylistt[0].' = '.$emp_display["g_salary"];?></b></td>
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
<?php
include("footer.php");
include("includes/script.php");?>
</body>
</html>
 <? ob_flush(); ?>