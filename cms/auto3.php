<? ob_start(); ?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="Book_inventory/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function(){
  var currencies = [
    <?php
$sql = mysql_query("SELECT * FROM student s INNER JOIN class c on(s.c_id=c.c_id)WHERE s.b_id='$bid' AND s.ay_id='$ayid' AND s.user_status=1 AND c.c_name='PRE KG' or c.c_name='LKG' or c.c_name='UKG'");
while ($thisrow = mysql_fetch_array($sql)){	
$sname=$thisrow['firstname']." ".$thisrow['lastname'];
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