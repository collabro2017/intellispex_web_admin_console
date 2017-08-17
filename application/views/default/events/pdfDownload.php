<?php
$imagePost = $event->postImage->url;
?>
<h4><?php echo $event->eventname; ?></h4>
<p><?php $event->description; ?></p>
<img src="<?php echo $imagePost; ?>" alt="<?php echo $event->eventname; ?>" border="0" />
<div class="span12">
    <?php if (count($event_comment)) { ?>
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
            <h4> <?php
                if (isset($user_details[0]['username'])): echo $user_details[0]['username'];
                endif;
                ?>
            </h4>
            <p>Created: <?php echo date('Y-m-d', strtotime($event->createdAt)); ?></p>
            <p>
                <?php echo $data->Comments; ?>
            </p>
            <?php
        }
    }
    ?>
</div>
<?php foreach ($event_post as $post){ ?>
    <h4><?php echo $post->title; ?></h4>
    <?php if (isset($post->thumbImage) && isset($post->postFile) && $post->postType == 'photo') {
            $image = $post->thumbImage;
            $imagePost = $post->postFile->url; 
    ?>
    <img src="<?php echo $imagePost; ?>" alt="<?php echo $event->eventname; ?>" border="0" />
    <?php } ?>
    <p><?php echo $post->description; ?></p>
<?php } ?>
