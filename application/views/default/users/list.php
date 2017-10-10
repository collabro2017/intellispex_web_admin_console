<!DOCTYPE html>
<html lang="en">
    <head>		
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <body>

        <style>
            .row-fluid [class*="span"]:first-child {
                text-align: left !important;
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
                margin-top:10%;
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
        </style>
    </head>
    <?php $this->load->view('default/head/console_page.php'); ?>
<body class="login-layout admin-body">
    <?php $this->load->view('default/nav/console_page.php'); ?>

    <div class="container-fluid" id="main-container">
        <div id="main-content">
            <div class="row-fluid" style="margin-top:20px;">
                <div class="span12">

                    <ul style="list-style: none">
                        <li style="float:left;margin-left: 10px;">
                            <a href="<?php echo base_url(); ?>manage/add_user/<?php echo $client_id; ?>" class="btn btn-small btn-primary">Add Associated Users</a>	
                        </li>
                        <li style="float:left;margin-left: 10px;">
                            <a class="btn btn-small btn-primary"  href="javascript:deleteuser();" class="btn btn-small btn-primary menu-button">Delete User</a> 	
                        </li>
                        <?php if (count($associated_user) > 0) { ?>
                            <li style="float:left;margin-left: 10px;">
                                <a id="enable" class="btn btn-small btn-primary"  href="javascript:enableuser();" class="btn btn-small btn-primary menu-button">Enable</a>	
                            </li>
                            <li style="float:left;margin-left: 10px;">
                                <a id="disable" class="btn btn-small btn-primary"  href="javascript:disableuser();" class="btn btn-small btn-primary menu-button">Disable</a>	
                            </li>
                            <li style="float:left;margin-left: 10px;">
                                <a id="create_group" class="btn btn-small btn-primary" href="#" class="btn btn-small btn-primary menu-button">Create Group</a> 	
                            </li>
                            <li style="float:left;margin-left: 10px;">
                                <a id="view_group" class="btn btn-small btn-primary" href="#" class="btn btn-small btn-primary menu-button">View Group</a>	
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="span11">
                    <table class="table table-striped events-table" id="table_data">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Phone #</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>State</th>
                                <th>ZipCode</th>
                                <th>Status</th>
                                <th>Time Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($associated_user as $value): ?>
                                <tr>
                                    <td><input type="checkbox" class="deleteitem" name="<?php echo $value['objectId'] ?>"></td>
                                    <td><?php
                                        if (isset($value['Firstname'])): echo $value['Firstname'];
                                        endif;
                                        echo " ";
                                        if (isset($value['LastName'])): echo $value['LastName'];
                                        endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['company'])): echo $value['company'];
                                        endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['Gender'])): echo $value['Gender'];
                                        endif;
                                        ?></td>
                                    <td><?php
                                    if (isset($value['email'])): echo $value['email'];
                                    endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['phone'])): echo $value['phone'];
                                        endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['country'])): echo $value['country'];
                                        endif;
                                        ?></td>
                                    <td><?php
                                    if (isset($value['city'])): echo $value['city'];
                                    endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['state'])): echo $value['state'];
                                        endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['zipcode'])): echo $value['zipcode'];
                                        endif;
                                        ?></td>
                                    <td>
    <?php
    if ($value['Status'] == '1') {
        echo 'Active';
    } else {
        echo 'Closed';
    }
    ?>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($value['createdAt'])) ?></td>

                                    <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/edit_user/<?php echo $value['objectId']; ?>/<?php echo $client_id; ?>">Edit</a></td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
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
        <form class="form-horizontal" action='<?php echo base_url(); ?>manage/create_grpup/<?php echo $client_id; ?>' method='post' style="margin-bottom:0">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Create Group</h2>
            </div>
            <!-- Modal content -->
            <div class="modal-content">

