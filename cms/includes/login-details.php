<?php if($_SESSION['log_type']=="admin"){?>
<section id="login-details">
    		<img class="img-left framed" src="img/misc/avatar_small.png" alt="Hello Admin">
    		<h3>Logged in as</h3>
    		<h2><a class="user-button" href="javascript:void(0);"><?php echo $user;?>&nbsp;<span class="arrow-link-down"></span></a></h2>
    		<ul class="dropdown-username-menu">
    			<li><a href="#">Profile</a></li>
    			<li><a href="setting.php">Settings</a></li>
    			<li><a href="#">Messages</a></li>
                <li><a href="download_database.php">Backup</a></li>
    			<li><a href="logout.php">Logout</a></li>
    		</ul>
    		
    		<div class="clearfix"></div>
 </section>
 <?php }else{ ?>
 <section id="login-details">
    		<img class="img-left framed" src="img/misc/avatar_small.png" alt="Hello Admin">
    		<h3>Logged in as</h3>
    		<h2><a class="user-button" href="javascript:void(0);"><?php echo $user;?>&nbsp;<span class="arrow-link-down"></span></a></h2>
    		<ul class="dropdown-username-menu">
    	<?php $qry=mysql_query("SELECT * FROM staff WHERE  st_id='$stid' and admin_permission='1'");
    	 
    	
    	$log_type=$_SESSION['log_type'];
    	if($log_type=="others" || mysql_num_rows($qry)!=0){ ?>
    		    <li><a href="dashboard.php">Admin Profile</a></li>
    		    <?php } ?>
    			<li><a href="">Profile</a></li>
    			<li><a href="ssetting.php">Settings<?=$admin_type?></a></li>
    			<li><a href="">Messages</a></li>
    			
    			<li><a href="logout.php">Logout</a></li>
    		</ul>
    		
    		<div class="clearfix"></div>
 </section>
 <?php } ?>