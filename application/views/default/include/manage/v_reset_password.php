<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>IntelliSpeX</title>
  <meta name="description" content="Support page" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/font-awesome.min.css" /> -->
  <script src="https://use.fontawesome.com/3d7f954615.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('public') ?>/css/general.css" />
  <link rel="stylesheet" href="<?php echo base_url('public') ?>/css/login.css" />
  <body class="login-layout">
    <div class="container">
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url().'manage/home'; ?>"><img class="img-responsive" src="<?php echo base_url('public') ?>/images/logo.png" alt="logo"><span>IntelliSpex</span></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
          <ul class="nav navbar-nav ">
            <li><a href="<?php echo base_url().'manage/home'; ?>">Home</a></li>
            <li><a href="<?php echo base_url().'manage/management_team'; ?>">Management Team</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="<?php echo base_url().'manage/management_support'; ?>">Support</a></li>
            <li><a href="#partners">Partners</a></li>
            <li><a class="btn btn-md btn-success login-button" href="<?php echo base_url().'manage/console_menu'; ?>">Login</a></li>
          </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
    </div>
    <div class="container mgt-12x mgb-4em">
      <div  id="login-modal" >
        <div class="modal-dialog">
          <div class="loginmodal-container">
            <h1>Reset Client Password</h1><br>
            <form action='<?php echo base_url(); ?>manage/reset_password' method='post'>
              <?php if ( validation_errors() != "" ) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif; ?>
                <?php if (isset($message) && $message != ''): ?>
                <div class="alert alert-warning" role="alert">
                  <?php echo $message; ?>
                </div>
              <? endif;?>
              <fieldset>
                Enter the Administrator Email Address:
                <span class="block input-icon input-icon-right">
                  <input type="text" class="span12"  name='username'/>
                  <i class="icon-user"></i>
                </span>
                <div class="row-fluid">
                  <input type="submit" name="reset" value="Reset Password" class="login loginmodal-submit"></input>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer id="footer-v6" class="footer-v6">
      <div class="copyright">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p class="color-white center">Copyright © 2016 IntelliSpeX - <span data-localize="copyright.all_rights">All Rights Reserved</span></p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </body>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>