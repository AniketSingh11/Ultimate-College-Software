<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

$bid = $_GET['bid'];

?>
<?php
                                            $agencyl = "SELECT c_id,c_name FROM class class where b_id=$bid AND ay_id=$acyear";
                                            $result = mysql_query($agencyl) or die(mysql_error());
                                            echo '<option value="0">All</option>';
											while ($row = mysql_fetch_assoc($result)):
                                                echo "<option value='{$row['c_id']}'>{$row['c_name']}</option>\n";
                                            endwhile;
                                            
											?>
<? ob_flush(); ?>