<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
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
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    </aside> <!--! end of #sidebar -->
    <!-- Begin of #main -->
    <div id="main" role="main">
    <?php $bid=$_GET['bid'];
	if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_syllabus1.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Assign Syllabus To Staff (Classwise)</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_syllabus.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="student_mng.php">
						<div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class where b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" class="required">
											<option value="">Please select</option>											
								</select>
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
			<?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$slid=$_GET['slid'];							
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $cname=$class['c_name'];
								  if($cname == 'XI STD' || $cname == 'XII STD'){ 
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								  }
								  if(!$slid){
									   	if($cname == 'XI STD' || $cname == 'XII STD'){ 
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear LIMIT 1");
											}else{
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear LIMIT 1");
											}
											$slist=mysql_fetch_array($qry);
											$slid=$slist['sl_id'];											
									}
									if($slid){
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist1=mysql_fetch_array($subjectlist1);
								   $paper=$slist1['paper'];
								 	
								  ?>
			<div class="grid_12">
				<h1><?php echo $class['c_name']; if($cname == 'XI STD' || $cname == 'XII STD'){ echo "-".$section['s_name']; }?> Syllabus List <b><?php if($slid){?>( <?php echo $slist1['s_name'];?> )<?php } ?></b></h1>
                <?php 
							if($cname == 'XI STD' || $cname == 'XII STD'){ 
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
											}else{
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear");
											}
							$count=1;
			  while($slist=mysql_fetch_array($qry))
        		{
					?>
                 <a href="syllabus_class.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&slid=<?php echo $slist['sl_id']; ?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $slist['s_name']; ?></button></a>
                <?php } ?>
                <a href="javascript: void(0)"  onclick="popup('syllabus_assign.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&slid=<?php echo $slid; ?>&bid=<?php echo $bid;?>')" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  Add syllabus</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']; if($cname == 'XI STD' || $cname == 'XII STD'){ echo "-".$section['s_name']; }?> Syllabus List</h1>                
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table" align="center">
							<thead>
								<tr>
									<th width="10%"><center>S.No</center></th>
                                    <th width="25%;"><center>Exam Name</center></th>
                                    <th width="22%;"><center>due Date (DD/MM/YYYY)</center></th>
                                    <th><center>Syllabus to Covered</center></th>   
                                    <th>Acction</th>                                    
								</tr>
							</thead>
							<tbody>
								<?php 
												$qry11=mysql_query("SELECT * FROM exam Where ay_id=$acyear");
											$count=1;
						while($row11=mysql_fetch_array($qry11))
        		{			
				$eid=$row11['e_id'];
							if(($classname == 'XI STD') || $classname == 'XII STD'){
							$qry=mysql_query("SELECT * FROM syllabus_assign WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sl_id=$slid AND b_id=$bid AND ay_id=$acyear");
							}else{
								$qry=mysql_query("SELECT * FROM syllabus_assign WHERE c_id=$cid AND e_id=$eid AND sl_id=$slid AND b_id=$bid AND ay_id=$acyear");
							}
			  $row=mysql_fetch_array($qry);
			  if($row['id']){        		
						?>     		
								<tr class="gradeX" style="border-bottom:1px #ABABAB dotted;">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row11['e_name']; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['covered'];?></center></td>
                                <td class="action"><a href="javascript: void(0)"  onclick="popup('syllabus_assign.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&slid=<?php echo $slid; ?>&bid=<?php echo $bid;?>')" title="Edit"><img src="./img/edit.png" alt="edit"></a></td>
                                </tr> 
                                 <?php 
							$count++;
							}  } ?>                                                                						
							</tbody>
						</table>
					</div>
				</div>
            </div>
            <?php } 
			else{?>
            <div class="grid_12">
                <div class="alert error"><span class="hide">x</span><?php echo $class['c_name']; if($cname == 'XI STD' || $cname == 'XII STD'){ echo "-".$section['s_name']; }?> - This is No Subject to display... create subject to that class!!!</div>
                </div>
                 <?php }?> 
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
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
	function popup(url) 
{
 /*params  = 'width='+screen.width;
 params += ', height='+screen.height;
 params += ', top=0, left=0'
 params += ', fullscreen=no';

 newwin=window.open(url,'windowname4', params);
 if (window.focus) {newwin.focus()}
 return false;*/
 var width  = 1100;
 var height = 700;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=no';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'syllabus_class.php?bid='+cid;	  
	}
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