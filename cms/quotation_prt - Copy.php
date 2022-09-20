<?php 
include("includes/config.php");
session_start();
$check=$_SESSION['email'];
$query=mysql_query("select email from admin_login where email='$check' ");
$data=mysql_fetch_array($query);
$email=$data['email'];
$user=$_SESSION['uname'];
if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($email))
{	
header("Location:404.php");
}
							$qid=$_GET['qid'];
							$qry=mysql_query("SELECT * FROM quotation where q_id='$qid'") or die(mysql_error());
							$row1=mysql_fetch_array($qry);
					        $bill_address=$row1["bill_address"];
					        $ship_address=$row1["ship_address"];
					        $total_amount=$row1["total_amount"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Quotation </title>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page     var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            //document.body.innerHTML ="<html><head><title></title></head><body>" + divElements + "</body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;          
        }
</script>
<style type="text/css">
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: #57B223;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #57B223;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #57B223; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}
/*.profile-table td{
	 border:1px solid #2D2D2D;
	 padding-left:10px;
}
.small{font-size:10px;}
.bgcolor{background-color:#D0D0D0;}
.column {
float: left;
    margin: 20px;
    
    padding-bottom: 1000px;
    margin-bottom: -1000px;
}*/
</style>    
</head>
<body>
<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv">
<center>
<img src="img/s_profile_head.png" style="width:100%;"> 
</center>
<div class="column">Bill To :<b ><?=$bill_address?> </b></div>&nbsp;<div class="column" style="float: right;">Ship To: <b><?=$ship_address?></b></div>

<!--<table  style="width:100%;border:1px solid black;height:100%;cell-padding:1px; margin-top:10px;line-height:20px; "/>-->

<table style="width:100%;font-size:12px;line-height:18px; margin-top:-18px;" class="profile-table">
<tbody>
<tr>
<td class="bgcolor">S.No</td>
<td width="40%" class="bgcolor" >Name</td>
<td class="bgcolor" >Quantity</td>
<td class="bgcolor">Amount</td>
<td class="bgcolor">Total</td>
</tr>
<?php   $query="select * from  quotation_amount where q_id='$qid' order by qa_id asc ";
					       $res=mysql_query($query);
					       $i=0;
					       while($row=mysql_fetch_array($res))
					       {
					           $i=$i+1;
					       
					         $name=stripslashes($row["name"]);
					         $qty=$row["qty"];
					         $amount=$row["amount"];
					         $total=$row["total"];?>
<tr>
<td height="20px"><?=$i?></td>
<td width="40%"><?=$name?></td>
<td><?=$qty?></td>
<td><?=$amount?></td>
<td><?=$total?></td>
</tr>
<?php } ?>


</tbody></table><b style="margin-left:1250px;">Total Amount :Rs.<?=$total_amount?></b>
<table style="width:100%;font-size:12px; margin-top:40px;"> 
<tr>
<td>Signature of the Principal with Seal</td>
 
</tr>
</table>

</div>
</body>
</html>