<?php 
include("header.php");
$lid=$_GET['id'];
$stid=$_GET['stid'];
$emp_query="select st_id,o_id,d_id,f_date,t_date,status from staff_leave where id='$lid'";
$emp_result=mysql_query($emp_query);
$employee=mysql_fetch_array($emp_result);
  		$st_id=$employee["st_id"];
  		$o_id=$employee["o_id"];
		$d_id=$employee["d_id"];
		$l_status=$employee["status"];
	if($l_status=='1'){
  		$fromdate=$employee['f_date'];
		$lastdate=$employee['t_date'];
		
		$sdate_split3= explode('-', $fromdate);		 
		  $lf_day=$sdate_split3[0];
		  $lf_month=$sdate_split3[1];
		  $lf_year=$sdate_split3[2];	
	$lfrom_date=$lf_year."-".$lf_month."-".$lf_day;
	
	$sdate_split4= explode('-', $lastdate);		 
		  $ll_day=$sdate_split4[0];
		  $ll_month=$sdate_split4[1];
		  $ll_year=$sdate_split4[2];	
	$llast_date=$ll_year."-".$ll_month."-".$ll_day;
		
		$datefrom=$lfrom_date;
			while ($datefrom <= $llast_date) {
			//echo $datefrom.'<br>';
			$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
						  $sql=mysql_query("UPDATE sattendance SET result='1',lt_id='',reason='',result_half='',l_apply='0' WHERE satt_id='$satt_id1'");
					  }		
			$datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));		
			}
	}
$query="delete from staff_leave where id='$lid'";
$result=mysql_query($query);
if($result)
{
	header("location:leave_detail1.php?id=$stid&syear=$syear&eyear=$eyear&msg=dsucc");
}
else
{
	header("location:leave_detail1.php?id=$stid&syear=$syear&eyear=$eyear&msg=err");
}
?>

