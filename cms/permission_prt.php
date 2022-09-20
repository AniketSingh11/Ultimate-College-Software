<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

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

function convert_number_to_words($number) {
   
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
		/*10000               => 'Ten Thousand',
        100000              => 'One lakh',
		1000000             => 'Ten Lakhs',*/
		1000000             => 'million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
}

?>
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
function hide_button(){
     window.print();
}
</script>
<link rel="stylesheet" href="css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <!-- end CSS-->
  <style type="text/css">
  body {
  
  font-family: Arial, sans-serif;
}
.parag{
		 margin:0 auto;
		 width:90%;
		 font-size:25px;
		 line-height:50px;
		 text-align:justify;
	 }

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 30px;
  margin-right:5px;
  border: 1px solid #C1CED9;
  
  font-family: Arial, sans-serif;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 20px 20px;
  color: #000000;
  border: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
  background: #DDDDDD;
}
	.title{
		font-size:17px;
		border-bottom: solid 1px #000000;
      display: inline;
      padding-bottom: 2px;}
	 .parag{
		 margin:0 auto;
		 width:90%;
		 font-size:25px;
		 line-height:60px;
		 text-align:justify;
	 }
	 table .service,
table .desc {
  text-align: left;
}

table td {
	font-size:18px;
  padding: 20px;
  text-align: right;
  border: 1px solid #C1CED9;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.sub {
  border: 1px solid #C1CED9;
}

table td.grand {
  border: 1px solid #5D6975;
}

/*table tr:nth-child(2n-1) td {
  background: #EEEEEE;
}*/

table tr:last-child td {
  background: #DDDDDD;
}
	 .footer1{
		 padding-top:60px;
	  	  width: 100%;
		  height: 30px;
		  position: absolute;
	 }	
</style>
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  onLoad="hide_button()">
<center>

<div id="printablediv" style="width:148mm;">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
 <center>
<img src="img/letterpad.png" style="width:100%;">
</center>
<hr>

     <?php 
	 $pid=$_GET['pid'];
$type=$_GET['type'];

