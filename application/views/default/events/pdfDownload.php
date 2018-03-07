<?php
$imagePost = $event->postImage->url;
//print_r($event_post);
?>
<style>
    *{
        font-family: "Trebuchet MS", Helvetica, sans-serif;
    }
    h4 {
        color: black;
        font-family: "Trebuchet MS", Helvetica, sans-serif;
        font-size: 13px;
        padding: 0;
        font-weight: normal;
        margin: 0;
    }
    p {
        font-family:  "Trebuchet MS", Helvetica, sans-serif;
        font-size: 12px;
        padding: 20px;
    }
    table {
        color: #000;
        font-family: helvetica;
        font-size: 8pt;
        border: none;
    }
    td{
        margin-top: 20px;
    }
    .lowercase {
        text-transform: lowercase;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .capitalize {
        text-transform: capitalize;
    }
</style>
<?php
$event_user = $event->user->objectId;
$event_user_details = json_decode(json_encode($this->parserestclient->query(array(
                    "objectId" => "_User",
                    'query' => '{"deletedAt":null,"objectId":"' . $event_user . '"}',
                        )
        )));
$image = $event_user_details[0]->ProfileImage->url;
?>
<table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
    <tr>
        <td style="text-align:left;width: 50px">
            <img style="height:50px;"  src="<?php echo $image; ?>" />
        </td>
        <td style="text-align:left;">
            <h4>
                <?php
                if (isset($event_user_details[0]->username)):
                    echo $event_user_details[0]->username;
                endif;
                ?>
            </h4>
        </td>
    </tr>
</table>
<br/><br/>
<table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
    <tr>
        <td style="text-align:center;">
            <img style="width:400px;" src="<?php echo $imagePost; ?>" />
        </td>
    </tr>
</table>
<br/><br/>
<table width="200" cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
    <tr>
        <td style="text-align:left;width: 20px;">
            <img align="middle"  src="<?php echo base_url() ?>public/like.png" style="width:20px;" />&nbsp;&nbsp;
        </td>
        <td style="text-align:left;">
            <span><?php
                if (isset($event->likeUserArray)) {
                    echo count($event->likeUserArray);
                } else {
                    echo 0;
                }
                ?>
            </span>
        </td>
        <td style="text-align:left;width: 20px;">
            <img align="middle" src="<?php echo base_url() ?>public/message.png" style="width:20px;" />&nbsp;&nbsp;
        </td>
        <td style="text-align:left;">
            <span><?php
                if (isset($event_comment)) {
                    echo count($event_comment);
                } else {
                    echo 0;
                }
                ?>
            </span>
        </td>
    </tr>
</table>

<table cellpadding="1" cellspacing="1" border="0" style="text-align:left;">
    <tr>
        <td style="text-align:left;">
            <?php echo $event->eventname; ?>
        </td>
    </tr>
    <tr>
        <td style="text-align:left;">
            <?php echo $event->description; ?>
        </td>
    </tr>
</table>
<?php
if (count($event_comment)) {
    $i = 0;
    ?>

    <h4>Event Comments</h4>
    <?php
    foreach ($event_comment as $data) {
        $commenter = $data->Commenter;
        $user_details = $this->parserestclient->query(array(
            "objectId" => "_User",
            'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                )
        );
        $user_details = json_decode(json_encode($user_details), true);
        
        ?>
        <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
            <tr>
                    <?php if(isset($user_details[0]['ProfileImage'])){ 
                    $image = $user_details[0]['ProfileImage']['url'];
                    ?>
                <td style="text-align:left;width: 50px">
                        <img style="height:50px;"  src="<?php echo $image; ?>" />
                   
                </td>
                 <?php 
                    }
                    ?>
                <td style="text-align:left;">
                    <h4>
                        <?php
                        if (isset($user_details[0]['username'])):
                            echo $user_details[0]['username'];
                        endif;
                        ?>
                    </h4>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span style="text-align: right;color: #444"><?php echo date('d-m-Y g:i A', strtotime($data->createdAt)); ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $data->Comments; ?>
                </td>
            </tr>
        </table>
        <?php
    }
}
?>
<hr style="background-color: #bbb;color: #BBB" />
<br/><br/>
<?php if(count($event_post_ama) > 0 ){ foreach ($event_post_ama as $post) { ?>
    <?php
    $event_user = $post->user->objectId;
    $event_user_details = json_decode(json_encode($this->parserestclient->query(array(
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"objectId":"' . $event_user . '"}',
                            )
    )));
    if (isset($event_user_details[0])) {
        if(isset($event_user_details[0]->ProfileImage)){
            $image = $event_user_details[0]->ProfileImage->url;
        }
        ?>
        <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
            <tr>
                <td style="text-align:left;width: 50px">
                    
                    <?php if(isset($event_user_details[0]->ProfileImage->url)){ 
                        
                        ?>
                        <img style="height:50px;"  src="<?php echo $event_user_details[0]->ProfileImage->url; ?>" />
                    <?php } ?>
                </td>
                <td style="text-align:left;width:300px;">
                    <h4>
                        <?php
                        if (isset($event_user_details[0]->username)):
                            echo $event_user_details[0]->username;
                        endif;
                        ?>
                    </h4>
                </td>
                <td style="text-align:right;">
                    <?php echo date('d-m-Y g:i A', strtotime($post->createdAt)); ?>
                </td>
            </tr>
        </table>
    <?php } ?>
    <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <?php
        if (isset($post->thumbImage) && isset($post->postFile)) {
            $image = $post->thumbImage;
            $imagePost = $post->postFile->url;
            $imageMimeTypes = array(
                'image/png',
                'image/gif',
                'image/jpeg');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$post->postFile->url);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE){  
                $a = getimagesize($post->postFile->url);
                $image_type = $a[2];     
                if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {   
                    ?><tr>
                        <td style="text-align:left;">
                            <img style="width:400px;" src="<?php echo $post->postFile->url; ?>" />
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
    </table>
    <?php
    if (isset($post->commentsArray)) {
        $postComments = count($post->commentsArray);
    } else {
        $postComment = 0;
    }
    ?>
    <table width="200" cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <tr>
            <td style="text-align:left;width: 20px;">
                <img align="middle"  src="<?php echo base_url() ?>public/like.png" style="width:20px;" />&nbsp;&nbsp;
            </td>
            <td style="text-align:left;">
                <span><?php
                    if (isset($post->likeUserArray)) {
                        echo count($post->likeUserArray);
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </td>
            <td style="text-align:left;width: 20px;">
                <img align="middle" src="<?php echo base_url() ?>public/message.png" style="width:20px;" />&nbsp;&nbsp;
            </td>
            <td style="text-align:left;">
                <span><?php
                    if (isset($postComments)) {
                        echo count($event_comment);
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </td>
        </tr>
    </table>
    <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <tr>
            <td style="text-align:left;"><?php echo $post->title; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;">
                <?php echo $post->description; ?>
            </td>
        </tr>
    </table>

    <?php
    if (isset($post->commentsArray)) {
        ?>
        <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
            <tr>
                <td style="text-align:left;">
                    <h4>Event Comments</h4>
                </td>
            </tr>
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
                    <tr>
                        <td style="text-align:left;">
                            <p><?php echo date('d-m-Y g:i A', strtotime($data->createdAt)); ?>: <?php
                                if (isset($user_details[0]['username'])):
                                    echo '<b>' . $user_details[0]['username'] . ': </b>';
                                endif;
                                ?>
                                <?php echo $data->Comments; ?>
                            </p>
                        </td>
                    </tr>
                    <?php
                }
            } ?>
        </table>
                    <?php
        }
        ?>
    <?php } } ?><br/><br/>
<?php if(count($event_post) > 0 ){ foreach ($event_post as $post) { ?>
    <?php
    $event_user = $post->user->objectId;
    $event_user_details = json_decode(json_encode($this->parserestclient->query(array(
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"objectId":"' . $event_user . '"}',
                            )
    )));
    if (isset($event_user_details[0])) {
        if(isset($event_user_details[0]->ProfileImage)){
            $image = $event_user_details[0]->ProfileImage->url;
        }
        ?>
        <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
            <tr>
                <td style="text-align:left;width: 50px">
                    
                    <?php if(isset($event_user_details[0]->ProfileImage->url)){ 
                        
                        ?>
                        <img style="height:50px;"  src="<?php echo $event_user_details[0]->ProfileImage->url; ?>" />
                    <?php } ?>
                </td>
                <td style="text-align:left;width:300px;">
                    <h4>
                        <?php
                        if (isset($event_user_details[0]->username)):
                            echo $event_user_details[0]->username;
                        endif;
                        ?>
                    </h4>
                </td>
                <td style="text-align:right;">
                    <?php echo date('d-m-Y g:i A', strtotime($post->createdAt)); ?>
                </td>
            </tr>
        </table>
    <?php } ?>
    <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <?php
        if (isset($post->thumbImage) && isset($post->postFile)) {
            $image = $post->thumbImage;
            $imagePost = $post->postFile->url;
            $imageMimeTypes = array(
                'image/png',
                'image/gif',
                'image/jpeg');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$post->postFile->url);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE){  
                $a = getimagesize($post->postFile->url);
                $image_type = $a[2];     
                if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {   
                    ?><tr>
                        <td style="text-align:left;">
                            <img style="width:400px;" src="<?php echo $post->postFile->url; ?>" />
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
    </table>
    <?php
    if (isset($post->commentsArray)) {
        $postComments = count($post->commentsArray);
    } else {
        $postComment = 0;
    }
    ?>
    <table width="200" cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <tr>
            <td style="text-align:left;width: 20px;">
                <img align="middle"  src="<?php echo base_url() ?>public/like.png" style="width:20px;" />&nbsp;&nbsp;
            </td>
            <td style="text-align:left;">
                <span><?php
                    if (isset($post->likeUserArray)) {
                        echo count($post->likeUserArray);
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </td>
            <td style="text-align:left;width: 20px;">
                <img align="middle" src="<?php echo base_url() ?>public/message.png" style="width:20px;" />&nbsp;&nbsp;
            </td>
            <td style="text-align:left;">
                <span><?php
                    if (isset($postComments)) {
                        echo count($event_comment);
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </td>
        </tr>
    </table>
    <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <tr>
            <td style="text-align:left;"><?php echo $post->title; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;">
                <?php echo $post->description; ?>
            </td>
        </tr>
    </table>

    <?php
    if (isset($post->commentsArray)) {
        ?>
        <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
            <tr>
                <td style="text-align:left;">
                    <h4>Event Comments</h4>
                </td>
            </tr>
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
                    <tr>
                        <td style="text-align:left;">
                            <p><?php echo date('d-m-Y g:i A', strtotime($data->createdAt)); ?>: <?php
                                if (isset($user_details[0]['username'])):
                                    echo '<b>' . $user_details[0]['username'] . ': </b>';
                                endif;
                                ?>
                                <?php echo $data->Comments; ?>
                            </p>
                        </td>
                    </tr>
                    <?php
                }
            } ?>
        </table>
                    <?php
        }
        ?>
    <?php } } ?>
