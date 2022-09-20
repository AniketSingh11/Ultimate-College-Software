<div id="topNav">
		 <ul>
		 	<li>
		 		<a href="">Board : <?php echo $boardname; ?> | Academy Year : <strong><?php echo $acyear_name;?></strong> | <strong> <?php echo $user;?></strong></a>
		 		
		 		<!--<div id="menuProfile" class="menu-container menu-dropdown">
					<div class="menu-content">
						<ul class="">
							<li><a href="javascript:;">Edit Profile</a></li>
							<li><a href="javascript:;">Edit Settings</a></li>
							<li><a href="user.php">Password Change</a></li>
						</ul>
					</div>
				</div>-->
	 		</li>
		 	<!--<li><a href="javascript:;">Upgrade</a></li>-->
		 	<li><a href="../logout.php">Logout</a></li>
		 </ul>
	</div>
    <div id="quickNav">
		<ul>
			<li class="quickNavMail">
				<a href="#menuAmpersand" class="menu"><span class="icon-book"></span></a>		
				
				<!--<span class="alert">3</span>-->		

				<div id="menuAmpersand" class="menu-container quickNavConfirm">
					<div class="menu-content cf">							
						
						<div class="qnc qnc_confirm">
							
							<h3>Low Qty of Book/Thinks</h3>
					
                    <?php 
							$qry=mysql_query("SELECT * FROM book Where type='B' AND b_qtyleft<'10' LIMIT 0,5");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{?>
							<div class="qnc_item">
								<div class="qnc_content">
									<span class="qnc_title"><?php echo $row['b_name'];?></span>
									<span class="qnc_preview">This One have very low Qty!!!<br/> <strong> Quantity : <?php echo $row['b_qtyleft'];?></strong></span>
								</div>
								
								<div class="qnc_actions">						
									<a href="book_count.php?bid<?php echo $row['b_id'];?>"><button class="btn btn-primary btn-small">View</button></a>
								</div>
							</div>	
                            
                            <?php } ?>						
							<a href="book_count.php" class="qnc_more">View all Notification</a>
															
						</div>
					</div>
				</div>
			</li>
			<li class="quickNavNotification">
				<a href="#menuPie" class="menu"><span class="icon-chat"></span></a>
				
				<div id="menuPie" class="menu-container">
					<div class="menu-content cf">					
						
						<div class="qnc">
							
							<h3>Notebook low Quantity</h3>
                            <?php 
							$qry=mysql_query("SELECT * FROM notebook_purchese WHERE n_qtyleft<'10' LIMIT 0,5");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{?>
					
							<a href="javascript:;" class="qnc_item">
								<div class="qnc_content">
									<span class="qnc_title"><?php echo $row['n_name']; ?></span>
									<span class="qnc_preview">This notebook have very low qty!!!<br/> <strong>Quantity : <?php echo $row['n_qtyleft']; ?></strong></span>
								</div> 
							</a>
                            <?php } ?>
							
							<a href="notebook_count.php" class="qnc_more">View all Notification</a>
							
						</div> 
					</div>
				</div>				
			</li>
		</ul>		
	</div>