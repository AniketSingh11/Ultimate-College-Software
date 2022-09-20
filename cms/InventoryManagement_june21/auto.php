<? ob_start(); ?>
<script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function(){
  var currencies = [
    <?php
$sql = mysql_query("SELECT * FROM student WHERE b_id=$brdid AND ay_id=$acyear AND user_status='1'");
while ($thisrow = mysql_fetch_array($sql)){	
echo "{ value:'$thisrow[admission_number]-$thisrow[firstname]', reg:'$thisrow[reg]', cid:'$thisrow[c_id]', sid:'$thisrow[s_id]'},";
}
?>  
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies,
  });

});
</script>
<? ob_flush(); ?>