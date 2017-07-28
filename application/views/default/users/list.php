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
	<?php  $this->load->view('default/head/console_page.php'); ?>
	<body class="login-layout admin-body">
	<?php $this->load->view('default/nav/console_page.php'); ?>
  	
	  <div class="container-fluid" id="main-container">
		<div id="main-content">
			<div class="row-fluid" style="margin-top:20px;">
                            <div class="span12">
                                
                            <ul style="list-style: none">
                                <li style="float:left;margin-left: 10px;">
                                    <a href="<?php echo base_url(); ?>manage/add_user/<?php echo $client_id; ?>" class="btn btn-small btn-primary">Add Associated Users</a>	
                                </li>
                                <li style="float:left;margin-left: 10px;">
                                    <a class="btn btn-small btn-primary"  href="javascript:deleteuser();" class="btn btn-small btn-primary menu-button">Delete User</a> 	
                                </li>
                                <li style="float:left;margin-left: 10px;">
                                    <a class="btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/create_user_group/" class="btn btn-small btn-primary menu-button">Create Group</a> 	
                                </li>
                                <li style="float:left;margin-left: 10px;">
                                    <a class="btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/create_user_group/" class="btn btn-small btn-primary menu-button">View Group</a>	
                                </li>
                            </ul>
                            </div>
				<div class="span11">
					<table class="table table-striped events-table" id="table_data">
						<thead>
							<tr>
                                                            <th></th>
								<th>Name</th>
								<th>Company</th>
								<th>Gender</th>
								<th>Email</th>
								<th>Phone #</th>
								<th>Country</th>
								<th>City</th>
								<th>State</th>
								<th>ZipCode</th>
								<th>Status</th>
								<th>Time Active</th>
								<th>Actions</th>
							  </tr>
						</thead>
						<tbody>
							<?php foreach ($associated_user as $value): ?>
								<tr>
                                                                  <td><input type="checkbox" class="deleteitem" name="<?php echo $value['objectId'] ?>"></td>
                                                                  <td><?php if(isset($value['Firstname'])): echo $value['Firstname']; endif; echo " ";if(isset($value['LastName'])): echo  $value['LastName']; endif; ?></td>
                                                                  <td><?php if(isset($value['company'])): echo $value['company']; endif; ?></td>
                                                                   <td><?php if(isset($value['Gender'])): echo $value['Gender']; endif; ?></td>
								  <td><?php if(isset($value['email'])): echo $value['email']; endif; ?></td>
								  <td><?php if(isset($value['phone'])): echo $value['phone']; endif; ?></td>
                                                                  <td><?php if(isset($value['country'])): echo $value['country']; endif; ?></td>
                                                                  <td><?php if(isset($value['city'])): echo $value['city']; endif; ?></td>
                                                                  <td><?php if(isset($value['state'])): echo $value['state']; endif; ?></td>
                                                                  <td><?php if(isset($value['zipcode'])): echo $value['zipcode']; endif; ?></td>
								  <td>
                                                                        <?php if ( $value['Status'] == '1' ){ echo 'Active'; }else{ echo 'Closed'; } ?>
								  </td>
                                                                  <td><?php echo date('Y-m-d',strtotime($value['createdAt'])) ?></td>
                                                                  
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/edit_user/<?php echo $value['objectId']; ?>/<?php echo $client_id; ?>">Edit</a></td>
								</tr>
							  <?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<br><br><br>
				<div class="row">				
					<div class="span10" style="margin-left:10%;margin-top:3%;">
						<div class = "row">
							<div class="span4" style="text-align:center;"> </div>
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

		function deleteuser(){
			if (window.confirm("Are you sure want to delete selected user(s)?")) { 
				
				var deletelist = [];
				$( ".deleteitem" ).each(function(){
					if(this.checked == true)
						deletelist.push(this.name);
				});
				$.post( "<?php echo base_url(); ?>manage/userdelete",{ deletelist: deletelist}, function( data ) {
					//console.log(data);
					window.location.href="<?php echo base_url(); ?>manage/user_management";
				});
			}
		}

	</script>
	</body>
</html>
