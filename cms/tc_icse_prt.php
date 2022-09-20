<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

$check=$_SESSION['email'];

 $sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($check))

{
	
header("Location:404.php");

}
							$id=$_GET['id'];
							$stafflist=mysql_query("SELECT * FROM tc_icse WHERE id=$id"); 
								  $row=mysql_fetch_array($stafflist);
								  extract($row);
					
?>
<?php include 'print_header.php';?>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page     var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
          
        }
    </script>
     <style>
        b.dotted{
          border-bottom: 1px dashed #000;
          text-decoration: none; 
        }
    </style>
</head>
<body>
 <div style="float:right;"><a onclick="javascript:printDiv('printablediv')" href="" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv" style="font-size:12px; line-height:20px;">
<center>
<img src="img/icse.jpg" style="width:100%;">
<div style=" float:left; margin-left:10px;font-size:14px;">Admn.No : <b><?php echo $ano;?></b></div><div style="float:right;font-size:14px; margin-left:10px;">T C.No : <b><?php echo $tcno;?></b></div>
<center><img src="img/icse_t.jpg" style="width:100%;"></center>
<br><br>

<div style="min-height:400px;line-height:45px;text-align:justify;">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <b class="dotted"><?php echo $name;?></b> son/daughter of  <b class="dotted"><?php echo $f_name;?></b> was admitted into this school on the date  <b class="dotted"><?php echo $a_from;?></b> on a Transfer Certificate from  <b class="dotted"><?php if(!$tc_from){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php }else { echo $tc_from; }?></b>    and left on  <b class="dotted"><?php echo $left1;?></b>  He/she is leaving the school (purpose)  <b class="dotted"><?php echo $leaving;?></b> He / She was then studying in the <b class="dotted"><?php echo $class;?></b> Class of the Ten year ICSE stream, the school year being from  <b class="dotted"><?php echo $year_from;?></b> to (x)  <b class="dotted"><?php echo $year_to;?></b> His / Her date of Birth, according to the Admission Register is (in figures )  <b class="dotted"><?php echo $dob_f;?></b>  (in words)  <b class="dotted"><?php echo $dob_w;?></b>  His/ Her Religion is  <b class="dotted"><?php echo $religion;?></b> and He/She belongs to  <b class="dotted"><?php echo $community;?></b>  Community.<br>Promotion has been (+) <b class="dotted"><?php echo $promotion;?></b> This Certificate is dated <b class="dotted"><?php echo $c_date;?></b>.<br><br>
<font style="float:right;">Signature of the Head of school</font><br><br><br>
<hr>
</div>
<br><br>
<font style="margin-left:50px;">Students Signature</font><font style="margin-left:280px;">Parents / Guardian Signature</font><br/><br><br><font style="float:left; margin-left:50px;">(X) Insert Months</font><br><br><font style="float:left;margin-left:50px;">(+) Granted or refused</font><br>
</div>
</div>
</div>
</body></html>