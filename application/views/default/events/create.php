<!DOCTYPE html>
<html lang="en">
    <head>		
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            .row-fluid [class*="span"]:first-child {
                text-align: left !important;
            }
            [class*="span"] {
                float: left;
                min-height: 1px;
                margin-right: 30px !important;
                margin-left: 0px !important;
            }
            .bootstrap-timepicker-hour{
                padding: 0px !important;
                padding-left: 2px !important;
            }
            .bootstrap-timepicker-minute{
                padding: 0px !important;
                padding-left: 2px !important;
                
            }
            .bootstrap-timepicker-meridian{
                padding: 0px !important;
                padding-left: 2px !important;
                
            }
            .list-group {
                padding-left: 0;
                margin-bottom: 20px;
                margin: 0px;
            }
            .list-group-item:first-child {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }
            .list-group-item {
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                cursor: pointer;
                border: 1px solid #ddd;
            }
            .list-group-item > .badge {
                float: right;
            }
            .list-group-item:hover{
                background-color: #2e3192;
                color:#FFF;
            }
            .list-group selected{
                background-color: #2e3192;
                color:#FFF;
            }
            .badge {
                display: inline-block;
                min-width: 10px;
                padding: 3px 7px;
                font-size: 12px;
                font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                background-color: #777;
                border-radius: 10px;
            }

            #DataTables_Table_0_wrapper{
                margin:auto;
            }
            #main-container{
                margin-top:5%;
            }
            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 41% !important; /* Full width */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                padding: 20px;
                overflow: scroll;
                overflow-y: scroll !important;
                height: 450px;
            }


            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
            .border-circle{
                padding: 20px;
                border-radius: 3px;
                margin: 0 !important;margin-top: -3px !important;
            }
            .fileContainer {
                overflow: hidden;
                position: relative;
            }

            .fileContainer [type=file] {
                cursor: inherit;
                display: block;
                font-size: 999px;
                filter: alpha(opacity=0);
                min-height: 100%;
                min-width: 100%;
                opacity: 0;
                position: absolute;
                left: 7px;
                text-align: right;
                top: 0;
            }

            /* Example stylistic flourishes */

            .fileContainer {    
                border-radius: .5em;
                float: left;
                padding: .5em;
            }

            .fileContainer [type=file] {
                cursor: pointer;
            }
        </style>
    <body>


    </head>
    <?php $this->load->view('default/head/console_page.php'); ?>
