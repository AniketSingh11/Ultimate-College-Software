<? ob_start(); ?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="Book_inventory/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function(){
  var currencies = [
    <?php
$sql = mysql_query("SELECT * FROM staff");
while ($thisrow = mysql_fetch_array($sql)){	
$sname=$thisrow['fname']." ".$thisrow['lname'];
echo "{ value:'$thisrow[staff_id]-$sname' },";
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