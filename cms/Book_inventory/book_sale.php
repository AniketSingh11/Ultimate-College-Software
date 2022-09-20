<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
include("includes/functions.php");

if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}
	else if($_REQUEST['command']=='clear'){
		unset($_SESSION['cart']);
	}
	else if($_REQUEST['command']=='cancel'){
		unset($_SESSION['cart']);
		header("location:book_sale.php");
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['bookid'];
			$q=intval($_REQUEST['product'.$pid]);
			if($q>0 && $q<=999){
				$_SESSION['cart'][$i]['qty']=$q;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
			}
		}
	}
	
if (isset($_POST['roll-submit']))
{
	$roll=explode("-",$_POST['roll']);
	 $roll=$roll[0];
		
		$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$roll' AND ay_id=$acyear"); 
								  $student=mysql_fetch_array($studentlist);
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
				$classlist1=mysql_query("SELECT * FROM invoice WHERE ss_id=$ssid"); 
								  $class11=mysql_fetch_array($classlist1);	
		//$booklist=mysql_query("SELECT * FROM book WHERE c_id=$cid AND s_id=$sid");  /* With Section/Group */
		$invoicelist=mysql_query("SELECT * FROM invoice WHERE ss_id=$ssid"); 
								  $invoice=mysql_fetch_array($invoicelist);	
		/*if(!$invoice){*/
		if($student){
			unset($_SESSION['cart']);
			$cname1=$class1['c_name'];
						if($cname1 == 'XI STD' || $cname1 == 'XII STD' || $cname1 == 'XI' || $cname1 == 'XII'){ 
							$booklist=mysql_query("SELECT * FROM book WHERE c_id=$cid AND s_id=$sid ORDER BY type");
						}else{
							$booklist=mysql_query("SELECT * FROM book WHERE c_id=$cid ORDER BY type");
						}
		//$booklist=mysql_query("SELECT * FROM book WHERE c_id=$cid");
								  //$book=mysql_fetch_array($booklist);
								   while($book=mysql_fetch_array($booklist))
        		{						  
								  
								  $bid=$book['b_id'];
								  $qty=$book['qty'];
								  $category=$book['category'];
								 if($category == $ss_gender || $category == 'C'){
								addtocart($bid,$qty);
								 }
				}
				header("location:book_sale.php?roll=$roll&ss_id=$ssid");
		}else{
			header("location:book_sale.php");
		}
		/*}else{
			header("location:book_sale.php?msg=already");
		}*/
		
}	

