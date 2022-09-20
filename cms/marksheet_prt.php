<?php 
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

 

$acyear=$_SESSION['acyear'];

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

					if($_GET['roll']){
					
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1]; 
					$eid=$_GET['eid']; 
					$bid=$_GET['bid']; 

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
								  $student=mysql_fetch_array($studentlist);
								  if(!$student || !$eid){
									  header("Location:result_analysis_student.php?bid=$bid");
								  }
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
							
			}else{
				echo "<script>window.close();</script>";
			}
			$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  								
					
?>
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
     window.print();
     document.body.onmousemove = doneyet;
}
</script>
<link rel="stylesheet" href="css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="css/960.fluid.css"> <!-- 960.gs Grid System -->
  <link rel="stylesheet" href="css/lists.css"> <!-- Lists, optional -->
  <link rel="stylesheet" href="css/forms.css"> <!-- Forms, optional -->
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <!-- end CSS-->
  
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
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
                      <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                            <div style="text-align:left; width:50.00mm; float:left;">
                                <div><img src="img/logo1.png" width="160px" height="160px"></div>
                            </div>
                            <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                                <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:46px; ; font-weight:bold;">SCHOOL/COLLEGE MANAGEMENT SYSTEM</h5>

                                <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Hetauda, Nepal</h5>
                               <!-- <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>-->
                            </div>
                        </div>
                        <center>
                       <!-- <table width="900" height="24" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="margin-left:5%; line-height:40px;">
    <tbody><tr id="butt" style="visibility: visible; line-height:40px; min-height:150px;">
      <td><img src="img/images1.png" style="width:130px; height:110px;" /></td>     
      <td>
      <h2 style="text-align:center; padding:0px; margin:0px; color:red; font-size:2em;">SP MODERN SCHOOL</h2>
      <h5 style="text-align:center; padding:0px; margin:0px; line-height:21px; color:#017CBE; font-size:1em;">(Government Recognized &An ISO 9001:2008 Certified institution)</h5>
      <h4 style="text-align:center; padding:0px; margin:0px; font-size:14px; color:#5D5E60; font-size:16px;">SEVALPATTI, VIRUTHUNAGAR (DT)-626140</h4>
      </td>
      <td><img src="img/images2.png" style="height:70px;" /></td>
    </tr>
  </tbody>
     <table align="left" width="96%" style=" border-bottom:2px solid lightblue; margin-top:-18px; font-size:20px; margin-left:12%;">
  <tr>
  <td>
        <span style="margin-left:25%; height:22px;"><img src="img/phone.jpg" />:04562-239111</span><br>
      <span style="margin-left:10%; height:19px;"><img src="img/mail.jpg" />:www.spmodernschool.edu.in:contact@spmodernschool.edu.in</span><br>
      <span style="margin-left:10%; height:21px;"><img src="img/fb.jpg" />:www.facebook.com/page/spmodernschoolsevalpatti</span>

  </td>
  </tr>
  </table>
</table>-->
                        <h2>MarkSheet</h2></center>
                       <div style=" float:left; margin-left:10px;font-size:14px;">Marksheet No : <b>01254</b></div><div style="float:right;font-size:14px; margin-left:10px;">Serial No : <b>15478</b></div><br><hr>
                <table style="width:100%">
                <tr><td style="width:50%">
                       <table style="width:100%;font-size:12.5px;line-height:22px;">
<tbody>
<tr>
<td width="40%">&nbsp;&nbsp;Admission No</td>
<td width="50%">: <b><?php echo $student['admission_number']; ?></b></td>
</tr>
<tr>
<td width="40%">&nbsp;&nbsp;Student Name</td>
<td width="50%">: <b><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></b></td>
</tr>
<tr>
<td width="40%">&nbsp;&nbsp;Gender </td>
<td width="50%">:<b> <?php if($student['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></b><br></td>
</tr>
</tbody>
</table>
</td>
<td style="width:50%">

<table style="width:100%;font-size:12.5px;line-height:22px;">
<tbody>
<tr>
<td width="40%">&nbsp;&nbsp;Academic Year</td>
<td width="50%">: <b><?php echo $acyear_name;?></b></td>
</tr>
<tr>
<td width="40%">&nbsp;&nbsp;Class and Section</td>
<td width="50%">: <b><?php echo $class['c_name']."-".$section['s_name'];?></b></td>
</tr>
<tr>
<td width="40%">&nbsp;&nbsp;Exam Name </td>
<td width="50%">:<b> <?php echo $exam['e_name']; ?> </b><br></td>
</tr>
</tbody>
</table>

</td>
</tr>
</table>
<br>
<table class="table table-striped" id="table-example" style="border:1px solid #CBC9C9;">	
              <thead>
                <tr style="border-top:1px solid #C0BDBD">
                  <th>Title</th>
                  <th>Mark</th>
                  <th>Mark in Work</th>
                  <th>Result</th>
                </tr>
              </thead>
              <tbody>                
                <?php 
						$qury=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear AND b_id=$bid"); 
						$count=0;
						$total =0;
						$fail =0;
					while($subject2=mysql_fetch_array($qury))
					{ 
					$subid=$subject2['sub_id'];
					$slid=$subject2['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
					 $paper=$slist['paper'];
					$select_record6=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear AND ss_id=$ssid");
					$result2=mysql_fetch_array($select_record6);
					$ml =$result2['mark'];
					if($ml){
					?>
                    <tr style="border-top:1px dotted #B4B3B3">
                  <td><?php echo $slist['s_name'];?></td>
                  <td> <strong> <?php
								$mark=$result2['mark'];
								$mark1=$result2['mark1'];
								$tot=$mark+$mark1;
								 if($paper=='1'){ echo $mark." - ".$mark1." = ".$tot; } else { $tot=$ml; echo $result2['mark']; }?></strong></td>
                   <td> <strong> <?php echo convert_number_to_words($tot);?></strong></td>
                   <td> <strong> <?php echo $result2['result'];?></strong></td>
                   <?php $total+=$tot; 
				   		if($result2['result']=='FAIL')
						$fail++;				   
				    }?>
                </tr>
                <?php $count++; }
				$sno=11-$count;
				for($i=0;$i<=$sno;$i++){
				?>
                <tr>
                	<td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
                <tfoot>
                 <tr style="border-top:1px solid #C0BDBD">
                <?php if($total!=0){ ?>               
                <td>Total</td>
                <td><strong><?php echo $total;?></strong></td>
                <td></td>
                <td><b><?php if($fail>0){ echo "FAIL";}else{ echo "PASS";}?></b></td>
                <?php }else{ echo "<td colspan='5'><br><center><p>There is no result found!!!</p></center><br></td>";}?>
                </tr>
                </tfoot> 
              </tbody>
            </table>
					
				<br><br><br><br><br><br><br><br>
<font>Students Signature</font><font style="margin-left:280px;">Signature of the Principal</font><br/>
                  
			</div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>

</body></html>