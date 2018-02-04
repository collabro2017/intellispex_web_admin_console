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
                    } endif; ?> value="female">Female</option>
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
                        <tr>
                            <td>Password</td>
                            <td><input type="password" class="span4" name='password'<?php if (isset($user[0]['password'])): ?> value="<?php echo $user[0]['password']; ?>" <?php endif; ?>/></td>
                        </tr>
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
                </table>