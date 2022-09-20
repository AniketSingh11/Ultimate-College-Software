<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
?>
<link rel="stylesheet" href="stylesheets/sample_pages/invoice.css" type="text/css" />
<body>

<div id="wrapper">
	
	<div id="header">
		<h1><a href="dashboard.php">Book Inventory</a></h1>		
		<a href="javascript:;" id="reveal-nav">
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
		</a>
	</div> <!-- #header -->
	
	<div id="search">
		<form>
			<input type="text" name="search" placeholder="Search..." id="searchField" />
		</form>		
	</div> <!-- #search -->
	
	<div id="sidebar">		
		
		  <?php include 'sidebar.php';?>
				
	</div> <!-- #sidebar -->
	
	<div id="content">		
		
		<div id="contentHeader">
			<h1>Invoice</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
				
				<div class="grid-17">				
					<div id="invoice" class="widget widget-plain">	
					<?php 
					$i_id=$_GET['iid'];
					if(isset($_GET['del_succ']))
					{
					    
					    if($_GET['del_succ']=="delete")
					    {
					    
               $qry=mysql_query("update invoice set i_status='1' where i_id=$i_id");
               $qry=mysql_query("update salessumarry set i_status='1' where i_id=$i_id");
               
               $query1="select  * from `salessumarry` where  i_id='$i_id'";
               $res1=mysql_query($query1) or die(mysql_error());
               
               while($row1=mysql_fetch_array($res1))
               {
               $b_id=$row1["b_id"];
               $sa_qty=$row1["sa_qty"];

               
               $qry2=mysql_fetch_array(mysql_query("select * from book where b_id='$b_id'"));
               $b_qtysold=$qry2["b_qtysold"]-$sa_qty;
               $b_qtyleft=$qry2["b_qtyleft"]+$sa_qty;
			   
			   $type=$qry2["type"];
			   $nid=$qry2["n_id"];
               
               $qry=mysql_query("update book set b_qtysold='$b_qtysold',b_qtyleft='$b_qtyleft'  where b_id='$b_id'");
                   if($type == 'N'){
					$nbooklist=mysql_query("SELECT * FROM notebook_purchese WHERE n_id='$nid'"); 
								  $nbook=mysql_fetch_array($nbooklist);
								  $nqtysold=$nbook['n_qtysold'];
								  $nqtyleft=$nbook['n_qtyleft'];
								  $nqtysold = $nqtysold-$sa_qty;
								  $nqtyleft = $nqtyleft+$sa_qty;
				    $qry=mysql_query("UPDATE notebook_purchese SET n_qtysold='$nqtysold',n_qtyleft='$nqtyleft' WHERE n_id='$nid'");
				  }
               }
               ?> 
                    <div class="notify notify-success">						
						<a href="javascript:;" class="close">&times;</a>						
						 					
						<p>Your Invoice bill successfully Rejected!!!</p>
					</div>
				<?php	}

					    }?>
					
							
						 <a href="invoicelist.php" style="margin:3px 0 0 20px;"><button class="btn btn-success">Back</button></a>
						 <?php 
						
						$invoicelist1=mysql_query("SELECT * FROM invoice WHERE i_id=$i_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
									
									$ssid=$invoice['ss_id'];
									
									$i_status=$invoice['i_status'];
									
									
								  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
			?>
						 <?php if($i_status!=1){?>
						 &nbsp;&nbsp;&nbsp;&nbsp;  <input type="button" value="Reject Invoice" class="btn btn-small btn-red" onClick="clear_cart()">&nbsp;&nbsp;
						 <?php }?>
						<div class="widget-header">
							<h3>Invoice</h3>   
                                                     
						</div>
						
						<div class="widget-content">
                        
				<ul class="client_details">
					<li><strong class="name"><?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?></strong></li>
					<li>Admission No: <?php echo $student1['admission_number'];?></li>
					<li>Class: <?php echo $row['c_name'];?></li>
					<li>Section/Group: <?php echo $row1['s_name'];?></li>
                    <li>Gender: <?php if($student1['ss_gender'] =='M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
				
				<ul class="invoice_details">
					<li>Status: <span class="ticket ticket-info">close</span></li>
					<li>Invoice Number: <?php echo $invoice['i_no']; ?></li>
					<li>Invoice Date: <?php echo $invoice['i_day']."/".$invoice['i_month']."/".$invoice['i_year']; ?></li>
				</ul>
				
				
				<div class="clear"></div>
			
				<table class="table table-striped">
					
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
							<td class="sub_total">Rs <?php echo  $invoice['i_total']; ?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs <?php echo  $invoice['i_total']; ?></td>
						</tr>
					</tbody>
				</table>
				<a href="invoice_prt.php?iid=<?php echo $i_id;?>" target="_blank" ><input name="" type="button" value="Print" class="btn btn-small btn-success" style="cursor:pointer; float:left;" /></a>
				
			</div>
						</div>
										
				</div> <!-- .grid -->
				
		<div class="grid-7">			
			<div class="box">
				<div id="invoice_total">Rs <?php echo  $invoice['i_total']; ?></div>				
				<br />				
				<!--<h3>Invoice Actions</h3>								
				<ul id="invoice_actions" class="">
					<li class="send"><a href="javascript:;">Send Invoice</a></li>
					<li class="edit"><a href="javascript:;">Edit Invoice</a></li>
					<li class="print"><a href="javascript:;">Print Invoice</a></li>
					<li class="duplicate"><a href="javascript:;">Duplicate Invoice</a></li>
					<li class="delete"><a href="javascript:;">Delete Invoice</a></li>
					<li class="change"><a href="javascript:;">Change Status</a></li>
				</ul>-->
				
			</div> <!-- .box -->		
			
		</div> <!-- .grid -->
		</div> <!-- .container -->		
	</div> <!-- #content -->	
	<?php include("includes/topnav.php"); ?>
     <!-- .quickNav -->
</div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>
<script>
function clear_cart(){
	if(confirm('Are You Reject this Bill invoice, continue?')){

		window.location.href='invoice.php?iid=<?=$i_id?>&del_succ=delete';
		//document.form1.command.value='clear';
		//document.form1.submit();
	}
}
</script>

</body>
</html>
<? ob_flush(); ?>