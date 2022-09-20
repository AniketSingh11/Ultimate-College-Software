<? ob_start(); ?>
<?php
include("includes/config.php");

$exsid = $_GET['exsid'];

$classlist=mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id=$exsid");
$class=mysql_fetch_array($classlist);
 
$count=$class["count"];


$qry1=mysql_query("select * from ex_insubcategory where exs_id!=$exsid");
while($res1=mysql_fetch_array($qry1))
{
$subcat=array();
for($j=1;$j<=20;$j++)
{
$sub_id=$res1["sub$j"."_id"];
	
if($sub_id!=0){
$delete="Delete from ex_insubcategory where sub$j"."_id='$exsid' and exs_id!=$exsid ";
$result=mysql_query($delete);
}
}

}




$delete="Delete from ex_insubcategory where exs_id='$exsid' ";
$result=mysql_query($delete);
if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:exponses_subcategory.php?msg=dsucc");
}

?>
<? ob_flush(); ?>