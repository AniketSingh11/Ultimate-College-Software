 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
	
 
	
	$book_title= mysql_real_escape_string($_POST["book_title"]);
	$category= mysql_real_escape_string($_POST["category"]);
	$a_name= mysql_real_escape_string($_POST["a_name"]);
	$edition= mysql_real_escape_string($_POST["edition"]);
	$qty= mysql_real_escape_string($_POST["qty"]);
	$publisher= mysql_real_escape_string($_POST["publisher"]);
	$book_number=mysql_real_escape_string($_POST["book_number"]);
	$shelf_no=mysql_real_escape_string($_POST["shelf_no"]);
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	$query="select * from lms_book where book_no='$book_number'";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Book Number Already Given &nbsp;";
	    
	}
 
	 if(!is_numeric($qty))
	 {
	     
	     $err_msg.="Book Copies(Qty)  Only Number Format Only &nbsp;";
	 }
	
	
	if($book_title!="" && $category!="" && $a_name!="" && $qty!="" && $publisher!="" && $book_number!="" && $shelf_no!="" && is_numeric($qty) && $chk!="1")
	{
	    
	    $qty=round($qty);
	    
	    $query="insert into lms_book(category,book_no,book_title,author_name,publisher,edition,qty,shelf_no,creation_date)
	    values('$category','$book_number','$book_title','$a_name','$publisher','$edition','$qty','$shelf_no','$date')";
	    $result=mysql_query($query);
	    
	    header("location:book_details_add.php?msg=succ");
	    
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
	
	
	  //  header("location:book_details_add.php?msg=err&err_msg=$err_msg");
 
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
			 <h1>Borrow Details  <a href="emp_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
  
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_SERVER["REQUEST_METHOD"]=="POST") { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?php echo $err_msg;?>!!
			</div>
<?php } ?>
 
                 
                   <?php 
                   
                   if(isset($_GET['bid']))
                   {
                       
                       $bid=$_GET['bid'];
                   }else{
                       
                       $bid=1;
                       
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
					Add	Borrow Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Borrow Details :</p>       
 
                       <div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Admission number<font color="red">*</font></label>
									<input type="text"  class="biginput form-control" id="autocomplete" name="admission_number">
									
								</div>
								 
				            	 
								    <div class="form-group">
									<label for="name">Book Tile<font color="red">*</font></label>
									<input type="text" list="b_name" name="b_name" class="form-control"  value="<?=$_POST["b_name"]?>" data-required="true">
									 <datalist id="b_name">
    <option value="Internet Explorer">
    <option value="Firefox">
    <option value="Chrome">
    <option value="Opera">
    <option value="Safari">
  </datalist>
								</div>
								
                                <div class="form-group">
									<label for="name">Author Name<font color="red">*</font></label>
									<input type="text" id="a_name" name="a_name" class="form-control"  value="<?=$_POST["a_name"]?>" data-required="true">
								</div>
                               
                                <div class="form-group">
									<label for="name">Edition</label>
									<input type="text" id="edition" value="<?=$_POST["edition"]?>" name="edition" class="form-control">
								</div>
                                
                                <div class="form-group">
									<label for="name">Book Avilable copies(Qty) <font color="red">*</font></label>
									<input type="text" id="qty" name="qty" data-type="digits"   value="<?=$_POST["qty"];?>"  class="form-control" data-required="true">
								</div>
								
								
                                <div class="form-group">
									<label for="name">Qualification </label>
									<input type="text" id="qualification" name="qualification" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
								<label for="textarea-input">Residential Address</label>
								<textarea name="address2" id="textarea-input" cols="10" rows="3" class="form-control"></textarea>
								</div>
                                <div class="form-group">
									<label for="name">Country </label>
									<input type="text" id="country" name="country" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Land Line No </label>
									<input type="text" id="lline" name="lline" class="form-control">
								</div>-->
                                
</div>
<div class="col-sm-6">
								 
							<!--  		 
								<p>Name : siva</p>
								<p>Stanard  : LKG</p>
								<p>Section  : A</p>
								<p>Book Count   : Already Get 3 Books </p>
								<p>Book 1 : End Date 12/03/2015  </p>
								<p>Book 2 : End Date 15/03/2015  </p>
								<p>Book 3 : End Date 17/03/2015  </p> -->
									 
								 
                              <div class="form-group">
									<label for="name">Publisher<font color="red">*</font></label>
									<input type="text" id="publisher" value="<?=$_POST["publisher"]?>" name="publisher" class="form-control" data-required="true">
								</div>
                               
                                <div class="form-group">
									<label for="name">Book Number<font color="red">*</font></label>
									<input type="text" id="book_number" value="<?=$_POST["book_number"]?>"  name="book_number" class="form-control" data-required="true">
								</div>
								
								  <div class="form-group">
									<label for="name">Shelf No<font color="red">*</font></label>
									<input type="text" id="shelf_no" name="shelf_no"  value="<?=$_POST["shelf_no"]?>" class="form-control" data-required="true">
								</div>
							 
                                <div class="form-group">	
									<label for="validateSelect">Marital Status</label>
									<select name="marital" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
                                        <option value="Widow">Widow</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Staff Type</label>
									<select name="staff_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Teaching">Teaching</option>
										<option value="Non-Teaching">Non-Teaching</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Job Type</label>
									<select name="job_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Permanent">Permanent</option>
										<option value="Temporary">Temporary</option>
									</select>
								</div>
                                <div class="form-group">
								<label for="textarea-input">Permanent Address</label>
								<textarea name="address1" id="textarea-input" cols="10" rows="3" class="form-control" data-required="true"></textarea>
								</div>
                                <div class="form-group">
									<label for="name">State </label>
									<input type="text" id="state" name="state" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Email ID </label>
									<input type="email" id="email" name="email" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Phone No</label>
									<input type="text" id="phone" name="phone" class="form-control" data-required="true">
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Transport</label>
									<select name="transport" class="form-control">
										<option value="">Select Transport</option>
										<option value="0">Regular Bus</option>
                                            <option value="1">Sp.Bus</option>
                                            <option value="2">Onetime Sp.Bus</option>	
									</select>
								</div> 
</div>
  			 </div>  <!-- /.portlet-content -->
             <div class="portlet-content">
     
     
 
<div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>

     </div>
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php
 
 include("footer.php");
 include("auto.php");
 
 ?>
 <?php include("includes/script.php");?>
</body>
</html>

<script>

 

 
function change_function1(){ 
	
    var bid =document.getElementById('bid').value;
	 window.location.href = 'student_borrow_details.php?bid='+bid;
	 	  
	}  
</script>


 <? ob_flush(); ?>