<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();
if(isset($_POST['submit'])){

 $username = $_POST['username'];

 $password = $_POST['password'];

if(isset($username) && isset($password)){
    
    $qry=mysql_query("SELECT * FROM admin_login WHERE email='$username' and password='$password'");
    $row=mysql_fetch_array($qry);
    $id=$row['id'];
    $name=$row['name'];
    $admin_type=$row['admin_type'];
    //die();
    //echo $row["user"]." ".$row["password"]."<br/>";
    
    $qry2=mysql_query("SELECT * FROM staff WHERE email='$username' and password='$password' AND s_type='Teaching'");
    $row2=mysql_fetch_array($qry2);
    
    $qry3=mysql_query("SELECT * FROM staff WHERE email='$username' and password='$password' AND s_type!='Teaching' and admin_permission='1'");
    $row3=mysql_fetch_array($qry3);
    
    $qry4=mysql_query("SELECT * FROM  others WHERE email='$username' AND password='$password' and admin_permission='1'");
    $row4=mysql_fetch_array($qry4);
    	
    if($_POST['username']==$row['email'] && $_POST['password']==$row['password'])
    {
        $classl = mysql_query("SELECT * FROM year");
        while ($yearlist = mysql_fetch_assoc($classl)){
            $year=$yearlist['ay_id'];
            $qry=mysql_query("UPDATE year SET status='0' WHERE ay_id='$year'");
        }
        $ayear=mysql_query("SELECT * FROM year ORDER BY ay_id DESC");
        $ay=mysql_fetch_array($ayear);
        $acyear=$ay['ay_id'];
        $qry=mysql_query("UPDATE year SET status='1' WHERE ay_id='$acyear'");
    
        $_SESSION['email']=$username;
        
        $_SESSION['uname']=$name;
        $_SESSION['u_id']=$id;
        $_SESSION['admin_type']=$admin_type;
        $_SESSION['log_type']="admin";
		$_SESSION['acyear']=$acyear;
    
        $_SESSION['expiretime'] = time() + 600;
        header("location:dashboard.php");
    }
   
    
    elseif($_POST['username']==$row2['email'] && $_POST['password']==$row2['password'])
    {
    $qry=mysql_query("SELECT * FROM staff WHERE email='$username' AND password='$password' AND s_type='Teaching'");
   
        $row1=mysql_fetch_array($qry);
        $stid=$row1['st_id'];
        $name=$row1['fname'];
        //echo $name=$row1['fname']." ".$row1['mname']." ".$row1['lname'];
        //die();
        //echo $row["user"]." ".$row["password"]."<br/>";
        	
        if($_POST['username']==$row1['email'] && $_POST['password']==$row1['password'])
        {
            $_SESSION['email']=$username;
            $_SESSION['uname']=$name;
            $_SESSION['stid']=$stid;
            $_SESSION['expiretime'] = time() + 600;
          //  $_SESSION['admin_type']=$admin_type;
            $_SESSION['log_type']="staff";
			$_SESSION['acyear']=$acyear;
            
            header("location:dashboard1.php");
        }else 
        {
            header("Location:index.php?msg=error2");
        }
    
    }
    
    elseif($_POST['username']==$row3['email'] && $_POST['password']==$row3['password']) 
    {
        $qry=mysql_query("SELECT * FROM staff WHERE email='$username' AND password='$password' AND s_type!='Teaching' and admin_permission='1'");
        
            $row1=mysql_fetch_array($qry);
            $stid=$row1['st_id'];
            $name=$row1['fname'];
          //  echo $name=$row1['fname']." ".$row1['mname']." ".$row1['lname'];
            //die();
            //echo $row["user"]." ".$row["password"]."<br/>";
             
            if($_POST['username']==$row1['email'] && $_POST['password']==$row1['password'])
            {
                $_SESSION['email']=$username;
                $_SESSION['uname']=$name;
                $_SESSION['stid']=$stid;
                $_SESSION['expiretime'] = time() + 600;
                //  $_SESSION['admin_type']=$admin_type;
                $_SESSION['log_type']="staff";
				$_SESSION['acyear']=$acyear;
        
                header("location:dashboard.php");
            }else
            {
                header("Location:index.php?msg=error3");
            }
        }
        
        elseif($_POST['username']==$row4['email'] && $_POST['password']==$row4['password'])
        {
            $qry=mysql_query("SELECT * FROM others WHERE email='$username' AND password='$password' and admin_permission='1'");
        
            $row1=mysql_fetch_array($qry);
            $stid=$row1['o_id'];
            $name=$row1['fname'];
            //  echo $name=$row1['fname']." ".$row1['mname']." ".$row1['lname'];
            //die();
            //echo $row["user"]." ".$row["password"]."<br/>";
             
            if($_POST['username']==$row1['email'] && $_POST['password']==$row1['password'])
            {
                $_SESSION['email']=$username;
                $_SESSION['uname']=$name;
                $_SESSION['stid']=$stid;
                $_SESSION['expiretime'] = time() + 600;
                //  $_SESSION['admin_type']=$admin_type;
                $_SESSION['log_type']="others";
				$_SESSION['acyear']=$acyear;
        
                header("location:dashboard.php");
            }else
            {
                header("Location:index.php?msg=error4");
            }
        }else{
            
        }
     
 

 
/*$query="SELECT * FROM admin_login WHERE email='$username' and password='$password'";

$result=mysql_query($query);

$row=mysql_fetch_array($result);

$id=$row['id'];
$name=$row['name'];

$count=mysql_num_rows($result);

if($count==1)
{
//session_register("username");

//$ayear=mysql_query("SELECT * FROM year ORDER BY ay_id DESC");
//$ay=mysql_fetch_array($ayear);

//$acyear=$ay['ay_id'];

$_SESSION['email']=$username;
$_SESSION['acyear']=$acyear;
$_SESSION['uname']=$name;
$_SESSION['u_id']=$id; 
$_SESSION['expiretime'] = time() + 600;
header("location:dashboard.php");

}else{
header("location:index.php?msg=error");

}*/





}

}
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  
  <!-- DNS prefetch -->
  <link rel=dns-prefetch href="//fonts.googleapis.com">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Login :: School/College Management Solution</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="css/960.fluid.css"> <!-- 960.gs Grid System -->
  <link rel="stylesheet" href="css/main.css"> <!-- Complete Layout and main styles -->
  <link rel="stylesheet" href="css/buttons.css"> <!-- Buttons, optional -->
  <link rel="stylesheet" href="css/lists.css"> <!-- Lists, optional -->
  <link rel="stylesheet" href="css/icons.css"> <!-- Icons, optional -->
  <link rel="stylesheet" href="css/notifications.css"> <!-- Notifications, optional -->
  <link rel="stylesheet" href="css/typography.css"> <!-- Typography -->
  <link rel="stylesheet" href="css/forms.css"> <!-- Forms, optional -->
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <link rel="stylesheet" href="css/charts.css"> <!-- Charts, optional -->
  <link rel="stylesheet" href="css/jquery-ui-1.8.15.custom.css"> <!-- jQuery UI, optional -->
  <!-- end CSS-->
  
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
  <!-- end Fonts-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body class="special-page">

  <!-- Begin of #container -->
  <div id="container">
  	
  	<!-- Begin of LoginBox-section -->
    <section id="login-box">
    	
    	<div class="block-border">
    		<div class="block-header">
    			<h1>Login</h1>
    		</div>
    		<form id="login-form" class="block-content form" action="" method="post">
            <?php 
			$msg=$_GET['msg'];
			if($msg == "error"){?>
            <div id="alertBox-generated" style="" class="alert error no-margin top">invalid Username / Password!!!</div><?php }if($msg == "lterr"){?>
            <div id="alertBox-generated" style="" class="alert error no-margin top">Session Time Expired, Please Login...</div><?php } if($msg=="lsucc"){?>
            <div id="alertBox-generated" style="" class="alert success no-margin top">You has been succesfully logout!!!</div><?php } ?>
    			<p class="inline-small-label">
					<label for="username">Username</label>
					<input type="text" name="username" value="" class="required">
				</p>
				<p class="inline-small-label">
					<label for="password">Password</label>
					<input type="password" name="password" value="" class="required">
				</p>
    			<p>
					<label><input type="checkbox" name="keep_logged" /> Auto-login in future.</label>
				</p>
				
				<div class="clear"></div>
				
				<!-- Begin of #block-actions -->
    			<div class="block-actions">
					<ul class="actions-left">
						<li><a class="button" name="recover_password" href="javascript:void(0);">Recover Password</a></li>
						<li class="divider-vertical"></li>
						<li><a class="button red" id="reset-login" href="javascript:void(0);">Cancel</a></li>
					</ul>
					<ul class="actions-right">
						<li><input type="submit" class="button" name="submit" value="Login"></li>
					</ul>
				</div> <!--! end of #block-actions -->
    		</form>
    		
    		
    	</div>
    </section> <!--! end of #login-box -->
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {
		
		/*
		 * Validate the form when it is submitted
		 */
		var validatelogin = $("#login-form").validate({
			invalidHandler: function(form, validator) {
      			var errors = validator.numberOfInvalids();
      			if (errors) {
        			var message = errors == 1
			          ? 'You missed 1 field. It has been highlighted.'
			          : 'You missed ' + errors + ' fields. They have been highlighted.';
        			$('#login-form').removeAlertBoxes();
        			$('#login-form').alertBox(message, {type: 'error'});
        			
      			} else {
       			 	$('#login-form').removeAlertBoxes();
      			}
    		}
		});
		
		jQuery("#reset-login").click(function() {
			validatelogin.resetForm();
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
  
</body>
</html>
<? ob_flush(); ?>