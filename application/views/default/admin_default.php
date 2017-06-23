<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8" />
    <?php if (ENVIRONMENT=="production") : ?>
		<title>IntelliSpeX</title>
	<?php else : ?>
		<title>ICYMI</title>
	<?php endif; ?>
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

  <body class="login-layout admin-body">
  <?php $this->load->view('default/nav/console_page.php'); ?>
  <div class="container-fluid" id="main-container">
	<div id="main-content">
		<?php if ( isset($links) && ( array_key_exists( "logout", $links ) || array_key_exists( "Logout", $links ) ) ): ?>
			<?php if($function_name != "CLIENT MANAGEMENT CONSOLE"){ ?>
	  		<div class="widget-main">
	  			<a class=" btn btn-small btn-primary menu-button menu-logout-button" style="margin-top:10px" href="<?php echo base_url(); ?>manage/logout">Logout</a>
	  		</div>
		<?php } endif; ?>

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
					  	<?php
					  		if($function_name == "CLIENT MANAGEMENT CONSOLE"){ ?>
					  		<div class="row">
					  			<div class="span6">
						  			<div>
										<input class="" type="text" placeholder="Username"></a>
									</div>
						  		</div>
						  		<div class="span6">
						  			<div>
										<a class="btn btn-small btn-primary menu-button" href="#">Support</a>
									</div>
						  		</div>
					  		</div>
					  		<div class="row">
					  			<div class="span6">
						  			<div>
										<input class="" type="password" placeholder="Password"></a>
									</div>
						  		</div>
						  		<div class="span6">
						  			<div>
										<a class="btn btn-small btn-primary menu-button" href="#">Contact</a>
									</div>
						  		</div>
					  		</div>
					  		<div class="row">
					  			<div class="span6">
					  				<div>
										<a style="min-width:222px;" class=" btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/logout">Logout</a>
									</div>
					  			</div>
					  		</div>
					  		<div class="row">
					  		<div class="span3"></div>
						  		<div class="span6">
						  			<img alt="Client Management's Images" src="<?php echo base_url('public') ?>/images/earth.jpg" />
					  			</div>
					  		</div>
					  	<?php
					  		}
					  		else{
					  		if (isset($links)): ?>
							<?php foreach ($links as $key => $link): ?>
								<?php if  ($link != "Logout") : ?>
									<div>
										<a class=" btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/<?php echo $key; ?>"><?php echo $link; ?></a>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php endif;
							} ?>
						<?php if ( isset( $statistics ) ): ?>

							<div>
  								<div class="span9">

									<div class="section-title">
										<h2><?php echo $statistics; ?></h2>
									</div>
									<div class="table-wrapper">
										<table class="table table-striped statistics-table ">
											<tr>
												<td># of Administrators</td>
												<td><?=$nroadmin?></td>
											</tr>
											<tr>
												<td># of Users</td>
												<td><?=$nrousers?></td>
											</tr>
											<tr>
												<td># of Activities</td>
												<td><?=$nroevent?></td>
											</tr>
											<tr>
												<td># of Frames / Activity (average)</td>
												<td><?=$averageframe?></td>
											</tr>
											<tr>
												<td>Total Storage in Use</td>
												<td>100</td>
											</tr>
											<tr>
												<td>Average Storage / Activity</td>
												<td>100</td>
											</tr>
										</table>
									</div>
								</div>
								
								<div class="span3">
									<div class="span12">
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>manage/logout">Logout</a>
										<div class="clear"></div>
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="#">Print</a>
										<div class="clear"></div>
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="#sharePDF" role="button" data-toggle="modal">Share PDF Report</a>
										<div class="clear"></div>

									</div>
<<<<<<< HEAD
=======
								</div>
							</div>

							<!-- Modal Share-->
							<div id="sharePDF" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="sharePDFLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="sharePDFLabel">Share PDF Report</h3>
								</div>
								<div class="modal-body">
									<div class="dp-inblock text-left width-80">
										<label class="color-gray" for="s-email">Email:</label>
										<input id="s-email" type="email" class="width-100" placeholder="Email">
										<div id="container-error"></div>
										<div id="container-success"></div>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
									<button id="bnt-share" class="btn btn-primary bnt-share">Share</button>
									<button id="btn-download" type="button" class="btn btn-primary bnt-share">Download a PDF Report</button>
