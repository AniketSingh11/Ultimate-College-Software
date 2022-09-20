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
function array_push_assoc($array, $key, $value){
    $array[$key] = $value;
    return $array;
}

function rank ($arr) {
    $ret = array();
    $s = array();
    $i = 0;
    foreach ($arr as $x => $v) {
        if (!$s[$v]) { $s[$v] = ++$i; }
        $ret[]= array($x => $v, $s[$v]);
    }
    return $ret;
}


 

							$bid=$_REQUEST['bid'];
		$cid=$_REQUEST['cid'];
							$sid=$_REQUEST['sid'];
							$eid=$_REQUEST['eid'];
							$subid=$_REQUEST['subid'];
							
							if(isset($_REQUEST['std'])){
							$std=$_REQUEST['std'];
							$s=join(",",$std);
							}
							
							
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  
					//$ssid=$_REQUEST['ssid'];
					//$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear AND ss_id=$ssid");
					//$student=mysql_fetch_array($qry);
					
?>
<?php include 'print_header.php';?>
<html
 <script src="js/jquery.min.js"></script>
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

        $().ready(function() {
        
        	printDiv('printablediv');
        });
    </script>
 
<body>


<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px;">
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<style>
#invoice .client_details,
#invoice .invoice_details { margin:0 0 0em; border-bottom: none;}
#rankcard{margin-top:10px;padding:10px 0px 20px 10px; border-radius: 30px 30px 30px 30px;
-moz-border-radius: 30px 30px 30px 30px;
-webkit-border-radius: 30px 30px 30px 30px;
border: 4px dotted #ff7700; background:url(img/bgtile.png) repeat;}

	/* -------------------------------------------------------------- 
   Invoice Page
-------------------------------------------------------------- */			
 
.clear {
    clear: both;
    display: block;
    overflow: hidden;
    visibility: hidden;
    width: 0px;
    height: 0px;
}

</style>

