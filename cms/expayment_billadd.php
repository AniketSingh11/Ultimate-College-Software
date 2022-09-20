<?php
include("includes/config.php");
include("includes/close-bill.php");

if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	 $value=$_GET['value'];
	 $epid=$_GET['epid'];
	
		  $exid=$value;
		  $classlist1=mysql_query("SELECT * FROM exponses WHERE ex_id=$exid"); 
		  $row4=mysql_fetch_array($classlist1);
		  $tamount=$row4["amount"];
		  $aid=$row4["aid"];
		  $pending1=$row4["pending"];
				  if(!$pending1){
					  $pending1=$row4["amount"];
				  }
		  $excid=$row4["exc_id"];
		  addtocart($exid,$excid,$pending1,$aid,$pending1,$epid);
		  echo "success";
}