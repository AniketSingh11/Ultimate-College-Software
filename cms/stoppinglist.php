<? ob_start(); ?>
<?php
include("includes/config.php");
echo "<option value=''>Please Select</option> " ;
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
}
  $query = "SELECT * FROM trstopping WHERE status='1'"; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
		   echo"<option  value =".$row['stop_id']."> ".$row['stop_name']."</option>";		
    }
?>
<? ob_flush(); ?>