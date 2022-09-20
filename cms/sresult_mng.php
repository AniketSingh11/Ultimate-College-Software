<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
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
		$eid=$_GET['eid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="sboard_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                 <li class="no-hover"><a href="sboard_select_classexam.php?bid=<?php echo $bid; ?>&eid=<?php echo $eid;?>" title="Select Class">Class List</a></li>
				<li class="no-hover">Exam Results Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$subid=$_GET['subid'];
							
							
				if($cid && $sid && $eid){
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							if($subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_array($subjectlist);	
								  $slid=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1); 
								  $paper=$slist['paper'];  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b><?php if($subid){?>(<?php echo $slist['s_name'];?>)<?php } ?></b></h1>
                <?php if($cid && $subid && $sid){?>
                <a href="sboard_select_classexam.php?bid=<?php echo $bid;?>&eid=<?php echo $eid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                <a href="sresult_impt.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Import Student Result</button></a>
                <a href="sresult_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  Add Single</button></a>
                <span style="float:right"><a href="sresult_mng1.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/chart-pie-separate.png"> <?php echo $class['c_name']."-".$section['s_name']?>  Overall Result</button></a></span>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($cid && $subid && $sid && $eid){?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b><?php if($subid){?>(<?php echo $subject['s_name'];?>)<?php } ?></b></h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Mark</th>
                                    <th>result</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$ssid=$row['ss_id'];
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_array($studentlist);	
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                                <td><center><?php
								$mark=$row['mark'];
								$mark1=$row['mark1'];
								$total=$mark+$mark1;
								 if($paper=='1'){ echo $mark."-".$mark1." = ".$total; } else { echo $row['mark']; }?></center></td>
                                <td><center><?php echo $row['result']; ?></center></td>
                                <td width="80px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="sresult_edit.php?rid=<?php echo $row['r_id'];?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="sresult_delete.php?rid=<?php echo $row['r_id']; ?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?>'s Result" style="display: none;">
				<p>Exam Name : <strong><?php echo $exam['e_name']; ?></strong></p>
                
                 <p>Mark : <strong><?php
								$mark=$row['mark'];
								$mark1=$row['mark1'];
								$total=$mark+$mark1;
								 if($paper=='1'){ echo $mark."-".$mark1." = ".$total; } else { echo $row['mark']; }?></strong></p> 
                
                <p>Result : <strong><?php echo $row['result']; ?></strong>  </p> 
                <p>Remark : <strong><?php echo $row['remark']; ?></strong>  </p>   
                </div>
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
            </div> <?php } else {?>
            <center><h3 class="succ"> Please Select Subject </h3></center> <?php } ?>
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
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
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