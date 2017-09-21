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
                        <input id="search" required="" type="text" value="" placeholder="Search Content" />
                        <button style="margin-top: 6px;" id="runSearch" class="btn btn-small btn-primary btn-info">Run Search</button>
                    </div>
                    <div class="search-results" style="display:none;">
                        <img src="<?php echo base_url(); ?>public/loading.gif" />
                    </div>
                    <div style="clear: both;height: 20px"></div>
                </div>
            </div>
        </div>
        <?php $this->load->view('default/footer/console_page.php'); ?>
        <script type="text/javascript">
            $( "#runSearch" ).click(function(){
                if($('#search').val()){
                    $('.search-results').css('display','block');
                    $.post( "<?php echo base_url(); ?>events/admin_content_search",{ keyword: $('#search').val()}, function( data ) {
                         $('.search-results').html(data);
                    });
                }else{
                    $('#search').focus();
                    $('#search').css('color','#e9322d');
                    $('#search').css('border-color','#e9322d');
                    $('#search').css('-webkit-box-shadow','0 0 6px #f8b9b7');
                    $('#search').css('-moz-box-shadow','0 0 6px #f8b9b7');
                    $('#search').css('box-shadow','0 0 6px #f8b9b7');
                }
            });
            $('#search').on('input',function(e){
                if($(this).val()){
                    $('#search').css('border-color','#d5d5d5');
                    $('#search').css('color','#AAA');
                    $('#search').css('border-color','');
                    $('#search').css('-webkit-box-shadow','');
                    $('#search').css('-moz-box-shadow','');
                    $('#search').css('box-shadow','');
                }else{
                    $('#search').focus();
                    $('#search').css('color','#e9322d');
                    $('#search').css('border-color','#e9322d');
                    $('#search').css('-webkit-box-shadow','0 0 6px #f8b9b7');
                    $('#search').css('-moz-box-shadow','0 0 6px #f8b9b7');
                    $('#search').css('box-shadow','0 0 6px #f8b9b7');
                }
            });
        </script>