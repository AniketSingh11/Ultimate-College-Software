<? ob_start(); ?>
<?php

include("includes/config.php");

$month=date("m");
	$year=date("Y");	
	if($month>=3){
		$yearlist=mysql_query("SELECT * FROM year WHERE s_year=$year"); 
		$year=mysql_fetch_array($yearlist);
		$acyear=$year['ay_id'];
		$acname=$year['y_name'];
}else if($month<3){
	$yearlist=mysql_query("SELECT * FROM year WHERE e_year=$year"); 
		$year=mysql_fetch_array($yearlist);
		$acyear=$year['ay_id'];
		$acname=$year['y_name'];
}

echo "<option value=''>Select Class Select</option> " ;
if(isset($_GET['mmtid'])) 
{
    $catParent = $_GET['mmtid'];
  $query = "SELECT * FROM class WHERE b_id = '".$catParent."' AND ay_id='$acyear'"; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
           echo"<option  value =".$row['c_id'].">".$row['c_name']."</option>";
    }
}
?>
<? ob_flush(); ?>