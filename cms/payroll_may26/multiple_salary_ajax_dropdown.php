<?php include("../includes/config.php"); ?>

                                    	<div class="form-group" >
									<label for="name">Employee ID</label>
									<select id="employeez" name="employee" class="" style="width:50%" onchange="select_employee()"  multiple="multiple">
									
									
                                        <?php 
										// $month=date('m');
//$yr=date('Y');
$val=$_GET['value'];
 $month_val=explode('-',$val);
 $month=$month_val[0];
 $yr=$month_val[1];
										$emp_query="select * from staff WHERE status='1' and st_id not in (select st_id FROM staff_month_salary WHERE month =$month and year=$yr)";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["st_id"];?>
                                    <option value="<?php echo $emp_id.".st";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["staff_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from others WHERE status='1' and (s_type='0' or s_type='') and o_id not in (select o_id FROM staff_month_salary WHERE month =$month and year=$yr)";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["o_id"];?>
                                         <option value="<?php echo $emp_id.".ow";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["others_id"]; ?></option>
                                  <?php } 
								  $emp_query="select * from driver WHERE status='1' and (s_type='0' or s_type='')  and d_id not in (select d_id FROM staff_month_salary WHERE month =$month and year=$yr)";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$emp_id=$emp_display["d_id"];?>
                                         <option value="<?php echo $emp_id.".dr";?>" class="mutliSelect"><?php echo $emp_display["fname"]." ".$emp_display["lname"]." - ".$emp_display["driver_id"]; ?></option>
                                  <?php }?>	</select></div>	
								  
<link href="http://wenzhixin.net.cn/p/multiple-select/multiple-select.css" rel="stylesheet"/>
<script src="http://wenzhixin.net.cn/p/multiple-select/docs/assets/jquery.min.js" type="text/javascript"></script>
<script src="http://wenzhixin.net.cn/p/multiple-select/multiple-select.js"></script>
  

