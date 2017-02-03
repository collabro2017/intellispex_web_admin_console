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
									<?php foreach($info as $key ) : ?>
										<tr>
											<td>
												<a href="<?php echo base_url(); ?>events/event/<?php echo $key->objectId ?>">
													<?php
														if($key->eventname)
														{
															echo $key->eventname;
														}else{
																echo 'No name';
														}
													?>
												</a>
											</td>
											<td>
												<?php echo $key->username ?>
											</td>
											<td>
												<?php echo $key->createdAt ?>
											</td>
											<td>
												<input type="checkbox" data-id="<?= $key->objectId ?>" name="evet_delete" />
											</td>
										</tr>
									<?php endforeach; ?>
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
			var id=[];
			$("table.events-table input[name=evet_delete]:checked").each
			   (
				   function( index )
				   {
					   id.push($( this ).data("id"));
					   console.log( index + ": " + $( this ).data("id") );
				   }
			   );

			$.ajax({
				url: "<?php echo base_url("/events/ajax_delete_event"); ?>",
				method: "POST",
				data: {id:id},
				success:function(data)
				{

					if(data.result=='success'){
						$("table.events-table input[name=evet_delete]:checked").each(
						   function( index )
						   {
							   $(this).attr('checked', false);
						   }
					   );
						location.reload();
					}else{
						alert('the selected events could not be deleted');
					}
				}
			});
		}
	</script>
	</body>
</html>
