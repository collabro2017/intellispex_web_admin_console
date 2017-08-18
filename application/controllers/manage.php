<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include_once('CI_Controller_EX.php');

class manage extends CI_Controller_EX {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_user', '', TRUE);
        $this->load->model('M_client', '', TRUE);
        if ($this->input->post('remember_me')) // set sess_expire_on_close to 0 or FALSE when remember me is checked.
            $this->config->set_item('sess_expire_on_close', '0'); // do change session config
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->library('grocery_CRUD');
        $this->load->library('ParseRestClient');
    }

    public function check_login($data = '', $function_name = ' ') {

        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->function_name = $function_name;
            $data->id = $session_data['id'];
            $data->email = $session_data['email'];
            $this->load->view('default/admin_default', $data);
        } else {
            if ($this->input->post('submit')) {
                //This method will have the credentials validation
                $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

                if ($this->form_validation->run() == FALSE) {
                    //Field validation failed.&nbsp; User redirected to login page
                    $this->load->view('default/include/manage/v_login');
                } else {
                    //Go to private area
                    //redirect('manage', 'refresh');
                    redirect('manage/console_menu', 'refresh');
                    //$this->load->view('default/layout_default');
                }
            }
//    elseif ($this->input->post('reset')) {
//      $this->reset_password();
//    }
            else {
                $this->load->view('default/include/manage/v_login');
                $this->load->helper(array('form'));
            }
        }
    }

    public function check_login1($data = '', $function_name = ' ') {
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->function_name = $function_name;
            $data->id = $session_data['id'];
            $this->load->view('default/admin_default1', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
            $this->load->helper(array('form'));
        }
    }

    public function index() {
        //$this->console_menu();
        $this->home();
    }

    function login() {
        if ($this->input->post('submit')) {
            //This method will have the credentials validation
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

            if ($this->form_validation->run() == FALSE) {
                //Field validation failed.&nbsp; User redirected to login page
                $this->load->view('default/include/manage/v_login');
            } else {
                //Go to private area
                redirect('manage', 'refresh');
                //$this->load->view('default/layout_default');
            }
        }
    }

    function check_database($password) {
        //Field validation succeeded.&nbsp; Validate against database
        $username = $this->input->post('username');
        $role = $this->input->post('role');
        //query the database
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "_User",
                    'query' => '{"email":"' . $username . '"}',
                )
        );
        $users = json_decode(json_encode($temp), true);
        $current_user = $users[0];
        $mongoRolerId = $current_user['user_type']['objectId'];
        $result = $this->M_user->login($username, $password, $mongoRolerId);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    'role' => $role,
                    'email' => $row->email,
                    'mongodb_id' => $current_user['objectId'],
                    'mongodb_role_id' => $row->mongodb_role_id
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            //if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
            $this->session->unset_userdata($key);
            //}
        }
        $this->session->sess_destroy();
        redirect('manage');
    }

    function userstatistics() {
        $data = new stdClass;
        $function_name = "User Statistics";
        $data->back = TRUE;
        $session_data = $this->session->userdata('logged_in');
        $user = $this->parserestclient->query(
                    array(
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"XVr1sAmAQl"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                    )
                );
        $associated_user = json_decode(json_encode($user), true); 
        $userArr = array();
        foreach ($associated_user as $user) {
            $userArr[] = $user['objectId'];
        }
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Event",
                    'query' => '{"TagFriends":{"$all":'.json_encode($userArr,true).'}}',
                )
        );
        $events = json_decode(json_encode($temp), true);
        $fullCount = 0;
        $commentOnly = 0;
        $viewOnly = 0;
        $totalData = 0;
        foreach ($events as $event) {
            if (isset($event['TagFriendAuthorities'])) {
                $TagFriendAuthorities = $event['TagFriendAuthorities'];
                for ($i = 0; $i < count($TagFriendAuthorities); $i++) {
                    if (strpos($TagFriendAuthorities[$i], 'Full') !== false) {
                        $fullCount = $fullCount + 1;
                    } elseif (strpos($TagFriendAuthorities[$i], 'Comment') !== false) {
                        $commentOnly = $commentOnly + 1;
                    } else {
                        $viewOnly = $viewOnly + 1;
                    }
                    $totalData = $totalData+1;
                }
            }
        }
        $data->full = $fullCount;
        $data->commentOnly = $commentOnly;
        $data->viewOnly = $viewOnly;
        $totalEvents = count($events);
        $data->totalData = $totalData;
        if($totalData > 0){
            $data->averageData = ceil($totalData/$totalEvents);
        }
        $this->check_login($data, $function_name);
    }

    function clientmanagementconsole() {
        $session_data = $this->session->userdata('logged_in');
        //var_dump($session_data);exit();
        $role = $session_data['role'];
        $data = new stdClass;
        $function_name = "CLIENT MANAGEMENT CONSOLE";
        $data->links = array('logout' => 'Logout');

        $this->check_login($data, $function_name);
    }

    function clientmanagementconsolesupport() {
        $session_data = $this->session->userdata('logged_in');
        $data = new stdClass;
        $function_name = "SUPPORT REQUEST";

        $this->check_login($data, $function_name);
    }

    function contentmanager() {
        $data = new stdClass;
        $function_name = "Content Manager";
        $data->back = TRUE;
        $this->check_login($data, $function_name);
    }

    public function supportmsg() {
        $session_data = $this->session->userdata('logged_in');
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "test.IntelliSpeX@gmail.com";
        $config['smtp_pass'] = "Test123456789";

        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $ci->email->initialize($config);
        $ci->email->from($this->input->post('emailto'), $session_data['username']);
        $ci->email->to('support@visitechmgmt.zendesk.com');
        $this->email->reply_to($this->input->post('emailto'), $session_data['username']);
        $ci->email->subject($this->input->post('priority'));
        $ci->email->message($this->input->post('des'));

        if ($_FILES['upload']['size'] > 0) { // upload is the name of the file field in the form
            $aConfig['upload_path'] = 'public/images';
            // chmod('public/images', 777);
            $aConfig['allowed_types'] = 'doc|docx|pdf|jpg|png';
            $aConfig['max_size'] = '3000';
            $aConfig['max_width'] = '1280';
            $aConfig['max_height'] = '1024';
            $this->load->library('upload', $aConfig);
            $this->upload->do_upload('upload');
            $ret = $this->upload->data();
            $pathToUploadedFile = $ret['full_path'];
            $this->email->attach($pathToUploadedFile);
        }

        $this->email->send();
//var_dump($this->email->print_debugger());
        $data = new stdClass;
        $function_name = "Content Manager";
        $data->back = TRUE;
        $this->check_login($data, $function_name);
    }

    public function reset_password() {
        if ($this->input->post('reset')) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('default/include/manage/v_reset_password');
            } else {
                try {
                    $temp_pass = md5(uniqid());
                    $email_to_reset = $this->input->post('username');
                    $message = "<p>This email has been sent as a request to reset our password</p>";
                    $message .= "<p><a href='" . base_url() . "manage/reset_password_form/$temp_pass'>Click here </a>if you want to reset your password,
                        if not, then ignore</p>";
                    $ci = get_instance();
                    $ci->load->library('email');
                    $config['protocol'] = "smtp";
                    $config['smtp_host'] = "ssl://smtp.gmail.com";
                    $config['smtp_port'] = "465";
                    $config['smtp_user'] = "test.IntelliSpeX@gmail.com";
                    $config['smtp_pass'] = "Test123456789";
                    $config['charset'] = "utf-8";
                    $config['mailtype'] = "html";
                    $config['newline'] = "\r\n";

                    $ci->email->initialize($config);

                    $ci->email->from('test.IntelliSpeX@gmail.com', 'IntelliSpeX');
                    $list = array($email_to_reset);
                    $ci->email->to($list);
                    $this->email->reply_to('test.IntelliSpeX@gmail.com', 'Explendid Videos');
                    $ci->email->subject('Reset your Password');
                    $ci->email->message($message);
                    $ci->email->send();


                    $this->load->model('m_user');
                    $this->m_user->temp_reset_password($temp_pass, $email_to_reset);

                    if ($ci->email->send()) {
                        $this->load->view('default/include/manage/v_reset_message');
                    } else {
                        $data['message'] = 'Email was not sent, please contact your administrator';
                        $this->load->view('default/include/manage/v_reset_password', $data);
                    }
                } catch (Exception $e) {
                    $this->load->view('default/include/manage/v_reset_password');
                }
            }
        } else {
            $this->load->view('default/include/manage/v_reset_password');
        }
    }

    public function reset_pw($id) {
        $data = new stdClass;
        $function_name = "RESET PASSWORD";
        $data->back = TRUE;
        $data->links = array('reset_pw_email/' . $id => 'Reset the Application Administrator Password');
        $this->check_login($data, $function_name);
    }

    public function reset_pw_email($id) {
        $data = new stdClass;
        $function_name = "RESET CLIENT PASSWORD";
        $data->back = TRUE;
        $data->reset_pw_email = $id;
        $this->check_login($data, $function_name);
    }

    public function reset_pw_send_mail($id) {
        $data = new stdClass;
        $data->reset_pw_email = $id;
        $function_name = "RESET CLIENT PASSWORD";
        $data->back = TRUE;
        $data->message = '';
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data->message = 'Invalid email';
        } else {
            $temp_pass = md5(uniqid());
            $message = "<p>This email has been sent as a request to reset our password</p>";
            $message .= "<p><a href='" . base_url() . "manage/reset_password_client_form/$temp_pass'>Click here </a>if you want to reset your password,
                        if not, then ignore</p>";
            $ci = get_instance();
            $ci->load->library('email');
            $config['protocol'] = "smtp";
            $config['smtp_host'] = "ssl://smtp.gmail.com";
            $config['smtp_port'] = "465";
            $config['smtp_user'] = "test.IntelliSpeX@gmail.com";
            $config['smtp_pass'] = "Test123456789";
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";

            $ci->email->initialize($config);

            $ci->email->from('test.IntelliSpeX@gmail.com', 'IntelliSpeX');
            $list = array($this->input->post('username'));
            $ci->email->to($list);
            $this->email->reply_to('test.IntelliSpeX@gmail.com', 'Explendid Videos');
            $ci->email->subject('Reset your Password');
            $ci->email->message($message);
            //$ci->email->send();

            if ($ci->email->send()) {
                $this->load->model('m_user');
                if ($this->m_user->temp_reset_client_password($temp_pass, $id)) {
                    $data->message = "SUCCESS!!! The Password Reset link has been sent to the administrator Email";
                }
            } else {
                $data->message = "Email was not sent, please contact your administrator";
            }

            //$this->load->view('default/include/manage/v_reset_message');
        }
        $this->check_login($data, $function_name);
    }

    public function reset_password_form($temp_pass) {
        $data['pram'] = $temp_pass;
        $data['message'] = '';
        $sucess = FALSE;
        $this->load->model('m_user');
        if ($this->m_user->is_temp_pass_valid($temp_pass)) {
            $data['key'] = TRUE;
            //once the user clicks submit $temp_pass is gone so therefore I can't catch the new password and   //associated with the user...
        } else {
            $data['key'] = FALSE;
            echo "the key is not valid";
        }
        if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|callback_check_password');
            if ($this->form_validation->run()) {
                $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
                if ($this->form_validation->run()) {
                    $this->load->model('m_user');
                    if ($this->m_user->reset_password($temp_pass)) {
                        $sucess = TRUE;
                        redirect('manage', 'refresh');
                    }
                } else {
                    $data['message'] = "Password does not match";
                }
            } else {
                $data['message'] = "A combination of at least one upper case letters, lower case letters, numbers, special characters; 8 - 12 characters";
            }
        }
        if (!$sucess)
            $this->load->view('default/include/manage/v_reset_password_form', $data);
    }

    public function reset_password_client_form($temp_pass) {
        $data = new stdClass;
        $function_name = "RESET CLIENT PASSWORD";
        $data->back = TRUE;
        $data->reset_password_client_form = TRUE;
        $data->pram = $temp_pass;
        $data->message_pw = '';
        $sucess = FALSE;
        $this->load->model('m_user');
        if ($this->m_user->is_client_pass_valid($temp_pass)) {
            $data->key = TRUE;
            //once the user clicks submit $temp_pass is gone so therefore I can't catch the new password and   //associated with the user...
        } else {
            $data->key = FALSE;
        }
        if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|callback_check_password');
            if ($this->form_validation->run()) {
                $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
                if ($this->form_validation->run()) {
                    $this->load->model('m_user');
                    if ($this->m_user->reset_client_password($temp_pass)) {
                        $sucess = TRUE;
                        $data->message = "SUCCESS!!! Your password has been reset";
                    }
                } else {
                    $data->message_pw = "Password does not match";
                }
            } else {
                $data->message_pw = "A combination of at least one upper case letters, lower case letters, numbers, special characters; 8 - 12 characters";
            }
        }
        $this->check_login($data, $function_name);
    }

    public function update_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|callback_check_password');
        if ($this->form_validation->run()) {
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
            if ($this->form_validation->run()) {
                echo "Passwords match";
            } else {
                $this->load->view('default/include/manage/v_login');
            }
        } else {
            echo "A combination of at least one upper case letters, lower case letters, numbers, special characters; 8 - 12 characters";
        }
    }

    function check_email() {
        //Field validation succeeded.&nbsp; Validate against database
        $username = $this->input->post('username');
        //query the database

        if ($row = $query->row()) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_email', 'Invalid email');
            return FALSE;
        }
    }

    function check_password() {
        $pass = $this->input->post('password');
        return (bool) preg_match('/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,12}$/', $pass);
    }

    public function console_menu() {
        $session_data = $this->session->userdata('logged_in');
        //var_dump($session_data);exit();
        $role = $session_data['role'];

//    print_r($users);exit;
//    $date = date(DateTime::ISO8601, time());
//    foreach ($users as $user){
//        print_r($user);continue;
//        print_r($this->parserestclient->update
//        (
//                array
//                (
//                        "objectId" => "_User",
//                        'object' => [ 'updatedAt' =>  [
//                                        "__type" => "Date",
//                                        "iso" => $date, 
//                                       ],'user_type' => [
//                                        "__type" => "Pointer",
//                                        "className" =>"_Role",
//                                        "objectId" => "XVr1sAmAQl"
//                                        ] ],
//					'where' => $user['objectId']
//                        )
//        ));
//    }
//    exit;
        $data = new stdClass;
        if ($role == 1) {
            $function_name = "CLIENT ADMINISTRATOR CONSOLE MENU";
            $data->links = array('c_dashboard' => 'Client Management Dashboard', 'client_set_up' => 'User Set Up / Upload / Editing',
                'set_up_management' => 'Activity Set Up and Management', 'user_data_management' => 'User Data Management and Export',
                'logout' => 'Logout');
        } else if ($role == 2) {
            $function_name = "APPLICATION ADMINISTRATOR CONSOLE MENU";
            $data->links = array('dashboard' => 'Management Dashboard', 'client_set_up' => 'Client Set Up/ Upload / Editing',
                'activity_setup_management' => 'Activity Setup and Management', 'user_data_management' => 'User Data Management and Export',
                'console_manager' => 'Console Manager', 'app_administrator_user' => 'Users', 'manage_report_content' => 'Mange Reported Content', 'logout' => 'Logout');
        } else {
            $function_name = "CLIENT MANAGEMENT CONSOLE";
            $data->links = array('logout' => 'Logout');
        }
        $this->check_login($data, $function_name);
    }

    public function activity_setup_management() {
        
    }

    public function user_data_management() {
        
    }

    public function console_manager() {
        
    }

    public function app_administrator_user() {
        
    }

    public function manage_report_content() {
        
    }

    public function dashboard() {
        $data = new stdClass;
        $function_name = "APPLICATION ADMINISTRATOR - DASHBOARD";
        $data->back = TRUE;
        $admin = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"aDiZnlW1AX"}}',
                        )
                    );
         $users = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null}',
                            'count' => '1',
                            'limit' => '1000000'
                        )
                    );
        $data->admin_count = count($admin);
        $data->user_count = count($users)-$data->admin_count;
        $data->statistics = "Global Application Statistics";
        $this->check_login($data, $function_name);
    }

    public function c_dashboard() {
        $data = new stdClass;
        $function_name = "CLIENT MANAGEMENT DASHBOARD";
        $data->back = TRUE;
        $data->statistics = "Usage Statistics";
        $this->check_login($data, $function_name);
    }

    public function client_set_up() {
        $session_data = $this->session->userdata('logged_in');
        $data = new stdClass;
        $function_name = "APPLICATION ADMINISTRATOR - CLIENT SET UP AND MAINTENANCE";
        $data->back = TRUE;
        if(isset($session_data['role'])){
            $data->role =  $session_data['role'];
        }
        $data->links = array('create_client' => 'Create a Client', 'edit_client' => 'Manage / Edit a Client', 'events' => 'View or Edit Global Event List', 'logout' => 'Logout');
        $this->check_login($data, $function_name);
    }
    
    public function review_users() {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data){
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "Review User";
            $user = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"XVr1sAmAQl"}}',
                        'limit' => '1000000',
                        'order' => '-Status'
                    )
            );
            $data->associated_user = json_decode(json_encode($user), true); 
            $data->back = TRUE;
            $data->associated_setup = TRUE;
            $data->role = $session_data['role'];
            $this->load->view('default/users/review', $data);
        }else{
            $this->load->view('default/include/manage/v_login');
        }
    }
    public function add_user($client_id) {

        $data = new stdClass;
        $this->load->model('m_user');
        $function_name = "ADD ASSOCIATED USER";
        $data->back = TRUE;
        $data->create_associated_user = TRUE;
        $data->message = '';
        
        $data->client_id = $client_id;
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'User Name', 'required|trim');
            if ($this->form_validation->run()) {
                $name = $this->input->post('name');
                $Firstname = $this->input->post('Firstname');
                $LastName = $this->input->post('LastName');
                $Gender = $this->input->post('Gender');
                $company = $this->input->post('company');
                $country = $this->input->post('country');
                $address1 = $this->input->post('address1');
                $password = $this->input->post('password');
                $city = $this->input->post('city');
                $province = $this->input->post('province');
                $postal = $this->input->post('postal');
                $phone = $this->input->post('phone_number');
                $mobile = $this->input->post('mobile');
                $email = $this->input->post('email');
                $client_mongo_role = $this->m_user->getMongoRoleById(3);
                $client_mongo_role = $client_mongo_role->mongodb_role_id;
                $session_data = $this->session->userdata('logged_in');
                $mongodb_id = $session_data['mongodb_id'];
                $date = date(DateTime::ISO8601, time());
                $response = $this->parserestclient->create
                        (
                        array
                            (
                            "objectId" => "_User",
                            'object' => ['username' => "$name", 'password' => "$password", 'email' => "$email", 'email' => "$email",
                                'Firstname' => "$Firstname",
                                'LastName' => "$LastName",
                                'Gender' => "$Gender",
                                'company' => "$company",
                                'country' => "$country",
                                'phone' => "$phone",
                                'loginType' => 'email',
                                'telephone' => "$phone",
                                'emailVerified' => TRUE,
                                'city' => "$city",
                                'zipcode' => "$postal",
                                'phone' => "$mobile",
                                'state' => "$province",
                                'Status' => true,
                                'createdAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ], 'user_type' => [
                                    "__type" => "Pointer",
                                    "className" => "_Role",
                                    "objectId" => "XVr1sAmAQl"
                                ], 'created_by' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$mongodb_id"
                                ], 'associated_with' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$client_id"
                                ]]
                        )
                );
                if (isset($response->objectId))
                    if($session_data['role'] == 3){
                        redirect('/manage/user_management/', 'refresh');
                    }else{
                        redirect('/manage/add_associate_users/'.$client_id, 'refresh');
                    }
