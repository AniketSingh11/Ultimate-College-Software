<?php 
include("header.php");
include_once("amount_in_word.php");
			$s_id=$_GET["sid"];
 $hin_id=$_GET["id"];
			 			  $months = array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"); 								  
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
     window.print();
     document.body.onmousemove = doneyet;
}
</script>
  </head>
 <body style="background:#FFFFFF;">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="../img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css" media="all">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:950px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px;
		/*border: 2px solid #a9a6a6;*/
		  }
</style>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        <center><img src="../img/hallticket.jpg" style="width:80%;"><h4>Hostel Fees Invoice</h4></center>
                       <div class="modal-body">
                       
                       
                       <?php  $query=mysql_query("SELECT * FROM hms_hinvoice where hin_id='$hin_id'");
		   $res=mysql_fetch_array($query);
		   $in_no=$res["in_no"];
		   $pay_type=$res["pay_type"];
		   $total=$res["h_total"];
		   
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
		$cart_name=$row["cart_name"];?>
        <table class="table">
					        <tbody>
                            <tr>
                                <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Student Name</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b><?php echo $firstname." ".$lastname;?></b></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">Section/Group.</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $class_name." - ".$section_name;?></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">Admission Number</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $admission_number;?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Invoice Number</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b><?php echo $in_no;?></b></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">Invoice Date</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php echo $in_date;?></td>
                                        </tr>
                                        <tr>
                                        	<td width="50%" style="border:none;">Hostel Name</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php  echo $cat_name;?></td>
                                        </tr>
                                         <tr>
                                        	<td width="50%" style="border:none;">Hostel Room/Cart</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><?php  echo $room_number." - ".$cart_name;?></td>
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	 
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                         
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td width="50%" style="border:1px solid #CCCCCC">
                                	<table>
                                    <?php
									   $emp_query11="select * from hms_hinvoice_sumarry where  ay_id='$acyear' and  hin_id='$hin_id'";
$emp_result11=mysql_query($emp_query11);
$counts=0;
while($emp_display=mysql_fetch_array($emp_result11))
{
    $counts=$counts+1;
    
    
    $fees_name=stripslashes($emp_display["fees_name"]);
    $amount=stripslashes($emp_display["amount"]);
										?>
                                    	<tr>
                                        	<td width="50%" style="border:none;"><?php echo $fees_name;?></td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;">Rs.<?php echo  number_format($amount,2);?></td>
                                        </tr> 
                                        <?php } ?>                                       
                                    </table>
                                </td>
                                
					          </tr>
                               <tr>
                                 
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Total Amount.</td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;"><b>Rs. <?php echo number_format($total,2);?></b></td>
                                        </tr>
                                    </table>
                                </td>
					          </tr>
                              <tr>
                                <td colspan="2">
                                	<table width="100%">
                                    	<tr>
                                        	<td colspan="3" style="border:none;"> 
                         </td>
                                        </tr>
                                    </table>
                                </td>                                
					          </tr>
                            </tbody>
					      </table>
                          <br><br><br><br><br><br><br><br>
<font>Hostel Staff Signature</font><font style="margin-left:400px;">School Seal</font><br/>
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>


</body>
 </html>