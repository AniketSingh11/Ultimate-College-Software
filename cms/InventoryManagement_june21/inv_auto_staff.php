<? ob_start(); ?>
    <?php
	include("../includes/config.php");
	
	$keyword = $_POST['keyword'];
 	$sql = "SELECT * FROM staff where status='1' AND (staff_id like '%".$keyword."%' OR fname like '%".$keyword."%') ";
$sql_res = mysql_query($sql) or die("Could not fetch data into DB: " . mysql_error());
echo '<ul id="staff-list">';
while ($thisrow = mysql_fetch_array($sql_res)){
		
//echo "$thisrow[admission_number]-$thisrow[firstname]";
$staffdetail = $thisrow['staff_id']." - ".$thisrow['fname'];

echo "
<li onClick=\"selectStaff('".$staffdetail."');\">".$staffdetail."</li>


";
}
echo "</ul>";
?>  
<style>
#staff-list {
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
    width: 18%;
    position: absolute;
    z-index: 1;
}
#staff-list li{
    padding: 10px;
    background: #FAFAFA;
    border-bottom: #F0F0F0 1px solid;
    list-style-type: none;
	margin-bottom: 0;
}
</style> 
<? ob_flush(); ?>