<?php $this->load->view('default/users/create_group.php'); ?>
            </div>
            <div class="modal-footer">
                <div style="float:right">
                    <button class="btn btn-small btn-primary btnClose" style="float:left;margin-right:20px;" >Close</button>
                    <button type="submit" class="btn btn-small btn-primary" style="float:left;" class="close">Submit</button>
                </div>
                <div style="clear:both"></div>
            </div>
        </form>
    </div>

    <!-- View Grop -->
    <div id="view_group_modal" class="modal">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>View Group</h2>
        </div>
        <!-- Modal content -->
        <div class="modal-content">

<?php $this->load->view('default/users/view_group.php'); ?>
        </div>
        <div class="modal-footer">
            <div style="float:right">
                <button class="btn btn-small btn-primary btnClose" style="float:left;margin-right:20px;" >Close</button>
            </div>
            <div style="clear:both"></div>
        </div>
</div>

<?php $this->load->view('default/footer/console_page.php'); ?>
<script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
<script src="<?php echo base_url('public') ?>/js/multiselect.js"></script>

<script type="text/javascript">

    $('#table_data').DataTable();

    function deleteuser() {
        if (window.confirm("Are you sure want to delete selected user(s)?")) {

            var deletelist = [];
            $(".deleteitem").each(function () {
                if (this.checked == true)
                    deletelist.push(this.name);
            });
            $.post("<?php echo base_url(); ?>manage/userdelete", {deletelist: deletelist}, function (data) {
                //console.log(data);
                window.location.href = "<?php echo base_url(); ?>manage/add_associate_users/<?php echo $client_id; ?>";
            });
        }
    }
    
    function enableuser() {

        var deletelist = [];
        $(".deleteitem").each(function () {
            if (this.checked == true)
                deletelist.push(this.name);
        });
        $.post("<?php echo base_url(); ?>manage/userenable", {deletelist: deletelist}, function (data) {
            //console.log(data);
            window.location.href = "<?php echo base_url(); ?>manage/add_associate_users/<?php echo $client_id; ?>";
        });
    }
    
    function disableuser() {

        var deletelist = [];
        $(".deleteitem").each(function () {
            if (this.checked == true)
                deletelist.push(this.name);
        });
        $.post("<?php echo base_url(); ?>manage/useredisable", {deletelist: deletelist}, function (data) {
            //console.log(data);
            window.location.href = "<?php echo base_url(); ?>manage/add_associate_users/<?php echo $client_id; ?>";
        });
    }
    
    
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
    btn.onclick = function () {
        create_group.style.display = "block";
    }

    // When the user clicks on <span> (x), close the create_group
    span.onclick = function () {
        create_group.style.display = "none";
    }
    // When the user clicks anywhere outside of the create_group, close it
    window.onclick = function (event) {
        if (event.target == create_group) {
            create_group.style.display = "none";
        }
    }
    // Create Group End


    // Get the View Group Start
    var view_group = document.getElementById('view_group_modal');

    // Get the button that opens the view_group
    var btn = document.getElementById("view_group");

    // Get the <span> element that closes the view_group
    var span = document.getElementsByClassName("close")[0];
    $('.btnClose').on('click', function () {
        view_group.style.display = "none";
    });
    // When the user clicks the button, open the view_group 
    btn.onclick = function () {
        view_group.style.display = "block";
    }

    // When the user clicks on <span> (x), close the view_group
    span.onclick = function () {
        view_group.style.display = "none";
    }
    // When the user clicks anywhere outside of the view_group, close it
    window.onclick = function (event) {
        if (event.target == view_group) {
            view_group.style.display = "none";
        }
    }
    // View Group End
    $(document).ready(function ($) {
        $('#show_create_group').click(function () {
            $('.create_group').fadeIn();
            $(this).fadeOut();
            $('#groupEdit').fadeOut();
        });
        $('#search').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function (value) {
                return value.length > 3;
            }
        });
    });
</script>
</body>
</html>
