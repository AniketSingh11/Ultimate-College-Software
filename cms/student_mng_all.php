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
    <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_stu.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Students Overall Edit</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="grid_12">
				<h1>Students Overall Edit</h1> 
            <a onclick="history.go(-1);" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            </div>          
            <?php if(isset($_GET["alledit"]))
			{
				$alledit=$_GET["alledit"];				
			}else{?>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="student_mng.php">
						<div class="_50">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
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
                        <div class="_50">
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
                            	<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div><?php }?>
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
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Student List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Student Category</th>
                                    <th>Student Type</th>
                                    <th>Mode of Transport</th>
                                    <th>Stopping Point</th>
                                    <th>Route No</th>
                                    <th>Fees Rate Type</th>
                                    <th>Status</th>
                                    
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear ORDER BY firstname ASC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
        		$ajaxsid=$row["ss_id"];
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                <td><center>	<select name="category" id="category<?=$ajaxsid?>" onchange="edit_changes('category',this.value,<?=$ajaxsid?>)" class="required">
                                    <?php 
									$fdis_id=$row['fdis_id'];
									$sql1=mysql_query("SELECT * FROM fdiscount");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									if($fdis_id==$row2['fdis_id']){?>
                                    <option value="<?php echo $row2['fdis_id'];?>" selected><?php echo $row2['fdis_name'];?></option>
                                    <?php } else { ?>
												<option value="<?php echo $row2['fdis_id'];?>"><?php echo $row2['fdis_name'];?></option>
                                <?php } }?>
											</select>	</center></td>
                                <td><center><select name="stype" id="stype<?=$ajaxsid?>" onchange="edit_changes('Std type',this.value,<?=$ajaxsid?>)" class="required">
												<option value="Old" <?php if($row['stype']=='Old'){ echo 'selected'; }?>>Old Student</option>
								<option value="New" <?php if($row['stype']=='New'){ echo 'selected'; }?>>New Student</option>
											</select></center></td>
                                <td><center><?php
											$mode=$row['mode'];
											$rid=$row['r_id'];
                                            //$result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
											$modelist=array("School Van","Private Van","Car","Auto","Two Wheeler"); 
                                            echo "<select name='mode' id='mode$ajaxsid'  onchange='showCategory_all(this.value,$ajaxsid)' >
											<option value=''>Select</option>";
											for ($cmonth = 0; $cmonth <= 4; $cmonth++) {
												if($mode==$modelist[$cmonth]){
											echo '<OPTION VALUE="'.$modelist[$cmonth].'" selected>'.$modelist[$cmonth].'</OPTION>';
												}else{
											echo '<OPTION VALUE="'.$modelist[$cmonth].'">'.$modelist[$cmonth].'</OPTION>';		
												}
											}
											?>										
								</select></center></td>

                                <td><center>  <select name="spid"  <?php if($rid=="0"){ ?>style="display:none;" <?php }?> onchange="edit_changes('Stopping Point',this.value,<?=$ajaxsid?>)" id="spid<?=$ajaxsid?>">
                               		<?php $spid=$row['sp_id'];
									$result1 = mysql_query("SELECT * FROM trstopping WHERE status='1'") or die(mysql_error());
									echo '<option value="0">Please select</option>';
                                            while ($row1 = mysql_fetch_assoc($result1)):
												if($spid==$row1['stop_id']){
                                                echo "<option value='{$row1['stop_id']}' selected>{$row1['stop_name']}</option>\n";
												}else{
												echo "<option value='{$row1['stop_id']}'>{$row1['stop_name']}</option>\n";	
												}
                                            endwhile;
                                            echo '</select>';?></center></td>
                                            <td><div id="route<?=$ajaxsid?>"><?php echo $row['route'];?></div></td>
                                <td> <?php  
				$fesstypearray=array("Normal Fees","Sp.Fees","Onetime Sp.Fees","Onetime"); 
				?>	<center><select name="busfeestype"  <?php if($rid=="0"){ ?>style="display:none;" <?php }?> onchange="edit_changes('Busfees',this.value,<?=$ajaxsid?>)" id="busfeestype<?=$ajaxsid?>">
                               <?php  if($rid=="0"){
                              // echo "<option value='0' selected='selected'>Please select</option>";
                                }
							  
				for ($cmonth = 0; $cmonth <= 3; $cmonth++) { 
				if($row["busfeestype"]==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"  ><?php echo $fesstypearray[$cmonth]?></option>
            <?php }else { ?>
            <option value="<?php echo $cmonth;?>" ><?php echo  $fesstypearray[$cmonth]?></option>            
            <?php } }?>										
								</select></center></td>
                                <td id="status_<?=$ajaxsid?>"><center>
                              <font color="green"> </font>
                                </center></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
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
	$('#table-example').dataTable({
  'iDisplayLength': 25
});
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

function findRoot(str,upid) {
    	if (str == "") {
            document.getElementById("route"+upid).innerHTML = "";
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
                document.getElementById("route"+upid).innerHTML = xmlhttp.responseText;
            }
        }
		xmlhttp.open("GET", "findroot.php?stpt=" + str, true);
        xmlhttp.send();
		
    } 

function edit_changes(m,n,o)
{
	



	$("#status_"+o).html("<center><font color='green'>"+m+" Updated</font></center>");
	var point=$("#spid"+o).val();
	//findroot(point,o);
	var bustype=$("#busfeestype"+o).val();
	var mode=$("#mode"+o).val();

	 var stype=$("#stype"+o).val();

	 var category=$("#category"+o).val();

	 
 
	 
	     var request =$.ajax({
		 	  
		    url: "ajax_studentprofile.php",
		   // context: document.body
	 type: "POST",
	 data: { sid : o,mode : mode,point :point,bustype:bustype,stype:stype,category:category },
	 dataType: "html"
		  });

	    request.done(
	     		  
	    	    function(dataFromTheBackEnd) {
	    		   
	    		   
	     		 // $('#configform')[0].reset(); form reset  
	    	 		 
	    	      // The data from the back end is passed to the callback as a parameter /
	    		     // $("#step1").css("display", "none");
	    		      //$("#step3").css("display", "block");
	    	     // $("#register").html(dataFromTheBackEnd);
	    	    }
	    );
	    request.fail(
	    		 function() {
	    			   alert("Fail");
	        		//window.location.href="";

	       });
}

  
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
	
	 function showCategory_all(str,n) {
		 
        if (str == "" || str != 'School Van') {
            
            document.getElementById("spid"+n).innerHTML = "";
            $("#spid"+n).hide();
            $("#busfeestype"+n).hide();
            edit_changes("Route Master",0,n);
            return;
        }

        
        $("#spid"+n).show();
        $("#busfeestype"+n).show();
        
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("spid"+n).innerHTML = xmlhttp.responseText;

                edit_changes("Route Master",0,n);
                
            }
        }
        xmlhttp.open("GET", "stoppinglist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>