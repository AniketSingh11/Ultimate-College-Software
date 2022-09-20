<?php
include("../includes/config.php"); 
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
if((isset ($_GET['value']) && $_GET['value']!=''))
{
   $value=$_GET['value'];
   $sdate_split1= explode('-', $value);
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];	
		  
		  echo '<table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">
                            <tr>
                            <th>S.No</th>
                            <th>Teacher\'s Name</th>
                            <th>Designation</th>
                            <th>AC/No</td>
                            <th>Salary</th>
                            </tr>';
		  $emp_query="select * from staff_month_salary where month=$sdate_month and year=$sdate_year order by st_ms_id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							$total=0;
							while($emp_display=mysql_fetch_assoc($emp_result))
							{
								
								$emp_id=$emp_display["st_ms_id"];	
								$bank=0;
								$st_id=$emp_display["st_id"];
								if($st_id && mysql_num_rows(mysql_query("SELECT st_id FROM staff WHERE salarytype='0'  AND st_id=$st_id"))){
									$amt=$emp_display["n_salary"];
									$bank=1;
								}
								
								if($st_id && mysql_num_rows(mysql_query("SELECT st_id FROM staff WHERE extra_salary_type='0' AND st_id=$st_id"))){
									$val=mysql_fetch_array(mysql_query("SELECT * FROM staff WHERE extra_salary_type='0' AND st_id=$st_id"));
									$amt1=$val["extra_salary"];
									$bank=2;
								}
								$o_id=$emp_display["o_id"];	
								if($o_id && mysql_num_rows(mysql_query("SELECT o_id FROM others WHERE salarytype='0'  AND o_id=$o_id"))){
									$amt=$emp_display["n_salary"];
									$bank=1;
								}
								if($o_id && mysql_num_rows(mysql_query("SELECT o_id FROM others WHERE extra_salary_type='0' AND o_id=$o_id"))){
									$val=mysql_fetch_array(mysql_query("SELECT * FROM others WHERE extra_salary_type=0 AND o_id=$o_id"));
									$amt=$val["extra_salary"];
									$bank=2;
								}
								$d_id=$emp_display["d_id"];	
								if($d_id && mysql_num_rows(mysql_query("SELECT d_id FROM driver WHERE salarytype='0' AND d_id=$d_id"))){
									$amt=$emp_display["n_salary"];
									$bank=1;
								}
								if($d_id && mysql_num_rows(mysql_query("SELECT d_id FROM driver WHERE extra_salary_type='0' AND d_id=$d_id"))){
									$val=mysql_fetch_array(mysql_query("SELECT * FROM driver WHERE extra_salary_type='0' AND d_id=$d_id"));
									$amt=$val["extra_salary"];
									$bank=2;
								}
								
								if($bank=='1' || $bank=='2'){
									//$total +=round($emp_display["n_salary"]);
									$total +=round($amt);
									
								echo '<tr>
									   <td>'.$emp_count.'</td>
									   <td>'.$emp_display["staff_name"].'</td>
									   <td>'.$emp_display["position"].'</td>
									   <td>'.$emp_display["accno"].'</td>
									   <td>'.round($amt).'</td>
									   </tr>';
									   $emp_count++;
								}
							}	

$emp_query1="select st_ms_id,st_id,o_id,d_id,n_salary,staff_name,position,accno,n_salary from staff_daily_salary where month=$sdate_month and year=$sdate_year order by st_ms_id desc";	
							//echo "select st_ms_id,st_id,o_id,d_id,n_salary,staff_name,position,accno,n_salary from staff_month_salary where month=$sdate_month and year=$sdate_year order by st_ms_id desc";	die;									
							$emp_result1=mysql_query($emp_query1);
							//$emp_count=1;
							//$total=0;
							while($emp_display1=mysql_fetch_array($emp_result1))
							{
							
								$emp_id=$emp_display1["st_ms_id"];	
								$bank=0;
								$st_id=$emp_display1["st_id"];
								if($st_id!=0){
									
								if($st_id && mysql_num_rows(mysql_query("SELECT st_id FROM staff WHERE s_type='0'  AND st_id=$st_id"))){
									$amt=$emp_display1["n_salary"];
									$bank=1;
								}
								if($st_id && mysql_num_rows(mysql_query("SELECT st_id FROM staff WHERE extra_salary_type='0' AND st_id=$st_id"))){
									
									$val=mysql_fetch_array(mysql_query("SELECT * FROM staff WHERE extra_salary_type='0' AND st_id=$st_id"));
									$amt=$val["extra_salary"];
									$bank=2;
								}
								
								}
								
								$o_id=$emp_display1["o_id"];	
								if($o_id!=0){
								if($o_id && mysql_num_rows(mysql_query("SELECT o_id FROM others WHERE s_type='0' AND o_id=$o_id"))){
									$amt=$emp_display1["n_salary"];
									$bank=1;
								}
								if($o_id && mysql_num_rows(mysql_query("SELECT o_id FROM others WHERE extra_salary_type='0' AND o_id=$o_id"))){
									$val=mysql_fetch_array(mysql_query("SELECT * FROM others WHERE extra_salary_type='0' AND o_id=$o_id"));
									$amt=$val["extra_salary"];
									$bank=2;
								}	}
								
								$d_id=$emp_display1["d_id"];	
								if($d_id!=0){
								if($d_id && mysql_num_rows(mysql_query("SELECT d_id FROM driver WHERE s_type='0'  AND d_id=$d_id"))){
									$amt=$emp_display1["n_salary"];
									$bank=1;
								}
								if($d_id && mysql_num_rows(mysql_query("SELECT d_id FROM driver WHERE extra_salary_type='0' AND d_id=$d_id"))){
									$val=mysql_fetch_array(mysql_query("SELECT * FROM driver WHERE extra_salary_type='0' AND d_id=$d_id"));
									$amt=$val["extra_salary"];
									$bank=2;
								}}
								if($bank=='1' || $bank=='2'){
									//$total +=round($emp_display1["n_salary"]);
									$total +=round($amt);
								
								echo '<tr>
									   <td>'.$emp_count.'</td>
									   <td>'.$emp_display1["staff_name"].'</td>
									   <td>'.$emp_display1["position"].'</td>
									   <td>'.$emp_display1["accno"].'</td>
									   <td>'.round($amt).'</td>
									   </tr>';
									   $emp_count++;
								}
							} 							
							echo '<tr>
                           <td colspan="4"><b style="float:right">Total</b></td>
                           <td><b>'.round($total).'</b></td>
                           </tr>
						   </table>
						   <input type="hidden" id="total" name="total" class="form-control" value="'.round($total).'">';
}
?>
