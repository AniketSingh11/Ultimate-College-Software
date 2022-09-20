<? ob_start(); ?>
<?php
include("includes/config.php");
echo '<select name="ms_example[ ]" multiple="multiple" id="msc" class="required">';
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
}
  $query = "SELECT ex_id,r_no,amount,pending,date_day,date_month,date_year FROM exponses WHERE aid = '".$catParent."' AND type=1 AND status=0"; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
		$pending=$row['pending'];
		if(!$pending){
			$pending=$row['amount'];
		}
		$cdate1=$row["date_day"]."/".$row["date_month"]."/".$row["date_year"];
		?>
      <option  value ="<?=$row['ex_id']?>"><?php echo $cdate1." - ".$row['r_no']." - <b>Rs. ".$pending."</b>"; ?></option>
  <?php   }
  echo '</select>';
 echo '<div class="btn-group">
                                            <span class="button blue" id="ms_select">Select all</span>
                                            <span class="button blue" id="ms_deselect">Deselect all</span>
                  						</div>';
?>
<? ob_flush(); ?>