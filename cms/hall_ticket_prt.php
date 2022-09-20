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
							$eid=$_GET['eid'];
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$bid=$_GET['bid'];
							$acyear=$_GET['ayid'];
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							
		 //echo $drid=$selectedOption;
					
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
    <?php foreach ($_GET['ms_example'] as $selectedOption)
    { 
		$drid=$selectedOption;
			  $qry=mysql_query("SELECT * FROM student WHERE ss_id='$drid' AND c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  $row=mysql_fetch_array($qry);
			  ?>
<center>
    <div style="width:650px; margin:0 auto;">
	<div>
    <fieldset style="margin-top:10px;width:98%">
    <IMG SRC="img/hallticket.jpg" ALT="" height="70px">
    </fieldset>
    </div>
		<fieldset style="margin-top:10px;width:98%">
	<div style="float:left;width:97%">
        <div style="width:90%;font:normal 18px timesroman;text-align:left;float:left;padding-top:10px;">
                <span style="width:200px;">Admision No</span><span style="padding-left:100px;">-</span><b style="width: 328px;
        padding-right: 0px;"> <?php echo $row['admission_number']; ?> </b>
            </div>
		<div style="width:90%;font:normal 18px timesroman;text-align:left;float:left;padding-top:10px;">
			<span style="width:200px;">Name of the student</span><span style="padding-left:50px;">-</span><b style="width: 328px;
	padding-right: 0px;"> <?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></b>
		</div>
        <div style="width:90%;font:normal 18px timesroman; text-align:left;float:left;padding-top:10px;">
			<span style=""> Standard & Section</span><span style="padding-left:55px;">-</span><b style="width:320px;padding-right: 0px;"> <?php echo $class['c_name']." - ".$section['s_name'];?></b>
		</div>
        <div style="width:90%;font:normal 18px timesroman;text-align:left;float:left;padding-top:10px;">
			<span style="width:200px;">Name of the examination</span><span style="padding-left:15px;">-</span><b style="width: 328px;
	padding-right: 0px;"> <?php echo $exam['e_name']; ?> </b>
		</div>
	</div>
	<div style="float:left;width:0%">
		<div style="font:normal 18px timesroman;float:right;padding-left:40px;padding-top:10px;">
		   <img src="./img/student/<?php echo $row['photo']; ?>"  height="100px"/>
		   <img src="img/0fedzcPQ.png"  width="100px" height="70px" style="padding-top:20px;"/>
		</div>
	</div>	
		</fieldset>	
		<fieldset style="margin-top:10px;width:98%">
				<div style="width:100%;font:normal 18px timesroman;float:left;padding-top:10px;"><br>
				<span style="width:300px;font-weight:bold;">Principal</span>
				<span style="width:300px;font-weight:bold;float:right">Student signature</span>
				</div>
		</fieldset>			
</div>
<div>
</center>
<hr>
<?php } ?>
</div>
</div>
</div>
</body></html>