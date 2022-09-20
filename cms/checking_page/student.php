 <?php if($_SESSION['admin_type']=="1")
 {
     $query1="select * from  subadmin_accesspage where subadmin_id='$_SESSION[u_id]'";
     $res1=mysql_query($query1);
     $permissions_check=array();
     while($row1=mysql_fetch_array($res1))
     {
         	
         array_push($permissions_check, $row1["menu_name"]);
     }
 }
 
  if($_SESSION['log_type']=="staff")
							{
							    $query1="select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
							    $res1=mysql_query($query1);
							    $permissions_check=array();
							    while($row1=mysql_fetch_array($res1))
							    {
							        	
							        array_push($permissions_check, $row1["menu_name"]);
							    }
							}
							
							if($_SESSION['log_type']=="others")
							{
							    $query1="select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
							    $res1=mysql_query($query1);
							    $permissions_check=array();
							    while($row1=mysql_fetch_array($res1))
							    {
							
							        array_push($permissions_check, $row1["menu_name"]);
							    }
							}
 
 if($_SESSION['admin_type']!="0" && (!in_array("Student Management", $permissions_check))){
 
  header("Location:404.php?msg=errors");
     
 }