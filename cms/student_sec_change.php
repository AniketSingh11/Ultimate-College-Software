<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
include("checking_page/admission.php");
$bid = $_GET['bid'];
if (isset($_POST['submit'])) {
    $bid = mysql_real_escape_string($_POST['bid']);
    $c_id = mysql_real_escape_string($_POST['n_cid']);
    $s_id = mysql_real_escape_string($_POST['n_sid']);


    foreach ($_POST['ms_example'] as $selectedOption) {
        $ssid = $selectedOption;

        //echo $ssid.$s_id;
        
        $studentlist = mysql_query("UPDATE student SET s_id=$s_id WHERE ss_id=$ssid");
        
    }


    header("Location:student_sec_change.php?bid=$bid&msg=succ");
    //exit;	
}
?>
<link href="css/multiselect/multiselect.css" rel="stylesheet" type="text/css" />
</head>

<body id="top">
    <!-- Begin of #container -->
    <div id="container">
        <!-- Begin of #header -->
        <?php include("includes/header.php"); ?>
        <!--! end of #header -->

        <div class="fix-shadow-bottom-height"></div>

        <!-- Begin of Sidebar -->
        <aside id="sidebar">

            <!-- Search -->
            <?php include("includes/search.php"); ?>
            <!--! end of #search-bar -->

            <!-- Begin of #login-details -->
            <?php include("includes/login-details.php"); ?>
            <!--! end of #login-details -->

            <!-- Begin of Navigation -->
            <?php include("nav.php"); ?>
            <!--! end of #nav -->

        </aside> <!--! end of #sidebar -->
        <?php
        if ($bid) {
            $boardlist = mysql_query("SELECT * FROM board WHERE b_id=$bid");
            $bo = mysql_fetch_array($boardlist);
        } else {

            $board_query = mysql_query("SELECT * FROM board  order by b_id asc");
            $bo = mysql_fetch_array($board_query);

            $bid = $bo['b_id'];
        }
        ?>
        <!-- Begin of #main -->
        <div id="main" role="main">
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="board_select_admin_select.php" title="<?php echo $bo['b_name']; ?>"><?php echo $bo['b_name']; ?></a></li>

                    <li class="no-hover">Promotion  Student List</li>                
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="_25" style="float:right">
                    <label for="select">Board :</label>
                    <?php
                    $classl = "SELECT * FROM board";
                    $result1 = mysql_query($classl) or die(mysql_error());
                    echo '<select name="bid" id="bid" class="required" onchange="change_function1()">';
                    while ($row1 = mysql_fetch_assoc($result1)):
                        if ($bid == $row1['b_id']) {
                            echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
                        } else {
                            echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
                        }
                    endwhile;
                    echo '</select>';
                    ?>

                </div>

                <div class="container_12">
   <!--  <a href="pre_admission_allocation.php?bid=<?php echo $bid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a> -->
                    <div class="grid_12">
                        <?php
                        $msg = $_GET['msg'];
                        if ($msg == "succ") {
                            ?>			
                            <div class="alert success"><span class="hide">x</span>All Student has been Successfully moved!!!</div>
                        <?php } ?>



                        <div class="block-border">

                            <div class="block-header">
                                <h1>Select Student and Standard and Section/Group</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="POST">

                                <div class="_25">
                                    <p>
                                        <label for="select">Standard : <span class="error">*</span></label>
                                        <?php
                                        $qry = mysql_query("SELECT * FROM `year` where ay_id = '$acyear'  order by ay_id desc");

                                        $res = mysql_fetch_array($qry);

                                        $old_ayid = $res["ay_id"];

                                        $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$old_ayid";
                                        $result1 = mysql_query($classl) or die(mysql_error());
                                        ?>
                                        <select name='o_cid' id='o_cid' class='required' onchange="showCategory(this.value, '<?= $old_ayid ?>', 'o')"> 
                                            <option value=''>Select Class</option>
                                            <?php
                                            while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
                                        </select>
                                    </p>
                                </div>

                                <div class="_25">
                                    <p>
                                        <label for="select">Section / Group : <span  >*</span></label>
                                        <select name="o_sid[]" id="o_sid" onchange="showstudent(this.value, '<?= $old_ayid ?>', 'o')"   multiple="multiple"   class="required" style="width:90%">

                                        </select>
                                    </p>
                                </div> 

                                <!--                                <div class="_25">
                                                                    <p>
                                                                        <label for="select">Standard : <span class="error">*</span></label>
                                <?php
                                $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                $result1 = mysql_query($classl) or die(mysql_error());
                                ?>
                                                                        <select name='n_cid' id='n_cid' class='required' onchange="showCategory(this.value, '<?= $acyear ?>', 'n')"> 
                                                                            <option value=''>Select Class</option>
                                <?php
                                while ($row1 = mysql_fetch_assoc($result1)):
                                    echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                endwhile;
                                echo '</select>';
                                ?>
                                                                        </select>
                                                                    </p>
                                                                </div>-->

                                <div class="_25">
                                    <p>
                                        <label for="select">Section / Group : <span class="error">*</span></label>
                                        <select name="n_sid" id="n_sid"  data-required="true"  class='required'   style="width:90%">

                                        </select>
                                    </p>
                                </div> 

                                <input type="hidden" name="bid"   class='required'  value="<?= $bid ?>">
                                <div id="test"></div>  


                                <div class="clear"></div>
                                <div class="block-actions">
                                    <ul class="actions-left">
                                        <li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
                                    </ul>
                                    <ul class="actions-left">
                                        <li><input type="submit" name="submit" class="button" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div></div> <!--! end of #main-content -->
        </div> <!--! end of #main -->


        <?php include("includes/footer.php"); ?>
    </div> <!--! end of #container -->

    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


    <!-- scripts concatenated and minified via ant build script-->
    <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
    <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
    <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
    <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
    <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
    <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
    <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
    <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
    <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
    <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
    <script defer src="js/common.js"></script> <!-- Generic functions -->
    <script defer src="js/script.js"></script> <!-- Generic scripts -->
    <script type="text/javascript">
                                            $().ready(function() {
                                                var validateform = $("#validate-form").validate();
                                                $("#reset-validate-form").click(function() {
                                                    validateform.resetForm();
                                                    $.jGrowl("Form was Reset.", {theme: 'error'});
                                                });
                                            });
    </script>



    <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
    <link rel="stylesheet" href="library/js/plugins/select2/select2.css" type="text/css" />
    <script src="library/js/plugins/select2/select2.js"></script>  
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
    <script type="text/javascript">
                                            $().ready(function() {

                                                $('#n_sid').select2({
                                                    allowClear: true,
                                                    placeholder: "Please Select..."
                                                })
                                                $('#o_sid').select2({
                                                    allowClear: true,
                                                    placeholder: "Please Select..."
                                                })


                                                if ($("#msc").length > 0) {
                                                    $("#msc").multiSelect({
                                                        selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
                                                        selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
                                                        afterSelect: function(value, text) {

                                                            //action
                                                        },
                                                        afterDeselect: function(value, text) {
                                                            //action
                                                        }
                                                    });



                                                    $("#ms_select").click(function() {

                                                        $('#msc').multiSelect('select_all');
                                                    });
                                                    $("#ms_deselect").click(function() {
                                                        $('#msc').multiSelect('deselect_all');
                                                    });
                                                }
                                            });
                                            function showCategory(str, ayid, prefix) {
                                                if (prefix == "o") {
                                                    $(".select2-search-choice").remove();
                                                    $("#test").html("");
                                                } else {
                                                    var show = "show";
                                                    $('.select2-chosen').html("");

//$(".ms-selection .ms-list li").find("span").css({"color": "red", "border": "2px solid red"});

                                                }
                                                if (str == "") {
                                                    document.getElementById(prefix + "_sid").innerHTML = "";
                                                    return;
                                                }

                                                if (window.XMLHttpRequest) {
                                                    // code for IE7+, Firefox, Chrome, Opera, Safari
                                                    xmlhttp = new XMLHttpRequest();
                                                }
                                                else {// code for IE6, IE5
                                                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                                }
                                                xmlhttp.onreadystatechange = function() {
                                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                                        document.getElementById(prefix + "_sid").innerHTML = xmlhttp.responseText;

                                                    }
                                                }
                                                xmlhttp.open("GET", "sectionlist.php?mmtid=" + str + "&show=" + show, true);
                                                xmlhttp.send();
                                                promot_section(str, show);
                                            }

                                            function showstudent(str, ayid, prefix) {
                                                var standard = $("#" + prefix + "_cid").val();
                                                var section = $("#" + prefix + "_sid").val();
                                                $.get("promotion_section.php", {section: section, value: standard, bid:<?php echo $bid; ?>, ayid: ayid}, function(data) {
                                                    $("#test").html(data);
                                                });

                                            }

                                            function change_function1() {

                                                var bid = document.getElementById('bid').value;
                                                window.location.href = 'promotion_student.php?bid=' + bid;

                                            }

                                            function promot_section(str, show) {

                                                //get method jquery
                                                $.get("sectionlist.php", {mmtid: str, show: show}, function(data) {
                                                    $("#n_sid").html(data);

                                                    $('#n_sid').select2({
                                                        allowClear: true,
                                                        placeholder: "Please Select..."
                                                    });
                                                });


                                            }
    </script> 

    <!-- end scripts-->

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

</body>
</html>
<? ob_flush(); ?>