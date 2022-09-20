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
   //echo $test=$int = thefunction($s_id);
   
	$emp_query="select * from leavetype where lt_id=$value";										
	$emp_result=mysql_query($emp_query);
	$emp_display=mysql_fetch_array($emp_result);
	$other=$emp_display["other"];
			$tleave=0;
   
   $emp_query1="select * from staff_leave where status='1' AND (st_id=$s_id AND l_type=$value) AND ((year='2014' AND month>'5') OR (year='2015' AND month<='5'))";	
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
			}else{
				echo '<div class="alert alert-success">
					<input type="hidden" name="re_leave" value="other"/>
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				'.$emp_display["lt_name"].' - Pay for this leave... 
			</div>	';
			}
}