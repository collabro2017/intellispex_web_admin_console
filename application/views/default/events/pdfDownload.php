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
        font-size: 14px;
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
<table width="200" cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
    <tr>
        <td style="text-align:left;">
            <img style="width:30px;border-radius: 20px;" src="<?php echo $image; ?>" />
        </td>
        <td style="text-align:left;">
            <h4><?php
            if (isset($event_user_details[0]->username)):
                echo $event_user_details[0]->username;
            endif;
            ?></h4>
        </td>
    </tr>
</table>

<table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
    <tr><td style="text-align:left;">
            <h4><?php echo $event->eventname; ?></h4></td>
    </tr>
    <tr><td style="text-align:left;">
            <p><?php $event->description; ?></p></td>
    </tr>

    <tr><td style="text-align:left;">
            <img align="middle" src="<?php echo $imagePost; ?>" alt="<?php echo $event->eventname; ?>" border="0" /></td>
    </tr>
</table>
<br/><br/>
<table width="200" cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
    <tr><td style="text-align:left;">
            <img align="middle"  src="<?php echo base_url() ?>public/like.png" style="width:20px;" />&nbsp;&nbsp;<span><?php
                if (isset($event->likeUserArray)) {
                    echo count($event->likeUserArray);
                } else {
                    echo 0;
                }
                ?></span>
        </td>
        <td style="text-align:left;">
            <img align="middle" src="<?php echo base_url() ?>public/message.png" style="width:20px;" />&nbsp;&nbsp;<span><?php
                if (isset($event_comment)) {
                    echo count($event_comment);
                } else {
                    echo 0;
                }
                ?></span>  
        </td>
    </tr>
</table>

<br/><br/>
    <?php if (count($event_comment)) { ?>
    <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
        <tr>
            <td style="text-align:left;"><h4> Comments</h4></td></tr>
        <?php
        foreach ($event_comment as $data) {
            $commenter = $data->Commenter;
            $user_details = $this->parserestclient->query(array(
                "objectId" => "_User",
                'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                    )
            );
            $user_details = json_decode(json_encode($user_details), true);
            $imagePost = $user_details[0]['postImage']['url'];
            ?>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <img width="500" align='middle' src="<?php echo $imagePost; ?>" alt="<?php echo $event->eventname; ?>" border="0" />
                </td>
            </tr>
            <tr>
                <td style="text-align:left;"><?php
            if (isset($user_details[0]['username'])): echo $user_details[0]['username'];
            endif;
            ?>
                </td>
                <td style="text-align:right;">
                    <?php echo date('d-m-Y g:i', strtotime($event->createdAt)); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left;">
        <?php echo $data->Comments; ?>
                </td>
            </tr>
        </table>
        <?php
    }
}
?>
<br/><br/>
<?php foreach ($event_post as $post) { ?>
    <table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">

        <tr>
            <td style="text-align:left;"><h4><?php echo $post->title; ?></h4></td>
            <td style="text-align:right;">
        <?php echo date('d-m-Y g:i', strtotime($post->createdAt)); ?>
            </td>
        </tr>
        <?php
        if (isset($post->thumbImage) && isset($post->postFile) && $post->postType == 'photo') {
            $image = $post->thumbImage;
            $imagePost = $post->postFile->url;
            ?><tr>
                <td colspan="2" style="text-align:center;">
                    <img align="middle" style="width:500px;" src="<?php echo $imagePost; ?>" alt="<?php echo $event->eventname; ?>" border="0" />
                </td>
            </tr>
    <?php } ?>
        <tr>
            <td style="text-align:left;">
    <?php echo $post->description; ?>
            </td>
        </tr>
    </table>
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
                <p><?php echo date('d-m-Y g:i', strtotime($data->createdAt)); ?>: <?php
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
<?php } ?>
