<?php 
if($roll=="Principal"){
    ?>
 
<script>
$().ready(function() {
$('a[title=Edit]').each(function(index) {
    $(this).hide();
});

$('a[title=delete]').each(function(index) {
    $(this).hide();
});
$('a[title=add]').each(function(index) {
    $(this).hide();
});
});
</script>
<?php } ?>
 