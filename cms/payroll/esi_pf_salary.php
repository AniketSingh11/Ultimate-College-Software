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
			 <h1> <?php echo $months[$m_value]." - ".$y_value;?> EPF and ESI Details </h1>
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
								<?php echo $months[$m_value]." - ".$y_value;?> EPF and ESI Details List 
							 </h3>
                             <a href="esi_pf_salary_down.php?m=<?php echo $m_value."&syear=".$syear."&eyear=".$eyear."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-success">Download Report</button></a>                  
                             <div class="btn-group" style="float:right;">
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
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="esi_pf_salary.php?m=<?php echo $m_value;?>&syear=<?php echo $syear1."&eyear=".$eyaer1;?>"><?php echo $row['y_name'];?></a></li>
                                  <?php } ?>                             		
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Month <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <?php                                  
                                    foreach($months as $x => $x_value) {
									   if($x==$m_value){
                                    ?>
                                <li class="active"><a href="esi_pf_salary.php?m=<?php echo $x;?>&syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>"><?php echo $x_value; ?></a></li>
                                <?php }else{ ?>
                                <li><a href="esi_pf_salary.php?m=<?php echo $x;?>&syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>"><?php echo $x_value; ?></a></li>
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
											 <th data-sortable="true">Salary </th>
											 <th data-sortable="true">EPF</th>
                                             <th data-sortable="true">Mng. EPF</th>
                                             <th data-sortable="true">ESI</th>
                                             <th data-sortable="true">Mng. ESI</th>
                                             <th data-sortable="true">EPF Total</th>
                                             <th data-sortable="true">ESI Total</th>
                                             <th data-sortable="true">Total</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										$myarray = array();
										$cur_yr=date('Y');
										
										$alldedlist2=mysql_query("SELECT id FROM staff_allw_ded WHERE pe_type!=0"); 
								  while($allded2=mysql_fetch_assoc($alldedlist2))
								  { 	
								  $adid=$allded2['id'];
								  array_push($myarray,$adid);
								  }
								 
										$emp_query="SELECT DISTINCT a.* FROM staff_month_salary a, staff_month_salary_summary b WHERE a.month=$m_value AND a.year=$y_value AND a.st_ms_id = b.st_ms_id AND b.ad_id IN (".implode(',',$myarray).") AND b.pevalue AND b.amount"; 
										//$emp_query="SELECT DISTINCT a.* FROM staff_month_salary a, staff_month_salary_summary b WHERE a.month=$m_value AND a.year=$y_value AND a.st_ms_id = b.st_ms_id AND b.ad_id IN (".implode(',',$myarray).")"; 
							//$emp_query="select * from staff_month_salary where month=$m_value and year=$y_value order by st_ms_id desc";	
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								
								$emp_id=$emp_display["st_ms_id"];	
								$st_id=$emp_display["st_id"];
								$o_id=$emp_display["o_id"];	
								$d_id=$emp_display["d_id"];	
								$esipf=mysql_query("SELECT ad_id,amount,pevalue FROM staff_month_salary_summary WHERE st_ms_id=$emp_id AND ad_id IN (".implode(',',$myarray).")");		
								//echo "SELECT ad_id,amount,pevalue FROM staff_month_salary_summary WHERE st_ms_id=$emp_id AND ad_id IN (".implode(',',$myarray).")";die;
								while($esipflist=mysql_fetch_assoc($esipf))
								  { 	
								  	if($esipflist['ad_id']=='8'){
										$PFstaffpreamount=$esipflist['amount'];
										$PFpreamount=$esipflist['pevalue'];
									}else if($esipflist['ad_id']=='10'){
										$ESIstaffpreamount=$esipflist['amount'];
										$ESIpreamount=$esipflist['pevalue'];
									}
								  }
								  $ESItotal=$ESIstaffpreamount+$ESIpreamount;
								  $EPFtotal=$PFstaffpreamount+$PFpreamount;
								  $total=$ESItotal+$EPFtotal;
															
							?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><?php echo $emp_display["staff_name"]; ?> </td>
                                             <td><?php echo $emp_display["role"]; ?> </td>
                                             <td>Rs. <?php echo $emp_display["n_salary"]; ?> /- </td>
                                             <td><?php echo $PFstaffpreamount; ?></td>
                                             <td><?php echo $PFpreamount; ?></td>
                                             <td><?php echo $ESIstaffpreamount; ?></td>
                                             <td><?php echo $ESIpreamount; ?> </td>
                                             <td><?php echo $EPFtotal; ?></td>
                                             <td><?php echo $ESItotal; ?></td>
                                             <td><b>Rs. <?php echo round($total); ?></b> /-</td>
                                             <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> 
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
                         
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper --> 
 				<?php
					$emp_query="SELECT DISTINCT a.* FROM staff_month_salary a, staff_month_salary_summary b WHERE a.month=$m_value AND a.year=$y_value AND a.st_ms_id = b.st_ms_id AND b.ad_id IN (".implode(',',$myarray).") AND b.pevalue"; 								
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["st_ms_id"];
								$stid=$emp_display["st_id"];
								$oid=$emp_display["o_id"];
								$did=$emp_display["d_id"];
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
                                        <?php } ?>                                       
                                    </table>
                                </td>
                                <td width="50%">
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