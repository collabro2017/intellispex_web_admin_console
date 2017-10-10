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
                    
			<div class="row-fluid" style="margin-top:20px;">
				<div class="span1"></div>
				<div class="span10">
					<table class="table table-striped events-table" id="table_data">
						<thead>
							<tr>
								<th>User</th>
								<th>Event Title</th>
								<th>Date Created</th>
								<th>Date Deleted</th>
                                <th>Time Left</th>
                                                            <th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php														
								foreach($info as $val){
									?>
									
                                    <tr>
                                        <td><?php echo $val['username'] ?></td>
                                        <td><?php echo $val['eventname'] ?></td>
                                        <td><?php echo $val['createdAt'] ?></td>
                                        <td><?php echo $val['deletedAt'] ?></td>
                                        <td><?php
                                        if($val['deletedAt'] !=""){
                                            $d1 = date('Y-m-d');
                                            $d2 = $val['deletedAt'];

                                            $leftmonth = (int)abs((strtotime($d1) - strtotime($d2))/(60*60*24*30)); 
                                            $today = date("Y")*12+date('m');                                            
                                            $deleteday=explode('-',$val['deletedAt']);
                                            $deleteddate = intval($deleteday[0])*12+intval($deleteday[1]);
//                                            $leftmonth = 12 - ($today-$deleteddate);
                                        }
                                        else{
                                            $leftmonth = "Unknown";
                                        }                                            
                                        echo $leftmonth." Months";
                                        ?></td>
                                        <td><a href="javascript:restoreevent('<?php echo $val['objectId']; ?>');" >Restore Event</a></td>
                                    </tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
				
				<div style="text-align:center;margin-top:50px;">
					<a href="<?php echo base_url(); ?>manage/contentmanager" class="btn btn-small btn-primary menu-button">
						Content Manager
					</a>
				</div>				
			</div>
		</div>
	</div>



	<?php $this->load->view('default/footer/console_page.php'); ?>
	<script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
	
	<script type="text/javascript">
		$('#table_data').DataTable();
                
		function restoreevent(deleteId){
			if (window.confirm("Are you sure want to restore selected event?")) { 
				$.post( "<?php echo base_url(); ?>events/eventRestore",{ deleteId: deleteId}, function( data ) {
					//console.log(data);
                                    alert('Event is restored and you can manage restored event in Event Listing.');
                                    window.location.href="<?php echo base_url(); ?>events/deletedevents/";
				});
			}
		}
	</script>
	</body>
</html>
