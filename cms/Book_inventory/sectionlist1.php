<? ob_start(); ?>
<?php
include("../includes/config.php");
if(isset( $_GET['mmtid']) ) 
{
    echo $catParent = $_GET['mmtid'];
	
}
  /*$query = "SELECT * FROM student WHERE ss_roll LIKE '".$catParent."' "; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
           echo"<p>".$row['ss_name']."</p>";
    }*/
	//echo $_GET['mmtid'];
?>
<? ob_flush(); ?>