<?php 
require("includes/config.php");
$stop 				= $_POST['stop']; 
$rid 				= $_POST['rid'];
$action =mysql_real_escape_string($_POST['action']); 
//$last =mysql_real_escape_string($_POST['last']); 

$last = unserialize(urldecode($_POST['last']));
    //print_r($arr);
$myString = $stop;
$myArray = explode(',', $myString);
//print_r($myArray);
/*
foreach ($myArray as &$value) {
    echo $value."<br>";
}*/
$result = array_diff($last, $myArray);

//echo count($result);
//print_r($result);
	
if ($action == "update"){
	
	$listingCounter = 1;
	
		if(count($result)>0){
			foreach ($result as $recordIDValue1) {
			$query1 = "UPDATE trstopping SET r_id=0,ListingID =0 WHERE stop_id = ". $recordIDValue1;
			mysql_query($query1) or die('Error, insert query failed1');
			}	
		}
	
	foreach ($myArray as $recordIDValue) {		
		$query = "UPDATE trstopping SET r_id=$rid,ListingID = ".$listingCounter." WHERE stop_id = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed2');
		$listingCounter = $listingCounter + 1;	
	}
	
	
	
}
?>