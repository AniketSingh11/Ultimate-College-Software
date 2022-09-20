<?php 
include ("includes/config.php");

$filter=$_REQUEST["filter"];

$ay_id=$_REQUEST["ay_id"];

$b_id=$_REQUEST["b_id"]; 
?><option value="All">All</option>
<?php
    $qry = mysql_query("SELECT distinct $filter  FROM student where ay_id='$ay_id' and b_id='$b_id'");
   while($row=mysql_fetch_array($qry))
   {
       if($filter=="fdis_id"){
           
           $qry1=mysql_fetch_array(mysql_query("select * from fdiscount where fdis_id='$row[$filter]'"));
           ?>
                 <option  value ="<?=$row[$filter]?>"><?php echo $qry1['fdis_name']; ?></option>
           <?php 
                  }else{
    ?>
      <option  value ="<?=$row[$filter]?>"><?php echo $row[$filter]; ?></option>
<?php 
       }
     }