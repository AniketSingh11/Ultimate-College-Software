<? ob_start(); ?>
<style>
.autocomplete-suggestions {
    border: 1px solid #999;
    background: none repeat scroll 0% 0% #FFF;
    cursor: default;
    overflow: auto;
}
</style>
<?php 
 
 
?>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="../Book_inventory/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function(){
  var currencies = [
    <?php
$sql = mysql_query("SELECT * FROM lms_book");
while ($thisrow = mysql_fetch_array($sql)){	
$sname=$thisrow['firstname'];
echo "{ value:'$thisrow[admission_number]-$sname', name:'$thisrow[firstname]', reg:'$thisrow[reg]', cid:'$thisrow[c_id]', sid:'$thisrow[s_id]'},";
}
?>  
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies
  });

});
</script>
<? ob_flush(); ?>