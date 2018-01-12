<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8" />
	<title>IntelliSpeX</title>
	<meta name="description" content="User login page" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- basic styles -->
	<link href="<?php echo base_url('public') ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('public') ?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/font-awesome.min.css" />

	<!--[if IE 7]>
	  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
	<![endif]-->


	<!-- page specific plugin styles -->


	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/ace.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('public') ?>/assets/css/ace-responsive.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('public') ?>/css/main.css" />
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />	

        <style>
                #DataTables_Table_0_wrapper{
                        margin:auto;
                }
        </style>
	<!--[if lt IE 9]>
	  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
	<![endif]-->

	<style type="text/css">
		.column-chart {
		  position: relative;
		  z-index: 20;		 	  
		  width: 80%;
		  height: 200px;		 
		}
		
		.column-chart > .chart {
		  position: relative;
		  z-index: 20;
		  width: 98%;
		  height: 100%;
		}

		.column-chart > .chart > .item {
		  position: relative;
		  float: left;
		  height: 100%;
		}

		.column-chart > .chart > .item:before {
		  position: absolute;
		  z-index: -1;
		  content: '';
		  width: 1px;
		  height: calc(100% + 15px);
		}

		.column-chart > .chart > .item > .bar {
		  position: absolute;
		  width: 94%;
		  height: 100%;
		}

		.column-chart > .chart > .item > .bar > .item-progress {
		  position: absolute;
		  bottom: 0;
		  left: 0;
		  width: 100%;
		  height: 20%;
		  color: #fff;		  
		}

		table, th, td {
		    border: 1px solid black;
		    border-collapse: collapse;
		}
		th, td {
		    padding: 5px;
		    text-align: left;
		    background-color:#ffffff;
		}
		#frm_support .row .span6{
			text-align:left;
		}
		#frm_support .row .span6 input{
			width:100%;
		}
		#frm_support .row .span6 textarea{
			width:100%;
		}
		input[type="file"]{
			display:flex;			
		}
	</style>

  </head>

  <body class="login-layout admin-body">
		<div class="top-menu">
                    <div class="span2">
                        <h2><img class="irc_mut iUyhD38Z_yik-HwpH6ZlgJaI" onload="google.aft&amp;&amp;google.aft(this)" src="<?php echo base_url('public') ?>/images/logo.JPG" width="60" height="60" style="margin-top: 0px;"> 
                        <span style="color : #00aaff;">IntelliSpeX</span></h2>
                    </div>
                    <div class="span5"><h2 style="text-align: left;"><span><?php echo $function_name; ?></span></h2></div>
                    <div class="span5" style="float:right;">
                        <h2 id="welcome-heading"> <span>Welcome, <?php echo $email; ?></span></h2>
                        <ul class="main-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>manage/console_menu">Home</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>manage/clientmanagementconsolesupport">Support</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>manage/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
		</div>
  <div class="container-fluid" id="main-container">
	<div id="main-content">
		<?php if ( isset($links) && ( array_key_exists( "logout", $links ) || array_key_exists( "Logout", $links ) ) ): ?>
			<?php if($function_name != "CLIENT MANAGEMENT CONSOLE"){ ?>
	  		<div class="widget-main">
	  			<a class=" btn btn-small btn-primary menu-button menu-logout-button" style="margin-top:10px" href="<?php echo base_url(); ?>manage/logout">Logout</a>
	  		</div>
		<?php } endif; ?>

	 	 <div class="row-fluid">


		<div class="span12">

		  <div class="">

			<div class="row-fluid">
			  <div class="center">

			  </div>
			</div>

			<div class="space-6"></div>

			<div class="row-fluid">

			  <div class="position-relative">


				<div id="login-box" class="visible no-border">

				  <div>
					<div class="widget-main">

					  <div class="space-6"></div>



					  <div class="panel-admin" style="text-align: initial;">
					  	<?php
					  		if($function_name == "CLIENT MANAGEMENT CONSOLE"){ ?>
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;">
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/contentmanager">Content Manager</a>
					  			</div>					  			
					  		</div>
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;">
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/userstatistics">User Statistics</a>
					  			</div>					  			
					  		</div>
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;">
					  				<a class="btn btn-small btn-primary menu-button" href="#">Console Manager</a>
					  			</div>					  			
					  		</div>
					  		<div class="row">
					  			<div class="span3"></div>
						  		<div class="span6">
						  			<img alt="Client Management's Images" src="<?php echo base_url('public') ?>/images/earth.jpg" />
					  			</div>
					  		</div>
                                              <div style="clear:both;height: 40px;"></div>
					  		
					  	<?php
					  		}
					  		else if($function_name == "User Statistics"){
					  	?>
					  		<div class="row">
					  			<div class="span1"></div>
					  			<div class="span6">
					  				<a class="btn btn-small btn-primary menu-button" style="min-width:250px;margin-top: 15px;" href="#">Support</a>
					  			</div>
					  		</div>
					  		<div class="row">
					  			<div class="span1"></div>
					  			<div class="span6">
					  				<div>
										<table>
											<thead>
												<th style="width:50%;">&nbsp;</th>
												<th style="width:50%;">&nbsp;</th>	
											</thead>
											
											<tr>
												<td># of Full Right Users</td>
												<td><?php echo $full; ?></td>
											</tr>
											<tr>
												<td># of Comment-View Users</td>
												<td><?php echo $commentOnly; ?></td>
											</tr>
											<tr>
												<td># of View Only Users</td>
												<td><?php echo $viewOnly; ?></td>
											</tr>
											<tr>
												<td>Total Data</td>
												<td><?php echo $totalData; ?></td>
											</tr>
											<tr>
												<td>Average Data Per Event</td>
                                                                                                <td><?php if(isset($averageData)) echo $averageData; ?></td>
											</tr>
										</table>
									</div>
					  			</div>
					  			<div class="span4">
					  				
									 <div class="column-chart">						            
						            
						                <div class="chart clearfix">
						                    <div class="item">
						                        <div class="bar">
						                            <div class="item-progress" style="background-color: #0000ff;" data-percent="35">
						                            </div>
						                            <!-- //.item-progress -->
						                        </div>
						                        <!-- //.bar -->
						                    </div>
						                    <!-- //.item -->
						            
						                    <div class="item">
						                        <div class="bar">	
						                            <div class="item-progress" style="background-color: #00a651;" data-percent="45">
						                            </div>
						                            <!-- //.item-progress -->
						                        </div>
						                        <!-- //.bar -->
						                    </div>
						                    <!-- //.item -->
						            
						                    <div class="item">
						                        <div class="bar">	
						                            <div class="item-progress" style="background-color: #f7941d;" data-percent="55">
						                            </div>
						                            <!-- //.item-progress -->
						                        </div>
						                        <!-- //.bar -->
						                    </div>
						                    <!-- //.item -->
						            
						                    <div class="item">
						                        <div class="bar">
						                            <div class="item-progress" style="background-color: #ed1c24;" data-percent="65">
						                            </div>
						                            <!-- //.item-progress -->
						                        </div>
						                        <!-- //.bar -->
						                    </div>
						                    <!-- //.item -->
						            
						                    <div class="item">
						                        <div class="bar">
						                            <div class="item-progress" style="background-color: #8dc63f;" data-percent="76">
						                            </div>
						                            <!-- //.item-progress -->
						                        </div>
						                        <!-- //.bar -->
						                    </div>
						                    <!-- //.item -->
						                    <div class="item">
						                        <div class="bar">
						                            <div class="item-progress" style="background-color: #002157;" data-percent="97">
						                            </div>
						                            <!-- //.item-progress -->
						                        </div>
						                        <!-- //.bar -->
						                    </div>
						                    <!-- //.item -->
						                </div>
						                <!-- //.chart -->
						            </div>
																					
					  			</div>
					  		</div>
					  		<div class="row" style="margin-top:30px;">
					  			<div class="span3"></div>
					  			<div class="span6">
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/clientmanagementconsole" style="width:100%;">Client Management Console</a>
					  			</div>					  			
					  		</div>
					  	<?php		
					  		}
					  		else if($function_name == "Content Manager"){
					  	?>
					  		<div class="row">
					  			<div class="span2"></div>
<!--					  			<div class="span4" style="text-align: left;">
					  				<a class="btn btn-small btn-primary menu-button" style="min-width:250px;margin-top: 15px;" href="<?php echo base_url(); ?>manage/clientmanagementconsolesupport">Support</a>
					  			</div>
					  			<div class="span4" style="text-align: right;">
					  				<a class="btn btn-small btn-primary menu-button" style="min-width:250px;margin-top: 15px;" href="#">Download Complete</a>
					  			</div>-->
					  		</div>	
                                                        <div class="row">
                                                            <div class="span3"></div>
                                                            <div class="span6" style="text-align: center;" >
                                                                <a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>events/download_metadata">Download Metadata</a>
                                                            </div>					  			
                                                        </div>	
                                                        <div class="row">
                                                            <div class="span3"></div>
                                                            <div class="span6" style="text-align: center;" >
                                                                <a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>events/create">Set-Up Events</a>
                                                            </div>					  			
                                                        </div>
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;" >
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>events/index">View Events</a>
					  			</div>					  			
					  		</div>	
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;" >
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>events/deletedevents">Deleted Events</a>
					  			</div>					  			
					  		</div>	
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;" >
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/user_management">User Management</a>
					  			</div>					  			
					  		</div>
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;" >
					  				<a class="btn btn-small btn-primary menu-button" href="#">Deleted Users</a>
					  			</div>					  			
					  		</div>
					  		<div class="row">
					  			<div class="span3"></div>
					  			<div class="span6" style="text-align: center;" >
					  				<a class="btn btn-small btn-primary menu-button" href="#">User Customizable Delimited Data Lists</a>
					  			</div>					  			
					  		</div>	
<!--					  		<div class="row">
					  			<div class="span2"></div>
					  			<div class="span8" style="text-align: center;" >
					  				<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/clientmanagementconsole">Client Management Console</a>
					  			</div>					  			
					  		</div>					  		-->
					  	<?php
					  		}
								else if($function_name == "SUPPORT REQUEST"){									
							?>	
							<div class="row">
								<div class="span3"></div>
								<div class="span6">
									<!--form action="<?php echo base_url(); ?>manage/supportmsg" id="frm_support" method="post" enctype="multipart/form-data"-->
									<?php   echo form_open_multipart(base_url().'manage/supportmsg', array('id'=>'frm_support', 'method'=>'post')); ?>
										<div class="row">
											<div class="span6">To:</div>
											<div class="span6">
                                                                                            <input type="email" class="form-control" id="email" value="support@vistechmgmt.zendesk.com" name="email">

                                                                                        </div>											
										</div>
										<div class="row">
											<div class="span6">Contact Email:</div>
											<div class="span6">
												<input type="email" class="form-control" id="emailto" name="emailto">
											</div>											
										</div>
										<div class="row">
											<div class="span6">Priority:</div>
											<div class="span6">
												<select name="priority">
													<option value="Forget Password">Forget Password</option>
													<option value="Forget Username">Forget Username</option>
													<option value="Change Password">Change Password</option>
													<option value="Page does not load">Page does not load</option>
													<option value="Error Page">Error Page</option>
													<option value="Other">Other</option>
												</select>
											</div>											
										</div>
										<div class="row">
											<div class="span6">Description:</div>
											<div class="span6">
												<textarea class="form-control" rows="7" id="des" name="des"></textarea><br>	
											</div>											
										</div>
										<div class="row">
											<div class="span6">Attachment:</div>
											<div class="span6">
												<input type="file" class="form-control" id="support_file" name="support_file">
											</div>											
										</div>
										<div class="row">
											<div class="span12">
												<button type="submit" class="btn btn-default">Submit</button>												
												<button type="button" onclick="window.history.back();"  class="btn btn-default">Cancel</button>
											</div>																			
										</div>
									</form>		
								</div>
							</row>

												
							<?php
								}
								else if($function_name == "Deleted Events"){
								?>
								<div class="row">
									<div class="span1">
									</div>
									<div class="span10">
										<table>
											<thead>
												<th>User</th>
												<th>Event Title</th>
												<th>Date Created</th>
												<th>Date Deleted</th>
												<th>Time Left</th>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row" style="text-align:center;margin-top:15%;">
									<div class="span2">
									</div>
									<div class="span8">
										<a class="btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/contentmanager">Content Manager</a>
									</div>
								</div>
								<?php
								}
					  		else{
					  		if (isset($links)): ?>
							<?php foreach ($links as $key => $link): ?>
								<?php if  ($link != "Logout") : 
                                                                    if($key == 'create_client' && $role == '2'){
                                                                        ?>
                                                        
									<div style="text-align: center;">
										<a class=" btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>clients/create"><?php echo $link; ?></a>
									</div>
                                                        <?php
                                                                    }else{
                                                                    ?>
									<div style="text-align: center;">
										<a class=" btn btn-small btn-primary menu-button" href="<?php echo base_url(); ?>manage/<?php echo $key; ?>"><?php echo $link; ?></a>
									</div>
                                                                    <?php } endif; ?>
							<?php endforeach; ?>
							<?php endif;
							} ?>
						<?php if ( isset( $statistics ) ): ?>

							<div>
  								<div class="span9">

									<div class="section-title">
										<h2><?php echo $statistics; ?></h2>
									</div>
									<div class="table-wrapper">
										<table class="table table-striped statistics-table ">
											<tr>
												<td># of Administrators</td>
												<td><?php echo $admin_count; ?></td>
											</tr>
											<tr>
												<td># of Users</td>
												<td><?php echo $user_count?></td>
											</tr>
											<tr>
												<td># of Activities</td>
												<td>100</td>
											</tr>
											<tr>
												<td># of Frames / Activity (average)</td>
												<td>100</td>
											</tr>
											<tr>
												<td>Total Storage in Use</td>
												<td>100</td>
											</tr>
											<tr>
												<td>Average Storage / Activity</td>
												<td>100</td>
											</tr>
										</table>
									</div>
								</div>
								
								<div class="span3">
									<div class="span12">
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>manage/logout">Logout</a>
										<div class="clear"></div>
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" onclick="window.print();" href="#">Print</a>
										<div class="clear"></div>
										<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="#">Share PDF Report</a>
									</div>
								</div>
								
							</div>
						<?php endif; ?>
						<?php if (isset($create_associated_user) || isset($edit_associated_user)): ?>
						<div class="panel-admin">
							<div class="span9">
  								<label>
									<span class="block input-icon input-icon-right">
										<?php echo validation_errors(); ?>
									</span>
								</label>
						  		<?php if(isset($message)) echo $message; ?>
						 		 <?php if (isset($create_associated_user)): ?>
									<form action='<?php echo base_url(); ?>manage/add_user/<?php echo $client_id?>' method='post' style="margin-bottom:0">
									  <?php endif; ?>
									  <?php if (isset($edit_associated_user)): ?>
									  <form action='<?php echo base_url(); ?>manage/edit_user/<?php echo $user[0]['objectId']; ?>/<?php echo $client_id?>' method='post' style="margin-bottom:0">
										<?php endif; ?>
									  <table class="table table-striped create-client-table"><tr>
										  <th>First Name</th>
										  <th><input type="text" class="span12" name='Firstname' <?php if (isset($user[0]['Firstname'])): ?> value="<?php echo $user[0]['Firstname']; ?>" <?php endif; ?>/></th>
										</tr><tr>
										  <th>Last Name</th>
										  <th><input type="text" class="span12" name='LastName' <?php if (isset($user[0]['LastName'])): ?> value="<?php echo $user[0]['LastName']; ?>" <?php endif; ?>/></th>
										</tr>
                                                                                <tr>
										  <th>Gender</th>
										  <th>
                                                                                      <select name="Gender">
                                                                                          <option <?php if (isset($user[0]['Gender'])): if($user[0]['Gender'] == 'male'){ echo 'selected'; } endif;?>  value="male">Male</option>
                                                                                          <option <?php if (isset($user[0]['Gender'])): if($user[0]['Gender'] == 'female'){ echo 'selected'; } endif;?> value="female">Fe-Male</option>
                                                                                      </select>
                                                                                  </th>
										</tr>
										<tr>
										  <th>Company</th>
										  <th><input type="text" class="span12" name='company' <?php if (isset($user[0]['company'])): ?> value="<?php echo $user[0]['company']; ?>" <?php endif; ?>/></th>
										</tr>
										<tr>
										  <th>User Name</th>
										  <th><input type="text" class="span12" name='name' <?php if (isset($user[0]['username'])): ?> value="<?php echo $user[0]['username']; ?>" <?php endif; ?>/></th>
										</tr>
										<tr>
										  <td>Email</td>
										  <td><input type="text" class="span12" name='email'<?php if (isset($user[0]['email'])): ?> value="<?php echo $user[0]['email']; ?>" <?php endif; ?>/></td>
										</tr>
                                                                                 <?php if (isset($create_associated_user)): ?>
										<tr>
										  <td>Password</td>
                                                                                  <td><input type="password" class="span12" name='password'<?php if (isset($user[0]['password'])): ?> value="<?php echo $user[0]['password']; ?>" <?php endif; ?>/></td>
										</tr>
                                                                                 <?php endif; ?>
