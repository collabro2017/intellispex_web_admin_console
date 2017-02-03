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
						<div class="span10" >
							<br/>
							<?php if (!isset($user)): ?>
							<form class="form-horizontal" method="post" action="<?= base_url('user/add')?>">
								<?php endif; ?>
								<?php if (isset($user)): ?>
								<form class="form-horizontal" method="post" action="<?= base_url('user/edit').'/'.$user[0]->objectId?>">
									<?php endif; ?>
									<?php if ( validation_errors() != "" ) : ?>
										<div class="alert alert-danger" role="alert">
											<?php echo validation_errors(); ?>
										</div>
									<?php endif; ?>
									<fieldset style="text-align: left;">
										<div class="control-group">
											<label for="name-contract" class="control-label">Name</label>
											<div class="controls">
												<input id="name-contract" name="name" <?php if (isset($user[0]->name)): ?> value="<?= $user[0]->name; ?>" <?php endif; ?>
													   data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="name-contract" class="control-label">Lastname</label>
											<div class="controls">
												<input id="name-contract" name="lastname" <?php if (isset($user[0]->LastName)): ?> value="<?=$user[0]->LastName; ?>" <?php endif; ?>
													   data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">Gender</label>
											<div class="controls">
												<input  id="text-contract" name="gender" value="<?php if (isset($user[0]->Gender)): ?><?php echo $user[0]->Gender; ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">City</label>
											<div class="controls">
												<input  id="text-contract" name="city" value="<?php if (isset($user[0]->city)): ?><?php echo $user[0]->city; ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">State</label>
											<div class="controls">
												<input  id="text-contract" name="state" value="<?php if (isset($user[0]->State)): ?><?php echo $user[0]->State; ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">Zipcode</label>
											<div class="controls">
												<input  id="text-contract" name="zipcode" value="<?php if (isset($user[0]->zipcode)): ?><?php echo $user[0]->zipcode; ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">Email</label>
											<div class="controls">
												<input  id="text-contract" name="email" value="<?php if (isset($user[0]->email)):?><?=$user[0]->email; ?> <?php endif; ?>"
														data-parsley-required="true" 	data-parsley-type="email" />
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">Company</label>
											<div class="controls">
												<input  id="text-contract" name="company" value="<?php if (isset($user[0]->company)): ?><?php echo $user[0]->company; ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">Telephone</label>
											<div class="controls">
												<input  id="text-contract" name="telephone" value="<?php if (isset($user[0]->telephone)): ?><?php echo $user[0]->telephone ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
										<div class="control-group">
											<label for="text-contract" class="control-label">Country</label>
											<div class="controls">
												<input  id="text-contract" name="country" value="<?php if (isset($user[0]->country)): ?><?php echo $user[0]->country; ?> <?php endif; ?>"
														data-parsley-required="true" 	/>
											</div>
										</div>
									</fieldset>
								</form>
								<div class="clear">
									<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a>
								</div>
						</div>
						<div class="span2">
							<div class="clear">
								<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="#" onclick="script:save();">
									Save
								</a>
							</div>
							<div class="clear">
								<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="<?= base_url('/manage/logout')?>">
									Logout
								</a>
							</div>
							<div class="clear">
								<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="<?= base_url('/user/index')?>">
									Back
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
<script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="<?=base_url('/public/js/Parsley.js-2.6.2/dist/parsley.min.js')?>"></script>
<script type="text/javascript">
	function save(){
		var form=$('form').parsley();
		form.validate();
		if(form.isValid()){
			$('form').submit();
		}

	}
</script>
</body>
</html>