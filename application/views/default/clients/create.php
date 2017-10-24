<!DOCTYPE html>
<html lang="en">
    <head>		
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                border: 1px solid #eee;
                padding: 20px;
                border-radius: 3px;
                margin: 0 !important;margin-top: -3px !important;
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
                    <ul class="nav nav-pills" style="margin:0 !important;">
                        <li id="create_client" class="active"><a href="#">Create Client</a></li>
                        <li id="associated_user"><a href="#">Associated Users</a></li>
                    </ul>
                    <div id="client" class="border-circle">
                        <div class="panel-admin">
                            <div class="span10">
                                <label>
                                    <span class="block input-icon input-icon-right">
                                        <?php echo validation_errors(); ?>
                                    </span>
                                </label>
                                <?php echo $message; ?>
                                <?php if (isset($create_client)): ?>
                                    <form action='<?php echo base_url(); ?>clients/create' method='post' style="margin-bottom:0">
                                    <?php endif; ?>
                                    <?php if (isset($edit_client)): ?>
                                        <form action='<?php echo base_url(); ?>clients/edit/<?php echo $client_data[0]['objectId']; ?>' method='post' style="margin-bottom:0">
                                        <?php endif; ?>
                                        <table class="table table-striped create-client-table" style="margin: 0px;max-width: 85%;"> 
                                            <tr>
                                                <th>*Client Name</th>
                                                <th><input required type="text" class="span6" name='name' <?php if (isset($client_data[0]['username'])): ?> value="<?php echo $client_data[0]['username']; ?>" <?php endif; ?>/></th>
                                            </tr>
                                            <tr>
                                                <td>*Email</td>
                                                <td><input required type="text" class="span6" name='email'<?php if (isset($client_data[0]['email'])): ?> value="<?php echo $client_data[0]['email']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                                <td>*Password</td>
                                                <td><input required type="password" class="span6" name='password'<?php if (isset($client_data[0]['password'])): ?> value="<?php echo $client_data[0]['password']; ?>" <?php endif; ?>/></td>
                                            </tr>
<!--										<tr>
                                              <td>Location</td>
                                              <td><input type="text" class="span6" name='address1'<?php if (isset($client_data[0]['address1'])): ?> value="<?php echo $client_data[0]['address1']; ?>" <?php endif; ?>/></td>
                                            </tr>-->
                                            <tr>
                                                <td>City</td>
                                                <td><input type="text" class="span6" name='city'<?php if (isset($client_data[0]['city'])): ?> value="<?php echo $client_data[0]['city']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                                <td>Province / State</td>
                                                <td><input type="text" class="span6" name='province'<?php if (isset($client_data[0]['state'])): ?> value="<?php echo $client_data[0]['state']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                                <td>Postal Code</td>
                                                <td><input type="text" class="span6" name='postal'<?php if (isset($client_data[0]['zipcode'])): ?> value="<?php echo $client_data[0]['zipcode']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td><input type="text" class="span6" name='phone_number'<?php if (isset($client_data[0]['telephone'])): ?> value="<?php echo $client_data[0]['telephone']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                                <td>Mobile Phone</td>
                                                <td><input type="text" class="span6" name='mobile'<?php if (isset($client_data[0]['phone'])): ?> value="<?php echo $client_data[0]['phone']; ?>" <?php endif; ?>/></td>
                                            </tr>
<!--										<tr>
                                              <td>Date Created</td>
                                              <td><input type="date" class="span6" name='created'<?php if (isset($client_data[0]['created'])): ?> value="<?php echo $client_data[0]['created']; ?>" <?php endif; ?>/></td>
                                            </tr>
                                            <tr>
                                              <td>Date Modified</td>
                                              <td><input type="date" class="span6" name='updated'<?php if (isset($client_data[0]['updated'])): ?> value="<?php echo $client_data[0]['updated']; ?>" <?php endif; ?>/></td>
                                            </tr>-->
                                            <tr>
                                                <td colspan="2">
                                                    <input id="objectId" type="hidden" name="objectId" value="<?php if (isset($client_data[0]['objectId'])): echo $client_data[0]['objectId'];
                                        endif; ?>" />
                                                    <input type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary"></input>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div id="users" class="border-circle" style="display:none;">
                        <a id="create_group" href="#" class="btn btn-small btn-primary menu-button">Add Associated Users</a>
