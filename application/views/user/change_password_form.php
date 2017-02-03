<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('default/head/console_page.php'); ?>
	<body class="login-layout admin-body">
	<?php $this->load->view('default/nav/console_page.php'); ?>
	<link rel="stylesheet" href="<?=base_url('/public/js/Parsley.js-2.6.2/src/parsley.css')?>"/>
	<div class="container-fluid" id="main-container">
		<div id="main-content">
			<div class="row-fluid">
				<div class="span12">
					<div class="widget-main">
						<div class="row-fluid">
							<div class="span10">
								<form class="form-horizontal" method="post" action="<?= base_url('user/add')?>">
									<fieldset style="text-align: left;">
										<div class="control-group">
											<!--<label for="name-contract" class="control-label">Old Password</label>
											<div class="controls">
												<input id="old-pass" name="old-pass" type="password"
													   data-parsley-required="true" 	/>
											</div>!-->
										</div>
										<div class="control-group">
											<label for="name-contract" class="control-label">New Password</label>
											<div class="controls">
												<input id="new-pass" name="new-pass" type="password"
													   data-parsley-required="true" 	data-parsley-length="[4, 20]"
													   data-parsley-equalto="#confirm-pass"/>
											</div>
										</div>
										<div class="control-group">
											<label for="name-contract" class="control-label">Password Confirmation</label>
											<div class="controls">
												<input id="confirm-pass" name="confirm-pass" type="password"
													   data-parsley-required="true" 	data-parsley-length="[4, 20]"
													   data-parsley-equalto="#new-pass"/>
											</div>
										</div>
										<input id="user" type="hidden" name="user" value="<?= $user?>"/>
										<input id="user" type="hidden" name="hash" value="<?= $hash?>"/>
									</fieldset>
								</form>
							</div>
							<div class="span2">
								<div class="clear">
									<a class="btn btn-small btn-primary menu-button menu-logout-button"
									   href="#" id="change-btn">
										Change Password
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('default/footer/console_page.php'); ?>
	</body>
</html>
<script src="<?=base_url('/public/js/Parsley.js-2.6.2/dist/parsley.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#change-btn').click(function(){
			var form=$('form').parsley();
			form.reset();
			form.validate();
			if(form.isValid()){
				$.ajax({
					url:"<?=base_url('user/ajax_change_password')?>",
					method : "POST" ,
					data :  $('form').serializeArray()  ,
					success : function ( data )
					{
						if ( data.status == 'success' )
						{

							alert('password changed');
							window.location.href = "<?=base_url()?>";
						} else
						{
							alert ( "could not change user password" );
						}
						console.log(data);
					}
				})
			}
		});
	})
</script>