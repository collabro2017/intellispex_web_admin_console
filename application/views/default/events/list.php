<!DOCTYPE html>
<html lang="en">
	<head>		
		<link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />	

		<style>
			#DataTables_Table_0_wrapper{
				margin:auto;
			}
			#main-container{
				margin-top:10%;
			}
		</style>

	</head>
	<?php $this->load->view('default/head/console_page.php'); ?>
	<body class="login-layout admin-body">
	<?php $this->load->view('default/nav/console_page.php'); ?>
  	
	  <div class="container-fluid" id="main-container">
		<div id="main-content">
			<div class="row-fluid">
				<div class="span1"></div>
				<div class="span10">
					<table class="table table-striped events-table" id="table_data">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php														
								foreach($info as $val){
									?>
									<tr>																
										<td><input type="checkbox" class="deleteitem" name="<?php echo $val['objectId'] ?>"></td>
										<td><img width="70px" src="<?php echo $val['postImage']['url']; ?>"></img></td>
										<td><?php echo $val['eventname'] ?><br>
											<b>Date Created:</b> <?php echo $val['createdAt'] ?><br>
											<b>User:</b> <?php echo $val['username'] ?>
										</td>
										<td>
											<button onclick="metadataevents();">Download Metadata</button><br><br>
											<button onclick="window.print();">Download PDF</button>									
										</td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
				<br><br><br>
				<div class="row">				
					<div class="span10" style="margin-left:10%;margin-top:3%;">
						<div class = "row">
							<div class="span4" style="text-align:center;"> <a style="min-width:300px;" href="javascript:deleteevent();" class="btn btn-small btn-primary menu-button">Delete Event</a> </div>
							<div class="span4" style="text-align:center;"> <a style="min-width:300px;" class="btn btn-small btn-primary menu-button editevent">Edit Event</a> </div>
							<div class="span4" style="text-align:center;"> <a style="min-width:300px;" class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/clientmanagementconsolesupport">Support</a> </div>
					
						</div>
					</div>					
				</div>
				<div style="text-align:center;margin-top:2%;">
					<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
						Console Menu
					</a>
				</div>				
			</div>
		</div>
	</div>



	<?php $this->load->view('default/footer/console_page.php'); ?>
	<script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
	
	<script type="text/javascript">		
		
		$('#table_data').DataTable();		
		function metadataevents(){
			
		};
		function deleteevent(){
			if (window.confirm("Are you sure want to delete selected event(s)?")) { 
				console.log("delete");
			}
		}

	</script>
	</body>
</html>
