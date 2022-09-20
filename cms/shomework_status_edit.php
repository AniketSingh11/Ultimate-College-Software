<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['update'])) {
	  $sremark=$_POST['sremark'];
	  $hst_id=$_POST['hst_id'];
	 
	 // if($hst_id){
		  $sql=mysql_query("UPDATE homework_status SET st_remark='$sremark' WHERE id='$hst_id'");		  
	 /* }else{
		  $sql=mysql_query("INSERT INTO homework_status (status,h_id,ss_id,c_id,s_id,b_id,ay_id,s_remark) VALUES ('$status','$hid','$ssid','$cid','$sid','$bid','$acyear','$remark')");
	  }*/
	 	 if($sql){
			 $msg="succ";
	   }else{
		 $msg="err";
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    <?php 
		$bid=$_GET['bid'];
		$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$mid=$_GET['mid'];
							$subid=$_GET['subid'];
							$hid=$_GET['hid'];
							$ssid=$_GET['ssid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $homeworklist=mysql_query("SELECT * FROM homework WHERE h_id=$hid"); 
								  $homework=mysql_fetch_array($homeworklist);	
								  
								  $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);	
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sboard_select_work.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="sboard_select_classwork.php?bid=<?php echo $bid;?>" title="Select Class">Select Class</a></li>
                <li class="no-hover"><a href="shomework_mng.php?cid=<?php echo $cid."&sid=".$sid."&mid=".$mid."&subid=".$subid."&bid=".$bid;?>" title="Select Class">Homework Management</a></li>
				<li class="no-hover"><a href="shomework_status.php?cid=<?php echo $cid."&sid=".$sid."&mid=".$mid."&subid=".$subid."&bid=".$bid."&hid=".$hid;?>" title="Select Class">Homework Student Status</a></li> 
                <li class="no-hover"><?php echo $student['admission_number']."-".$student['firstname']." ".$student['lastname'];?> Status</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
        <!-- Begin of #main-content -->
		<div id="main-content">
        
		<div class="container_12">
            <?php
				if($cid && $sid && $subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_array($subjectlist);	
								  $slid=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);	
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							if($mid){
								$examlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($examlist);
							  }
							 	  //echo $class['c_name']."-".$section['s_name'];
		
								  ?>
            <a href="shomework_status.php?cid=<?php echo $cid."&sid=".$sid."&mid=".$mid."&subid=".$subid."&bid=".$bid."&hid=".$hid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                                   <?php if($cid && $subid && $sid && $mid){?>
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> - Home Work <?php echo " ( ".$student['admission_number']."-".$student['firstname']." ".$student['lastname']." status ) ";?><b><?php if($subid){?> ( <?php echo $slist['s_name'];?> )<?php } ?></b> <a style="float:right;" href="javascript:void(0);" onclick="$('#info-dialog01').dialog({ modal: true });"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/home--pencil.png"> <?php echo $homework['day']."/".$homework['month']."/".$homework['year'];?> - Home Work Detail</button></a></h1>
                <!-- Modal Box Content -->
			<div id="info-dialog01" title="Home Work Details" style="display: none;" >
				<table id="table-exampl" class="table" width="100%">
							<thead>
								<tr>
									<th>Title</th>
                                    <th width="2%">:</th>
                                    <th>Details</th>
								</tr>
							</thead>
                            <tbody>
                            <tr>
                            	<td>Title</td>
                                <td><center>:</center></td>
                                <td><?php echo $homework['title'];?></td>                                
                            </tr>
                            <tr>
                            	<td>Date</td>
                                <td><center>:</center></td>
                                <td><?php echo $homework['day']."/".$homework['month']."/".$homework['year'];?></td>                                
                            </tr>
                            <tr>
                            	<td>Details</td>
                                <td><center>:</center></td>
                                <td><?php echo $homework['detail'];?></td>                                
                            </tr>
                            </tbody>
                           </table>				
			</div> <!--! end of #info-dialog -->
            
                <?php if($cid && $mid && $sid){?>
                <?php //$msg=$_GET['msg'];
				if($msg=="succ"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully edited !!!</div>
                 <?php } }?>                   
            </div>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Home Work <?php echo " ( ".$student['admission_number']."-".$student['firstname']." ".$student['lastname']." ) ";?> <b><?php if($subid){?>(<?php echo $slist['s_name'];?>)<?php } ?></b></h1>                   <span></span>
					</div>
					<div class="block-content">
                    <form id="validate-form" method='post' action=''>
						<table class="table" width="100%">
              <thead>
                <tr>
                  <th>Title</th>
                  <th width="2%">:</th>
                  <th>Details</th>
                </tr>
              </thead>
              <tbody>
              <?php $hstatus=mysql_query("SELECT * FROM homework_status WHERE h_id=$hid AND ss_id=$ssid AND c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");						
					$hstatuslist=mysql_fetch_array($hstatus);
					
					$status=$hstatuslist['status'];
					$remark1=$hstatuslist['s_remark'];
					$remark2=$hstatuslist['st_remark'];
					$hst_id=$hstatuslist['id'];
					?>
                    <tr>
                  <td>Title</td>
                  <td>:</td>
                  <td><?php echo $homework['title'];?></td>
                  </tr>
                  <tr>
                  <td>Date</td>
                  <td>:</td>
                  <td><?php echo $homework['day']."-".$homework['month']."-".$homework['year'];;?></td>
                  </tr>
                  <tr>
                  <td>Homework Details</td>
                  <td>:</td>
                  <td><?php echo $homework['detail'];?></td>
                  </tr>
                <tr>
                  <td>Status</td>
                  <td>:</td>
                  <td><?php if(!$status){ ?>
                                <button class="btn btn-small btn-gray" >Pending</button><?php }else if($status=='1'){ ?>
                                <button class="btn btn-small btn-warning" >Started</button><?php }else if($status=='2'){ ?>
                                <button class="btn btn-small btn-success" >Finished</button><?php } ?></td>
                 </tr>
                 <tr>
                  <td>Finished Details</td>
                  <td>:</td>
                  <td><textarea name="remark" id="remark" rows="5" style="width:90%" readonly><?php echo $remark1;?></textarea></td>
                  </tr>
                 <tr>
                 <tr>
                  <td>Staff's Remark</td>
                  <td>:</td>
                  <td><textarea name="sremark" id="sremark" rows="5" style="width:90%" class="required"><?php echo $remark2;?></textarea></td>
                  </tr>
                 <tr>
                 <td colspan="3">
                 <div align="center">
                 <input type="hidden" name="hst_id" value="<?php echo $hst_id;?>" />
            <button class="btn btn-primary" name="update" type="submit">Submit</button>
        </div>
                 </td>
                 </tr>
              </tbody>
            </table>
            </form>
					</div>
				</div>
            </div> <?php } else {?>
            <center><h3 class="succ"> Please Select any one Month </h3></center> <?php } ?>
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
	$('#table-example1').dataTable();
	$('#table-example2').dataTable();
	$('#table-example3').dataTable();
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
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		$("#tab-panel-1").createTabs();
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
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
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>