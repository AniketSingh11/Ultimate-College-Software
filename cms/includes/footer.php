  <footer id="footer"><div class="container_12">
		<div class="grid_12">
        	<div class="footer-icon align-center"><a class="top" href="#top"></a></div>
            <span style="float:right; margin-top:-40px; color:#E1E0E0"></span>
		</div>
    </div>
</footer>
 <script src="js/jquery.min.js"></script>
 <script type="text/javascript">
	$().ready(function() {
		 var thisPage = GetCurrentPageName();
		 var myarray=<?=json_encode($permissions_submenu)?>;
		
		  $(".sub li a").each(function(){
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
			$(".sub li a").hide();
			 $(".sub li a").each(function(){
				 if(myarray!=null){
		           var status_id = $(this).attr('href');
		           
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

