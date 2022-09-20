<?php
function thefunction($number){
  if ($number < 0)
    return 0;
  return $number; 
}
include("../includes/config.php"); 
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['stid']) && $_GET['stid']!='') )
{
	 $value=$_GET['value'];
     $s_id=$_GET['stid'];
	 $type=$_GET['type'];
	 $syear=$_GET['syear'];
	 $eyear=$_GET['eyear'];
   //echo $test=$int = thefunction($s_id);
   
	$emp_query="select other,l_total,lt_name from leavetype where lt_id=$value";										
	$emp_result=mysql_query($emp_query);
	$emp_display=mysql_fetch_array($emp_result);
	$other=$emp_display["other"];
			$tleave=0;
   if($type=='st'){
   $emp_query1="select l_total from staff_leave where status='1' AND (st_id=$s_id AND l_type=$value) AND ((year='$syear' AND month>'5') OR (year='$eyear' AND month<='5'))";	
			$emp_result1=mysql_query($emp_query1);
			while($emp_display1=mysql_fetch_array($emp_result1))
			{
				$tleave +=$emp_display1['l_total'];
			}
			$rleave=$emp_display["l_total"]-$tleave;
			
			//echo thefunction($rleave);
			if(!$other){
			echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="'.thefunction($rleave).'"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>'.thefunction($rleave).' Days</strong> Only Remaining Leave in '.$emp_display["lt_name"].' 
			</div>	';
			}else if($other=="2"){
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Not Pay for this leave Type... 
			</div>	';
			}else{
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Pay for this leave... 
			</div>	';
			}
   }else if($type=='ow'){
	   	$emp_query1="select l_total from staff_leave where status='1' AND (o_id=$s_id AND l_type=$value) AND ((year='$syear' AND month>'5') OR (year='$eyear' AND month<='5'))";	
			$emp_result1=mysql_query($emp_query1);
			while($emp_display1=mysql_fetch_array($emp_result1))
			{
				$tleave +=$emp_display1['l_total'];
			}
			$rleave=$emp_display["l_total"]-$tleave;
			
			//echo thefunction($rleave);
			if(!$other){
			echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="'.thefunction($rleave).'"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>'.thefunction($rleave).' Days</strong> Only Remaining Leave in '.$emp_display["lt_name"].' 
			</div>	';
			}else if($other=="2"){
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Not Pay for this leave Type... 
			</div>	';
			}else{
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Pay for this leave... 
			</div>	';
			}
	   
   }else if($type=='dr'){
	   	$emp_query1="select l_total from staff_leave where status='1' AND (d_id=$s_id AND l_type=$value) AND ((year='$syear' AND month>'5') OR (year='$eyear' AND month<='5'))";	
			$emp_result1=mysql_query($emp_query1);
			while($emp_display1=mysql_fetch_array($emp_result1))
			{
				$tleave +=$emp_display1['l_total'];
			}
			$rleave=$emp_display["l_total"]-$tleave;
			
			//echo thefunction($rleave);
			if(!$other){
			echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="'.thefunction($rleave).'"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>'.thefunction($rleave).' Days</strong> Only Remaining Leave in '.$emp_display["lt_name"].' 
			</div>	';
			}else if($other=="2"){
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Not Pay for this leave Type... 
			</div>	';
			}else{
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Pay for this leave... 
			</div>	';
			}
	   
   }
}