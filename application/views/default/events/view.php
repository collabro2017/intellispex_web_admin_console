<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('default/head/console_page.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/css/events.css" />
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
                                    <form class="form-horizontal" action='<?php echo base_url(); ?>events/update_event/<?php echo $event->objectId; ?>' method='post' style="margin-bottom:0">
                                        <ul style="list-style: none">
                                            <li style="float:left;margin-left: 10px;">
                                                <button type="submit" class="btn btn-small btn-primary">Update Event</button>	
                                            </li>
                                            <li style="float:left;margin-left: 10px;">
                                                <a class="btn btn-small btn-primary"  href="javascript:deletevent();" class="btn btn-small btn-primary menu-button">Delete User</a> 	
                                            </li>
                                        </ul>
                                        <div style="clear:both"></div>
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
                                                <textarea style="width: 100%; height: 200px;" name="description" cols="10" rows="10">
                                                    <?php echo $event->description; ?>
                                                </textarea>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="span12">
                                            <?php if(count($event_comment)){ ?>
                                                <h2>Event Comments</h2>
                                                <?php 
                                                foreach ($event_comment as $data){
                                                    $commenter = $data->Commenter;
                                                    $user_details = $this->parserestclient->query(array(
                                                        "objectId" => "_User",
                                                        'query' => '{"deletedAt":null,"objectId":"' . $commenter->objectId . '"}',
                                                        )
                                                    );
                                                    $user_details = json_decode(json_encode($user_details), true); 
                                                    ?>
                                                <h3> <?php 
                                                        if (isset($user_details[0]['username'])): echo $user_details[0]['username'];
                                                        endif;
                                                        ?>
                                                </h3>
                                                <p>Created: <?php echo date('Y-m-d', strtotime($event->createdAt)); ?></p>
                                                <p>
                                                    <?php echo $data->Comments; ?>
                                                </p>
                                                <?php 
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div style="clear:both;height:10px"></div>
                                        
                                    </form>
                                    <h2>Add New Comments</h2>
                                    <form class="form-horizontal" action='<?php echo base_url(); ?>events/add_event_comment/<?php echo $event->objectId; ?>' method='post' style="margin-bottom:0">
                                         <div class="form-group">
                                            <div class="col-sm-10">
                                                <label for="access_rights" style="text-align: left" class="col-sm-2 control-label">Description</label>
                                            </div>
                                            <div style="clear: both" class="col-sm-10">
                                                <textarea style="width: 100%; height: 200px;" name="Comments" cols="10" rows="10">
                                                    
                                                </textarea>
                                                <input type="hidden" name="Commenter" value="<?php echo $current_user; ?>" />
                                                <input type="hidden" name="targetEvent" value="<?php echo $event->objectId; ?>" />
                                            </div>
                                             <div style="clear:both; height: 10px;"></div>
                                            <button type="submit" class="btn btn-small btn-primary">Add Comment</button>
                                        </div>
                                    </form>
                                    
                                    <div class="span12">
                                        <?php
                                        $image = $event->postImage;
                                        ?>
                                        <img width="100%" src="<?php echo $image->url; ?>" />
                                    </div>
                                    <div style="clear:both;height:10px"></div>
                                    <div class="span12">
                                        <div class="span4" style="text-align:center;margin-left: 300px"> 
                                            <a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
                                                Console Menu
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                echo '<pre>';
                                print_r($event);
                                ?>
                                <div class="span2">
                                    <h3>Tag Users/User Group</h3>
                                    <ul  class="list-group">
                                        <?php if (count($associated_user) > 0) { ?>
                                            <li class="list-group-item">
                                                Users
                                                <ul class="children">
                                                    <?php foreach ($associated_user as $user) {
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>events/tag_user/<?php echo $user['objectId'];?>/<?php echo $event->objectId; ?>">
                                                            <?php
                                                            if (isset($user['Firstname'])): echo $user['Firstname'];
                                                            endif;
                                                            echo " ";
                                                            if (isset($user['LastName'])): echo $user['LastName'];
                                                            endif;
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>events/tag_user_group/<?php echo $user['objectId'];?>">
                                                        </li>
                                                        <?php
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
                                                            <a href="<?php echo base_url(); ?>events/tag_user_group/<?php echo $group['objectId'];?>/<?php echo $event->objectId; ?>">
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
        <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
        <script type="text/javascript">
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
                                                $(document).ready
                                                        (
                                                                function ()
                                                                {
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
