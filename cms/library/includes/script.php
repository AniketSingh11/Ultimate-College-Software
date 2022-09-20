<script> 
$(function () {
	$('.select2-input').select2({
					placeholder: "Select..."
				});
			// Just for the demo
			$('#time-2').val ('');
});
$(function () {	
    if (!$('#donut-chart1').length) { return false; }
	donut1 ();
	$(window).resize (App.debounce (donut, 325));
});
</script>