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
								<table class="table table-striped events-table">
									<thead>
										<tr>
											<th>Event Name</th>
											<th>Client</th>
											<th>Date</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><a href="<?php echo base_url(); ?>manage/event/1">Coffee Mugs</a></td>
											<td>Nancy</td>
											<td>2016-23-12</td>
											<td>
												<input type="checkbox" data-id="101" name="evet_delete" />
											</td>
										</tr>
										<tr>
											<td><a href="<?php echo base_url(); ?>manage/event/2">Coffee Mugs</a></td>
											<td>Nancy</td>
											<td>2016-23-12</td>
											<td>
												<input type="checkbox" data-id="102" name="evet_delete" />
											</td>
										</tr>
										<tr>
											<td><a href="<?php echo base_url(); ?>manage/event/3">Coffee Mugs</a></td>
											<td>Nancy</td>
											<td>2016-23-12</td>
											<td>
												<input type="checkbox" data-id="103" name="evet_delete" />
											</td>
										</tr>
										<tr>
											<td><a href="<?php echo base_url(); ?>manage/event/4">Coffee Mugs</a></td>
											<td>Nancy</td>
											<td>2016-23-12</td>
											<td>
												<input type="checkbox" data-id="104" name="evet_delete" />
											</td>
										</tr>
										<tr>
											<td><a href="<?php echo base_url(); ?>manage/event/5">Coffee Mugs</a></td>
											<td>Nancy</td>
											<td>2016-23-12</td>
											<td>
												<input type="checkbox" data-id="105" name="evet_delete" />
											</td>
										</tr>
									</tbody>
								</table>

								<div class="clear">
									<a href="#" onclick="script:deletevents();" class="btn btn-small btn-primary menu-button">
										Submit
									</a>
								</div>
								<div class="clear">
									<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
										Console Menu
									</a>
								</div>
							</div>
							<div class="span2">
								<a class="btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>manage/logout">
			  						Logout
			  					</a>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<a class=" btn btn-small btn-primary menu-button menu-logout-button menu-button-small" href="<?php echo base_url(); ?>/manage/sqlserver">
									SQL Server
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('default/footer/console_page.php'); ?>
	<script type="text/javascript">
		function deletevents()
		{
			$("table.events-table input[name=evet_delete]:checked").each
			(
				function( index )
				{
			  		console.log( index + ": " + $( this ).data("id") );
				}
			);
			alert("Delete events");
		}
	</script>
	</body>
</html>
