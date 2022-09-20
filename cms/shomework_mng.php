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
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sboard_select_work.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="sboard_select_classwork.php?bid=<?php echo $bid;?>" title="Select Class">Select Class</a></li>
				<li class="no-hover">Home Work Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$mid=$_GET['mid'];
							$subid=$_GET['subid'];
							
							
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
            <a href="sboard_select_classwork.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <?php 
			$monthno=date("m");
				 			$qry1=mysql_query("SELECT * FROM month WHERE ay_id=$acyear");
							$count=1;
							$mcount=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$mno=$row1['m_no'];
					if($mcount==1){?>
                 <a href="shomework_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $row1['m_id'];?>&subid=<?php echo $subid; ?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $row1['m_name']; ?></button></a>
                <?php } if($mno==$monthno){
						$mcount=0;
					} }?>
                                   <?php if($cid && $subid && $sid && $mid){?>
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name']." (".$month['m_name']." ) ";?> Home Work <b><?php if($subid){?>(<?php echo $slist['s_name'];?>)<?php } ?></b></h1>
                <?php if($cid && $mid && $sid){?>
                <a href="shomework_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  Add Home Work</button></a>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } }?>                   
				<span style="float:right;">
            <?php
									/*$qry2=mysql_query("SELECT * FROM year ORDER BY ay_id DESC LIMIT 1");
									$row2=mysql_fetch_array($qry2);				
									$monthno=date("m");
									$mcount=1;
                                            $classl1 = "SELECT m_id,m_name,m_no FROM month where ay_id=$acyear";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="mid" id="mid" class="required" onchange="change_function()"> <option value="">Select Month</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
											$mid1=$row11['m_id'];
											$mno=$row11['m_no'];
											if($mcount==1){	
												if($mid1==$mid){
                                                 echo "<option value='{$row11['m_id']}' selected>{$row11['m_name']}</option>\n";
												}else{
													echo "<option value='{$row11['m_id']}'>{$row11['m_name']}</option>\n";
												}
												}
											if($mno==$monthno && $row2['ay_id']==$acyear){
													$mcount=0;
												}
                                            endwhile;
                                            echo '</select>';*/
                                            ?>
                                            </span>
            </div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name']." (".$month['m_name'].")";?> Home Work <b><?php if($subid){?>(<?php echo $slist['s_name'];?>)<?php } ?></b></h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Title</th>
                                    <th><center>Date</center></th>
                                    <th>Details</th>
                                    <th>Student Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM homework WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND sub_id=$subid AND ay_id=$acyear ORDER BY h_id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo $row['day']."/".$row['month']."/".$row['year']; ?></center></td>
                                <td><center><?php echo substr($row['detail'], 0, 20); ?></center></td>
                                <td class="view"><center><a href="shomework_status.php?hid=<?php echo $row['h_id']; ?>&cid=<?php echo $cid."&sid=".$sid."&mid=".$mid."&subid=".$subid."&bid=".$bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
                                <td width="80px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="shomework_edit.php?hid=<?php echo $row['h_id'];?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="shomework_delete.php?hid=<?php echo $row['h_id']; ?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $class['c_name']."-".$section['s_name']." (".$month['m_name']." ) ";?> Home Work <b><?php if($subid){?>(<?php echo $slist['s_name'];?>)<?php } ?></b>" style="display: none;">
				<p>Title : <strong><?php echo $row['title']; ?></strong></p>
                
                <p>Subject : <strong><?php echo $slist['s_name'];?></strong></p>
                
                 <p>Date: <strong><?php echo $row['day']."/".$row['month']."/".$row['year']; ?></strong></p> 
                
                <p>Details : <strong><?php echo $row['detail']; ?></strong>  </p>   
                
                </div>
                
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
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