<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('default/head/console_page.php'); ?>
<body class="login-layout admin-body">
<?php $this->load->view('default/nav/console_page.php'); ?>
	<div class="container-fluid" id="main-container">
		<div id="main-content">
			<div class="row-fluid">
				<div class="span12">
					<div class="widget-main">
						<div class="row-fluid">
							<div class="span10" >
								<br/>

								<?php if (!isset($contract)): ?>
								<form class="form-horizontal" method="post" action="<?= base_url('sys_contract/add')?>">
								<?php endif; ?>
								<?php if (isset($contract)): ?>
								<form class="form-horizontal" method="post" action="<?= base_url('sys_contract/edit').'/'.$contract[0]->id?>">
								<?php endif; ?>
								<?php if ( validation_errors() != "" ) : ?>
								 <div class="alert alert-danger" role="alert">
								  <?php echo validation_errors(); ?>
								 </div>
								<?php endif; ?>
								<fieldset style="text-align: left;">
									<div class="control-group">
										<label for="name-contract" class="control-label">Slug Name</label>
										<div class="controls">
											<input id="name-contract" name="name" <?php if (isset($contract[0]->name)): ?> value="<?php echo $contract[0]->name; ?>" <?php endif; ?>>
										</div>
									</div>
									<div class="control-group">
										<label for="text-contract" class="control-label">Content</label>
										<div class="controls">
											<textarea  id="text-contract" name="contract" ><?php if (isset($contract[0]->contract)): ?> <?php echo $contract[0]->contract; ?> <?php endif; ?></textarea>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('default/footer/console_page.php'); ?>
	<script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
	<script src="<?= base_url('assets/tinymce/js/tinymce/tinymce.min.js')?>"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			tinymce.init({
				selector: 'textarea',
				height: '50%',
				width : "100%",
				menubar: false,
				plugins: [
					'advlist autolink lists link  anchor',
					'searchreplace visualblocks code ',
					'insertdatetime media  contextmenu paste code'
				],
				toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
				content_css: '//www.tinymce.com/css/codepen.min.css',
				setup: function (editor) {
					editor.on('change', function () {
						editor.save();
					});
				}
			});
		});
		function save(){
			$('form').submit();

		}


	</script>
</body>
</html>