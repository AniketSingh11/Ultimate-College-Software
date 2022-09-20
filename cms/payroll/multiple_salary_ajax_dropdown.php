<?php include("../includes/config.php");
$val=$_GET['value'];
$month_val=explode('-',$val);
$month=$month_val[0];
$yr=$month_val[1]; 
$day=date("d");
$find_date='01-'.$month.'-'.$yr;
$date=strtotime($find_date);
$newDate = date('Y-m-d',strtotime('-1 month',$date));
//$d=date("Y-m-d");
$d=$yr.'-'.$month.'-'.$day;

?>


<div class="form-group" >
<label for="name">Employee ID</label>
<select id="employeez" name="employee" class="" style="width:50%" onchange="select_employee()"  multiple="multiple">

									
                                        <?php 
										// $month=date('m');
//$yr=date('Y');



								$emp_query="select * from staff WHERE status='1' and  relivestatus='0' and st_id not in (select st_id FROM staff_month_salary WHERE month =$month and year=$yr)";
										 
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];?>
                                    <option value="<?php echo $emp_id.".st";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from others WHERE status='1' and s_type='0' and relivestatus='0' and o_id not in (select o_id FROM staff_month_salary WHERE month =$month and year=$yr)";
								 
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                         <option value="<?php echo $emp_id.".ow";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from driver WHERE status='1' and s_type='0' and relivestatus='0'  and  d_id not in (select d_id FROM staff_month_salary WHERE month =$month and year=$yr)";
								
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["d_id"];?>
                                         <option value="<?php echo $emp_id.".dr";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["driver_id"]; ?></option>
                                  <?php }
								
								  $emp_query="select * from staff WHERE relivestatus='1' and STR_TO_DATE( dor,  '%m/%d/%Y' ) BETWEEN STR_TO_DATE('$newDate',  '%Y-%m-%d' ) AND STR_TO_DATE('$d',  '%Y-%m-%d') and st_id not in (select st_id FROM staff_month_salary WHERE month =$month and year=$yr)";
										 
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];?>
                                    <option value="<?php echo $emp_id.".st";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  
								   
								  $emp_query="select * from others WHERE relivestatus='1' and s_type='0' and STR_TO_DATE( dor,  '%m/%d/%Y' ) BETWEEN STR_TO_DATE('$newDate',  '%Y-%m-%d' ) AND STR_TO_DATE('$d',  '%Y-%m-%d') and o_id not in (select o_id FROM staff_month_salary WHERE month =$month and year=$yr)";
								 
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                         <option value="<?php echo $emp_id.".ow";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								   $emp_query="select * from driver WHERE relivestatus='1' and s_type='0' and STR_TO_DATE( dor,  '%m/%d/%Y' ) BETWEEN STR_TO_DATE('$newDate',  '%Y-%m-%d' ) AND STR_TO_DATE('$d',  '%Y-%m-%d') and o_id not in (select o_id FROM staff_month_salary WHERE month =$month and year=$yr)";
								
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["d_id"];?>
                                         <option value="<?php echo $emp_id.".dr";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["driver_id"]; ?></option>
                                  <?php }
								  
								  ?>
								  
								  
								  
								  </select></div>	
								  

<link rel="stylesheet" href="./css/multiple-select.css">
<script src="./js/jquery.min.js"></script>
<script src="./js/multiple-select.js"></script>
  

