<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");
 include("checking_page/timetable_management.php");
	
  if (isset($_POST['timing-submit']))
{
	$stime=$_POST['stime'];
	$p_total=$_POST['p_total'];
	$b1_time=$_POST['b1_time'];
	$b1_period=$_POST['b1_period'];
	$b2_time=$_POST['b2_time'];
	$b2_period=$_POST['b2_period'];
	$lunch_time=$_POST['lunch_time'];
	$lunch_peroid1=$_POST['lunch_peroid'];
	$ds_time=$_POST['ds_time'];
	$ds_period=$_POST['ds_period'];
	$duration=$_POST['duration'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	$bid=$_POST['bid'];
	$ttlist=mysql_query("SELECT * FROM timetable_timing WHERE c_id='$cid' AND b_id='$bid' AND ay_id='$acyear'"); 
								  $ttiming=mysql_fetch_array($ttlist);
								  if($ttiming){
									 // echo $lunch_peroid1;
									  
									  $tt_id=$ttiming['tt_id']; 
		$sql="UPDATE timetable_timing SET s_time='$stime',duration='$duration',p_total='$p_total',b1_time='$b1_time',b1_period='$b1_period',b2_time='$b2_time',b2_period='$b2_period',lunch_time='$lunch_time',lunch_period1='$lunch_peroid1',ds_time='$ds_time',ds_period='$ds_period' WHERE tt_id='$tt_id'";	
		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());							  
								  }else{									  
		$sql1="INSERT INTO timetable_timing (s_time,duration,p_total,b1_time,b1_period,b2_time,b2_period,lunch_time,lunch_period1,ds_time,ds_period,c_id,s_id,b_id,ay_id) VALUES
('$stime','$duration','$p_total','$b1_time','$b1_period','$b2_time','$b2_period','$lunch_time','$lunch_peroid1','$ds_time','$ds_period','$cid','$sid','$bid','$acyear')";
$result = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
								  }
    if($result){
        header("Location:timetable_assign.php?cid=$cid&sid=$sid&bid=$bid");
    }
    exit;
}
 ?>
