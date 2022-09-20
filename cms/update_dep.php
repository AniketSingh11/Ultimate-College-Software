<?php 
include("includes/config.php");
$qry=mysql_query('select * from bank_deposit');
//$val=mysql_fetch_array($qry);
//print_r($val);
$i=1;
while($row=mysql_fetch_array($qry))
{
	$bc_id=$row['bc_id'];
	$date=$row['date'];
	$exp_date=explode('/',$date);
	$dt=$exp_date[0];
	$dm=$exp_date[1];
	$dy=$exp_date[2];
	//$final_dt=$dy.'-'.$dm.'-'.$dt;
	if($i<='59')
	{
	$final_dt=$dy.'-'.$dm.'-'.$dt.' '.date('h:i:'.$i);
	}
	else
	{
	$i=0;
	$final_dt=$dy.'-'.$dm.'-'.$dt.' '.date('h:'.$i.':s');
	}
	$update=mysql_query('update bank_deposit set deposit_date_time="'.$final_dt.'" where bc_id="'.$bc_id.'"');
	
	$i++;
}
?>