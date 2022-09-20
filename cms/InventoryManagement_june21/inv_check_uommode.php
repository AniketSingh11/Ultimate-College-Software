<?php
	include("../includes/config.php");
	
	$uomid = $_GET['uomid'];
 	 
	$agencyl = "SELECT uom_id,uom_name,uom_mode FROM inv_uom where uom_id=$uomid";
	$result = mysql_query($agencyl) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	if($row['uom_mode']==0) echo 'Fixed';
	else echo 'Non Fixed';											
?>  
