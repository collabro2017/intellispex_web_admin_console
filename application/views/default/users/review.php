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

    <div class="container" id="main-container">
        <div id="main-content">
            <div class="row" style="margin-top:20px;">
                <div class="span11">
                    <table class="table table-striped events-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Sr. Number</th>
                                <th>Name</th>
                                <th>Client or App Administrator</th>
                                <th>Email</th>
                                <th>Phone #</th>
                                <th>Status</th>
                                <th>Time Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($associated_user as $value): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php
                                        if (isset($value['username'])): echo $value['username'];
                                        endif;
                                        ?></td>
                                    <td>
                                        <?php 
                                        if(isset($value['associated_with'])){
                                            $client_admin = $this->parserestclient->query
                                                            (
                                                            array
                                                                (
                                                                "objectId" => "_User",
                                                                'query' => '{"deletedAt":null,"objectId":"'.$value['associated_with']['objectId'].'"}',
                                                            )
                                                    );
                                            $client_admin = $client_admin[0];
                                             if (isset($client_admin->username)): echo $client_admin->username;
                                        endif;
                                        }
                                        ?>
                                    </td>
                                    
                                    <td><?php
                                    if (isset($value['email'])): echo $value['email'];
                                    endif;
                                        ?></td>
                                    <td><?php
                                        if (isset($value['phone'])): echo $value['phone'];
                                        endif;
                                        ?></td>
                                    <td>
    <?php
    if(isset($value['Status'])){
    if ($value['Status'] == '1') {
        echo 'Enable';
    } else {
        echo 'Disable';
    }
    }else{
        echo 'N/A';
    }
    ?>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($value['createdAt'])) ?></td>
                                </tr>
<?php $i++; endforeach; ?>
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

<?php $this->load->view('default/footer/console_page.php'); ?>
<script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
<script src="<?php echo base_url('public') ?>/js/multiselect.js"></script>

<script type="text/javascript">

    $('#table_data').DataTable( {
        "order": [[ 1, "asc" ]]
    } );
    
</script>
</body>
</html>
