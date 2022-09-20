<? ob_start(); ?>
<?php
include("includes/config.php");
echo '<select name="ms_example[ ]" multiple="multiple" id="msc" class="required">';
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
}

$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$catParent"); 
								  $section=mysql_fetch_array($sectionlist);
								  $cid1=$section['c_id'];
								  $ac_year1=$section['ay_id'];
								  
 $query = mysql_query("SELECT * FROM student WHERE c_id='$cid1' AND s_id = '".$catParent."' AND ay_id='$ac_year1' ORDER BY ss_id ASC"); 
    while ($row = mysql_fetch_assoc($query)) 
    {
           echo"<option value =".$row['ss_id']."> ".$row['admission_number']." - ".$row['firstname']." ".$row['middlename']." ".$row['lastname']."</option>";
    }
 echo '</select>';
 echo '<div class="btn-group">
                                            <span class="button blue" id="ms_select">Select all</span>
                                            <span class="button blue" id="ms_deselect">Deselect all</span>
                  						</div>';										
?>
<? ob_flush(); ?>