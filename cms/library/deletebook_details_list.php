 <?php
 include("header.php");
  $s_id=$_GET["emp"];
  
  if(isset($_POST["submit"]))
  {
	  
      $book_id=addslashes(trim($_POST["sel_book"]));
      $book_number=addslashes(trim($_POST["book_number"]));
      
      $err_msg="";
      
      
      $res1=mysql_query("select * from lms_student_borrowbook where   book_id='$book_id' and book_number='$book_number' and status='0'") or die(mysql_error());
      $chk=0;
      while($row1=mysql_fetch_array($res1))
      {
         $chk=1; 
         $err_msg.="Book is Already get some Student..  &nbsp;";
          
      }
      
      $res1=mysql_query("select * from lms_staff_borrowbook where book_id='$book_id' and book_number='$book_number' and status='0'") or die(mysql_error());
      $chk1=0;
      while($row1=mysql_fetch_array($res1))
      {
          $chk1=1;
          $err_msg.="Book is Already get some Staff..  &nbsp;";
      
      }
      
      if($chk!="1" && $chk1!="1")
      {
          
          $query="select * from lms_book where  b_id='$book_id'";
          $res=mysql_query($query) or die(mysql_error());
          $row=mysql_fetch_array($res);
          $oldqty=$row["qty"];
          $oldavilable_qty=$row["avilable_qty"];
          
         
              $qty=$oldqty;
              $avilable_qty=$oldavilable_qty;
          
          
          $qty=$oldqty-1;
          if($oldavilable_qty!=0)
          {
          $avilable_qty=$oldavilable_qty-1;
          }
       
          $qry=mysql_query("update lms_book set qty='$qty',avilable_qty='$avilable_qty' where b_id='$book_id'");
          
          
	     $qry=mysql_query("update lms_book_snumber set status='1' where ibs_id='$book_number'");
	
	    
	    header("location:deletebook_details_list.php?msg=succ");
	    
      }else{
          
          header("location:deletebook_details_list.php?msg=err&err_msg=$err_msg");
          
      }
      
      
  }
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
			 <h1> Delete List of  Book Number </h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Book Number Successfully Deleted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"] ?>!!!
			</div>
<?php }?>
 



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
				<!--   <div class="_25" style="float:right">
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
								 
                 </div>-->
				 			
					 <h3>	Delete List of Book number </h3>	
					 
	 <?php if($s_id){ ?> <a href="loan_add.php" style="float:right;"><button type="button" class="btn btn-warning" > Select Another Student</button></a><?php } ?>
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				<?php if(!$s_id){ ?>  
				 <div class="portlet-content"> 
				                      
                       <div class="col-sm-12">
				            	
				            	<div class="form-group">
									<label for="name">Book Title </label>
									<select id="sel_book"   placeholder="Please select Book" name="sel_book" data-required="true" class="form-control" style="width:50%">
                                      <option value=''>Select</option>
                                        <?php 
										$emp_query="select * from lms_book where avilable_qty!='0' and status='0' and specimen='0' order by book_title asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$b_id=$emp_display["b_id"];		?>
                                        <option value="<?php echo $b_id;?>"><?php echo $emp_display["book_title"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>  
								
				            	 <div class="form-group">
									<label for="name">Book Number </label>
									<select  id="book_number"   placeholder="Please select Book" name="book_number" data-required="true" class="form-control" style="width:50%">
                                     <option value=''>Select</option>
                                       							
                            		</select>
								</div>
								 
					  </div>

                             <div class="col-sm-12">
                           <center>
                             <div class="form-group"><input type="hidden" name="b_id" value="<?php echo  $bid;?>"/>
								<input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
                                <input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
                          </center>
                                </div>


  			 </div>  <!-- /.portlet-content -->
             <?php 
				 }			?>
  
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">


 function sd()
 {
var v=$("#sel_book").val();
alert(v);
 }

function change_function1(){ 
		
var bid=document.getElementById('bid').value;
 window.location.href = 'student_book_details.php?bid='+bid;
		 	  
		}

 $('#dpStart').datepicker({
	 
	    daysOfWeekDisabled: [0,0]
	});

  
 $('#dpEnd').datepicker({
  daysOfWeekDisabled: [0,0]
	});
 $('#sel_book').select2 ({
		allowClear: true,
		placeholder: "Select..."
	}).on("change", function(e) {
 
	       var bid=$('#sel_book').val();
 
		 
		   var request =$.ajax({
			   url: "ajax_booknumber_details.php",
			   // context: document.body
		 type: "POST",
		 data: { bid : bid},
		 dataType: "html"
			  });
			 // The function inside done() gets executed once the ajax request has been completed /
			  request.done(
		   		  
			    function(dataFromTheBackEnd) {
				   // alert(dataFromTheBackEnd);
				    $("#book_number").html(dataFromTheBackEnd);
			    }
			    
			  );
})  
	
 $('#student').select2 ({
		allowClear: true,
		placeholder: "Select..."
	}) 
	
	
	 $('#book_number').select2 ({
			allowClear: true,
			placeholder: "Select..."
		})
	
 function select_employee() { 
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="student_book_details.php?emp="+employee;
	  }	
}
    $(document).ready(function(){ 
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".txt").each(function() { 
            $(this).keyup(function(){
                loan();
            });
        }); 
    });
	
 function loan() {	 
var a = document.first.l_t_amount.value;
var b = document.first.l_interest.value;
var c = document.first.l_terms.value;

//var n = c * 12;
var n = c;
var r = b/(12*100);
var p = (a * r *Math.pow((1+r),n))/(Math.pow((1+r),n)-1);
var prin = Math.round(p);
var total = Math.round(p*c);
var total_inrest = Math.round(total-a);
document.first.l_m_pay.value = prin;
document.first.l_t_inrest.value = total_inrest;
document.first.l_t_pay.value = total;
/*var mon = Math.round(((n * prin) - a)*100)/100;
document.first.r2.value = mon;
alert(mon);
var tot = Math.round((mon/n)*100)/100;
document.first.r3.value = tot;
for(var i=0;i<n;i++)
{
var z = a * r * 1;
var q = Math.round(z*100)/100;
var t = p - z;
var w = Math.round(t*100)/100;
var e = a-t;
var l = Math.round(e*100)/100;
a=e;
}*/
} 

</script>
</body>
</html>

 <? ob_flush(); ?>