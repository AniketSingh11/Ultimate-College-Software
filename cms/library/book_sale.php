 <?php
 include("header.php");
 
 
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
     $ptype=$_POST['ptype'];
     $ss_id=$_POST["student_id"];
     $bid=$_POST["bid"];
     $in_no=$_POST['in_no'];
     $total=$_POST['total'];
     
     $res=mysql_query("select * from student where ss_id='$ss_id'");
     $row1=mysql_fetch_array($res);
     $admission_number=$row1["admission_number"];
     $firstname=$row1["firstname"];
     $lastname=$row1["lastname"];
     $name=$firstname." ".$lastname;
     
     $date=date("Y-m-d");
     
     if($total!="0")
     {
   
      $emp_display=mysql_query("select *   from lms_student_borrowbook where  ay_id='$acyear' and student_id='$ss_id' and b_id='$bid' and status='1' and fine_amount!='0' and 	paid_status='0'");
      $for_count=mysql_num_rows($emp_display);

      $sql="INSERT INTO lms_binvoice (in_no,student_id,name,admission_no,ay_id,b_id,b_total,paid_date,pay_type,fi_by) VALUES
                                   ('$in_no','$ss_id','$name','$admission_number','$acyear','$bid','$total','$date','$ptype','$user')";
       
      $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
      $lastid=$id = mysql_insert_id();
       
       
      $qry2=mysql_fetch_array(mysql_query("select * from invoice_no where id='2' "));
      $invoice_count=$qry2["count"]+1;
      $qry1=mysql_query("UPDATE invoice_no SET count='$invoice_count' WHERE id='2'");
   for ($i=1;$i <= $for_count; $i++){
       
       $sb_id=$_POST["sb_id$i"];
       
     
       if($sb_id!=""){
       
       $emp_query11="select * from lms_student_borrowbook where  sb_id='$sb_id' ";
       $emp_result11=mysql_query($emp_query11);
      
      $emp_display=mysql_fetch_array($emp_result11);
      
          
        /*   $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
           $row=mysql_fetch_array($res);
           $book_title=stripslashes($row["book_title"]);
           $book_no=stripslashes($row["book_no"]);*/
       
           $sb_id=stripslashes($emp_display["sb_id"]);
           $book_id=stripslashes($emp_display["book_id"]);
       
           $fine_amount=stripslashes($emp_display["fine_amount"]);

       $sql="INSERT INTO lms_binvoice_sumarry (	bin_id,sb_id,student_id,book_id,ay_id,b_id,amount,date) VALUES
                     ('$lastid','$sb_id','$ss_id','$book_id','$acyear','$bid','$fine_amount','$date')";
       
       $qry1=mysql_query("UPDATE lms_student_borrowbook SET paid_status='1' WHERE sb_id='$sb_id'"); 
       
       $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
       
       }      
   }
   
   header("location:view_invoice.php?bin_id=$lastid&bid=$bid&sid=$ss_id&msg=succ");
     }else{
         
         header("location:book_sale.php?bid=$bid&sid=$ss_id&&msg=err");
     }
   
 }
 
 
 
 
 
 
 
 
  $s_id=$_GET["sid"];
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



<?php   if(isset($_GET['bid']))
                   {
                       
                       $bid=$_GET['bid'];
                   }else{
                       
                       $board_query=mysql_query("SELECT * FROM board  order by b_id asc");
                       $bo=mysql_fetch_array($board_query);
                       
                       $bid=$bo['b_id'];
                        
                       
                   }
            ?>
				 <div class="portlet-header">
				 <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function1()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								 
                 </div>
				 			
					 <h3>						 
						Generate Invoice 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
		 
				 <div class="portlet-content">                      
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

 </div>  <!-- /.portlet-content -->
               
 
		 </div>  <!-- /#content-container -->
		   <form name="form1" id="validate-enhanced" method="post" action="book_sale.php?sid=<?=$s_id?>&bid=<?=$bid?>" class="form parsley-form">	
		 <div class="panel-group accordion" id="accordion">
		<?php  if($s_id){		 	

		    $qry3=mysql_query("SELECT * FROM invoice_no WHERE id='2'");
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
		
		$in_no="L".str_pad($invoice_no, 3, '0', STR_PAD_LEFT);
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
                                                                  
                        </div>         
       </div>   
				 		 <?php 
				 		 $emp_display=mysql_fetch_array(mysql_query("select sum(fine_amount) as fine from lms_student_borrowbook where  ay_id='$acyear' and student_id='$s_id' and b_id='$bid' and status='1' and fine_amount!='0' and 	paid_status='0'"));
				 		 $total=$emp_display[fine];
				 		 ?>
 
							<button class="btn btn-primary btn-small">Total Amount: Rs <?php echo number_format($total,2);?></button>	
 
						</div>
						<input type='hidden' name='in_no' value='<?=$in_no?>'>
						<input type='hidden' name='student_id' value='<?=$s_id?>'>
						<input type='hidden' name='bid' value='<?=$bid?>'>
				<table class="table table-striped">
					 
            	 <thead>
						<tr>
							<th>S.No</th>
							<th>Book Number</th>
							<th>Book Name</th>
							<th class="price">Fine Amount</th>
                            <th></th>
						</tr>
					</thead>
                    <tbody>			
						
		<?php	

		
$emp_query11="select * from lms_student_borrowbook where  ay_id='$acyear' and student_id='$s_id' and b_id='$bid' and status='1' and fine_amount!='0' and 	paid_status='0' ";
$emp_result11=mysql_query($emp_query11);
$counts=0;
while($emp_display=mysql_fetch_array($emp_result11))
{
    $counts=$counts+1;
    $book_no=stripslashes($emp_display["book_number"]);
    $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
    $row=mysql_fetch_array($res);
    $book_title=stripslashes($row["book_title"]);
   
    
    $sb_id=stripslashes($emp_display["sb_id"]);

    
    $fine_amount=stripslashes($emp_display["fine_amount"]);
?>
     
     
							 
	
					
                    <tr id="sb_id<?=$counts?>" bgcolor="#FFFFFF" >
                    <td><?php echo $counts;?></td>
                    <td><?php echo $book_no;?></td>
                    <td><?php echo $book_title;?></td>
                    <td class="total"><b>Rs.<?php echo  number_format($fine_amount,2);?></b></td>
                   <td><a href="javascript:del(<?=$counts?>)"><img src="img/layout/delete.png" alt="delete"></a></td>
                   
                   <input type="hidden"   name="sb_id<?=$counts?>" value="<?php echo $sb_id;?>"/>
                   
                   </tr>	
                    	
		 <?php }?>
		 <tr style="border-bottom:3pt solid black;" ></tr>
		 <tr>
							<td colspan="2"></td>
							<td ><b>Subtotal:</b></td>
							<td class="sub_total"><b>Rs. <?php echo number_format($total,2);?></b></td>
                            <td></td>
						</tr>
						<tr class="total_bar">
							<td  colspan="2"></td>
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
               
                <input type="submit" value="Update" class="btn btn-success btn-small btn-green">&nbsp;&nbsp;
                
                <input type="button" value="cancel" class="btn btn-small btn-primary btn-red" onClick="cancel_cart()"></td></tr>
		 
		  </tbody>	
					 </table>	
					 </form>
		 <?php if($counts==0){ echo "<br><h1 style='color:red';>No Books Available </h1>";}

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
		
	    var bid =document.getElementById('bid').value;
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