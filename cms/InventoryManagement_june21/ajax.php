<? ob_start(); ?>
 <?php
 include("includes/config.php");
 
$cosmo = $_GET["cid"];
if ($_GET["cid"]){
     $class=mysql_query("SELECT * FROM class WHERE c_id=$cosmo");
			  		$classlist=mysql_fetch_array($class);
    echo $classlist['c_name'];
	$_SESSION['cname']=$classlist['c_name'];}
?> 
<? ob_flush(); ?>