<body class="login-layout admin-body">
    <?php $this->load->view('default/nav/console_page.php'); ?>

    <div class="container" id="main-container">
        <div id="main-content">
            <div class="row" style="margin-top:20px;">
                <div class="span9">
                    <div id="client" class="border-circle">
                        <div class="panel-admin">
                            <div class="span10">
                                <label>
                                    <span class="block input-icon input-icon-right">
                                        <?php echo validation_errors(); ?>
                                    </span>
                                </label>
                                <?php echo $message; ?>
                                    <form action='<?php echo base_url(); ?>events/create' method='post' style="margin-bottom:0"  enctype="multipart/form-data">
                                   
                                        <table class="table table-striped create-client-table" style="margin: 0px;max-width: 85%;"> 
                                            <tr>
                                                <th>*Event Title</th>
                                                <th><input required type="text" class="span6" name='eventname' <?php if (isset($event[0]['eventname'])): ?> value="<?php echo $event[0]['eventname']; ?>" <?php endif; ?>/></th>
                                            </tr>
                                            <tr>
                                                <th>Company</th>
                                                <th><input type="text" class="span6" name='company' <?php if (isset($event[0]['company'])): ?> value="<?php echo $event[0]['company']; ?>" <?php endif; ?>/></th>
                                            </tr>
                                            <tr>
                                                <th>Time Start</th>
                                                <th>
                                                     <div class="input-group bootstrap-timepicker timepicker">
                                                        <input class="form-control input-small" id="startTime" type="time" autocomplete="on" class="span6" name='startTime' <?php if (isset($event[0]['startTime'])): ?> value="<?php echo $event[0]['startTime']; ?>" <?php endif; ?>/>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Time End</th>
                                                <th>
                                                     <div class="input-group bootstrap-timepicker timepicker">
                                                        <input class="form-control input-small" id="endTime" required type="time" autocomplete="on" class="span6" name='endTime' <?php if (isset($event[0]['endTime'])): ?> value="<?php echo $event[0]['endTime']; ?>" <?php endif; ?>/>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>*Description</td>
                                                <td><textarea class="span6" name='description'> <?php if (isset($event[0]['description'])): ?> <?php echo $event[0]['description']; ?> <?php endif; ?> </textarea> </td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td><input type="text" class="span6" name='country'<?php if (isset($event[0]['country'])): ?> value="<?php echo $event[0]['country']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                                <td>Add User Group</td>
                                                <td>
                                                    <select required="" name="user_group[]" id="user_group" class="form-control" size="8" multiple="multiple">
                                                        <?php foreach ($user_group as $value){ 
                                                            if (isset($value['group_name'])): 
                                                            ?>
                                                        <option value="<?php echo $value['objectId']?>">
                                                            <?php
                                                                echo $value['group_name'];
                                                                
                                                            ?>
                                                        </option>
                                                        <?php 
                                                        endif;
                                                        } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Add User</td>
                                                <td>
                                                    <select required="" name="user_id[]" id="user" class="form-control" size="8" multiple="multiple">
                                                        <?php foreach ($associated_user as $value){ 
                                                            if (isset($value['username'])): 
                                                                ?>
                                                        <option value="<?php echo $value['objectId']?>">
                                                            <?php
                                                                echo $value['username'];
                                                               
                                                            ?>
                                                        </option>
                                                        <?php 
                                                         endif;
                                                        } ?>
                                                    </select><br/>
                                                    <select required="" id="access_rights" name="access_rights">
                                                        <option value="Full">Full Rights</option>
                                                        <option value="View &amp; Comments">View &amp; Comments</option>
                                                        <option value="Comment">Comment</option>
                                                        <option value="View Only">View Only</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="fileContainer">
                                                        Thumbnail Photo &nbsp;&nbsp; <i class="fa fa-upload"></i>
                                                        <input required="" name="postImage" id="postImage" onchange="readURL(this);" type="file"/>
                                                    </label>
                                                </td>
                                                <td><img src="#" style="display:none;" id="viewEvent"/></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input id="objectId" type="hidden" name="objectId" value="<?php
                                                    if (isset($event[0]['objectId'])): echo $event[0]['objectId'];
                                                    endif;
                                                    ?>" />
                                                    <input type="submit" name="submit" value="submit" class=" btn btn-small btn-primary" />
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
                <div class="span2">
                    <a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/logout">Logout</a>
                    <div class="clear"></div>
                    <a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/scan">Scan Business Card</a>
                    <div class="clear"></div>
                    <a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/upload">Upload Doc</a>
                    <div class="clear"></div>
                </div>
                <br><br><br>
                <div class="row">				
                    <div class="span10" style="margin-left:10%;margin-top:3%;">
                        <div class = "row">
                            <div class="span4" style="text-align:center;"> </div>
                            <div class="span4" style="text-align:center;"> <a style="min-width:300px;" class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/clientmanagementconsolesupport">Support</a> </div>

                        </div>
                    </div>					
                </div>
                <div style="text-align:center;margin-top:2%;">
                    <a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
                        Console Menu
                    </a>
                </div>				
            </div>


        </div>
    </div>
<?php $this->load->view('default/footer/console_page.php'); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" />
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <script type="text/javascript">
        $('#startTime').timepicker();
        $('#endTime').timepicker();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewEvent')
                        .attr('src', e.target.result)
                        .width(150)
                        .css('display','block');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        
    </script>
</body>
</html>
