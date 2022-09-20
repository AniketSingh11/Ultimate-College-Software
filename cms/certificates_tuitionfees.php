<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/admission.php");
 $bid=$_GET['bid']; 
 if (isset($_POST['submit']))
{/*
	$bid=mysql_real_escape_string($_POST['bid']);
    $c_id=mysql_real_escape_string($_POST['n_cid']);
    $s_id=mysql_real_escape_string($_POST['n_sid']);
    
    
	foreach ($_POST['ms_example'] as $selectedOption)
    { 
	                 $ssid=$selectedOption;	 
	                 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
	                 $row=mysql_fetch_row($studentlist);

	                 $admission_number=$row[1];
					 

					 $query1=mysql_query("select * from student where admission_number='$admission_number' and ay_id='$acyear'");
					 
					 if(mysql_num_rows($query1)=="0"){
					     
					     
	 $query=mysql_query("insert into student(admission_number,firstname,lastname,middlename,dob,day,month,year,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,state,country,pin,phone_number,phone1,phone2,phone3,user_status,joined_date,last_login,bar_code,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,from_school,eslc,tc,doa,protected,mother_tongue,height,weight,std_leaving,no_date_tran,dol,reason_leaving,school_pubil,remarks,b_id,stype,fdis_id,r_id,sp_id,busfeestype,ay_id,photo,pa_id,p_id)
					          values ('$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]','$row[12]','$row[13]','$row[14]','$row[15]','$row[16]','$row[17]','$row[18]','$row[19]','$row[20]','$row[21]','$row[22]','$row[23]','$row[24]','$row[25]','$row[26]','$row[27]','$row[28]','$row[29]','$row[30]','$row[31]','$c_id','$s_id','$row[34]','$row[35]','$row[36]','$row[37]','$row[38]','$row[39]','$row[40]','$row[41]','$row[42]','$row[43]','$row[44]','$row[45]','$row[46]','$row[47]','$row[48]','$row[49]','$row[50]','$row[51]','$row[52]','$bid','$row[54]','$row[55]','$row[56]','$row[57]','$row[58]','$acyear','$row[60]','$row[61]','$row[62]')");

	               $new_ss_id=mysql_insert_id();
	 $parentlist=mysql_query("SELECT * FROM parent WHERE ss_id=$ssid");
	 $row1=mysql_fetch_row($parentlist);
	 
	 $query1=mysql_query("insert into parent(p_name,password,phone_number,phone1,phone2,phone3,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,email,admin_no,b_id,sibling)
	  values ('$row1[1]','$row1[2]','$row1[3]','$row1[4]','$row1[5]','$row1[6]','$row1[7]','$row1[8]','$c_id','$s_id','$row1[11]','$acyear','$new_ss_id','$row1[14]','$row1[15]','$bid','$row1[17]')");
	     
					                          }
	}
	 header("Location:promotion_student.php?bid=$bid&msg=succ");
	 exit;	
*/}
 ?>
 <link href="css/multiselect/multiselect.css" rel="stylesheet" type="text/css" />
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
    <?php 
			
			if($bid){
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $bo=mysql_fetch_array($boardlist);
			}else{
                       
                       $board_query=mysql_query("SELECT * FROM board  order by b_id asc");
                       $bo=mysql_fetch_array($board_query);
                       
                       $bid=$bo['b_id'];
                       
                   }
			?>
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
            
               
				<li class="no-hover">CERTIFICATE FOR PAYMENT OF TUITION FEES</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
		  <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function1()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								 
                 </div>
		
			<div class="container_12">
            <div class="grid_12">
            <?php  $id=$_GET["id"];
					 $s=array();
                            $qry1=mysql_query("SELECT * FROM sibling where ss_id='$id'") or die (mysql_error());
                             $row1=mysql_fetch_array($qry1);
                             $p_id=$row1["p_id"];
                             array_push($s,$id);
                             $qry1=mysql_query("SELECT * FROM sibling where p_id='$p_id' and ss_id!='$id'") or die (mysql_error());
                             while($row1=mysql_fetch_array($qry1))
                             {
                            $ss_id=$row1["ss_id"];
                           
                             array_push($s,$ss_id);
                             }
                            $ss=implode(",",$s);
                            
                         
                        function total_amount($b,$c,$fdis,$acyear,$ftype)
                        {
                            
							$cid=$c;
							$bid=$b;
							$rate=$ftype;
					$total1=0;
					$fdisid2=$fdis;
				 	$qry=mysql_query("SELECT * FROM mfrate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND rate='$rate'");
				 		  while($row=mysql_fetch_array($qry))
							{ 
							$frid=$row['fr_id'];
							$fgid2=$row['fg_id'];
							
								if($fgid2){
								$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$fgid2");
												  $fgroup=mysql_fetch_array($fgrouplist);
												  $fgroupname=$fgroup['fg_name'];	
												  $ftyid=$fgroup['fty_id'];
												  $fto=$fgroup['end'];
												  if($fto==0){
													  $fto=12;
												  }
								  $ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];
								}
								
						$frvaluelist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND ay_id=$acyear"); 
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
									  if($ftypevalue==1){
								  $total1 +=$frvalue['dis_value']*$fto;
									  }else{
								  $total1 +=$frvalue['dis_value'];
									  }
								  }
								   }
								   
                       return $total1;                       
                       }    
                            ?>
            
            <div class="block-border">
            
					<div class="block-header">
						<h1>Select Student or Parent</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="POST">
				 
						
                        <div class="_100">
							<p>
								<label for="select">Section / Group (Student Name): <span class="error">*</span></label>
                               <select name="n_sid" id="n_sid"  data-required="true"  class='required'  onchange="change_function1(this.value)"  style="width:90%">
									<option value="">Plese select Student </option>
                                        <?php 
										$emp_query="select * from student where b_id='$bid' and ay_id='$acyear' order by firstname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
                                        $ss_id=$emp_display["ss_id"];
                                        $c_id=$emp_display["c_id"];
                                        $s_id=$emp_display["s_id"];
                                        
                                        $qry1=mysql_fetch_array(mysql_query("select * from class where c_id='$c_id'"));
                                        $class_name=$qry1["c_name"];
                                        $qry1=mysql_fetch_array(mysql_query("select * from section where s_id='$s_id'"));
                                        $section_name=$qry1["s_name"];
                                        
                                        $class=$class_name." - ".$section_name." ";
										 		?>
                                        <option value="<?php echo $ss_id;?>" <?php if($ss_id==$id){ echo "selected"; }?>><?php echo  $class.$emp_display["admission_number"]."-".$emp_display["firstname"]." ".$emp_display["lastname"]; ?></option>
                                  <?php } ?>								
                            		 				
								</select>
							</p>
						</div> 
						
						<input type="hidden" name="bid"   class='required'  value="<?=$bid?>">
                        <div id="test"></div>  
        						
        						
						
                        <div class="clear"></div>
						 
					</form>
					</div>
					 </div>
					
					 <div class="grid_12" <?php if(!$id){?>style="display: none;" <?php }?>>
				<div class="block-border">
					<div class="block-header">
                    	<h1>Overall Student Fees Detail - <?php echo $bo['b_name'];?></h1>  
                         <?php if($id){?>                        
                        <a href="tuitionfees_prt.php?id=<?php echo $id;?>" target="_blank" style="padding-top:5px;"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Print Certificate</button> </a>
					<?php }?>                      
                        <span></span>
                   </div>
                  <div class="block-content">
					 
					<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                   
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                     <th>Board</th>
                                     <th>Class-Section</th>
                                    <th>Parent's name</th>
                                     
                                    <th>Total Amount</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                           
                            
                            
                            
							$qry="SELECT * FROM student WHERE ay_id=$acyear";
							if($bid){
								$qry .="  and ss_id IN ($ss)";
							}
							$qry ." ORDER BY c_id,s_id,gender,firstname ASC";
							$qry1=mysql_query($qry);
							$count=1;
			  while($row=mysql_fetch_array($qry1))
        		{
					$cid=$row['c_id'];
							$sid=$row['s_id'];	
							$bid=$row['b_id'];
							$fdis=$row['fdis_id'];
							$boardlist=mysql_fetch_array(mysql_query("SELECT * FROM board WHERE b_id=$bid"));
							$board_name=$boardlist["b_name"];
							
							$stype=$row['stype'];
							
							if($stype=="Old")
							{
							    $ftype="0";
							}else{
							    $ftype="0,1";
							}
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                              
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                 <td><center><?php echo $board_name; ?></center></td>
                                  <td><center><?php echo $class['c_name']."-".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row['fathersname']; ?></center></td>
                            
                            
                            
                                <td><center><?php  echo "Rs. ".total_amount($bid,$cid,$fdis,$acyear,$stype); ?></center></td>
								 <td width="100px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                                             </td>
								</tr> 
                                                     <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count;?>" title="<?php echo $row['admission_number']; ?>, This student details" style="display: none;">
            <center><img src="./img/student/<?php echo $row['photo']; ?>" alt="student photo" width="60" height="60"></center>
				<p>Admin NO : <strong><?php echo $row['admission_number']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['firstname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lastname']; ?></strong>  </p>   
                
                <p>Father / Guardian Name: <strong><?php echo $row['fathersname']; ?></strong>  </p>   
                
                <p>Father / Guardian Occupation : <strong><?php echo $row['fathersocupation']; ?></strong>  </p> 
                
                <p>Father / Guardian Monthly Income : <strong><?php echo $row['p_income']; ?></strong>  </p> 
                
                <p>Mother's Name : <strong><?php echo $row['m_name']; ?></strong>  </p> 
                
                <p>Mother's Occupation : <strong><?php echo $row['m_occup']; ?></strong>  </p> 
                
                <p>Mother's Monthly Income : <strong><?php echo $row['m_income']; ?></strong>  </p>   
                
                <p>Date of admission :  <strong><?php echo $row['doa']; ?></strong>  </p>   
                
                <p>Date Of Birth : <strong><?php echo $row['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Nationality : <strong><?php echo $row['nation']; ?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong> </p>   
                
                <p>Caste : <strong><?php echo $row['caste']; ?></strong>  </p>   
                
                <p>Subcaste : <strong><?php echo $row['sub_caste']; ?></strong>  </p>   
                
                <p>Blood Group : <strong><?php echo $row['blood']; ?></strong> </p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $row['phone_number']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong>  </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong> </p>   
                
                <p>Town or village Name : <strong><?php echo $row['city_id']; ?></strong> </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $row['pin']; ?></strong> </p>   
                
                <p>Mother Tongue : <strong><?php echo $row['mother_tongue']; ?></strong> </p>   
                
                <p>Height : <strong><?php echo $row['height']; ?></strong> </p>
                
                <p>Weight : <strong><?php echo $row['weight']; ?></strong> </p>
                
                <p>Remarks : <strong><?php echo $row['remarks']; ?></strong> </p>
                
                <p>student type : <strong><?php echo $row['stype']; ?></strong> </p>
                
                <?php 
				$fdis_id=$row['fdis_id'];
				if($fdis_id){ 
				//$rid1=$invoice['r_id'];
								  $qry6=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdis_id"); 
								  $row6=mysql_fetch_array($qry6);
				?>
                <p>Student Category  : <strong><?php echo $row6['fdis_name']; ?></strong> </p>   
                <?php } $rid=$row['r_id'];
				$spid=$row['sp_id'];
				if($rid){ 
				//$rid1=$invoice['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $row5=mysql_fetch_array($qry5);
				?>
                <p>Bus Route Name : <strong><?php echo $row5['r_name']; ?></strong> </p>   
                <?php } if($spid){
					 $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid"); 
								  $row6=mysql_fetch_array($qry6);?>				
                <p>Stopping Point : <strong><?php echo $row6['sp_name']; ?></strong> </p> 
                
                <?php } 
						$fesstypearray=array("Normal Fees","Sp.Fees","Onetime Sp.Fees");
						$busfeestype=$row['busfeestype'];
				 	 if($rid){ 
					 ?>				
                <p>Bus Fees Rate Type : <strong><?php echo $fesstypearray[$busfeestype]; ?></strong> </p> 
                <?php } ?>
                <p>Status  : <?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </p>
                </div>
                				
			</div> <!--! end of #info-dialog -->
            
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					
					</div>
				</div>
            </div>
				
           
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->
  
    <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable({
  'iDisplayLength': 50
});
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


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
  <script type="text/javascript">
	$().ready(function() {		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
	});
  </script>
  
  
  
      <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
  	  <link rel="stylesheet" href="library/js/plugins/select2/select2.css" type="text/css" />
  	  <script src="library/js/plugins/select2/select2.js"></script>  
      <script src="js/jquery-migrate-1.2.1.js"></script>
      <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
      <script type="text/javascript">
$().ready(function() {	

	 $('#n_sid').select2 ({
			allowClear: true,
			placeholder: "Please Select..."
		})  
		$('#o_sid').select2 ({
			allowClear: true,
			
			placeholder: "Please Select..."
		})  
	
	
		if($("#msc").length > 0){
        $("#msc").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
            selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
            afterSelect: function(value, text){
           	 
                //action
            },
            afterDeselect: function(value, text){
                //action
            }            
        });
        

       
        $("#ms_select").click(function(){
           
            $('#msc').multiSelect('select_all');
        });
        $("#ms_deselect").click(function(){
            $('#msc').multiSelect('deselect_all');
        });        
    }    	
	});
    function showCategory(str,ayid,prefix) {
  	 if(prefix=="o"){
 		  $(".select2-search-choice").remove();
  		 $("#test").html("");
  	 }else{
var show="show";
$('.select2-chosen').html("");
 
//$(".ms-selection .ms-list li").find("span").css({"color": "red", "border": "2px solid red"});

  	 }
        if (str == "") {
            document.getElementById(prefix+"_sid").innerHTML = "";
            return;
        }
      
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(prefix+"_sid").innerHTML = xmlhttp.responseText;
                
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str+"&show="+show, true);
        xmlhttp.send();
        
	
		
    }

    function showstudent(str,ayid,prefix) {
        var standard=$("#"+prefix+"_cid").val();

       var section =$("#"+prefix+"_sid").val();
      
   
	$.get("promotion_calc.php",{section:section,value:standard, bid:<?php echo $bid;?>, ayid:ayid},function(data){
		$("#test").html(data);
    });

    }

function change_function1(n){ 
		
	    var bid=document.getElementById('bid').value;
		 window.location.href = 'certificates_tuitionfees.php?bid='+bid+'&id='+n;
		 	  
		}
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