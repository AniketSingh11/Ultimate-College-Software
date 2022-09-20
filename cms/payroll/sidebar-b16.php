<div id="sidebar-wrapper" class="collapse sidebar-collapse">
	
		 <div id="search">
			 <form name="search"  action="" method="post"/>
				 <input class="form-control input-sm" type="text" name="search" placeholder="Search..." autocomplete="off" />

				 <button type="submit" id="search-btn" class="btn"><i class="fa fa-search"></i></button>
			 </form> 		
		 </div>  <!-- #search -->
	
		 <nav id="sidebar">		
			
			 <ul id="main-nav" class="open-active">			
				<li>				
					 <a href="dashboard.php">
						 <img src="../img/icons/packs/fugue/24x24/home.png"/>
						Payroll Dashboard
					 </a>				
				 </li>
                 <li>				
					 <a href="emp_details_list.php">
						 <img src="../img/icons/packs/fugue/24x24/user-business-boss.png"/>
						Employee Details
					 </a>				
				 </li>
                 <li>				
					 <a href="ow_list.php">
						<img src="../img/icons/packs/fugue/24x24/user.png"/>
						Other Workers Details
					 </a>				
				 </li>
                 <li>				
					 <a href="driver_list.php">
						<img src="../img/icons/packs/fugue/16x16/traffic-light--plus.png" width="24" height="24"/>
						Driver Details
					 </a>				
				 </li>
                 <li>				
					 <a href="allw_ded_list.php">
						 <img src="../img/icons/packs/fugue/24x24/target.png"/>
						Allowance & Deduction
					 </a>				
				 </li>
                 <li>				
					 <a href="common_deduction.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>">
						 <img src="../img/icons/packs/fugue/24x24/box-label.png"/>
						Common Deduction
					 </a>				
				 </li>
				 <li class="dropdown">
					 <a href="javascript:;">
						 <img src="../img/icons/packs/fugue/24x24/battery-charge.png"/>
						Salary Details
						 <span class="caret"></span>
					 </a>
					
					 <ul class="sub-nav">
                      <li>
							 <a href="monthly_salary.php?m=<?php echo date("m");?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>">
								<img src="../img/icons/packs/fugue/16x16/credit-card-green.png"/>
								Monthly Salary
							 </a>
						 </li>
                          <li>
							 <a href="emp_salary_detail.php">
								 <img src="../img/icons/packs/fugue/16x16/user-share.png"/>
								 Employee Salary Lists
							 </a>
						 </li>
                         <li>
							 <a href="ow_salary_detail.php">
								 <img src="../img/icons/packs/fugue/16x16/user-share.png"/>
								 Other Worker Salary Lists
							 </a>
						 </li>	
                         <li>
							 <a href="driver_salary_detail.php">
								 <img src="../img/icons/packs/fugue/16x16/user-share.png"/>
								 Driver Salary Lists
							 </a>
						 </li>	
                         <li>
							 <a href="salary_report.php">
								<img src="../img/icons/packs/fugue/16x16/credit-card-green.png"/>
								Salary Bank report 
							 </a>
						 </li>	
                         <li>
							 <a href="salary_report_full.php">
								<img src="../img/icons/packs/fugue/16x16/credit-card-green.png"/>
								Salary Overall report 
							 </a>
						 </li>
                         <li>
							 <a href="salary_inhand.php">
								<img src="../img/icons/packs/fugue/16x16/credit-card-green.png"/>
								Salary In Hand report 
							 </a>
						 </li>	
					 </ul>										
				 </li>
				  <li class="dropdown">
					 <a href="javascript:;">
						 <img src="../img/icons/packs/fugue/24x24/lifebuoy.png"/>
						Loan Details
						 <span class="caret"></span>
					 </a>					
					 <ul class="sub-nav">
						 <li>
							 <a href="loan_list.php">
								 <img src="../img/icons/packs/fugue/16x16/umbrella--plus.png"/>
								 Loan Details
							 </a>
						 </li>						 	
					 </ul>			
				 </li>
                <li class="dropdown">
					 <a href="javascript:;">
						 <img src="../img/icons/packs/fugue/24x24/calendar-blue.png"/>
						Leave Details
						 <span class="caret"></span>
					 </a>					
					 <ul class="sub-nav">                     
						 <li>
							 <a href="leave_list.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>">
								<img src="../img/icons/packs/fugue/16x16/leaf--arrow.png"/>
								Leave List
							 </a>
						 </li>
                         <li>
							 <a href="leave_type.php">
								 <img src="../img/icons/packs/fugue/16x16/calendar-insert.png"/>
								Yearly Leave 
							 </a>
						 </li>                         
						 <li>
							 <a href="emp_leave_list.php">
								 <img src="../img/icons/packs/fugue/16x16/users.png"/>
								Employee Leave Lists
							 </a>
						 </li>
                         <li>
							 <a href="ow_leave_list.php">
								 <img src="../img/icons/packs/fugue/16x16/user-detective.png"/>
								Other Worker Leave Lists
							 </a>
						 </li>	
                         <li>
							 <a href="driver_leave_list.php">
								 <img src="../img/icons/packs/fugue/16x16/traffic-cone--plus.png"/>
								Driver Leave Lists
							 </a>
						 </li>	
					 </ul>		
				 </li> 
                 <li>				
					 <a href="advance_list.php">
						 <img src="../img/icons/packs/fugue/24x24/battery.png"/>
						Advance Salary Manage
					 </a>				
				 </li> 
                 <li class="dropdown">
					 <a href="javascript:;">
						 <img src="../img/icons/packs/fugue/24x24/calendar-blue.png"/>
						EPF &amp; ESI Management
						 <span class="caret"></span>
					 </a>					
					 <ul class="sub-nav">                     
						 <li>
							 <a href="mcontribution.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>">
								<img src="../img/icons/packs/fugue/16x16/leaf--arrow.png"/>
								Management Contribution
							 </a>
						 </li>
                         <li>
							 <a href="esi_pf_salary.php?m=<?php echo date("m");?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>">
								<img src="../img/icons/packs/fugue/16x16/credit-card-green.png"/>
								Monthly ESI and PF List
							 </a>
						 </li>
                         <li>
							 <a href="emp_esi_pf_detail.php">
								 <img src="../img/icons/packs/fugue/16x16/user-share.png"/>
								 Employee ESI and PF Lists
							 </a>
						 </li>
                         <li>
							 <a href="ow_esi_pf_detail.php">
								 <img src="../img/icons/packs/fugue/16x16/user-share.png"/>
								 Other Worker ESI and PF 
							 </a>
						 </li>
                         <li>
							 <a href="driver_esi_pf_detail.php">
								 <img src="../img/icons/packs/fugue/16x16/user-share.png"/>
								 Driver ESI and PF 
							 </a>
						 </li>
                         <!--<li>
							 <a href="yearly.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>">
								 <img src="../img/icons/packs/fugue/16x16/calendar-insert.png"/>
								Yearly EPF &amp; ESI 
							 </a>
						 </li>                         
						 <li>
							 <a href="emp_leave_list.php">
								 <img src="../img/icons/packs/fugue/16x16/users.png"/>
								Employee Leave Lists
							 </a>
						 </li>
                         <li>
							 <a href="ow_leave_list.php">
								 <img src="../img/icons/packs/fugue/16x16/user-detective.png"/>
								Other Worker Leave Lists
							 </a>
						 </li>	
                         <li>
							 <a href="driver_leave_list.php">
								 <img src="../img/icons/packs/fugue/16x16/traffic-cone--plus.png"/>
								Driver Leave Lists
							 </a>
						 </li>	-->
					 </ul>		
				 </li> 
                 <li>				
					 <a href="relive_details_list.php">
						 <img src="../img/icons/packs/fugue/24x24/user-business-boss.png"/>
						Relieve Management
					 </a>				
				 </li> 
			 </ul>
					
		 </nav>  <!-- #sidebar -->

	 </div>  <!-- /#sidebar-wrapper -->