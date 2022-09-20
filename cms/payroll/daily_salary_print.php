<?php 
include("header.php");
include_once("amount_in_word.php");
//$m_value=date("m");
//$y_value=date("Y");

$m_value=$_GET['m'];
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];

if($m_value>5){
	$y_value=$syear;
}else if($m_value<=5){
	$y_value=$eyear;
}
			$emp_id=$_GET["id"];
			$emp_result=mysql_query("SELECT * FROM staff_daily_salary WHERE st_ms_id=$emp_id"); 
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
							
		
			  $months = array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"); 


			  
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
     window.print();
     document.body.onmousemove = doneyet;
}
</script>
  </head>
 <body style="background:#FFFFFF;">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="../img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css" media="all">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:950px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px;
		/*border: 2px solid #a9a6a6;*/
		  }
</style>
 					<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        <center><img src="../img/hallticket.jpg" style="width:80%;"><h4>Salary for the month of <?php echo $months[$emp_display['month']]." - ". $emp_display['year'];?></h4></center>
                       <div class="modal-body">
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
                                        	<td  colspan="3" style="border:none;"><h5>SALARY DETAILS</h5></td>
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
										//echo "select * from staff_daily_salary_summary where type='1' and st_ms_id=$emp_id and (st_id=$stid AND o_id=$oid AND d_id=$did) order by sum_id asc";die;
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
                                           <!-- <td width="48%" style="border:none;"><b><?php echo $emp_display["g_salary"];?></b></td>-->
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
                                        	<td colspan="3" style="border:none;"><b>NET SALARY : Rs. <?php echo round($emp_display["n_salary"]);?></b> (
                                            Rupees <?php $amount=round($emp_display["n_salary"]);
							 					echo convert_number_to_words($amount);?> Only
                         )</td>
                                        </tr>
                                    </table>
                                </td>                                
					          </tr>
                            </tbody>
					      </table>
                          <br><br><br><br><br><br><br><br>
<font>Staff Signature</font><font style="margin-left:400px;">Signature of the Principal</font><br/>
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>



</body>
 </html>