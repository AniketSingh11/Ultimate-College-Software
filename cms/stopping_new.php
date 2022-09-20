<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$part_country="";
	$rid=$_POST['rid'];
		$stoplist=mysql_query("SELECT * FROM stopping WHERE r_id=$rid ORDER BY ListingID DESC"); 
		$stop=mysql_fetch_array($stoplist);
		$lasteid=$stop['ListingID'];
		if($lasteid){
			$lasteid++;		
		}else{
			$lasteid=1;		
		}
		//echo $lasteid;
		//die();
								  
	foreach ($_POST['sp_name'] as $selectedOption1)
    {
		 $part_country.=$selectedOption1.",";
		 		 $sql="INSERT INTO stopping (sp_name,r_id,ListingID,status) VALUES
('$selectedOption1','$rid','$lasteid','1')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
		if($result){
			$lasteid++;
		}		
	}
	//echo $part_country."/".$lasteid;
	//die();
	if($result){
        header("Location:stopping_new.php?rid=$rid&msg=succ");
    }
    exit;
}

 ?>
 <!-- Example JavaScript files -->

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
		$rid=$_GET['rid'];
							 $classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $class=mysql_fetch_array($classlist);
								  $vid=$class['v_id'];
							$did=$class['d_id'];
							$sdid=$class['sd_id'];
								$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid"); 
								$vehicle=mysql_fetch_array($vehiclelist);
								$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								$driver=mysql_fetch_array($driverlist);
								$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid"); 
								$driver1=mysql_fetch_array($driverlist1);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="route.php" title="Route Master">Route Master</a></li>
                <li class="no-hover"><a href="stopping.php?rid=<?php echo $rid; ?>" title="Stopping Name List"><?php  echo $class['r_name'];?> - Stopping Name List</a></li>
                <li class="no-hover">Add/Edit Stopping Place ( <?php  echo $class['r_name'];?> )</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12 fadeInRight animated">
				<h1>Add/Edit Stopping Place ( <?php  echo $class['r_name'];?> )</h1>                
			<a href="stopping.php?rid=<?php echo $rid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <span style="margin:0px 10px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/truck--plus.png"> Vehicle No - <strong><?php echo $vehicle['v_no']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-thief-baldie.png"> Driver Name - <strong><?php echo $driver['fname']." ".$driver['lname']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-yellow-female.png"> Bus Assistant - <strong><?php echo $driver1['fname']." ".$driver1['lname']; ?></strong></span>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add/Edit Stopping Place ( <?php  echo $class['r_name'];?> )</h1> <span></span><center><label for="select">Filter :</label><select name="sfilter" id="sfilter" class="required valid" onchange="change_function()" style="width:25%; margin:5px 10px;">
                                    <option value="1">Not Assign List</option>
                                    <option value="2">Overall List</option>
									</select></center>
					</div>
                    <form id="validate-form" class="block-content form" action="" method="post">
						<div class="field">
                        <div class="_75">
            	</div>
                <div class="contents">
                <div id="example-1-3">
               <!-- <p><input type="button" class="input-button" id="btn-get" value="Get items" /></p>-->
                <p>
                <div class="_50 left first">
                                    <label for="textfield">
								<center>Stopping Place List </center></label>
					<ul class="sortable-list" id="filterlist" style="height:600px; overflow:scroll;">
                    <?php 
					$qry=mysql_query("SELECT * FROM trstopping WHERE r_id=0");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ $rid1=$row['r_id'];?>
                    	<li class="sortable-item flipInY animated" id="<?php echo $row['stop_id'];?>" <?php if($rid1){ ?> style="background-color:#FC6467;"<?php } ?> ><img src="img/icons/packs/fugue/24x24/marker.png"> <?php echo $row['stop_name']; ?></li>
				<?php } ?>
					</ul>
                    </p>
				</div>
				<div class="_50 left">
                <label for="textfield"><center><?php  echo $class['r_name'];?> - Stopping List </center></label>
					<ul class="sortable-list" id="left" style="height:600px; overflow:scroll;">
                    <?php 
					$res_arr_values = array();
					$qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
					$res_arr_values[] = $row['stop_id'];
				?>
                    	<li class="sortable-item flipInY animated" id="<?php echo $row['stop_id'];?>"><img src="img/icons/packs/fugue/24x24/marker.png"> <?php echo $row['stop_name']; ?></li>
				<?php } ?>
                	</ul>
				</div>
               <div class="clearer">&nbsp;</div>
<input type="hidden" id="lastarray" value="<?php echo $res_arr_values;?>"/>
			</div></div></div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="rid" value="<?php echo $_GET['rid'];?>" >
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
            <?php //print_r($res_arr_values); 
			$str = serialize($res_arr_values);
    		$strenc = urlencode($str);
    		?>
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php  include("includes/footer.php");?>
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
  <script src="js/jquery-1.9.1.min.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
	});
  </script>
  <link rel="stylesheet" type="text/css" href="stoping/stop.css" media="screen" />
  <script type="text/javascript" src="stoping/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="stoping/jquery-ui-1.8.custom.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	// Get items
	function getItems(exampleNr)
	{
		var columns = [];

		$(exampleNr + ' ul.sortable-list#left').each(function(){
			columns.push($(this).sortable('toArray').join(','));				
		});
		return columns.join('|');
	}

	// Example 1.3: Sortable and connectable lists with visual helper
	$('#example-1-3 .sortable-list').sortable({
		connectWith: '#example-1-3 .sortable-list',
		placeholder: 'placeholder',
	});

	$('#btn-get').click(function(){
		alert(getItems('#example-1-3'));
	});
	
	$(function() {
		$("#example-1-3 ul#left").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			//alert(getItems('#example-1-3'));
			var x = document.getElementById("lastarray").value;
			var order = '&rid=<?php echo $rid;?>&last=<?php echo $strenc;?>&action=update&stop='+getItems('#example-1-3'); 
			//alert(order);
			$.post("trstopDB.php", order, function(theResponse){
				//alert(theResponse);
				$("#contentRight").html(theResponse);
			});												 
		}								  
		});
	});
});
function change_function() { 
     var cid =document.getElementById('sfilter').value;
	 $.get("trstop_filter.php",{value:cid,rid:<?php echo $rid;?>},function(data){
			$( "#filterlist" ).html(data);
        });	  
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