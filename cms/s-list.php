<? ob_start(); ?>
<?php
include("includes/config.php");
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
}
$sectionlist=mysql_query("SELECT * FROM section WHERE s_id='".$catParent."'"); 
								  $section=mysql_fetch_array($sectionlist);
								  $cid=$section['c_id'];
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  
$cname=$class['c_name'];
											if($cname == 'XI STD' && $cname == 'XII STD'){ 
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id='".$cid."' AND s_id='".$catParent."'");
											}else{
												$qry="SELECT * FROM subjectlist Where c_id='".$cid."'";
											}
											//$class2=mysql_fetch_array($qry);
echo "<option value=''>Please Select</option> " ;


  $query = "SELECT * FROM subjectlist WHERE s_id = '".$catParent."' "; 
  $result = mysql_query($qry);
    while ($row = mysql_fetch_array($result)) 
    {
           echo"<option  value =".$row['sl_id']."> ".$row['s_name']."</option>";
    }
?>
<? ob_flush(); ?>