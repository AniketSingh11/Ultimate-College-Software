<? ob_start(); ?>
<?php
include("includes/config.php");

$baid = $_GET['baid'];
 $delete="Delete from bank_account where ba_id='$baid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:bank_account.php?msg=dsucc");
}
?>
<? ob_flush(); ?>