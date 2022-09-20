<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
  if (isset($_POST['event-submit']))
{
	 $title=$_POST['title'];
	 $eventtype=$_POST['event-type'];
	 $eventprivacy=$_POST['event-privacy'];
	 $desc=$_POST['desc'];
	 $eventstart=$_POST['event-start'];
	 $eventend=$_POST['event-end'];
	if($title){
	$sql="INSERT INTO evenement (title,et_id,privacy,descp,start,end) VALUES
('$title','$eventtype','$eventprivacy','$desc','$eventstart','$eventend')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
if($result){
	header("Location:fullcalendar.php?sdate=$eventstart");
}
	}else{
		header("Location:fullcalendar.php?msg=err");
	}

}
if (isset($_POST['event-edit-submit']))
{
	 $title=$_POST['title'];
	 $eventtype=$_POST['event-type'];
	 $eventprivacy=$_POST['event-privacy'];
	 $desc=$_POST['desc'];
	 $ssid=$_POST['ssid'];
	 $eventstart=$_POST['event-start'];
	if($title){
$sql="UPDATE evenement SET title='$title',et_id='$eventtype',privacy='$eventprivacy',descp='$desc' WHERE id='$ssid'";

		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
if($result){
	header("Location:fullcalendar.php?sdate=$eventstart&msg=esucc");
}
	}else{
		header("Location:fullcalendar.php?msg=err");
	}

}
 //unset($_SESSION['event']['eid']);
  $sessionid=$_GET['ssid'];
 ?>
  <link href='./fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='./fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
 <style>
 #calendar {
  /*width: 900px;
  margin: 0 auto;*/
  margin:10px 0;
  }
</style>
<style type="text/css">
#basic-modal-content {display:none;}
#basic-modal-content1 {display:none;}

/* Overlay */
#simplemodal-overlay {background-color:#000;}

/* Container */
#simplemodal-container { width:380px; color:#bbb; /* height:330px; background-color:#262B2E; border:4px solid #444;*/}
#simplemodal-container code {background:#141414; border-left:3px solid #65B43D; color:#bbb; display:block; font-size:12px; }
#simplemodal-container a {color:#ddd;}
#simplemodal-container a.modalCloseImg {background:url(img/x.png) no-repeat; width:25px; height:29px; display:inline; z-index:3200; position:absolute; /*top:-15px;*/ right:-16px; cursor:pointer;}
#simplemodal-container h3 {color:#84b8d9;}

