<?php

function thefunction($number) {
    if ($number < 0)
        return 0;
    return $number;
}

include("includes/config.php");
if ((isset($_GET['value']) && $_GET['value'] != '') && (isset($_GET['bid']) && $_GET['bid'] != '') && (isset($_GET['ayid']) && $_GET['ayid'] != '')) {

    $b_id = $_GET['bid'];
    $acyear = $_GET['ayid'];
    $sections = $_GET['section'];

    $section = join(',', $sections);

    $standard = $_GET['value'];

    $qry = mysql_query("SELECT * FROM `year` where ay_id = '$acyear'  order by ay_id asc");
    $res = mysql_fetch_array($qry);
    $new_ayid = $res["ay_id"];

    $pro = array();
    $st_qry = "SELECT * FROM student WHERE s_id IN ($section) and  (ay_id='$acyear' AND  b_id='$b_id' AND c_id='$standard')  AND  user_status='1'   ORDER BY ss_id ASC";
   
    $query = mysql_query($st_qry);

    echo '<div class="_100">
							<p>
                             <div id="msc1">Total number of Students ' . mysql_num_rows($query) .
    '</div>
                            <select  id="msc" name="ms_example[ ]"   multiple="multiple" >';
    while ($row = mysql_fetch_assoc($query)) {
        $cid1 = $row['c_id'];
        $s_id1 = $row['s_id'];
        $admission_number = $row['admission_number'];
        $user_status = $row['user_status'];
        $check = 0;
        if ($user_status == 0) {

            if ($row['reason_leaving'] != "" || $row['std_leaving'] != "" || $row['no_date_tran'] != "" || $row['dol'] != "") {
                $check = 1;
            }
        }

        $query1 = mysql_query("select * from student where admission_number='$admission_number' and ay_id='$new_ayid'");

        if (mysql_num_rows($query1) != "0" && $check == 0) {


            $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid1");
            $class = mysql_fetch_array($classlist);

            $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$s_id1");
            $sect = mysql_fetch_array($sectionlist);

            array_push($pro, $row['ss_id']);
            echo '<option value="' . $row['ss_id'] . '">' . $row['admission_number'] . " - " . $row['firstname'] . " " . $row['lastname'] . " - " . $class['c_name'] . " - " . $sect['s_name'] . '</option>';
        }
    }
    echo '</select> 
                                        <div class="btn-group">
                                            <span class="button blue" id="ms_select">Select all</span>
                                            <span class="button blue" id="ms_deselect">Deselect all</span>
                                        </div>
                                    
							</p>
						</div>';
}
?>
<script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>

<script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.js'></script>  
<script type='text/javascript' src='js/plugins/multiselect/jquery.quicksearch.js'></script> 
<script type="text/javascript">
    $().ready(function() {

        var a =<?php echo json_encode($pro); ?>;
        if ($("#msc").length > 0) {
            $("#msc1").html("Total number of Students <?= count($pro) ?>");
            $("#msc").multiSelect({
                //<div id='deselect_item'>Selected Number of students 0</div><div class='multipleselect-header'>Selected items</div>  
                selectableHeader: "<div class='multipleselect-header'>Selectable item</div><input type='text' class='search-input' autocomplete='off' placeholder=' \"Student Name\"'>",
                selectionHeader: "<div id='deselect_item'>Selected Number of students 0</div><div class='multipleselect-header'>Selected items</div><input type='text' class='search-input' autocomplete='off' placeholder=' \"Student Name\"'>",
                afterInit: function(ms) {
                    var that = this,
                            $selectableSearch = that.$selectableUl.prev(),
                            $selectionSearch = that.$selectionUl.prev(),
                            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                            .on('keydown', function(e) {
                                if (e.which === 40) {
                                    that.$selectableUl.focus();
                                    return false;
                                }
                            });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                            .on('keydown', function(e) {
                                if (e.which == 40) {

                                    that.$selectionUl.focus();
                                    return false;
                                }
                            });
                },
                afterSelect: function() {

                    this.qs1.cache();
                    this.qs2.cache();
                    var select_able = $(".ms-selection .ms-list li:visible").length;
                    $("#deselect_item").html("Selected Number of students " + select_able);

                },
                afterDeselect: function() {
                    this.qs1.cache();
                    this.qs2.cache();

                    var select_able = $(".ms-selection .ms-list li:visible").length;
                    $("#deselect_item").html("Selected Number of students " + select_able);

                }
            });

            $("#ms_select").click(function() {
                $('#msc').multiSelect('select_all');

            });

            $("#ms_deselect").click(function() {
                // $('#msc').multiSelect('deselect_all');
                $('#msc').multiSelect('select', a);
            });




        }
    });

    function shuffle()
    {



    }


</script>  