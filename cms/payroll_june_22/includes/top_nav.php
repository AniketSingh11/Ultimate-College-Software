<nav id="top-bar" class="collapse top-bar-collapse">

		<ul class="nav navbar-nav pull-left">
			<li class="">
				<a href="../dashboard.php">
					<i class="fa fa-home"></i> 
					Back To Main Admin Panel
				</a>
			</li>

			<li class="dropdown">
		    	<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
		        	Basic Settings <span class="caret"></span>
		    	</a>

		    	<ul class="dropdown-menu" role="menu">
			        <li><a href="loan_type.php"><i class="fa fa-user"></i>&nbsp;&nbsp;Loan types</a></li>
			        <li><a href="leave_type.php"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Leave Types</a></li>
			        <!--<li class="divider"></li>
			        <li><a href="javascript:;"><i class="fa fa-tasks"></i>&nbsp;&nbsp;Example #3</a></li>-->
		    	</ul>
		    </li>
		    
		</ul>

		<ul class="nav navbar-nav pull-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
					<i class="fa fa-user"></i>
		        	<?php echo $user;?>
		        	<span class="caret"></span>
		    	</a>

		    	<ul class="dropdown-menu" role="menu">
			        <li>
			        	<a href="#">
			        		<i class="fa fa-user"></i> 
			        		&nbsp;&nbsp;My Profile
			        	</a>
			        </li>
			        <!--<li>
			        	<a href="#">
			        		<i class="fa fa-calendar"></i> 
			        		&nbsp;&nbsp;My Calendar
			        	</a>
			        </li>
			        <li>
			        	<a href="#">
			        		<i class="fa fa-cogs"></i> 
			        		&nbsp;&nbsp;Settings
			        	</a>
			        </li>-->
			        <li class="divider"></li>
			        <li>
			        	<a href="logout.php">
			        		<i class="fa fa-sign-out"></i> 
			        		&nbsp;&nbsp;Logout
			        	</a>
			        </li>
		    	</ul>
		    </li>
		</ul>

	</nav><!-- /#top-bar -->