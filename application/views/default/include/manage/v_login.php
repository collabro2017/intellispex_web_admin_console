<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>IntelliSpeX</title>
    <meta name="description" content="User login page" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->
    <link href="<?php echo base_url('public') ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('public') ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
      <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->


    <!-- page specific plugin styles -->


    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/ace-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('public') ?>/css/main.css" />
    
    <!---------------------------------------------------------------------->
	<style>
		ul{
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}
		li{
			float: left;
			margin-left:35px;
		}
		li a{
			display: inline-block;
			color: white;
			text-align: center;
			padding: 20px 22px;
			text-decoration: none;
			font-size :16px;
		}
		li a:hover{
			background-color:#222;
			color: #ff0000;
		}
		li a:focus{
			color: #00aaff;
		}
	</style>
	<!---------------------------------------------------------------------->
    <!--[if lt IE 9]>
      <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
    <![endif]-->

  </head>

  <h1 class="col-sm-4"><img class="irc_mut iUyhD38Z_yik-HwpH6ZlgJaI" onload="google.aft&amp;&amp;google.aft(this)" src="<?php echo base_url('public') ?>/images/logo.JPG" width="60" height="60" style="margin-top: 0px;"> <span style="color : #00aaff;">IntelliSpeX</span></h1>
  <!-----------------//////////////////////////////------------------------>
	<ul>
		<li><a href="<?php echo base_url().'manage/home'; ?>">Home</a></li>
		<li><a href="<?php echo base_url().'manage/management_team'; ?>">Management Team</a></li>
		<li><a href="#contact">Contact Us</a></li>
		<li><a href="#news">News</a></li>
		<li><a href="#parners">Partners</a></li>
		<li><a href="#login">Login</a></li>
	</ul>
	
	<!-----------------//////////////////////////////------------------------>
  
  <body class="login-layout">

    <div class="container-fluid" id="main-container">
      <div id="main-content">
        <div class="row-fluid">
          <div class="span12">

            <div class="login-container">

              <div class="row-fluid">
                <div class="center">
                </div>
              </div>

              <div class="space-6"></div>

              <div class="row-fluid">

                <div class="position-relative">


                  <div id="login-box" class="visible widget-box no-border">

                    <div class="widget-body">
                      <div class="widget-main">

                        <div class="space-6"></div>

                        <form action='<?php echo base_url(); ?>manage/' method='post'>

                          <fieldset>
                            <div class="radio">
                              <label><input type="radio" checked="checked" value="1" name="role">Corporation Administrator:</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" value="2" name="role">Application Administrator:</label>
                            </div>
                            <label class="login_textbox">
                              <span class="block input-icon input-icon-right">
                                Login (email):
                                <input type="text" class="span12" name='username'/>
                              </span>
                            </label>
                            <label class="login_textbox">
                              <span class="block input-icon input-icon-right">
                                Password:
                                <input type="password" class="span12" name='password'/>
                              </span>
                            </label>
                            <label>
                              <span class="block input-icon input-icon-right">
                                  <?php echo validation_errors(); ?>
                              </span>
                            </label>
                            <div class="space"></div>
                            <div class="row-fluid">
                              <input type="submit" value="SUBMIT" name="submit" class="span4 btn btn-small btn-primary"></input>
                            </div>
                            <div><a href="<?php echo base_url(); ?>manage/reset_password"class=" btn btn-small btn-primary">RESET APPLICATION ADMINISTRATOR PASSWORD</a></div>

                          </fieldset>
                        </form>
                      </div><!--/widget-main-->
                    </div><!--/widget-body-->

                  </div><!--/login-box-->

                </div><!--/position-relative-->

              </div>


            </div>


          </div><!--/span-->
        </div><!--/row-->
      </div>
    </div><!--/.fluid-container-->


    <!-- basic scripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
      window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");
    </script>


    <!-- page specific plugin scripts -->


    <!-- inline scripts related to this page -->

    <script type="text/javascript">

      function show_box(id) {
          $('.widget-box.visible').removeClass('visible');
          $('#' + id).addClass('visible');
      }

    </script>

  </body>
</html>
