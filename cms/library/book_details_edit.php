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
	$id=mysql_real_escape_string($_POST["id"]);
	
	$purchase_date=mysql_real_escape_string($_POST["purchase_date"]);
	$mrp_rs=mysql_real_escape_string($_POST["mrp_rs"]);
	//$sp_book=mysql_real_escape_string($_POST["sp_book"]);
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	
	
	$query="select * from lms_book where  b_id='$id'";
	$res=mysql_query($query) or die(mysql_error());
	$row=mysql_fetch_array($res);
	$oldqty=$row["qty"];
	$oldavilable_qty=$row["avilable_qty"];
	
	
	if($qty <  $oldqty)
	{
	    
	    if($oldqty==$oldavilable_qty)
	        $avilable_qty=$qty;
	     else
	    $err_msg.="Return the remaining book &nbsp;";
	}elseif ($qty  >  $oldqty)
	{
	    $avilable_qty=$oldavilable_qty+($qty-$oldqty);
	    $insert=1;
	    
	}else{
	    
        $avilable_qty=$qty;
	    
	}
	
 
	 if(!is_numeric($qty))
	 {
	     
	     $err_msg.="Book Copies(Qty)  Only Number Format Only &nbsp;";
	 }
	
	
	if($book_title!="" && $category!="" && $a_name!="" && $qty!="" && $publisher!="" && $purchase_date!="" && $shelf_no!="" && is_numeric($qty))
	{
	    
if($insert==1)
{
	    for($i=$oldqty;$i<$qty;$i++)
	    {
	    
	    $query="insert into lms_book_snumber(b_id)
	    values('$id')";
	    $result=mysql_query($query);
	    }
	    
}
	    $qty=round($qty);
	    
	   $qry=mysql_query("update lms_book set category='$category',book_title='$book_title',author_name='$a_name',publisher='$publisher',edition='$edition',qty='$qty',avilable_qty='$avilable_qty',shelf_no='$shelf_no',purchase_date='$purchase_date',mrp_rs='$mrp_rs' where b_id='$id'");
	
        header("location:book_details_edit.php?id=$id&msg=succ");
	    
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
	   header("location:book_details_edit.php?id=$id&msg=err&err_msg=$err_msg");
 
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
			 <h1> Book Details Edit <a href="book_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 
		 <div id="content-container">
			 <div class="portlet">
    
 <?php if($_GET["msg"] == 'succ') { ?>	
             <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Updated 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
             <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"];?>!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Book Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $s_id=$_GET["id"];
$book_query="select * from lms_book  where b_id='$s_id' and status='0'";
$book_result=mysql_query($book_query);
$book_display=mysql_fetch_array($book_result);
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">

				 <div class="portlet-content">
     <p class="title">Book Details :</p>  
          
         <div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Book Titles<font color="red">*</font></label>
									<input type="text" id="book_title" name="book_title"   class="form-control" data-required="true"  value="<?=$book_display["book_title"]?>" >
								</div>
                                <div class="form-group">
									<label for="name">Author Name<font color="red">*</font></label>
									<input type="text" id="a_name" name="a_name" class="form-control"  value="<?=$book_display["author_name"]?>" data-required="true">
								</div>
                               
                                <div class="form-group">
									<label for="name">Edition</label>
									<input type="text" id="edition" value="<?=$book_display["edition"]?>" name="edition" class="form-control">
								</div>
                                
                                <div class="form-group">
									<label for="name">Book copies(Qty) <font color="red">*</font></label>
									<select id="qty" name="qty" class="form-control" data-required="true">
									<?php for($j=$book_display["qty"];$j<=100;$j++)
									{?>
									<option value='<?=$j?>'><?=$j?></option>
									<?php }?>
									</select>
									<!--  <input type="text" id="qty" name="qty" data-type="digits"   value="<?=$book_display["qty"];?>"  class="form-control" data-required="true">-->
								</div>
								
								 <div class="form-group">
									<label for="name">purchase date<font color="red">*</font></label>
									 <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Start date" name="purchase_date" data-minlength="10"   data-maxlength="10" value="<?=$book_display["purchase_date"];?>" id="dpStart" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
									 
								</div>
             </div>       
             
                        
<div class="col-sm-6">
<div class="form-group">	
									<label for="validateSelect">Category<font color="red">*</font></label>
									<select name="category" class="form-control" data-required="true">
									<option value="" <?php if($book_display["category"]==""){?>selected="selected" <?php }?>>Please Select</option> <?php 
									$res=mysql_query("select * from lms_category where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option value="<?=stripslashes($row["c_id"]);?>" <?php if($book_display["category"]==$row["c_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["category_name"]);?></option>
									 <?php }?>
									</select>
								</div>
                                <div class="form-group">
									<label for="name">Publisher<font color="red">*</font></label>
									<input type="text" id="publisher" value="<?=$book_display["publisher"]?>" name="publisher" class="form-control" data-required="true">
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Book Number<font color="red">*</font></label>
									<input type="text" id="book_number" value="<?//=$book_display["book_no"]?>"  name="book_number" class="form-control" data-required="true">
								</div>-->
								<input type="hidden" name="id" value="<?=$s_id?>">
								  <div class="form-group">
									<label for="name">Shelf No<font color="red">*</font></label>
									<input type="text" id="shelf_no" name="shelf_no"  value="<?=$book_display["shelf_no"]?>" class="form-control" data-required="true">
								</div>
								
								  <div class="form-group">
									<label for="name">MRP Rs</label>
									<input type="text" id="mrp_rs" name="mrp_rs"  value="<?=$book_display["mrp_rs"]?>" class="form-control" >
								 </div>
								  
								<!--   <div class="form-group">
									<label for="name">specimen book :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" id="sp_book" name="sp_book" <?php if($book_display["specimen"]=="0"){?> checked="checked" <?php }?> value='0' class="form-control" >No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" id="sp_book" name="sp_book" <?php if($book_display["specimen"]=="1"){?> checked="checked" <?php }?>  value='1' class="form-control" >Yes
								 </div>-->
</div>
  			
  			
  			<div class="clear"></div>
  			
                    <div class="col-sm-12">
                                <center>
                                 <div class="form-group">
								 
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
								</center>
                 </div>
  			
  			
  			 </div>  <!-- /.portlet-content -->
  			 
  			 
              
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <script>
 
    //iterate through each textboxes and add keyup
    //handler to trigger sum event
 
 
 </script>
 <?php 
 include("footer.php"); 
 ?>
 <?php include("includes/script.php");?>

 <script>

 $('#dpStart').datepicker({
	 
	  
	});
 </script>
</body>
</html>

 <? ob_flush(); ?>