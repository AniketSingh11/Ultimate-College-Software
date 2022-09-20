<? ob_start(); ?>
<?php
include("includes/config.php");
if(isset( $_GET['stpt']) ) 
{
    $catParent = $_GET['stpt'];
}
  $query = "SELECT * FROM trstopping WHERE status='1' AND stop_id=$catParent"; 
  $result = mysql_query($query);
  $r_id=mysql_fetch_array($result)['r_id'];
  $root=mysql_query("select * from route where r_id=$r_id");
  $route=mysql_fetch_array($root)['r_name'];
  echo '<p><label>Route No</label><input type="hidden" name="route" value="'.$route.'">';
  echo $route.'</p>';

?>
<? ob_flush(); ?>