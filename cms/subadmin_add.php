<? ob_start(); ?>
<?php
error_reporting(0);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if($_SESSION['admin_type']!="0" ){
 
     header("Location:404.php?msg=errors");
      
 }
 if (isset($_POST['update']))
 {
     $roll=addslashes(trim($_POST['roll']));
     $type=addslashes(trim($_POST['type']));
     $usid=addslashes(trim($_POST['usid']));
     
     if($type!=""){
         
         $delete="Delete from subadmin_accesspage   where log_type='$type' and subadmin_id='$usid'";
         $result=mysql_query($delete);
          
         foreach($_POST['list_menu'] as $menus) {
             $submenu_name="";
             $submenus=str_replace(" ","",$menus);
             //  echo $menus;
              
             //  Scan through inner loop
             foreach ($_POST["$submenus"] as $value) {
                 $submenu_name.=$value.',';
             }
              
              
             $submenuname=rtrim($submenu_name,',');
              
             if($menus!=""){
                  
                 $sql=mysql_query("INSERT INTO subadmin_accesspage (subadmin_id,menu_name,log_type,sub_menuname) values('$usid','$menus','$type','$submenuname')") or die(mysql_error());
                  
             }
             
             
              
         }
         ?>
                  <script>
          alert("Successfully Updated");
         window.location.href="subadmin_add.php";
                  </script>
                <?php 
              }else{
    // if()
     
 
     $name=addslashes(trim($_POST['name']));
     $username=addslashes(trim($_POST['username']));
     $password=addslashes(trim($_POST['pass']));
	 
     
     $adminlist1=mysql_query("SELECT * FROM admin_login  WHERE email='$username'and  id!='$usid'");
     $check=0;
     while($admincount1=mysql_fetch_array($adminlist1))
     {
         $check=1;
         // $admin_number1="ST".str_pad($adminno1, 3, '0', STR_PAD_LEFT);
     
     }
     
     if($check==0)
     
     {

         $sql=mysql_query("UPDATE admin_login SET name='$name',email='$username',password='$password',roll='$roll'  WHERE id='$usid'") or die(mysql_error());
         
         $delete="Delete from subadmin_accesspage   where log_type='admin' and subadmin_id='$usid'";
         $result=mysql_query($delete);
         
         foreach($_POST['list_menu'] as $menus) {
         
             $submenu_name="";
             $submenus=str_replace(" ","",$menus);
             //  echo $menus;
             
             //  Scan through inner loop
             foreach ($_POST["$submenus"] as $value) {
                 $submenu_name.=$value.',';
             }
             
             
             $submenuname=rtrim($submenu_name,',');
             
             if($menus!=""){
         
                 $sql=mysql_query("INSERT INTO subadmin_accesspage (subadmin_id,menu_name,log_type,sub_menuname) values('$usid','$menus','admin','$submenuname')") or die(mysql_error());
         
             }
         
         }
         ?>
         <script>
 alert("Successfully Updated");
window.location.href="subadmin_add.php";
         </script>
       <?php 
     }  else{
              
             $errmsg="UserName Already Given!!!";
             ?>
             <script>
             alert("UserName Already Given!!!");
             window.location.href="subadmin_add.php";
             </script>
             <?php
         }
              }
 }

 if (isset($_POST['submit']))
{	 
	$name=addslashes(trim($_POST['name']));
	$username=addslashes(trim($_POST['username']));
	$password=addslashes(trim($_POST['pass']));
	$roll=addslashes(trim($_POST['roll']));
	
	$staffid=explode("-",$_POST['staff_id']);
	 
	 
	
	 if($_POST['add_new']=="")
	{
	     
	    $staff_id=$staffid[0];
	    $s_type=$staffid[1];
	    
	    if($s_type=="others")
	    {
	        $stypeid="o_id";
	    }
	     
	    if($s_type=="staff")
	    {
	        $stypeid="st_id";
	    }

	    if($s_type!="")
	    {
	   $sql=mysql_query("UPDATE $s_type SET admin_permission='1',admin_role='$roll'  WHERE $stypeid='$staff_id'") or die(mysql_error());
	  
	    foreach($_POST['list_menu'] as $menus) {
	      
	        $submenu_name="";
	        $submenus=str_replace(" ","",$menus);
	      //  echo $menus;
	        
	            //  Scan through inner loop
	            foreach ($_POST["$submenus"] as $value) {
	                $submenu_name.=$value.',';
	            }
	        
	      
	        $submenuname=rtrim($submenu_name,',');
	         
	        if($menus!=""){
	             $sql=mysql_query("INSERT INTO subadmin_accesspage (subadmin_id,menu_name,log_type,sub_menuname) values('$staff_id','$menus','$s_type','$submenuname')") or die(mysql_error());
       
	        }
	    }
	    ?>
	    <script>
	    alert("Successfully added");
	   window.location.href="subadmin_add.php";
	    </script>
	    <?php

	    }else{
	        ?>
	        <script>
	        alert("Failed");
	         window.location.href="subadmin_add.php";
	        </script>
	        <?php
	    }
	}else{
	
	
	$adminlist1=mysql_query("SELECT * FROM admin_login  WHERE email='$username'"); 
	$check=0;
	while($admincount1=mysql_fetch_array($adminlist1))
	{
	    $check=1;
								// $admin_number1="ST".str_pad($adminno1, 3, '0', STR_PAD_LEFT);
	}
	if($check==0 && $username!="" && $password!="")
	{
	    $sql=mysql_query("INSERT INTO admin_login (name,email,password,admin_type,roll) values('$name','$username','$password',1,'$roll')") or die(mysql_error());
	    $subid = mysql_insert_id();	    
	    foreach($_POST['list_menu'] as $menus) {


	        $submenu_name="";
	        $submenus=str_replace(" ","",$menus);
	        //  echo $menus;
	         
	        //  Scan through inner loop
	        foreach ($_POST["$submenus"] as $value) {
	            $submenu_name.=$value.',';
	        }
	         
	         
	        $submenuname=rtrim($submenu_name,',');
	      if($menus!=""){
	    $sql=mysql_query("INSERT INTO subadmin_accesspage (subadmin_id,menu_name,log_type,sub_menuname) values('$subid','$menus','admin','$submenuname')") or die(mysql_error());	     
	     }	     
	    }
	    ?>
	             <script>
	    alert("Successfully added");
	    window.location.href="subadmin_add.php";
	             </script>
	           <?php 	          
	}else{
	    $errmsg="UserName Already Given!!!";
	}
	
}//


 
}
 ?>
 <style>
    
.topnav {
	width: 100%;
	padding: 40px 28px 25px 0;
	font-family:"PT Sans","Tahoma",sans-serif;
}

ul.topnav {
	padding: 0;
	margin: 0;
	font-size: 1em;
	line-height: 0.5em;
	list-style: none;
	
}

