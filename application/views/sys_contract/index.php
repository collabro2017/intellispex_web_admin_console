
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
							<div class="span10">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>ID</th>
											<th style="width: 70%">Slug Name</th>
											<th>Version</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($rows as $row):?>
									<tr>

										<td>
										<?= $row->id?>
										</td>

										<td>
										<?= $row->name?>
										</td>
										<td>
											<?= $row->version?>
										</td>
										<td>
										<a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>sys_contract/edit/<?php echo $row->id; ?>">Edit</a>
								  		<a class=" btn btn-small btn-primary" href="#" onclick='deleted( <?php echo $row->id; ?> );'> Delete</a>
								  		</td>

									</tr>
									<?php endforeach;?>
									</tbody>
								</table>
								<div class="clear">
									<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a>
								</div>

							</div>
							<div class="span2">
								<div class="clear">
									<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="<?= base_url('/sys_contract/add')?>">
									Add New
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
	<script type="text/javascript">
	function deleted( id )
		{

		  var answer = confirm("You are sure to delete this record??");

		    if (answer)
		    {
		        window.location = "<?= base_url('sys_contract/delete/')?>" +"/"+ id;
		    }

		}
	</script>
</body>

<?php $this->load->view('default/footer/console_page.php'); ?>