<div id="main-content">
			<div class="container_12">
            <?php							
				//if($cid && $sid && $ssid){
				
            $qryp="SELECT * FROM student WHERE c_id=$cid AND s_id=$sid";
            
            if($s!="")
            {
                
                $qryp="SELECT * FROM student WHERE ss_id IN ($s) ";
            }
				    
            $qryp=mysql_query($qryp);
            $c=1;
            while($rowp=mysql_fetch_array($qryp))
            {  
               
				 $c=$c+1;    
				 
                $ssid=$rowp["ss_id"];
                $cid=$rowp["c_id"];
                $sid=$rowp["s_id"];
              
              
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  
								  if(!$subid){
								$qry7=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
								$subjectlist=mysql_fetch_array($qry7);
									$subid=$subjectlist['sub_id'];
								}								
							if($subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_array($subjectlist);
								   $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1'"); 
								   $slist1=mysql_fetch_array($subjectlist1);
								   $paper=$slist1['paper'];
								  	  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
								  <center>
<img src="img/letterpad.png" style="width:100%;">
</center>
 <p style="width:40%;">
 <?php 
$address="<b>".$rowp['firstname']." ".$rowp['lastname'];
		if($rowp['gender'] == 'M')
				$address .=" S/O ";
			else	
				$address .=" D/O ";

$address .=$rowp['fathersname']."</b><br>";

$address .=$rowp['address1'];
echo "TO : <br>";
echo wordwrap($address,100,"<br>\n");?>
 </p>
 <br>
		<div class="grid_12">
				<center><h5><?php echo $rowp['firstname']." ".$rowp['lastname'];?> - Progress Card</h5></center>
                                 
			</div>
            <?php 
            
            
            if($cid && $sid && $ssid){		
				
				
				/*$a=array("Guna"=>"100");
								//array_push($a,"Joe"=>"84","Peter1"=>"84");								
								$data = array_merge($a, array("Joe"=>"84","Peter1"=>"84"));
								//$myarray = array_push_assoc($myarray, "Gune", "100");
								//print_r($data);
								//$data = array_merge($data, array("Joe2"=>"84","Peter2"=>"83"));
								
								$rank = rank($data);

								echo "<pre>";
								print_r($rank);
								echo "</pre>";*/
								
								/*$a=array("7"=>"289");
								$data = array_merge($a, array("3"=>"234","4"=>"194","5"=>"214"));
								rsort($data);
								$rank = rank($data);

								echo "<pre>";
								print_r($rank);
								echo "</pre>";
								
								//var_dump($rank);
								foreach($rank as $key=>$data) {
									$datas=$data;
									$nos=1;
									foreach($data as $key1=>$data1) {
										if($nos=='1'){										
										echo "Key: ".$key1." Data: ".$data1."<br />";
										}else{
										echo "Data: ".$data1."<br />";
										}
										$nos++;										
									}
								}*/
				?>
                    <?php
								/*$a=array();								
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_array($qry))
        		{
						$eid=$student['ss_id'];
						if($nofrow>1){
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$pass=0;
							$fail=0;
							$gtotal=0;
							$subount=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
								   
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_array($studentlist);	
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								$result=$row['result'];
																
								if($result=="FAIL"){
									$fail++;
								}else if($result=="PASS"){
									$pass++;
								}
								$subount++;		
								 if($paper=='1'){
                                 $gtotal +=$total; } else {  $gtotal +=$row['mark']; }
					 } 
					// echo $pass."-".$subount."<br>";
					 if($pass==$subount){
                			 if($gtotal){ 
								if($fail){ 
								 }else{
									 $a = array_merge($a, array("'$ssid'"=>"$gtotal"));
									 //print_r($data);								 
									 } 
							}  
					 }
							$count++;
						}
						}
								arsort($a);
								$rank = rank($a);*/

								/*echo "<pre>";
								print_r($a);
								echo "</pre>";*/
						
						?>
                        <div class="grid_12" id="rankcard" style="height: 400px;">
                        <div id="invoice" class="widget widget-plain">	
                        <div class="widget-content">
                        
				<ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $rowp['firstname']." ".$rowp['lastname'];?></strong></li>
                    <li>Class: <?php echo $class['c_name'];?></li>
					<li>Gender: <?php if($rowp['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
                <ul class="client_details">
					
					<li>Admission No: <strong><?php echo $rowp['admission_number'];?></strong></li>
					<li>Section/Group: <?php echo $section['s_name'];?></li>
                    <li>DOB: <?php echo $rowp['dob'];?></li>					
				</ul>
				 
                 <div class="clear"></div>
                
                 <center><h1 style="color:#003e73;"> PROGRESS CARD</h1> </center>
                        <table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Exam Name</center></th>
                                     <?php 
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
					?>
                 	<th><?php echo $slist['s_name']; ?></th>
                <?php } ?>
                                    <th width="10%">Total</th>
                                    <th width="10%">Result</th>
                                    <th width="8%">Rank</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$count=1;
							$examlist1=mysql_query("SELECT * FROM exam WHERE ay_id=$acyear");
							$count1=1;
			  while($examl=mysql_fetch_array($examlist1))
        		{
					$eid=$examl['e_id'];
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$a=array();	
							$resultarray1=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow1=mysql_num_rows($resultarray1);							
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student1=mysql_fetch_array($qry))
        		{
						$ssid1=$student1['ss_id'];
						if($nofrow1>1){
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$pass=0;
							$fail=0;
							$gtotal=0;
							$subount=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
								   
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid1 AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_array($studentlist);	
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								$result=$row['result'];
																
								if($result=="FAIL"){
									$fail++;
								}else if($result=="PASS"){
									$pass++;
								}
								$subount++;		
								 if($paper=='1'){
                                 $gtotal +=$total; } else {  $gtotal +=$row['mark']; }
					 } 
					// echo $pass."-".$subount."<br>";
					 if($pass==$subount){
                			 if($gtotal){ 
								if($fail){ 
								 }else{
									 $a = array_merge($a, array("'$ssid1'"=>"$gtotal"));
									 //print_r($data);								 
									 } 
							}  
					 }
							$count++;
						}
						}
								arsort($a);
								$rank = rank($a);
							
							
							/*echo "<pre>";
								print_r($rank);
								echo "</pre>";*/
							
							
							
							
							
							
							$studentrank="";
						foreach($rank as $key=>$data) {
								$datas=$data;
									$nos=1;
									foreach($data as $key1=>$data1) {
										//echo $key1;
										if(str_replace("'", "", $key1)==$ssid){
										if($nos=='1'){
											//echo "Key: ".$key1." Data: ".$data1."<br />";										
											$ssid1=$key1;
											$Total=$data1;
											$studentrank=$rank[$key][0];
										}else{
											echo "Key: ".$key1." Data: ".$data1."<br />";	
											$studentrank=$data1;										
										}
										$nos++;	
										}																			
									}
									}
						if($nofrow>1){
						?> 
								<tr class="gradeX1" >
								<td class="sno center"><center><?php echo $count1; ?></center></td>
								<td><center><?php echo $examl['e_name']; ?></center></td>
                                <?php 
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$pass=0;
							$fail=0;
							$gtotal=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
								   
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_array($studentlist);	
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								$result=$row['result'];
																
								if($result=="FAIL"){
									$fail++;
								}							
								 if($paper=='1'){ ?>
                                 <td width="10%" ><?php echo $mark."-".$mark1." = ".$total;?> </td><?PHP $gtotal +=$total; } else {  ?>
								 <td width="10%" <?php if($result) { if($result=="FAIL"){ echo ''; }}?>><center><b><?php if($row['mark']){ echo $row['mark'];} else { echo "-";}?></b></center> </td>
								 <?php  $gtotal +=$row['mark']; }?>
                                 
                <?php  } ?>			
                				<td <?php if($gtotal && $fail){ echo '';}?>><center><b><?php if($gtotal){ echo $gtotal;}else { echo "-";}?></b> </center></td>
                                <td <?php if($gtotal){ 
								if($fail){ echo ''; } } ?>> <b><center><?php if($gtotal){ 
								if($fail){ echo "FAIL"; }else{ echo "PASS"; } 
								}else { echo "-";}?></center></b></td>
                				<td><center><b><?php 
								if($studentrank){
								echo $studentrank;
								}else{ echo "-";}
								?></center></b></td>	                
                                </tr> 
                                 <?php 
							$count1++;
						}} ?>                               																
							</tbody>
						</table>
                        </div>
                        </div></div>
					 <?php }  else {?>
            <center><h3 class="succ"> Please Select Subject </h3></center> <?php } ?>
             <div class="clear height-fix"></div>
            <p style="width:90%;height:250px;" >
 <!--John Jones, President
Acme Accounting Services, Inc.
11300 Rockville Pike Ste 1100
Rockville MD 20852-->
 </p>
           
<?php } ?>

 

		</div></div> <!--! end of #main-content -->


 


</div>
</body>
</html>