</style>
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
				<li class="no-hover">School Calendar</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>School Calendar</h1>
                <a href="full_event_type.php" title="event-types"><button class="btn btn-small btn-warning"><img src="img/icons/packs/fugue/16x16/table--plus.png"> Event Types</button></a>
                <form class="form" action="fullcalendar.php" method="get">
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <!--<div class="grid_6 alert success"><span class="hide">x</span>Your Board Successfully Deleted !!!</div>-->
                 <?php } ?> 
                <div class="form _25" style="float:right">
								<label for="select1">Show</label>
								<select name="etype" onchange="this.form.submit();">
                                	<option value="all">All Event Types</option>
                                    <?php 
									$etype=$_GET['etype'];
									$qry=mysql_query("SELECT * FROM event_type WHERE status='1'");
								  while($row=mysql_fetch_array($qry))
									{ if($etype==$row['et_id']){?>
                                    <option value="<?php echo $row['et_id']; ?>" style="color:#FFFFFF; background-color:<?php echo $row['et_color']; ?>;" selected><?php echo $row['et_name']; ?></option><?php } else { ?>
									<option value="<?php echo $row['et_id']; ?>" style="color:#FFFFFF; background-color:<?php echo $row['et_color']; ?>;"><?php echo $row['et_name']; ?></option>
									<?php } } ?>
								</select>
                                
						</div>
                        </form>
                 <div id="basic-modal-content">
				<div class="block-border">
					<div class="block-header">
						<h1>Create Event</h1>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<p class="inline-mini-label">
							<label for="title">Title</label>
							<input type="text" name="title" id="event-title" class="required" value="<?php echo $eventid;?>">
						</p>
						<p class="inline-mini-label">
							<label for="category">Event Type</label>
							<select name="event-type" id="event-type">
								<?php 
									$qry=mysql_query("SELECT * FROM event_type WHERE status='1'");
								  while($row=mysql_fetch_array($qry))
									{?>
									<option value="<?php echo $row['et_id']; ?>"><?php echo $row['et_name']; ?></option>
									<?php } ?>
							</select>
                            <?php $sdate=$_GET['sdate'];
							if($sdate){ ?>
                            <input type="hidden" id="sdate" name="sdate" value="<?php echo $sdate;?>" />
                            <?php } ?>
						</p>
						<p class="inline-mini-label">
								<label for="post">Description</label>
								<textarea id="post" name="desc" class="required" rows="5" cols="40"></textarea>
							</p>
						</p>
                      <p class="inline-mini-label">
							<label for="category">Event Privacy</label>
							<select name="event-privacy" id="event-privacy" style="width:160px; margin-left:20px;">
							  <option value="Public">Public</option>
							  <option value="Admin">Admin</option>
							  <option value="Staff">Staff</option>   
                              <option value="Student">Student</option>
                              <option value="Parent">Parent</option>  
							</select>
						</p>

						<div class="clear"></div>
						
						<!-- Buttons with actionbar  -->
						<div class="block-actions">
							<ul class="actions-right">
                            <input type="hidden" id="event-start" name="event-start" value="" />
                            <input type="hidden" id="event-end" name="event-end" value="" />
								<li><input type="submit" class="button" name="event-submit" value="Submit"></li>
							</ul>
						</div> <!--! end of #block-actions -->
					</form>				
			</div>
            
		</div>
        <?php if($sessionid){ 
				$eventlist=mysql_query("SELECT * FROM evenement WHERE id=$sessionid"); 
								  $events=mysql_fetch_array($eventlist);
								  $etid2=$events['et_id'];
		?>
        		<div id="basic-modal-content1">
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Event</h1>
					</div>
                    <form id="validate-form" class="block-content form" action="" method="post">
						<p class="inline-mini-label">
							<label for="title">Title</label>
							<input type="text" name="title" id="event-title" class="required" value="<?php echo $events['title'];?>">
						</p>
						<p class="inline-mini-label">
							<label for="category">Event Type</label>
							<select name="event-type" id="event-type">
								<?php 
									$qry=mysql_query("SELECT * FROM event_type WHERE status='1'");
								  while($row=mysql_fetch_array($qry))
									{ if($etid2==$row['et_id']){?>
									<option value="<?php echo $row['et_id']; ?>" selected><?php echo $row['et_name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $row['et_id']; ?>"><?php echo $row['et_name']; ?></option>
									<?php }  } ?>
							</select>
                            <?php $sdate=$_GET['sdate'];
							if($sdate){ ?>
                            <input type="hidden" id="sdate" name="sdate" value="<?php echo $sdate;?>" />
                            <?php } ?>
						</p>
						<p class="inline-mini-label">
								<label for="post">Description</label>
								<textarea id="post" name="desc" class="required" rows="5" cols="40"><?php echo $events['descp'];?></textarea>
							</p>
						</p>
                        <?php 
							$privacyarray=array("Public","Admin","Staff","Student","Parent");
							?>	
                      <p class="inline-mini-label">
							<label for="category">Event Privacy</label>
							<select name="event-privacy" id="event-privacy" style="width:160px; margin-left:20px;">
                            <?php
							   $privacy=$events['privacy'];
				for ($cmonth = 0; $cmonth <= 4; $cmonth++) { 
				if($privacy==$privacyarray[$cmonth]){?>
                <option value="<?php echo $privacyarray[$cmonth];?>" selected="selected" ><?php echo $privacyarray[$cmonth];?></option>
            <?php }else { ?>
            <option value="<?php echo $privacyarray[$cmonth];?>" ><?php echo  $privacyarray[$cmonth];?></option>            
            <?php } }?>		
							</select>
						</p>

						<div class="clear"></div>
						
						<!-- Buttons with actionbar  -->
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="fullcalendar_delete.php?id=<?php echo $sessionid;?>&sdate=<?php echo $events['start'];?>">Delete</a></li>
							</ul>
							<ul class="actions-right">
                            <input type="hidden" id="ssid" name="ssid" value="<?php echo $sessionid;?>" />
                            <input type="hidden" id="event-start" name="event-start" value="<?php echo $events['start'];?>" />
                            	<li><input type="submit" class="button" name="event-edit-submit" value="Submit"></li>
							</ul>
						</div> <!--! end of #block-actions -->
					</form>				
			</div>
            
		</div>
        <?php } ?>
        
                         
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>School Calendar - Event List</h1> <a href="fullcalendar.php" title="today"> <button style="margin:5px 0 0 50px;" class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/calendar-blue.png"> TO DAY</button> </a>
                        <span></span>
					</div>
					<div class="block-content">
						<div id='calendar'></div>
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
   <!-- <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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
  
<!-- <script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>-->
<script src='./fullcalendar/lib/moment.min.js'></script>
 <script src='./fullcalendar/lib/jquery.min.js'></script>
<script src='./fullcalendar/fullcalendar.min.js'></script>

<script type='text/javascript' src='js/jquery.simplemodal.js'></script>

  <script type="text/javascript">
  function myFunction() {
	   
	var etype  = $("#event-type").val();
	//alert(etype);
	        var dateval    = $("#locDatePicker").val();
            var locvalLen    = locval.length;
    alert("test");
}  
function myFunction() {
	   
	var etype  = $("#event-type").val();
	//alert(etype);
	        var dateval    = $("#locDatePicker").val();
            var locvalLen    = locval.length;
    alert("test");
}   
function editpopup(){
	//alert("test");
	$('#basic-modal-content1').modal();
		return false;
}
function popup1(id) {
	//alert(id);
	<?php 
	$url="fullcalendar.php?";
	if($sdate){ 
		$url .=$sdate."&";
	}	?>
	window.location.href = '<?php echo $url;?>ssid='+id;
	/*$.ajax({
            type: "POST",
            url: "pass_value1.php",
            //data: dataString,
			data :{"lang":id},
            dataType: 'json',
            cache: false,
            success: function(response) {
                    alert(response.message);					
                }
        });
		window.location.reload();	*/	
}
function popup(s,e) {
	//alert(s);
	//var ffromvalue = parseFloat(document.getElementById('event-title').value);
	eventstart = document.getElementById('event-start');
	eventstart.value = s;	
	eventend = document.getElementById('event-end');
	eventend.value = e;	
	//alert(ffromvalue1);
	$('#basic-modal-content').modal();
		return false;
	}; 
	$(document).ready(function() {
		
		/*var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		$('#table-example').dataTable();
		*/
		 var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  var calendar = $('#calendar').fullCalendar({
	  <?php
	   if($sdate){?>
	  now: '<?php echo $sdate;?>', <?php } ?>
   editable: true,
   header: {
    left: 'prev,next',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },   
   /*defaultView:"agendaDay",*/
   //events: "full_events.php",   
   <?php include("full_events.php"); ?>
   // Convert the allDay from string to boolean
   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {
   //var title = prompt('Event Title:');
   //var url = prompt('Type Event url, if exits:');
   var sdate=(new Date(start)).toISOString();
   var edate=(new Date(end)).toISOString();
   //alert(sdate);
   popup(sdate,edate);
   /*if (title) {
	var start = (new Date(start)).toISOString();
	var end = (new Date(end)).toISOString();
   //alert(start);
   
   $.ajax({
   type: "POST",
   url: 'full_add_event.php',
   data: '&title='+title+'&start='+start +'&end='+end,
   success: function(json) {
   alert('Added Successfully');
   }
   });
   calendar.fullCalendar('renderEvent',
   {
   title: title,
   start: start,
   end: end,
   allDay: allDay
   },
   true // make the event "stick"
   );
   }*/
   calendar.fullCalendar('unselect');
   },   
   editable: true,
   eventDrop: function(event, delta) {   
	var start = (new Date(event.start)).toISOString();
	var end = (new Date(event.end)).toISOString();
	//alert(event.id);
/*var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");*/
$.ajax({
	type: "POST",
url: 'full_update_events.php',
data: '&title='+event.title+'&start='+start+'&end='+end+'&id='+event.id,
success: function(json) {
/*alert("Updated Successfully");*/
}
   });
   },
   eventClick: function(event) {
	   //var title = prompt('Event Title:', event.title);
	   //alert("test");
	   popup1(event.id);
/*var decision = confirm("Do you really want to delete that?"); 
if (decision) {
$.ajax({
type: "POST",
url: "full_delete_event.php",
data: "&id=" + event.id,
 success: function(json) {
	 $('#calendar').fullCalendar('removeEvents', event.id);
	 alert("Updated Successfully");
	  }
}); 
}*/
  },
   eventResize: function(event) {
	  // alert(event.end);
	  var start = (new Date(event.start)).toISOString();
	var end = (new Date(event.end)).toISOString();   
   $.ajax({
    url: 'full_update_events.php',
    data: '&title='+event.title+'&start='+start+'&end='+end+'&id='+event.id,
    type: "POST",
    success: function(json) {
     /*alert("Updated Successfully");*/
    }
   });

}
   
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
  <?php 
  if($sessionid){?>
  <script>
    editpopup();
</script>
<?php } ?>
</body>
</html>
<? ob_flush(); ?>