<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$bid = $_GET['bid'];
$rate = $_GET['rate'];
$frid = $_GET['frid'];
 $delete1=mysql_query("Delete from mfrate where fr_id='$frid' ");
    //$result=mysql_query($delete);
	$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fg_id");													
									  while($row2=mysql_fetch_array($qry2))
										{
											$fgdid=$row2['fgd_id'];
	$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
						$fdisid=$student12['fdis_id'];
						$delete2=mysql_query("Delete from mfrate_value where fr_id='$frid' AND fdis_id='$fdisid'");
					}
										}
    if(!$delete1 && !$delete2)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:mfeesrate.php?cid=$cid&bid=$bid&rate=$rate&msg=dsucc");
}
?>
<? ob_flush(); ?>