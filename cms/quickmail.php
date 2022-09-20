 
 <?php

include("includes/config.php");
 

$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];
 
 


$subject = "Enquiry Send From School Management\n";

$from="info@.com";
//$headers = "From: $visitormail\n";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .="From:".$from;

$msg="testing";

        $studentlist=mysql_query("SELECT * FROM pre_admission WHERE (status = '1') AND ay_id=$acyear ORDER BY pa_id DESC");
         while($row=mysql_fetch_array($studentlist))
         {
         $to=$row["email"];
         $pa_id=$row["pa_id"];
    
         if(mail($to, $subject, $msg, $headers))
         
         {?> <script>
$("#mail_status<?=$pa_id?>").html("<center><button class='btn btn-small btn-success'>success</button></center>");
</script><?php
      
             
         }else{
             
        //    ?> <script>
        	 $("#mail_status<?=$pa_id?>").html("<center><button class='btn btn-small btn-error'>Failed</button></center>");
</script><?php
         }

         }


?>




