<?php $monthno=date("m");
				 			$qry12=mysql_query("SELECT * FROM month WHERE m_no=$monthno AND ay_id=$acyear");
							$monthsw=mysql_fetch_array($qry12);
							
							 
							if($_SESSION['admin_type']=="1")
							{
							$query1="select * from  subadmin_accesspage where subadmin_id='$_SESSION[u_id]' and log_type='admin'";
							$res1=mysql_query($query1);
							$permissions_check=array();
							$permissions_submenu=array();
							while($row1=mysql_fetch_array($res1))
							{
							    if($row1["sub_menuname"]!=""){
							        $submenu=explode(",",$row1["sub_menuname"]);
							    
							        foreach($submenu as $val)
							        {
							            array_push($permissions_submenu,$val);
							        }
							        	
							    }
							   array_push($permissions_check, $row1["menu_name"]);
							}
							}
							
							if($_SESSION['log_type']=="staff")
							{
							    $query1="select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
							    $res1=mysql_query($query1);
							    $permissions_check=array();
							    $permissions_submenu=array();
							    while($row1=mysql_fetch_array($res1))
							    {
							        if($row1["sub_menuname"]!=""){
                                $submenu=explode(",",$row1["sub_menuname"]);
                                
                                foreach($submenu as $val)
                                {
                                    array_push($permissions_submenu,$val);
                                }
							      
							        }
							        array_push($permissions_check, $row1["menu_name"]);
							    }
							}
							
							
							
							if($_SESSION['log_type']=="others")
							{
							    $query1="select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
							    $res1=mysql_query($query1);
							    $permissions_check=array();
							    while($row1=mysql_fetch_array($res1))
							    {
							
							        array_push($permissions_check, $row1["menu_name"]);
							    }
							}
							
						
							?>
