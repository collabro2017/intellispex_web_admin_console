<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");
</script>

<table class="table table-striped events-table" id="table_data">
    <thead>
        <tr>
            <th>Title</th>
            <th>Date Created</th>
            <th>Created By</th>
            <th>Preview Content</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($event as $val) {
            ?>
            <tr>	
                <td><?php echo $val['eventname'] ?></td>
                <td><?php echo $val['createdAt'] ?></td>
                <td><?php echo $val['username'] ?></td>
                <td>
                    <a target="_blank" href="<?php echo base_url(); ?>events/event/<?php echo $val['objectId']; ?>">
                        <?php echo $val['content_type'] ?>
                    </a>
                </td>
                <td>
                    <?php echo $val['description'] ?>
                </td>
                <td>
                    <select id="action<?php echo $val['objectId']; ?>" style="margin-bottom:0px;">
                        <option value="">Select</option>
                        <option value="delete_user">Delete User</option>
                        <option value="send_user_warning">Send User a Warning Message</option>
                        <option value="dismiss">Dismiss</option>
                        <option value="suspend_user">Suspend User</option>
                        <option value="<?php if($val['content_type'] == 'Event'){ echo 'delete_event'; }else{ echo 'delete_post'; } ?>">Delete <?php if($val['content_type'] == 'Event'){ echo 'Event'; }else{ echo 'Post'; }?></option>
                    </select>
                    <script type="text/javascript">
                        $('#action<?php echo $val['objectId']?>').change(function() {
                            if($( this ).val() == 'delete_event'){
                                if (window.confirm("Are you sure want to delete selected event?")) {
                                    var deletelist = [];
                                    deletelist.push('<?php echo $val['objectId']; ?>');
                                    $.post("<?php echo base_url(); ?>events/eventdelete", {deletelist: deletelist}, function (data) {
                                        //console.log(data);
                                        window.location.href = "<?php echo base_url(); ?>manage/<?php echo $page; ?>";
                                    });
                                }
                            }else if($( this ).val() == 'delete_post'){
                                if (window.confirm("Are you sure want to delete selected post?")) {
                                    $.post("<?php echo base_url(); ?>events/postdelete", {postId: "<?php echo $val['post_id']; ?>"}, function (data) {
                                        //console.log(data);
                                        window.location.href = "<?php echo base_url(); ?>manage/<?php echo $page; ?>";
                                    });
                                }
                            }else if($( this ).val() == 'delete_user'){
                                if (window.confirm("Are you sure want to delete user?")) {
                                    $.post("<?php echo base_url(); ?>events/userdelete", {user_id: "<?php echo $val['user_id']; ?>"}, function (data) {
                                        //console.log(data);
                                        window.location.href = "<?php echo base_url(); ?>manage/<?php echo $page; ?>";
                                    });
                                }
                            }else if($( this ).val() == 'suspend_user'){
                                if (window.confirm("Are you sure want to suspend user?")) {
                                    $.post("<?php echo base_url(); ?>events/suspendUser", {user_id: "<?php echo $val['user_id']; ?>"}, function (data) {
                                        //console.log(data);
                                        window.location.href = "<?php echo base_url(); ?>manage/<?php echo $page; ?>";
                                    });
                                }
                            }else if($( this ).val() == 'send_user_warning'){
                                $.post("<?php echo base_url(); ?>events/send_user_warning", {user_id: "<?php echo $val['user_id']; ?>"}, function (data) {
                                    window.location.href = "<?php echo base_url(); ?>manage/<?php echo $page; ?>";
                                });
                            }else if($( this ).val() == 'dismiss'){
                                if (window.confirm("Are you sure want to dismiss flag request?")) {
                                    $.post("<?php echo base_url(); ?>events/dismiss", {reportId: "<?php echo $val['reported_id']; ?>"}, function (data) {
                                        window.location.href = "<?php echo base_url(); ?>manage/<?php echo $page; ?>";
                                    });
                                }
                            }
                        });
                    </script>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<script src="<?php echo base_url('public') ?>/js/datatable.js"></script>

<script type="text/javascript">
    $('#table_data').DataTable();
</script>