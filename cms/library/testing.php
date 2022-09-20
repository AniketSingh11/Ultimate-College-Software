<?php 

 
include("../includes/config.php");
for ($i=5;$i<=152;$i++)
{  
     
     $query="insert into lms_book_snumber(b_id) values('$i')";
     $result=mysql_query($query);
}