ul.topnav li { 
	font-size: 12px;
	padding: 5px;
	color: #666666;
	display: block;
	text-decoration: none;
	font-weight: 700;
	cursor:pointer;
	background: rgba(226,226,226,1);
background: -moz-linear-gradient(top, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(224,221,224,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(226,226,226,1)), color-stop(50%, rgba(219,219,219,1)), color-stop(51%, rgba(209,209,209,1)), color-stop(100%, rgba(224,221,224,1)));
background: -webkit-linear-gradient(top, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(224,221,224,1) 100%);
background: -o-linear-gradient(top, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(224,221,224,1) 100%);
background: -ms-linear-gradient(top, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(224,221,224,1) 100%);
background: linear-gradient(to bottom, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(224,221,224,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#e0dde0', GradientType=0 );
border-bottom:1px dashed #ACACAC;
	}

ul.topnav li a {
	line-height: 10px;
	font-size: 12px;
	padding: 5px 0px;
	color: #666666;
	display: block;
	text-decoration: none;
	font-weight: 700;
	cursor:pointer;
	background:white;
}

ul.topnav li a:hover {
	background-color:#675C7C;
	color:white;
}

ul.topnav ul {
	margin: 0;
	padding: 0;
	display: none;
}

ul.topnav ul li {
	margin: 0;
	padding: 0;
	clear: both;
	list-style-type:none;
}

ul.topnav ul li a {
	padding-left: 20px;
	font-size: 12px;
	font-weight: 700;
	outline:0;
}

ul.topnav ul li a:hover {
	background-color:#FF8E00;
	color:#675C7C;
}

ul.topnav ul ul li a {
	color:silver;
	padding-left: 40px;
}

ul.topnav ul ul li a:hover {
	background-color:#D3CEB8;
	color:#675C7C;
}

ul.topnav span{
	float:right;
}
</style>
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
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
			 
                <li class="no-hover">Sub  Administrator</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            
            <div class="grid_12">
				<h1>Sub Administrator</h1>      
				<?php 
              if(!isset($_GET['show']))
            {?>
              <a href="subadmin_add.php?show=add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
                      <?php }?>
                      <?php 
              if(isset($_GET['show']))
            {?>
                <a onclick="history.go(-1);" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <?php }?>
			 		</div>
            <div class="grid_12">
            <?php  
            if (isset($_POST['submit']))
{
			if($check=="0"){?>			
            <div class="alert success"><span class="hide">x</span>Your  Successfully Created!!!</div>
            <?php }else { ?>		
          <div class="alert error"><span class="hide">x</span><?=$errmsg?>!!</div>
            <?php } }else{
                
                $name="";
                $username="";
            }?>
            </div>
 
            <?php if (isset($_GET['delid']))
            {
                
                $delid=$_GET['delid'];
                $type=$_GET['type'];
                
                if($type==""){
                
                $delete="Delete from admin_login where id='$delid'";
                $result=mysql_query($delete);
                $delete="Delete from subadmin_accesspage where log_type='admin' and subadmin_id='$delid'";
                $result=mysql_query($delete);
                }else{
                    if($type=="others")
                    {
                        $stypeid="o_id";
                    }
                    
                    if($type=="staff")
                    {
                        $stypeid="st_id";
                    }
                    $sql=mysql_query("UPDATE $type SET admin_permission='0',admin_role=''  WHERE $stypeid='$delid'");
                    $delete="Delete from subadmin_accesspage where log_type='$type' and subadmin_id='$delid'";
                    $result=mysql_query($delete);
                    
                }
                ?>
                            <div class="alert success"><span class="hide">x</span>Your Successfully Deleted!!!</div>
                            <?php
                
            }
            
            if(isset($_GET['show']))
            {
                
                $show=$_GET['show'];
                if($show=="add")
                {    /********************************** SubAdmin ADD Start*****************************************/
			 ?> 
             <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Subadmin</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						 	 <div class="_25">
						 	<p> <label for="textfield">Add New Subadmin: &nbsp;<input id="add_new" name="add_new" value="new" type="checkbox" > </label> </p>
							 </div>
						 
						 <div id="new_staff">
						   <div class="_25">
						 	<p>
							 <label for="select">Select Staff : <span class="error">*</span></label>
							<select name="staff_id" name="staff_id" class="form-control" style="width:90%" >
							<option value=''>Select</option>
							<?php 
							$qry=mysql_query("select * from staff where  admin_permission='0' AND status='1'");
							while($res=mysql_fetch_array($qry))
							{
							    $st_id=$res["st_id"];
							    $staff_id=$res["staff_id"];
							    $fname=$res["fname"];
							    $lname=$res["lname"];
							    
							    $staff_name=$staff_id." - ".$fname." ".$lname
							  ?>
						     <option value="<?=$st_id?>-staff"><?=$staff_name?></option>
							<?php } ?>
							
							<?php 
							$qry=mysql_query("select * from others  where admin_permission='0' ");
							while($res=mysql_fetch_array($qry))
							{
							    $o_id=$res["o_id"];
							    $others_id=$res["others_id"];
							    $fname=$res["fname"];
							    $lname=$res["lname"];
							    
							    $others_name=$others_id." - ".$fname." ".$lname
							  ?>
						     <option value="<?=$o_id?>-others"><?=$others_name?></option>
							<?php } ?>
							
						 	</select>
                             </p>
						</div>
						</div>
						
						<div id="new_admin" style="display: none;">
						 <div class="clear"></div>
                       <div class="_25">
							<p>
                                <label for="textfield">Name : <span class="error">*</span></label>
                                <input id="name" name="name" class="required" type="text" value="1" />
                            </p>
						</div>
						
                        <div class="_25">
							<p>
                                <label for="textfield">Username : <span class="error">*</span></label>
                                <input id="username" name="username"   class="required" type="text" value="2" />
                            </p>
						</div>
						
						
						<div class="_25">
							<p>
                                <label for="textfield">Passowrd : <span class="error">*</span></label>
                                <input id="pass" name="pass"   class="required" type="text" value="3" />
                            </p>
						</div> 
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Roll :</label>
                                <input id="roll" name="roll" type="text" class="required" value="" />
                            </p>
						</div>
						<div class="clear"></div>
						
						
						  <div class="_50">
							<p>
                                <label for="textfield">List Of Menu : <span class="error">*</span></label><div class="clear"></div> 
                                <ul  class="topnav">                               
                               <li><input  name="list_menu[]" <?php if (in_array("Standard and Section", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Standard and Section" />Standard and Section</li>
                                <li  id="Mainadmissions" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Mainadmissions')"><input   name="list_menu[]" <?php if (in_array("Main admissions", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Main admissions" /><b >Main admissions <span></span></b></div>
                                <ul>
                                <li> <a> <input name="Mainadmissions[]" <?php if (in_array("pre_admission.php", $submenu_checkbox)) {?>checked="checked" <?php }?> id="listsub_menu"  type="checkbox" value="pre_admission.php" />Pre Admission </a> </li>
                                <li> <a> <input   name="Mainadmissions[]" <?php if (in_array("pre_admission_select.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="pre_admission_select.php" />Pre Admission Selection</a> </li>
                               <li> <a>  <input   name="Mainadmissions[]" <?php if (in_array("admission.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="admission.php" />Admission</a> </li>
                                 <li> <a> <input   name="Mainadmissions[]" <?php if (in_array("admission_imp.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="admission_imp.php" />New Student import</a> </li>
                                 <li> <a>  <input   name="Mainadmissions[]" <?php if (in_array("pre_admission_allocation.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="pre_admission_allocation.php" />Student Allocation</a> </li>
                                 </ul></li>
                                 
                                <li  id="SubjectManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('SubjectManagement')"> <input  name="list_menu[]" <?php if (in_array("Subject Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Subject Management" /><b>Subject Management<span></span></b></div>
                                  <ul>
                              <li> <a>   <input   name="SubjectManagement[]" <?php if (in_array("subject_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> id="listsub_menu"  type="checkbox" value="subject_mng.php" />Classwise Subject</a> </li>
                               <li> <a>  <input   name="SubjectManagement[]" <?php if (in_array("subject_mng1.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="subject_mng1.php" />Staff Assign</a> </li>
                               <li> <a>  <input   name="SubjectManagement[]"  <?php if (in_array("stafflist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="stafflist.php" />Staffwise Assign</a> </li>
                               <li> <a>   <input   name="SubjectManagement[]" <?php if (in_array("board_select_cstaff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="board_select_cstaff.php" />Classwise Staff</a> </li>
                                  
                                 </ul></li>
                                 <li  id="ClassTimetableManage" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('ClassTimetableManage')"><input  name="list_menu[]" <?php if (in_array("Class Timetable Manage", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Class Timetable Manage" /><b>Class Timetable Manage<span></span></b></div>
                                 <ul>
                                <li> <a> <input   name="ClassTimetableManage[]" <?php if (in_array("day.php", $submenu_checkbox)) {?>checked="checked" <?php }?> id="listsub_menu"  type="checkbox" value="day.php" />Day management </a> </li>
                                <li> <a> <input   name="ClassTimetableManage[]" <?php if (in_array("peroid.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="peroid.php" />Extra Period management</a> </li>
                                 <li> <a> <input   name="ClassTimetableManage[]"  <?php if (in_array("timetable_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="timetable_mng.php" />Time Table</a> </li>
                                <li> <a>  <input   name="ClassTimetableManage[]" <?php if (in_array("staff_free_periods.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="staff_free_periods.php" />Staff Free Hours</a> </li>
                                 
                                 </ul></li>
                                 <li  id="StudentManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('StudentManagement')"><input  name="list_menu[]" <?php if (in_array("Student Management", $checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="Student Management" /><b>Student Management<span></span></b></div>
                                
                                  <ul>
                                <li> <a> <input   name="StudentManagement[]" id="listsub_menu"  type="checkbox"  <?php if (in_array("student_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> value="student_mng.php" />Student Management</a> </li>
                                 <li> <a> <input   name="StudentManagement[]"  type="checkbox" value="att_mng.php" <?php if (in_array("att_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student's Attendance Management</a> </li>
                                 <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="att_mng_today.php" <?php if (in_array("att_mng_today.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Absent List</a> </li>
                                 <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_overall.php" <?php if (in_array("student_overall.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Student's List</a> </li>
                                 <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_inactive.php" <?php if (in_array("student_inactive.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Inactive Student List</a> </li>
                                <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_newlist.php" <?php if (in_array("student_newlist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />New Student List</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_admission_prt.php" <?php if (in_array("student_admission_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student Application Form</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="roll_of_student.php" <?php if (in_array("roll_of_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Roll of Student</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="castewise_list.php" <?php if (in_array("castewise_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Castewise Student list</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="today_att_student.php" <?php if (in_array("today_att_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Student Present</a> </li>
                                 
                                 </ul></li>
                                
                                 <li id="StaffManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('StaffManagement')"><input  name="list_menu[]" <?php if (in_array("Staff Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Staff Management" /><b>Staff Management<span></span></b></div>
                                  <ul>
                                <li> <a> <input   name="StaffManagement[]" id="listsub_menu"  type="checkbox" value="staff.php" <?php if (in_array("staff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Management</a> </li>
                                <li> <a> <input   name="StaffManagement[]"  type="checkbox" value="classwise_staff.php" <?php if (in_array("classwise_staff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Classwise Staff List</a> </li>
                                <li> <a> <input   name="StaffManagement[]"  type="checkbox" value="satt_mng.php" <?php if (in_array("satt_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Attendance Management</a> </li>
                                 <li><a><input   name="StaffManagement[]"  type="checkbox" value="staff_admission_prt.php" <?php if (in_array("staff_admission_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Application Form</a></li>
                                 </ul>
                                 </li>
                                 
                                 <li id="OtherStaff" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('OtherStaff')"><input  name="list_menu[]" <?php if (in_array("Other Staff", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Other Staff" /><b>Other Staff<span></span></b></div>
                                  <ul>
                                <li> <a> <input   name="OtherStaff[]" id="listsub_menu"  type="checkbox" value="others_categorylist.php" <?php if (in_array("others_categorylist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Other Staff Category</a> </li>
                                <li> <a> <input   name="OtherStaff[]"  type="checkbox" value="others_list.php" <?php if (in_array("others_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Other Staff List</a> </li>
                                <li> <a> <input   name="OtherStaff[]"  type="checkbox" value="owatt_mng.php" <?php if (in_array("owatt_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Other Staff Attendance</a></li>
                                 </ul>
                                 </li>
                                 
                                 <li id="ParentManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('ParentManagement')"><input  name="list_menu[]" <?php if (in_array("Parent Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Parent Management" /><b>Parent Management<span></span> </b></div>                             
                                  <ul>
                                <li> <a> <input   name="ParentManagement[]" id="listsub_menu"  type="checkbox" value="parent_mng.php"  <?php if (in_array("parent_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />parants Management</a> </li>
                                <li> <a> <input   name="ParentManagement[]"  type="checkbox" value="sibling_mng.php" <?php if (in_array("sibling_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Sibling Management</a> </li>
                                
                                  </ul></li>
                                   <li  id="ExamManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('ExamManagement')"><input  name="list_menu[]" <?php if (in_array("Exam Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Exam Management" /><b>Exam Management<span></span></b></div>
                                 <ul>
                                <li> <a> <input   name="ExamManagement[]" id="listsub_menu" <?php if (in_array("classtest_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="classtest_mng.php" />Class Test Assign</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="homework_mng.php" <?php if (in_array("homework_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Home Work Assign</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="exam.php"  <?php if (in_array("exam.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Exam List</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="examtimetable_mng.php"  <?php if (in_array("examtimetable_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Exams time table</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_mng.php"  <?php if (in_array("result_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Add Exam Results</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_mng1.php"  <?php if (in_array("result_mng1.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Exam Results</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_mng_grade.php"  <?php if (in_array("result_mng_grade.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Grade Results</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="rank_card.php"  <?php if (in_array("rank_card.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Progress Card</a> </li>
                                 <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="rankcard_status.php"  <?php if (in_array("rankcard_status.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Progress Visit Status</a> </li>
                                 <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_analysis_section.php"  <?php if (in_array("result_analysis_section.php", $submenu_checkbox)) {?>checked="checked" <?php }?>/>Exam Results Analysis</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_analysis_student.php"  <?php if (in_array("result_analysis_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?>/>Studentwise Results Analysis</a> </li>
                                 
                                 </ul></li>
                                 
                                 
                                 <li id="StudentPromotion" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('StudentPromotion')"><input  name="list_menu[]" <?php if (in_array("Student Promotion", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Student Promotion" /><b>Student Promotion<span></span> </b></div>                             
                                  <ul>
                                <li> <a> <input   name="StudentPromotion[]" id="listsub_menu"  type="checkbox" value="promotion_student.php"  <?php if (in_array("promotion_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student Selected</a> </li>
                                <li> <a> <input   name="StudentPromotion[]"  type="checkbox" value="promotion_shuffle_student.php" <?php if (in_array("promotion_shuffle_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student Shuffle</a> </li>
                                
                                  </ul></li>
                                
                                
                                 <li id="FeesManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('FeesManagement')"><input  name="list_menu[]" <?php if (in_array("Fees Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Fees Management" /><b>Fees Management<span></span></b></div>
                                <ul>
                                <li> <a> <input   name="FeesManagement[]" id="listsub_menu"  type="checkbox" value="billing.php" <?php if (in_array("billing.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Payment</a> </li>
                              <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="feesinvoice.php" <?php if (in_array("feesinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Payment Invoice</a> </li>
                              <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="feesinvoice_reject.php" <?php if (in_array("feesinvoice_reject.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Rejected Fees Invoice</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="cheque_feesinvoice.php" <?php if (in_array("cheque_feesinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Cheque payment List</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="ftype.php" <?php if (in_array("ftype.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Type</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="fgroup.php" <?php if (in_array("fgroup.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Group</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="feesrate.php" <?php if (in_array("feesrate.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Rate</a> </li>
                                 </ul></li>
                                 <li  id="Finance" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Finance')"><input  name="list_menu[]" <?php if (in_array("Finance", $checkbox)) {?>checked="checked" <?php }?>   type="checkbox" value="Finance" /><b>Finance<span></span></b></div>
                                 
                                   <ul>
                                <li> <a> <input   name="Finance[]" id="listsub_menu"  type="checkbox" value="income_category.php" <?php if (in_array("income_category.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Income Category</a> </li>
                               <li> <a> <input   name="Finance[]"  type="checkbox" value="income_mng.php" <?php if (in_array("income_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Income Management</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="agency.php" <?php if (in_array("agency.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Agency</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="quotation_list.php" <?php if (in_array("quotation_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Proposal Management</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="exponses_category.php" <?php if (in_array("exponses_category.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Expenses Category</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="exponse_mng.php" <?php if (in_array("exponse_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Over Expenses Manage</a> </li> 
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="exponse_mngi.php" <?php if (in_array("exponse_mngi.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Expenses Bill Paid</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="finance_Agency_reports_prt.php" <?php if (in_array("finance_Agency_reports_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Agencywise Expenses</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="finance_category_reports_prt.php" <?php if (in_array("finance_category_reports_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Categorywise Expenses</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="finance_reports_prt.php" <?php if (in_array("finance_reports_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />SubCategorywise Expenses</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="bank_account.php" <?php if (in_array("bank_account.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bank Account List</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="bdeposit_mng.php" <?php if (in_array("bdeposit_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bank Deposit Manage</a> </li>
                                   
                               <li> <a>  <input   name="Finance[]"  type="checkbox" value="bwithdrawl_mng.php" <?php if (in_array("bwithdrawl_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bank Withdrawl Manage</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="expense_allowancelist.php" <?php if (in_array("expense_allowancelist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Daily Allowance List</a> </li>
                                <li> <a>   <input   name="Finance[]"  type="checkbox" value="balance_sheet.php" <?php if (in_array("balance_sheet.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Ledger</a> </li>
                                 </ul></li>
                                 <li  id="Feedbacks" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Feedbacks')"><input  name="list_menu[]" <?php if (in_array("Feedbacks", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Feedbacks" /><b>Feedbacks<span></span></b></div>
                            <ul>
                                <li> <a> <input   name="Feedbacks[]" id="listsub_menu"  type="checkbox" value="feedback_mng.php" <?php if (in_array("feedback_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />parant-Staff Feedbacks</a> </li>
                               <li> <a>  <input   name="Feedbacks[]"  type="checkbox" value="feedback_mng1.php" <?php if (in_array("feedback_mng1.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Staff-Student Feedbacks</a> </li>
                              <li> <a>   <input   name="Feedbacks[]"  type="checkbox" value="staff_mng_feed.php" <?php if (in_array("staff_mng_feed.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Feed Backs From Staff</a> </li>
                                <li> <a> <input   name="Feedbacks[]"  type="checkbox" value="student_mng_feed.php" <?php if (in_array("student_mng_feed.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Feed Backs From Parents</a> </li>                                
                                 </ul></li>
                           </ul>
                            </p>
						 </div>
						 
                         <div class="_50">
							<p>
							<ul  class="topnav">  
                                <div class="clear"></div>                                
                                 <li  id="CircularandEvents" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('CircularandEvents')"><input  name="list_menu[]"  <?php if (in_array("Circular and Events", $checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="Circular and Events" /><b>Circular and Events<span></span></b></div>
                                  <ul>
                                <li> <a> <input   name="CircularandEvents[]" id="listsub_menu"  type="checkbox" <?php if (in_array("circular.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  value="circular.php" />Circular Management</a> </li>
                                <li> <a> <input   name="CircularandEvents[]"  type="checkbox" value="event.php" <?php if (in_array("event.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Events Management</a> </li>
                                <li> <a> <input   name="CircularandEvents[]"  type="checkbox" value="news.php" <?php if (in_array("news.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />NEWS Management</a> </li>
                                 
                                
                                 </ul></li>
                                 <li  id="MobileSMS" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('MobileSMS')"><input  name="list_menu[]" <?php if (in_array("Mobile SMS", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Mobile SMS" /><b>Mobile SMS<span></span></b></div>
                                    <ul>
                               <li> <a>  <input   name="MobileSMS[]" id="listsub_menu"  type="checkbox" value="sms_mng.php" <?php if (in_array("sms_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />OverAll SMS Management</a> </li>
                                <li> <a> <input   name="MobileSMS[]"  type="checkbox" value="sms_specific_mng.php" <?php if (in_array("sms_specific_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Specific SMS Management</a> </li>
                                       </ul></li>
                                 <li><input  name="list_menu[]" <?php if (in_array("Book Inventory", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Book Inventory" />Book Inventory</li>
                                 <li><input  name="list_menu[]" <?php if (in_array("Payroll Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Payroll Management" />Payroll Management</li>
                                  <li><input  name="list_menu[]" <?php if (in_array("library Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="library Management" />library Management</li>
                                  <li><input  name="list_menu[]" <?php if (in_array("Hostel Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Hostel Management" />Hostel Management</li>
                                 
                                 <li  id="Certificates" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Certificates')"><input  name="list_menu[]" <?php if (in_array("Certificates", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Certificates" /><b>Certificates<span></span></b><div>
                                  <ul> 
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="bonafide.php" <?php if (in_array("bonafide.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bonafide Certificate</a> </li>
                               <li> <a>    <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="community.php" <?php if (in_array("community.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Community Certificate</a> </li>
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="conduct.php" <?php if (in_array("conduct.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Conduct Certificate</a> </li>
                                <li> <a>   <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="c_attend.php" <?php if (in_array("c_attend.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Attendance Certificate</a> </li>
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="board_select_marksheet.php" <?php if (in_array("board_select_marksheet.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Marklist Certificate</a> </li>
                                <li> <a>   <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="board_select_tc11.php" <?php if (in_array("board_select_tc11.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Transfer Certificate</a> </li>
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="board_select_hallticket.php" <?php if (in_array("board_select_hallticket.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Hall Ticket</a> </li>
                               <li> <a>    <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="certificates_tuitionfees.php" <?php if (in_array("certificates_tuitionfees.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Tuition Fees Certificate</a> </li>
                              <li> <a>   <input   name="Certificates[]"  type="checkbox" value="exp_certificate_list.php" <?php if (in_array("exp_certificate_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Experience  Certificate</a> </li>
                                       </ul></li>
                                 <li  id="IDCard" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('IDCard')"><input  name="list_menu[]" <?php if (in_array("ID Card", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="ID Card" /><b>ID Card<span></span></b></div>
                                  <ul>
                              <li> <a>   <input   name="IDCard[]" id="listsub_menu"  type="checkbox" value="board_select_idcard3.php" <?php if (in_array("board_select_idcard3.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall ID Cards</a> </li>
                               <li> <a>  <input   name="IDCard[]"  type="checkbox" value="idcard.php" <?php if (in_array("idcard.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Classwise ID Cards</a> </li>
                                <li> <a>   <input   name="IDCard[]" id="listsub_menu"  type="checkbox" value="idcard_selected.php" <?php if (in_array("idcard_selected.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />selected Student ID Cards</a> </li>
                                <li> <a> <input   name="IDCard[]"  type="checkbox" value="idcard_single.php" <?php if (in_array("idcard_single.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Single Student ID Card</a> </li>
                                
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="staff_idcard_all_prt.php" <?php if (in_array("staff_idcard_all_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Overall ID Cards</a> </li>
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="staff_idcard_single.php" <?php if (in_array("staff_idcard_single.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Single Staff ID Cards</a> </li>
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="driver_idcard_all_prt.php" <?php if (in_array("driver_idcard_all_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Driver Overall ID Cards</a> </li>
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="driver_idcard_single.php" <?php if (in_array("driver_idcard_single.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Single Driver ID Cards</a> </li>
                                    
                                </ul></li>
                                 <li  id="Vehiclemanagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Vehiclemanagement')"><input  name="list_menu[]" <?php if (in_array("Vehicle management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Vehicle management" /><b>Vehicle management<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="busfeesbilling.php" <?php if (in_array("busfeesbilling.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />BusFees Payment</a> </li>
                               <li> <a>  <input   name="Vehiclemanagement[]"  type="checkbox" value="bfeesinvoice.php" <?php if (in_array("bfeesinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />BusFees Payment Invoice</a> </li>
                              <li> <a>     <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="bchequeinvoice.php" <?php if (in_array("bchequeinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Cheque payment List</a> </li>
                              <li> <a>     <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="trstopping.php" <?php if (in_array("trstopping.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Stopping Points</a> </li>
                              <li> <a>     <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="vehicle.php" <?php if (in_array("vehicle.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Vehicle Master</a> </li>
                              <li> <a>   <input   name="Vehiclemanagement[]"  type="checkbox" value="driver.php" <?php if (in_array("driver.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Driver details</a> </li>
                                <li> <a>   <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="datt_mng.php" <?php if (in_array("datt_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Driver Attendance</a> </li>
                               <li> <a>  <input   name="Vehiclemanagement[]"  type="checkbox" value="route.php" <?php if (in_array("route.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Route Master</a> </li>
                               <li> <a>    <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="stopping_mng.php" <?php if (in_array("stopping_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Route stopping Assign</a> </li>
                               <li> <a>    <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="trbus_feesrate.php" <?php if (in_array("trbus_feesrate.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Fees Rate</a> </li>
                               <li> <a>    <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="bus_feesrate.php" <?php if (in_array("bus_feesrate.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Routewise Fees Rate</a> </li>
                                <li> <a> <input   name="Vehiclemanagement[]"  type="checkbox" value="vehicle_capacity.php" <?php if (in_array("vehicle_capacity.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Capacity Details</a> </li>
                                <li> <a>   <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="bus_timing.php" <?php if (in_array("bus_timing.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Timing</a> </li>
                                <li> <a>  <input   name="Vehiclemanagement[]"  type="checkbox" value="boarding_point.php" <?php if (in_array("boarding_point.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff / Student & boarding points</a> </li>
                                <li> <a> <input   name="Vehiclemanagement[]"  type="checkbox" value="bus_att_mng.php" <?php if (in_array("bus_att_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />vehicle Student Attendance</a> </li>
                                <li> <a> <input   name="Vehiclemanagement[]"  type="checkbox" value="busfees_overall_prt.php" <?php if (in_array("busfees_overall_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Feesrate</a> </li>
                                       </ul></li>
                                  <li  id="VehicleTripmanagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('VehicleTripmanagement')"><input  name="list_menu[]" <?php if (in_array("Vehicle Trip management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Vehicle Trip management" /><b>Vehicle Trip management<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="VehicleTripmanagement[]" id="listsub_menu"  type="checkbox" value="vehicle_trip.php" <?php if (in_array("vehicle_trip.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Vehicle Trip Details</a> </li>
                                       </ul></li>     
                                  <li  id="VehicleManageReports" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('VehicleManageReports')"><input  name="list_menu[]" <?php if (in_array("Vehicle Manage Reports", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Vehicle Manage Reports" /><b>Vehicle Manage Reports<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="bincome_report.php" <?php if (in_array("bincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Fees Income Report</a> </li>
                               <li> <a>  <input   name="VehicleManageReports[]"  type="checkbox" value="bincome_frno_report.php" <?php if (in_array("bincome_frno_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />FR.No Based Income Report</a> </li>
                              <li> <a>     <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="bpayment_income_report.php" <?php if (in_array("bpayment_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Paid Report</a> </li>
                              <li> <a>     <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="buswiseincome_report.php" <?php if (in_array("buswiseincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Buswise Fees Income</a> </li>
                              <li> <a>     <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="stopwiseincome_report.php" <?php if (in_array("stopwiseincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Stopwise Fees Income</a> </li>
                              <li> <a>   <input   name="VehicleManageReports[]"  type="checkbox" value="boarding_point.php" <?php if (in_array("boarding_point.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Buswise Student/Staff  Report</a> </li>
                                <li> <a>   <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="vehicle_capacity.php" <?php if (in_array("vehicle_capacity.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Capcity Detail Report</a> </li>
                               <li> <a>  <input   name="VehicleManageReports[]"  type="checkbox" value="boarding_point_att.php" <?php if (in_array("boarding_point_att.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Boarding Point List</a> </li>
                               <li> <a>    <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="boarding_point_att_count.php" <?php if (in_array("boarding_point_att_count.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Boarding Point Count</a> </li>
                               <li> <a>    <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="boarding_point_count.php" <?php if (in_array("boarding_point_count.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Boarding Point Total Count</a> </li>
                                       </ul></li>     
                                 <li id="FeesReports" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('FeesReports')"><input  name="list_menu[]" <?php if (in_array("Fees Reports", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Fees Reports" /><b>Fees Reports<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="FeesReports[]" id="listsub_menu"  type="checkbox" value="income_report.php" <?php if (in_array("income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Income Report</a> </li>
                                 <li> <a><input   name="FeesReports[]"  type="checkbox" value="income_frno_report.php" <?php if (in_array("income_frno_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />FR.No Based Income Report</a> </li>
                                <li> <a>   <input   name="FeesReports[]" id="listsub_menu"  type="checkbox" value="payment_income_report.php" <?php if (in_array("payment_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Paid Report</a> </li>
                                 <li> <a><input   name="FeesReports[]"  type="checkbox" value="payment_percentageincome_report.php" <?php if (in_array("payment_percentageincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Paid percentage Report</a> </li>
                                 <li> <a>  <input   name="FeesReports[]" id="listsub_menu"  type="checkbox" value="classwise_income_report.php" <?php if (in_array("classwise_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Classwise Fees Income Report</a> </li>
                                <li> <a> <input   name="FeesReports[]"  type="checkbox" value="studentwise_income_report.php" <?php if (in_array("studentwise_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Studentwise Fees Income Report</a> </li>
                                       </ul></li>
                                 <li  id="FrontOffice" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('FrontOffice')"><input  name="list_menu[]" <?php if (in_array("Front Office", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Front Office" /><b>Front Office<span></span></b></div>
                                    <ul>
                                <li> <a> <input   name="FrontOffice[]" id="listsub_menu"  type="checkbox" value="visitor.php" <?php if (in_array("visitor.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />visitors Monitoring </a> </li>
                                <li> <a> <input   name="FrontOffice[]"  type="checkbox" value="coureirs.php" <?php if (in_array("coureirs.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />couriers/dispatches</a> </li>
                                  <li> <a> <input   name="FrontOffice[]" id="listsub_menu"  type="checkbox" value="contact_details.php" <?php if (in_array("contact_details.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />telephone directory</a> </li>
                               
                                       </ul></li>
                                 <li  id="Reportdatas" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Reportdatas')"><input  name="list_menu[]" <?php if (in_array("Report datas", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Report datas" /><b>Report datas<span></span></b></div>
                                 
                                  <ul>
                                <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_student_list.php" <?php if (in_array("exp_student_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Students List </a> </li>
                                <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_filterstudent_list.php" <?php if (in_array("exp_filterstudent_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Filter Students List </a> </li>
                               <li> <a> <input   name="Reportdatas[]"  type="checkbox" value="board_select_staff.php" <?php if (in_array("board_select_staff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff List</a> </li>
                                  <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_parent_list.php" <?php if (in_array("exp_parent_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Parents List</a> </li>
                               <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_student_result.php" <?php if (in_array("exp_student_result.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Students Mark </a> </li>
                               <li> <a>  <input   name="Reportdatas[]"  type="checkbox" value="exp_student_att.php" <?php if (in_array("exp_student_att.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />students Attendance</a> </li>
                                  <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_staff_att.php" <?php if (in_array("exp_staff_att.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Attendance </a> </li>
                                       </ul></li>
                                        <li><input  name="list_menu[]" <?php if (in_array("School Calendar", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="School Calendar" />School Calendar</li>  
                                       
                                        <li><input  name="list_menu[]" <?php if (in_array("Contact Details", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Contact Details" />Contact Details</li>  
                                       </ul>
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
				<?php }   /********************************** SubAdmin ADD End*****************************************/
				
			if($show=="edit" && $_GET["usid"]!="")
			    				
			{				/********************************** SubAdmin EDIT Start*****************************************/
			    $type=$_GET["type"];
			    
			    if($type==""){
			    $qry=mysql_query("select * from admin_login where id='$_GET[usid]'");
			    $row=mysql_fetch_array($qry);
			    $id=$row['id'];
			    $username=$row['email'];
			    $name=$row['name'];
			    $password=$row['password'];
				$roll=$row['roll'];
				$query1="select * from  subadmin_accesspage where log_type='admin' and subadmin_id='$id'";
			    }elseif($type=="others")
			    {
			        $qry=mysql_query("select * from others where o_id='$_GET[usid]'");
			        $row=mysql_fetch_array($qry);
			        $id=$row['o_id'];
			        $username=$row['email'];
			        $name=$row['fname'];
			        $password=$row['password'];
			        $roll=$row['admin_role'];
			        
			        $staff_name=$row['others_id'].$name;
			        $query1="select * from  subadmin_accesspage where log_type='others' and subadmin_id='$id'";
			    }elseif($type=="staff")
			    {
			        $qry=mysql_query("select * from staff where st_id='$_GET[usid]'");
			        $row=mysql_fetch_array($qry);
			        $id=$row['st_id'];
			        $username=$row['email'];
			        $name=$row['fname'];
			        $password=$row['password'];
			        $roll=$row['admin_role'];
			        $staff_name=$row['staff_id'].$name;
			        $query1="select * from  subadmin_accesspage where log_type='staff' and subadmin_id='$id'";
			    }
			    
			    
			    $checkbox=array();
			  
			    $res1=mysql_query($query1);
			    $submenu_checkbox=array();
			    while($row1=mysql_fetch_array($res1))
			    {
			        if($row1["sub_menuname"]!=""){
			            $submenu=explode(",",$row1["sub_menuname"]);
			        
			            foreach($submenu as $val)
			            {
			                array_push($submenu_checkbox,$val);
			            }
			            	
			        }
			       array_push($checkbox,$row1["menu_name"]);
			    }
			    ?>
            
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Subadmin</h1><span></span>
					</div>
                    <form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						 <?php  if($type!=""){?>
						   <div class="_25">
						 	<p>
							 <label for="textfield" > Staff Name: &nbsp;  <b><?=$staff_name?></b></label>
							
                             </p>
						</div>
						<?php }?>
						 <?php  if($type==""){?>
                      <div class="_25">
							<p>
                                <label for="textfield">Name : <span class="error">*</span></label>
                                <input id="name" name="name" class="required" type="text" value="<?=$name?>" />
                            </p>
						</div>
					 
						
                        <div class="_25">
							<p>
                                <label for="textfield">Username : <span class="error">*</span></label>
                                <input id="username" name="username"   class="required" type="text" value="<?=$username?>" />
                            </p>
						</div>
						
						
						     <div class="_25">
							<p>
                                <label for="textfield">Passowrd : <span class="error">*</span></label>
                                <input id="pass" name="pass" value="<?=$password?>"   class="required" type="text"  />
                            </p>
						    </div>
						    <?php }?>
						     <input type="hidden" name="usid" value="<?=$id?>">
						       <input type="hidden" name="type" value="<?=$type?>">
						<div class="_25">
							<p>
                                <label for="textfield">Roll :</label>
                                <input   name="roll"  class="required" type="text" value="<?=$roll?>" />
                            </p>
						</div>
						 <div class="clear"></div>
						
						  <div class="_50">
							<p>
                                <label for="textfield">List Of Menu : <span class="error">*</span></label><div class="clear"></div> 
                                <ul  class="topnav">                               
                               <li><input  name="list_menu[]" <?php if (in_array("Standard and Section", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Standard and Section" />Standard and Section</li>
                                <li  id="Mainadmissions" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Mainadmissions')"><input   name="list_menu[]" <?php if (in_array("Main admissions", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Main admissions" /><b >Main admissions <span></span></b></div>
                                <ul>
                                <li> <a> <input name="Mainadmissions[]" <?php if (in_array("pre_admission.php", $submenu_checkbox)) {?>checked="checked" <?php }?> id="listsub_menu"  type="checkbox" value="pre_admission.php" />Pre Admission </a> </li>
                                <li> <a> <input   name="Mainadmissions[]" <?php if (in_array("pre_admission_select.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="pre_admission_select.php" />Pre Admission Selection</a> </li>
                               <li> <a>  <input   name="Mainadmissions[]" <?php if (in_array("admission.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="admission.php" />Admission</a> </li>
                                 <li> <a> <input   name="Mainadmissions[]" <?php if (in_array("admission_imp.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="admission_imp.php" />New Student import</a> </li>
                                 <li> <a>  <input   name="Mainadmissions[]" <?php if (in_array("pre_admission_allocation.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="pre_admission_allocation.php" />Student Allocation</a> </li>
                                 </ul></li>
                                 
                                <li  id="SubjectManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('SubjectManagement')"> <input  name="list_menu[]" <?php if (in_array("Subject Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Subject Management" /><b>Subject Management<span></span></b></div>
                                  <ul>
                              <li> <a>   <input   name="SubjectManagement[]" <?php if (in_array("subject_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> id="listsub_menu"  type="checkbox" value="subject_mng.php" />Classwise Subject</a> </li>
                               <li> <a>  <input   name="SubjectManagement[]" <?php if (in_array("subject_mng1.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="subject_mng1.php" />Staff Assign</a> </li>
                               <li> <a>  <input   name="SubjectManagement[]"  <?php if (in_array("stafflist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="stafflist.php" />Staffwise Assign</a> </li>
                               <li> <a>   <input   name="SubjectManagement[]" <?php if (in_array("board_select_cstaff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="board_select_cstaff.php" />Classwise Staff</a> </li>
                                  
                                 </ul></li>
                                 <li  id="ClassTimetableManage" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('ClassTimetableManage')"><input  name="list_menu[]" <?php if (in_array("Class Timetable Manage", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Class Timetable Manage" /><b>Class Timetable Manage<span></span></b></div>
                                 <ul>
                                <li> <a> <input   name="ClassTimetableManage[]" <?php if (in_array("day.php", $submenu_checkbox)) {?>checked="checked" <?php }?> id="listsub_menu"  type="checkbox" value="day.php" />Day management </a> </li>
                                <li> <a> <input   name="ClassTimetableManage[]" <?php if (in_array("peroid.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="peroid.php" />Extra Period management</a> </li>
                                 <li> <a> <input   name="ClassTimetableManage[]"  <?php if (in_array("timetable_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="timetable_mng.php" />Time Table</a> </li>
                                <li> <a>  <input   name="ClassTimetableManage[]" <?php if (in_array("staff_free_periods.php", $submenu_checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="staff_free_periods.php" />Staff Free Hours</a> </li>
                                 
                                 </ul></li>
                                 <li  id="StudentManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('StudentManagement')"><input  name="list_menu[]" <?php if (in_array("Student Management", $checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="Student Management" /><b>Student Management<span></span></b></div>
                                
                                  <ul>
                                <li> <a> <input   name="StudentManagement[]" id="listsub_menu"  type="checkbox"  <?php if (in_array("student_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> value="student_mng.php" />Student Management</a> </li>
                                 <li> <a> <input   name="StudentManagement[]"  type="checkbox" value="att_mng.php" <?php if (in_array("att_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student's Attendance Management</a> </li>
                                 <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="att_mng_today.php" <?php if (in_array("att_mng_today.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Absent List</a> </li>
                                 <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_overall.php" <?php if (in_array("student_overall.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Student's List</a> </li>
                                 <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_inactive.php" <?php if (in_array("student_inactive.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Inactive Student List</a> </li>
                                <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_newlist.php" <?php if (in_array("student_newlist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />New Student List</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="student_admission_prt.php" <?php if (in_array("student_admission_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student Application Form</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="roll_of_student.php" <?php if (in_array("roll_of_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Roll of Student</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="castewise_list.php" <?php if (in_array("castewise_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Castewise Student list</a> </li>
                                  <li> <a>  <input   name="StudentManagement[]"  type="checkbox" value="today_att_student.php" <?php if (in_array("today_att_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Student Present</a> </li>
                                 
                                 </ul></li>
                                
                                 <li id="StaffManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('StaffManagement')"><input  name="list_menu[]" <?php if (in_array("Staff Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Staff Management" /><b>Staff Management<span></span></b></div>
                                  <ul>
                                <li> <a> <input   name="StaffManagement[]" id="listsub_menu"  type="checkbox" value="staff.php" <?php if (in_array("staff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Management</a> </li>
                                <li> <a> <input   name="StaffManagement[]"  type="checkbox" value="classwise_staff.php" <?php if (in_array("classwise_staff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Classwise Staff List</a> </li>
                                <li> <a> <input   name="StaffManagement[]"  type="checkbox" value="satt_mng.php" <?php if (in_array("satt_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Attendance Management</a> </li>
                                 <li><a><input   name="StaffManagement[]"  type="checkbox" value="staff_admission_prt.php" <?php if (in_array("staff_admission_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Application Form</a></li>
                                 </ul>
                                 </li>
                                 
                                 <li id="OtherStaff" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('OtherStaff')"><input  name="list_menu[]" <?php if (in_array("Other Staff", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Other Staff" /><b>Other Staff<span></span></b></div>
                                  <ul>
                                <li> <a> <input   name="OtherStaff[]" id="listsub_menu"  type="checkbox" value="others_categorylist.php" <?php if (in_array("others_categorylist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Other Staff Category</a> </li>
                                <li> <a> <input   name="OtherStaff[]"  type="checkbox" value="others_list.php" <?php if (in_array("others_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Other Staff List</a> </li>
                                <li> <a> <input   name="OtherStaff[]"  type="checkbox" value="owatt_mng.php" <?php if (in_array("owatt_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Other Staff Attendance</a></li>
                                 </ul>
                                 </li>
                                 
                                 <li id="ParentManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('ParentManagement')"><input  name="list_menu[]" <?php if (in_array("Parent Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Parent Management" /><b>Parent Management<span></span> </b></div>                             
                                  <ul>
                                <li> <a> <input   name="ParentManagement[]" id="listsub_menu"  type="checkbox" value="parent_mng.php"  <?php if (in_array("parent_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />parants Management</a> </li>
                                <li> <a> <input   name="ParentManagement[]"  type="checkbox" value="sibling_mng.php" <?php if (in_array("sibling_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Sibling Management</a> </li>
                                
                                  </ul></li>
                                   <li  id="ExamManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('ExamManagement')"><input  name="list_menu[]" <?php if (in_array("Exam Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Exam Management" /><b>Exam Management<span></span></b></div>
                                 <ul>
                                <li> <a> <input   name="ExamManagement[]" id="listsub_menu" <?php if (in_array("classtest_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="classtest_mng.php" />Class Test Assign</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="homework_mng.php" <?php if (in_array("homework_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Home Work Assign</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="exam.php"  <?php if (in_array("exam.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Exam List</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="examtimetable_mng.php"  <?php if (in_array("examtimetable_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Exams time table</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_mng.php"  <?php if (in_array("result_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Add Exam Results</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_mng1.php"  <?php if (in_array("result_mng1.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Exam Results</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_mng_grade.php"  <?php if (in_array("result_mng_grade.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Grade Results</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="rank_card.php"  <?php if (in_array("rank_card.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Progress Card</a> </li>
                                 <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="rankcard_status.php"  <?php if (in_array("rankcard_status.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Progress Visit Status</a> </li>
                                 <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_analysis_section.php"  <?php if (in_array("result_analysis_section.php", $submenu_checkbox)) {?>checked="checked" <?php }?>/>Exam Results Analysis</a> </li>
                                <li> <a> <input   name="ExamManagement[]"  type="checkbox" value="result_analysis_student.php"  <?php if (in_array("result_analysis_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?>/>Studentwise Results Analysis</a> </li>
                                 
                                 </ul></li>
                                 
                                 
                                 <li id="StudentPromotion" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('StudentPromotion')"><input  name="list_menu[]" <?php if (in_array("Student Promotion", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Student Promotion" /><b>Student Promotion<span></span> </b></div>                             
                                  <ul>
                                <li> <a> <input   name="StudentPromotion[]" id="listsub_menu"  type="checkbox" value="promotion_student.php"  <?php if (in_array("promotion_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student Selected</a> </li>
                                <li> <a> <input   name="StudentPromotion[]"  type="checkbox" value="promotion_shuffle_student.php" <?php if (in_array("promotion_shuffle_student.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Student Shuffle</a> </li>
                                
                                  </ul></li>
                                
                                
                                 <li id="FeesManagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('FeesManagement')"><input  name="list_menu[]" <?php if (in_array("Fees Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Fees Management" /><b>Fees Management<span></span></b></div>
                                <ul>
                                <li> <a> <input   name="FeesManagement[]" id="listsub_menu"  type="checkbox" value="billing.php" <?php if (in_array("billing.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Payment</a> </li>
                              <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="feesinvoice.php" <?php if (in_array("feesinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Payment Invoice</a> </li>
                              <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="feesinvoice_reject.php" <?php if (in_array("feesinvoice_reject.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Rejected Fees Invoice</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="cheque_feesinvoice.php" <?php if (in_array("cheque_feesinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Cheque payment List</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="ftype.php" <?php if (in_array("ftype.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Type</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="fgroup.php" <?php if (in_array("fgroup.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Group</a> </li>
                               <li> <a>  <input   name="FeesManagement[]"  type="checkbox" value="feesrate.php" <?php if (in_array("feesrate.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Rate</a> </li>
                                 
                                 </ul></li>
                                 <li  id="Finance" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Finance')"><input  name="list_menu[]" <?php if (in_array("Finance", $checkbox)) {?>checked="checked" <?php }?>   type="checkbox" value="Finance" /><b>Finance<span></span></b></div>
                                 
                                   <ul>
                                <li> <a> <input   name="Finance[]" id="listsub_menu"  type="checkbox" value="income_category.php" <?php if (in_array("income_category.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Income Category</a> </li>
                               <li> <a> <input   name="Finance[]"  type="checkbox" value="income_mng.php" <?php if (in_array("income_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Income Management</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="agency.php" <?php if (in_array("agency.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Agency</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="quotation_list.php" <?php if (in_array("quotation_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Proposal Management</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="exponses_category.php" <?php if (in_array("exponses_category.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Expenses Category</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="exponse_mng.php" <?php if (in_array("exponse_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Over Expenses Manage</a> </li> 
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="exponse_mngi.php" <?php if (in_array("exponse_mngi.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Expenses Bill Paid</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="finance_Agency_reports_prt.php" <?php if (in_array("finance_Agency_reports_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Agencywise Expenses</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="finance_category_reports_prt.php" <?php if (in_array("finance_category_reports_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Categorywise Expenses</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="finance_reports_prt.php" <?php if (in_array("finance_reports_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />SubCategorywise Expenses</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="bank_account.php" <?php if (in_array("bank_account.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bank Account List</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="bdeposit_mng.php" <?php if (in_array("bdeposit_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bank Deposit Manage</a> </li>
                                   
                               <li> <a>  <input   name="Finance[]"  type="checkbox" value="bwithdrawl_mng.php" <?php if (in_array("bwithdrawl_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bank Withdrawl Manage</a> </li>
                                <li> <a> <input   name="Finance[]"  type="checkbox" value="expense_allowancelist.php" <?php if (in_array("expense_allowancelist.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Daily Allowance List</a> </li>
                                <li> <a>   <input   name="Finance[]"  type="checkbox" value="balance_sheet.php" <?php if (in_array("balance_sheet.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Ledger</a> </li>
                                 </ul></li>
                                 <li  id="Feedbacks" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Feedbacks')"><input  name="list_menu[]" <?php if (in_array("Feedbacks", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Feedbacks" /><b>Feedbacks<span></span></b></div>
                            <ul>
                                <li> <a> <input   name="Feedbacks[]" id="listsub_menu"  type="checkbox" value="feedback_mng.php" <?php if (in_array("feedback_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />parant-Staff Feedbacks</a> </li>
                               <li> <a>  <input   name="Feedbacks[]"  type="checkbox" value="feedback_mng1.php" <?php if (in_array("feedback_mng1.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Staff-Student Feedbacks</a> </li>
                              <li> <a>   <input   name="Feedbacks[]"  type="checkbox" value="staff_mng_feed.php" <?php if (in_array("staff_mng_feed.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Feed Backs From Staff</a> </li>
                                <li> <a> <input   name="Feedbacks[]"  type="checkbox" value="student_mng_feed.php" <?php if (in_array("student_mng_feed.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Feed Backs From Parents</a> </li>                                
                                 </ul></li>
                           </ul>
                            </p>
						 </div>
						 
                         <div class="_50">
							<p>
							<ul  class="topnav">  
                                <div class="clear"></div>                                
                                 <li  id="CircularandEvents" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('CircularandEvents')"><input  name="list_menu[]"  <?php if (in_array("Circular and Events", $checkbox)) {?>checked="checked" <?php }?> type="checkbox" value="Circular and Events" /><b>Circular and Events<span></span></b></div>
                                  <ul>
                                <li> <a> <input   name="CircularandEvents[]" id="listsub_menu"  type="checkbox" <?php if (in_array("circular.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  value="circular.php" />Circular Management</a> </li>
                                <li> <a> <input   name="CircularandEvents[]"  type="checkbox" value="event.php" <?php if (in_array("event.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />Events Management</a> </li>
                                <li> <a> <input   name="CircularandEvents[]"  type="checkbox" value="news.php" <?php if (in_array("news.php", $submenu_checkbox)) {?>checked="checked" <?php }?>  />NEWS Management</a> </li>
                                 
                                
                                 </ul></li>
                                 <li  id="MobileSMS" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('MobileSMS')"><input  name="list_menu[]" <?php if (in_array("Mobile SMS", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Mobile SMS" /><b>Mobile SMS<span></span></b></div>
                                    <ul>
                               <li> <a>  <input   name="MobileSMS[]" id="listsub_menu"  type="checkbox" value="sms_mng.php" <?php if (in_array("sms_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />OverAll SMS Management</a> </li>
                                <li> <a> <input   name="MobileSMS[]"  type="checkbox" value="sms_specific_mng.php" <?php if (in_array("sms_specific_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Specific SMS Management</a> </li>
                                       </ul></li>
                                 <li><input  name="list_menu[]" <?php if (in_array("Book Inventory", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Book Inventory" />Book Inventory</li>
                                 <li><input  name="list_menu[]" <?php if (in_array("Payroll Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Payroll Management" />Payroll Management</li>
                                  <li><input  name="list_menu[]" <?php if (in_array("library Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="library Management" />library Management</li>
                                  <li><input  name="list_menu[]" <?php if (in_array("Hostel Management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Hostel Management" />Hostel Management</li>
                                 
                                 <li  id="Certificates" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Certificates')"><input  name="list_menu[]" <?php if (in_array("Certificates", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Certificates" /><b>Certificates<span></span></b><div>
                                  <ul> 
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="bonafide.php" <?php if (in_array("bonafide.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bonafide Certificate</a> </li>
                               <li> <a>    <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="community.php" <?php if (in_array("community.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Community Certificate</a> </li>
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="conduct.php" <?php if (in_array("conduct.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Conduct Certificate</a> </li>
                                <li> <a>   <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="c_attend.php" <?php if (in_array("c_attend.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Attendance Certificate</a> </li>
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="board_select_marksheet.php" <?php if (in_array("board_select_marksheet.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Marklist Certificate</a> </li>
                                <li> <a>   <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="board_select_tc11.php" <?php if (in_array("board_select_tc11.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Transfer Certificate</a> </li>
                               <li> <a>  <input   name="Certificates[]"  type="checkbox" value="board_select_hallticket.php" <?php if (in_array("board_select_hallticket.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Hall Ticket</a> </li>
                               <li> <a>    <input   name="Certificates[]" id="listsub_menu"  type="checkbox" value="certificates_tuitionfees.php" <?php if (in_array("certificates_tuitionfees.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Tuition Fees Certificate</a> </li>
                              <li> <a>   <input   name="Certificates[]"  type="checkbox" value="exp_certificate_list.php" <?php if (in_array("exp_certificate_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Experience  Certificate</a> </li>
                                       </ul></li>
                                 <li  id="IDCard" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('IDCard')"><input  name="list_menu[]" <?php if (in_array("ID Card", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="ID Card" /><b>ID Card<span></span></b></div>
                                  <ul>
                              <li> <a>   <input   name="IDCard[]" id="listsub_menu"  type="checkbox" value="board_select_idcard3.php" <?php if (in_array("board_select_idcard3.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall ID Cards</a> </li>
                               <li> <a>  <input   name="IDCard[]"  type="checkbox" value="idcard.php" <?php if (in_array("idcard.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Classwise ID Cards</a> </li>
                                <li> <a>   <input   name="IDCard[]" id="listsub_menu"  type="checkbox" value="idcard_selected.php" <?php if (in_array("idcard_selected.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />selected Student ID Cards</a> </li>
                                <li> <a> <input   name="IDCard[]"  type="checkbox" value="idcard_single.php" <?php if (in_array("idcard_single.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Single Student ID Card</a> </li>
                                
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="staff_idcard_all_prt.php" <?php if (in_array("staff_idcard_all_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Overall ID Cards</a> </li>
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="staff_idcard_single.php" <?php if (in_array("staff_idcard_single.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Single Staff ID Cards</a> </li>
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="driver_idcard_all_prt.php" <?php if (in_array("driver_idcard_all_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Driver Overall ID Cards</a> </li>
                                 <li> <a> <input   name="IDCard[]"  type="checkbox" value="driver_idcard_single.php" <?php if (in_array("driver_idcard_single.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Single Driver ID Cards</a> </li>
                                </ul></li>
                                 <li  id="Vehiclemanagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Vehiclemanagement')"><input  name="list_menu[]" <?php if (in_array("Vehicle management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Vehicle management" /><b>Vehicle management<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="busfeesbilling.php" <?php if (in_array("busfeesbilling.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />BusFees Payment</a> </li>
                               <li> <a>  <input   name="Vehiclemanagement[]"  type="checkbox" value="bfeesinvoice.php" <?php if (in_array("bfeesinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />BusFees Payment Invoice</a> </li>
                              <li> <a>     <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="bchequeinvoice.php" <?php if (in_array("bchequeinvoice.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Cheque payment List</a> </li>
                              <li> <a>     <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="trstopping.php" <?php if (in_array("trstopping.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Stopping Points</a> </li>
                              <li> <a>     <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="vehicle.php" <?php if (in_array("vehicle.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Vehicle Master</a> </li>
                              <li> <a>   <input   name="Vehiclemanagement[]"  type="checkbox" value="driver.php" <?php if (in_array("driver.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Driver details</a> </li>
                                <li> <a>   <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="datt_mng.php" <?php if (in_array("datt_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Driver Attendance</a> </li>
                               <li> <a>  <input   name="Vehiclemanagement[]"  type="checkbox" value="route.php" <?php if (in_array("route.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Route Master</a> </li>
                               <li> <a>    <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="stopping_mng.php" <?php if (in_array("stopping_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Route stopping Assign</a> </li>
                               <li> <a>    <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="trbus_feesrate.php" <?php if (in_array("trbus_feesrate.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Fees Rate</a> </li>
                               <li> <a>    <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="bus_feesrate.php" <?php if (in_array("bus_feesrate.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Routewise Fees Rate</a> </li>
                                <li> <a> <input   name="Vehiclemanagement[]"  type="checkbox" value="vehicle_capacity.php" <?php if (in_array("vehicle_capacity.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Capacity Details</a> </li>
                                <li> <a>   <input   name="Vehiclemanagement[]" id="listsub_menu"  type="checkbox" value="bus_timing.php" <?php if (in_array("bus_timing.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Timing</a> </li>
                                <li> <a>  <input   name="Vehiclemanagement[]"  type="checkbox" value="boarding_point.php" <?php if (in_array("boarding_point.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff / Student & boarding points</a> </li>
                                <li> <a> <input   name="Vehiclemanagement[]"  type="checkbox" value="bus_att_mng.php" <?php if (in_array("bus_att_mng.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />vehicle Student Attendance</a> </li>
                                <li> <a> <input   name="Vehiclemanagement[]"  type="checkbox" value="busfees_overall_prt.php" <?php if (in_array("busfees_overall_prt.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Overall Feesrate</a> </li>
                                       </ul></li>
                                       <li  id="VehicleTripmanagement" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('VehicleTripmanagement')"><input  name="list_menu[]" <?php if (in_array("Vehicle Trip management", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Vehicle Trip management" /><b>Vehicle Trip management<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="VehicleTripmanagement[]" id="listsub_menu"  type="checkbox" value="vehicle_trip.php" <?php if (in_array("vehicle_trip.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Vehicle Trip Details</a> </li>
                                       </ul></li> 
                                       <li  id="VehicleManageReports" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('VehicleManageReports')"><input  name="list_menu[]" <?php if (in_array("Vehicle Manage Reports", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Vehicle Manage Reports" /><b>Vehicle Manage Reports<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="bincome_report.php" <?php if (in_array("bincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Fees Income Report</a> </li>
                               <li> <a>  <input   name="VehicleManageReports[]"  type="checkbox" value="bincome_frno_report.php" <?php if (in_array("bincome_frno_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />FR.No Based Income Report</a> </li>
                              <li> <a>     <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="bpayment_income_report.php" <?php if (in_array("bpayment_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Paid Report</a> </li>
                              <li> <a>     <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="buswiseincome_report.php" <?php if (in_array("buswiseincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Buswise Fees Income</a> </li>
                              <li> <a>     <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="stopwiseincome_report.php" <?php if (in_array("stopwiseincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Stopwise Fees Income</a> </li>
                              <li> <a>   <input   name="VehicleManageReports[]"  type="checkbox" value="boarding_point.php" <?php if (in_array("boarding_point.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Buswise Student/Staff  Report</a> </li>
                                <li> <a>   <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="vehicle_capacity.php" <?php if (in_array("vehicle_capacity.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Bus Capcity Detail Report</a> </li>
                               <li> <a>  <input   name="VehicleManageReports[]"  type="checkbox" value="boarding_point_att.php" <?php if (in_array("boarding_point_att.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Boarding Point List</a> </li>
                               <li> <a>    <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="boarding_point_att_count.php" <?php if (in_array("boarding_point_att_count.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Today Boarding Point Count</a> </li>
                               <li> <a>    <input   name="VehicleManageReports[]" id="listsub_menu"  type="checkbox" value="boarding_point_count.php" <?php if (in_array("boarding_point_count.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Boarding Point Total Count</a> </li>
                                       </ul></li>
                                       
                                 <li id="FeesReports" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('FeesReports')"><input  name="list_menu[]" <?php if (in_array("Fees Reports", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Fees Reports" /><b>Fees Reports<span></span></b></div>
                                   <ul>
                               <li> <a>  <input   name="FeesReports[]" id="listsub_menu"  type="checkbox" value="income_report.php" <?php if (in_array("income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Income Report</a> </li>
                                 <li> <a><input   name="FeesReports[]"  type="checkbox" value="income_frno_report.php" <?php if (in_array("income_frno_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />FR.No Based Income Report</a> </li>
                                <li> <a>   <input   name="FeesReports[]" id="listsub_menu"  type="checkbox" value="payment_income_report.php" <?php if (in_array("payment_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Paid Report</a> </li>
                                 <li> <a><input   name="FeesReports[]"  type="checkbox" value="payment_percentageincome_report.php" <?php if (in_array("payment_percentageincome_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Fees Paid percentage Report</a> </li>
                                 <li> <a>  <input   name="FeesReports[]" id="listsub_menu"  type="checkbox" value="classwise_income_report.php" <?php if (in_array("classwise_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Classwise Fees Income Report</a> </li>
                                <li> <a> <input   name="FeesReports[]"  type="checkbox" value="studentwise_income_report.php" <?php if (in_array("studentwise_income_report.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Studentwise Fees Income Report</a> </li>
                                       </ul></li>
                                 <li  id="Reportdatas" class="menulist" style="min-height:25px;"><div onClick="showsubmenu('Reportdatas')"><input  name="list_menu[]" <?php if (in_array("Report datas", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Report datas" /><b>Report datas<span></span></b></div>
                                 
                                  <ul>
                                <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_student_list.php" <?php if (in_array("exp_student_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Students List </a> </li>
                                <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_filterstudent_list.php" <?php if (in_array("exp_filterstudent_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Filter Students List </a> </li>
                               <li> <a> <input   name="Reportdatas[]"  type="checkbox" value="board_select_staff.php" <?php if (in_array("board_select_staff.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff List</a> </li>
                                  <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_parent_list.php" <?php if (in_array("exp_parent_list.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Parents List</a> </li>
                               <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_student_result.php" <?php if (in_array("exp_student_result.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Students Mark </a> </li>
                               <li> <a>  <input   name="Reportdatas[]"  type="checkbox" value="exp_student_att.php" <?php if (in_array("exp_student_att.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />students Attendance</a> </li>
                                  <li> <a> <input   name="Reportdatas[]" id="listsub_menu"  type="checkbox" value="exp_staff_att.php" <?php if (in_array("exp_staff_att.php", $submenu_checkbox)) {?>checked="checked" <?php }?> />Staff Attendance </a> </li>
                                       </ul></li>
                                       
                                       
                                       
                                        <li><input  name="list_menu[]" <?php if (in_array("School Calendar", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="School Calendar" />School Calendar</li>  
                                       
                                        <li><input  name="list_menu[]" <?php if (in_array("Contact Details", $checkbox)) {?>checked="checked" <?php }?>  type="checkbox" value="Contact Details" />Contact Details</li>  
                                       
                                       </ul>
                            </p>
						 </div>
                          
                          
                          
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="update" class="button" value="Update"></li>
							</ul>
						</div>
					</form>
                    
            </div>
            <?php }
					/********************************** SubAdmin EDIT Start*****************************************/
			}?>
            <?php 
              if(!isset($_GET['show']))
            {
                ?>
            
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Admin List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>                                    
                                    <th><center> Name</center></th>
                                    <th>UserName</th>    
                                     <th>Type</th>                                 
                                    <th>Access Menu</th>
                                    <th>Action</th>
                                    
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM admin_login  where admin_type='1'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{        	 
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['name']; ?></center></td>
                                <td><center><?php echo $row['email'] ?></center></td>
                                <td><center>Subadmin</center></td>
                                <td><center><?php 
                                 $query1="select * from  subadmin_accesspage where log_type='admin' and subadmin_id='$row[id]'";
                                 $res1=mysql_query($query1);
                                 while($row1=mysql_fetch_array($res1))
                                 {
                                     echo $row1["menu_name"].",";
                                 }
                                ?></center></td>
                               <td class="action">
                               <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                               <a href="subadmin_add.php?usid=<?php echo $row['id'];?>&show=edit" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="subadmin_add.php?delid=<?php echo $row['id']; ?>" class="delete" title="delete" onClick="return confirm('Are you sure you wish to delete this record?');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
									<div id="info-dialog<?php echo $count;?>" title="Sub Admin user details" style="display: none;">
            
				<p>Name     : <strong><?php echo $row['name']; ?></strong></p>
				<p>UserName : <strong><?php echo $row['email']; ?></strong></p>
				<p>password : <strong><?php echo $row['password']; ?></strong></p>
				<p>Access Menus : <strong><?php $query1="select * from  subadmin_accesspage where subadmin_id='$row[id]'";
                                 $res1=mysql_query($query1);
                                 
                                 while($row1=mysql_fetch_array($res1))
                                 {
                                     echo $row1["menu_name"].",";
                                 } ?></strong></p>
                                 <?php if($row['roll']){?>
                                 <p>Roll : <strong><?php echo $row['roll']; ?></strong></p>
                                 <?php } ?>
				</div>
                                                     <!-- Modal Box Content -->
		             
                                 <?php 
							$count++;
							} ?>            
							
							
							
							 <?php 
							$qry=mysql_query("SELECT a.fname as name,a.email,a.password,a.st_id as id  FROM staff a where admin_permission='1' ");
						 
			  while($row=mysql_fetch_array($qry))
        		{        	 
        		   // echo $row[log_type];
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['name']; ?></center></td>
                                <td><center><?php echo $row['email'] ?></center></td>
                                  <td><center>Staff</center></td>
                                <td><center><?php 
                                 $query1="select * from  subadmin_accesspage where log_type='staff' and  subadmin_id='$row[id]'";
                                 $res1=mysql_query($query1);
                                 while($row1=mysql_fetch_array($res1))
                                 {
                                     echo $row1["menu_name"].",";
                                 }
                                ?></center></td>
                               <td class="action">
                               <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                               <a href="subadmin_add.php?usid=<?php echo $row['id'];?>&show=edit&type=staff" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="subadmin_add.php?delid=<?php echo $row['id']; ?>&type=staff" class="delete" title="delete" onClick="return confirm('Are you sure you wish to delete this record?');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
									<div id="info-dialog<?php echo $count;?>" title="Sub Admin user details" style="display: none;">
            
				<p>Name     : <strong><?php echo $row['name']; ?></strong></p>
				<p>UserName : <strong><?php echo $row['email']; ?></strong></p>
				<p>password : <strong><?php echo $row['password']; ?></strong></p>
				<p>Access Menus : <strong><?php $query1="select * from  subadmin_accesspage where subadmin_id='$row[id]'";
                                 $res1=mysql_query($query1);
                                 
                                 while($row1=mysql_fetch_array($res1))
                                 {
                                     echo $row1["menu_name"].",";
                                 } ?></strong></p>
                                 <?php if($row['roll']){?>
                                 <p>Roll : <strong><?php echo $row['roll']; ?></strong></p>
                                 <?php } ?>
				</div>
                                                     <!-- Modal Box Content -->
            
                                 <?php 
							$count++;
							} ?>          
							
							<?php 
							$qry=mysql_query("SELECT a.fname as name,a.email,a.password,a.o_id as id  FROM others a where admin_permission='1' ");
						 
			  while($row=mysql_fetch_array($qry))
        		{        	 
        		   // echo $row[log_type];
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['name']; ?></center></td>
                                <td><center><?php echo $row['email'] ?></center></td>
                                  <td><center>Others</center></td>
                                <td><center><?php 
                                 $query1="select * from  subadmin_accesspage where log_type='others' and  subadmin_id='$row[id]'";
                                 $res1=mysql_query($query1);
                                 while($row1=mysql_fetch_array($res1))
                                 {
                                     echo $row1["menu_name"].",";
                                 }
                                ?></center></td>
                               <td class="action">
                               <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                               <a href="subadmin_add.php?usid=<?php echo $row['id'];?>&show=edit&type=others" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="subadmin_add.php?delid=<?php echo $row['id']; ?>&type=others" class="delete" title="delete" onClick="return confirm('Are you sure you wish to delete this record?');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
									<div id="info-dialog<?php echo $count;?>" title="Sub Admin user details" style="display: none;">
            
				<p>Name     : <strong><?php echo $row['name']; ?></strong></p>
				<p>UserName : <strong><?php echo $row['email']; ?></strong></p>
				<p>password : <strong><?php echo $row['password']; ?></strong></p>
				<p>Access Menus : <strong><?php $query1="select * from  subadmin_accesspage where subadmin_id='$row[id]'";
                                 $res1=mysql_query($query1);
                                 
                                 while($row1=mysql_fetch_array($res1))
                                 {
                                     echo $row1["menu_name"].",";
                                 } ?></strong></p>
                                 <?php if($row['roll']){?>
                                 <p>Roll : <strong><?php echo $row['roll']; ?></strong></p>
                                 <?php } ?>
				</div>
                                                     <!-- Modal Box Content -->
		                      <?php 
							$count++;
							} ?>      
							
							
							                   																
							</tbody>
						</table>
					</div>
				</div>
            <div class="clear height-fix"></div>
            <?php }?>
            </div>
           
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->
    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->
  
<link href="css/jquery.akordeon.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function($){
	$('#table-example').dataTable();
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
 
 
<script language="JavaScript">

$(document).ready(function() {
});

function showsubmenu(n) {
	//alert(n+" b span");
	if($("#"+n+" b span").hasClass('closed')) {
			$("#"+n+" b span").removeClass('closed');
		} else {
			$("#"+n+" b span").addClass('closed');
		}
	 $(".topnav  #"+n+" ul").toggle();
}

</script>
  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
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
  
  
      <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
  	  <link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
  	  <script src="payroll/js/plugins/select2/select2.js"></script>  
      <script src="js/jquery-migrate-1.2.1.js"></script>
  
  
  
   <script type="text/javascript">

	$().ready(function() {		

		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$("#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			


	    
	});
	   


	$("#add_new").change(function(){
		if(this.checked) {
   			$('#new_admin').show();
   			$('#name').val("");
   			$('#username').val("");
   			$('#pass').val("");
   			$("#new_staff").hide();
      		 $('#new_staff select').select2("val", $('option:eq(1)').val());
		 
		}else{
			$('#name').val("1");
   			$('#username').val("2");
   			$('#pass').val("3");
			$('#new_admin').hide();
			$('#new_staff').show();	
			 $('#new_staff select').select2("val", $('option:eq(0)').val());			
		}
	});	



	$().ready(function() {		
 
	 $('#new_staff select').select2 ({
			allowClear: true,
			placeholder: "Please Select..."
		}); 
});	
	
  </script>
  <style>
.menulist span {
	background: url("img/icons/packs/diagona/16x16/plus.png") no-repeat scroll 0 0 transparent;
	height: 16px;
	width: 16px;
	float: right;
	margin-top: 0px;
	margin-right: 0px;
	display: block;
	cursor: pointer;
}
.menulist span.closed {
	background: url("img/icons/packs/diagona/16x16/minus.png") no-repeat scroll 0 0 transparent;
}
  </style>
  
</body>
</html>
<? ob_flush(); ?>