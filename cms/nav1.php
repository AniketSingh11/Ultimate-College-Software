<?php 
$monthno=date("m");
				 			$qry12=mysql_query("SELECT * FROM month WHERE m_no=$monthno AND ay_id=$acyear");
							$monthsw=mysql_fetch_array($qry12);
							?>
<nav id="nav">
	    	<ul class="menu collapsible shadow-bottom">
	    		<li><a href="dashboard1.php"><img src="img/icons/packs/fugue/16x16/dashboard.png">Dashboard</a></li>
                <li><a href="sboard_select_stu.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Details</a></li>
                <li><a href="sboard_select_att.php"><img src="img/icons/packs/fugue/16x16/alarm-clock-select-remain.png">Student Attendance</a></li>
                <li><a href="sboard_select_exam.php"><img src="img/icons/packs/fugue/16x16/trophy.png">Exam Results</a></li>
                <li><a href="sboard_select_classrank.php"><img src="img/icons/packs/fugue/16x16/rainbow.png">Progress Card</a></li>
                <li><a href="sboard_select_test.php"><img src="img/icons/packs/fugue/16x16/system-monitor.png">Class Test Assign</a></li>
                <li><a href="sboard_select_work.php"><img src="img/icons/packs/fugue/16x16/home.png">Home Work Assign</a></li>
                <li><a href="stimetable_mng.php"><img src="img/icons/packs/fugue/16x16/table.png">Class TimeTable Manage</a></li>
                <li><a href="sattendance.php?mid=<?php echo $monthsw['m_id'];?>"><img src="img/icons/packs/fugue/16x16/resource-monitor.png">Your Attendance</a></li>
                <li><a href="sleave.php"><img src="img/icons/packs/fugue/16x16/leaf--plus.png">Apply Leave</a></li>
                <li><a href="staff_salarydetails.php"><img src="img/icons/packs/fugue/16x16/lifebuoy--plus.png">Salary Details</a></li>
                <li><a href="staff_loandetails.php"><img src="img/icons/packs/fugue/16x16/star--plus.png">Loan Details</a></li>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/speaker.png">Circular and Events<span class="badge red">3</span></a>
                    <ul class="sub nav1">
                            <li><a href="scircular.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Circulars</a></li>
                            <li><a href="sevent.php"><img src="img/icons/packs/fugue/16x16/odata-balloon.png">Events</a></li>
                             <li><a href="snews.php"><img src="img/icons/packs/fugue/16x16/newspaper.png">NEWS</a></li>
                        </ul>
                </li>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/speaker.png">Syllabus Management<span class="badge red">2</span></a>
                    <ul class="sub nav1">
                            <li><a href="sboard_select_syllabus.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Class Syllabus</a></li>
                            <li><a href="sboard_select_scovered.php"><img src="img/icons/packs/fugue/16x16/odata-balloon.png">Syllabus Covered</a></li>
                        </ul>
                </li>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/feed.png">Feedbacks<span class="badge red">3</span></a>
                    <ul class="sub nav1">
                            <li><a href="sboard_select_stu_feed.php"><img src="img/icons/packs/fugue/16x16/parents.png">Parent's Feedback</a></li>
                            <li><a href="toadmin_feedback.php"><img src="img/icons/packs/fugue/16x16/wrench-screwdriver.png">Admin's Feedback</a></li>
                             <li><a href="sboard_select_stu_feed1.php"><img src="img/icons/packs/fugue/16x16/users.png">Student's Feedback</a></li>
                        </ul>
                </li>
                <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/report.png">Reports / Export Datas<span class="badge gray">4</span></a>
                	<ul class="sub nav1">
	    				<li><a href="sboard_select_stuexp.php"><img src="img/icons/packs/fugue/16x16/users.png">Students List</a></li>
	    				<li><a href="sboard_select_parentexp.php"><img src="img/icons/packs/fugue/16x16/parents.png">Parents List</a></li>
	    				<li><a href="sboard_select_markexp.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Students Mark</a></li>
                        <li><a href="sboard_select_attexp.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">students Attendance</a></li>                        
	    			</ul>
                </li>
	    		<li><a href="logout.php"><img src="img/icons/packs/fugue/16x16/door-open-in.png">logout</a></li>	    		    		
	    	</ul>
    	</nav>