if($type=='1'){
	 $qry=mysql_query("SELECT * FROM permission WHERE type='1' AND ay_id='$acyear'");
							$count=1;
			  $row=mysql_fetch_array($qry);
				$ssid=$row['ss_id'];
				$studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);
				
							$cid=$student['c_id'];
							$sid=$student['s_id'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
									$bid=$student['b_id'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
}else if($type=='2'){
	$qry=mysql_query("SELECT * FROM permission WHERE type='2' AND ay_id='$acyear'");
							$count1=1;
			  $row=mysql_fetch_array($qry);
				$stid=$row['st_id'];
				$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
}
        			?>
               
 <center><h5 class="title">STUDENT LEAVE APPLICATION</h5></center>
                    <br>
<div style="float: left;width: 125px;">Name of the Student: </div> <div style="border-bottom:1px dotted #000;width:308px;float:left"><span style="float: left;"><?php echo $student['firstname']." ".$student['lastname'];?></span></div>
<div style="float: left;width: 25px;">Std: </div><div style="border-bottom:1px dotted #000;width:100px;float:left"><span style="float: left;"><?php echo $class['c_name']."-".$section['s_name'];?></span></div>
<br><br>
<div style="float: left;width: 200px;">Number of leave days requried for: </div> <div style="border-bottom:1px dotted #000;width:50px;float:left"><span style="float: left;"><?php echo $row['leave_no_days'];?></span></div>
<div style="float: left;width: 115px;margin-left:83px;">Date of application: </div><div style="border-bottom:1px dotted #000;width:111px;float:left"><span style="float: left;"><?php echo $row['date'];?></span></div>
<br><br>
<div style="float: left;width: 137px;">Reson for taking leave: </div> <div style="border-bottom:1px dotted #000;width:422px;float:left"><span style="float: left;"><?php echo $row['reason'];?></span></div>
<br><br>
<div style="float: left;width: 92px;">Escorts Name: </div> <div style="border-bottom:1px dotted #000;width:250px;float:left"><span style="float: left;"><?php echo $row['escort_name'];?></span></div>
<div style="float: left;width: 79px;">Relationship: </div><div style="border-bottom:1px dotted #000;width:138px;float:left"><span style="float: left;"><?php echo $row['escort_rship'];?></span></div>
<br><br>
<div style="float: left;width: 65px;">Address: </div> <div style="border-bottom:1px dotted #000;width:493px;float:left"><span style="float: left;"><?php echo $row['address'];?></span></div>
<br><br>
 <div style="border-bottom:1px dotted #000;width:558px;float:left"><span style="float: left;"><?php echo $row['address'];?></span></div>
 <br><br>
 <div style="float: left;width: 106px;">Leave granted by: </div> <div style="border-bottom:1px dotted #000;width:452px;float:left"><span style="float: left;"><?php echo $row['leave_given_by'];?></span></div>
 <br><br><br><br>
 <div style="float: left;width: 235px;" ><div style="float: left;width: 100px;"> 
 <center>Signature of the Escort</center>
 </div></div>
<div style="float: left;width: 190px;" ><div style="float: left;width: 100px;"> 
 <center>Signature of the Student</center>
 </div></div>
<div style="float: left;width: 133px;" ><div style="float: right;width: 100px;"> 
 <center>Signature of the Principal</center>
 </div></div>


</div>
<!--
 <table  class="table table-striped1">	
                	<thead>
						<tr style="border:1px solid #BFBFBF;">
							<th><center>Title</center></th>
							<th ><center>Details</center></th>                        
						</tr>
					</thead>						
					<tbody style="border:1px solid #BFBFBF;">
                    <?php if($type=='1'){?>
                    	<tr>
							<td><center>Student Name</center></td>	
							<td><?php echo $student['firstname']." ".$student['lastname'];?></td>
                        </tr>
                        <tr>
							<td><center>Admin No</center></td>	
							<td><?php echo $student['admission_number'];?></td>
                        </tr>
                        <tr>
							<td><center>Class/Section</center></td>
							<td><?php echo $class['c_name']."-".$section['s_name'];?></td>
                        </tr>
                        <tr>
							<td><center>Date</center></td>	
							<td><?php echo $row['date'];?></td>
                        </tr>
                        <tr>
							<td><center>Reason</center></td>
							<td><?php echo $row['reason'];?></td>
                        </tr>
                        <tr>
							<td><center>Description</center></td>
							<td><?php echo $row['desci'];?></td>
                        </tr>
                        <?php }else if($type=='2'){ ?>
                        <tr>
							<td><center>Staff Name</center></td>	
							<td><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname'];?></td>
                        </tr>
                        <tr>
							<td><center>Staff Id</center></td>	
							<td><?php echo $staff['staff_id'];?></td>
                        </tr>
                        <tr>
							<td><center>Gender</center></td>
							<td><?php if($staff['gender']=='M'){ echo 'Male'; }else{ echo"Female"; };?></td>
                        </tr>
                        <tr>
							<td><center>Position</center></td>
							<td><?php echo $staff['position'];?></td>
                        </tr>
                        <tr>
							<td><center>Email</center></td>
							<td><?php echo $staff['email'];?></td>
                        </tr>
                        <tr>
							<td><center>Date</center></td>	
							<td><?php echo $row['date'];?></td>
                        </tr>
                        <tr>
							<td><center>Reason</center></td>
							<td><?php echo $row['reason'];?></td>
                        </tr>
                        <tr>
							<td><center>Description</center></td>
							<td><?php echo $row['desci'];?></td>
                        </tr>
                        <?php } ?>
             		</tbody>
                  </table>
             
                         <div class="footer1">
<strong><font style=" float:left; margin-left:60px;">School Seal</font><font style="margin-right:80px; float:right;">Principal</font></strong>
</div>
</div>
-->
</center>
</body></html>

  