<div class="row-fluid">
    <?php
    if (count($user_group) > 0) {
        ?>
    <div id="groupEdit">
        <div class='span5'>
            <select id="res_group" name="res_group" style="width:100%">
                <?php foreach ($user_group as $group) { ?>
                    <option value="<?php echo $group['objectId'] ?>"><?php echo $group['group_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="span2">
            or
        </div>
        <div class="span5">
            <a id="show_create_group" class="btn btn-small btn-primary" href="#">Create New Group</a>
        </div>
    </div>
        <?php
    } else {
        ?>
        <div style="width: 34%;margin:auto;">
            <a id="show_create_group" class="btn btn-small btn-primary" href="#">Create New Group</a>
        </div>
        <?php
    }
    ?>
    <div class="span12 create_group" style="display: none;">
        
            <div class="form-group">
                <div class="col-sm-10">
                    <label for="group_name" style="text-align: left" class="col-sm-2 control-label">Group Name</label>
                </div>
                <div style="clear: both" class="col-sm-10">
                    <input required="" id="group_name" name="group_name" class="form-control" id="focusedInput" type="text" placeholder="Group Name">
                </div>
            </div>
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
            <div style="clear:both;height:20px;"></div>
            <div class="span12" style="margin: 0;">
                <div class="span5" style="margin: 0;">
                    <label for="search" style="text-align: left" class="col-sm-2 control-label">All Users</label>
                    <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                        <?php foreach ($associated_user as $value){ ?>
                        <option value="<?php echo $value['objectId']?>">
                            <?php
                                if (isset($value['Firstname'])): echo $value['Firstname'];
                                endif;
                                echo " ";
                                if (isset($value['LastName'])): echo $value['LastName'];
                                endif;
                            ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="span2" style="margin-top: 36px;">
                    <button type="button" id="search_rightSelected" style="font-size: 40px;" class="btn btn-small btn-grey"><i class="fa fa-arrow-circle-o-right"></i></button>
                    <button type="button" id="search_leftSelected" style="font-size: 40px;margin-top: 20px;" class="btn btn-small btn-grey"><i class="fa fa-arrow-circle-o-left"></i></button>
                </div>

                <div class="span5" style="margin: 0px;">
                    <label for="search_to" style="text-align: left" class="col-sm-2 control-label">Selected Group Users</label>
                    <select required="" name="users[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
                </div>
            </div>
        
    </div>
</div>