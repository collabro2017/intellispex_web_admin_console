<!DOCTYPE html>
<html lang="en">
    <head>		
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />	

        <style>
            #DataTables_Table_0_wrapper{
                margin:auto;
            }
            #main-container{
                margin-top:10%;
            }
        </style>
    </head>
    <?php $this->load->view('default/head/console_page.php'); ?>
    <body class="login-layout admin-body">
        <?php $this->load->view('default/nav/console_page.php'); ?>

        <div class="container" id="main-container">
            <div id="main-content">
                <div class="row">
                    <div class="span9">
                        <!--<input id="search" required="" type="text" value="" placeholder="Search Content" />-->
                        <button style="margin-top: 6px;" id="runSearch" class="btn btn-small btn-primary btn-info">Run Search</button>
                    </div>
                    <div class="search-results" style="display:none;">
                        <img src="<?php echo base_url(); ?>public/loading.gif" />
                    </div>
                    <div style="clear: both;height: 20px"></div>
                </div>
                <div class="row">
                    <div class="span9">
                        <div class="clear" style="text-align:center;">
                            <a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php $this->load->view('default/footer/console_page.php'); ?>
        <script type="text/javascript">
            $("#runSearch").click(function () {
                $('.search-results').css('display', 'block');
                $.post("<?php echo base_url(); ?>events/admin_content_search", {keyword: ''}, function (data) {
                    $('.search-results').html(data);
                });
            });
        </script>