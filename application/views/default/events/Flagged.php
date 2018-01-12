<!DOCTYPE html>
<html lang="en">
    <head>		
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />	
        <style>
            #DataTables_Table_0_wrapper{
                margin:auto;
            }
        </style>
    </head>
    <?php $this->load->view('default/head/console_page.php'); ?>
    <body class="login-layout admin-body">
        <?php $this->load->view('default/nav/console_page.php'); ?>

        <div class="container-fluid" id="main-container">
            <div id="main-content">

                <div class="row-fluid" style="margin-top:20px;">
                    <div class="span1"></div>
                    <div class="span10">
                        <?php $this->load->view('default/events/admin_content_result'); ?>
                    </div>
                    <div style="text-align:center;margin-top:2%;">
                        <a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
                            Console Menu
                        </a>
                    </div>				
                </div>
            </div>
        </div>

        <div class="hide metadatamodal container-fluid" style="background-color:#ddd;width:80%;margin:auto;margin-top:10%;">
            <div class="row-fluid">	
                <div class="span12" style="text-align:left;"><br><br>
                    <button onclick="metadataedit();"><h3>Download List</h3></button>
                    <button onclick="gobacklist();"><h3>Go Back</h3></button><br>
                </div>					
            </div>
            <div class="row-fluid">

                <div class="span6" style="text-align:left;padding-top:20px;">
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist"  value="1">Creator</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="2">Date Created</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="3">Time Created</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="4">Number of Participants</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="5">Tagged Users</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="6">Size</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="7">Location</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="8">Number of Activity Sheets</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="downloadlist" value="9">Title of Activity Sheets</label>
                    </div>
                </div>
                <div class="span6" style="padding-top:20px;">
                    <label>Activity Sheets</label>
                    <div class="checkbox">
                        <label><input type="checkbox" class="activitylist" value="10">Activity Sheet Time</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="activitylist" value="11">Activity Sheet Date</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="activitylist" value="12">Activity Sheet Title</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="activitylist" value="13">Activity Sheet List</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="activitylist" value="14">Activity Sheet Description</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" class="activitylist" value="15">Activity Sheet Comment</label>
                    </div>
                </div>			
            </div>
            <div class="row-fluid">			
                <div class="span12" style="text-align:left;"><br>
                    <input type = 'hidden' id="metadataID" value="" />
                    <button onclick="selectall();"><h3>Select All</h3></button>
                    <button onclick="deselectall();"><h3>Deselect All</h3></button><br><br>
                </div>					
            </div>
        </div>

        <div class="hide">
            <form method="post"id="frmmetalist" action="<?php echo base_url(); ?>events/eventmetadata">
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="metaviewlist" id="metaviewlist" value="">
            </form>
        </div>



        <?php $this->load->view('default/footer/console_page.php'); ?>
        <script src="<?php echo base_url('public') ?>/js/datatable.js"></script>


    </body>
</html>
