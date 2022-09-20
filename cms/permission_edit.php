<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 

$pid=$_GET['pid'];
$type=$_GET['type'];

if (isset($_POST['submit']))
{
  $type=mysql_real_escape_string($_POST['type']);
  $ss_id=mysql_real_escape_string($_POST['ss_id']);
  $date=mysql_real_escape_string($_POST['date']);
  $reason=mysql_real_escape_string($_POST['reason']);
  $address=mysql_real_escape_string($_POST['address']);
  $st_id=mysql_real_escape_string($_POST['st_id']);
  $class_section=mysql_real_escape_string($_POST['class_section']);
  $leave_no_days=mysql_real_escape_string($_POST['leave_no_days']);
  $escort_name=mysql_real_escape_string($_POST['escort_name']);
  $escort_rship=mysql_real_escape_string($_POST['escort_rship']);
   $leave_given_by=mysql_real_escape_string($_POST['leave_given_by']);
   //echo '<pre>';
   // print_r($_POST);
   // echo '</pre>';
  if($type!=2){
  $qry=mysql_query("UPDATE permission SET date='$date',reason='$reason',address='$address',class_section='$class_section',leave_no_days=$leave_no_days,escort_name='$escort_name',escort_rship='$escort_rship',leave_given_by='$leave_given_by' WHERE p_id='$pid'");
  } else {

    $qry=mysql_query("UPDATE permission SET date='$date',reason='$reason',address='$address' WHERE p_id='$pid'");
  } 
  
  if($qry){
    $lid=$pid;
    $msg="succ";
    }
}   
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
    /*$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
                  $board=mysql_fetch_array($boardlist);*/
    
    ?>
      <!-- Begin of titlebar/breadcrumbs -->
    <div id="title-bar">
      <ul id="breadcrumbs">
        <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="permission.php" title="Admission">Permission</a></li>
        <li class="no-hover">Permission Edit</li> 
      </ul>
    </div> <!--! end of #title-bar -->
    
    <div class="shadow-bottom shadow-titlebar"></div>
    
    <!-- Begin of #main-content -->
    <div id="main-content">
      <div class="container_12">
      <div class="grid_12">
        <h1><a href="permission.php?" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Permission Edit <?php if($lid){ ?><a href="permission_prt.php?pid=<?php echo $lid;?>" target="_blank" title="Select Anothar One"><button class="btn btn-small btn-success"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Last Permission Slip Print </button></a> <?php } ?></h1>
                <?php //$msg=$_GET['msg'];
      if($msg=="succ"){?>     
            <div class="alert success"><span class="hide">x</span>Your Record Successfully edited!!!</div>
            <?php } ?>
                <?php if($_GET['pid']){ 
        $permissionlist2=mysql_query("SELECT * FROM permission WHERE p_id='$pid'"); 
                  $permission=mysql_fetch_array($permissionlist2);
                  
        $ss_id=$permission['ss_id'];
          $st_id=$permission['st_id'];
          
          if($type=="1"){
          $studentlist2=mysql_query("SELECT * FROM student WHERE ss_id='$ss_id'"); 
                  $row=mysql_fetch_array($studentlist2);
                  
                  $bid=$row['b_id'];              
              $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
                  $board=mysql_fetch_array($boardlist);
                  
                  $cid=$row['c_id'];              
              $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
                  $class=mysql_fetch_array($classlist);
                  
                  $sid=$row['s_id'];              
              $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
                  $section=mysql_fetch_array($sectionlist);
          
    ?>
          <div class="block-border">
          <div class="block-header">
            <h1>Permission for Student</h1><span></span>
          </div>
          <form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
                        <div class="_25">
              <p>
                                <label for="textfield">Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row['admission_number'];?>" readonly  />
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="<?php echo $row['firstname'];?>" readonly />
                            </p>
            </div>
                       
                       
                        <div class="_25">
              <p>
                                <label for="textfield">Board: <span class="error">*</span></label>
                                <input id="textfield" name="p_occup" class="required" type="text" value="<?php echo $board['b_name'];?>" readonly/>
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">Class And Section:</label>
                                <input id="textfield" name="p_income" type="text" value="<?php echo $class['c_name']."-".$section['s_name'];?>" readonly/>
                            </p>
            </div>
            <div class="_25">
              <p>
                                <label for="textfield">Number of leave days requried for </label>
                                <input id="" name="leave_no_days" type="text" value="<?php echo $permission['leave_no_days'];?>" />
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">Date of Application </label>
                                <input id="datepicker" name="date" type="text" value="<?php echo $permission['date'];?>" />
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">Reason: </label>
                                <input id="textfield" name="reason" type="text" value="<?php echo $permission['reason'];?>" />
                            </p>
            </div>
            <div class="_25">
              <p>
                                <label for="textfield">Escorts Name </label>
                                <input id="textfield" name="escort_name" type="text" value="<?php echo $permission['escort_name'];?>" />
                            </p>
            </div>
            <div class="_25">
              <p>
                                <label for="textfield">Relation Ship </label>
                                <input id="textfield" name="escort_rship" type="text" value="<?php echo $permission['escort_rship'];?>" />
                            </p>
            </div>
                        <div class="_50">
              <p>
                                <label for="textfield"> Address </label>
                                <textarea id="textarea" name="desc" rows="5" cols="40"><?php echo $permission['address'];?></textarea></p>
                            </p>
            </div>
             <div class="_25">
              <p>
                                <label for="textfield">Leave granted by </label>
                                <input id="textfield" name="leave_given_by" type="text" value="<?php echo $permission['leave_given_by'];?>" />
                                 <input type="hidden" class="medium" name="type" value="<?php echo "1";?>" >
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
                <?php } else if ($type=="2"){ 
        $stafflist21=mysql_query("SELECT * FROM staff WHERE st_id='$st_id'"); 
                  $staff=mysql_fetch_array($stafflist21);                
                 ?>
          
          <div class="block-border">
          <div class="block-header">
            <h1>Permission for Staff</h1><span></span>
          </div>
          <form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
                        <div class="_25">
              <p>
                                <label for="textfield">Staff ID : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $staff['staff_id'];?>" readonly  />
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="<?php echo $staff['fname'];?>" readonly/>
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="<?php echo $staff['lname'];?>" readonly/>
                            </p>
            </div>
                       <div class="_25">
              <p>
                                <label for="textfield">Date : </label>
                                <input id="datepicker" name="date" type="text" value="<?php echo $permission['date'];?>" />
                            </p>
            </div>
                        <div class="_25">
              <p>
                                <label for="textfield">Reason: </label>
                                <input id="textfield" name="reason" type="text" value="<?php echo $permission['reason'];?>" />
                            </p>
            </div>
                        <div class="_50">
              <p>
                                <label for="textfield"> Description: </label>
                                <textarea id="textarea" name="address" rows="5" cols="40"><?php echo $permission['address'];?></textarea></p>
                                 <input type="hidden" class="medium" name="type" value="<?php echo "2";?>" >
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
        <?php } 
        } 
    ?>
        <div class="clear height-fix"></div>
        </div>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->
    <?php include("includes/footer.php");
  ?>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
 <script type="text/javascript">
$().ready(function() {
  var validateform = $("#validate-form").validate();
  $( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });     
    $( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });        
});
</script>
</body>
</html>
<? ob_flush(); ?>