//                    $data->message = "Create sucessfully";
                else
                    if($response == -1){
                        $data->message = $_SESSION['error'];
                    }
            }
        }
        $this->check_login($data, $function_name);
    }
    
    
    
    public function userdelete(){
        $deletelist = $this->input->post('deletelist');
        $date = date('Y-m-d');
        foreach($deletelist as $val){
            //$data = array('deletedAt' => '2017-07-03T00:00:00','objectId'=>$val);
            $this->parserestclient->update
            (
                array
                (
                    "objectId" => "_User",
                    'object' => [ 'deletedAt' => "$date"],
                            'where' => $val
                )
            );
        }
    }
    
    public function userenable(){
        $deletelist = $this->input->post('deletelist');
        $date = date('Y-m-d');
        foreach($deletelist as $val){
            //$data = array('deletedAt' => '2017-07-03T00:00:00','objectId'=>$val);
            $this->parserestclient->update
            (
                array
                (
                    "objectId" => "_User",
                    'object' => [ 'Status' => true],
                            'where' => $val
                )
            );
        }
    }
    
    public function useredisable(){
        $deletelist = $this->input->post('deletelist');
        $date = date('Y-m-d');
        foreach($deletelist as $val){
            //$data = array('deletedAt' => '2017-07-03T00:00:00','objectId'=>$val);
            $this->parserestclient->update
            (
                array
                (
                    "objectId" => "_User",
                    'object' => [ 'Status' => false],
                            'where' => $val
                )
            );
        }
    }
    
    public function edit_user($user_id,$client_id) {
        $session_data = $this->session->userdata('logged_in');
        $mongodb_id = $session_data['mongodb_id'];
        $this->load->model('m_user');
        $client_mongo_role = $this->m_user->getMongoRoleById(3);
        $client_mongo_role = $client_mongo_role->mongodb_role_id;
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "_User",
                    'query' => '{"objectId":"'.$user_id.'"}',
                )
        );
        $data = new stdClass;
        $data->client_id = $client_id;
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'User Name', 'required|trim');
            if ($this->form_validation->run()) {
                $name = $this->input->post('name');
                $Firstname = $this->input->post('Firstname');
                $LastName = $this->input->post('LastName');
                $Gender = $this->input->post('Gender');
                $company = $this->input->post('company');
                $country = $this->input->post('country');
                $address1 = $this->input->post('address1');
                $password = $this->input->post('password');
                $city = $this->input->post('city');
                $province = $this->input->post('province');
                $postal = $this->input->post('postal');
                $phone = $this->input->post('phone_number');
                $mobile = $this->input->post('mobile');
                $email = $this->input->post('email');
                $client_mongo_role = $this->m_user->getMongoRoleById(3);
                $client_mongo_role = $client_mongo_role->mongodb_role_id;
                $date = date(DateTime::ISO8601, time());
                $response = $this->parserestclient->update
                        (
                        array
                            (
                            "objectId" => "_User",
                            'object' => ['username' => "$name", 'password' => "$password", 'email' => "$email", 'email' => "$email",
                                'Firstname' => "$Firstname",
                                'LastName' => "$LastName",
                                'Gender' => "$Gender",
                                'company' => "$company",
                                'country' => "$country",
                                'phone' => "$phone",
                                'loginType' => 'email',
                                'telephone' => "$phone",
                                'emailVerified' => TRUE,
                                'city' => "$city",
                                'zipcode' => "$postal",
                                'phone' => "$mobile",
                                'state' => "$province",
                                'Status' => true,
                                'createdAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ], 'user_type' => [
                                    "__type" => "Pointer",
                                    "className" => "_Role",
                                    "objectId" => "XVr1sAmAQl"
                                ], 'created_by' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$mongodb_id"
                                ], 'associated_with' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$client_id"
                                ]],
                                'where' => $user_id
                        )
                );
                if (isset($response->updatedAt))
                    if($session_data['role'] == 3){
                        redirect('/manage/user_management/', 'refresh');
                    }else{
                        redirect('/manage/add_associate_users/'.$client_id, 'refresh');
                    }
                else
                    $data->message = "Updated have issues";
            }
        }
        $function_name = "Edit Associated User";
        $data->user = json_decode(json_encode($temp), true); //$client;
        $data->back = TRUE;
        $data->edit_associated_user = TRUE;
        $this->check_login($data, $function_name);
    }
    public function add_associate_users($id) { 
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data){
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "Client View: User Management";
            $user = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"XVr1sAmAQl"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $id . '"}}',
                    )
            );
            $data->associated_user = json_decode(json_encode($user), true); 
            $user_group = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "user_group",
                        'query' => '{"created_by":{"__type":"Pointer","className":"_User","objectId":"' . $id . '"}}',
                    )
            );
            $data->user_group = json_decode(json_encode($user_group), true); 
            $data->back = TRUE;
            $data->associated_setup = TRUE;
            $data->client_id = $id;
            $data->role = $session_data['role'];
            $this->load->view('default/users/list', $data);
        }else{
            $this->load->view('default/include/manage/v_login');
        }
