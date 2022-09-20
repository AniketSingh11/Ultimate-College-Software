<? ob_start(); ?>
<?php
include("../includes/config.php");
echo " <option value=''>Please Select</option> " ;
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
}
  $query = "SELECT * FROM section WHERE c_id = '".$catParent."' "; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
           echo"<option  value =".$row['s_id']."> ".$row['s_name']."</option>";
    }
?>
<? ob_flush(); ?>