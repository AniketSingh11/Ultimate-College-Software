<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 
 if (isset($_POST['submit']))
{
	$part_country="";
	foreach ($_POST['menuname'] as $selectedOption1)
    {
		 $part_country.=$selectedOption1.",";
	}
	echo $part_country;
}
?>

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
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
 <script src="js/jquery-1.9.1.min.js"></script>
<script>
$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
	});
            $(document).ready(function() {
                $(".add").click(function() {
                    $('<div class="field"><label>Sub-Menu Name:</label><input type="text" name="menuname[]" /><span class="rem" ><a href="javascript:void(0);" >Remove</span></div>').appendTo(".contents");
                });
                $('.contents').on('click', '.rem', function() {
                    $(this).parent("div").remove();
                });

            });
        </script>
</head>

<body>
<form action="" method="post">
<div class="field"><label>Sub-Menu Name:</label><input type="text" name="menuname[]" /><span><a href="javascript:void(0);" class="add" >Add More</a></span>
                                <div class="contents"></div></div>
                                
     <input type="submit" name="submit" class="button" value="Submit">                           
 </form>                               
</body>
</html>
