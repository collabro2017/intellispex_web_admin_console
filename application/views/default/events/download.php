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
        
        <form method="post"id="frmmetalist" action="<?php echo base_url(); ?>events/eventmetadata">
            <div id="main-container">
                <div  class="container">
                    <div id="main-content">
                        <div class="row">
                            <div class="menu-button span3">
                                <ul class="label-meta">
                                    <li> <label class="number">1</label></li>
                                    <li> <div class="label-text">File Type: </div> </li>
                                    <li>
                                        <div class="styled">
                                            <select name="select-meta file_type" class="file_type">
                                                <option value="csv">CSV</option>
                                                <option value="xls">Excel</option>
                                                <option value="pdf">PDF</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div class="menu-button span3">
                                <ul class="label-meta">
                                    <li> <label class="number">2</label></li>
                                    <li> <div class="label-text">Download Selected Event Metadata </div> </li>
                                </ul>
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div class="meta-table span8">
                                <!--                            <div class="meta-table-sorter">
                                                                <div class="styled">
                                                                    <select name="sorter">
                                                                        <option value="user">User (Alphabatic)</option>
                                                                        <option value="title">Title (Alphabatic)</option>
                                                                        <option value="title">Date Created</option>
                                                                    </select>
                                                                </div>
                                                            </div>-->
                                <div style="height:400px;overflow-x: hidden;overflow-y: scroll;">
                                    <table class="table table-striped" cellspacing="0" width="100%" id="table_data_down">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input style="margin-left: -3px;margin-top: 0px;" type="checkbox" name="checkAll" id="checkAll" onclick="selectall()" />
                                                </th>
                                                <th>Title</th>
                                                <th>User</th>
                                                <th>Date Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($info as $val) {
                                                if (isset($val['eventname'])) {
                                                    ?>
                                                    <tr>																
                                                        <td><input style="margin-left:5px;" type="checkbox" class="downloadlist" name="<?php echo $val['objectId'] ?>" /></td>
                                                        <td>
                                                            <a href="<?php echo base_url(); ?>events/event/<?php echo $val['objectId']; ?>">
                                                                <?php echo $val['eventname']; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['username'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['createdAt'] ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="span12" style="text-align:left;"><br>
                                    <input type = 'hidden' id="metadataID" value="" />
                                    <button onclick="selectall();">Select All</button>
                                    <button onclick="deselectall();">Deselect All</button><br><br>
                                </div>		
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div class="menu-button span3">
                                <ul class="label-meta">
                                    <li> <label class="number">3</label></li>
                                    <li> <div class="label-text">Select Metadata for Selected Events </div> </li>
                                </ul>
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div class="metadata-fields">
                                <div class="span3" style="text-align:left;padding-top:20px;">
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="1" type="checkbox">Creator</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="15" type="checkbox">Event Title</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="4" type="checkbox">Number of Participants</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="17" type="checkbox">Time Start</label>
                                    </div> 
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="18" type="checkbox">Time End</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="18" type="checkbox">Users</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="18" type="checkbox">Groups</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="19" type="checkbox">Address</label>
                                    </div>
                                </div>
                                <div class="span3" style="text-align:left;padding-top:20px;">
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="2" type="checkbox">Date Created</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="3" type="checkbox">Time Created</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="6" type="checkbox">Size</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="7" type="checkbox">Location</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="8" type="checkbox">Number of Activity Sheets</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="16" type="checkbox">Company Name</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="16" type="checkbox">Description</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="downloadlist" value="17" type="checkbox">Comments</label>
                                    </div>
                                </div>
                                <div class="span3" style="padding-top:20px;">
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="10" type="checkbox">Activity Sheet Time</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="11" type="checkbox">Activity Sheet Date</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="12" type="checkbox">Activity Sheet Title</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="16" type="checkbox">Activity Sheet Format</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="13" type="checkbox">Activity Sheet List</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="14" type="checkbox">Activity Sheet Description</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="activitylist" value="15" type="checkbox">Activity Sheet Comment</label>
                                    </div>
                                </div>	
                                <div style="clear:both"></div>
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div class="menu-button span3">
                                <ul class="label-meta">
                                    <li> <label class="number">4</label></li>
                                    <li> <div class="label-text">Includes: </div> </li>
                                </ul>
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div class="metadata-fields" style="width: 23%;padding-bottom: 10px;">
                                <ul class="file-selection">
                                    <li class="checkbox">
                                        <label><input class="activitylist" value="10" type="checkbox">Images</label>
                                    </li>
                                    <li class="checkbox">
                                        <label><input class="activitylist" value="10" type="checkbox">Audio</label>
                                    </li>
                                    <li class="checkbox">
                                        <label><input class="activitylist" value="10" type="checkbox">Videos</label>
                                    </li>
                                </ul>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                        <div style="clear:both;height: 30px;"></div>
                        <div class="row">
                            <div style="clear:both;height: 30px;"></div>
                            <input type="submit" class="menu-button" style="border:none;" value="Download" />
                        </div>
                        <div style="clear:both;height: 30px;"></div>

                    </div>
                </div>
            </div>
        </form>
        <?php $this->load->view('default/footer/console_page.php'); ?>
        <script src="<?php echo base_url('public') ?>/js/datatable.js"></script>

        <script type="text/javascript">
                                    $('#table_data_down').DataTable({
                                        "paging": false
                                    });
                                    $('#checkAll').change(function () {
                                        if (this.checked === true) {
                                            $(".downloadlist").each(function () {
                                                this.checked = true;
                                            });
                                        } else if (this.checked === false) {
                                            $(".downloadlist").each(function () {
                                                this.checked = false;
                                            });
                                        }
                                    });
                                    function selectall() {
                                        $(".downloadlist").each(function () {
                                            this.checked = true;
                                        });
                                        $(".activitylist").each(function () {
                                            this.checked = true;
                                        });
                                    }
                                    function deselectall() {
                                        $(".downloadlist").each(function () {
                                            this.checked = false;
                                        });
                                        $(".activitylist").each(function () {
                                            this.checked = false;
                                        });
                                    }
        </script>
    </body>
</html>