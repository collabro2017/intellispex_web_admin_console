<?php
$imagePost = $event->postImage->url;
?>
<style>
    *{
        font-family: "Trebuchet MS", Helvetica, sans-serif;
    }
    h4 {
        color: black;
        font-family: "Trebuchet MS", Helvetica, sans-serif;
        font-size: 16px;
        padding: 0;
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
        border: 3px solid #b2b2b2;
        background-color: #eee;
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
<h4><?php echo $event->eventname; ?></h4>
<p><?php $event->description; ?></p>
<img width="800" src="<?php echo $imagePost; ?>" alt="<?php echo $event->eventname; ?>" border="0" />
<div class="span12">
    <?php if (count($event_comment)) { ?>
        <h4> Comments</h4>
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
            <h5> <?php
                if (isset($user_details[0]['username'])): echo $user_details[0]['username'];
                endif;
                ?>
            </h5>
            <p><?php echo date('d-m-Y g:i A', strtotime($event->createdAt)); ?><br/>
                <?php echo $data->Comments; ?>
            </p>
            <?php
        }
    }
    ?>
</div>
<div class="span12">
<?php if(count($event_post_ama) > 0 ){ foreach ($event_post_ama as $post) { ?>
    <h4><?php echo $post->title; ?></h4>
    <?php
//    if (isset($post->thumbImage) && isset($post->postFile) && $post->postType == 'photo') {
    if (isset($post->thumbImage) && isset($post->postFile) && (isset($post->postType) && $post->postType == 'photo')) {
        $image = $post->thumbImage;
        $imagePost = $post->postFile->url;
        ?>
    <?php } ?>
    <p>
        <?php
        if (isset($post->countryLatLong)) {
            ?><?php echo $post->countryLatLong; ?><br/> <?php
        }
        ?>
        <?php echo date('d-m-Y g:i A', strtotime($post->createdAt)); ?><br/>
        <?php echo $post->description;
        ?>
    </p>
        <?php
        if (isset($post->thumbImage) && isset($post->postFile)) {
            $image = $post->thumbImage;
            $imagePost = $post->postFile->url;
            $imageMimeTypes = array(
                'image/png',
                'image/gif',
                'image/jpeg');
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$imagePost);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE){  
                $a = getimagesize($imagePost);
                $image_type = $a[2];

                if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
                    ?>
                        <img style="width:700px;" src="<?php echo $imagePost; ?>" />
                                                                        
                    <?php
                }
            }
        }
        ?>
    <?php if (isset($post->commentsArray)) { ?>
            <h5>Comments</h5>
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
            ?>
        <div style="clear:both"></div>
    <?php } ?>
<?php } } ?>
</div>
<?php if(count($event_post) > 0){ foreach ($event_post as $post) { ?>
    <h4><?php echo $post->title; ?></h4>
    <?php
//    if (isset($post->thumbImage) && isset($post->postFile) && $post->postType == 'photo') {
    if (isset($post->thumbImage) && isset($post->postFile) && (isset($post->postType) && $post->postType == 'photo')) {
        $image = $post->thumbImage;
        $imagePost = $post->postFile->url;
        ?>
    <?php } ?>
    <p>
        <?php
        if (isset($post->countryLatLong)) {
            ?><?php echo $post->countryLatLong; ?><br/> <?php
        }
        ?>
        <?php echo date('d-m-Y g:i A', strtotime($post->createdAt)); ?><br/>
        <?php echo $post->description;
        ?>
    </p>
        <?php
        if (isset($post->thumbImage) && isset($post->postFile)) {
            $image = $post->thumbImage;
            $imagePost = $post->postFile->url;
            $imageMimeTypes = array(
                'image/png',
                'image/gif',
                'image/jpeg');
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$imagePost);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE){  
                $a = getimagesize($imagePost);
                $image_type = $a[2];

                if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
                    ?>
                        <img style="width:700px;" src="<?php echo $imagePost; ?>" />
                    <?php
                }
            }
        }
        ?>
    <?php if (isset($post->commentsArray)) { ?>
            <h5>Comments</h5>
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
            ?>
        <div style="clear:both"></div>
    <?php } ?>
<?php } }?>
