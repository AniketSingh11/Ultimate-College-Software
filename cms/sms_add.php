<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	 $pdate=mysql_real_escape_string($_POST['pdate']);
	 $title=mysql_real_escape_string($_POST['title']);
	 $msg=mysql_real_escape_string($_POST['msg']);
	 $type=mysql_real_escape_string($_POST['type']);
	 $bid=mysql_real_escape_string($_POST['bid']);
	 $date_split= explode('/', $pdate);
	  $publish_day=$date_split[0];
			 $publish_month=$date_split[1];
			 $publish_year=$date_split[2];
			
			
			 
			if($type=='Staff'){
				$bid=0;
			}
				
				$sql="INSERT INTO mobile_sms (day,month,year,date,title,msg,type,b_id,ay_id) VALUES
('$publish_day','$publish_month','$publish_year','$pdate','$title','$msg','$type','$bid','$acyear')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				$lastid=mysql_insert_id();
				
				//$msg=str_replace(' ','%20',$msg);
				
				if($result){
					if($type=='Staff'){
						/********************** Staff Send SMS ******************************/
						$select_record1=mysql_query("SELECT fname,lname,phone_no FROM staff where s_type='Teaching' AND status='1'");
							$succ="";
							$error="";
							while($queryfetch1=mysql_fetch_assoc($select_record1))
							{ 
							$phone_no=explode(",",$queryfetch1['phone_no']);
							$phone_no=$phone_no[0];
							
							$name=$queryfetch1['fname']." ".$queryfetch1['lname'];
							
							$msg1="Dear ".$name." ".$msg;
							$msg1=str_replace(' ','%20',$msg1);
							$qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
							$ch = curl_init();
							// Set query data here with the URL
							curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
								
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_TIMEOUT, '3');
							$buffer = trim(curl_exec($ch));
                                if(empty ($buffer))
                                {
									// echo " buffer is empty "; 
									}else{ 
								
								//echo $buffer; 								 
								//$buffer; 
								$stat= explode(',', $buffer);
	  							/*$status=$stat[0];
									if($status == "Status=0"){							
									 $succ .=$queryfetch1['staff_id'].",";
									}else if($status == "Status=1"){
										$error .=$queryfetch1['staff_id'].",";
									}*/
								
								} 
                                curl_close($ch);
							}
							//$qry=mysql_query("UPDATE mobile_sms SET st_s_detail='$succ',st_e_detail='$error' WHERE id='$lastid'");
							
					}else if($type=='Student'){
						/********************** Student & Parent Send SMS ******************************/
							$succ="";
							$error="";
						$qry2="SELECT phone_number FROM parent where ay_id='$acyear' AND user_status='1'";
						if($bid && $bid>0){
							$qry2.=" AND b_id='$bid'";
						}						
						$select_record2=mysql_query($qry2);
					while($queryfetch2=mysql_fetch_assoc($select_record2))
					{ 
					 $pphone_no=$queryfetch2['phone_number'];
					 
					 $msg1="Dear Parent ".$msg;
					 $msg1=str_replace(' ','%20',$msg1);
					 
					  $qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$pphone_no&message=$msg1&senderid=MODERN&type=3";
				        $ch = curl_init();
				        // Set query data here with the URL
				        curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
				
				        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
				        $buffer = trim(curl_exec($ch));
				        if(empty ($buffer))
				        {
				            // echo " buffer is empty ";
				        }else{
				            //echo $buffer;
				            //$buffer;
				            $stat= explode(',', $buffer);
				            /*$status=$stat[0];
				            if($status == "Status=0"){
				                $succ .=$queryfetch1['o_id'].",";
				            }else if($status == "Status=1"){
				                $error .=$queryfetch1['o_id'].",";
				            }*/
				
				        }
				        curl_close($ch);
					}
					//$qry=mysql_query("UPDATE mobile_sms SET sp_s_detail='$succ',sp_e_detail='$error' WHERE id='$lastid'");					 
				}
				elseif($type=='OtherStaff'){
				    /********************** Staff Send SMS ******************************/
				    $select_record1=mysql_query("SELECT fname,lname,phone_no FROM others where status='1'");
				    $succ="";
				    $error="";
				    while($queryfetch1=mysql_fetch_assoc($select_record1))
				    {
				        $phone_no=explode(",",$queryfetch1['phone_no']);
				        $phone_no=$phone_no[0];
				        $name=$queryfetch1['fname']." ".$queryfetch1['lname'];
				        
				        $msg1="Dear ".$name." ".$msg;
				        
				        $msg1=str_replace(' ','%20',$msg1);
				        
				        $qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
				        $ch = curl_init();
				        // Set query data here with the URL
				        curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
				
				        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
				        $buffer = trim(curl_exec($ch));
				        if(empty ($buffer))
				        {
				            // echo " buffer is empty ";
				        }else{
				
				            //echo $buffer;
				            //$buffer;
				            $stat= explode(',', $buffer);
				            /*$status=$stat[0];
				            if($status == "Status=0"){
				                $succ .=$queryfetch1['o_id'].",";
				            }else if($status == "Status=1"){
				                $error .=$queryfetch1['o_id'].",";
				            }*/
				
				        }
				        curl_close($ch);
				    }
				    //$qry=mysql_query("UPDATE mobile_sms SET st_s_detail='$succ',st_e_detail='$error' WHERE id='$lastid'");
				    	
				}
				
				elseif($type=='Driver'){
				    /********************** Staff Send SMS ******************************/
				    $select_record1=mysql_query("SELECT fname,lname,phone_no FROM driver where status='1'");
				    $succ="";
				    $error="";
				    while($queryfetch1=mysql_fetch_assoc($select_record1))
				    {
				        $phone_no=explode(",",$queryfetch1['phone_no']);
				        $phone_no=$phone_no[0];
				        $name=$queryfetch1['fname']." ".$queryfetch1['lname'];
				        
				        $msg1="Dear ".$name." ".$msg;
				        $msg1=str_replace(' ','%20',$msg1);
				        
				        $qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
				        $ch = curl_init();
				        // Set query data here with the URL
				        curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
				
				        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
				        $buffer = trim(curl_exec($ch));
				        if(empty ($buffer))
				        {
				            // echo " buffer is empty ";
				        }else{
				
				            //echo $buffer;
				            //$buffer;
				            $stat= explode(',', $buffer);
				            /*$status=$stat[0];
				            if($status == "Status=0"){
				                $succ .=$queryfetch1['d_id'].",";
				            }else if($status == "Status=1"){
				                $error .=$queryfetch1['d_id'].",";
				            }*/
				
				        }
				        curl_close($ch);
				    }
				    //$qry=mysql_query("UPDATE mobile_sms SET st_s_detail='$succ',st_e_detail='$error' WHERE id='$lastid'");
				     
				}
				
				
				else{
					/********************** ALL Send SMS ******************************/
						$select_record1=mysql_query("SELECT fname,lname,phone_no FROM staff where s_type='Teaching' AND status='1'");
							$succ="";
							$error="";
							while($queryfetch1=mysql_fetch_assoc($select_record1))
							{ 
						 
							
							$phone_no=explode(",",$queryfetch1['phone_no']);
							$phone_no=$phone_no[0];
							
							$name=$queryfetch1['fname']." ".$queryfetch1['lname'];
								
							$msg1="Dear ".$name." ".$msg;
							$msg1=str_replace(' ','%20',$msg1);
						$qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
$ch = curl_init();
// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$buffer = trim(curl_exec($ch));
                                if(empty ($buffer))
                                {
									// echo " buffer is empty "; 
									}else{ 
								
								//echo $buffer; 								 
								//$buffer; 
								$stat= explode(',', $buffer);
	  							/*$status=$stat[0];
									if($status == "Status=0"){							
									 $succ .=$queryfetch1['staff_id'].",";
									}else if($status == "Status=1"){
										$error .=$queryfetch1['staff_id'].",";
									}*/
								
								} 
                                curl_close($ch);
							}
							//$qry=mysql_query("UPDATE mobile_sms SET st_s_detail='$succ',st_e_detail='$error' WHERE id='$lastid'");
					
					/********************** Student & Parent Send SMS ******************************/		
									
									$succ="";
									$error="";
								$qry2="SELECT phone_number FROM parent where ay_id='$acyear' AND user_status='1'";
								if($bid && $bid>0){
									$qry2.=" AND b_id='$bid'";
								}						
								$select_record2=mysql_query($qry2);
							while($queryfetch2=mysql_fetch_assoc($select_record2))
							{ 
							 $pphone_no=$queryfetch2['phone_number'];
							 
							 $msg1="Dear Parent ".$msg;
							 $msg1=str_replace(' ','%20',$msg1);
							 
							$qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$pphone_no&message=$msg1&senderid=MODERN&type=3";
$ch = curl_init();
// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$buffer = trim(curl_exec($ch));
                                if(empty ($buffer))
                                {
									// echo " buffer is empty "; 
									}else{ 
								
								//echo $buffer; 								 
								//$buffer; 
								$stat= explode(',', $buffer);
	  							/*$status=$stat[0];
									if($status == "Status=0"){							
									 $succ .=$queryfetch2['ss_id'].",";
									}else if($status == "Status=1"){
										$error .=$queryfetch2['ss_id'].",";
									}*/
								
								} 
                                curl_close($ch);
							}
							//$qry=mysql_query("UPDATE mobile_sms SET sp_s_detail='$succ',sp_e_detail='$error' WHERE id='$lastid'");
							
							
							$select_record1=mysql_query("SELECT fname,lname,phone_no FROM others where status='1'");
							$succ="";
							$error="";
							while($queryfetch1=mysql_fetch_assoc($select_record1))
							{
							    $phone_no=explode(",",$queryfetch1['phone_no']);
							    $phone_no=$phone_no[0];
							    $name=$queryfetch1['fname']." ".$queryfetch1['lname'];
							    
							    $msg1="Dear ".$name." ".$msg;
							    
							    $msg1=str_replace(' ','%20',$msg1);
							    
							    $qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
							    $ch = curl_init();
							    // Set query data here with the URL
							    curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
							
							    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
							    $buffer = trim(curl_exec($ch));
							    if(empty ($buffer))
							    {
							        // echo " buffer is empty ";
							    }else{
							
							        //echo $buffer;
							        //$buffer;
							        $stat= explode(',', $buffer);
							        /*$status=$stat[0];
							        if($status == "Status=0"){
							            $succ .=$queryfetch1['o_id'].",";
							        }else if($status == "Status=1"){
							            $error .=$queryfetch1['o_id'].",";
							        }*/
							
							    }
							    curl_close($ch);
							}
							//$qry=mysql_query("UPDATE mobile_sms SET st_s_detail='$succ',st_e_detail='$error' WHERE id='$lastid'");
							
							
							
							
							$select_record1=mysql_query("SELECT phone_no,fname,lname FROM driver where status='1'");
							$succ="";
							$error="";
							while($queryfetch1=mysql_fetch_assoc($select_record1))
							{
							    $phone_no=explode(",",$queryfetch1['phone_no']);
							    $phone_no=$phone_no[0];
							    
							    $name=$queryfetch1['fname']." ".$queryfetch1['lname'];
							    
							    $msg1="Dear ".$name." ".$msg;
							    $msg1=str_replace(' ','%20',$msg1);
							    
							    $qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
							    $ch = curl_init();
							    // Set query data here with the URL
							    curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
							
							    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
							    $buffer = trim(curl_exec($ch));
							    if(empty ($buffer))
							    {
							        // echo " buffer is empty ";
							    }else{							
							        //echo $buffer;
							        //$buffer;
							        $stat= explode(',', $buffer);
							        /*$status=$stat[0];
							        if($status == "Status=0"){
							            $succ .=$queryfetch1['d_id'].",";
							        }else if($status == "Status=1"){
							            $error .=$queryfetch1['d_id'].",";
							        }*/							
							    }
							    curl_close($ch);
							}
							//$qry=mysql_query("UPDATE mobile_sms SET st_s_detail='$succ',st_e_detail='$error' WHERE id='$lastid'");
				}
				//header("Location:sms_add.php?msg=succ");
				 $msg2="succ";
			} 	
}
if (isset($_POST['submit1']))
{
	 $pdate=$_POST['pdate'];
	 $title=$_POST['title'];
	 $msg=mysql_real_escape_string($_POST['msg']);
	 $bid=$_POST['bid'];
	 $cid=$_POST['cid'];
	 $sid=$_POST['sid'];
	 
	 $date_split= explode('/', $pdate);
	 
	  $publish_day=$date_split[1];
			 $publish_month=$date_split[0];
			 $publish_year=$date_split[2];
			 
			$sql="INSERT INTO mobile_sms (day,month,year,date,title,msg,type,b_id,c_id,s_id,ay_id) VALUES
('$publish_day','$publish_month','$publish_year','$pdate','$title','$msg','Student','$bid','$cid','$sid','$acyear')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				$lastid=mysql_insert_id();
				
				$msg=str_replace(' ','%20',$msg);
				if($result){
					$succ="";
									$error="";
								$qry2="SELECT phone_number FROM parent where ay_id='$acyear' AND b_id='$bid' AND c_id='$cid' AND user_status='1'";
								if($sid && $sid>0){
									$qry2.=" AND s_id='$sid'";
								}						
								$select_record2=mysql_query($qry2);
							while($queryfetch2=mysql_fetch_assoc($select_record2))
							{ 
							$pphone_no=$queryfetch2['phone_number'];
							
							$msg1="Dear Parent ".$msg;
							$msg1=str_replace(' ','%20',$msg1);
							
							$qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$pphone_no&message=$msg1&senderid=MODERN&type=3";
$ch = curl_init();
// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$buffer = trim(curl_exec($ch));
                                if(empty ($buffer))
                                {
									// echo " buffer is empty "; 
										}
										else{
											// echo $buffer; 
										$stat= explode(',', $buffer);
										/*$status=$stat[0];
											if($status == "Status=0"){							
											 $succ .=$queryfetch2['ss_id'].",";
											}else if($status == "Status=1"){
												$error .=$queryfetch2['ss_id'].",";
											}*/
										} 
										curl_close($ch);
							}
							//$qry=mysql_query("UPDATE mobile_sms SET sp_s_detail='$succ',sp_e_detail='$error' WHERE id='$lastid'");							
					 //header("Location:sms_add.php?msg=succ");
					 $msg2="succ";
				}			
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
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="sms_mng.php" title="Home">Mobile SMS Management</a></li>
                <li class="no-hover">Send New SMS</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Send New SMS</h1>                
			<a href="sms_mng.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg2=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully sent!!!</div>
            <?php }  ?>
            
				<div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Send New SMS</h1>
                        <ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">SMS To All </a></li>
							<li><a href="#tab-2">SMS To Specific Standard</a></li>
						</ul>
                        <span></span>
					</div>
					
                    <div class="block-content tab-container" >
						<div id="tab-1" class="tab-content">
							<br>
					<form id="validate-form" class="block-content form" action="" method="post" >
						<div class="_25">
							<p>
                                <label for="textfield">Date : <span class="error">*</span></label>
                                <input id="pdate" name="pdate" class="required"  type="text" value="<?php echo date("d/m/Y");?>" readonly/>
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea">Msg Details: <span class="error">*</span></label><textarea id="textarea" name="msg" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
								<select name="bid" class="required">
									<option value="">Select one</option>
									<option value="0">All</option>
                                    <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{ ?>
									<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>									
                            <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Circular Type : <span class="error">*</span></label>
								<select name="type" class="required">
									<option value="">Select one</option>
									<option value="All">All</option>
									<option value="Staff">Staff</option>									
                                    <option value="Student">Student & Parent</option>
                                    <option value="OtherStaff">Other staff</option>
                                    <option value="Driver">Driver</option>
								</select>
							</p>
						</div>
                     	<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
                    </div>
                    <div id="tab-2" class="tab-content">
                        <br>
                        <form id="validate-form1" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Date : <span class="error">*</span></label>
                                <input id="pdate" name="pdate" class="required"  type="text" value="<?php echo date("d/m/Y");?>" readonly/>
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea">Msg Details: <span class="error">*</span></label><textarea id="textarea" name="msg" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
								<select name="bid" class="required" onchange="showCategory1(this.value)">
									<option value="">Select Board</option>
                                    <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{ ?>
									<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>									
                            <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<select name="cid" id="cid" class="required" onchange="showCategory(this.value)">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : ( optional )</label>
                               <select name="sid" id="sid">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form1" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="submit1" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
                     </div>   
                    </div>
                    
				</div>
			</div>
            
            
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
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
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		var validateform1 = $("#validate-form1").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$("#reset-validate-form1").click(function() {
			validateform1.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$("#tab-panel-1").createTabs();
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
   <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory1(str) {
        if (str == "") {
            document.getElementById("cid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("cid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "standardlist.php?mmtid=" + str, true);
        xmlhttp.send();
    } function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist1.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script> 
</body>
</html>
<? ob_flush(); ?>