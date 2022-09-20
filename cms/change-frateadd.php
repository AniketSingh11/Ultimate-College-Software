<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php"); 
 include("includes/functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>1</title>
</head>

<body>
<!--<form id="form1" name="form1" method="post" action="">
    <label for="fgroup">Websites</label>
    <select name="fgroup" id="fgroup">
    <option value="">Select</option>
    
        <option value="Design">Design</option>
        <option value="Dev">Dev</option>
        <option value="Ecom">Ecom</option>
    </select>
</form>-->
<?php
//unset($_SESSION['frate']);
echo $frateid=$_SESSION['frate']['frid'];
echo $fratefrom=$_SESSION['frate']['ffrom'];
echo $frateto=$_SESSION['frate']['fto'];
echo $frateamount=$_SESSION['frate']['amount'];
			
 ?>
<form id="validate-form" class="block-content form" method="post" action="">
                	<table width="100%">
               			<tr>
                        	<td width="300px">
                            	<p style="margin:5px 10px">
                                    <label for="required">Fees Group Name:</label>
                                     <select name="fgroup" id="fgroup" class="required" >
                                	<option value="">Select Fees Type</option>
                                    <?php 
		$sql1=mysql_query("SELECT * FROM frate WHERE c_id=9 AND b_id=1 AND ay_id=2 AND rate='Old' ORDER BY fg_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$ffgid=$row2['fg_id'];
									$frid=$row2['fr_id'];
									$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$ffgid");
									 $ffgroup=mysql_fetch_array($fgrouplist);
									if($frateid==$frid){?>
                                    <option value="<?php echo $frid;?>" selected="selected"><?php echo $ffgroup['fg_name'];?></option>
                                    <?php } else { ?>
                                     <option value="<?php echo $frid;?>"><?php echo $ffgroup['fg_name'];?></option>
                                     <?php } } ?>
                                    </select>										
								</p> <!-- .field-group -->
                            </td>
                            <td>
                            	<p style="margin:5px 10px">
                                    <label for="required">Fees From:</label>
                                    <?php 
				$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
				?>	
                                    <select name="ffrom" id="ffrom" class="required" onchange="change_amountfrom()" >
                                    <?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($fratefrom==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo  $montharray[$cmonth-1]?></option>
            <?php }else { ?>
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth-1]?></option>            
            <?php } }?>	
                                    </select>										
								</p> <!-- .field-group -->
                            </td>
                            <td>
                            	<p style="margin:5px 15px">
                                    <label for="required">Fees To:</label>
                                    <select name="fto" id="fto" class="required" onchange="change_amountfrom()"  >
                                	<?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($frateto==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth-1]?></option>
            <?php }else { ?>				
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth-1]?></option>            
            <?php } } ?>	
                                    </select>										
								</p> <!-- .field-group -->                               	
                            </td>
                            <td width="150px">
                            	<p style="margin:5px 15px">
                                    <label for="required">Fees:</label>
                                    <input type="text" name="fees" id="fees" class="biginput" id="autocomplete" class="required" value="<?php echo $frateamount;?>" readonly="readonly" />										
								</p> <!-- .field-group -->
                            </td>
                            <td>
                            <input type="hidden" id="fdisid" value="1" />
                            <input type="hidden" id="ftyvalue" value="6" />
                            <input type="hidden" id="feesvalue" value="<?php echo $frateamount;?>" />
                            <button style="margin:15px 0 0 0" type="submit" name="add-fees" class="btn btn-green">Add</button>
                            </td>
                        </tr>
                        </table>
                        </form>
 <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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
  
  
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php if(!$_GET['roll']){ include("auto.php"); }?>
  <script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your Billing, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		document.form1.command.value='update';
		document.form1.submit();
	}
	function cancel_cart(){
		if(confirm('This will cancel your Bill, continue?')){
			document.form1.command.value='cancel';
			document.form1.submit();
		}
	}
	function change_amountfrom() { 
      var ffromvalue = parseFloat(document.getElementById('ffrom').value);
	  var ftovalue = parseFloat(document.getElementById('fto').value);
	  var ftovalue = ftovalue+1;
	   if((ftovalue-1) < ffromvalue) {
      		alert("Please Select valid months");
			location.reload();
			return;			
   		}
	  fees = document.getElementById('fees');
	  var feesvalue =parseFloat(feesvalue = document.getElementById('feesvalue').value);
	  var ftyvalue = parseFloat(document.getElementById('ftyvalue').value);
	  var amount=parseFloat(((ftovalue-ffromvalue)/ftyvalue)*feesvalue);
	   fees.value = amount.toFixed(2); 
}
		

</script>                        
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
    function languageChange()
    {
         var lang = $('#fgroup option:selected').val();
        return lang;
    }
    $('#fgroup').change(function(e) { 
        var lang = languageChange();
		var fees= $("#fdisid").val();
        //var dataString = 'lang=' + lang +'fdisid=1';
        $.ajax({
            type: "POST",
            url: "pass_value.php",
            //data: dataString,
			data :{"lang":lang,"fdisid":fees},
            dataType: 'json',
			cache: false,
			//async: false,
 			success: function(response) {
                    alert(response.message);
					//window.location.reload();					
                },
			error: function (jqXHR, textStatus, errorThrown) {
               // alert("error");
			  // window.location.reload();
            }
        });
		//location.reload();
		window.location.reload();
        return false;
    });
});
</script>
</body>
</html>