if (isset($_POST['place-order']))
{
	  $ptype=$_POST['ptype'];
	  $ssid1=$_POST['ssid1'];
	  $ss_name=$_POST['ss_name'];
	  $cid1=$_POST['cid1'];
	  $sid=$_POST['sid'];
	  $in_no=$_POST['in_no'];
	  
	  $idate=$_POST['idate'];
	   $idatesplit=explode("/",$idate);  
	    $day=$idatesplit[0]; 
	    $month=$idatesplit[1];
	    $year=$idatesplit[2];
		
	  /*$day=date("d");
	  $month=date("m");
	  $year=date("Y");*/
	  $seid=$_POST['se_id'];
	  $total=$_POST['total'];
	 
	 echo $sql="INSERT INTO invoice (i_no,i_name,i_total,i_ptype,i_day,i_month,i_year,ss_id,c_id,s_id,se_id,brdid,ay_id) VALUES
('$in_no','$ss_name','$total','$ptype','$day','$month','$year','$ssid1','$cid1','$sid','$seid','$brdid','$acyear')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
    if($result){
		$invoicelist=mysql_query("SELECT * FROM invoice WHERE i_id='$lastid'"); 
								  $invoice=mysql_fetch_array($invoicelist);
								  $i_id=$invoice['i_id'];
								  
								  $inovoice=$in_no+1; 
					$qry1=mysql_query("UPDATE invoice_no SET count='$inovoice' WHERE id='1'");
								  
		$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					 $pid=$_SESSION['cart'][$i]['bookid'];
					 $q=$_SESSION['cart'][$i]['qty'];
					 $pname=get_product_name($pid);
					if($q==0) continue;
					
					 $price=get_price($pid);
					 $btotal=number_format((get_price($pid)*$q),2);
					//echo "<br>";
					
					$sql1="INSERT INTO salessumarry (i_id,b_id,b_name,sa_qty,sa_price,sa_total,brdid,ay_id) VALUES
('$i_id','$pid','$pname','$q','$price','$btotal','$brdid','$acyear')";
					$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
					
					$booklist=mysql_query("SELECT * FROM book WHERE b_id='$pid'"); 
								  $book=mysql_fetch_array($booklist);
								  $type=$book['type'];
							 	  $nid=$book['n_id'];
				if($type == 'B'){
								  $qtysold=$book['b_qtysold'];
								  $qtyleft=$book['b_qtyleft'];
								  $qtysold = $qtysold+$q;
								  $qtyleft = $qtyleft-$q;
				    $qry=mysql_query("UPDATE book SET b_qtysold='$qtysold',b_qtyleft='$qtyleft' WHERE b_id='$pid'");								 				}else if($type == 'N'){
					$nbooklist=mysql_query("SELECT * FROM notebook_purchese WHERE n_id='$nid'"); 
								  $nbook=mysql_fetch_array($nbooklist);
								  $nqtysold=$nbook['n_qtysold'];
								  $nqtyleft=$nbook['n_qtyleft'];
								  $nqtysold = $nqtysold+$q;
								  $nqtyleft = $nqtyleft-$q;
				    $qry=mysql_query("UPDATE notebook_purchese SET n_qtysold='$nqtysold',n_qtyleft='$nqtyleft' WHERE n_id='$nid'");
				  }
					
				}
				unset($_SESSION['cart']);
				header("location:invoice.php?iid=$lastid");
				
    }
	 
		
}		
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
						
						<div class="widget-header">
							<h3>Invoice</h3>
						</div>
						
						<div class="widget-content">
                        <?php if($_GET['roll'] && $_GET['ss_id']){
							?>
                            <form name="form1" method="post" action="" class="form validateForm">
<input type="hidden" name="pid" />
<input type="hidden" name="command" />
				<?php 
					$ssid=$_GET['ss_id'];
					$studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$student1['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$student1['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $qry3=mysql_query("SELECT * FROM invoice_no WHERE id='1'"); 
								  $row3=mysql_fetch_array($qry3);
								  $invoice_no=$row3['count'];
								  
				?>
                <ul class="client_details">
					<li><strong class="name"><?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?><input type="hidden" class="medium" name="ss_name" value="<?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?>"/></strong></li>
					<li>Admission No: <?php echo $student1['admission_number'];?><input type="hidden" class="medium" name="ssid1" value="<?php echo $ssid;?>"/></li>
				</li>
					<li>Class: <?php echo $row['c_name'];?><input type="hidden" class="medium" name="cid1" value="<?php echo $cid1;?>" > 	
                </li>
                    <li>Section/Group: <?php echo $row1['s_name'];?><input type="hidden" class="medium" name="sid" value="<?php echo $sid1;?>" > 	
                </li>
                <li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
               </ul>
				
				<ul class="invoice_details">
					<li>Status: <span class="ticket ticket-info">Open</span></li>
					<li>Invoice Number: <?php echo $invoice_no;?></li><input type="hidden" class="medium" name="in_no" value="<?php echo $invoice_no;?>" > 
					<li>Invoice Date: <input type="text" name="idate" id="datepicker" value="<?php echo date("d/m/Y");?>" class="validate[required]" /></li>
               </ul>				
				
				<div class="clear"></div>
			
				<table class="table table-striped">
					<?php
			if(is_array($_SESSION['cart'])){ ?>
            	 <thead>
						<tr>
							<th>S.No</th>
							<th>Book Name</th>
							<th class="price">Price</th>
                            <th>Qty</th>
							<th class="total">Total</th>
                            <th></th>
						</tr>
					</thead>
                    <tbody>
				<?php $max=count($_SESSION['cart']);
				$count=0;
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['bookid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pname=get_product_name($pid);
					if($q==0) continue;
					
			?>
            		<tr bgcolor="#FFFFFF">
                    <td><?php echo $i+1?></td>
                    <td><?php echo $pname?></td>
                    <td class="price">Rs: <?php echo get_price($pid)?></td>
                    <td><input type="text" name="product<?php echo $pid?>" value="<?php echo $q?>" maxlength="3" size="2" /></td>                    
                    <td class="total">Rs: <?php echo number_format((get_price($pid)*$q),2);?></td>
                    <td><a href="javascript:del(<?php echo $pid?>)"><img src="./images/del.png" alt="delete"></a></td></tr>
            <?php
			$count++;					
				}
				
				$invoicelist=mysql_query("SELECT * FROM invoice WHERE ss_id=$ssid"); 
								  $invoice=mysql_fetch_array($invoicelist);	
								  
				if(!$invoice) {
									  
						if($row['c_name'] == 'XI STD' || $row['c_name'] == 'XII STD'){
						$qry5=mysql_query("SELECT * FROM service WHERE c_id=$cid1 AND s_id=$sid1"); }
						else{
							$qry5=mysql_query("SELECT * FROM service WHERE c_id=$cid1"); }
								  $row5=mysql_fetch_array($qry5);
				if($row5){
			?>			
            		<tr bgcolor="#FFFFFF">
                    <td><?php echo $count+1?></td>
                    <td colspan="3">Service Charges</td>
                    <td class="total">Rs: <?php echo $row5['se_price'];?> <input type="hidden" class="medium" name="se_id" value="<?php echo $row5['se_id'];?>" /> </td>
                    <td></td>
                    </tr>
                    <?php } 
				}
					?>
            		<tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs <?php 
							$charge = 0;
							$charge =$row5['se_price'];
							$total = get_order_total();
							$total +=$charge;
							 echo number_format($total,2);?></td>
                            <td class="sub_total"></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs <?php echo number_format($total,2);?><input type="hidden" class="medium" name="total" value="<?php echo $total;?>"/></td>
                            <td class="grand_total"></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">Payment Type:<div class="field-group">		
									<div class="field">
										<select name="ptype" id="ptype" class="validate[required]">
											<option value="">Please select</option>	
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>									
										</select>										
									</div></td>
						</tr>
				<tr>
                <td></td>
                <td colspan="5" align="right">
                <input type="button" value="Clear" class="btn btn-small btn-red" onClick="clear_cart()">&nbsp;&nbsp;
                <input type="button" value="Update" class="btn btn-small btn-green" onClick="update_cart()">&nbsp;&nbsp;
                <input type="submit" value="Place Order" name="place-order" class="btn btn-small btn-blue">&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-small btn-red" onClick="cancel_cart()"></td></tr>
                
                </tbody>
			<?php
            }
			else{
				echo '<tr bgColor="#FFFFFF"><td>There are no Book items in your Invoice !!!</td><td><input type="button" value="cancel" class="btn btn-small btn-red" onclick="cancel_cart()">';
			}
		?>
				</table>
                </form>
                <?php } else {
					//unset($_SESSION['cart']);
							//echo "is this?";
					?>
                
                        <div class="field-group">
									<form class="form uniformForm validateForm" method="post" action=""><label for="required">Student Roll No:</label>
                                    <input type="text" name="roll" class="biginput" id="autocomplete" /> <button type="submit" name="roll-submit" class="btn btn-error">Submit</button></form>											
								</div> <!-- .field-group -->
				<!--<ul class="client_details">
					Choose a currency and the results will display here.
				</ul>-->
				<?php
				if($_GET['msg'] =="already"){
				echo '<tr bgColor="#FFFFFF"><td>The student has already taken!!!</td><td>';
				}
				 }?>				
			</div>
						</div>
										
				</div> <!-- .grid -->				
		<?php if($_GET['roll'] && $_GET['ss_id']){
							?>
        <div class="grid-7">			
			<div class="box">
				<div id="invoice_total">Rs <?php echo number_format($total,2);?></div>				
				<!--<br />				
				<h3>Invoice Actions</h3>								
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
        <?php } ?>
		</div> <!-- .container -->
		
	</div> <!-- #content -->
	
	<?php 
	include("includes/topnav.php");
	?> <!-- #topNav -->
	
	
	
	
</div> <!-- #wrapper -->

<?php 
include("includes/footer.php"); 
include("auto.php");?>
<script type="text/javascript">
$(document).ready(function() {		 
		  $("#datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
	});	
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your Billing, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		document.form1.command.value='update';
		document.form1.submit();
	}
	function cancel_cart(){
		if(confirm('This will cancel your Bill, continue?')){
			document.form1.command.value='cancel';
			document.form1.submit();
		}
	}


</script>
</body>
</html>
<? ob_flush(); ?>