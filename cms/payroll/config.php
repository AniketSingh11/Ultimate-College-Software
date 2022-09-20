
<?php
error_reporting(E_PARSE);
$conn=mysql_connect('localhost','root','');
if(!$conn)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('pay_roll',$conn);

?>