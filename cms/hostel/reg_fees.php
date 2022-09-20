 <?php
 include("header.php");
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
     $ptype=$_POST['ptype'];
     $ss_id=$_POST["student_id"];
    
     $in_no=$_POST['in_no'];
     $total=$_POST['total'];
     
     $fees_type=$_POST['fees_type'];
     
     $res=mysql_query("select * from student where ss_id='$ss_id'");
     $row1=mysql_fetch_array($res);
     $admission_number=$row1["admission_number"];
     $firstname=$row1["firstname"];
     $lastname=$row1["lastname"];
     $name=$firstname." ".$lastname;
     
     $emp_display=mysql_fetch_array(mysql_query("select * from hms_student_room where admission_number='$admission_number' and status='0'"));
     
     $hsr_id=$emp_display["hsr_id"];
     $hr_id=$emp_display["hr_id"];
     $hrc_id=$emp_display["hrc_id"];
     
     $date=date("Y-m-d");
     
     if($total!="0")
     {
   
     $sql="INSERT INTO hms_hinvoice(in_no,hsr_id,name,admission_no,ay_id,h_total,paid_date,pay_type,fi_by,fees_type) VALUES
                                   ('$in_no','$hsr_id','$name','$admission_number','$acyear','$total','$date','$ptype','$user','$fees_type')";
       
      $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
      $lastid=$id=mysql_insert_id();
       
       
      $qry2=mysql_fetch_array(mysql_query("select * from hms_invoice_no where hin_id='1'"));
      $invoice_count=$qry2["count"]+1;
      $qry1=mysql_query("UPDATE hms_invoice_no SET count='$invoice_count' WHERE hin_id='1'");
   
       
     if($fees_type=="Register Fees"){
       
           $query=mysql_query("SELECT * FROM hms_cash_deposit where ay_id='$acyear'");
           $res=mysql_fetch_array($query);
           $cash_amount=$res["amount"];
           
           $h_total=$total-$cash_amount;

       $sql="INSERT INTO hms_hinvoice_sumarry (hin_id,ay_id,fees_name,fees_type,amount,date) VALUES
                     ('$lastid','$acyear','Cash Deposit','Register Fees','$cash_amount','$date')";
       
        $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
       
        $sql="INSERT INTO hms_hinvoice_sumarry (hin_id,hsr_id,hr_id,hrc_id,ay_id,fees_name,fees_type,amount,date) VALUES
        ('$lastid','$hsr_id','$hr_id','$hrc_id','$acyear','Hostel Fees','Register Fees','$h_total','$date')";
         
        $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        
       }elseif ($fees_type=="Renew Fees")  

       {
           
           $sql="INSERT INTO hms_hinvoice_sumarry (hin_id,hsr_id,hr_id,hrc_id,ay_id,fees_name,fees_type,amount,date) VALUES
           ('$lastid','$hsr_id','$hr_id','$hrc_id','$acyear','Hostel Fees','Renew Fees','$total','$date')";
            
           $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
           
           
       }
       header("location:view_invoice.php?id=$lastid&sid=$ss_id&msg=succ");
     }else{
         
         header("location:reg_fees.php?id=$ss_id&fees_type=$fees_type&msg=err");
     }
   
 }
 
$s_id=$_GET["id"];
$fees_type=$_GET["fees_type"];

  ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Invoice <a onclick="history.go(-1)"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  Invoice Generate Failed!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>

 
				 <div class="portlet-header">
				 <h3>Generate Invoice </h3>			
				 </div>  <!-- /.portlet-header -->			
		 
			<!--	 <div class="portlet-content">                      
