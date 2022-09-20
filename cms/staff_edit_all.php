<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");
 include("checking_page/staff.php");
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
                <li class="no-hover"><a href="staff.php" title="Home">Staff Management</a></li>
				<li class="no-hover">Staff Overall Edit</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">		 
			<div class="grid_12">
				<h1>Staff Overall Edit</h1>
            <a href="staff.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			 			<?php if(isset($_GET['msg']))
				{
				if($_GET['msg']="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully edited !!!</div>
                 <?php } }?>    
			</div>
          <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1> Staff List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Staff ID</center></th>
                                    <th><center>Staff Name</center></th>
                                    <th>Staff Type</th>
                                     <th>Route Master</th>
                                    <th>Stopping Point</th>
                                    <th>Fees Rate Type</th>                                   
                                    <th>Status</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
						$qry=mysql_query("SELECT * FROM staff order by st_id desc ");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
        		    $st_id=$row["st_id"];
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['staff_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['mname']." ".$row['lname'];  ?></center></td>
                                <td><center><select name="s_type"  id="s_type<?=$st_id?>" onchange="edit_changes('Staff Type',this.value,<?=$st_id?>)" class="required">
                                	 
									<option value="Teaching" <?php if($row['s_type']=="Teaching"){?> selected="selected" <?php }?>>Teaching</option>
									<option value="Non-Teaching" <?php if($row['s_type']=="Non-Teaching"){?> selected="selected" <?php }?>>Non-Teaching</option>
								</select></center></td>
                                
                                
                                <td><center><?php
											$rid=$row['r_id'];
                                            echo "<select name='rid' id='rid$st_id'  onchange='showCategory(this.value,$st_id)' >";
											echo '<option value="0"';
											
											 if($rid=='0'){ echo 'selected'; } echo'>Not Bus Student</option>	
                                            <option value="1"'; 
											if($rid=='1'){ echo 'selected'; } 
											echo '>Bus student</option>';
											?>										
								</select>
								</center></td>
                                <td><center>   <select name="spid" <?php if($rid=="0"){ ?>style="display:none;" <?php }?> onchange="edit_changes('Stoping point',this.value,<?=$st_id?>)"  id="spid<?=$st_id?>">
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
                                <td><center><?php $fesstypearray=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); ?> <select name="busfeestype" <?php if($rid=="0"){ ?>style="display:none;" <?php }?>  id="busfeestype<?=$st_id?>" onchange="edit_changes('Fees Rate type',this.value,<?=$st_id?>)">
                               <?php
							   $busfeestype=$row['busfeestype'];
				for ($cmonth = 0; $cmonth <= 3; $cmonth++) { 
				if($busfeestype==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo $fesstypearray[$cmonth]?></option>
            <?php }else { ?>
            <option value="<?php echo $cmonth;?>" ><?php echo  $fesstypearray[$cmonth]?></option>            
            <?php } }?>									
								</select></center></td>
                               
                                <td id="status_<?=$st_id?>"><center> 
                                </center></td>                                
								</tr> 
                            <!-- Modal Box Content -->
			</div> <!--! end of #info-dialog -->            
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
            </div>
            <div class="clear height-fix"></div>
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
		$('#table-example1').dataTable({
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
  function edit_changes(m,n,o)
  {
  	$("#status_"+o).html("<center><font color='green'>"+m+" Updated</font></center>");
  	var point=$("#spid"+o).val();
  	var bustype=$("#busfeestype"+o).val();
  	var rid=$("#rid"+o).val();

  	 var stype=$("#s_type"+o).val();
  	 //var category=$("#category"+o).val();
  	     var request =$.ajax({
  		 	  
  		    url: "ajax_staffprofile.php",
  		   // context: document.body
  	 type: "POST",
  	 data: { stid : o,rid : rid,point :point,bustype:bustype,stype:stype },
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
   
  function showCategory(str,n) {
	  if (str == "" || str == 0) {
          
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
 
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
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
  
</body>
</html>
<? ob_flush(); ?>