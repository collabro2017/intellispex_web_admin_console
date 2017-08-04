<html lang="en">
	<head>		
		<link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />	
	</head>
	<?php $this->load->view('default/head/console_page.php'); ?>
	<body class="login-layout admin-body">
	<?php $this->load->view('default/nav/console_page.php'); ?>
    <style>
        .menu-button {
            min-width: 300px;
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>
  	
	<div class="container-fluid" id="main-container">
        
		<div id="main-content">
        <div class="span5"><br><br><br><br>
            <table>
                <tr><td>Creator</td><td><?php echo $event[0]['username'] ?></td></tr>
                <tr><td>Data Created</td><td><?php echo $event[0]['createdAt'] ?></td></tr>
                <tr><td>Time Created</td><td><?php echo $event[0]['createdAt'] ?></td></tr>
                <tr><td>Number of Participants</td><td><?php if(isset($event[0]['commenters'])) { echo count($event[0]['commenters']); }else{ echo 0; } ?></td></tr>
                <tr><td>Tagged Users</td><td><?php echo count(implode(",",$event[0]['TagFriends'])) ?></td></tr>
                <tr><td>Location</td><td><?php  ?></td></tr>
            </table>
            <br><br>
            <table>
                <tr><td>Number of Activity Sheets</td><td><?php echo count($eventActivity); ?></td></tr>
                <tr><td>Title of Activity Sheet</td><td><?php echo $event[0]['eventname'] ?></td></tr>
                <tr><td>Description</td><td>none<?php //echo $event[0]['description'] ?></td></tr>
            </table>
            <?php
            if(count($eventActivity) > 0){
            $halfActivity = ceil(((count($eventActivity))/2));
            $halfActivity = $halfActivity-1;
            ?>
            <table>
                <?php for($i = 0; $i < $halfActivity; $i++){ ?>
                    <tr><td>Activity Sheet <?php echo $i+1; ?></td><td>&nbsp;</td></tr>
                    <tr><td>Date</td><td><?php echo date('Y-m-d',time($eventActivity[0]['createdAt'])); ?></td></tr>
                    <tr><td>Time</td><td><?php echo date('g:i A',time($eventActivity[0]['createdAt'])); ?></td></tr>
                    <tr><td>Title</td><td><?php echo $eventActivity[0]['title']; ?></td></tr>
                    <tr><td>Desctiption</td><td><?php echo $eventActivity[0]['description']; ?></td></tr>
                <?php } ?>
            </table>
            <?php 
            }
            ?>
        </div>
        <div class="span5"><br><br><br><br>
            <?php if(count($eventActivity) > 0){ ?>
            <table>
                <?php for($i = $halfActivity; $i < count($eventActivity); $i++){ ?>
                    <tr><td>Activity Sheet <?php echo $i+1; ?></td><td>&nbsp;</td></tr>
                    <tr><td>Date</td><td><?php echo date('Y-m-d',time($eventActivity[0]['createdAt'])); ?></td></tr>
                    <tr><td>Time</td><td><?php echo date('g:i A',time($eventActivity[0]['createdAt'])); ?></td></tr>
                    <tr><td>Title</td><td><?php echo $eventActivity[0]['title']; ?></td></tr>
                    <tr><td>Desctiption</td><td><?php echo $eventActivity[0]['description']; ?></td></tr>
                <?php } ?>
            </table>
            <?php } ?>
        </div>
        <div class="span2"><br><br><br><br>
            <button onclick="window.print();" class="btn btn-small btn-primary menu-button">Export</button><br><br>
            <button onclick="" class="btn btn-small btn-primary menu-button">Save</button><br><br>
            <button onclick="" class="btn btn-small btn-primary menu-button">Analyse</button><br><br>
            <button onclick="" class="btn btn-small btn-primary menu-button">Select Metadata</button><br><br>
        </div>
    </div>