</head>
<body>
<?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
  	<div id="main" role="main">
    	<div class="shadow-bottom shadow-titlebar"></div>
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> TimeTable </h1>                        
                        <span></span>
					</div>
					<div class="block-content">
                    <?php 
					$qrye=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
					$d_total=mysql_num_rows($qrye);
					$ttlist=mysql_query("SELECT * FROM timetable_timing WHERE c_id='$cid' AND b_id='$bid' AND ay_id='$acyear'"); 
								  $ttiming=mysql_fetch_array($ttlist);
								  if($ttiming){
									$stime=$ttiming['s_time'];
									$duration=$ttiming['duration'];
									$p_total=$ttiming['p_total'];
									$b1_time=$ttiming['b1_time'];
									$b1_period=$ttiming['b1_period'];
									$b2_time=$ttiming['b2_time'];
									$b2_period=$ttiming['b2_period'];
									$lunch_time=$ttiming['lunch_time'];
									$lunch_period=$ttiming['lunch_period1'];
									$ds_time=$ttiming['ds_time'];
									$ds_period=$ttiming['ds_period'];
									 $p_total1=$p_total;
									if($b1_period){
										$p_total1++;
									}if($b2_period){
										$p_total1++;
									}if($lunch_period){
										$p_total1++;
									}if($ds_period){
										$p_total1++;
									}
								  }else {
									$dttlist=mysql_query("SELECT * FROM timetable_timing WHERE c_id='0' AND b_id='0' AND ay_id=$acyear"); 
								  $dttiming=mysql_fetch_array($dttlist);
								    $stime=$dttiming['s_time'];
									$duration=$dttiming['duration'];
									$p_total=$dttiming['p_total'];
									$b1_time=$dttiming['b1_time'];
									$b1_period=$dttiming['b1_period'];
									$b2_time=$dttiming['b2_time'];
									$b2_period=$dttiming['b2_period'];
									$lunch_time=$dttiming['lunch_time'];
									$lunch_period=$dttiming['lunch_period1'];
									$ds_time=$dttiming['ds_time'];
									$ds_period=$dttiming['ds_period'];
									$p_total1=$p_total;
									if($b1_period){
										$p_total1++;
									}if($b2_period){
										$p_total1++;
									}if($lunch_period){
										$p_total1++;
									}if($ds_period){
										$p_total1++;
									}
								  }
								  ?>
                    <form id="validate-form" class="block-content form" action="" method="post" action="">
						<div class="_25">
							<p>
                                <label for="textfield">Start Time <span class="error">( H:I:S)</span></label>
                                <input id="textfield" name="stime" class="required" type="text" value="<?php echo $stime;?>" />
                            </p>
						</div>
                        <div class="_25"> 
							<p>
                                <label for="textfield">Number of Periods : </label>
                                <input id="textfield" name="p_total" class="required" type="text" value="<?php echo $p_total;?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Break1 Time Duration : <span class="error">(Minutes)</span></label>
                                <input id="textfield" name="b1_time" type="text" value="<?php echo $b1_time;?>" />
                            </p>
						</div>
                         <div class="_25">
							<p>
                                <label for="textfield">Break1 after period : </label>
                                <input id="textfield" name="b1_period"  type="text" value="<?php echo $b1_period;?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Break2 Time Duration : <span class="error">(Minutes)</span></label>
                                <input id="textfield" name="b2_time"  type="text" value="<?php echo $b2_time;?>" />
                            </p>
						</div>
                         <div class="_25">
							<p>
                                <label for="textfield">Break2 after period : </label>
                                <input id="textfield" name="b2_period"  type="text" value="<?php echo $b2_period;?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Lunch Time Duration : <span class="error">(Minutes)</span></label>
                                <input id="textfield" name="lunch_time"  class="required" type="text" value="<?php echo $lunch_time;?>" />
                            </p>
						</div>
                         <div class="_25">
							<p>
                                <label for="textfield">Lunch after period : </label>
                                <input id="textfield" name="lunch_peroid" class="required"  type="text" value="<?php echo $lunch_period;?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Dairy Sign Time Duration : <span class="error">(Minutes)</span></label>
                                <input id="textfield" name="ds_time"   type="text" value="<?php echo $ds_time;?>" />
                            </p>
						</div>
                         <div class="_25">
							<p>
                                <label for="textfield">Dairy Sign after period : </label>
                                <input id="textfield" name="ds_period"  type="text" value="<?php echo $ds_period;?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Each Period Duration : <span class="error">(Minutes)</span></label>
                                <input id="textfield" name="duration" type="text" value="<?php echo $duration;?>" />
                            </p>
						</div>
                    
                     <div class="clear"></div>
                    <?php 
					/*$selectedTime = "9:15:00";
$endTime = strtotime("+120 minutes", strtotime($selectedTime));
echo date('h:i:s', $endTime);*/ ?>
                    	<table id="table-example" class="table1" align="center">
							<thead>
								<tr>
                                	<th>Day</th>
                                    <?php
									$b1_period1=0;
									$b2_period1=0;
									$lunch_period1=0;
									$ds_period1=0;
									if($b1_period){
									$b1_period1=$b1_period+1;}
									if($b2_period){
									$b2_period1=$b2_period+1;}
									if($lunch_period){
									$lunch_period1=$lunch_period+1;}
									if($ds_period){
									$ds_period1=$ds_period+1;}
									$b1_period1." ".$b2_period1." ".$lunch_period1." ".$ds_period1;
									$period=1;
									 $p_total1;
									 $selectedTime = $stime;
									  for($i=1;$i<=$p_total1;$i++){ 
									 $duration1="+".$duration." minutes";									
									 $endTime = strtotime("$duration1", strtotime($selectedTime));
									  ?>
									<?php if($period==$b1_period1){?>
                                    <th></th>
                                    <?php $b1_period1=0;
									$duration2="+".$b1_time." minutes";
									$endTime = strtotime("$duration2", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									 } elseif($period==$b2_period1){?>
                                    <th></th>
                                    <?php $b2_period1=0; 
									$duration3="+".$b2_time." minutes";
									$endTime = strtotime("$duration3", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									} elseif($period==$lunch_period1){ ?>
                                    <th></th>
                                    <?php $lunch_period1=0;
									$duration4="+".$lunch_time." minutes";
									$endTime = strtotime("$duration4", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									 } elseif($period==$ds_period1){ ?>
                                    <th></th>
									<?php $ds_period1=0;
									$duration5="+".$ds_time." minutes";
									$endTime = strtotime("$duration5", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									}else{ ?>
                                    <th><center><?php echo $period;?> <br><span style="font-size:10px;">( <?php echo date('h:i A',strtotime($selectedTime));?> TO <?php echo date('h:i A', $endTime);?> )</span></center></th>
                                     <?php $period++; 
									 $selectedTime=date('h:i:s A', $endTime); } } ?>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
                                <td></td>
                                 <?php
								 $b1_period1=0;
									$b2_period1=0;
									$lunch_period1=0;
									$ds_period1=0;
									if($b1_period){
									$b1_period1=$b1_period+1;}
									if($b2_period){
									$b2_period1=$b2_period+1;}
									if($lunch_period){
									$lunch_period1=$lunch_period+1;}
									if($ds_period){
									$ds_period1=$ds_period+1;}
									$period=1;
									  for($i=1;$i<=$p_total1;$i++){ 
									  ?>
									<?php if($period==$b1_period1){?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>"><strong>Break</strong></td>
                                    <?php $b1_period1=0; } elseif($period==$b2_period1){?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>"><strong>Break</strong></td>
                                    <?php $b2_period1=0; } elseif($period==$lunch_period1){ ?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>"><strong>Lunch</strong></td>
                                    <?php $lunch_period1=0; } elseif($period==$ds_period1){ ?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>" style="z-index:1;"><strong>Dairy Sign</strong></td>
									<?php }else{ ?>
                                    <td></td>
                                     <?php $period++; } } ?>									
								</tr>
                                <?php 
							$qry=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$peroid=0;
					$did=$row['d_id'];
								   $timelist=mysql_query("SELECT * FROM timetable WHERE c_id=$cid AND s_id=$sid AND d_id=$did AND b_id=$bid AND ay_id=$acyear"); 
								   $timetable=mysql_fetch_array($timelist);	
								   if($timetable){
									   $tt_id=$timetable['tt_id'];
								   $p1=$timetable['p1'];
								   $p2=$timetable['p2'];
								   $p3=$timetable['p3'];
								   $p4=$timetable['p4'];
								   $p5=$timetable['p5'];
								   $p6=$timetable['p6'];
								   $p7=$timetable['p7'];
								   $p8=$timetable['p8'];
								   $peroid = array($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);
								   }
								   //echo $peroid[3];
								  
								  
					?>
                                <tr class="gradeC">
                               	<td class="hover"><strong><?php echo $row['d_name'];?></strong></td>
                                    <?php  for($i=0;$i<$p_total;$i++){
									  $subid=$peroid[$i];
									  $timeli=mysql_query("SELECT * FROM subject WHERE sub_id='$subid'"); 
									   $row2=mysql_fetch_array($timeli);
									   $slid=$row2['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);

									?>
									  <td class="hover" style="padding:20px 5px; position:relative; z-index:2;" >
                                      <input type="hidden" id="position<?php echo $did."".$count."".$i;?>" value="<?php echo $i+1;?>"/>
                                      <input type="hidden" id="did<?php echo $did."".$count."".$i;?>" value="<?php echo $did;?>"/>
                                   
                                     <select name="p<?php echo $did."".$count."".$i;?>" id="p<?php echo $did."".$count."".$i;?>" onchange="OnSave<?php echo $did."".$count."".$i;?>()">
									<option value="">Select Subject</option>
									<?php
									 $subid=$peroid[$i];
									//$p1=$timetable['p1'];
			if($class['c_name']!="XI" || $class['c_name']!="XII"){
			$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			} else {
			$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");	
			}							
			  while($row1=mysql_fetch_array($qry1))
        		{ 
        					print_r($row1);
        						   $slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);

				if($subid==$row1['sub_id']){?>
									<option value="<?php echo $row1['sub_id'];?>" selected><?php echo $slist['s_name'];?></option>
                                    <?php }else{ ?>
                                    <option value="<?php echo $row1['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                     <?php } 

                                 }
									 $qry2=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row2=mysql_fetch_array($qry2))
        		{ 
				if($subid==$row2['ep_code']){?>
                                    <option value="<?php echo $row2['ep_code'];?>" selected><?php echo $row2['ep_name'];?></option>
                                    <?php }else{?>
                                    <option value="<?php echo $row2['ep_code'];?>"><?php echo $row2['ep_name'];?></option>
                                    <?php } } ?>
								</select>
                                <!--<br><br>
                                <center><span id="shidden"> </span></center>-->
                                      </td>
									 <?php } ?>                                                                   
								</tr>
                                <?php } ?>                                                              						
							</tbody>
						</table>    
                         <div class="clear"></div>
                         <div align="center" style="padding:5px 0;">
                         <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            
                <input type="submit" value="Submit" name="timing-submit" class="btn btn-green" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="Reset" class="btn btn-blue" Onclick="ConfirmReset()" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="Close Window" class="btn  btn-red" onclick="window.close()" style="width:100px">   </div>                 
					</div>
                    </form>
                    <form name="form1" method="post" action="" id="validate-form1" class="block-content-invoice form">
					<input type="hidden" name="command" />
					</form>
				</div>
            </div>
            <div class="clear height-fix"></div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

 

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <!-- <script defer src="js/mylibs/jquery.uniform.min.js"></script> Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		$('#table-example1').dataTable({
		"bJQueryUI"     : true,
        "bPaginate"     : false,
        "bLengthChange" : false,
        "bFilter"           : false,
        "bSort"         : false,
        "bInfo"         : false,
        "bAutoWidth"        : false,
        "fnDrawCallback"    : function() { $("#table-example1").show();
		$('thead td').addClass('ui-state-default'); }
		});
		
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
<script type="text/javascript">
<?php 
$count=1;
$qry=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
			  while($row=mysql_fetch_array($qry))
        		{
					 $did=$row['d_id'];
 					 for($i=0;$i<$p_total;$i++){
                     $ccno = $did."".$count."".$i;
					 ?>
function OnSave<?php echo $ccno;?>(){
	var pvalue = document.getElementById('p<?php echo $ccno;?>').value;
	//var eno="<?php echo $ccno;?>";
	var skillsSelect = document.getElementById('p<?php echo $ccno;?>')
	var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
	var position = document.getElementById('position<?php echo $ccno;?>').value;
	var did = document.getElementById('did<?php echo $ccno;?>').value;
	  
    $.ajax({
		type: "POST",
		url: "onsave.php",
		dataType:"json",
		data: { p: pvalue, pposition : position, cid : <?php echo $cid;?>, sid : <?php echo $sid;?>, bid : <?php echo $bid;?>, ayid : <?php echo $acyear;?>, did1 : did,subject: selectedText},
		success: function (response) {
            if(response.status === "success") {
				//$("#shidden").val(response.message);
		//document.getElementById("shidden").innerHTML = response.message
				//alert(response.message);
				//document.getElementById("here").innerHTML = "Successfully Updated";
				// do something with response.message or whatever other data on success
            } else if(response.status === "error"){
                // do something with response.message or whatever other data on error
				alert(response.message);
				location.reload();
            } else if(response.status === "success1"){
                // do something with response.message or whatever other data on error
				alert(response.message);
				/*var answer = confirm(response.message);
				if(!answer)
				location.reload();*/
            }
        }
		})
		 /*.done(function() {
alert( "success" );
})
.fail(function() {
alert( "error" );
})
		.done(function( msg ) {
			document.getElementById("here").innerHTML = "Data Saved: " + msg ;		
	});*/
} 
<?php  } } ?>

function ConfirmReset(){
		if(confirm('Are you sure you want to Reset all periods?')){
			document.form1.command.value='reset';
			document.form1.submit();
		}
	}
</script>  
<?php 
if($_REQUEST['command']=='reset'){
		$qry12=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
			  while($row12=mysql_fetch_array($qry12))
        		{
					$did12=$row12['d_id'];
								   $timelist12=mysql_query("SELECT * FROM timetable WHERE c_id=$cid AND s_id=$sid AND d_id=$did12 AND b_id=$bid AND ay_id=$acyear"); 
								   $timetable12=mysql_fetch_array($timelist12);	
								   if($timetable12){
									   $tt_id=$timetable12['tt_id'];	
									   $sql=mysql_query("UPDATE timetable SET p1=' ',p2=' ',p3=' ',p4=' ',p5=' ',p6=' ',p7=' ',p8=' ' WHERE tt_id='$tt_id'");
								   }
				}
				
				echo "<script>location.reload();</script>";
	}
	 ?>
</body>
</html>
<? ob_flush(); ?>