<!--										<tr>
										  <td>Location</td>
										  <td><input type="text" class="span12" name='address1'<?php if (isset($user[0]['address1'])): ?> value="<?php echo $user[0]['address1']; ?>" <?php endif; ?>/></td>
										</tr>-->
										<tr>
										  <th>Country</th>
										  <th><input type="text" class="span12" name='country' <?php if (isset($user[0]['country'])): ?> value="<?php echo $user[0]['country']; ?>" <?php endif; ?>/></th>
										</tr>
										<tr>
										  <td>City</td>
										  <td><input type="text" class="span12" name='city'<?php if (isset($user[0]['city'])): ?> value="<?php echo $user[0]['city']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Province / State</td>
										  <td><input type="text" class="span12" name='province'<?php if (isset($user[0]['state'])): ?> value="<?php echo $user[0]['state']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Postal Code</td>
										  <td><input type="text" class="span12" name='postal'<?php if (isset($user[0]['zipcode'])): ?> value="<?php echo $user[0]['zipcode']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Phone</td>
										  <td><input type="text" class="span12" name='phone_number'<?php if (isset($user[0]['telephone'])): ?> value="<?php echo $user[0]['telephone']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Mobile Phone</td>
										  <td><input type="text" class="span12" name='mobile'<?php if (isset($user[0]['phone'])): ?> value="<?php echo $user[0]['phone']; ?>" <?php endif; ?>/></td>
										</tr>
