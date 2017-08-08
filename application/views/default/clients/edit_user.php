<!DOCTYPE html>
<html lang="en">
    <head>		
        <link href="<?php echo base_url('public') ?>/css/datatable.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .row-fluid [class*="span"]:first-child {
                text-align: left !important;
            }
            [class*="span"] {
                float: left;
                min-height: 1px;
                margin-right: 30px !important;
                margin-left: 0px !important;
            }
        </style>


    </head>
    <?php $this->load->view('default/head/console_page.php'); ?>
<body class="login-layout admin-body">
    <?php $this->load->view('default/nav/console_page.php'); ?>

    <div class="container" id="main-container" style="margin-top: 100px;"> 
        <div id="main-content">
            <div class="row" style="margin-top:20px;">
                <div class="span9">
                    
                    <form action='<?php echo base_url(); ?>clients/edit_user/<?php if (isset($user[0]['objectId'])): echo $user[0]['objectId']; endif; ?>/<?php if(isset($client_id)){ echo $client_id; }?>' method='post' style="margin-bottom:0">
                    <table class="table table-striped create-client-table" style="margin: 0px;max-width: 85%;"><tr>
                        <th>First Name</th>
                        <th><input type="text" class="span4" name='Firstname' <?php if (isset($user[0]['Firstname'])): ?> value="<?php echo $user[0]['Firstname']; ?>" <?php endif; ?>/></th>
                    </tr><tr>
                        <th>Last Name</th>
                        <th><input type="text" class="span4" name='LastName' <?php if (isset($user[0]['LastName'])): ?> value="<?php echo $user[0]['LastName']; ?>" <?php endif; ?>/></th>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <th>
                            <select name="Gender">
                                <option <?php if (isset($user[0]['Gender'])): if ($user[0]['Gender'] == 'male') {
                        echo 'selected';
                    } endif; ?>  value="male">Male</option>
                                <option <?php if (isset($user[0]['Gender'])): if ($user[0]['Gender'] == 'female') {
                        echo 'selected';
                    } endif; ?> value="female">Fe-Male</option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <th><input type="text" class="span4" name='company' <?php if (isset($user[0]['company'])): ?> value="<?php echo $user[0]['company']; ?>" <?php endif; ?>/></th>
                    </tr>
                    <tr>
                        <th>User Name</th>
                        <th><input type="text" class="span4" name='name' <?php if (isset($user[0]['username'])): ?> value="<?php echo $user[0]['username']; ?>" <?php endif; ?>/></th>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" class="span4" name='email'<?php if (isset($user[0]['email'])): ?> value="<?php echo $user[0]['email']; ?>" <?php endif; ?>/></td>
                    </tr>
                    <?php if (isset($create_associated_user)): ?>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" class="span4" name='password'<?php if (isset($user[0]['password'])): ?> value="<?php echo $user[0]['password']; ?>" <?php endif; ?>/></td>
                        </tr>
<?php endif; ?>
<!--										<tr>
                      <td>Location</td>
                      <td><input type="text" class="span4" name='address1'<?php if (isset($user[0]['address1'])): ?> value="<?php echo $user[0]['address1']; ?>" <?php endif; ?>/></td>
                    </tr>-->
                    <tr>
                        <th>Country</th>
                        <th><input type="text" class="span4" name='country' <?php if (isset($user[0]['country'])): ?> value="<?php echo $user[0]['country']; ?>" <?php endif; ?>/></th>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><input type="text" class="span4" name='city'<?php if (isset($user[0]['city'])): ?> value="<?php echo $user[0]['city']; ?>" <?php endif; ?>/></td>
                    </tr>
                    <tr>
                        <td>Province / State</td>
                        <td><input type="text" class="span4" name='province'<?php if (isset($user[0]['state'])): ?> value="<?php echo $user[0]['state']; ?>" <?php endif; ?>/></td>
                    </tr>
                    <tr>
                        <td>Postal Code</td>
                        <td><input type="text" class="span4" name='postal'<?php if (isset($user[0]['zipcode'])): ?> value="<?php echo $user[0]['zipcode']; ?>" <?php endif; ?>/></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><input type="text" class="span4" name='phone_number'<?php if (isset($user[0]['telephone'])): ?> value="<?php echo $user[0]['telephone']; ?>" <?php endif; ?>/></td>
                    </tr>
                    <tr>
                        <td>Mobile Phone</td>
                        <td><input type="text" class="span4" name='mobile'<?php if (isset($user[0]['phone'])): ?> value="<?php echo $user[0]['phone']; ?>" <?php endif; ?>/></td>
                    </tr>
<!--										<tr>
                      <td>Date Created</td>
                      <td><input type="date" class="span4" name='created'<?php if (isset($user[0]['created'])): ?> value="<?php echo $user[0]['created']; ?>" <?php endif; ?>/></td>
                    </tr>
                    <tr>
                      <td>Date Modified</td>
                      <td><input type="date" class="span4" name='updated'<?php if (isset($user[0]['updated'])): ?> value="<?php echo $user[0]['updated']; ?>" <?php endif; ?>/></td>
                    </tr>-->
                    <tr>
                        <td colspan="2"><input class="btn btn-small btn-primary" style="float:left;" type="submit" name="submit" value="Submit" class=" btn btn-small btn-primary menu-button"></input></td>
                    </tr>
                </table>
        </form>
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
            <div class="span2">
                <a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/logout">Logout</a>
                <div class="clear"></div>
                <a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/scan">Scan Business Card</a>
                <div class="clear"></div>
                <a class=" btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>/manage/upload">Upload Doc</a>
                <div class="clear"></div>
            </div>


        </div>
    </div>
        </div>
<?php $this->load->view('default/footer/console_page.php'); ?>
    <script src="<?php echo base_url('public') ?>/js/datatable.js"></script>
</body>
</html>
