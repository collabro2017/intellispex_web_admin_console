<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('default/head/console_page.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/css/events.css" />
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/colorbox/colorbox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <style>
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
    </style>
    <body class="login-layout admin-body">
        <?php $this->load->view('default/nav/console_page.php'); ?>
        <div class="container" id="main-container">
            <div id="main-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-main">
                            <div class="row-fluid">
                                <div class="span8">


                                    <div class="span12">
                                        <h3><?php echo $event->eventname; ?></h3>
                                        <?php
                                        if (isset($event->thumbImage) && isset($event->postImage)) {
                                            $image = $event->thumbImage;
                                            $imagePost = $event->postImage;
                                            ?>
                                            <a class="groupPhoto"  href="<?php echo $imagePost->url; ?>" title="<?php echo $event->eventname; ?>">
                                                <img style="width:70%;" style="cursor: pointer" id="eventImage" src="<?php echo $imagePost->url; ?>" />    
                                            </a>
                                            <?php
                                        }
                                        ?>
                                        <div class="span8" style="margin: 0">
                                            <div  style="background: #eee; border: 1px solid #b2b2b2;padding: 10px;margin: 0">
                                                <h4>Description: </h4>
                                                <p><?php echo $event->description; ?></p>
                                            </div>
                                            <div style="background: #eee; border: 1px solid #b2b2b2;padding: 10px;margin: 0;border-top: 0px;width: 85%;margin-left: 10.5%;">

                                                <h4>Comments</h4>
                                                <a id="add_comment" class="btn btn-small btn-primary"  href="javascript:void(0)" class="btn btn-small btn-primary menu-button"> Add </a> 
                                                <div style="clear:both"></div>

                                                <?php
                                                if (count($event_comment)) {
                                                    foreach ($event_comment as $data) {
                                                        $commenter = $data->Commenter;
                                                        $user_details = $this->parserestclient->query(array(
                                                            "objectId" => "_User",
                                                            'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                                                                )
                                                        );
                                                        $user_details = json_decode(json_encode($user_details), true);
                                                        ?>
                                                        <div style="float:left">
                                                            <span style="color: #444"><?php echo date('d-m-Y g:i A', strtotime($event->createdAt)) . ": "; ?></span>
                                                            <b>
                                                                <?php
                                                                if (isset($user_details[0]['username'])):
                                                                    echo $user_details[0]['username'] . ": ";
                                                                endif;
                                                                ?>
                                                            </b>
                                                            <?php echo $data->Comments; ?>
                                                        </div>
                                                        <div style="float:right">
                                                            <a  href="javascript:updateComment('<?php echo $data->objectId; ?>')" style="background: transparent; border: none; font-size: 15px;color:#000;"> <i class="fa fa-pencil"></i> </a> 
                                                            <a  href="javascript:deletComment('<?php echo $data->objectId; ?>');" style="background: transparent; border: none; font-size: 15px;color:#000;"> <i class="fa fa-remove"></i> </a> 
                                                        </div>
                                                        <div style="clear:both"></div>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="span4" style="margin: 0">
                                            <ul style="list-style: none">
                                                <li style="float: left">
                                                    <a id="add_event" class="btn btn-small btn-primary"  href="javascript:void(0)"> <i class="fa fa-pencil"></i>  </a> 	
                                                </li>
                                                <li style="float:left">
                                                    <a class="btn btn-small btn-primary"  href="javascript:deletevent();"> <i class="fa fa-remove"></i> </a> 	
                                                </li>
                                                <li style="float:left">
                                                    <a class="btn btn-small btn-primary"  href="javascript:report();"> <i class="fa fa-flag"></i> </a> 	
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div style="clear:both;height: 20px"></div>
                                    <div class="span12" style="margin: 0;">
                                        <ul style="margin:0px; padding: 0px;">
                                            <?php
                                            if (isset($event_post)) {
                                                foreach ($event_post as $post) {
                                                    ?>
                                                    <li style="margin: 0px;padding: 0;position: relative;margin-top: 20px;">
                                                        <div style="background: #eee;  border: 1px solid #b2b2b2;padding: 0px;margin: 0;">
                                                            <div class="span3" style="padding: 0px;background: #FFF;padding-left: 15px;border-right: 1px solid #b2b2b2; ">
                                                                <h3><?php echo $post->title; ?></h3>
                                                                <?php
                                                                if (isset($post->countryLatLong)) {
                                                                    ?><p><i class="fa fa-map-marker"></i><?php echo $post->countryLatLong; ?></p> <?php
                                                                }
                                                                ?>
                                                                <p>
                                                                    <?php echo date('Y-m-d g:i', strtotime($post->createdAt)); ?>
                                                                </p>
                                                            </div>
                                                            <div style="background: #eee;margin: 0;padding: 10px;" class="span9">
                                                                <div style="float:left;width: 90%;">
                                                                    <?php
                                                                    $commenter = $post->user;
                                                                    $user_details = $this->parserestclient->query(array(
                                                                        "objectId" => "_User",
                                                                        'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                                                                            )
                                                                    );
                                                                    $user_details = json_decode(json_encode($user_details), true);
                                                                    ?>
                                                                    <p><b>By:  <?php
                                                                            if (isset($user_details[0]['username'])):
                                                                                echo $user_details[0]['username'] . ": ";
                                                                            endif;
                                                                            ?></b> </p>
                                                                    <p><?php echo $post->description; ?></p></div>
                                                                <div style="float:right;">
                                                                    <a  href="javascript:updatePost('<?php echo $post->objectId; ?>')" style="background: transparent; border: none; font-size: 15px;color:#000;"> <i class="fa fa-pencil"></i> </a> 
                                                                    <a  href="javascript:deletPost('<?php echo $post->objectId; ?>');" style="background: transparent; border: none; font-size: 15px;color:#000;"> <i class="fa fa-remove"></i> </a>
                                                                    <a  href="javascript:reportPost('<?php echo $post->objectId; ?>');" style="background: transparent; border: none; font-size: 15px;color:#000;"> <i class="fa fa-flag"></i> </a> 
                                                                </div>
                                                            </div>
                                                            <div style="clear: both;"></div>
                                                        </div>
                                                        <?php
                                                        if(isset($post->postType)){
                                                            if (isset($post->thumbImage) && isset($post->postFile) && $post->postType == 'photo') {
                                                                $image = $post->thumbImage;
                                                                $imagePost = $post->postFile;
                                                                ?>
                                                                <style>
                                                                    <?php
                                                                    if (strlen($post->title) > 120 && strlen($post->title) < 180) {
                                                                        ?>
                                                                        .cboxPhoto{ height: 98% !important; }
                                                                        <?php
                                                                    } elseif (strlen($post->title) > 180) {
                                                                        ?>
                                                                        .cboxPhoto{ height: 96% !important; }
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </style>

                                                                <a  class="groupPhoto"  href="<?php echo $imagePost->url; ?>" title="<?php echo $post->title; ?>">
                                                                    <img style="width:70%;" style="cursor: pointer" id="eventImage" src="<?php echo $imagePost->url; ?>" />
                                                                </a>
                                                                <?php
                                                            } elseif ($post->postType == 'video') {
                                                                $video = $post->postFile;
                                                                $name = explode('.', basename($video->url));
                                                                $extension = $name['1'];
                                                                ?>
                                                                <?php if ($extension == 'mp4' || $extension == 'ogg') { ?>
                                                                    <video name="<?php echo $post->title; ?>" style="width: 100%;" controls autoplay>
                                                                        <source src="<?php echo $video->url; ?>" type="video/<?php echo $extension; ?>" />
                                                                        Sorry, your browser doesn't support the video element.
                                                                    </video>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <video style="width: 100%;" controls="controls" width="800" height="600" name="<?php echo $post->title; ?>" src="<?php echo $video->url; ?>"></video>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                                                        <script type="text/javascript">
                                                            window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");
                                                        </script>
                                                        <div style="clear:both"></div>

                                                        <div style="width:80%;float: right;background: #eee;  border: 1px solid #b2b2b2;margin: 0;padding-left: 20px;">
                                                            <div style="clear: both;height:20px;"></div>
                                                            <a id="add_post_comment<?php echo $post->objectId; ?>" class="btn btn-small btn-primary"  href="javascript:void(0)" class="btn btn-small btn-primary menu-button"> Add </a> 
                                                            <script>

                                                                $('#add_post_comment<?php echo $post->objectId; ?>').on('click', function () {
                                                                    $('#comment_form').attr('action', '<?php echo base_url(); ?>events/add_post_comment/<?php echo $post->objectId; ?>')
                                                                            $('#add_comment_modal').fadeIn();
                                                                        });
                                                            </script>
                                                            <?php
                                                            if (isset($post->commentsArray)) {
                                                                ?>
                                                                <?php
                                                                $postComments = $post->commentsArray;
                                                                for ($i = 0; $i < count($postComments); $i++) {
                                                                    $comment = $this->parserestclient->query(array(
                                                                        "objectId" => "Comments",
                                                                        'query' => '{"objectId":"' . $postComments[$i]->objectId . '"}',
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
                                                        </div>
                                                        <div style="clear:both"></div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php if (isset($event->audio)) { ?>
                                        <div style="clear:both;height: 10px;"></div>


                                        <div class="span12">
                                            <?php
                                            $audio = $event->audio;
                                            ?>
                                            <audio controls>
                                                <source src="<?php echo $audio->url; ?>" type="audio/mpeg">
                                                Sorry, your browser does not support the audio element.
                                            </audio>

                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php if (isset($event->video)) { ?>
                                        <div style="clear:both;height: 10px;"></div>


                                        <div class="span12">
                                            <?php
                                            $video = $event->video;
                                            $name = explode('.', basename($video->url));
                                            $extension = $name['1'];
                                            ?>
                                            <?php if ($extension == 'mp4' || $extension == 'ogg') { ?>
                                                <video style="width: 100%;" controls autoplay>
                                                    <source src="<?php echo $video->url; ?>" type="video/<?php echo $extension; ?>" />
                                                    Sorry, your browser doesn't support the video element.
                                                </video>
                                                <?php
                                            } else {
                                                ?>
                                                <video style="width: 100%;" controls="controls" src="<?php echo $video->url; ?>">
                                                    Sorry, your browser doesn't support the video element.
                                                </video>
                                                <?php
                                            }
                                            ?>
                                            <video width="320" height="240" controls autoplay>
                                                <source src="<?php echo $event->video; ?>" type="video/<?php echo $extension; ?>">
                                                Sorry, your browser doesn't support the video element.
                                            </video>

                                        </div>
                                    <?php } ?>


                                    <div style="clear:both;height:10px"></div>
                                    <div class="span12">
                                        <div class="span4" style="text-align:center;margin-left: 300px"> 
                                            <a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
                                                Console Menu
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2"> 
                                    <h3>Tag Users/User Group</h3>
                                    <ul  class="list-group">
                                        <li class="list-group-item">
                                            <a href="<?php echo base_url(); ?>events/download/<?php echo $event->objectId; ?>">
                                                Full Resolution PDF
                                            </a>
                                        </li>
                                        <?php if (count($associated_user) > 0) { ?>
                                            <li class="list-group-item">
                                                Users
                                                <ul class="children">
                                                    <?php foreach ($associated_user as $user) {
                                                        
                                                            if (isset($user['username'])): 
                                                        ?>
                                                        <li>
                                                            <a id="create_group<?php echo $user['objectId']; ?>" href="#">
                                                                <?php echo $user['username']; ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                        endif;
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                        <?php if (count($associated_user) > 0) { ?>
                                            <li class="list-group-item">
                                                User Group
                                                <ul class="children">
                                                    <?php foreach ($user_group as $group) {
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>events/tag_user_group/<?php echo $group['objectId']; ?>/<?php echo $event->objectId; ?>">
                                                                <?php
                                                                if (isset($group['group_name'])):
                                                                    echo $group['group_name'];
                                                                endif;
                                                                ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="span2">
                                    <a class="btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>manage/logout">
                                        Logout
                                    </a>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <a class=" btn btn-small btn-primary menu-button menu-logout-button menu-button-small" href="<?php echo base_url(); ?>/manage/sqlserver">
                                        SQL Server
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('default/footer/console_page.php'); ?>
        <?php
        if (count($associated_user) > 0) {
            foreach ($associated_user as $user) {
                ?>
                <div id="create_group_modal<?php echo $user['objectId']; ?>" class="modal">
                    <form class="form-horizontal" action='<?php echo base_url(); ?>events/tag_user/' method='post' style="margin-bottom:0">
                        <div class="modal-header">
                            <span id="close<?php echo $user['objectId']; ?>" class="close">&times;</span>
                            <h2>Tag User</h2>
                        </div>
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <label for="access_rights" style="text-align: left" class="col-sm-2 control-label">User Rights</label>
                                    </div>
                                    <div style="clear: both" class="col-sm-10">
                                        <select required="" id="access_rights" name="access_rights">
                                            <option value="Full Rights">Full Rights</option>
                                            <option value="View & Comments">View & Comments</option>
                                            <option value="Comment">Comment</option>
                                            <option value="View Only">View Only</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div style="float:right">
                                <input type="hidden" name="user_id" value="<?php echo $user['objectId']; ?>" />
                                <input type="hidden" name="event_id" value="<?php echo $event->objectId; ?>" />
                                <button type="button" class="btn btn-small btn-primary btnClose<?php echo $user['objectId']; ?>" style="float:left;margin-right:20px;" >Close</button>
                                <button type="submit" class="btn btn-small btn-primary" style="float:left;" >Submit</button>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </form>

                </div>
                <script>

                    // Get the create group Start
                    $('.btnClose<?php echo $user['objectId']; ?>').on('click', function () {
                        $('#create_group_modal<?php echo $user['objectId']; ?>').css('display', 'none');
                    });
                    $('#create_group<?php echo $user['objectId']; ?>').on('click', function () {
                        $('#create_group_modal<?php echo $user['objectId']; ?>').css('display', 'block');
                    });
                    $('#close<?php echo $user['objectId']; ?>').on('click', function () {
                        $('#create_group_modal<?php echo $user['objectId']; ?>').css('display', 'none');
                    });


                    // When the user clicks anywhere outside of the create_group, close it
                    //            window.onclick = function (event) {
                    //                if (event.target == create_group) {
                    //                    create_group.style.display = "none";
                    //                }
                    //            }
                    // Create Group End
                </script>
                <?php
            }
        }
        ?>

        <!-- Update Event Modal Start -->
        <div id="event_modal" class="modal">
            <form class="form-horizontal" action='<?php echo base_url(); ?>events/update_event/<?php echo $event->objectId; ?>' method='post' style="margin-bottom:0">
                <div class="modal-header">
                    <span id="close" class="close">&times;</span>
                    <h2>Update Event</h2>
                </div>
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="e" style="text-align: left" class="col-sm-2 control-label">Event Name</label>
                        </div>
                        <div style="clear: both" class="col-sm-10">
                            <input required="" id="eventname" name="eventname" class="form-control" id="focusedInput" type="text" value="<?php echo $event->eventname; ?>" placeholder="Event Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="access_rights" style="text-align: left" class="col-sm-2 control-label">Description</label>
                        </div>
                        <div style="clear: both" class="col-sm-10">
                            <textarea style="width: 97%; height: 120px;" name="description" cols="10" rows="10">
                                <?php echo $event->description; ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="float:right">
                            <input type="hidden" name="event_id" value="<?php echo $event->objectId; ?>" />
                            <button type="button" class="btn btn-small btn-primary btnEventClose" style="float:left;margin-right:20px;" >Close</button>
                            <button type="submit" class="btn btn-small btn-primary" style="float:left;" >Submit</button>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Update Event Modal End -->

        <!-- Add Comment Modal -->

        <div id="add_comment_modal" class="modal">
            <form id='comment_form' class="form-horizontal" action='<?php echo base_url(); ?>events/add_event_comment/<?php echo $event->objectId; ?>' method='post' style="margin-bottom:0">
                <div class="modal-header">
                    <span id="close" class="close">&times;</span>
                    <h2 id="headingComment">Add New Comment</h2>
                </div>
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="access_rights" style="text-align: left" class="col-sm-2 control-label">Description</label>
                        </div>
                        <div style="clear: both" class="col-sm-10">
                            <textarea id="comments" style="width: 100%; height: 200px;" name="Comments" cols="10" rows="10">

                            </textarea>
                        </div>
                        <div style="clear:both; height: 10px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="float:right">
                        <input type="hidden" name="Commenter" value="<?php echo $current_user; ?>" />
                        <input type="hidden" name="commentId" id="commentId" value="" />
                        <input type="hidden" name="postId" id="postId" value="" />
                        <input type="hidden" name="targetEvent" value="<?php echo $event->objectId; ?>" />
                        <button type="button" class="btn btn-small btn-primary btnCommentClose" style="float:left;margin-right:20px;" >Close</button>
                        <button type="submit"  id="btnComment" class="btn btn-small btn-primary">Add Comment</button>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </form>
        </div>
        <!-- Add Comment Modal End -->

        <!-- Update Post Title & Description -->

        <div id="update_post_modal" class="modal">
            <form id='comment_form' class="form-horizontal" action='<?php echo base_url(); ?>events/update_event_post/<?php echo $event->objectId; ?>' method='post' style="margin-bottom:0">
                <div class="modal-header">
                    <span id="close" class="close">&times;</span>
                    <h2 id="headingComment">Update Post</h2>
                </div>
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="access_rights" style="text-align: left" class="col-sm-2 control-label">Title</label>
                        </div>
                        <div style="clear: both" class="col-sm-10">
                            <input type="text" name="title" id="title" />
                            <input type="hidden" name="title2" id="title2" />
                        </div>
                        <div class="col-sm-10">
                            <label for="access_rights" style="text-align: left" class="col-sm-2 control-label">Description</label>
                        </div>
                        <div style="clear: both" class="col-sm-10">
                            <textarea id="description" style="width: 100%; height: 200px;" name="description" cols="10" rows="10">

                            </textarea>
                        </div>
                        <div style="clear:both; height: 10px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="float:right">
                        <input type="hidden" name="Commenter" value="<?php echo $current_user; ?>" />
                        <input type="hidden" name="postId" id="postId" />
                        <input type="hidden" name="targetEvent" value="<?php echo $event->objectId; ?>" />
                        <button type="button" class="btn btn-small btn-primary btnPostClose" style="float:left;margin-right:20px;" >Close</button>
                        <button type="submit"  id="btnComment" class="btn btn-small btn-primary">Update Post</button>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </form>
        </div>
        <!-- Update Post Title & Description Modal End -->

        <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('public') ?>/js/jquery.colorbox.js"></script>
        <script type="text/javascript">
                    $('.btnEventClose').on('click', function () {
                        $('#event_modal').fadeOut();
                    });
                    $('#add_event').on('click', function () {
                        $('#event_modal').fadeIn();
                    });
                    $('#close').on('click', function () {
                        $('#event_modal').fadeOut();
                    });

                    $('.btnCommentClose').on('click', function () {
                        $('#add_comment_modal').fadeOut();
                    });
                    $('#add_comment').on('click', function () {
                        $('#add_comment_modal').fadeIn();
                    });
                    $('#close').on('click', function () {
                        $('#add_comment_modal').fadeOut();
                    });

                    $('.btnPostClose').on('click', function () {
                        $('#update_post_modal').fadeOut();
                    });
                    $('#close').on('click', function () {
                        $('#update_post_modal').fadeOut();
                    });
                    function deletevent() {
                        if (window.confirm("Are you sure want to delete selected event?")) {

                            var deletelist = [];
                            deletelist.push('<?php echo $event->objectId; ?>');
                            $.post("<?php echo base_url(); ?>events/eventdelete", {deletelist: deletelist}, function (data) {
                                //console.log(data);
                                window.location.href = "<?php echo base_url(); ?>events/index";
                            });
                        }
                    }
                    function report() {
                        if (window.confirm("Are you sure want to report selected event?")) {

                            var deletelist = [];
                            deletelist.push('<?php echo $event->objectId; ?>');
                            $.post("<?php echo base_url(); ?>events/reportEvent", {deletelist: "<?php echo $event->objectId; ?>"}, function (data) {
                                //console.log(data);
                                window.location.href = "<?php echo base_url(); ?>events/index";
                            });
                        }
                    }
                    function reportPost(postId) {
                        if (window.confirm("Are you sure want to report selected post?")) {

                            var deletelist = [];
                            deletelist.push('<?php echo $event->objectId; ?>');
                            $.post("<?php echo base_url(); ?>events/reportPost/<?php echo $event->objectId; ?>", {deletelist: postId}, function (data) {
                                            //console.log(data);
                                            window.location.href = "<?php echo base_url(); ?>events/index";
                                        });
                                    }
                                }
                                function deletComment(comment_id) {
                                    if (window.confirm("Are you sure want to delete selected comment?")) {

                                        $.post("<?php echo base_url(); ?>events/commentdelete", {commentId: comment_id}, function (data) {
                                            //console.log(data);
                                            window.location.href = "<?php echo base_url(); ?>events/event/<?php echo $event->objectId; ?>";
                                                        });
                                                    }
                                                }

                                                function deletPost(post_id) {
                                                    if (window.confirm("Are you sure want to delete selected post?")) {

                                                        $.post("<?php echo base_url(); ?>events/postdelete", {postId: post_id}, function (data) {
                                                            //console.log(data);
                                                            window.location.href = "<?php echo base_url(); ?>events/event/<?php echo $event->objectId; ?>";
                                                                        });
                                                                    }
                                                                }
                                                                function updateComment(comment_id) {
                                                                    $.post("<?php echo base_url(); ?>events/comments", {commentId: comment_id}, function (data) {
                                                                        $('#comment_form').attr('action', '<?php echo base_url(); ?>events/update_event_comment/<?php echo $event->objectId; ?>');
                                                                                    var obj = jQuery.parseJSON(data);
                                                                                    $('#headingComment').html('Update Comment');
                                                                                    $('#btnComment').html('Update Comment');
                                                                                    $('#comments').val(obj.Comments);
                                                                                    $('#commentId').val(comment_id);
                                                                                    $('#add_comment_modal').fadeIn();
                                                                                });
                                                                            }
                                                                            function updatePost(post_id) {
                                                                                $('#postId').val(post_id);
                                                                                $.post("<?php echo base_url(); ?>events/Post", {postId: post_id}, function (data) {
                                                                                    var obj = jQuery.parseJSON(data);
                                                                                    $('#description').val(obj.description);
                                                                                    $('#title').val(obj.title);
                                                                                    $('#title2').val(obj.objectId);
                                                                                    $('#update_post_modal').fadeIn();
                                                                                });
                                                                            }
                                                                            $(document).ready
                                                                                    (
                                                                                            function ()
                                                                                            {
                                                                                                $(".groupPhoto").colorbox({rel: 'groupPhoto', transition: "fade"});
                                                                                                $('#event_area ul').multiSelect
                                                                                                        (
                                                                                                                {
                                                                                                                    unselectOn: '#event_area',
                                                                                                                    keepSelection: true,
                                                                                                                }
                                                                                                        );
                                                                                            }
                                                                                    //.hover(function(){
                                                                                    //                            alert('test');
                                                                                    //                           $(this).find('.children').slideToggle(); 
                                                                                    //                        });
                                                                                    );

                                                                            $('.list-group-item').hover(function () {
                                                                                $(this).find('.children').slideToggle();
                                                                            });
                                                                            function deletesheets()
                                                                            {
                                                                                $("#event_area ul li.selected").each
                                                                                        (
                                                                                                function (index)
                                                                                                {
                                                                                                    console.log(index + ": " + $(this).data("id"));
                                                                                                }
                                                                                        );
                                                                                alert("Delete Sheets");
                                                                            }

                                                                            $.fn.multiSelect = function (o)
                                                                            {
                                                                                var defaults = {
                                                                                    multiselect: true,
                                                                                    selected: 'selected',
                                                                                    filter: ' > *',
                                                                                    unselectOn: false,
                                                                                    keepSelection: true,
                                                                                    list: $(this).selector,
                                                                                    e: null,
                                                                                    element: null,
                                                                                    start: false,
                                                                                    stop: false,
                                                                                    unselecting: false
                                                                                }
                                                                                return this.each(function (k, v) {
                                                                                    var options = $.extend({}, defaults, o || {});
                                                                                    // selector - parent, assign listener to children only
                                                                                    $(document).on('mousedown', options.list + options.filter, function (e)
                                                                                    {
                                                                                        if (e.which == 1)
                                                                                        {
                                                                                            if (options.handle != undefined && !$(e.target).is(options.handle)) {

                                                                                                return true;
                                                                                            }
                                                                                            options.e = e;
                                                                                            options.element = $(this);
                                                                                            multiSelect(options);
                                                                                        }
                                                                                        return true;
                                                                                    });

                                                                                    if (options.unselectOn)
                                                                                    {
                                                                                        $(document).on('mousedown', options.unselectOn, function (e)
                                                                                        {
                                                                                            if (!$(e.target).parents().is(options.list) && e.which != 3)
                                                                                            {
                                                                                                $(options.list + ' .' + options.selected).removeClass(options.selected);
                                                                                                if (options.unselecting != false)
                                                                                                {
                                                                                                    options.unselecting();
                                                                                                }
                                                                                            }
                                                                                        });

                                                                                    }

                                                                                });


                                                                            }

                                                                            function multiSelect(o)
                                                                            {
                                                                                var target = o.e.target;
                                                                                var element = o.element;
                                                                                var list = o.list;

                                                                                if ($(element).hasClass('ui-sortable-helper'))
                                                                                {
                                                                                    return false;
                                                                                }

                                                                                if (o.start != false)
                                                                                {
                                                                                    var start = o.start(o.e, $(element));
                                                                                    if (start == false)
                                                                                    {
                                                                                        return false;
                                                                                    }
                                                                                }

                                                                                if (o.e.shiftKey && o.multiselect)
                                                                                {
                                                                                    $(element).addClass(o.selected);
                                                                                    first = $(o.list).find('.' + o.selected).first().index();
                                                                                    last = $(o.list).find('.' + o.selected).last().index();

                                                                                    if (last < first)
                                                                                    {
                                                                                        firstHolder = first;
                                                                                        first = last;
                                                                                        last = firstHolder;
                                                                                    }

                                                                                    if (first == -1 || last == -1)
                                                                                    {
                                                                                        return false;
                                                                                    }

                                                                                    $(o.list).find('.' + o.selected).removeClass(o.selected);

                                                                                    var num = last - first;
                                                                                    var x = first;

                                                                                    for (i = 0; i <= num; i++)
                                                                                    {
                                                                                        $(list).find(o.filter).eq(x).addClass(o.selected);
                                                                                        x++;
                                                                                    }
                                                                                } else if ((o.e.ctrlKey || o.e.metaKey) && o.multiselect)
                                                                                {
                                                                                    if ($(element).hasClass(o.selected))
                                                                                    {
                                                                                        $(element).removeClass(o.selected);
                                                                                    } else
                                                                                    {
                                                                                        $(element).addClass(o.selected);
                                                                                    }
                                                                                } else
                                                                                {
                                                                                    if (o.keepSelection && !$(element).hasClass(o.selected))
                                                                                    {
                                                                                        $(list).find('.' + o.selected).removeClass(o.selected);
                                                                                        $(element).addClass(o.selected);
                                                                                    } else
                                                                                    {
                                                                                        $(list).find('.' + o.selected).removeClass(o.selected);
                                                                                        $(element).addClass(o.selected);
                                                                                    }

                                                                                }

                                                                                if (o.stop != false)
                                                                                {
                                                                                    o.stop($(list).find('.' + o.selected), $(element));
                                                                                }

                                                                            }
        </script>

    </body>
</html>
