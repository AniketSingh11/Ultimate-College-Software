<?php
include("includes/config.php"); 
if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	$value=$_GET['value'];
   
   $sdate_split1= explode('/', $value);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];		  
		  
		  $finaldate=$sdate_year."-".$sdate_month."-".$sdate_day;		  
  echo '<div class="_100">
                         <p>
                         <label for="textfield">Fill Driver Attendance: </label>
                        <table class="table">
                  	<thead>
                    	<th><center>S.No</center></th>
                    	<th><center>Driver ID</center></th>
                        <th><center>Driver Name</center></th>
                        <th><center>Present</center></th>
                        <th><center>Absent - FullDay</center></th>
                        <th><center>Absent - HalfDay </center></th>
                        <th><center>Leave Type</center></th>
                        <th><center>Reason </center></th>
                       </thead>
                    </thead>
                    <tbody>';
                    	 
						 $att=1;						 
					$select_record=mysql_query("SELECT * FROM driver WHERE status='1'");
					while($student12=mysql_fetch_array($select_record))
					{ 
					$d_id=$student12['d_id'];
					
					$emp_query="select * from staff_leave where (from_date<='$finaldate' AND to_date>='$finaldate') AND d_id=$d_id AND status='1'";
										$emp_result=mysql_query($emp_query);
					$emp_display=mysql_fetch_array($emp_result);
					$ltid=$emp_display['l_type'];
					$staffleaveid=$emp_display['id'];
					$htype=$emp_display['h_type'];
					$fromdate=$emp_display['from_date'];
					$todate=$emp_display['to_date'];
					
					$morning=0;
					$evening=0;
					$fullday=0;
					
					if($finaldate==$fromdate){
						$thisdate=1; //from date
					}else if($finaldate==$todate){
						$thisdate=2; //To date
					}else{
						$thisdate=3; //Middle date
					}
					
					if($htype){
						if($thisdate==1){
							if($htype=='E'){
								$evening=1;
							}else if($htype=='EM'){
								$evening=1;
							}
						}else if($thisdate==2){
							if($htype=='M'){
								$morning=1;
							}else if($htype=='EM'){
								$morning=1;
							}
						}else{
							$fullday=1;
						}
					}else{
						$fullday=1;
					}
					
					$leavelist=mysql_query("SELECT other FROM leavetype WHERE lt_id=$ltid"); 
								  $leavety=mysql_fetch_array($leavelist);	
						$leaveother=$leavety['other'];
						
					if($leaveother=='2' && $ltid){
						$morning=0;
						$evening=0;
						$fullday=0;
					}			
                    echo '<tr>
                        <td><center>'.$att.'</center></td>
                        <td><center>'.$student12['driver_id'].'</center></td>
                        <td><center>'.$student12['fname']." ".$student12['lname'].'</center></td>
                        <td><center><input type="radio" id="name"  name="'.$student12['d_id'].'" class="text err" value="1"';
						
						if(!$emp_display || $leaveother=='2'){
							$leave="1";
						echo 'checked="checked"';}
						if($emp_display){
						echo 'disabled';}
						echo '/></center></td>
                        <td><center><input type="radio" id="name" name="'.$student12['d_id'].'" class="text err" value="0"';
						if($emp_display && $fullday){
							$leave="0";
						echo 'checked="checked"';}
						if($emp_display){
						echo 'disabled';}
						echo '/></center></td>
                        <td><input type="radio" id="name" name="'.$student12['d_id'].'" class="text err" value="off-M"';
						if($morning){
							$leave="off-M";
						echo 'checked="checked"';}
						if($emp_display){
						echo 'disabled';}
						echo '/>Morning<br>
                            <input type="radio" id="name" name="'.$student12['d_id'].'" class="text err" value="off-E"';
						if($evening){
							$leave="off-E";
						echo 'checked="checked"';}
						if($emp_display){
						echo 'disabled';}
						echo '/>Afternoon';
							if($emp_display){
								echo '<input type="hidden" id="ltid" name="'.$student12['d_id'].'" class="text err" value="'.$leave.'" />';
							}
                        echo '</td>
                        <td>';
                                            $classl = "SELECT lt_id,lt_name FROM leavetype";
											$staffid=$student12['driver_id'];
                                            $result1 = mysql_query($classl) or die(mysql_error()); 
                                            
								echo '<select name="ltid'.$student12['d_id'].'" id="ltid"';
								 	if($ltid){
									echo 'disabled';}
                                      echo '><option value="">Select Leave Type</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($ltid==$row1['lt_id']){
                                       			echo '<option value="'.$row1['lt_id'].'" selected>'.$row1['lt_name'].'</option>\n';
											}else{
												echo '<option value="'.$row1['lt_id'].'">'.$row1['lt_name'].'</option>\n';
											}
                                            endwhile;
                                        echo '</select>';
										if($ltid){
									echo '<input type="hidden" id="ltid" name="ltid'.$student12['d_id'].'" class="text err" value="'.$ltid.'" />';}
									echo '<input type="hidden" id="apply" name="apply'.$student12['d_id'].'" class="text err" value="';
									if($staffleaveid){ echo $staffleaveid;}else { echo "0"; }
									echo '" />';
										echo '</td>
                        <td><center><input type="text" id="reason" name="reason'.$student12['d_id'].'" class="text err" value="'.$emp_display['l_des'].'" /></center></td>                        </tr>';
                     $att++; }
                   echo '</tbody>
                  </table></p><br><br>	                  	
        			</div>
					<script defer src="js/script.js"></script> <!-- Generic scripts -->';
}