<nav id="nav">
	    	<ul class="menu collapsible shadow-bottom">
	    	
	     	   <li><a href="dashboard.php"><img src="img/icons/packs/fugue/16x16/dashboard.png">Dashboard</a></li> 
	     	   <?php
				if($_SESSION['admin_type']=="0"){?>
			   <li><a href="subadmin_add.php"><img src="img/icons/packs/fugue/16x16/user-silhouette-question.png"> User Permission</a></li>
			   <?php } if($_SESSION['admin_type']=="0"|| in_array("Main admissions", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/umbrella--exclamation.png">Main Admissions <span class="badge gray">5</span></a>
                	<ul class="sub">
                    	<li><a href="pre_admission.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Pre Admission</a></li>
                        <li><a href="board_select_pre.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Pre Admission Selection</a></li>
                        <li><a href="admission.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Admission</a></li>
                        <li><a href="admission_imp.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">New Student import</a></li>
	    				<li><a href="board_select_admin_select.php"><img src="img/icons/packs/fugue/16x16/cake--plus.png">Student Allocation</a></li>
	    			</ul>
                </li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Fees Management", $permissions_check)){?>
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/blog-posterous.png">Fees Management<span class="badge red">7</span></a>
	    			<ul class="sub">
	    				<li><a href="board_select_fees.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Fees Payment</a></li>
                        <li><a href="board_select_feesinvoice.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Fees Payment Invoice</a></li>
                        <li><a href="board_select_chequeinvoice.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Cheque payment List</a></li>
                        <li><a href="board_select_fundinvoice.php"><img src="img/icons/packs/fugue/16x16/hand-share.png">Student Discount Funds</a></li>
                        <li><a href="fdiscount.php"><img src="img/icons/packs/fugue/16x16/burn--plus.png">Discount Category</a></li>
                        <li><a href="fgroup.php"><img src="img/icons/packs/fugue/16x16/category.png">Fees Group</a></li>
                        <li><a href="board_select_feesrate.php"><img src="img/icons/packs/fugue/16x16/chart--arrow.png">Fees Rate</a></li>
                        <li><a href="board_select_differed.php"><img src="img/icons/packs/fugue/16x16/abacus.png">Differed Income List</a></li>    								
                     </ul>
	    		</li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Finance", $permissions_check)){?>
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/system-monitor-network.png">Finance<span class="badge red">8</span></a>
	    			<ul class="sub">
                    	<li><a href="income_category.php"><img src="img/icons/packs/fugue/16x16/inbox--plus.png">Income Category</a></li>
						<li><a href="income_mng.php"><img src="img/icons/packs/fugue/16x16/inbox-document-text.png">Income Management</a></li>
	    				<li><a href="exponses_category.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Expenses Category</a></li>
                        <li><a href="exponses_subcategory.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Expenses Sub Category</a></li>
                        <li><a href="exponse_mng.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Expenses Management</a></li>
                        <li><a href="bank_account.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Bank Account List</a></li>
                        <li><a href="bdeposit_mng.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Bank Deposit Manage</a></li>
                        <li><a href="bwithdrawl_mng.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Bank Withdrawl Manage</a></li>
                        <li><a href="expense_allowancelist.php"><img src="img/icons/packs/fugue/16x16/user-thief-baldie.png">Daily Allowance List</a></li>
                        <li><a href="balance_sheet.php"><img src="img/icons/packs/fugue/16x16/balance--arrow.png">Balance Sheet</a></li>
                     </ul>
	    		</li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("Student Management", $permissions_check)){?>                 
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/users.png">Student's<span class="badge orange">4</span></a>
	    			<ul class="sub">
	    				<li><a href="board_select_stu.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Management</a></li>
	    				<li><a href="board_select_att.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">Student's Attendance Management</a></li>
                        <li><a href="student_overall.php"><img src="img/icons/packs/fugue/16x16/cutter--arrow.png">Overall Student's List</a></li>
                    </ul>
	    		</li>
                <?php }  
				if($_SESSION['admin_type']=="0" || in_array("Staff Management", $permissions_check)){?>  
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/user-detective.png">Staff Management<span class="badge orange">3</span></a>
	    			<ul class="sub">
	    				<li><a href="staff.php"><img src="img/icons/packs/fugue/16x16/user--arrow.png">Staff Management</a></li>
	    				<li><a href="board_select_cstaff.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Classwise Staff List</a></li>
                      <!--   <li><a href="satt_mng.php?mid=<?php echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Staff Attendance Management</a></li> -->
	    			<li><a href="satt_mng.php"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Staff Attendance Management</a></li>
	    			</ul>
	    		</li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("Others Management", $permissions_check)){?>
                                <li>
                	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/user-detective.png">Other Workers<span class="badge orange">2</span></a>
                	    			<ul class="sub">
                	    				<li><a href="others_categorylist.php"><img src="img/icons/packs/fugue/16x16/user--arrow.png">Other Workers Category</a></li>
                	    				<li><a href="others_list.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Other Workers List</a></li>
                                    <!--    <li><a href="owatt_mng.php?mid=<?php echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Other Workers Attendance</a></li> -->
                                        <li><a href="owatt_mng.php"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Other Workers Attendance</a></li>
                	    			</ul>
                	    		</li>
                                <?php } 
				if($_SESSION['admin_type']=="0"|| in_array("Class Timetable Manage", $permissions_check)){?>     
           <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/table.png">Class TimeTable Manage<span class="badge orange">4</span></a>
                <ul class="sub">
	    				<li><a href="day.php"><img src="img/icons/packs/fugue/16x16/calendar-day.png">Day management</a></li>
                        <li><a href="peroid.php"><img src="img/icons/packs/fugue/16x16/sport-cricket.png">Extra Period management</a></li>
	    				<li><a href="board_select_table.php"><img src="img/icons/packs/fugue/16x16/table-share.png">Time Table</a></li>
                        <li><a href="board_select_staff_free.php"><img src="img/icons/packs/fugue/16x16/table-share.png">Staff Free Hours</a></li>
	    			</ul>
                </li><?php }
				if($_SESSION['admin_type']=="0" || in_array("Parent Management", $permissions_check)){?>
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/parents.png">Parent's<span class="badge red">2</span></a>
	    			<ul class="sub">
	    				<li><a href="board_select_parent.php"><img src="img/icons/packs/fugue/16x16/photo-album--arrow.png">parants Management</a></li>
                        <li><a href="sibling_mng.php"><img src="img/icons/packs/fugue/16x16/users.png">Sibling Management</a></li>
	    			</ul>
	    		</li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Exam Management", $permissions_check)){?>
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Exam Management<span class="badge orange">10</span></a>
	    			<ul class="sub"> 
                    	<li><a href="board_select_test.php"><img src="img/icons/packs/fugue/16x16/pencil-ruler.png">Class Test Assign</a></li>
                        <li><a href="board_select_homework.php"><img src="img/icons/packs/fugue/16x16/home--pencil.png">Home Work Assign</a></li>                  
                             <li><a href="exam.php"><img src="img/icons/packs/fugue/16x16/pencil-color.png">Exam List</a></li>
	    				<li><a href="board_select_examtable.php"><img src="img/icons/packs/fugue/16x16/clock.png">Exams time table</a></li>
	    				 <?php if($_SESSION['admin_type']=="0" || (in_array("Subject Management", $permissions_check) && $roll!="Principal")){ ?>
	    				<li><a href="board_select_exam.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Add Exam Results</a></li><?php }?>
                        <li><a href="result_mng1.php"><img src="img/icons/packs/fugue/16x16/sofa--pencil.png">Overall Exam Results</a></li>
                        <li><a href="rank_card.php"><img src="img/icons/packs/fugue/16x16/rainbow.png">Progress Card</a></li>
                        <li><a href="rankcard_status.php"><img src="img/icons/packs/fugue/16x16/eye--plus.png">Progress Visit Status</a></li>
                        <li><a href="board_select_analysis.php"><img src="img/icons/packs/fugue/16x16/chart-up-color.png">Exam Results Analysis</a></li>
                        <li><a href="board_select_sanalysis.php"><img src="img/icons/packs/fugue/16x16/dashboard--plus.png">Studentwise Results Analysis</a></li>
	    			</ul>
	    		</li>
	    		<?php }if($_SESSION['admin_type']=="0"){?>
                <li><a href="permission.php"><img src="img/icons/packs/fugue/16x16/rocket-fly.png">Permission Management</a></li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Certificates", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/certificate.png">Certificates<span class="badge gray">8</span></a>
                	<ul class="sub">
                	  <li><a href="quotation_list.php"><img src="img/icons/packs/fugue/16x16/address-book-open.png">Proposal Management</a></li>
	    				<li><a href="bonafide.php"><img src="img/icons/packs/fugue/16x16/address-book-open.png">Bonafide Certificate</a></li>
	    				<li><a href="community.php"><img src="img/icons/packs/fugue/16x16/color-adjustment-red.png">Community Certificate</a></li>
                        <li><a href="conduct.php"><img src="img/icons/packs/fugue/16x16/direction.png">Conduct Certificate</a></li>
	    				<li><a href="c_attend.php"><img src="img/icons/packs/fugue/16x16/alarm-clock-select-remain.png">Attendance Certificate</a></li>
                        <li><a href="board_select_marksheet.php"><img src="img/icons/packs/fugue/16x16/medal-bronze-red.png">Marklist Certificate</a></li>                       
                        <li><a href="board_select_tc11.php"><img src="img/icons/packs/fugue/16x16/monitor-wallpaper.png">Transfer Certificate</a></li>
	    				<!--<li><a href="board_select_tcicse.php"><img src="img/icons/packs/fugue/16x16/sort-date.png">Transfer Certificate ICSE</a></li>
                        <li><a href=""><img src="img/icons/packs/fugue/16x16/target--arrow.png">Grade Certificate</a></li>-->
                        <li><a href="board_select_hallticket.php"><img src="img/icons/packs/fugue/16x16/ticket--arrow.png">Hall Ticket</a></li>
                        <li><a href="certificates_tuitionfees.php"><img src="img/icons/packs/fugue/16x16/money-coin.png">Tuition Fees Certificate</a></li>
                        <li><a href="exp_certificate_list.php"><img src="img/icons/packs/fugue/16x16/user-silhouette-question.png">Experience  Certificate</a></li>
	    			</ul>
                </li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("ID Card", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/card-address.png">ID Card Generator<span class="badge red">4</span></a>
                    <ul class="sub">
                            <li><a href="board_select_idcard3.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Overall ID Cards</a></li>
                            <li><a href="board_select_idcard.php"><img src="img/icons/packs/fugue/16x16/cards-address.png">Classwise ID Cards</a></li>
                            <li><a href="board_select_idcard1.php"><img src="img/icons/packs/fugue/16x16/grid-snap-dot.png">selected Student ID Cards</a></li>
                             <li><a href="board_select_idcard2.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Single Student ID Card</a></li>
                        </ul>
                </li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("Mobile SMS", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/speaker.png">Mobile SMS Manage<span class="badge red">2</span></a>
                    <ul class="sub">
                            <li><a href="sms_mng.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">OverAll SMS Management</a></li>
                            <li><a href="sms_specific_mng.php"><img src="img/icons/packs/fugue/16x16/burn--pencil.png">Specific SMS Management</a></li>
                        </ul>
                </li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("Circular and Events", $permissions_check)){?>
	    		<li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/speaker.png">Circular and Events<span class="badge red">3</span></a>
                    <ul class="sub">
                            <li><a href="circular.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Circular Management</a></li>
                            <li><a href="event.php"><img src="img/icons/packs/fugue/16x16/burn--pencil.png">Events Management</a></li>
                             <li><a href="news.php"><img src="img/icons/packs/fugue/16x16/newspaper.png">NEWS Management</a></li>
                        </ul>
                </li>
                <?php } 
				if($_SESSION['admin_type']=="0"){?>
	    		<li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/remote-control.png">Basic Settings<span class="badge gray">5</span></a>
                	<ul class="sub">
                    	<li><a href="board.php"><img src="img/icons/packs/fugue/16x16/block.png">Board Settings</a></li>
	    				<li><a href=""><img src="img/icons/packs/fugue/16x16/switch.png">General Settings</a></li>
	    				<li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">Email and Contacts</a></li>
                        <li><a href=""><img src="img/icons/packs/fugue/16x16/acorn.png">Logo settings</a></li>
                        <li><a href="year.php"><img src="img/icons/packs/fugue/16x16/calendar-list.png">Academic Year and Month List</a></li>
	    			</ul>
                </li>
                 <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/paper-bag--plus.png">Letterhead<span class="badge gray">2</span></a>
                <ul class="sub">
                     <li><a href="letterpad_add.php"><img src="img/icons/packs/fugue/16x16/palette--plus.png">Add Content</a></li>
                  <li><a href="letterpad_list.php"><img src="img/icons/packs/fugue/16x16/paper-bag-recycle.png">Content List</a></li>	
                      </ul>
                      </li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Standard and Section", $permissions_check)){?> 
               <li><a href="standard.php"><img src="img/icons/packs/fugue/16x16/solar-panel.png">Standard and Section Management</a></li>
               <?php }
			    if($_SESSION['admin_type']=="0" || in_array("Subject Management", $permissions_check)){?>    
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/system-monitor.png">Subject Management<span class="badge orange">4</span></a>
                <ul class="sub">
                  <?php if($_SESSION['admin_type']=="0" || (in_array("Subject Management", $permissions_check) && $roll!="Principal")){ ?>
	    				<li><a href="board_select1.php"><img src="img/icons/packs/fugue/16x16/address-book-open.png">Classwise Subject</a></li>
                        <li><a href="board_select2.php"><img src="img/icons/packs/fugue/16x16/beaker--plus.png">Staff Assign</a></li>
                        <?php }?>
                        <li><a href="stafflist.php"><img src="img/icons/packs/fugue/16x16/bamboos.png">Staffwise Assign</a></li>
	    				<li><a href="board_select_cstaff.php"><img src="img/icons/packs/fugue/16x16/blog--arrow.png">Classwise Staff</a></li>
	    			</ul>
                </li><?php }
				if($_SESSION['admin_type']=="0" || in_array("Student Promotion", $permissions_check)){?>
                                
                <li>               
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/users.png">Student's Promotion<span class="badge orange">2</span></a>
	    			<ul class="sub">
	    				<li><a href="promotion_student.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Selected</a></li>
	    				<li><a href="promotion_shuffle_student.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Shuffle</a></li> 
                    </ul>
	    		</li>
                <?php } if($_SESSION['admin_type']=="0"){?>
                <li><a href=""><img src="img/icons/packs/fugue/16x16/clipboard-paste-image.png">Syllabus Management <span class="badge blue">3</span></a>
                	<ul class="sub">
                    	<li><a href="board_syllabus.php"><img src="img/icons/packs/fugue/16x16/block.png">Add Syllabus To Class</a></li>
	    				<li><a href="board_syllabus1.php"><img src="img/icons/packs/fugue/16x16/switch.png">Assign Syllabus to Staff</a></li>
	    				<li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">Syllabus Covered</a></li>
	    			</ul>
                </li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("Vehicle management", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/traffic-light--arrow.png">Vehicle management<span class="badge gray">10</span></a>
                	<ul class="sub">
                	 <?php if($_SESSION['admin_type']=="0" || (in_array("Subject Management", $permissions_check) && $roll!="Principal")){ ?>
                    	<li><a href="board_select_busfees.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">BusFees Payment</a></li><?php }?>
                        <li><a href="board_select_bfeesinvoice.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">BusFees Payment Invoice</a></li>
                    	<li><a href="vehicle.php"><img src="img/icons/packs/fugue/16x16/block.png">Vehicle Master</a></li>
	    				<li><a href="driver.php"><img src="img/icons/packs/fugue/16x16/user-thief-baldie.png">Driver details</a></li>
                       <!--   <li><a href="datt_mng.php?mid=<?php echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Driver Attendance</a></li>-->
                        <li><a href="datt_mng.php"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Driver Attendance</a></li>
	    				<li><a href="route.php"><img src="img/icons/packs/fugue/16x16/map.png">Route Master</a></li>
                        <li><a href="stopping_mng.php"><img src="img/icons/packs/fugue/16x16/marker--arrow.png">Route stop details</a></li>
                        <li><a href="bus_feesrate.php"><img src="img/icons/packs/fugue/16x16/target--plus.png">Bus Fees Rate</a></li>
                        <li><a href="vehicle_capacity.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">Bus Capacity Details</a></li>
                        <li><a href="bus_timing.php"><img src="img/icons/packs/fugue/16x16/clock-history-frame.png">Bus Timing</a></li>
                        <li><a href="boarding_point.php"><img src="img/icons/packs/fugue/16x16/point--arrow.png">Staff / Student & boarding points</a></li>
                        <!--<li><a href="#"><img src="img/icons/packs/fugue/16x16/truck--arrow.png">Day to day bus log</a></li>-->
	    			</ul>
                </li>
                <?php } 
				if($_SESSION['admin_type']=="0"){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/drill.png">Import Datas<span class="badge gray">6</span></a>
                	<ul class="sub">
	    				<li><a href="board_select_stuimp.php"><img src="img/icons/packs/fugue/16x16/users.png">Import Students</a></li>
	    				<!--<li><a href="">Import Students Photo</a></li>-->
                        <li><a href="board_select_exam.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Import Student Mark</a></li>
	    				<li><a href="board_select_att.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">Import Student Attendance</a></li>
                        <li><a href="staff.php"><img src="img/icons/packs/fugue/16x16/user-green-female.png">Import Staff</a></li>
                        <li><a href="satt_mng.php?mid=<?php echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/xfn-sweetheart-met.png">Import Staff Attendance</a></li>
                        <li><a href="salary_mng.php?mid=<?php echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/lifebuoy.png">Import Staff Salary</a></li>
	    			</ul>
                </li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Book Inventory", $permissions_check)){?>
                <li><a href="board_select_book.php"><img src="img/icons/packs/fugue/16x16/books-stack.png">Book Inventory</a></li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Payroll Management", $permissions_check)){?>
                <li><a href="payroll/dashboard.php" target="_blank"><img src="img/icons/packs/fugue/16x16/paper-plane--plus.png">Payroll Management System</a></li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("library Management", $permissions_check)){?>
                <li><a href="library/dashboard.php" target="_blank" ><img src="img/icons/packs/fugue/16x16/books-brown.png">Library Management System</a></li>
                <?php } 
				if($_SESSION['admin_type']=="0"){?>
	    		<li><a href=""><img src="img/icons/packs/fugue/16x16/home-share.png">Hostel Management System</a></li>
                <?php } 
				if($_SESSION['admin_type']=="0" || in_array("Front Office", $permissions_check)){?>
                <li><a href=""><img src="img/icons/packs/fugue/16x16/user-thief.png">Front Office Module<span class="badge gray">3</span></a>
                	<ul class="sub">
                    	<li><a href="visitor.php"><img src="img/icons/packs/fugue/16x16/block.png">visitors Monitoring </a></li>
	    				<li><a href="coureirs.php"><img src="img/icons/packs/fugue/16x16/switch.png">couriers/dispatches</a></li>
	    				<li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">telephone directory</a></li>
	    			</ul>
                </li>
                <?php }
                 if($_SESSION['admin_type']=="0" || in_array("Feedbacks", $permissions_check)){?>
                <li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/feed.png">Feedbacks<span class="badge red">4</span></a>
	    			<ul class="sub">
	    				<li><a href="board_select_feedback.php"><img src="img/icons/packs/fugue/16x16/node-delete-child.png">parant-Staff Feedbacks</a></li>
                        <li><a href="board_select_feedback1.php"><img src="img/icons/packs/fugue/16x16/foaf.png">Staff-Student Feedbacks</a></li>
                        <li><a href="staff_mng_feed.php"><img src="img/icons/packs/fugue/16x16/mail-share.png">Feed Backs From Staff</a></li>
                        <li><a href="student_mng_feed.php"><img src="img/icons/packs/fugue/16x16/geotag-balloon.png">Feed Backs From Parents</a></li>
                        
	    			</ul>
	    		</li>
                <?php }
				if($_SESSION['admin_type']=="0"){?>
                <li><a href="todaybirthday.php"><img src="img/icons/packs/fugue/16x16/present--plus.png">Today Birthday</a></li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Finance Report", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/open-share-document.png">Finance Reports<span class="badge gray">6</span></a>
                	<ul class="sub">
	    				<li><a href="income_report.php"><img src="img/icons/packs/fugue/16x16/server-property.png">Fees Income Report</a></li>
                        <li><a href="income_frno_report.php"><img src="img/icons/packs/fugue/16x16/receipt-stamp.png">FR.No Based Income Report</a></li>	
                        <li><a href="board_select_paid.php"><img src="img/icons/packs/fugue/16x16/ui-toolbar--plus.png">Fees Paid Report</a></li>
                        <li><a href="board_select_percentagepaid.php"><img src="img/icons/packs/fugue/16x16/ui-toolbar--plus.png">Fees Paid percentage Report</a></li>	
                        <li><a href="board_select_fincome.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Classwise Fees Income Report</a></li>	
                        <li><a href="board_select_std_fincome.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Studentwise Fees Income Report</a></li>	
                        <li><a href="board_select_differed_report.php"><img src="img/icons/packs/fugue/16x16/compass--arrow.png">Differed Income Report</a></li>	
                        <li><a href="exponse_report.php"><img src="img/icons/packs/fugue/16x16/umbrella--arrow.png">Expenses Report</a></li>	
                        <li><a href="incomedatewise_report.php"><img src="img/icons/packs/fugue/16x16/umbrella--arrow.png">Income Report</a></li>    				
	    			</ul>
                </li>
                <?php }
				if($_SESSION['admin_type']=="0"){?>
                <li><a href=""><img src="img/icons/packs/fugue/16x16/camera--plus.png">Class to capture </a></li>
                <li><a href="school_needs.php"><img src="img/icons/packs/fugue/16x16/server-property.png">School Needs (Stationary )</a></li>
                <li><a href=""><img src="img/icons/packs/fugue/16x16/heart--pencil.png">Birth day Greetings</a></li>
                <li><a href=""><img src="img/icons/packs/fugue/16x16/camcorder-image.png">Live Streaming</a></li>
                <li><a href=""><img src="img/icons/packs/fugue/16x16/ruby.png">Scholarships </a></li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Vehile Management", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/traffic-light--exclamation.png">Vehicle Manage Reports<span class="badge gray">6</span></a>
                	<ul class="sub">
	    				<li><a href="bincome_report.php"><img src="img/icons/packs/fugue/16x16/server-property.png">Bus Fees Income Report</a></li>
                        <li><a href="bincome_frno_report.php"><img src="img/icons/packs/fugue/16x16/receipt-stamp.png">FR.No Based Income Report</a></li>	
                        <li><a href="bpayment_income_report.php"><img src="img/icons/packs/fugue/16x16/plug--exclamation.png">Fees Paid Report</a></li>	
                        <li><a href="buswiseincome_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Buswise Fees Income Report</a></li>	
                        <li><a href="boarding_point.php"><img src="img/icons/packs/fugue/16x16/user-share.png">Buswise Student/Staff  Report</a></li>
                        <li><a href="vehicle_capacity.php"><img src="img/icons/packs/fugue/16x16/sofa--arrow.png">Bus Capcity Detail Report</a></li>    				
	    			</ul>
                </li>
                <?php }
				if($_SESSION['admin_type']=="0" || in_array("Report datas", $permissions_check)){?>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/report.png">Reports / Export Datas<span class="badge gray">7</span></a>
                	<ul class="sub">
	    				<li><a href="board_select_stuexp.php"><img src="img/icons/packs/fugue/16x16/users.png">Students List</a></li>
	    				<li><a href="board_select_stuexp1.php"><img src="img/icons/packs/fugue/16x16/users.png">Filter Students List</a></li>
	    				<li><a href="board_select_staff.php"><img src="img/icons/packs/fugue/16x16/user-detective.png">Staff List</a></li>
                        <li><a href="board_select_parentexp.php"><img src="img/icons/packs/fugue/16x16/parents.png">Parents List</a></li>
	    				<li><a href="board_select_resultexp.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Students Mark</a></li>
                        <li><a href="board_select_attexp.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">students Attendance</a></li>
                        <li><a href="exp_staff_att.php"><img src="img/icons/packs/fugue/16x16/microformats.png">Staff Attendance</a></li>
                       <!--  <li><a href="salary_mng.php?mid=<?php //echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/lifebuoy--arrow.png">staff salary</a></li>
                       <li><a href="">staff time table</a></li>-->
	    			</ul>
                </li>
                <?php }
				if($_SESSION['admin_type']=="0"){?>
                <li><a href="fullcalendar.php"><img src="img/icons/packs/fugue/16x16/calendar-list.png">School Calendar</a></li>
                <li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/address-book--arrow.png">Contact Details</a></li>
                <?php }?>
	    		<li><a href="logout.php"><img src="img/icons/packs/fugue/16x16/door-open-in.png">logout</a></li>
	    		<!--<li>
	    			<a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/user-white.png">Example Submenu<span class="badge red">42</span></a>
	    			<ul class="sub">
	    				<li><a href="javascript:void(0);">Lorem ipsum #1</a></li>
	    				<li><a href="javascript:void(0);">Lorem ipsum #2</a></li>
	    				<li><a href="javascript:void(0);">Lorem ipsum #3</a></li>
	    			</ul>
	    		</li>	-->    		
	    	</ul>
    	</nav>