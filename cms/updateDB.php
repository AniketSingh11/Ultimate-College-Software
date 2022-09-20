<?php 
require("includes/config.php");

$action 				= mysql_real_escape_string($_POST['action']); 
$updateRecordsArray 	= $_POST['recordsArray'];
$rid 	= $_POST['rid'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE trstopping SET ListingID = " . $listingCounter . " WHERE stop_id = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;	
	}
	
	/*echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	echo 'If you refresh the page, you will see that records will stay just as you modified.';*/
				$query  = "SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID ASC";
				$result = mysql_query($query);
				$count=1;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				
					echo '<li id="recordsArray_'.$row['stop_id'].'" ><img src="img/icons/packs/fugue/24x24/marker.png">'.$count.'-'.$row['stop_name'].'</li>';
					$count++; 
					}
}
?>