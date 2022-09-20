<? ob_start(); ?>
<?php
include("includes/config.php");

$clid = $_GET['clid'];

		$boardlist1=mysql_query("SELECT * FROM circular WHERE cl_id=$clid"); 
		$circular=mysql_fetch_array($boardlist1);
		$file=$circular['file'];
				
	unlink("circular/".$file);
								  
 $delete="Delete from circular where cl_id='$clid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:circular.php?msg=dsucc");
}
?>
<? ob_flush(); ?>