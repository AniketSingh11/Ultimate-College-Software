<?php 
include("header.php");
include_once("amount_in_word.php");
			 $s_id=$_GET["sid"];
 $bin_id=$_GET["bin_id"];
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
                        <center><img src="../img/hallticket.jpg" style="width:80%;"><h4>Library Fees Invoice</h4></center>
                       <div class="modal-body">
                       
                       
                       <?php   $query=mysql_query("SELECT * FROM lms_binvoice where bin_id='$bin_id'");
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
		$section_name=$res["s_name"];?>
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
                                            <td width="48%" style="border:none;"><?php echo  $class_name." - ".$section_name;?></td>
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
									  $emp_query11="select * from lms_binvoice_sumarry where  ay_id='$acyear' and student_id='$s_id' and bin_id='$bin_id'";
$emp_result11=mysql_query($emp_query11);
$counts=0;
while($emp_display=mysql_fetch_array($emp_result11))
{
    $counts=$counts+1;
    
    $res=mysql_query("select * from lms_student_borrowbook where sb_id='$emp_display[sb_id]'");
    $row=mysql_fetch_array($res);
    $book_no=stripslashes($row["book_number"]);
    
    $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
    $row=mysql_fetch_array($res);
    $book_title=stripslashes($row["book_title"]);
     
    
    $sb_id=stripslashes($emp_display["sb_id"]);

    
    $fine_amount=stripslashes($emp_display["amount"]);
										?>
                                    	<tr>
                                        	<td width="50%" style="border:none;"><?php echo $book_no." ".$book_title;?></td>
                                            <td style="border:none;">:</td>
                                            <td width="48%" style="border:none;">Rs.<?php echo  number_format($fine_amount,2);?></td>
                                        </tr> 
                                        <?php } ?>                                       
                                    </table>
                                </td>
                                
					          </tr>
                               <tr>
                                 <?php 
                                $emp_display=mysql_fetch_array(mysql_query("select sum(amount) as fine from lms_binvoice_sumarry where  ay_id='$acyear' and student_id='$s_id' and bin_id='$bin_id'"));
                                 $total=$emp_display[fine];
                                 ?>
                                <td width="50%">
                                	<table>
                                    	<tr>
                                        	<td width="50%" style="border:none;">Total Amount</td>
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
<font>Library Staff Signature</font><font style="margin-left:400px;">School Seal</font><br/>
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>


</body>
 </html>