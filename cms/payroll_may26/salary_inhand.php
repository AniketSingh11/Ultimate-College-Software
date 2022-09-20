 <?php
 include("header.php");
 
    if(isset($_GET["submit"]))
  {
	 // $sid= mysql_real_escape_string($_POST["st_id"]);
	$date= mysql_real_escape_string($_GET["date"]);
	$date1= mysql_real_escape_string($_GET["date1"]);
	$title= mysql_real_escape_string($_GET["title"]);
	
	
	$sdate_split1= explode('-', $date1);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
		  
		 $date1= $sdate_month."-". $sdate_year;
	
  $query="insert into salary_inhand(month,year,date1,date,title)values('$sdate_month','$sdate_year','$date1','$date','$title')";
  //echo "insert into salary_inhand(month,year,date,title)values('$sdate_month','$sdate_year','$date','$title')"; die;
	$result=mysql_query($query);
	$lastid=mysql_insert_id();
	if($result)
	{	
		header("location:salary_inhand.php?lid=$lastid&msg=succ");
	}
	else
	{
		header("location:salary_inhand.php?msg=err");
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
			 <h1> Salary Report Generate  <a href="salary_inhand_report.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
                     <a style="float:right" href="salary_inhand_prt.php?id=<?=$_GET["lid"]?>" title="Salary Report Print" target="_blank"><button type="button" class="btn btn-warning">Salary Report Print</button></a>
                     <?php } ?>
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="get" enctype="multipart/form-data" name="first">
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
		                                <input id="date1" name="date1" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                <div class="form-group">
									<label for="name">Title</label>
									<input type="text" id="title" name="title" class="form-control" data-required="true" value="" />
								</div> 
                                
</div>
		                               
								</div>
                                 <div class="col-sm-12">
                     <div id="salary">
                     </div>

<div class="form-group">
								
								<input type="hidden" name="amount" value="<?php echo $employee11['s_type'];?>"/>
								<input type="reset" name="reset" class="btn btn-default">
									<input type="submit" name="submit" class="btn btn-primary">
								</div>
</center>
                                </div>
    
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">

 $("#date1").change(function(){
	
        var thiss = $(this);
		var value = thiss.val(); 
		$.get("salary_check_hand.php",{value:value},function(data){
			$( "#salary" ).html(data);
        });
    });
</script>
</body>
</html>

 <? ob_flush(); ?>