>>>>>>> master
								</div>
								
							</div>

						<?php endif; ?>
						<?php if (isset($create_client) || isset($edit_client)): ?>
						<div class="panel-admin">
							<div class="span9">
  								<label>
									<span class="block input-icon input-icon-right">
										<?php echo validation_errors(); ?>
									</span>
								</label>
						  		<?php echo $message; ?>
						 		 <?php if (isset($create_client)): ?>
									<form action='<?php echo base_url(); ?>manage/create_client/' method='post' style="margin-bottom:0">
									  <?php endif; ?>
									  <?php if (isset($edit_client)): ?>
									  <form action='<?php echo base_url(); ?>manage/edit/<?php echo $client_data[0]['id']; ?>' method='post' style="margin-bottom:0">
										<?php endif; ?>
									  <table class="table table-striped create-client-table">
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

										<input type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary menu-button"/>
									  </div>
									</form>
							</div>
							<div class="span3">
								<div class="span12">
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/logout">Logout</a>
									<div class="clear"></div>
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/scan">Scan Business Card</a>
									<div class="clear"></div>
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/upload">Upload Doc</a>
									<div class="clear"></div>
								</div>
							</div>
						</div>
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
								  <td>
								  	<select>
										<option value="0" disabled <?php if ( $value['status'] == '' ){ echo "selected"; } ?>></option>
										<option value="1" <?php if ( $value['status'] == 'Active' ){ echo "selected"; } ?>>Active</option>
										<option value="2" <?php if ( $value['status'] == 'Inactive' ){ echo "selected"; } ?>>Inactive</option>
										<option value="3" <?php if ( $value['status'] == 'Closed' ){ echo "selected"; } ?>>Closed</option>
								  	</select>
								  </td>
								  <td><?php echo $value['phone'] ?></td>
								  <td><?php echo $value['email'] ?></td>
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/edit/<?php echo $value['id']; ?>">Edit</a></td>
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/reset_pw_email/<?php echo $value['id']; ?>">Reset Pw</a></td>
								</tr>
							  <?php endforeach; ?>
							</table>
						  <?php endif; ?>
							  <?php if (isset($reset_pw_email)): ?>
							  	<div class="reset-form">
								  	<?php if ( isset( $message ) && $message != '' ): ?>
									<div class="alert alert-success" role="alert">
							  			<?php echo $message; ?>
									</div>
									<?php endif; ?>

									<form action='<?php echo base_url(); ?>manage/reset_pw_send_mail/<?php echo $reset_pw_email; ?>' method='post'>

									  <fieldset>
										<h2>Enter the Administrator Email Address:</h2>
										<span class="block input-icon input-icon-right " >
										  <input type="text" class="span12"  name='username'/>
										</span>
										<?php if ( validation_errors() != "" ) : ?>
										<div class="alert alert-danger" role="alert">
											<?php echo validation_errors(); ?>
										</div>
										<?php endif; ?>
										<br/>
										<div class="row-fluid">
										  <input type="submit" name="reset" value="Reset the Application Administrator Password" class="btn btn-small btn-primary menu-button"></input>
										</div>

									  </fieldset>
									</form>
								</div>
							  <?php endif; ?>

						  <?php if (isset($reset_password_client_form)) : ?>
							<?php if ($key) : ?>

							  <form action='<?php echo base_url(); ?>manage/reset_password_client_form/<?php echo $pram; ?>' method='post' class="reset-form">
								<h2>Enter Your Password:</h2>
								<span class="block input-icon input-icon-right">
								  <input type="password" class="span12"  name='password'/>
								</span>
								<h2>Confirm Your Password:</h2>
								<span class="block input-icon input-icon-right">
								  <input type="password" class="span12"  name='cpassword'/>
								</span>
								<br/>
								<?php if ($message_pw) : ?>
								<div class="alert alert-danger" role="alert">
									Password doesn’t meet criteria... Re-enter your password.
								</div>
							  	<?php endif; ?>
							  	<div class="alert alert-info" role="alert">
								  (A combination of at least one upper case letters and lower case letters, numbers, special characters (optional); 8 - 12 characters)
								</div>
								<div class="row-fluid">
								  <input type="submit" name="submit" value="Reset the Application Administrator Password" class="btn btn-small btn-primary menu-button"></input>

								</div>
							  </form>
							<?php else : ?>
							  The key is not valid
							<?php endif ?>
						  <?php endif ?>
						  <?php if ( isset($back) && !( isset($create_client) ) ): ?>
						  	<?php if ( isset( $statistics ) ): ?>
						  		<div class="clear">
						  		<a href="<?php echo base_url(); ?>manage/review_users" class="btn btn-small btn-primary menu-button">Review Users</a>
							 <?php endif; ?>
							 <div class="clear">
							<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a></div>
						  <?php endif; ?>

						  <?php if ( isset( $create_client ) ): ?>
							<div>

								<div class="span9">
									<?php if (isset($back)): ?>
									  	<div class="clear"><a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a></div>
									<?php endif; ?>
								</div>
								<div class="span3">
									<div class="span12">
										<a class=" btn btn-small btn-primary menu-button menu-logout-button menu-button-small" href="<?php echo base_url(); ?>/manage/sqlserver">SQL Server</a>
									</div>
								</div>
							<div>
						  <?php endif?>

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

