 <?php
 include("header.php");
 
 
 $s_id=$_GET["sid"];
 $bin_id=$_GET["bin_id"];
 
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
			 <h1> View Invoice <a onclick="history.go(-1)"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
          <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Invoice Generate Successfully.. 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"] ?>!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>
                 <div class="portlet-header">
	                  <h3>						 
						Generate Invoice 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
	  </div>  <!-- /#content-container -->
		  
		 <div class="panel-group accordion" id="accordion">
		<?php  if($s_id){

		   
		   $query=mysql_query("SELECT * FROM lms_binvoice where bin_id='$bin_id'");
		   $res=mysql_fetch_array($query);
		   $in_no=$res["in_no"];
		   $pay_type=$res["pay_type"];
		   
	 $in_date = date("d/m/Y", strtotime($res["paid_date"]));
	 
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
									 <label for="value"><?php echo $in_date;?></label>
								</div>							
                                                                  
                        </div>         
       </div>   
				 		 <?php 
				 		 $emp_display=mysql_fetch_array(mysql_query("select sum(amount) as fine from lms_binvoice_sumarry where  ay_id='$acyear' and student_id='$s_id' and bin_id='$bin_id'"));
				 		 $total=$emp_display[fine];
				 		 ?>
 
							 
 
						</div>
						 
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

		
$emp_query11="select * from lms_binvoice_sumarry where  ay_id='$acyear' and student_id='$s_id' and bin_id='$bin_id'";
$emp_result11=mysql_query($emp_query11);
$counts=0;
while($emp_display=mysql_fetch_array($emp_result11))
{
    $counts=$counts+1;
    $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
    $row=mysql_fetch_array($res);
    $book_title=stripslashes($row["book_title"]);
    $book_no=stripslashes($row["book_no"]);
    
    $sb_id=stripslashes($emp_display["sb_id"]);

    
    $fine_amount=stripslashes($emp_display["amount"]);
?>
     
     
							 
	
					
                    <tr id="sb_id<?=$counts?>" bgcolor="#FFFFFF" >
                    <td><?php echo $counts;?></td>
                    <td><?php echo $book_no;?></td>
                    <td><?php echo $book_title;?></td>
                    <td class="total"><b>Rs.<?php echo  number_format($fine_amount,2);?></b></td>
                   <td></td>
                   
                  
                   
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
							<td colspan="2"></td>
							<td ><b>Payment Type:</b></td>
							<td class="sub_total"><b><?php echo $pay_type;?></b></td>
                            <td></td>
						</tr>
                      
				<tr>
                <td></td>
                <td colspan="5" align="left">
               
                <input type="button" value="Print Invoice" class="btn btn-success btn-small btn-green">&nbsp;&nbsp;
                
                <a href="book_sale.php?sid=<?=$s_id?>"><input type="button" value="Make Another Payment" class="btn btn-small  btn-primary" ></a></td></tr>
		 
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
?>
 
  
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