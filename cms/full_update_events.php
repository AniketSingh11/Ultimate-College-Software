<?php
include("includes/config.php");
/* Values received via ajax */
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// connection to the database
/*try {
 $bdd = new PDO('mysql:host=localhost;dbname=fullcalendar', 'root', '');
 } catch(Exception $e) {
exit('Unable to connect to database.');
}
 // update the records
$sql = "UPDATE evenement SET title=?, start=?, end=? WHERE id=?";
$q = $bdd->prepare($sql);
$q->execute(array($title,$start,$end,$id));*/

//$qry=mysql_query("UPDATE evenement SET title='$title',start='$start',end='$end' WHERE id='$id'");

$sql="UPDATE evenement SET title='$title',start='$start',end='$end' WHERE id='$id'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

?>
