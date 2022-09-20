<? ob_start(); ?>
<?php
include("includes/config.php");

$baid = $_GET['baid'];
$bcid = $_GET['bcid'];

$bdeposit1=mysql_query("SELECT * FROM bank_withdrawl WHERE bc_id=$bcid"); 
								  $bdeposit=mysql_fetch_array($bdeposit1);
								  $amount=$bdeposit['amount'];
								  $baid1=$bdeposit['ba_id'];
								  
 $delete="Delete from bank_withdrawl where bc_id='$bcid' ";
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
							  
							  $classlist=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid1"); 
								  $class=mysql_fetch_array($classlist);
							$accountamount=$class['amount'];
							$accountcash=$accountamount+$amount;
			  $cashqry=mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$baid1");
			  
header("Location:bwithdrawl_mng.php?msg=dsucc");
}
?>
<? ob_flush(); ?>