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
	<!--[if lt IE 9]>
	  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
	<![endif]-->

  </head>

  <body class="login-layout">
	<div class="widget-main">
		<div class="top-menu">
			<h2 class="col-sm-3"><img class="irc_mut iUyhD38Z_yik-HwpH6ZlgJaI" onload="google.aft&amp;&amp;google.aft(this)" src="<?php echo base_url('public') ?>/images/logo.JPG" width="60" height="60" style="margin-top: 0px;"> <span style="color : #00aaff;">IntelliSpeX</span></h2>
			<h2 class="col-sm-6"><span><?php echo $function_name; ?></span></h2>
			<h2 class="col-sm-3"></i> <span><?php echo $username; ?></span></h2>
		</div>
	</div>
  <div class="container-fluid" id="main-container">
	<div id="main-content">
		<?php  if ( isset($links) && array_key_exists( "logout", $links) ): ?>
	  		<div class="widget-main">
	  			<a class=" btn btn-small btn-primary menu-button menu-logout-button" style="margin-top:10px" href="<?php echo base_url(); ?>manage/logout">Logout</a>
	  		</div>
		<?php endif; ?>

	 	 <div class="row-fluid">


		<div class="span12">

		  <div class="">

			<div class="row-fluid">
			  <div class="center">

			  </div>
			</div>

			<div class="space-6"></div>

			<div class="row-fluid">

			  <div class="position-relative">


				<div id="login-box" class="visible no-border">

				  <div>
					<div class="widget-main">

					  <div class="space-6"></div>



					  <div class="panel-admin">
						<?php if (isset($links)): ?>
							<?php foreach ($links as $key => $link): ?>
								<?php if  ($link != "Logout") : ?>
									<div>
										<a class=" btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/<?php echo $key; ?>"><?php echo $link; ?></a>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if ( isset( $statistics ) ): ?>

							<div>
  								<div class="span9">

									<div class="section-title">
										<h2><?php echo $statistics; ?></h2>
									</div>

									<table class="table table-striped statistics-table">
										<tr>
											<td># of App Administrators</td>
											<td>100</td>
										</tr>
										<tr>
											<td># of Clients</td>
											<td>100</td>
										</tr>
										<tr>
											<td># of Client Administrators (average)</td>
											<td>100</td>
										</tr>
										<tr>
											<td># of Users</td>
											<td>100</td>
										</tr>
										<tr>
											<td># of Activities</td>
											<td>100</td>
										</tr>
										<tr>
											<td># of Frames / Activity (averge)</td>
											<td>100</td>
										</tr>
										<tr>
											<td>Total Storage in Use</td>
											<td>100</td>
										</tr>
										<tr>
											<td>Average Storage / Activity</td>
											<td>100</td>
										</tr>
										<tr>
											<td>Average Simultaneous Data Calls / Seconds</td>
											<td>100</td>
										</tr>
									</table>
									<div class="section-title">
										<h2>Client Statistics</h2>
									</div>

									<table class="table table-striped statistics-byuser-table">
										<thead>
											<tr>
												<th style="width: 300px">Client Name</th>
												<th># of users</th>
												<th># of Activities</th>
												<th># of Frames</th>
												<th># of Audio Frames</th>
												<th># of Video Frames</th>
												<th># of Text Frames</th>
												<th>Maximum Simultaneous Data Calls</th>
												<th>Average Simultaneous Data Calls</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Name</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
											</tr>
											<tr>
												<td>Name</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
												<td>100</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="span3">
									<div class="span12">
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>manage/logout">Logout</a>
										<div class="clear"></div>
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="#">Print</a>
										<div class="clear"></div>
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="#">Share PDF<br>Report</a>
									</div>




								</div>
							</div>
						<?php endif; ?>
						<?php if (isset($create_client) || isset($edit_client)): ?>
						  <label>
							<span class="block input-icon input-icon-right">
								<?php echo validation_errors(); ?>
							</span>
						  </label>
						  <?php echo $message; ?>
						  <?php if (isset($create_client)): ?>
							<form action='<?php echo base_url(); ?>manage/create_client/' method='post'>
							  <?php endif; ?>
							  <?php if (isset($edit_client)): ?>
							  <form action='<?php echo base_url(); ?>manage/edit/<?php echo $client_data[0]['id']; ?>' method='post'>
								<?php endif; ?>
							  <table>
								<tr>
								  <th>Client Name</th>
								  <th><input type="text" class="span12" name='name' <?php if (isset($client_data[0]['name'])): ?> value="<?php echo $client_data[0]['name']; ?>" <?php endif; ?>/></th>
								</tr>
								<tr>
								  <td>Address Line 1</td>
								  <td><input type="text" class="span12" name='address1'<?php if (isset($client_data[0]['address1'])): ?> value="<?php echo $client_data[0]['address1']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Address Line 2</td>
								  <td><input type="text" class="span12" name='address2'<?php if (isset($client_data[0]['address2'])): ?> value="<?php echo $client_data[0]['address2']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>City</td>
								  <td><input type="text" class="span12" name='city'<?php if (isset($client_data[0]['city'])): ?> value="<?php echo $client_data[0]['city']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Province / State</td>
								  <td><input type="text" class="span12" name='province'<?php if (isset($client_data[0]['province'])): ?> value="<?php echo $client_data[0]['province']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Postal Code</td>
								  <td><input type="text" class="span12" name='postal'<?php if (isset($client_data[0]['postal'])): ?> value="<?php echo $client_data[0]['postal']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Phone</td>
								  <td><input type="text" class="span12" name='phone'<?php if (isset($client_data[0]['phone'])): ?> value="<?php echo $client_data[0]['phone']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Mobile Phone</td>
								  <td><input type="text" class="span12" name='mobile'<?php if (isset($client_data[0]['mobile'])): ?> value="<?php echo $client_data[0]['mobile']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Email</td>
								  <td><input type="text" class="span12" name='email'<?php if (isset($client_data[0]['email'])): ?> value="<?php echo $client_data[0]['email']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Date Created</td>
								  <td><input type="date" class="span12" name='created'<?php if (isset($client_data[0]['created'])): ?> value="<?php echo $client_data[0]['created']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Date Modified</td>
								  <td><input type="date" class="span12" name='updated'<?php if (isset($client_data[0]['updated'])): ?> value="<?php echo $client_data[0]['updated']; ?>" <?php endif; ?>/></td>
								</tr>
								<tr>
								  <td>Administrator Email</td>
								  <td><input type="text" class="span12" name='admin_email'<?php if (isset($client_data[0]['admin_email'])): ?> value="<?php echo $client_data[0]['admin_email']; ?>" <?php endif; ?>/></td>
								</tr>
							  </table>
							  <div class="row-fluid">
								<input type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary"></input>
							  </div>
							</form>

						  <?php endif; ?>
						  <?php if (isset($client_setup)): ?>
							<table>
							  <tr>
								<th>Client</th>
								<th>Date Established</th>
								<th>Status</th>
								<th>Phone #</th>
								<th>Email</th>
								<th></th>
								<th></th>
							  </tr>
							  <?php foreach ($client as $value): ?>
								<tr>
								  <td><?php echo $value['name'] ?></td>
								  <td><?php echo $value['created'] ?></td>
								  <td><?php echo $value['status'] ?></td>
								  <td><?php echo $value['phone'] ?></td>
								  <td><?php echo $value['email'] ?></td>
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/edit/<?php echo $value['id']; ?>">Edit</a></td>
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/reset_pw/<?php echo $value['id']; ?>">Reset Pw</a></td>
								</tr>
							  <?php endforeach; ?>
							</table>
						  <?php endif; ?>
						  <?php if (isset($message) && $message != ''): echo $message; ?>
						  <?php endif; ?>
						  <?php if (isset($reset_pw_email)): ?>
							<form action='<?php echo base_url(); ?>manage/reset_pw_send_mail/<?php echo $reset_pw_email; ?>' method='post'>

							  <fieldset>
								Enter the Administrator Email Address:
								<span class="block input-icon input-icon-right">
								  <input type="text" class="span12"  name='username'/>
								  <i class="icon-user"></i>
								</span>
								<label>
								  <span class="block input-icon input-icon-right">
									  <?php echo validation_errors(); ?>
								  </span>
								</label>
								<div class="row-fluid">
								  <input type="submit" name="reset" value="Reset the Application Administrator Password" class=" btn btn-small btn-primary"></input>
								</div>

							  </fieldset>
							</form>
						  <?php endif; ?>
						  <?php if (isset($reset_password_client_form)) : ?>
							<?php if ($key) : ?>
							  <?php if ($message_pw) : ?>
								<span class="red">Password doesn’t meet criteria</span>
							  <?php endif; ?>
							  <form action='<?php echo base_url(); ?>manage/reset_password_client_form/<?php echo $pram; ?>' method='post'>
								<div>Enter Your Password:</div>
								<span class="block input-icon input-icon-right">
								  <input type="password" class="span12"  name='password'/>
								  <i class="icon-user"></i>
								</span>
								Confirm Your Password:
								<span class="block input-icon input-icon-right">
								  <input type="password" class="span12"  name='cpassword'/>
								  <i class="icon-user"></i>
								</span>
								<label>
								  A combination of at least one upper case letters, lower case letters, numbers, special characters; 8 - 12 characters
								</label>
								<div class="row-fluid">
								  <input type="submit" name="submit" value="Reset the Application Administrator Password" class=" btn btn-small btn-primary"></input>

								</div>
							  </form>
							<?php else : ?>
							  The key is not valid
							<?php endif ?>
						  <?php endif ?>
						  <?php if (isset($back)): ?>
						  	<div class="span12"><a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a></div>
						  <?php endif; ?>

					  </div>
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