<?php if (count($associated_user) > 0): ?>
                            <table>
                                <tr>
                                    <th>User</th>
                                    <th>Date Established</th>
                                    <th>Status</th>
                                    <th>Phone #</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
    <?php foreach ($associated_user as $value): ?>
                                    <tr>
                                        <td><?php echo $value['username'] ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($value['createdAt'])) ?></td>
                                        <td>
        <?php if ($value['Status'] == '1') {
            echo 'Active';
        } else {
            echo 'Closed';
        } ?>
                                        </td>
                                        <td><?php echo $value['phone'] ?></td>
                                        <td><?php echo $value['email'] ?></td>

                                        <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>clietns/edit_user/<?php echo $value['objectId']; ?>/<?php if (isset($client_data[0]['objectId'])): echo $client_data[0]['objectId'];
                        endif; ?>">Edit</a></td>
                                    </tr>
    <?php endforeach; ?>
                            </table>
<?php endif; ?>
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
    <!-- Create/Edit Group -->
    <div id="create_group_modal" class="modal">
        <form action='<?php echo base_url(); ?>clients/add_user/<?php if (isset($client_data[0]['objectId'])): echo $client_data[0]['objectId']; endif; ?>' method='post' style="margin-bottom:0">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Create User</h2>
            </div>
            <!-- Modal content -->
            <div class="modal-content">

<?php $this->load->view('default/clients/add_user.php'); ?>
            </div>
            <div class="modal-footer">
                <div style="float:right">
                    <button class="btn btn-small btn-primary btnClose" style="float:left;margin-right:20px;" >Close</button>
                    <input class="btn btn-small btn-primary" style="float:left;" type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary menu-button"></input>
                    <!--<button name="submit" type="submit" class="btn btn-small btn-primary" style="float:left;" class="close">Submit</button>-->
                </div>
                <div style="clear:both"></div>
            </div>
        </form>
    </div>

<?php $this->load->view('default/footer/console_page.php'); ?>
    <script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
    <script src="<?php echo base_url('public') ?>/js/multiselect.js"></script>

    <script type="text/javascript">
        // View Group End
        // Get the create group Start
        var create_group = document.getElementById('create_group_modal');

        // Get the button that opens the create_group
        var btn = document.getElementById("create_group");

        // Get the <span> element that closes the create_group
        var span = document.getElementsByClassName("close")[0];
        $('.btnClose').on('click', function () {
            create_group.style.display = "none";
        });
        // When the user clicks the button, open the create_group 
        $('#create_group').on('click', function () {
            create_group.style.display = "block";
        });

        // When the user clicks on <span> (x), close the create_group
         $('.close').on('click', function () {
            create_group.style.display = "none";
        });
        // When the user clicks anywhere outside of the create_group, close it
        window.onclick = function (event) {
            if (event.target == create_group) {
                create_group.style.display = "none";
            }
        }
        // Create Group End
        
        $(document).ready(function ($) {
            $('#create_client').click(function () {
                $('#client').css('display', 'block');
                $('#users').css('display', 'none');
                $('#associated_user').removeClass('active');
                $('#create_client').addClass('active');
            });

            $('#associated_user').click(function () {
                if ($('#objectId').val() == '') {
                    alert('Please add client first to add associated user');
                } else {
                    $('#client').css('display', 'none');
                    $('#users').css('display', 'block');
                    $('#associated_user').addClass('active');
                    $('#create_client').removeClass('active');
                }
            });
        });
    </script>
</body>
</html>
