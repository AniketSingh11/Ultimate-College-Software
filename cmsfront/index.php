<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//echo "test";

 $username = $_POST['username'];

 $password = $_POST['password'];

if(isset($username) && isset($password)){
	
	$month=date("m");
	$year=date("Y");
	
	if($m_value>5){
		$yearlist=mysql_query("SELECT * FROM year WHERE s_year=$year"); 
		$year=mysql_fetch_array($yearlist);
		$yid=$year['ay_id'];
}else if($m_value<=5){
	$yearlist=mysql_query("SELECT * FROM year WHERE e_year=$year"); 
		$year=mysql_fetch_array($yearlist);
		$yid=$year['ay_id'];
}

$query="SELECT * FROM student WHERE admission_number='$username' AND password='$password' AND ay_id=$yid";

$result=mysql_query($query);

$row=mysql_fetch_array($result);

$id=$row['ss_id'];
$ayid=$row['ay_id'];
$name=$row['firstname']." ".$row['middlename']." ".$row['lastname'];

$count=mysql_num_rows($result);

if($count==1)
{
//session_register("username");

$_SESSION['admin_no']=$username;
$_SESSION['uname']=$name;
$_SESSION['ss_id']=$id; 
$_SESSION['ay_id']=$ayid; 
$_SESSION['expiretime'] = time() + 600;
header("location:panel.php");

}else{
header("location:index.php?msg=error");

}

}

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login::Chirst Matric Higher Secondary School</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <a class="brand" href=""><span class="second">School/College Management</span></a>
        </div>
    </div>
    
        <div class="row-fluid">
    <div class="dialog">
        <div class="block">
            <p class="block-heading">Student Log In</p>
            <div class="block-body">
                <form action="" method="post">
                    <label>Admission No</label>
                    <input type="text" class="span12" name="username" required>
                    <label>Password</label>
                    <input type="password" class="span12" name="password" required>
                    <input type="submit" class="btn btn-primary pull-right" value="Log In" />
                    <label class="remember-me"><input type="checkbox"> Remember me</label>
                    <?php 
			$msg=$_GET['msg'];
			if($msg == "error"){?>
                    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
         invalid Username / Password!!!
    </div><?php }if($msg == "lterr"){?>
    				<div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">×</button>
         Session Time Expired, Please Login...
    </div><?php } if($msg=="lsucc"){?>
    				<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        You have successfully logged out!!!
    </div>
    			<?php } ?>	
                </form>
            </div>
        </div>        
    </div>
</div>

<script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
  </body>
</html>
<? ob_flush(); ?>

