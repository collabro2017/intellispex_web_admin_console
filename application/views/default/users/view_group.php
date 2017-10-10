<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");
</script>
<div class="row-fluid">
    
        <div class="span6">
            <h3>Groups</h3>
            <ul class="list-group">
                <?php foreach ($user_group as $group){ ?> 
                <li class="list-group-item" onclick="" id="<?php echo $group['objectId']?>">
                    <?php echo $group['group_name']; ?> 
                </li>
                <script>
                    $('#<?php echo $group['objectId']?>').click(function(){
                        $('.user_group').css('display','none');
                        $(this).attr('class','list-group-item');
                        $('#user_<?php echo $group['objectId']?>').css('display','block');
                        $(this).attr('class','list-group-item selected');
                    });
                </script>
                <?php } ?>
            </ul>
        </div>
        <?php $i = 0; foreach ($user_group as $group){ ?> 
            <div style="<?php if($i > 0){ echo 'display:none;'; }?>" class="span6 user_group" id="user_<?php echo $group['objectId']?>">
                
                <h3>Users for <b><?php echo $group['group_name']?></b></h3>
                <ul class="list-group">
                    
                    <?php 
                    $users = $group['users'];
                    foreach ($users as $user){
                        $user_details = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"objectId":"' . $user . '"}',
                        )
                        );
                        $user_details = json_decode(json_encode($user_details), true); 
                       ?>
                        <li class="list-group-item">
                            <?php 
                            if (isset($user_details[0]['Firstname'])): echo $user_details[0]['Firstname'];
                            endif;
                            echo " ";
                            if (isset($user_details[0]['LastName'])): echo $user_details[0]['LastName'];
                            endif;
                            ?>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        <?php $i++; } ?>
    
</div>
