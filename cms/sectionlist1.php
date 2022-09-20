<? ob_start(); ?>
<?php
include("includes/config.php");
//echo "<option value=''>Please Select</option> " ;
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
    $show=$_GET['show'];
}
?>
<option value ="">for All</option>
<?php 
  $query = "SELECT * FROM section WHERE c_id = '".$catParent."' "; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
        $ay_id=$row['ay_id'];
        
        $result1 = mysql_query("SELECT * FROM student WHERE c_id ='$catParent' and s_id=$row[s_id] and ay_id='$ay_id'");
        
        ?>
      <option  value ="<?=$row['s_id']?>" <?php if($_GET['sid']==$row['s_id']){ echo "selected"; }?>><?php if($show=="show"){ echo $row['s_name']." - ".mysql_num_rows($result1)." Students";}else{ echo $row['s_name']; }?></option>
  <?php   }
?>
<!-- <option value ="New">New Student</option> -->
<? ob_flush(); ?>