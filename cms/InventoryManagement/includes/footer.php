<div id="footer">
	Copyright &copy; 2016, Inventory.
</div>

<!-- start without conflict select2 js files -->
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script src="../payroll/js/plugins/select2/select2.js"></script> 
<script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.js"></script>
<!-- end select2 js files  -->
    <script type="text/javascript">
	var jq = jQuery.noConflict();
  jq(document).ready(function() {
		 
		  
		  //select 2 dropdown	
		 jq('select.select2').select2 ({
			allowClear: true,
			placeholder: "Please Select...",
			width: 'resolve'
		});
		
		
		//start validation for select2
	//Initialize the validation object which will be called on form submit.
    var validobj = jq(".form").validate({
        onkeyup: false,
        errorClass: "myErrorClass",

        //put error message behind each form element
        errorPlacement: function (error, element) {
            var elem = $(element);
            error.insertAfter(element);
        },

        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2-offscreen")) {
                $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
            } else {
                elem.addClass(errorClass);
            }
        },

        //When removing make the same adjustments as when adding
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2-offscreen")) {
                $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        }
    });

    $(document).on("change", ".select2-offscreen", function () {
        if (!$.isEmptyObject(validobj.submitted)) {
            validobj.form();
        }
    });

    $(document).on("select2-opening", function (arg) {
        var elem = $(arg.target);
        if ($("#s2id_" + elem.attr("id") + " ul").hasClass("myErrorClass")) {
            //jquery checks if the class exists before adding.
            $(".select2-drop ul").addClass("myErrorClass");
        } else {
            $(".select2-drop ul").removeClass("myErrorClass");
        }
    });
		  //end validation for select2
	});	
 </script>
 
 <script src="javascripts/all.js"></script>
 <ul>
   <li>
     <!-- <script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" src="js/currency-autocomplete.js"></script>-->
     <link rel="stylesheet" href="../payroll/js/plugins/select2/select2.css" type="text/css" />
     
     <link rel="stylesheet" href="stylesheets/style_custom.css" type="text/css" />
     
   </li>
 </ul>
