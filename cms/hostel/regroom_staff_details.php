 <?php
 include("header.php");
  
  if(isset($_POST["submit"]))
  {
	  
      $hostel_id=addslashes(trim($_POST["cid"]));
      
      $room_id=addslashes(trim($_POST["sel_book"]));
      
      $cart_id=addslashes(trim($_POST["sel_cart"]));
      
      $staff_id=addslashes(trim($_POST["staff"]));
      
      $joindate=addslashes(trim($_POST["f_date"]));
      
      $date=date("Y-m-d");
      
      $fr=explode("/",$joindate);
      
      $join_date=$fr[2]."-".$fr[1]."-".$fr[0];
     // $to_date=$to[2]."-".$to[1]."-".$to[0];
      
      
      $res=mysql_query("select * from hms_room where hr_id='$room_id' ");
      $row=mysql_fetch_array($res);
      $floor=$row["floor"];
      
      $err_msg="";
      $res=mysql_query("select * from hms_room where hr_id='$room_id' and status='0'");
      $row=mysql_fetch_array($res);
      $available_qty=$row["available_qty"];
      
      $res=mysql_query("select * from staff where st_id='$staff_id'");
      $row1=mysql_fetch_array($res);
      $staff_id=$row1["staff_id"];
      $firstname=$row1["fname"];
      $lastname=$row1["lname"];
      
      
     
      
      if($available_qty==0){
          
          $err_msg.="Room Is No Availability..  &nbsp;";
      }
      
      $res1=mysql_query("select * from hms_staff_room  where 	staff_id='$staff_id'  and status='0'") or die(mysql_error());
      $chk=0;
      while($row1=mysql_fetch_array($res1))
      {
         $chk=1; 
         $err_msg.="staff  Already Booked Room..  &nbsp;";
          
      }
      
      
      if($avilable_qty!="0" && $chk!="1")
      {
        $query="insert into hms_staff_room(category,floor,hr_id,hrc_id,staff_id,firstname,lastname,r_ay_id,join_date,date)
	           values('$hostel_id','$floor','$room_id','$cart_id','$staff_id','$firstname','$lastname','$acyear','$join_date','$date')";
	    $result=mysql_query($query);
	    
        $sb_id=mysql_insert_id();
  
	    $available_qty=$available_qty-1;
	    
	    
	    $qry=mysql_query("update hms_room set available_qty='$available_qty' where hr_id='$room_id'");
	    
	    $qry=mysql_query("update hms_room_cart set room_status='1' where hrc_id='$cart_id'");
	
	    
	    header("location: regroom_staff_details.php?msg=succ");
      }else{
           
           header("location: regroom_staff_details.php?msg=err&err_msg=$err_msg");
          
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
			 <h1> Apply Staff Register Room  <a onclick="history.go(-1)"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
				<strong>Error!</strong>  <?php echo $_GET["err_msg"] ?>!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>



<?php   if(isset($_GET['cid']))
                   {
                       
                       $cid=$_GET['cid'];
                   }else{
                       
                       $board_query=mysql_query("SELECT * FROM hms_category where status='0'  order by h_id asc");
                       $bo=mysql_fetch_array($board_query);
                       
                       $cid=$bo['h_id'];
                       
                   }
            ?>
				 <div class="portlet-header">
				  <div class="_25" style="float:right">
                <label for="select">Hostel :</label>
                                	<?php
                                            $classl = "SELECT * FROM hms_category where status='0'";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="change_function1()">';
											while ($row1 = mysql_fetch_array($result1)):
												if($cid ==$row1['h_id']){
                                                echo "<option value='{$row1['h_id']}' selected >{$row1['h_name']}</option>\n";
												} else {
												echo "<option value='{$row1['h_id']}'>{$row1['h_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								 
                 </div>
				 
				 <h3>						 
						Apply Staff Register Room  
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				<?php if(!$s_id){ ?>  
				 <div class="portlet-content">                      
<div class="col-sm-12">
				            	
				            	<div class="form-group">
									<label for="name">Floor/Room Number :</label>
									<select id="sel_book"   placeholder="Please select Book" name="sel_book" data-required="true" class="form-control" style="width:50%">
                                     <option value="">Select Room</option>
                                        <?php 
										$emp_query="select * from hms_room where  category='$cid' and available_qty!='0' and status='0' order by room_number asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$floor=$emp_display["floor"];
											$res=mysql_fetch_array(mysql_query("select * from hms_floor where hf_id=$floor"));
											$floor_name=stripslashes($res["floor_name"]);
											
											$room_number=stripslashes($emp_display["room_number"]);
											$room_type=stripslashes($emp_display["room_type"]);
											$hr_id=stripslashes($emp_display["hr_id"]);
											
											$qry1=mysql_fetch_array(mysql_query("select * from hms_room_type where hrt_id='$room_type'"));
											$room_type=$qry1["room_type"];
											
											?>
                                        <option value="<?php echo $hr_id;?>"><?php echo $floor_name." / ".$room_number.' '.$room_type; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>  
				            	
				            		<div class="form-group" id="show_cart"  style="display:none;">
									<label for="name" style="width: 140px;">Select Beds/cart :</label>
									<select id="sel_cart"   placeholder="Please select Cart" name="sel_cart" data-required="true" class="form-control" style="width:50%">
                                      <option value="">Select Beds/cart</option>
                                       							
                            		</select>
								</div>  
				            	
				            	<div class="form-group">
									<label for="name" style="width: 140px;">staff ID &nbsp;&nbsp;&nbsp;&nbsp; :</label>
									<select id="staff" name="staff" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select staff </option>
                                        <?php 
										$emp_query="select * from staff  order by fname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$st_id=$emp_display["st_id"];
                                            
                                            $staff_id=$emp_display["staff_id"];
                                            $fname=$emp_display["fname"];
                                            $lname=$emp_display["lname"];
           
											?>
                                        <option value="<?php echo $st_id;?>"><?php echo $staff_id."-".$fname."-".$lname; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>       
								
						         
						         <div class="form-group">
									<label for="name">Joining Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Start date" name="f_date" data-minlength="10"   data-maxlength="10" value="<?=date("d/m/Y")?>" id="dpStart" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>     
								
								
								<!-- 
								<div class="form-group">
									<label for="name">To Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="End  date" name="t_date"  data-minlength="10"   data-maxlength="10"  id="dpEnd" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>     -->                      
                                
</div>

 <div class="col-sm-12">
                    <center>
                             <div class="form-group"><input type="hidden" name="cid" value="<?php echo  $cid;?>"/>
								
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
		
	    var cid=document.getElementById('cid').value;
		 window.location.href = 'regroom_staff_details.php?cid='+cid;
		 	  
		}

 $('#dpStart').datepicker({
	 
	   // daysOfWeekDisabled: [0,0]
	});

  
 $('#dpEnd').datepicker({
 // daysOfWeekDisabled: [0,0]
	});
 $('#sel_book').select2 ({
		allowClear: true,
		placeholder: "Select..."
		
	}).on('change', function (e) {

		 var v=$('#sel_book').val();
		 var cid=$('#cid').val();
		 if(v!="")
		 {
			 $("#s2id_sel_cart .select2-chosen").text("Select");
			 
			 var request =$.ajax({
			 	  
				    url: "ajax_room_details.php",
				   // context: document.body
			 type: "POST",
			 data: { cid : cid,rid:v},
			 dataType: "html"
				  });
			 request.done(
			   		  
					    function(dataFromTheBackEnd) {
						   // alert(dataFromTheBackEnd);
				 		 /* $('#configform')[0].reset(); form reset */
					 		 
					      // The data from the back end is passed to the callback as a parameter /
						     // $("#step1").css("display", "none");
						      //$("#step3").css("display", "block");
					      $("#sel_cart").html(dataFromTheBackEnd);
					    }
						  
					  );
			 $('#show_cart').show();
			 
		 }else{
			 $('#show_cart').hide();

		 }
		 
	    //this.value
	})  
	 $('#sel_cart').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})
	
 $('#staff').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})
	
	
	
 function select_employee() { 
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="staff_book_details.php?emp="+employee;
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