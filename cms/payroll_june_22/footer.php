<footer id="footer">
	 <ul class="nav pull-right">
		 <li>
			Copyright &copy; 2014 Payroll Management System.
		 </li>
	 </ul>
 </footer>
 

  .
<script src="./js/libs/jquery-1.9.1.min.js"></script>
<script src="./js/libs/jquery-ui-1.9.2.custom.min.js"></script>
<script src="./js/libs/bootstrap.min.js"></script>

<script src="./js/plugins/icheck/jquery.icheck.js"></script>
<script src="./js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="./js/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="./js/plugins/simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="./js/plugins/select2/select2.js"></script>
<script src="./js/plugins/autosize/jquery.autosize.min.js"></script>
<script src="./js/plugins/textarea-counter/jquery.textarea-counter.js"></script>
<script src="./js/plugins/fileupload/bootstrap-fileupload.js"></script>

<script src="./js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./js/plugins/datatables/DT_bootstrap.js"></script>
<script src="./js/plugins/tableCheckable/jquery.tableCheckable.js"></script>
<script src="./js/plugins/magnific/jquery.magnific-popup.min.js"></script>
<script src="./js/plugins/howl/howl.js"></script>

<script src="./js/App.js"></script>

<script src="./js/demos/popups.js"></script>

<script src="./js/plugins/parsley/parsley.js"></script>

<script src="./js/demos/form-extended.js"></script>

<script src="./js/libs/raphael-2.1.2.min.js"></script>
<script src="./js/plugins/morris/morris.min.js"></script>

<script src="./js/demos/charts/morris/area.js"></script>
<script src="./js/demos/charts/morris/donut.js"></script>

<script src="./js/plugins/sparkline/jquery.sparkline.min.js"></script>

<script src="./js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="./js/demos/calendar.js"></script>


<script src="./js/demos/dashboard.js"></script>
<script src="./js/demos/sliders.js"></script>



  
<script type="text/javascript">
/*var jq = $.noConflict();
jq(document).ready(function(){
	
	jq('#employeez').multipleSelect();
});*/
</script>

 <script type="text/javascript">
	$().ready(function() {
		 var thisPage = GetCurrentPageName();
		 var myarray=<?=json_encode($permissions_submenu)?>;
		
		  $(".sub-nav li a").each(function(){
	           var status_id = $(this).attr('href');
	           if(thisPage==status_id){
	        	  $(this).parents().addClass('sub1');
				  $(this).parents().prev().addClass('current');
				  $(this).addClass('current');
	           }	          
	        });
			$(".menu li a").each(function(){
	           var status_id = $(this).attr('href');
	           if(thisPage==status_id){
	        	  $(this).addClass('current');
	           }	          
	        });

			<?php if($_SESSION['admin_type']!="0"){?>
			$(".sub-nav li a").hide();
			 $(".sub-nav li a").each(function(){
				 if(myarray!=null){
		          //var status_id = $(this).attr('href');
				  
		           var url_link = $(this).attr('href');
				   
				   if ( url_link.indexOf('?') > -1 )  {   
						var res = url_link.split("?"); 
						var status_id =res[0];  
					} 
				   else{
					   var status_id = $(this).attr('href');
				   }
		           
		           if(jQuery.inArray(status_id, myarray)!==-1){
		        	   
		        	   $(this).show();
					  
		           }	 
				 }         
		        });
<?php }?>
$(".nav1  li a").show();

			/*if(jQuery.inArray("test", myarray)!==-1){
			    // the element is not in the array
			    alert("in");
			}*/
			
	  });
	
	function GetCurrentPageName() {
        var sPath = window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
       // var index = sPage.indexOf('.');
        //sPage = sPage.substring(0, index);
        return sPage.toLowerCase();
  }

	function GetCurrentPageName() {
        var sPath = window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
       // var index = sPage.indexOf('.');
        //sPage = sPage.substring(0, index);
        return sPage.toLowerCase();
  }
  </script>