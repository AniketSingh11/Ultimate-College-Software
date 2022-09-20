<? ob_start(); ?>
<?php
include("../includes/config.php");
if($_POST)
{
$q=$_POST['searchword'];
$sql_res=mysql_query("select * from staff where (staff_id like '%$q%' or fname like '%$q%' and status='1' and relivestatus='0') order by st_id");
while($row=mysql_fetch_array($sql_res))
{
$staff_id=$row['staff_id'];
$fname=$row['fname'];
$image=$row['photo'];
//$country=$row['country'];

$b_staff_id='<b>'.$q.'</b>';
$b_fname='<b>'.$q.'</b>';

$final_staff_id = str_ireplace($q, $b_staff_id, $staff_id);
$final_fname = str_ireplace($q, $b_fname, $fname);
?>
<div class="display_box" align="left">
<img src="../img/Staff/<?php echo $image; ?>" style="width:50px; height:40px; float:left; margin-right:6px;" />
<span class="id"><?php echo $final_staff_id; ?></span>&nbsp;<br/>
<span class="name"><?php echo $final_fname; ?></span><br/>
<!--<span style="font-size:9px; color:#999999"><?php echo $country; ?></span>-->
</div>
<?php
}
}
?>
<? ob_flush(); ?>