<div class="col-sm-12">
				            
				            	
				            	<div class="form-group">
									<label for="name">Student ID &nbsp;&nbsp;&nbsp;&nbsp;</label>
									<select id="student" onchange="select_employee()"  name="student" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select Student </option>
                                        <?php 
										$emp_query="select * from student where b_id='$bid' and ay_id='$acyear' order by firstname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$ss_id=$emp_display["ss_id"];		?>
                                        <option value="<?php echo $ss_id;?>" <?php if($s_id==$ss_id){ echo "selected"; }?>><?php echo  $emp_display["admission_number"]."-".$emp_display["firstname"]." ".$emp_display["lastname"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>       
                              
</div>

 </div>   /.portlet-content -->
               
 
		 </div>  <!-- /#content-container -->
		 <form name="form1" id="validate-enhanced" method="post" action="" class="form parsley-form">	
		 <div class="panel-group accordion" id="accordion">
		<?php  if($s_id && $fees_type){		 	

		    $qry3=mysql_query("SELECT * FROM hms_invoice_no WHERE hin_id='1'");
		    $row3=mysql_fetch_array($qry3);
		    $invoice_no=$row3['count'];
		    
        $res=mysql_query("select * from student where ss_id='$s_id'");
		$row1=mysql_fetch_array($res);
		$admission_number=$row1["admission_number"];
		$firstname=$row1["firstname"];
		$lastname=$row1["lastname"];
		$c_id=$row1["c_id"];
		$section_id=$row1["s_id"];
		
		$query=mysql_query("SELECT * FROM class where c_id='$c_id'");
		$res=mysql_fetch_array($query);
		$class_name=$res["c_name"];
		
		$query=mysql_query("SELECT * FROM section where s_id='$section_id'");
		$res=mysql_fetch_array($query);
		$section_name=$res["s_name"];
		
		$in_no="H".str_pad($invoice_no, 3, '0', STR_PAD_LEFT);
		
		$emp_display=mysql_fetch_array(mysql_query("select * from hms_student_room where admission_number='$admission_number' and status='0'"));
		
		$res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
		$row=mysql_fetch_array($res);
		$cat_name=$row["h_name"];
			
		$res=mysql_query("select * from hms_room where hr_id='$emp_display[hr_id]'");
		$row=mysql_fetch_array($res);
		$room_number=$row["room_number"];
		$room_type=$row["room_type"];
		
		$res=mysql_query("select * from hms_room_cart where hrc_id='$emp_display[hrc_id]'");
		$row=mysql_fetch_array($res);
		$cart_name=$row["cart_name"];
		?>
				 		 
   <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Admission Number:</label>
									<label for="value"><font color="red"><?php echo $admission_number;?> </font></label>
								</div> 
							     <div class="form-group">
									<label for="name">Student Name:</label>
									<label for="value"><font color="red"><?php echo $firstname." ".$lastname;?>  </font></label>
								</div>  
								 <div class="form-group">
									<label for="name">Section/Group:</label>
									<label for="value"><?php echo $class_name." - ".$section_name;?>  </label>
								</div> 
									<div class="form-group">
									<label for="name">Hostel Room/Cart :</label>
									 <label for="value"><?php echo $room_number." - ".$cart_name;?></label>
								</div>
                                    
   </div>
                            <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Invoice Number : </label>
									 <label for="value"><?php echo $in_no;?></label>
								</div>	
								<div class="form-group">
									<label for="name">Invoice Date :</label>
									 <label for="value"><?php echo date("d/m/Y");?></label>
								</div>		
								<div class="form-group">
									<label for="name">Hostel Name :</label>
									 <label for="value"><?php echo $cat_name;?></label>
								</div>
								
													
                                                                  
                        </div>         
       </div>   
				 		 
 
			<div id="move_div">	</div>
 
						</div>
						<input type='hidden' name='in_no' value='<?=$in_no?>'>
						<input type='hidden' name='student_id' value='<?=$s_id?>'>
						<input type='hidden' name='fees_type' value='<?=$fees_type?>'> 
				<table class="table table-striped">
					 
            	 <thead>
						<tr>
							<th>S.No</th>
						 
							<th>Fees</th>
							<th class="price">Amount</th>
                            <th></th>
						</tr>
					</thead>
                    <tbody>			
						
		<?php	

		$emp_query="select * from hms_student_room where admission_number='$admission_number' and status='0'";
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		 $emp_display=mysql_fetch_array($emp_result);
		 
			$hsr_id=$emp_display["hsr_id"];
			$hr_id=$emp_display["hr_id"];
			$hrc_id=$emp_display["hrc_id"];
			$r_ay_id=$emp_display["r_ay_id"];
			$reg_class=$emp_display["reg_class"];

			$join_date=$emp_display["join_date"];	
            $student_number=$emp_display["admission_number"];
            $firstname=$emp_display["firstname"];
           
            
            $res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
            $row1=mysql_fetch_array($res);
            $c_id=$row1["c_id"];	
		    $s_id=$row1["s_id"];
		    $student_id=$row1["ss_id"];
		    
		    
			$query=mysql_query("SELECT * FROM class where c_id='$c_id'");
			$res=mysql_fetch_array($query);
			$class_name=$res["c_name"];
			 
			$query=mysql_query("SELECT * FROM section where s_id='$s_id'");
			$res=mysql_fetch_array($query);
			$section_name=$res["s_name"];
			
			
			$res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
			$row=mysql_fetch_array($res);
			$cat_name=$row["h_name"];
			
			$res=mysql_query("select * from hms_room where hr_id='$hr_id'");
			$row=mysql_fetch_array($res);
			$room_number=$row["room_number"];
			$room_type=$row["room_type"];
			 
			$res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
			$row=mysql_fetch_array($res);
			$cart_name=$row["cart_name"];
			
			$res=mysql_query("select * from hms_fees_structure where section='$c_id' and ay_id='$acyear'");
			$row=mysql_fetch_array($res);
			$hfs_id=$row["hfs_id"];
			
			$res=mysql_query("select * from hms_feestype where 	hfs_id='$hfs_id' and room_type='$room_type'");
			$row=mysql_fetch_array($res);
			$amount=$row["amount"];
			$cash_amount=0;
			if($r_ay_id==$acyear)
			{
			    $query=mysql_query("SELECT * FROM hms_cash_deposit where ay_id='$r_ay_id'");
			    $res=mysql_fetch_array($query);
			    $cash_amount=$res["amount"];
			    
			    
			    
			}
			$total=$amount+$cash_amount;
?>
        <tr id="sb_id<?=$counts?>" bgcolor="#FFFFFF" >
                    <td>1</td>
                    
                    <td>Hostel Fees</td>
                    <td class="total"><b>Rs.<?php echo  number_format($amount,2);?></b></td>
                                     </tr>	
                                     <?php if($r_ay_id==$acyear){?>
                                     
                                       <tr id="sb_id<?=$counts?>" bgcolor="#FFFFFF" >
                    <td>2</td>
                    
                    <td>Cash Deposit Amount</td>
                    <td class="total"><b>Rs.<?php echo  number_format($cash_amount,2);?></b></td>
                                     </tr>	   
                                         
		                                       <?php   }?>
                    	
	 
		 <tr style="border-bottom:3pt solid black;" ></tr>
		 <tr>
							<td colspan="1"></td>
							<td ><b>Subtotal:</b></td>
							<td class="sub_total"><b>Rs. <?php echo number_format($total,2);?></b></td>
                            <td></td>
						</tr>
						<tr class="total_bar">
							<td  colspan="1"></td>
							<td ><b>Total:</b></td>
							<td class="grand_total"> <b>Rs. <?php echo number_format($total,2);?></b></td>
                            <td ><input type="hidden" class="medium" id="total" name="total" value="<?php echo $total;?>"/></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">Payment Type:<div class="form-group">		
									<div class="field">
										<select name="ptype" id="ptype"   data-required="true" >
											<option value="">Please select</option>	
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>									
										</select>										
									</div></td>
						</tr>
				<tr>
                <td></td>
                <td colspan="5" align="right">
               
                <input type="submit" value="Submit" class="btn btn-success btn-small btn-green">&nbsp;&nbsp;
                
                <input type="button" value="cancel" class="btn btn-small btn-primary btn-red" onClick="cancel_cart()"></td></tr>
		 
		  </tbody>	
					 </table>	
					 </form>
					 
					 <div id="tot_full">	<button class="btn btn-primary btn-small">Total Amount: Rs <?php echo number_format($total,2);?></button></div>
		 <?php if($counts==0){ //echo "<br><h1 style='color:red';>No Books Available </h1>";
                    }

           }
		 ?>
		  
		 
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");
 if($s_id){
     $emp_query11="select * from lms_student_borrowbook  where status='0' and student_id='$s_id' and b_id='$bid' and ay_id='$acyear'";
     $emp_result11=mysql_query($emp_query11);
     $counts=0;
     while($emp_display=mysql_fetch_array($emp_result11))
     {
         $counts=$counts+1;
         $sb_id=$emp_display["sb_id"];
 ?>
  
 <script type="text/javascript">

 $("#cEnd<?=$sb_id?>").datepicker({

	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});

 $("#dpEnd<?=$sb_id?>").datepicker({

	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});
	</script>
 <?php }}?>
 
  
  <script type="text/javascript">
   
  $('#sel_book').select2 ({
  	allowClear: true,
  	placeholder: "Select..."
  });
  $('#student').select2 ({
  	allowClear: true,
  	placeholder: "Select..."
  });
 
 
	 
 function status_report(n)
 {

 //var c=$('input[name=status]').val();
 var v=$("#status"+n).val();

 $("#renew_status"+n).hide();
 $("#closed_status"+n).hide();

 $("#"+v+"_status"+n).show();

 $("#cEnd"+n).val("");
 $("#r_bookstatus"+n).val("");
 $("#dpEnd"+n).val("");
 if(v=="renew"){
 	 $("#cEnd"+n).val("<?=date("d/m/Y")?>");

 	 $("#r_bookstatus"+n).val("c");
 }
 if(v=="closed"){
 	 $("#dpEnd"+n).val("<?=date("d/m/Y")?>");

 	 
 }

  

 }

 
 function change_function1(){ 
		
	    var bid=document.getElementById('bid').value;
		 window.location.href = 'book_sale.php?bid='+bid;
		 	  
		}

function cancel_cart()

{
	if(confirm('This will cancel your Bill, continue?')){
	 window.location="<?php echo basename($_SERVER["REQUEST_URI"],"/"); ?>";
	}
}


	
 function select_employee() { 
	  
      var student = parseFloat(document.getElementById('student').value);
      
      var bid =document.getElementById('bid').value;
      
	  if(student>0){
		  window.location="book_sale.php?sid="+student+'&bid='+bid;
	  }	
}
    $(document).ready(function(){ 

   	 $( "#tot_full" ).insertAfter( "#move_div" );
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        
      /*  $(".txt").each(function() { 
            $(this).keyup(function(){
                loan();
            });
        }); */
        
    });
	
 function del(n){
	// var thirdCol= $("tr").find('.total').text();
	// alert(thirdCol)
	  $("#sb_id"+n).remove();
		var stot=0;
	 $(".total").each(function() { 
		var t=$(this).text();
		var res = t.replace(/Rs./g, "");
		stot=parseInt(res)+parseInt(stot);
         });

	 $(".sub_total").html("<b>Rs."+stot+".00</b>");
	 $(".grand_total").html("<b>Rs."+stot+".00</b>");
	 $("#total").val(stot);
 }

	
</script> 
   
</body>
</html>

 <? ob_flush(); ?>