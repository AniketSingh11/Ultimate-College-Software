<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
?>
<style type="text/css">
.client_details{
	padding:0px 20px !important;
	    margin: 0 0 0 0.5em !important;
}
li{
	margin-bottom:0.1em !important;
}
.table tbody td {
    padding: 4px !important;
}
</style>
<link rel="stylesheet" href="stylesheets/sample_pages/invoice.css" type="text/css" />
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById("wrapper1").innerHTML;
            //Get the HTML of whole page     var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script>
    <?php $i_id=$_GET['iid'];
                        
                        $show=$_GET['show'];?>
<body style="background:none;">
<div style="float:right;">
<b style="color:red;"><input  type="checkbox" <?php if($show=="full"){?>checked="checked" <?php }?> name="show" id="show" value="full">Full Details </b>
<a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="images/printer.png"></a></div>
<div id="wrapper1" >
	<div id="content1">		
		<div class="container1">
				
				<div class="grid-17">				
					<div id="invoice" class="widget widget-plain">	
                    <img src="../img/letterpad.png" title="latterpad" width="100%" style="border-bottom:1px solid #5B5B5B"
                    />
						<div class="widget-content">
                        <?php 
						$invoicelist1=mysql_query("SELECT * FROM invoice WHERE i_id=$i_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
									
									$ssid=$invoice['ss_id'];
								  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
			?>
				<ul class="client_details">
					<li><strong class="name"><?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?></strong></li>
					<li>Admission No: <?php echo $student1['admission_number'];?></li>
					<li>Class/Section: <?php echo $row['c_name']."/".$row1['s_name'];?></li>
                    <li>Gender: <?php if($student1['ss_gender'] =='M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
				<ul class="invoice_details">
					<li>Invoice Number: <?php echo $invoice['i_no']; ?></li>
					<li>Invoice Date: <?php echo $invoice['i_day']."/".$invoice['i_month']."/".$invoice['i_year']; ?></li>
				</ul>
			<?php if($show=="full"){?>
				<table class="table table-striped" style="margin:0">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Book Name</th>
							<th class="price">Price</th>
							<th>Qty</th>
							<th class="total">Total</th>
						</tr>
					</thead>	
					<tbody>
                    <?php 
					$count=1;
					$qry5=mysql_query("SELECT * FROM salessumarry WHERE i_id=$i_id");
			  while($row5=mysql_fetch_array($qry5))
        		{?>
						<tr>
							<td><?php echo $count; ?></td>			
							<td><?php echo  $row5['b_name']; ?></td>
							<td class="price">Rs <?php echo  $row5['sa_price']; ?></td>
							<td><?php echo  $row5['sa_qty']; ?></td>
							<td class="total">Rs <?php echo  $row5['sa_total']; ?></td>
						</tr>
                 <?php $count++; } 
				 $seid=$invoice['se_id'];
				 			$qry6=mysql_query("SELECT * FROM service WHERE se_id=$seid"); 
								  $row6=mysql_fetch_array($qry6);
				 if($row6['se_price']){
				 ?>       
                 		<tr bgcolor="#FFFFFF">
                    <td><?php echo $count;?></td>
                    <td colspan="3">Service Charges</td>
                    <td class="total">Rs: <?php echo $row6['se_price'];?> </td>
                    <td></td>
                    </tr>  
                    <?php } ?>
						<tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs <?php echo  number_format($invoice['i_total'],2); ?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs <?php echo  number_format($invoice['i_total'],2); ?></td>
						</tr>
					</tbody>
				</table>
				<?php }else{?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Fees</th>
							<th  class="price">Amount</th>
							<th class="total">Total</th>
						</tr>
					</thead>	
					<tbody>
						<tr>
							<td>1</td>			
							<td>Book Fees</td>
							<td  class="price"s>Rs. <?php echo  $invoice['i_total']; ?></td>
							 
							<td class="total">Rs. <?php echo  $invoice['i_total']; ?></td>
						</tr>
						<tr>
							<td class="sub_total" colspan="2"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs <?php echo  number_format($invoice['i_total'],2); ?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="2"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs <?php echo  number_format($invoice['i_total'],2); ?></td>
						</tr>
					</tbody>
				</table>
				<?php }?>
			</div>
						</div>
										
				</div> <!-- .grid -->
		</div> <!-- .container -->		
	</div> <!-- #content -->	
</div> <!-- #wrapper -->
<!--<input name="" type="button" value="Print" onClick="javascript:printDiv('printablediv')" style="cursor:pointer; float:left;" />-->

<script src="javascripts/all.js"></script>
<script>
$().ready(function() {

	$("#show").change(function(){
		if(this.checked) {
	 
		window.location.href='invoice_prt.php?iid=<?=$i_id?>&show=full';
	}else{
		window.location.href="invoice_prt.php?iid=<?=$i_id?>";

	}
	
	});	
});
				 
</script>
</body>
</html>
<? ob_flush(); ?>