//        $this->check_login($data, $function_name);
    }
    
    public function create_grpup($client_id){
        $group_name = $this->input->post('group_name');
        $access_rights = $this->input->post('access_rights');
        $users = $this->input->post('users');        
        $session_data = $this->session->userdata('logged_in');
        $mongodb_id = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        $response = $this->parserestclient->create
                        (
                        array
                            (
                            "objectId" => "user_group",
                            'object' => ['group_name' => "$group_name", 'access_rights' => "$access_rights",
                                'createdAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ], 'users' => [
                                    "__op" => "AddUnique",
                                    "objects" => $users
                                ], 'created_by' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$mongodb_id"
                                ], 'client_id' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$client_id"
                                ]]
                        )
                );
        if($session_data['role'] == 3){
            redirect('/manage/user_management/', 'refresh');
        }else{
            redirect('/manage/add_associate_users/'.$client_id, 'refresh');
        }
    }

    public function user_management() {
        
        $session_data = $this->session->userdata('logged_in');
        $mongodb_id = $session_data['mongodb_id'];
        $this->add_associate_users($mongodb_id);
    }
    
    public function edit($id) {
        $this->load->model('m_user');
        $this->load->model('m_client');
        $data = new stdClass;
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "_User",
                    //'query'=>'{"deletedAt":null, "createdAt":{"$gt":"'.$date.'"}}',
                    'query' => '{"objectId":"' . $id . '"}',
                )
        );
        $data->client_data = json_decode(json_encode($temp), true); // $this->m_client->get_client($id);
        $function_name = "EDIT CLIENT PROFILE";
        $data->back = TRUE;
        $data->edit_client = TRUE;
        $data->message = '';
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'Client Name', 'required|trim');
            if ($this->form_validation->run()) {
                $name = $this->input->post('name');
                $address1 = $this->input->post('address1');
                $password = $this->input->post('password');
                $city = $this->input->post('city');
                $province = $this->input->post('province');
                $postal = $this->input->post('postal');
                $phone = $this->input->post('phone_number');
                $telephone = $this->input->post('telephone');
                $mobile = $this->input->post('mobile');
                $email = $this->input->post('email');
                $client_mongo_role = $this->m_user->getMongoRoleById(3);
                $client_mongo_role = $client_mongo_role->mongodb_role_id;
                $session_data = $this->session->userdata('logged_in');
                $mongodb_id = $session_data['mongodb_id'];
                $date = date(DateTime::ISO8601, time());
                $response = $this->parserestclient->update
                        (
                        array
                            (
                            "objectId" => "_User",
                            'object' => ['username' => "$name", 'email' => "$email", 'email' => "$email",
                                'phone' => "$phone",
                                'loginType' => 'email',
                                'telephone' => "$telephone",
                                'emailVerified' => TRUE,
                                'city' => "$city",
                                'zipcode' => "$postal",
                                'phone' => "$mobile",
                                'state' => "$province",
                                'Status' => true,
                                'updatedAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ], 'user_type' => [
                                    "__type" => "Pointer",
                                    "className" => "_Role",
                                    "objectId" => "$client_mongo_role"
                                ], 'created_by' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$mongodb_id"
                                ]],
                                'where' => $id
                        )
                );
                if (isset($response->updatedAt)) {
                    $data->message = "Edit sucessfully";
                    redirect('manage/edit/' . $id, 'refresh');
                } else{
                    if($response == -1){
                        $data->message = $_SESSION['error'];
                    }
                }
            }
        }
        $this->check_login($data, $function_name);
    }
    
    
    public function edit_client() {
        $this->load->model('m_user');
        $client_mongo_role = $this->m_user->getMongoRoleById(3);
        $client_mongo_role = $client_mongo_role->mongodb_role_id;
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "_User",
                    //'query'=>'{"deletedAt":null, "createdAt":{"$gt":"'.$date.'"}}',
                    'query' => '{"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $client_mongo_role . '"}}',
                )
        );
        $data = new stdClass;
        $function_name = "MANAGE CLIENTS";
        $this->load->model('m_client');
        $data->client = json_decode(json_encode($temp), true); //$client;
        $data->back = TRUE;
        $data->client_setup = TRUE;
        $this->check_login($data, $function_name);
    }
    
    public function events() {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "VIEW OR EDIT GLOBAL EVENT LIST";
            $this->load->view('default/events/list', $data);
        } else {
            $this->check_login();
        }
    }

    public function event($event_id) {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "EVENT VIEWER";
            $data->event_id = $event_id;
            $this->load->view('default/events/view', $data);
        } else {
            $this->check_login();
        }
    }

    //-------------------------------------------------------------------//


    public function management_team() {
        $this->load->view('default/include/manage/v_management_team2');
    }

    public function management_support() {
        $this->load->view('default/include/manage/v_management_support');
    }

    public function home() {
        $this->load->view('default/include/manage/v_home2');
    }

}

?>