<!--										<tr>
										  <td>Date Created</td>
										  <td><input type="date" class="span12" name='created'<?php if (isset($user[0]['created'])): ?> value="<?php echo $user[0]['created']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Date Modified</td>
										  <td><input type="date" class="span12" name='updated'<?php if (isset($user[0]['updated'])): ?> value="<?php echo $user[0]['updated']; ?>" <?php endif; ?>/></td>
										</tr>-->
									  </table>
									  <div class="row-fluid">

										<input type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary menu-button"></input>
									  </div>
									</form>
							</div>
							<div class="span3">
								<div class="span12">
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/logout">Logout</a>
									<div class="clear"></div>
<!--									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/scan">Scan Business Card</a>
									<div class="clear"></div>-->
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/upload">Upload Doc</a>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						  <?php endif; ?>
                                                <?php if (isset($create_client) || isset($edit_client)): ?>
						<div class="panel-admin">
							<div class="span9">
  								<label>
									<span class="block input-icon input-icon-right">
										<?php echo validation_errors(); ?>
									</span>
								</label>
						  		<?php echo $message; ?>
						 		 <?php if (isset($create_client)): ?>
									<form action='<?php echo base_url(); ?>manage/create_client/' method='post' style="margin-bottom:0">
									  <?php endif; ?>
									  <?php if (isset($edit_client)): ?>
									  <form action='<?php echo base_url(); ?>manage/edit/<?php echo $client_data[0]['objectId']; ?>' method='post' style="margin-bottom:0">
										<?php endif; ?>
									  <table class="table table-striped create-client-table">
										<tr>
										  <th>Client Name</th>
										  <th><input type="text" class="span12" name='name' <?php if (isset($client_data[0]['username'])): ?> value="<?php echo $client_data[0]['username']; ?>" <?php endif; ?>/></th>
										</tr>
										<tr>
										  <td>Email</td>
										  <td><input type="text" class="span12" name='email'<?php if (isset($client_data[0]['email'])): ?> value="<?php echo $client_data[0]['email']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Password</td>
                                                                                  <td><input type="password" class="span12" name='password'<?php if (isset($client_data[0]['password'])): ?> value="<?php echo $client_data[0]['password']; ?>" <?php endif; ?>/></td>
										</tr>
