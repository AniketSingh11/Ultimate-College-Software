<? ob_start(); ?>
<?php
include("../includes/config.php");
echo " <option value='0'>All</option> " ;
if(isset( $_GET['secid']) ) 
{
    $catParent = $_GET['secid'];
}
  $query = "SELECT * FROM section WHERE c_id = '".$catParent."' "; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
           echo"<option  value =".$row['s_id']."> ".$row['s_name']."</option>";
    }
?>
<? ob_flush(); ?>