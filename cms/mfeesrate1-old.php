<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$fgid=$_POST['fgid'];
	$cid=$_POST['cid'];
	$bid=$_POST['bid'];
	$rate=$_POST['rate'];
	$sid=$_POST['sid'];
	
	
	$qrytest=mysql_query("SELECT * FROM mfrate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND rate='$rate' AND fg_id='$fgid' AND s_id='$sid'");
			  $already=mysql_fetch_array($qrytest);
	
	if($already){
		header("Location:mfeesrate.php?cid=$cid&rate=$rate&bid=$bid&msg=err");
	}else{
					$sql=mysql_query("INSERT INTO mfrate (fg_id,rate,c_id,s_id,b_id,ay_id) VALUES
('$fgid','$rate','$cid','$sid','$bid','$acyear')") or die("Could not insert data into DB: " . mysql_error());
						$lastid=mysql_insert_id();
						
				$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
						$fdisid=$student12['fdis_id'];
                        $fdis="fdisname".$count;
						$fdisvalue=$_POST[$fdis];
						$sql1=mysql_query("INSERT INTO mfrate_value (fr_id,fdis_id,dis_value,ay_id) VALUES
('$lastid','$fdisid','$fdisvalue','$acyear')") or die("Could not insert data into DB: " . mysql_error());
						
               $count++; 
			   }
		
//$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($sql1 && $sql){
        header("Location:mfeesrate.php?cid=$cid&rate=$rate&bid=$bid&sid=$sid&msg=succ");
    }
    exit;
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
    	<?php $bid=$_GET['bid'];
		$cid=$_GET['cid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  if($cid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  }
								  $rate=$_GET['rate'];
							if(!$rate){
								$rate="Old";
							}
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="mboard_select_feesrate.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Fees Rate <?php echo $class['c_name']; if($sid){ echo " - ( ".$section['s_name']." ) ";}?>  (<?php echo $rate;?> Student Rate)</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			    <a href="mboard_select_feesrate.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                <div class="_25" style="float:right">
                <label for="select">Standard</label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="change_function()"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($cid==$row1['c_id']){
                                                echo "<option value='{$row1['c_id']}' selected>{$row1['c_name']}</option>\n";
												} else {
												echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
            <?php
							
							
							//$sid=$_GET['sid'];
							
				if($cid){
								  $sid=$_GET['sid'];
								  if(!$sid && (($class['c_name']=="XI STD") || ($class['c_name']=="XII STD"))){
								  $qry1=mysql_query("SELECT * FROM section WHERE c_id=$cid AND ay_id=$acyear");
								  $row1=mysql_fetch_array($qry1);
								  $sid=$row1['s_id'];
								  //header("Location:feesrate.php?cid=$cid&bid=$bid&sid=$sid1");
								  }
								  ?>
                  <?php
				if($sid){
					$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	 
								  
							$qry=mysql_query("SELECT * FROM section WHERE c_id=$cid AND ay_id=$acyear order by s_id desc");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{  ?>
                 <a href="<?php if($row['s_id']==$sid){ echo "#"; } else { ?>mfeesrate.php?cid=<?php echo $cid;?>&sid=<?php echo $row['s_id'];?>&bid=<?php echo $bid; }?>" style="margin:10px 0 0 10px; float:right"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  <?php echo $row['s_name']; ?></button></a>					
				 <?php }  } else { $sid="0";}?>
                 
                 <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }elseif($msg=="succ"){ ?>  
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Created !!!</div>
                <?php }elseif($msg=="err"){ ?> 
                <div class="alert error"><span class="hide">x</span>This Fees Group Already Created !!!</div>
                <?php } ?> 
                 <div class="grid_12">
                 <div class="block-border">
					<form id="validate-form" class="block-content form" action="" method="post">
						 <div class="_100">
                         <p>
                         <label for="textfield">Add New Fees rate: </label>
                        <table class="table">
                  	<thead>
                    	<th><center>Group Name</center></th>
                        <?php 							
							$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ ?>
                                    <th><?php echo $row1['fdis_name'];?></th>
                            <?php } ?>
                       </thead>
                    </thead>
                    <tbody>
                    	<tr>
                        <td><select name="fgid" class="required"  >
                                	<option value="">Select Fees Group</option>
                                	<?php $qry1=mysql_query("SELECT * FROM mfgroup");													
									  while($row1=mysql_fetch_array($qry1))
										{?>
                                    <option value="<?php echo $row1['fg_id'];?>"><?php echo $row1['fg_name'];?></option>
                                    <?php } ?>
                                </select></td>
                        <?php 
					$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
					?>
                        <td><center><input id="fdisname<?php echo $count;?>" name="fdisname<?php echo $count;?>" class="required" type="text" value="" /></center></td>
                       <?php $count++; } ?>
                        </tr>
                        <input type="hidden" name="cid" value="<?php echo $cid;?>" />
                        <input type="hidden" name="rate" value="<?php echo $rate;?>" />
                        <input type="hidden" name="bid" value="<?php echo $bid;?>" /> 
                        <input type="hidden" name="sid" value="<?php echo $sid;?>" />                       
                    </tbody>
                  </table></p>
                  </div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form2" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
                 </div>        
			<div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Fees Rate <?php echo $class['c_name']; if($sid){ echo " - ( ".$section['s_name']." ) ";}?>  (<?php echo $rate;?> Student Rate) <a href="mfeesrate.php?cid=<?php echo $cid;?>&bid=<?php echo $bid;if($sid){ echo "&sid=".$sid;}?>&rate=<?php 
						if($rate=='Old'){ echo 'New'; } else { echo 'Old'; }?>" style=" margin-left:350px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php if($rate=='Old'){ echo 'New'; }else { echo 'Old'; }?>  Rate</button></a></h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Group Name</center></th>
                                    <?php 							
							$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ ?>
                                    <th><?php echo $row1['fdis_name'];?></th>
                            <?php } ?>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                                   <?php
							$qry=mysql_query("SELECT * FROM mfrate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND rate='$rate'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$frid=$row['fr_id'];
				$fgid2=$row['fg_id'];
				$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$fgid2");
								  $fgroup=mysql_fetch_array($fgrouplist);	
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $fgroup['fg_name']; ?></center></td>
                                <?php 							
							$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				$fdisid2=$row1['fdis_id'];
				$frvaluelist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND ay_id=$acyear"); 
								  $frvalue=mysql_fetch_array($frvaluelist);	
				?>
                                    <td><?php echo $frvalue['dis_value'];?></td>
                            <?php } ?>
								 <td class="action"><a href="mfeesrate_edit.php?cid=<?php echo $row['c_id'];?>&bid=<?php echo $bid;?>&rate=<?php echo $rate;?>&frid=<?php echo $row['fr_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="mfeesrate_delete.php?cid=<?php echo $row['c_id']; ?>&bid=<?php echo $bid;?>&rate=<?php echo $rate;?>&frid=<?php echo $row['fr_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>  
                            <tr class="gradeX odd" role="row">
									<td class="sno center sorting_1"><center>-</center></td>
								<td><center><b>Total</b></center></td>
                                <?php 
														
							$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				$total1=0;
				$fdisid2=$row1['fdis_id'];
				 $qry=mysql_query("SELECT * FROM mfrate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND rate='$rate'");
				 		  while($row=mysql_fetch_array($qry))
							{ 
							$frid=$row['fr_id'];
							$fgid2=$row['fg_id'];
						$frvaluelist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND ay_id=$acyear"); 
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
								  $total1 +=$frvalue['dis_value'];								  
								  }
								   }
				?>
                                    <td><b><?php echo $total1;?></b></td>
                            <?php } ?>
                            								 <td class="action">-</td>								
                                 								</tr>                   																
							</tbody>
						</table>
					</div>
				</div>
			</div>
            <div class="clear height-fix"></div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable();		
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->  
  <script type="text/javascript">
	$().ready(function() {		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form1").click(function() {
			location.reload(); 			
		});
		$("#reset-validate-form2").click(function() {
			location.reload(); 			
		});		
	});
  </script>
  <!-- end scripts-->
<script type="text/javascript">
	function change_function() { 
     var cid =document.getElementById('cid').value;
	  window.location.href = 'mfeesrate.php?cid='+cid+'&bid=<?php echo $bid;?>';	  
}
</script>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
</body>
</html>
<? ob_flush(); ?>