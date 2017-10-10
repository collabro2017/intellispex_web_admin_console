<table>
                <tr><td>Creator</td><td><?php echo $event[0]['username'] ?></td></tr>
                <tr><td>Data Created</td><td><?php echo date('Y-m-d',strtotime($event[0]['createdAt'])); ?></td></tr>
                <tr><td>Time Created</td><td><?php echo date('g:i A',strtotime($event[0]['createdAt'])); ?></td></tr>
                <tr><td>Number of Participants</td><td><?php if(isset($event[0]['commenters'])) { echo count($event[0]['commenters']); }else{ echo 0; } ?></td></tr>
                <tr><td>Tagged Users</td><td><?php echo count(implode(",",$event[0]['TagFriends'])) ?></td></tr>
                <tr><td>Location</td><td><?php  ?></td></tr>
            </table>
            
            <table>
                <tr><td>Number of Activity Sheets</td><td><?php echo count($eventActivity); ?></td></tr>
                <tr><td>Title of Activity Sheet</td><td><?php echo $event[0]['eventname'] ?></td></tr>
                <tr><td>Description</td><td>none<?php //echo $event[0]['description'] ?></td></tr>
            </table>
            
            <table>
                <?php for($i = 0; $i < count($eventActivity); $i++){ ?>
                <tr><td colspan="2">Activity Sheet <?php echo $i+1; ?></td></tr>
                    <tr><td>Date</td><td><?php echo date('Y-m-d',strtotime($eventActivity[$i]['createdAt'])); ?></td></tr>
                    <tr><td>Time</td><td><?php echo date('g:i A',strtotime($eventActivity[$i]['createdAt'])); ?></td></tr>
                    <tr><td>Title</td><td><?php echo $eventActivity[$i]['title']; ?></td></tr>
                    <tr><td>Location</td><td><?php echo $eventActivity[$i]['countryLatLong']; ?></td></tr>
                    <tr><td>Description</td><td><?php echo $eventActivity[$i]['description']; ?></td></tr>
                    
                <?php } ?>
            </table>