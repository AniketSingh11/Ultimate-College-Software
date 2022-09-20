<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php"); 
 
$qry=mysql_query("SELECT * FROM staff");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$stid=$row['st_id'];
					$date=$row['dob'];
					$date_split1= explode('/', $date);
		 
					 $date_month=$date_split1[1];
					 $date_day=$date_split1[0];
					 $date_year=$date_split1[2];
					 
					 $sql="UPDATE staff SET day='$date_day',month='$date_month',year='$date_year' WHERE st_id='$stid'";
					
					$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
					
					
				}
				
?>