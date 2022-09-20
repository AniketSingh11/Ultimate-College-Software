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
<?php include 'print_header.php';?>
<link rel="stylesheet" href="css/print.css"> 
<style type="text/css">
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
<body onload="javascript:printDiv('printablediv')">
<!--<div  id="print" style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>-->
<div id="printablediv">
   <header class="clearfix">
          <center>  <img src="img/logo_sms.png" title="latterpad" width="30%" /></center>
        </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">TO:</div>
          <h2 class="name"><?= $row1["name"] ?></h2>
          <div class="address"><?=nl2br($row1["bill_address"]);?></div>
        </div>
        <div id="invoice">
          <h1><?= $row1["title"];?></h1>
          <div class="date">Date of Proposal: <?= $row1["date"];?></div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">S.No</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">RATE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
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
            <td class="no"><?=$i?></td>
            <td class="desc"><?=$name?></td>
            <td class="unit"><?php echo number_format($amount,2);?></td>
            <td class="qty"><center><?=$qty?></center></td>           
            <td class="total"><?php echo number_format($total,2);?></td>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td><?php echo number_format($total_amount,2);?></td>
          </tr>
          <!--<tr>
            <td colspan="2"></td>
            <td colspan="2">TAX 25%</td>
            <td>1,300.00</td>
          </tr>-->
          <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td><?php echo number_format($total_amount,2);?></td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <!--<div id="notices">
        <div>NOTICE:</div>
        <div class="notice">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>
        <div class="notice">netus et malesuada fames ac turpis egestas.</div>
      </div>-->
    </main>
    <footer>
      1/191 A,, Rajiv Gandhi Nagar, Kundrathur Main Rd, Kovur, Chennai-600128. Phone No : 044 6566 6673.
    </footer>
</div>
</body>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
			//Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page     var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            //document.body.innerHTML ="<html><head><title></title></head><body>" + divElements + "</body>";
            //Print Page
			window.print();
			//$('#print').hide();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;          
        }
</script>
</html>