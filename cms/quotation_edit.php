<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['submit']))
{
    
    $id=$_POST['id'];
	$bill_to=addslashes(trim($_POST['bill_to']));
	$name1=$_POST['name1'];
	$title=$_POST['title'];
	$total_amount=addslashes(trim($_POST['overall_totamount']));
	//echo $bill_to."-".$ship_to."<br>";
	$date=$_POST['date'];
	$date_split1= explode('/', $date);	
		 $date_day=$date_split1[0];
		 $date_month=$date_split1[1];
		 $date_year=$date_split1[2];
		 
	$qry=mysql_query("update quotation set bill_address='$bill_to',name='$name1',title='$title',total_amount='$total_amount',date='$date',day='$date_day',month='$date_month',year='$date_year',ay_id='$acyear' where q_id='$id'");
 
	//$id=mysql_insert_id();
	
	$qry=mysql_query("delete from quotation_amount where q_id='$id'");
	for ($i=0;$i<=30;$i++){
	    $names=$_POST["name"];
	    $qtys=$_POST["qty"];
	    $amounts=$_POST["amount"];
	    $total=$_POST["total"];
	   
	    $totals=$total[$i];
	    $name=$names[$i];
	    $qty=$qtys[$i];
	    $amount=$amounts[$i];
	  
	   if($totals=="" || $totals==0 ){}else{
	       $sql=mysql_query("INSERT INTO quotation_amount (q_id,name,qty,amount,total) values('$id','$name','$qty','$amount','$totals')") or die(mysql_error());
	    } 
	}
	header("Location:quotation_edit.php?qid=$id&msg=succ");
}
 ?>
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
				<li class="no-hover"><a href="quotation_list.php" title="Home">Proposal</a></li>
                <li class="no-hover">Edit Proposal</li>
			</ul>
            
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Proposal</h1>                
			<a href="quotation_list.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php 
              $qid=$_GET['qid'];
            $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Updated!!!
                       </div>
            <?php } ?>
            <?php 
            $qry=mysql_query("SELECT * FROM quotation where q_id='$_GET[qid]'") or die(mysql_error());
							$count=1;
			  $row1=mysql_fetch_array($qry);?>
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Proposal</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">PO No<span class="error">*</span></label>
                                <input name="poid" class="required" type="text" value="<?php echo $row1['po_no']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">PO Date<span class="error">*</span></label>
                                <input name="date" id="datepicker1" class="required" type="text" value="<?php echo $row1['date']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Title<span class="error">*</span></label>
                                <input name="title" class="required" type="text" value="<?php echo $row1['title']; ?>" />
                            </p>
						</div>
                    	<div class="_25">
							<p>
                                <label for="textfield">Company Name / Name <span class="error">*</span></label>
                                <input name="name1" class="required" type="text" value="<?php echo $row1['name']; ?>" />
                            </p>
						</div>
                        <div class="clear"></div>
						<div class="_50">
							<p>
                                <label for="textfield">To</label>
                                <textarea name="bill_to" class="required" rows="5" ><?php echo $row1['bill_address']; ?></textarea>
                            </p>
						</div>					
						<table class="table">
					        <thead>					        
                            <tr>
					          <th>Name /Description</th>
					           <th width="10%">Qty</th>
					            <th width="20%">Amount</th>
					           <th width="20%">Total</th>
					           <th width="5%"></th>
					          </tr>                              
					        </thead>					        
					        <tbody class="dfdf">
					       <?php
					       $query="select * from  quotation_amount where q_id='$qid' order by qa_id asc ";
					       $res=mysql_query($query);
					       $i=0;
					       while($row=mysql_fetch_array($res))
					       {
					         $name=stripslashes($row["name"]);
					         $qty=$row["qty"];
					         $amount=$row["amount"];
					         $total=$row["total"];
					           ?>
					           <tr id="hide_tr<?=$i?>" >
					           					              <td> <input type="text" name="name[]" value="<?=$name?>" /></td>
					           					            <td> <input type="text" data-required="true" id="qty<?=$i?>" value="<?=$qty?>"   name="qty[]" onkeyup="calc(<?=$i?>)" data-type="digits" class="required"> </td>
					           					            <td>  <input type="text"  data-required="true" data-type="digits"  value="<?=$amount?>"   id="amount<?=$i?>" onkeyup="calc(<?=$i?>)" name="amount[]"  class="required"></td>
					           					             <td>  <input type="text"  id="total<?=$i?>"    name="total[]"  value="<?=$total?>" readonly></td>
					           					              <td> <?php if($i!=0){?>
					           					              <img onclick="hide_table_tr(<?=$i?>)" src="img/icons/packs/fugue/16x16/minus-button.png"> 
					           					             <?php }?>
					           					             <?php if($i==0){?>
					           					             <a id="addvalue<?=$i?>" onclick="add_table_tr(<?php echo mysql_num_rows($res);?>)"> <img src="img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td><?php }?>
					           					           
					           					          </tr>
					     <?php    $i=$i+1; }
					          for ($j=$i;$j<=30;$j++){?>
					          <tr id="hide_tr<?=$j?>" <?php if($j!=0){?>style="display: none;"<?php }?>>
					            
					              <td>  <input type="text" name="name[]" value="" /></td>
					            <td> <input type="text" data-required="true" id="qty<?=$j?>"  disabled  name="qty[]" onkeyup="calc(<?=$j?>)" data-type="digits" class="required"> </td>
					            <td>  <input type="text"  data-required="true" data-type="digits"   disabled   id="amount<?=$j?>" onkeyup="calc(<?=$j?>)" name="amount[]"  class="required"></td>
					             <td>  <input type="text"  id="total<?=$j?>"    name="total[]" readonly></td>
					              <td>  
					              <img onclick="hide_table_tr(<?=$j?>)" src="img/icons/packs/fugue/16x16/minus-button.png"> 
					          </tr>
					           <?php }?>
					        </tbody>
					      </table>
						<input type="hidden" name="id" value="<?=$qid?>">
						<div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount" value="<?php echo $row1['total_amount'];?>"  readonly style="border: none; width:20%;font-size:14px; font-weight:bold;" id="overall_totamount"> </div>
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
			</div>
            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

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
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
 	var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });				
 });

    function hide_table_tr(n)
    {


   	 $("#hide_tr"+n).hide();
    	$("#qty"+n).val(0);
    	$("#amount"+n).val(0);
   	 $("#total"+n).val(0);
    	var input=$("#hide_tr"+n+' input[type="text"]');
    	input.attr("disabled","disabled");
   	 
     var vals=0;
     var checkboxes=$('input[name="total[]"]');
      	for (var i=0, no=checkboxes.length;i<no;i++) {
      		 if(checkboxes[i].value==""){}else{
      		 vals=parseFloat(checkboxes[i].value)+vals;
      		 }

      	}
        	 
     
      	$("#overall_totamount").val(vals);
    }

    function calc(n)
    {
   var qty=parseFloat($("#qty"+n).val());
   var amt=parseFloat($("#amount"+n).val());
   var tot=parseFloat(qty * amt);
   
   if(isNaN(tot)){
	   tot=0;}
   
	   
   $("#total"+n).val(tot);
   var vals=0;
   var checkboxes=$('input[name="total[]"]');
    	for (var i=0, no=checkboxes.length;i<no;i++) {
    		 if(checkboxes[i].value==""){}else{
    		 vals=parseFloat(checkboxes[i].value)+vals;
    		 }

    	}
      	 
   
    	$("#overall_totamount").val(vals);
   
    }
	
	 function add_table_tr(n)
	 {

		 var input=$("#hide_tr"+n+' input[type="text"]');

		 input.removeAttr("disabled");
		 
		var m=parseInt(n)+1;
		
		 $("#hide_tr"+n).show();
		 
		 $("#addvalue0").attr("onclick","add_table_tr("+m+")");

	 }
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>