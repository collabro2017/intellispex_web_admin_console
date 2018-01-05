<html lang="en">
	<head>		
		<link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/css/events.css" />	
	</head>
	<?php $this->load->view('default/head/console_page.php'); ?>
	<body class="login-layout admin-body">
	<?php $this->load->view('default/nav/console_page.php'); ?>
    <style>
        .menu-button {
            min-width: 300px;
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>
	<div class="container-fluid" id="main-container">
        
		<div id="main-content">
        <div class="span5"><br><br><br><br>
            <table>
                <?php if(isset($event[0]['username'])){ ?>
                    <tr><td>Creator</td><td><?php echo $event[0]['username'] ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['eventname'])){ ?>
                    <tr><td>Event Title</td><td><?php echo $event[0]['eventname'] ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['company'])){ ?>
                    <tr><td>Company Name</td><td><?php echo $event[0]['company'] ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['startTime'])){ ?>
                    <tr><td>Start Time</td><td><?php echo $event[0]['startTime'] ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['endTime'])){ ?>
                    <tr><td>End Time</td><td><?php echo $event[0]['endTime'] ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['country'])){ ?>
                    <tr><td>Address</td><td><?php echo $event[0]['country'] ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['createdAt'])){ ?>
                    <tr><td>Data Created</td><td><?php echo date('Y-m-d',strtotime($event[0]['createdAt'])); ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['createdAt'])){ ?>
                    <tr><td>Time Created</td><td><?php echo date('g:i A',strtotime($event[0]['createdAt'])); ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['commenters'])){ ?>
                    <tr><td>Number of Participants</td><td><?php if(isset($event[0]['commenters'])) { echo count($event[0]['commenters']); }else{ echo 0; } ?></td></tr>
                <?php } ?>
                <?php if(isset($event[0]['TagFriends'])){ ?>
                    <tr><td>Tagged Users</td><td><?php echo count(implode(",",$event[0]['TagFriends'])) ?></td></tr>
                <?php } ?>
                <tr><td>Location</td><td><?php  ?></td></tr>
                <?php if(isset($event[0]['description'])){ ?>
                    <tr><td>Description</td><td><?php echo $event[0]['description'] ?></td></tr>
                <?php } ?>
            </table>
            <br><br>
            <table>
                <tr><td>Number of Activity Sheets</td><td><?php echo count($eventActivity); ?></td></tr>
                <tr><td>Title of Activity Sheet</td><td><?php echo $event[0]['eventname'] ?></td></tr>
                <tr><td>Description</td><td>none<?php //echo $event[0]['description'] ?></td></tr>
            </table>
            <?php
            if(count($eventActivity) > 0){
            $halfActivity = ceil(((count($eventActivity))/2));
            $halfActivity = $halfActivity-1;
            ?>
            <table>
                <?php for($i = 0; $i < $halfActivity; $i++){ ?>
                <tr><td colspan="2">Activity Sheet <?php echo $i+1; ?></td></tr>                    
                    <?php if(isset($eventActivity[$i]['createdAt'])){ ?>
                        <tr><td>Date</td><td><?php echo date('Y-m-d',strtotime($eventActivity[$i]['createdAt'])); ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['createdAt'])){ ?>
                        <tr><td>Time</td><td><?php echo date('g:i A',strtotime($eventActivity[$i]['createdAt'])); ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['title'])){ ?>
                        <tr><td>Title</td><td><?php echo $eventActivity[$i]['title']; ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['countryLatLong'])){ ?>
                        <tr><td>Location</td><td><?php echo $eventActivity[$i]['countryLatLong']; ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['description'])){ ?>
                        <tr><td>Description</td><td><?php echo $eventActivity[$i]['description']; ?></td></tr>
                    <?php } ?>
                    <?php
                        if (isset($eventActivity[$i]['commentsArray'])) {
                            ?>
                        <tr>
                            <td colspan="2">
                                <h4>Comments</h4>
                                <?php
                                $postComments = $eventActivity[$i]['commentsArray'];
                                for ($k = 0; $k < count($postComments); $k++) {
                                    $comment = $this->parserestclient->query(array(
                                        "objectId" => "Comments",
                                        'query' => '{"objectId":"' . $postComments[$k]['objectId'] . '"}',
                                            )
                                    );
                                    $comments = json_decode(json_encode($comment));
                                    foreach ($comments as $data) {
                                        $commenter = $data->Commenter;
                                        $user_details = $this->parserestclient->query(array(
                                            "objectId" => "_User",
                                            'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                                                )
                                        );
                                        $user_details = json_decode(json_encode($user_details), true);
                                        ?>
                                        <p><?php echo date('d-m-Y g:i A', strtotime($data->createdAt)); ?>: <?php
                                            if (isset($user_details[0]['username'])):
                                                echo '<b>' . $user_details[0]['username'] . ': </b>';
                                            endif;
                                            ?>
                                            <?php echo $data->Comments; ?>
                                        </p>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

                    
                <?php } ?>
            </table>
            <?php 
            }
            ?>
        </div>
        <div class="span5"><br><br><br><br>
            <?php if(count($eventActivity) > 0){ ?>
            <table>
                <?php for($i = $halfActivity; $i < count($eventActivity); $i++){ ?>
                    <tr><td colspan="2">Activity Sheet <?php echo $i+1; ?></td></tr>
                    <?php if(isset($eventActivity[$i]['createdAt'])){ ?>
                        <tr><td>Date</td><td><?php echo date('Y-m-d',time($eventActivity[$i]['createdAt'])); ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['createdAt'])){ ?>
                        <tr><td>Time</td><td><?php echo date('g:i A',time($eventActivity[$i]['createdAt'])); ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['title'])){ ?>
                        <tr><td>Title</td><td><?php echo $eventActivity[$i]['title']; ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['countryLatLong'])){ ?>
                        <tr><td>Location</td><td><?php echo $eventActivity[$i]['countryLatLong']; ?></td></tr>
                    <?php } ?>
                    <?php if(isset($eventActivity[$i]['description'])){ ?>
                        <tr><td>Description</td><td><?php echo $eventActivity[$i]['description']; ?></td></tr>
                    <?php } ?>   
                     <?php
                        if (isset($eventActivity[$i]['commentsArray'])) {
                            
                            $postComments = $eventActivity[$i]['commentsArray'];
                            if(count($postComments) > 0){
                            ?>
                        <tr>
                            <td colspan="2">
                                <h4>Comments</h4>
                                <?php
                                for ($k = 0; $k < count($postComments); $k++) {
                                    if(isset($postComments[$k]['objectId'])){
                                        $comment = $this->parserestclient->query(array(
                                            "objectId" => "Comments",
                                            'query' => '{"objectId":"' . $postComments[$k]['objectId'] . '"}',
                                                )
                                        );
                                        $comments = json_decode(json_encode($comment));
                                        foreach ($comments as $data) {
                                            $commenter = $data->Commenter;
                                            $user_details = $this->parserestclient->query(array(
                                                "objectId" => "_User",
                                                'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                                                    )
                                            );
                                            $user_details = json_decode(json_encode($user_details), true);
                                            ?>
                                            <p><?php echo date('d-m-Y g:i A', strtotime($data->createdAt)); ?>: <?php
                                                if (isset($user_details[0]['username'])):
                                                    echo '<b>' . $user_details[0]['username'] . ': </b>';
                                                endif;
                                                ?>
                                                <?php echo $data->Comments; ?>
                                            </p>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        } }
                        ?>
                <?php } ?>
            </table>
            <?php } ?>
        </div>
        <div class="span2"><br><br><br><br>
            <button onclick="window.print();" class="btn btn-small btn-primary menu-button">Export</button><br><br>
            <button id="show_option" class="btn btn-small btn-primary menu-button">Save</button><br><br>
            <button onclick="" class="btn btn-small btn-primary menu-button">Analyse</button><br><br>
            <button onclick="" class="btn btn-small btn-primary menu-button">Select Metadata</button><br><br>
            <a href="<?php echo base_url(); ?>events/index" class="btn btn-small btn-primary menu-button">
                Back to Event Viewer
            </a><br><br>
            <a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
                Console Menu
            </a><br><br>
        </div>
    </div>
            </div>

        <?php $this->load->view('default/footer/console_page.php'); ?>
    <div style="clear:both; height: 20px"></div>
    <div id="download_metadata" class="modal">
           <div class="modal-header">
                    <span id="close" class="close">&times;</span>
                    <h2 id="headingComment">Download Metadata</h2>
                </div>
                <!-- Modal content -->
                <div class="modal-content">
                    <a class="btn btn-small btn-primary btn-info" href="<?php echo base_url();?>events/downloadMeta/<?php echo $event[0]['objectId']; ?>/pdf">
                        PDF
                    </a>
                     <a class="btn btn-small btn-primary btn-info" href="<?php echo base_url();?>events/downloadMeta/<?php echo $event[0]['objectId']; ?>/xls">
                        Excel
                    </a>
                     <a class="btn btn-small btn-primary btn-info" href="<?php echo base_url();?>events/downloadMeta/<?php echo $event[0]['objectId']; ?>/csv">
                        CSV
                    </a>
                </div>
                <div class="modal-footer">
                    <div style="float:right">
                        <button type="button" class="btn btn-small btn-primary btnMetaClose" style="float:left;margin-right:20px;" >Close</button>
                    </div>
                    <div style="clear:both"></div>
                </div>
        </div>
    <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
        
    <script>
        $('.btnMetaClose').on('click', function () {
            $('#download_metadata').fadeOut();
        });
        $('#show_option').on('click', function () {
            $('#download_metadata').fadeIn();
        });
        $('#close').on('click', function () {
            $('#download_metadata').fadeOut();
        });
    </script>