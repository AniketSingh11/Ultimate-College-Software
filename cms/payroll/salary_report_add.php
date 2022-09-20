 <?php
 include("header.php");
  if(isset($_POST["submit"]))
  {
	 // $sid= mysql_real_escape_string($_POST["st_id"]);
	$salary_date= mysql_real_escape_string($_POST["salary_date"]);
	$to=addslashes(trim($_POST["to"]));
	$subject= mysql_real_escape_string($_POST["subject"]);
	$cheque_no= mysql_real_escape_string($_POST["cheque_no"]);
	
	$sdate_split1= explode('-', $salary_date);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
		  
		  $date=mysql_real_escape_string($_POST["date"]);
	$total=$_POST["total"];
	
  $query="insert into staff_salary_report(month,year,date,to_address,subject,cheque_no,amount)values('$sdate_month','$sdate_year','$date','$to','$subject','$cheque_no','$total')";
	$result=mysql_query($query);
	$lastid=mysql_insert_id();
	if($result)
	{	
		header("location:salary_report_add.php?lid=$lastid&msg=succ");
	}
	else
	{
		header("location:salary_report_add.php?msg=err");
    }
	}
   ?>
   <style type="text/css">
   .error{ color:#FF0004;}
   </style>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");	   
	   include("includes/top_nav.php");	   
	   include("sidebar.php");
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Salary Report Generate  <a href="salary_report.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Salary Report Generate  
					 </h3>
                     <?php if($_GET["lid"]){?>
                     <a style="float:right" href="salary_report_prt.php?id=<?=$_GET["lid"]?>" title="Salary Report Print" target="_blank"><button type="button" class="btn btn-warning">Salary Report Print</button></a>
                     <?php } ?>
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
		     <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
    				 <div class="form-group">
									<label for="name">date</label>
                                    <div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="date" name="date" class="form-control" type="text" data-required="true" value="<?php echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
								<div class="form-group">
									<label for="name">Salary Month</label>
                                    <div class="input-group date ui-datepicker2" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date" name="salary_date" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                <div class="form-group">
									<label for="name">Subject</label>
									<input type="text" id="subject" name="subject" class="form-control" data-required="true" value="" />
								</div> 
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">To</label>
									<textarea type="text" id="to" name="to" class="form-control" data-required="true" rows="5">
The Manager
Corporation Bank
Sivakasi
Virudhunagar (Dist)</textarea>
								</div> 
								<div class="form-group">
									<label for="name">Cheque No <span class="error"></span></label>
									<input type="text" id="cheque_no" name="cheque_no" class="form-control" data-required="true" autocomplete="off">
								</div>                                 
                        </div>        
<div class="clear"></div><br>
			         <div class="col-sm-12">
                     <div id="salary">
                     </div>
                    <center>
<div class="form-group">
								<input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>
     </div>  
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">
 $("#salary_date").change(function(){
        var thiss = $(this);
		var value = thiss.val(); 
		$.get("salary_check.php",{value:value},function(data){
			$( "#salary" ).html(data);
        });
    });
</script>
</body>
</html>

 <? ob_flush(); ?>