<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

$settingslist1 = mysql_query("SELECT * FROM inv_settings WHERE set_id=1");
$settings1 = mysql_fetch_array($settingslist1);

if (isset($_POST['submit'])) {

    $bill_mode = $_POST['bill_mode'];
    $mat_issue_mode = $_POST['mat_issue_mode'];
    

    if (empty($settings1) || $settings1 == '') {
        $qry = mysql_query("INSERT INTO inv_settings (bill_mode,mat_issue_mode,set_id) VALUES
             ('$bill_mode','$mat_issue_mode','1')");
    } else {
        $qry = mysql_query("UPDATE inv_settings SET bill_mode='$bill_mode',mat_issue_mode='$mat_issue_mode' WHERE set_id='1'");
    }
    if ($qry) {
        header("Location:inv_settings.php?msg=succ");
    }
    // exit;
}
?>
<body>

    <div id="wrapper">

        <div id="header">
            <h1><a href="dashboard.php">Inventory Management</a></h1>		

            <a href="javascript:;" id="reveal-nav">
                <span class="reveal-bar"></span>
                <span class="reveal-bar"></span>
                <span class="reveal-bar"></span>
            </a>
        </div> <!-- #header -->

        <div id="search">
            <form>
                <input type="text" name="search" placeholder="Search..." id="searchField" />
            </form>		
        </div> <!-- #search -->

        <div id="sidebar">		

            <?php include 'sidebar.php'; ?>

        </div> <!-- #sidebar -->

        <div id="content">		

            <div id="contentHeader">
                <h1>Inventory Settings</h1>
            </div> <!-- #contentHeader -->	

            <div class="container">
                <?php
                $msg = $_GET['msg'];
                if ($msg === "succ") {
                    ?>
                    <div class="notify notify-success">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Success Notifty</h3>						
                        <p>Your data successfully edited!!!</p>
                    </div>
                <?php }if ($msg === "err") {
                    ?>
                    <div class="notify notify-error">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Error Notifty</h3>						
                        <p>Your data has not been edited!!!</p>
                    </div>
                <?php } ?>

                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <!--<a href="inv_category.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>-->
                            <span class="icon-article"></span>
                            <h3> Settings</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">

                            <form class="form uniformForm validateForm" method="post" action="" >
                                <?php
                                $settingslist = mysql_query("SELECT * FROM inv_settings WHERE set_id=1");
                                $settings = mysql_fetch_array($settingslist);
                                ?>
                                <div class="grid-8">	
                                    <div class="widget-content"> 

                                        <div class="field-group">		
                                            <label>Bill Mode<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="bill_mode" id="bill_mode" class="required select2">
                                                    <option value="">Please select</option>	
                                                    <option value="1" <?php
                                if ($settings['bill_mode'] == '1') {
                                    echo 'selected';
                                }
                                ?>>Separate Bill</option>
                                                    <option value="0" <?php
                                                    if ($settings['bill_mode'] == '0') {
                                                        echo 'selected';
                                                    }
                                ?>>Common Bill</option>									
                                                </select>										
                                            </div>	
                                        </div>
                                        <div class="field-group">		
                                            <label>Material Issue Mode<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="mat_issue_mode" id="mat_issue_mode" class="required select2">
                                                    <option value="">Please select</option>	
                                                    <option value="1" <?php
                                if ($settings['mat_issue_mode'] == '1') {
                                    echo 'selected';
                                }
                                ?>>Bill Challan</option>
                                                    <option value="0" <?php
                                                    if ($settings['mat_issue_mode'] == '0') {
                                                        echo 'selected';
                                                    }
                                ?>>Delivery Challan</option>									
                                                </select>										
                                            </div>	
                                        </div>

                                        <div class="actions">		
                                            <input type="hidden" class="medium" name="catid" value="<?php echo $catid; ?>" > 				
                                            <button type="submit" name="submit" class="btn btn-error">Submit</button>
                                        </div> <!-- .actions -->
                                    </div>
                                </div>
                            </form>
                        </div> <!-- .widget-content -->						
                    </div>				
                </div> <!-- .grid -->			
            </div> <!-- .container -->

        </div> <!-- #content -->

        <?php
        include("includes/topnav.php");
        ?> <!-- #topNav -->

        <!-- .quickNav -->


    </div> <!-- #wrapper -->

    <?php include("includes/footer.php"); ?>
    <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#datepicker").datepicker();
        });
        function showCategory(str) {
            if (str == "") {
                document.getElementById("section").innerHTML = "";
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
                    document.getElementById("section").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
            xmlhttp.send();
        }
    </script>  
</body>
</html>
<? ob_flush(); ?>