<!--										<tr>
										  <td>Location</td>
										  <td><input type="text" class="span12" name='address1'<?php if (isset($client_data[0]['address1'])): ?> value="<?php echo $client_data[0]['address1']; ?>" <?php endif; ?>/></td>
										</tr>-->
										<tr>
										  <td>City</td>
										  <td><input type="text" class="span12" name='city'<?php if (isset($client_data[0]['city'])): ?> value="<?php echo $client_data[0]['city']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Province / State</td>
										  <td><input type="text" class="span12" name='province'<?php if (isset($client_data[0]['state'])): ?> value="<?php echo $client_data[0]['state']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Postal Code</td>
										  <td><input type="text" class="span12" name='postal'<?php if (isset($client_data[0]['zipcode'])): ?> value="<?php echo $client_data[0]['zipcode']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Phone</td>
										  <td><input type="text" class="span12" name='phone_number'<?php if (isset($client_data[0]['telephone'])): ?> value="<?php echo $client_data[0]['telephone']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Mobile Phone</td>
										  <td><input type="text" class="span12" name='mobile'<?php if (isset($client_data[0]['phone'])): ?> value="<?php echo $client_data[0]['phone']; ?>" <?php endif; ?>/></td>
										</tr>
<!--										<tr>
										  <td>Date Created</td>
										  <td><input type="date" class="span12" name='created'<?php if (isset($client_data[0]['created'])): ?> value="<?php echo $client_data[0]['created']; ?>" <?php endif; ?>/></td>
										</tr>
										<tr>
										  <td>Date Modified</td>
										  <td><input type="date" class="span12" name='updated'<?php if (isset($client_data[0]['updated'])): ?> value="<?php echo $client_data[0]['updated']; ?>" <?php endif; ?>/></td>
										</tr>-->
									  </table>
									  <div class="row-fluid">

										<input type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary menu-button"></input>
									  </div>
									</form>
							</div>
							<div class="span3">
								<div class="span12">
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/logout">Logout</a>
									<div class="clear"></div>
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/scan">Scan Business Card</a>
									<div class="clear"></div>
									<a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/upload">Upload Doc</a>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						  <?php endif; ?>
						  <?php if (isset($client_setup)): 
                                                      ?>
                                                        <table class="table table-striped events-table" id="table_data">
							  <thead>
                                                            <tr>
								<th>Client</th>
								<th>Date Established</th>
								<th>Status</th>
								<th>Phone #</th>
								<th>Email</th>
								<th>Edit</th>
								<th>Add Associate Users</th>
                                                            </tr>
							  </thead>
                                                          <tbody>
							  <?php foreach ($client as $value): ?>
								<tr>
								  <td><?php echo $value['username'] ?></td>
                                                                  <td><?php echo date('Y-m-d',strtotime($value['createdAt'])) ?></td>
								  <td>
								  	<select>
										<option value="0" disabled <?php if ( $value['Status'] == '' ){ echo "selected"; } ?>></option>
										<option value="True" <?php if ( $value['Status'] == '1' ){ echo "selected"; } ?>>Active</option>
										<option value="False" <?php if ( $value['Status'] == '0' ){ echo "selected"; } ?>>Closed</option>
								  	</select>
								  </td>
								  <td><?php echo $value['phone'] ?></td>
								  <td><?php echo $value['email'] ?></td>
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>clients/edit/<?php echo $value['objectId']; ?>">Edit</a></td>
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/add_associate_users/<?php echo $value['objectId']; ?>">Add Associate Users</a></td>
								</tr>
							  <?php endforeach; ?>
                                                          </tbody>
							</table>
                                                        <div style="clear:both"></div>
						  <?php endif; ?>
                                                <?php if (isset($associated_setup)): 
                                                      ?>
                                                        <a href="<?php echo base_url(); ?>manage/add_user/<?php echo $client_id; ?>" class="btn btn-small btn-primary menu-button">Add Associated Users</a>
							<?php if(count($associated_user) > 0):?>
                                                        <table>
							  <tr>
								<th>User</th>
								<th>Date Established</th>
								<th>Status</th>
								<th>Phone #</th>
								<th>Email</th>
								<th>Edit</th>
								<th>Delete</th>
							  </tr>
							  <?php foreach ($associated_user as $value): ?>
								<tr>
								  <td><?php echo $value['username'] ?></td>
                                                                  <td><?php echo date('Y-m-d',strtotime($value['createdAt'])) ?></td>
								  <td>
                                                                        <?php if ( $value['Status'] == '1' ){ echo 'Active'; }else{ echo 'Closed'; } ?>
								  </td>
								  <td><?php echo $value['phone'] ?></td>
								  <td><?php echo $value['email'] ?></td>
                                                                  
								  <td><a class=" btn btn-small btn-primary" href="<?php echo base_url(); ?>manage/edit_user/<?php echo $value['objectId']; ?>/<?php echo $client_id; ?>">Edit</a></td>
								</tr>
							  <?php endforeach; ?>
							</table>
                                                        <?php endif; ?>
                                                        <div style="clear:both;height:20px;"></div>
						  <?php endif; ?>
							  <?php if (isset($reset_pw_email)): ?>
							  	<div class="reset-form">
								  	<?php if ( isset( $message ) && $message != '' ): ?>
									<div class="alert alert-success" role="alert">
							  			<?php echo $message; ?>
									</div>
									<?php endif; ?>

									<form action='<?php echo base_url(); ?>manage/reset_pw_send_mail/<?php echo $reset_pw_email; ?>' method='post'>

									  <fieldset>
										<h2>Enter the Administrator Email Address:</h2>
										<span class="block input-icon input-icon-right " >
										  <input type="text" class="span12"  name='username'/>
										</span>
										<?php if ( validation_errors() != "" ) : ?>
										<div class="alert alert-danger" role="alert">
											<?php echo validation_errors(); ?>
										</div>
										<?php endif; ?>
										<br/>
										<div class="row-fluid">
										  <input type="submit" name="reset" value="Reset the Application Administrator Password" class="btn btn-small btn-primary menu-button"></input>
										</div>

									  </fieldset>
									</form>
								</div>
							  <?php endif; ?>

						  <?php if (isset($reset_password_client_form)) : ?>
							<?php if ($key) : ?>

							  <form action='<?php echo base_url(); ?>manage/reset_password_client_form/<?php echo $pram; ?>' method='post' class="reset-form">
								<h2>Enter Your Password:</h2>
								<span class="block input-icon input-icon-right">
								  <input type="password" class="span12"  name='password'/>
								</span>
								<h2>Confirm Your Password:</h2>
								<span class="block input-icon input-icon-right">
								  <input type="password" class="span12"  name='cpassword'/>
								</span>
								<br/>
								<?php if ($message_pw) : ?>
								<div class="alert alert-danger" role="alert">
									Password doesn’t meet criteria... Re-enter your password.
								</div>
							  	<?php endif; ?>
							  	<div class="alert alert-info" role="alert">
								  (A combination of at least one upper case letters and lower case letters, numbers, special characters (optional); 8 - 12 characters)
								</div>
								<div class="row-fluid">
								  <input type="submit" name="submit" value="Reset the Application Administrator Password" class="btn btn-small btn-primary menu-button"></input>

								</div>
							  </form>
							<?php else : ?>
							  The key is not valid
							<?php endif ?>
						  <?php endif ?>
						  <?php if ( isset($back) && !( isset($create_client) ) ): ?>
						  	<?php if ( isset( $statistics ) ): ?>
						  		<div class="clear">
						  		<a href="<?php echo base_url(); ?>manage/review_users" class="btn btn-small btn-primary menu-button">Review Users</a>
							 <?php endif; ?>
							 <?php if(($function_name != "User Statistics") && ($function_name != "Content Manager") && ($function_name != "Deleted Events")){ ?>
							 	<div class="clear" style="text-align:center;">
									<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a>
								</div>
						  	<?php	} ?>
							 
						  <?php endif; ?>

						  <?php if ( isset( $create_client ) ): ?>
							<div>

								<div class="span9">
									<?php if (isset($back)): ?>
									  	<div class="clear" style="text-align:center;"><a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">Console Menu</a></div>
									<?php endif; ?>
								</div>
								<div class="span3">
									<div class="span12">
										<a class=" btn btn-small btn-primary menu-button menu-logout-button menu-button-small" href="<?php echo base_url(); ?>/manage/sqlserver">SQL Server</a>
									</div>
								</div>
							<div>
						  <?php endif?>

					  </div>
					</div><!--/widget-main-->
				  </div><!--/widget-body-->

				</div><!--/login-box-->

			  </div><!--/position-relative-->

			</div>


		  </div>


		</div><!--/span-->
	  </div><!--/row-->
	</div>
  </div><!--/.fluid-container-->


  <!-- basic scripts -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");
  </script>


  <!-- page specific plugin scripts -->


  <!-- inline scripts related to this page -->

 <script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
	
	<script type="text/javascript">		
		
		$('#table_data').DataTable();	

	function show_box(id) {
		$('.widget-box.visible').removeClass('visible');
		$('#' + id).addClass('visible');
	}

	columnChart();
    
    function columnChart(){
        var item = $('.chart', '.column-chart').find('.item'),
        itemWidth = 100 / item.length;
        item.css('width', itemWidth + '%');
        
        $('.column-chart').find('.item-progress').each(function(){
            var itemProgress = $(this),
            itemProgressHeight = $(this).parent().height() * ($(this).data('percent') / 100);
            itemProgress.css('height', itemProgressHeight);
        });
    };

  </script>

</body>
</html>
