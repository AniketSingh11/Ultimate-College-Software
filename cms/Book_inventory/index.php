<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();
if(isset($_POST['submit'])){

echo $username = $_POST['username'];

echo $password = $_POST['password'];

if(isset($username) && isset($password)){

$query="SELECT id FROM admin_login WHERE username='$username' and password='$password'";

$result=mysql_query($query);

$row=mysql_fetch_array($result);

$id=$row['id'];

$count=mysql_num_rows($result);

if($count==1)

{

//session_register("username");

$_SESSION['name']=$username;
$_SESSION['u_id']=$id;
 
header("location:dashboard.php");

}else{
header("location:index.php?msg=error");

}

}

}

?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<title>Book Inventory - Login</title>

	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="author" content="" />		
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	
	<link rel="stylesheet" href="stylesheets/reset.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="stylesheets/text.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="stylesheets/buttons.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="stylesheets/theme-default.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="stylesheets/login.css" type="text/css" media="screen" title="no title" />
</head>

<body>

<div id="login">
	<h1>Dashboard</h1>
	<div id="login_panel">
		<form action="" method="post" accept-charset="utf-8">		
			<div class="login_fields">
				<div class="field">
					<label for="email">Username :</label>
					<input type="text" name="username" value="" id="username" tabindex="1" placeholder="Enter Your Username" required />		
				</div>
				
				<div class="field">
					<label for="password">Password :<!--<small><a href="javascript:;">Forgot Password?</a></small>--></label>
					<input type="password" name="password" value="" id="password" tabindex="2" placeholder="Enter Your  Password" required />			
				</div>
			</div> <!-- .login_fields -->
			
			<div class="login_actions">
				<button type="submit" class="btn btn-primary" tabindex="3" name="submit">Login</button>
                <span class="error">
                <?php 
				 	$msg = $_GET['msg'];
				 	if($msg === "error"){
               			echo  "Invalid Username / Password";
					}else if($msg ==="lerror"){
						echo "You are not authorised to access this page!";
					}?>
                  </span>
                  <?php if($msg === "succ"){ ?>
                  <span class="succ">You are successfully logged out</span>
                  <?php } ?>
			</div>
		</form>
	</div> <!-- #login_panel -->		
</div> <!-- #login -->

<script src="javascripts/all.js"></script>


</body>
</html>
<? ob_flush(); ?>