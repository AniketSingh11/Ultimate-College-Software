<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
//$yourentirehtml = file_get_contents("http://localhost/christ/sms/billing.php?roll=SKS3415-&bid=1");
//echo $yourentirehtml;
/*
$ch = curl_init("http://localhost/christ/sms/billing.php?roll=SKS3415-&bid=1");
$fp = fopen("bill.txt", "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
*/
$roll=$_GET['roll'];
$bid=$_GET['bid'];
//$url = "http://schoolec.in/christ/sms/billing.php?roll=".$roll."-&bid=".$bid;
$url = "http://localhost/christ/sms/billing.php?roll=".$roll."-&bid=".$bid;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);
$dom = new DOMDocument();
@$dom->loadHTML($html);
$n=0;
$mfee="";
foreach($dom->getElementsByTagName('td') as $link) {
        # Show the <a href>
		$n++;
		if($link->nodeValue=="Total:")
        $mfee=$dom->getElementsByTagName('td')->item($n)->nodeValue;
}
//$url = "http://schoolec.in/christ/sms/billing_others.php?roll=".$roll."-&bid=".$bid;
$url = "http://localhost/christ/sms/billing_others.php?roll=".$roll."-&bid=".$bid;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);
$dom = new DOMDocument();
@$dom->loadHTML($html);
$n=0;
$bfee="";
foreach($dom->getElementsByTagName('td') as $link) {
        # Show the <a href>
		$n++;
		if($link->nodeValue=="Total:")
        $bfee=$dom->getElementsByTagName('td')->item($n)->nodeValue;
}
function convert_number_to_words($number) { 
  $number=intval($number);
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

$ace=mysql_query("select * from year where ay_id=$acyear");
$ace_year=mysql_fetch_assoc($ace)['y_name'];

 if (isset($_POST['submit']))
{	
	//echo "<pre>";
	//print_r($_POST);
	//echo "<pre>";
	//die;
	$ano=mysql_real_escape_string($_POST['ano']);
	$tno=mysql_real_escape_string($_POST['tno']);
	$eno=mysql_real_escape_string($_POST['eno']);
	$sname=mysql_real_escape_string($_POST['sname']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$sex=mysql_real_escape_string($_POST['sex']);
	$mname=mysql_real_escape_string($_POST['mname']);
	$nation=mysql_real_escape_string($_POST['nation']);
	$religion=mysql_real_escape_string($_POST['religion']);
	$dobfigure=mysql_real_escape_string($_POST['dobfigure']);
	$dobword=mysql_real_escape_string($_POST['dobword']);
	$leaving=mysql_real_escape_string($_POST['leaving']);
	$high_language=mysql_real_escape_string($_POST['high_language']);
	$high_elective=mysql_real_escape_string($_POST['high_elective']);
	$med_ins1=mysql_real_escape_string($_POST['med_ins1']);
	$doa=mysql_real_escape_string($_POST['doa']);
	$q_std=mysql_real_escape_string($_POST['q_std']);
	$due_school=mysql_real_escape_string($_POST['due_school']);
	$last_att=mysql_real_escape_string($_POST['last_att']);
	$school_left=mysql_real_escape_string($_POST['school_left']);
	$dtc1=mysql_real_escape_string($_POST['dtc1']);
	$dtc=mysql_real_escape_string($_POST['dtc']);
	$purpose=mysql_real_escape_string($_POST['purpose']);
	$no_day_att=mysql_real_escape_string($_POST['no_day_att']);
	$conduct=mysql_real_escape_string($_POST['conduct']);
	$academic_year=mysql_real_escape_string($_POST['academic_year']);
	$standard=mysql_real_escape_string($_POST['standard']);
	$first_lan=mysql_real_escape_string($_POST['first_lan']);
	$med_ins=mysql_real_escape_string($_POST['med_ins']);
	$bid=mysql_real_escape_string($_POST['bid']);
	$emisno1=mysql_real_escape_string($_POST['emisno1']);
	$tcno1=mysql_real_escape_string($_POST['tcno1']);
	$ssid=$_POST['ssid'];
	$revenueplace=mysql_real_escape_string($_POST['revenueplace']);
	$schoolplace=mysql_real_escape_string($_POST['schoolplace']);
	$AdiDravidar=mysql_real_escape_string($_POST['AdiDravidar']);
	$backclass=mysql_real_escape_string($_POST['backclass']);
	$mostbackclass=mysql_real_escape_string($_POST['mostbackclass']);
	$convertedclass=mysql_real_escape_string($_POST['convertedclass']);
	$denoty=mysql_real_escape_string($_POST['denoty']);
	$personmark=mysql_real_escape_string($_POST['personmarka']).'*||*'.mysql_real_escape_string($_POST['personmarkb']);
	$scholarship=mysql_real_escape_string($_POST['scholarship']);
	$scholarshipreason=mysql_real_escape_string($_POST['scholarshipreason']);
	$medicalissue=mysql_real_escape_string($_POST['medicalissue']);
	$doandclass=mysql_real_escape_string($_POST['doandclass']);
    $mreson=mysql_real_escape_string($_POST['medicalissue_reson']);
     $cert_no=mysql_real_escape_string($_POST['cert_no']);
      $reg_no=mysql_real_escape_string($_POST['reg_no']);
       $tmr_no=mysql_real_escape_string($_POST['tmr_no']);
       $na_en=mysql_real_escape_string($_POST['na_en']);
       $cos=mysql_real_escape_string($_POST['cos']);
	
		$offer=mysql_real_escape_string($_POST['offer']);
		$generaleducation=mysql_real_escape_string($_POST['generaleducation']);
		$vocationaleducation=mysql_real_escape_string($_POST['vocationaleducation']);
		$Languageoffer=mysql_real_escape_string($_POST['Languageoffer']);
	
	
	
	$qry1=mysql_query("select * from tc_xi where ay_id='$acyear' and a_no='$ano' and b_id='$bid' ");
	
	if(mysql_num_rows($qry1)!=0){
	    $res1=mysql_fetch_array($qry1);
	
	    $ref_number=$res1["ref_number"];
	}else{
	
	
	    $adminlist=mysql_query("SELECT * FROM certificate_count WHERE cc_id='6'");
	    $admincount=mysql_fetch_array($adminlist);
	
	    $refno=$admincount['count'];
	    $refno2=$refno+1;
	    $ref_number="Tra".str_pad($refno, 3, '0', STR_PAD_LEFT);
	
	    $sql1=mysql_query("UPDATE certificate_count SET count='$refno2' WHERE cc_id='6'");
	}
	
	//$del_tc=mysql_query("update student set user_status='0' where admission_number='$ano' and b_id='$bid' and  ay_id='$acyear'");
	
		$sql="INSERT INTO tc_xi (ano,tno,eno,sname,sex,fname,mname,nation,religion,dobfigure,dobword,leaving,high_language,high_elective,med_ins1,doa,q_std,due_school,last_att,school_left,dtc1,dtc,purpose,no_day_att,conduct,academic_year,standard,first_lan,med_ins,ay_id,b_id,ss_id,revenueplace,schoolplace,AdiDravidar,mostbackclass,convertedclass,denoty,personmark,scholarship,scholarshipreason,medicalissue,backclass,doandclass,offer,generaleducation,vocationaleducation,Languageoffer,medicalissue_reson,cert_no,reg_no,tmr_no,na_en,cos) VALUES
('$ano','$tno','$eno','$sname','$sex','$fname','$mname','$nation','$religion','$dobfigure','$dobword','$leaving','$high_language','$high_elective','$med_ins1','$doa','$q_std','$due_school','$last_att','$school_left','$dtc1','$dtc','$purpose','$no_day_att','$conduct','$academic_year','$standard','$first_lan','$med_ins','$acyear','$bid','$ssid','$revenueplace','$schoolplace','$AdiDravidar','$mostbackclass','$convertedclass','$denoty','$personmark','$scholarship','$scholarshipreason','$medicalissue','$backclass','$doandclass','$offer','$generaleducation','$vocationaleducation','$Languageoffer','$mreson','$cert_no','$reg_no','$tmr_no','$na_en','$cos')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();
    if($result){
		$sql1=mysql_query("UPDATE tc_no SET count='$tcno1' WHERE id='1'");
		$sql2=mysql_query("UPDATE tc_no SET count='$emisno1' WHERE id='2'");
        header("Location:tc_xi_edit.php?bid=$bid&tcid=$lastid&msg=succ");
    }
    exit;
}

 ?>
 
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");?>
    <!--! end of #header -->
    
    <div class="fix-shadow-bottom-height"></div>
	
	<!-- Begin of Sidebar -->
    <aside id="sidebar">
    	<!-- Search -->
    	    	<?php include("includes/search.php"); ?>
 <!--! end of #search-bar -->
		
		<!-- Begin of #login-details -->
		<?php include("includes/login-details.php");?>
         <!--! end of #login-details -->
    	
    	<!-- Begin of Navigation -->
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">    				
    	<!-- Begin of titlebar/breadcrumbs -->
        <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_tc10.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="tc_xi.php?bid=<?php echo $bid;?>" title="Home">Transfer Certificate</a></li>
                <li class="no-hover">Add new Transfer Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Transfer Certificate</h1>                
			<a href="tc_xi.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			<?php $msg=$_GET['msg'];
			if($msg=="succ"){
				unset($_SESSION['tc']);?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc.php?tcid=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Created Certificate</button></a></center>
            </div>
            <?php }
			 if($_GET['roll']){ ?>
            <a href="tc_xi_single.php?bid=<?php echo $bid;?>"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Create Another One</button></a> <?php } ?>
			</div>
            <?php if(!$_GET['roll']){ ?>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Academic Year , Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get">
                    <div class="_50">
							<p>
								<label for="select" class="requered">Academic Year : <span class="error">*</span></label>
                                	<?php
                                	$ayid=$_GET['ayid'];
											$sayid=$_SESSION['tc']['ayid'];
											if(!$sayid){ unset($_SESSION['tc']);}
                                            $classl1 = "SELECT * FROM year ORDER BY ay_id DESC LIMIT 2";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="ayid" id="ayid" class="required"> 
											<option value="">Select Academic Year</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
												if($ayid == $row11['ay_id']){
                                                echo "<option value='{$row11['ay_id']}' selected>{$row11['y_name']}</option>\n";
												}else {
													echo "<option value='{$row11['ay_id']}'>{$row11['y_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						</div>
						<div class="_50">
                            <p>
                            <label for="required">Student Roll No:</label>
                            <input type="text" name="roll" class="biginput" class="requered" id="autocomplete" /> 
                            </p>
                            </div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
            <?php } if($_GET['roll']){ 
			
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];  
					$ayid=$_GET['ayid'];

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$ayid"); 
								  $student=mysql_fetch_array($studentlist);
								  if(!$student){
									  	unset($_SESSION['tc']);
										header("location:samacheer_x_single.php?bid=$bid");
									}
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  $rid=$student['r_id'];
								  $spid=$student['sp_id'];
								  if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  //echo $class['c_name'];
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  $yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayears=mysql_fetch_array($yearlist);	
								  
								  $tcnolist=mysql_query("SELECT * FROM tc_no where id=1"); 
								  $tcno1=mysql_fetch_array($tcnolist);
								  $tcno=$tcno1['count'];	
								  $emislist=mysql_query("SELECT * FROM tc_no where id=2"); 
								  $emis=mysql_fetch_array($emislist);	
								  $emisno=$emis['count'];
								  $attlist=mysql_query("SELECT day,month,year FROM attendance WHERE c_id=$cid AND s_id=$sid AND ss_id=$ssid AND ay_id=$acyear AND (result=1 OR result='off') ORDER BY month,day DESC LIMIT 0,1");
								  $attdate=mysql_fetch_assoc($attlist); 
								  $attlist1=mysql_query("SELECT SUM(result) as result FROM attendance WHERE c_id=$cid AND s_id=$sid AND ss_id=$ssid AND ay_id=$acyear AND result='1'");
								  $attdate1=mysql_fetch_array($attlist1);
								 $total_off=mysql_num_rows(mysql_query("SELECT att_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND ss_id=$ssid AND ay_id=$acyear AND result='off'"));
								 $totalprecent=$attdate1['result']+($total_off/2);
								  }
                                  $adno=$student['admission_number'];
                                 $aclass1=mysql_query("select * from student where admission_number='$adno' and ay_id='$ayid' and ss_id='$ssid' order by ss_id DESC");
                             $row1=mysql_fetch_assoc($aclass1);
                             $cidr=$row1['c_id'];
                             $classreleave=mysql_query("SELECT * FROM class WHERE c_id=$cidr"); 
                             $namereleave=mysql_fetch_array($classreleave)['c_name'];
                             $classno=array('PLAY SCHOOL'=>'PLAY SCHOOL','PRE KG'=>'PRE KG','LKG'=>'LKG','UKG'=>'UKG','I'=>'FIRST','II'=>'SECOND','III'=>'THIRD','IV'=>'FOURTH','V'=>'FIFTH','VI'=>'SIXTH','VII'=>'SEVENTH','VIII'=>'EIGHTH','IX'=>'NINETH','X'=>'TENTH','XI'=>'ELEVENTH','XII'=>'TWELVETH');
                             $classword='';
                             foreach ($classno as $key => $value) {
                                if($key==$namereleave)
                                    $classword=$value;
                             }

			?>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc.php?tcid=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Created Certificate</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add new Transfer Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <input id="textfield" name="eno" class="required" type="hidden" readonly value="<?php echo "EMIS".str_pad($emisno, 5, '0', STR_PAD_LEFT);?>" />
                        <?php if($namereleave=="X" || $namereleave=="XII") { ?>
                        <div class="_25">
							<p>
                                <label for="textfield">Certificate Number : <span class="error">*</span></label>
                                <input id="textfield" name="cert_no" class="required" type="text" />
                            </p>
						</div>
                        <div class="_25">
                            <p>
                                <label for="textfield">Registration Number : <span class="error">*</span></label>
                                <input id="textfield" name="reg_no" class="required" type="text" value="" />
                            </p>
                        </div>
                        <div class="_25">
                            <p>
                                <label for="textfield">TMR Code Number : <span class="error">*</span></label>
                                <input id="textfield" name="tmr_no" class="required" type="text" />
                            </p>
                        </div>
                        <?php } ?>
                         <div class="_25" style="clear: both;">
                            <p>
                                <label for="textfield">ந.எண் : <span class="error">*</span></label>
                                <input id="textfield" name="na_en" class="required" type="text" value="" />
                            </p>
                        </div>
                        <div class="_25" style="clear: both;">
							<p>
                                <label for="textfield">Admission Number : <span class="error">*</span></label>
                                <input id="textfield" name="ano" class="required" type="text" readonly value="<?php echo $student['admission_number']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">TC Number : <span class="error">*</span></label>
                                <input id="textfield" name="tno"  class="required" type="text" readonly value="<?php echo "TC".str_pad($tcno, 5, '0', STR_PAD_LEFT);?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Name of the Educational District : <span class="error">*</span></label>
                                <input id="textfield" readonly name="revenueplace" class="required" type="text" value="<?php echo 'THIRUVALLUR' ?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Name of the Revenue District : <span class="error">*</span></label>
                                <input id="textfield" readonly name="schoolplace" class="required" type="text" value="<?php echo 'THIRUVALLUR' ?>" />
                            </p>
						</div>
						

                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Pupil : <span class="error">*</span></label>
                                <input id="textfield" readonly name="sname" class="required" type="text" value="<?php echo strtoupper($student['firstname'])." ".strtoupper($student['middlename'])." ".strtoupper($student['lastname']); ?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Name of the Parent/Guardian  :<span class="error">*</span></label>
                                <input id="textfield"  name="fname"  type="text" class="required" value="<?php echo $student['fathersname']; ?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Name of the Mother  :<span class="error">*</span></label>
                                <input id="textfield"  name="mname"  type="text" class="required" value="<?php echo $student['m_name']; ?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Nationality : <span class="error">*</span></label>
                                <input id="textfield" readonly name="nation" class="required" type="text" value="<?php echo $student['nation'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Religion, Caste & Community : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="<?php echo $student['reg'].", ".$student['caste']. ", ".$student['sub_caste']; ?>" />
                            </p>
						</div>
						<div class="_100" style="clear: both;">
							<p>
						<label>If the pupil belongs to any one of the five categories mentioned below, choose "Yes" against the relevant Column </label>
						</p>
						</div>

						<div class="_50" style="clear: both;">
							<p>

                                <label for="textfield">a, Adi Dravidar (Scheduled Caste or Scheduled Tribe) <span class="error">*</span></label>
                                <select id="textfield" name="AdiDravidar" class="required">
                                <option>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">b, Backward Class <span class="error">*</span></label>
                                <select id="textfield" name="backclass" class="required">
                                <option>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">c, Most Backward Class <span class="error">*</span></label>
                                <select id="textfield" name="mostbackclass" class="required">
                                <option>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">d, Converted to Christianity from Scheduled Caste <span class="error">*</span></label>
                                <select id="textfield" name="convertedclass" class="required">
                                <option>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">e, Denotified Tribes <span class="error">*</span></label>
                                <select id="textfield" name="denoty" class="required">
                                <option>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                </select>
                            </p>
						</div>


                        <div class="_50">
							<p>
                                <label for="textfield">Gender : <span class="error">*</span></label>
                                <input id="textfield" name="sex" readonly class="required"  type="text" value="<?php if($student['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?>" />
                            </p>
						</div>
                        
                        <div class="_100">
							<p>
                                <label for="textfield">Date of Birth as entered in the admission register : </label>
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">a) In figures :</label>
                                <input id="textfield" name="dobfigure" type="text" value="<?php echo $student['dob']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield"> b) In words :</label>
<?php
$ans='';
$dob=explode('/',$student['dob']);
$ans=convert_number_to_words($dob[0]).'/'.convert_number_to_words($dob[1]).'/'.convert_number_to_words($dob[2]);

?>
                                <input id="textfield" name="dobword" type="text" value="<?= $ans?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Personal Marks of Identification</label>
                                a) <input id="textfield" name="personmarka" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
                            <p>
                                <label for="textfield"><br></label>
                                b) <input id="textfield" name="personmarkb" type="text" value="" />
                            </p>
                        </div>

						<div class="_100">
							<p>
							<?php
							 
							 
							?>
                                <label for="textfield">Date of Admission and Standard in which admitted (the year to be entered in words)  <span class="error">*</span></label>
                                <input id="textfield" name="doandclass" class="required" type="text" value="<?php echo $student['doa'].' - '.$classname.', '.$doawords;?>" />
                            </p>
						 </div>

                        <div class="_100">
							<p>
							
                                <label for="textfield">Standard in which the pupil was studying at the time of leaving (In words) : <span class="error">*</span></label>
                                <input id="textfield" readonly name="leaving" class="required" type="text" value="<?php echo 'STANDARD ' .$classword?>"/>
                            </p>
						 </div>
						 
						 <div class="_50">
							<p>
                                <label for="textfield">The course offered, i.e. General Education Vocational Education : </label>
                                <input id="textfield" name="offer" class="" type="text" value="<?php echo ''?>" />
                            </p>
						 </div>
						  <div class="_50">
							<p>
                                <label for="textfield">In the case of General Education the Subjects offered under part-III Group-A and Medium or Instruction : </label>
                                <input id="textfield" name="generaleducation" class="" type="text" value="<?php echo ''?>" />
                            </p>
						 </div>
						  <div class="_50">
							<p>
                                <label for="textfield"> In the case of Vocational Education the Vocational Subject under part-III group-B and the related subject offered under part-III Group-(A) : <span class="error">*</span></label>
                                <input id="textfield" name="vocationaleducation" class="" type="text" value="<?php echo ''?>" />
                            </p>
						 </div>
						 <div class="_50">
							<p>
                                <label for="textfield">Language offered under PartI : <span class="error">*</span></label>
                                <input id="textfield" name="Languageoffer" class="" type="text" value="<?php echo ''?>" />
                            </p>
						 </div>
						
						

						<!--

                         <div class="_100">
							<p>
                                <label for="textfield">In the case of pupils of higher standards : </label>
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">a) Language studied :</label>
                                <input id="textfield" name="high_language" type="text" value="" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield"> b) Elective studied:</label>
                                <input id="textfield" name="high_elective" type="text" value="" />
                            </p>
						</div>
                        
                        <div class="_50">
							<p>
                                <label for="textfield">Date of admission or promotion to that class or standard: <span class="error">*</span></label>
                                <input name="doa" class="required" type="text" value="<?php echo $student['doa']; ?>" />
                            </p>
						</div>
						
						-->
						 
						  <div class="_50" style="clear: both;">
							<p>
                                <label for="textfield">Whether qualified for promotion to higher standard :</label>
                               <select id="textfield" readonly name="q_std" class="required">
                                <option>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                </select>
                            </p>
						 </div>
						
						 <div class="_50">
							<p>
                                <label for="textfield">Whether the pupil has paid all the fees :</label>
                             <select id="textfield" name="due_school" class="required" readonly>
                                <?php if($mfee!="" && $bfee!=""){ ?>
                                <option value="No" selected=true>No</option>
                                <option value="Yes">Yes</option>
                                <?php } else { ?>
                                <option value="Yes" selected=true>Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						 </div>
						 <div class="_50">
							<p>
                                <label for="textfield">Whether the pupil has in receipt of any Scholarship (Nature of the Scholarship to be specified) or any Educational Concessions :</label>
                                <select id="textfield" name="scholarship" class="required" onchange="sreson(this.value)" readonly>
                               <?php if($student['s_ship']=="Yes"){
                                	echo '<option value="Yes" selected=true>Yes</option>';
                                	echo '<option value="No">No</option>';
                                }
                                if($student['s_ship']=="No"){
                                	echo '<option value="No" selected=true>No</option>';
                                	echo '<option value="Yes">Yes</option>';
                                }
                                if($student['s_ship']=="" || $student['s_ship']=="0"){
                                	echo '<option value="No">No</option>';
                                	echo '<option value="Yes">Yes</option>';
                                }
                                ?>
                                </select><br><br>
                                <?php if($student['s_ship']=="Yes") {?>
                                <span id="sreson"><input id="textfield" name="scholarshipreason"  type="text" value="<?php echo $student['s_reson'];?>" /></span>
                                <?php } ?>
                                <?php if($student['s_ship']=="No") {?>
                                <span id="sreson" style="display:none;"><input id="textfield" name="scholarshipreason"  type="text" value="" /></span>
                                <?php } ?>
                                <?php if($student['s_ship']=="" || $student['s_ship']=="0") {?>
                                <span id="sreson" style="display:none;"><input id="textfield" name="scholarshipreason"  type="text" value="" /></span>
                                <?php } ?>


                            </p>
						 </div>
						  <div class="_50">
							<p>
                                <label for="textfield">Whether the pupil has undergone Medical Inspection, if any during the academic year (First or repeat to be specified) :</label>
                                <select name="medicalissue" id="missue" onchange="mreson(this.value)">
                               <?php 
                                    echo '<option value="No">No</option>';
                               
                                    echo '<option value="Yes">Yes</option>';
                                
                                ?>
                                </select><br><br>
                             <div id="mreson" style="display: none;">
                                <span><input id="textfield" name="medicalissue_reson" type="text" value="" /></span>
                               </div>
                                
                            </p>
						 </div>
						
						  <div class="_25" style="clear:both;">
							<p>
                            
                                <label for="textfield">Date of pupil’s last attendance of School: </label>
                                <input id="datepicker4" name="last_att"  type="text" value="<?php if($attdate){ echo $attdate['day']."/".$attdate['month']."/".$attdate['year']; }?>" />
                            </p>
						</div>
						
						
                         	<div class="_25">
							<p>
                                <label for="textfield">Date of application for TC by Parent/Guardian :</label>
                                <input id="datepicker3" name="dtc1" type="text" value="<?php echo date("d/m/Y");?>" />
                            </p>
						</div>
						
						
                        <div class="_25">
							<p>
                                <label for="textfield">Date of issue of TC:</label>
                                <input id="datepicker2" name="dtc" type="text" value="<?php echo date("d/m/Y");?>" />
                            </p>
						</div>
						
                        <div class="_100">
							<p>
                                <label for="textfield">Reasons for leaving</label>
                                <input id="purpose"  name="purpose" type="text" value="" />
                            </p>
						</div>
						<!--
                        <div class="_50">
							<p>
                                <label for="textfield">No. of School days the pupil attended : </label>
                                <input id="textfield" name="no_day_att" type="text" value="<?=$totalprecent?>" />
                            </p>
						</div>
						-->
						 <div class="_50">
							<p>
                                <label for="textfield">The Pupil's Conduct :</label>
                                <select id="textfield" name="conduct" class="required">
                                <option>Select</option>
                                <option value="Excellent">Excellent</option>
                                <option value="Good">Good</option>
                                <option value="Poor">Poor</option>
                                </select>
                            </p>
						</div>
						 
						<div class="_25">
							<p>
                                <label for="textfield">Academic Year : <span class="error">*</span></label>
                                <?php 
                                $ans=explode('/',$student['doa'])[2];
                                $ans=$ans.'-'.explode('-',$ace_year)[1];
                                ?>
                                <input id="textfield" name="academic_year" class="required" type="text" value="<?php echo $ans?>" />
                            </p>
						</div>
                        <div class="_25">
                            <p>
                                <label for="select">Course of Study : </label>
                                <input id="textfield" name="cos" type="text" value="" />                               
                            </p>
                        </div>
                        <div class="_25">
							<p>
								<label for="select">Standard(s) Studied : <span class="error">*</span></label>
                                <input id="textfield" name="standard" class="required" type="text" value="<?php echo $namereleave;?>" />								
							</p>
						</div>
						
                        <div class="_50">
							<p>
								<label for="select">Second Language : </label>
                                <input id="textfield" name="first_lan" type="text" value="<?= $student['second_lang']?>" />
							</p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Medium Instruction :</label>
                                <input id="textfield" name="med_ins1" type="text" value="<?php echo $board['medium'];?>" />
                            </p>
						</div>
                        
						 
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            <input type="hidden" class="medium" name="emisno1" value="<?php echo $emisno+1;?>" >
                            <input type="hidden" class="medium" name="tcno1" value="<?php echo $tcno+1;?>" >
                            <input type="hidden" class="medium" name="ssid" value="<?php echo $ssid;?>" >
                           	<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
            <?php } ?>            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
   <?php if($_GET['roll']){ ?><script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI --> <?php } ?>
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  <script defer src="js/zebra_datepicker.js"></script>
  <?php if(!$_GET['roll']){ include("auto4.php"); ?>
  <script src="js/jquery-migrate-1.2.1.js"></script>
  <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<?php }?>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		<?php if($_GET['roll']){ ?> /*
		 * Datepicker
		 */
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker3" ).Zebra_DatePicker({
	        format: 'd/m/Y'
	    });	
		$( "#datepicker4" ).Zebra_DatePicker({
	        format: 'd/m/Y'
	    });		
		<?php } ?>
	});
	function sreson(val){
	//alert(val);
	if(val=="Yes")
		$('#sreson').show();
	else
		$('#sreson').hide();
}
function mreson(val){
    //alert(val);
    if(val=="Yes")
        $('#mreson').show();
    else
        $('#mreson').hide();
}
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript">
$(document).ready(function() {
    function languageChange()
    {
         var lang = $('#ayid option:selected').val();
        return lang;
    }
    $('#ayid').change(function(e) { 
var ayid=$("#ayid").val();

window.location.href='tc_xi_single.php?bid=<?=$bid?>&ayid='+ayid;
       
    	/*   var lang = languageChange();
		//alert(lang);
		//var dataString = 'lang=' + lang +'fdisid=1';
        $.ajax({
            type: "POST",
            url: "pass_value3.php",
            //data: dataString,
			data :{"lang":lang},
            dataType: 'json',
            cache: false,
            success: function(response) {
                    alert(response.message);					
                }
        });
		
		//location.reload();
		window.location.reload();
        return false;
*/
        
    });
});
</script>
</body>
</html>
<? ob_flush(); ?>