<form id="formdownload" method="post" target="_blank" action="<?= base_url('pdfs/download')?>">
	<input id="table-content" name="html" type="hidden">
</form>
  <!-- basic scripts -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");
  </script>
  <script src="<?php echo base_url('public') ?>/assets/js/bootstrap.min.js"></script>

  <!-- page specific plugin scripts -->


  <!-- inline scripts related to this page -->

  <script type="text/javascript">
		function getTable()
		{
			return 	"<style type=text/css>"+
				"td{"+
				"color:#000000;"+
				"border-left: 2px solid #cccccc;"+
				"border-right: 2px solid #cccccc;"+
				"border-top: 2px solid #cccccc;"+
				"border-bottom: 2px solid #cccccc;}"+
				"table {"+
				"font-family: helvetica;"+
				"font-size: 11pt;"+
				"border-left: 2px solid #cccccc;"+
				"}"+
				"</style>"+
				"<h1>Usage Statistics</h1>"+
				"<table border='1' cellpadding='3'>"+
				$('.table-wrapper').html()+
				"</table>";
		}
		function show_box(id) {
			$('.widget-box.visible').removeClass('visible');
			$('#' + id).addClass('visible');
		}
		$('#btn-download').click(function(){
			var html=getTable();
			$('#table-content').val(html);
			$('#formdownload').trigger( "submit" );
		});
		$( "#bnt-share" ).click(
		function()
		{
			if ( validate() )
			{
				var html=getTable();
				var btnShare = $( "#bnt-share" );
				btnShare.attr( 'disabled' , true );
				$.ajax({
					url: "<?php echo base_url("/pdfs/init"); ?>",
					method: "POST",
					data: {'html': html}
				}).done(function( response ) {
					if ( response.status == true )
					{
						$.ajax({
							url: "<?php echo base_url("/send_mail/sendMail"); ?>",
							method: "POST",
							data: 	{
										'email': $( '#s-email' ).val(),
										'from': 'ICYMI',
										'fromDescription': 'Usage Statistics',
										'cc': 'Icymi',
										'bcc': 'bcc descripcion',
										'subject': 'Report Usage Statistics',
										'message': 'Usage Statistics',
										'attach': '<?php echo FCPATH.'report/'. utf8_decode("report_usagestatistics.pdf") ?>'
									}
						}).done(function( responseEmail ) {
							if ( responseEmail.status )
							{
								var containerSuccess = $( '#container-success' );
								containerSuccess.text( 'Report Sent!' );
								containerSuccess.css( "color", "#4CAF50" );
								containerSuccess.delay( 3000 ).queue( function( next ) {
									$('#sharePDF').modal('hide');
									next();
									containerSuccess.text('');
									$( '#s-email' ).val('');
								});
							}
							else
							{
								alert('Report can not be sent');
							}
							btnShare.attr( 'disabled' , false );
						});
					}
					else
					{
						alert('Report can not be sent');
						btnShare.attr( 'disabled' , false );
					}
				});
			}
		} );

		function validateEmail( email )
		{
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}

		function validate()
		{
			var containerError = $("#container-error");
			containerError.text("");
			var email = $("#s-email").val();
			if ( !validateEmail(email) )
			{
				containerError.text( email + " is not valid" );
				containerError.css( "color", "red" );
				containerError.delay( 5000 ).fadeOut();
				containerError.css( 'display' , 'block' );
				return false;
			}
			else
			{
				return true;
			}
		}

		$("#validate").bind("click", validate);
	</script>
</body>
</html>
