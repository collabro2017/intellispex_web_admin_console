<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('default/head/console_page.php'); ?>
<body class="login-layout admin-body">
<?php $this->load->view('default/nav/console_page.php'); ?>
<link rel="stylesheet" href="<?= base_url('/public/js/DataTables-1.10.13/media/css/jquery.dataTables.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('/public/js/DataTables-1.10.13/extensions/Select/css/select.dataTables.min.css') ?>" />
<div class="container-fluid" id="main-container">
	<div id="main-content">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-main">
					<div class="row-fluid">
						<div class="span10">
							<table id="dataTable" class="display" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Name</th>
										<th>Last Name</th>
										<th>Gender</th>
										<th>City</th>
										<th>State</th>
										<th>ZipCode</th>
										<th>Email</th>
										<th>Company</th>
										<th>Telephone</th>
										<th>Country</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="span2">
							<div class="clear">
								<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="#" id="edit-btn">
									Edit
								</a>
							</div>
							<div class="clear">
								<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="#" id="delete-btn">
									Suspend
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
</body>

<?php $this->load->view('default/footer/console_page.php'); ?>
<script src="<?=base_url('/public/js/DataTables-1.10.13/media/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('/public/js/DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js')?>"></script>

<script type="text/javascript">
	var url="<?=base_url("user/ajax_user_datatable_parse")?>"
	var table= $('#dataTable').DataTable({
		"processing" : true ,
		"serverSide" : true ,
		"LengthMenu": [[10, 25, 50, 100,500],[10, 25, 50, 100,500]],
		"paging": true,
		select: {
			style: 'multi'
		},
		dom : 'lrtip',
		"ajax" : {
			url : url,
			type : 'POST' ,
		} ,
		"columns" : [
			{
				"data" : "name" ,
			},
			{
				"data" : "LastName" ,
			},
			{
				"data" : "Gender" ,
			},
			{
				"data" : "City" ,
			},
			{
				"data" : "State" ,
			},
			{
				"data" : "zipcode" ,
			},
			{
				"data" : "email" ,
			},
			{
				"data" : "company" ,
			},
			{
				"data" : "phone" ,
			},
			{
				"data" : "country" ,
			}
		]
	});
	$('#edit-btn').click( function () {

		if(table.$('tr.selected').length>0){
			var row=table.row('.selected');
			data=row.data();
			window.location.href = "<?=base_url('user/edit')?>"+"/"+data.objectId;
		}else{
			alert('Please, select an user');
		}

	} );
	$('#delete-btn').click(function(){
			id=[];
			if(table.$('tr.selected').length>0){
				var result=confirm("Are you sure?");
				if(result)
				{
					table.rows ( '.selected' ).every ( function ( rowIdx )
					{
						table.row ( rowIdx ).data ().objectId;
						id.push ( table.row ( rowIdx ).data ().objectId );
					} );
					var url = "<?= base_url( 'user/suspend_users' )?>";
					$.ajax ( {
						url : url ,
						method : "POST" ,
						data : { id : id } ,
						success : function ( data )
						{
							if ( data.status == 'success' )
							{
								location.reload ();
							} else
							{
								alert ( "the selected users, could not be deleted" );
							}
						}
					} );
				}
			}else{
				alert('Please, select an user');
			}
	});
</script>
