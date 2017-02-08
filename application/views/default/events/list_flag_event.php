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
									<th>User</th>
									<th>Date Time reported</th>
									<th>Feature User</th>
									<th>Description</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="span2">

							<div class="clear">
								<a class="btn btn-small btn-primary menu-button menu-logout-button"
								   href="#" id="delete-btn">
									delete
								</a>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="clear" style="text-align: center;">
	<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a>
</div>

<?php $this->load->view('default/footer/console_page.php'); ?>
</body>
<script src="<?=base_url('/public/js/moment.min.js')?>"></script>
<script src="<?=base_url('/public/js/DataTables-1.10.13/media/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('/public/js/DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js')?>"></script>

<script type="text/javascript">
	var url="<?=base_url("events/ajax_get_flagged_events")?>"
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
				"data" : "objectId" ,
				"render": function(data,type, row){
					return row.targetEvent.username
				}

			},
			{
				"data" : "updatedAt" ,
				"render":function(data, type, row){
					if(type=='display'){
						return moment(data).format('YYYY/MM/DD HH:mm:ss');
					}
					return data;
				}
			},
			{
				"data" : "targetEvent" ,
				"render":function(data, type, row)
				{
					if(type=='display'){
						var url='<?= base_url()?>'+'/events/event/'+row.targetEvent.objectId;
						if(!jQuery.isEmptyObject(row.usersBadgeFlag) && jQuery.isEmptyObject(row.targetEvent.eventBadgeFlag))
						{

							return '<a href="'+url+'" target="_blank">Post</a>';
						}
						if(jQuery.isEmptyObject(row.usersBadgeFlag) && !jQuery.isEmptyObject(row.targetEvent.eventBadgeFlag))
						{
							return '<a href="'+url+'" target="_blank">Event</a>';
						}
						if(!jQuery.isEmptyObject(row.usersBadgeFlag) && !jQuery.isEmptyObject(row.targetEvent.eventBadgeFlag))
						{
							return '<a href="'+url+'" target="_blank">Post, Event</a>';
						}
					}else{
						return data;
					}
				}
			},
			{
				"data":"description",
				"render":function(data, type, row){
					if(type=='display'){
						if(!jQuery.isEmptyObject(row.usersBadgeFlag && jQuery.isEmptyObject(row.targetEvent.eventBadgeFlag)))
						{

							return row.description;
						}
						if(jQuery.isEmptyObject(row.usersBadgeFlag && !jQuery.isEmptyObject(row.targetEvent.eventBadgeFlag)))
						{
							return row.targetEvent.eventname;
						}
						if(!jQuery.isEmptyObject(row.usersBadgeFlag && !jQuery.isEmptyObject(row.targetEvent.eventBadgeFlag)))
						{
							return row.description+'</br>'+row,targetEvent.title;
						}
					}else{
						return data;
					}
				}
			}
		]
	});

	$('#delete-btn').click(function(){
		id=[];
		if(table.$('tr.selected').length>0){
			var result=confirm("Are you sure?");
			if(result)
			{
				table.rows ( '.selected' ).every ( function ( rowIdx )
				{
					table.row ( rowIdx ).data ().targetEvent.objectId;
					id.push ( table.row ( rowIdx ).data ().objectId );
				} );
				var url = "<?= base_url( 'events/ajax_delete_event' )?>";
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
							alert( "the selected users, could not be deleted" );
						}
					}
				} );
			}
		}else{
			alert('Please, select an user');
		}
	});

</script>
