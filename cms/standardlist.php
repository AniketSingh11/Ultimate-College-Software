<? ob_start(); ?>
<?php
include("head_top.php"); 
//include("includes/config.php");
echo "<option value=''>Please Select</option> " ;
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
}
  $query = "SELECT * FROM class WHERE b_id = '".$catParent."' AND ay_id=$acyear"; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
           echo"<option  value =".$row['c_id']."> ".$row['c_name']."</option>";
    }
?>
<? ob_flush(); ?>