<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);

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

if(!isset($email))
{
	
header("Location:404.php");
}
 
$ex_id=$_GET['exid'];	
?>
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
     window.print();
     document.body.onmousemove = doneyet;
}
/*function download_doc(ano){
	
	var url = 'http://localhost/Erp_School/'+'admin/download_cert?id='+ano+'&type=bonafide';
	window.open(url,'_blank');
}
function doneyet()
{
  document.getElementById('butt').style.visibility='visible';
}*/
</script> 
     <?php 
					$count=1;
					$qry5=mysql_query("SELECT * FROM circular WHERE cl_id=$_GET[clid]");
			  $row5=mysql_fetch_array($qry5);
			  
			  $title=$row5['title'];
			  $desc=$row5['descript'];
			  
			  $type=$row5['type'];
			  $c_id=$row5['c_id'];
			  $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$c_id");
			  $section=mysql_fetch_array($sectionlist);
			  $class_name=$section["c_name"];
			  
			  $s_id=$row5['s_id'];
        			?>
 		<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<div   id="printablediv" style="font-size:12.5px; line-height:15px;">


<center>
<img src="img/letterpad.png" style="width:100%;">
</center>
<hr>
 <br><br><br><br>
 <b style="float:right;">Date : <?=$row5["cl_day"]."/".$row5["cl_month"]."/".$row5["cl_year"];?></b>
<b> Ref No : <?=$row5["ref_number"];?></b>
 <center><h3 class="title"><?php echo $title; ?></h3></center>
 <br>

    <h2></h2>
    <?php echo $desc; 
   
   if($type=="Staff")
   {
       
   ?>
   <table style="width:75%; border:1px solid #000; border-collapse:collapse; margin:0px auto;">
  <thead>
    <tr style="border:1px solid #000; border-collapse: collapse; height:35px;">
     <th style="border:1px solid #000; border-collapse: collapse; width:10%;</h5>">Sno</th>
      <th style="border:1px solid #000; border-collapse: collapse;">Staff Name</th>
      <th style="border:1px solid #000; border-collapse: collapse;">Signature</th>
    </tr>
  </thead>
   
  <tbody>
  <?php  $qry1=mysql_query("select * from staff where s_type='Teaching' order by fname asc");
    
   $count=1;
    while($row1=mysql_fetch_array($qry1))
    { 
    $f_name=stripslashes($row1["fname"]);
    $l_name=stripslashes($row1["lname"]);
   ?>
    <tr style=" height:30px;">  <td style="border:1px solid #000; border-collapse:collapse;"><?=$count?></td>
      <td style="border:1px solid #000; border-collapse:collapse;"><?=$f_name?>&nbsp;<?=$l_name?></td>
      <td style="border:1px solid #000; border-collapse:collapse;"><pre></pre></td>
    </tr>
    <?php
    $count=$count+1;
    }?>
  </tbody>
</table>
   <?php }?>
   <br>
   <?php if($type=="Student" && $c_id!=0 ) 
   {?>
   <table style="width:75%; border:1px solid #000; border-collapse:collapse; margin:0px auto;">
  <thead>
    <tr style="border:1px solid #000; border-collapse: collapse; height:35px;">
      <th style="border:1px solid #000; border-collapse: collapse; width:10%;">Sno</th>
       <th style="border:1px solid #000; border-collapse: collapse; width:15%;">Section </th>
      <th style="border:1px solid #000; border-collapse: collapse;">Staff Name</th>
      <th style="border:1px solid #000; border-collapse: collapse;">Signature</th>
    </tr>
  </thead>
   
  <tbody>
  <?php

    if($s_id=="All" || $s_id=="0")
    {
        $qry1=mysql_query("select * from section where c_id='$c_id' order by s_name asc ");
    }else{
        
        $qry1=mysql_query("select * from section where c_id='$c_id' and s_id='$s_id' order by s_name asc ");
    }
    
   $count=1;
    while($row1=mysql_fetch_array($qry1))
    { 
    $s_name=$row1["s_name"];
   ?>
    <tr style="border:1px solid #000; border-collapse: collapse; height:30px;"> <td><?=$count?></td>
     <td style="border:1px solid #000; border-collapse: collapse;"><?=$class_name?> - <?=$s_name?></td>
      <td style="border:1px solid #000; border-collapse: collapse;"><pre></pre></td>
      <td style="border:1px solid #000; border-collapse: collapse;"><pre></pre></td>
    </tr>
     <?php $count=$count+1; }
  ?>
  </tbody>
</table>
<?php }?>
            </div>            
		 
</body></html>