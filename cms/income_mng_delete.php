<? ob_start(); ?>
<?php
include("includes/config.php");

$incid = $_GET['incid'];
$inid = $_GET['inid'];

$income1=mysql_query("SELECT * FROM income WHERE in_id=$inid"); 
								  $income=mysql_fetch_array($income1);
								  $amount=$income['amount'];
								  
 $delete="Delete from income where in_id='$inid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
	$cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
							  $cash=mysql_fetch_array($cashlist);
							  $currentcash=$cash['amount'];
							  $updatecash=$currentcash-$amount;
							  $cashqry=mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
header("Location:income_mng.php?incid=$incid&msg=dsucc");
}
?>
<? ob_flush(); ?>