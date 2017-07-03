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
				
				<div class="span3"><span>orderBy</span>
					<select id="orderbyday" style="margin-bottom:0px;">
						
						<option value="">Beginning</option>
						<option value="1">Last Day</option>
						<option value="2">Last 2 Days</option>
						<option value="7">Last Week</option>
						<option value="10">Last 10 Days</option>
						<option value="14">Last 2 Weeks</option>
						<option value="30">Last Month</option>
						<option value="45">Last 45 Days</option>						
						<option value="60">Last 2 Months</option>
						<option value="75">Last 75 Days</option>
						<option value="100">Last 100 Days</option>
						<option value="365">Last Years</option>						
						
					</select>
				</div>
				<div class="span3">
					<select id="orderbyasc" style="margin-bottom:0px;">
						<option value="0">ascending</option>
						<option value="1">descending</option>
					</select>
				</div>
			</div>
			<div class="row-fluid" style="margin-top:20px;">
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
											<b>User:</b> <?php echo $val['username'] ?><br>
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
		$('#orderbyday').val(<?php echo $day; ?>);
		$('#orderbyasc').val(<?php echo $asc; ?>);	
		function metadataevents(){
			
		};
		function deleteevent(){
			if (window.confirm("Are you sure want to delete selected event(s)?")) { 
				console.log("delete");
				var deletelist = [];
				$( "input:checkbox" ).each(function(){
					if(this.checked == true)
						deletelist.push(this.name);
				});
				$.post( "<?php echo base_url(); ?>events/eventdelete",{ deletelist: deletelist}, function( data ) {
					//console.log(data);
					window.location.href="<?php echo base_url(); ?>events/index";
				});
			}
		}
		$( "#orderbyday" ).change(function() {
			window.location.href="<?php echo base_url(); ?>events/index?day="+$('#orderbyday').val()+"&asc="+$('#orderbyasc').val();
		});
		$( "#orderbyasc" ).change(function() {
			window.location.href="<?php echo base_url(); ?>events/index?day="+$('#orderbyday').val()+"&asc="+$('#orderbyasc').val();
		});

	</script>
	</body>
</html>
