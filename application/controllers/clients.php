<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include_once('CI_Controller_EX.php');

class Clients extends CI_Controller_EX {

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

    public function create() {

        $data = new stdClass;
        $this->load->model('m_user');
        $function_name = "CREATE CLIENT";
        $data->back = TRUE;
        $data->create_client = TRUE;
        $data->message = '';
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->function_name = $function_name;
            $data->id = $session_data['id'];
            $data->email = $session_data['email'];
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('name', 'Client Name', 'required|trim');
                if ($this->form_validation->run()) {
                    $client['name'] = $this->input->post('name');
                    $client['password'] = md5($this->input->post('password'));
                    $client['username'] = $this->input->post('email');
                    $client['phone_number'] = $this->input->post('phone_number');
                    $client['email'] = $this->input->post('email');
                    $client['user_type'] = 3;
                    $client['active'] = 1;
                    $name = $this->input->post('name');
                    $address1 = $this->input->post('address1');
                    $password = $this->input->post('password');
                    $city = $this->input->post('city');
                    $province = $this->input->post('province');
                    $postal = $this->input->post('postal');
                    $phone = $this->input->post('phone_number');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $client_mongo_role = $this->m_user->getMongoRoleById(3);
                    if(base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/'){
                        $client_mongo_role = $client_mongo_role->mongodb_role_id;
                    }else{
                        $client_mongo_role = $client_mongo_role->live_mangodb_role_id;
                    }
                    $session_data = $this->session->userdata('logged_in');
                    $mongodb_id = $session_data['mongodb_id'];
                    $date = date(DateTime::ISO8601, time());
                    $response = $this->parserestclient->create
                            (
                            array
                                (
                                "objectId" => "_User",
                                'object' => ['username' => "$name", 'password' => "$password", 'email' => "$email", 'email' => "$email",
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
                                        "objectId" => "$client_mongo_role"
                                    ], 'created_by' => [
                                        "__type" => "Pointer",
                                        "className" => "_User",
                                        "objectId" => "$mongodb_id"
                                    ]]
                            )
                    );
                    if ($response === -1) {
                        $data->message = $_SESSION['error'];
                    } else {
                        $this->m_user->save($client);
                        $objectId = $response->objectId;
                        redirect('clients/edit/' . $objectId, 'refresh');
                    }
                }
            }
            $this->load->view('default/clients/create', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function edit($id) {
        $this->load->model('m_user');
        $this->load->model('m_client');
        $session_data = $this->session->userdata('logged_in');
        $data = new stdClass;
        if ($session_data) {
            $function_name = "EDIT CLIENT PROFILE";
            $data->back = TRUE;
            $data->edit_client = TRUE;
            $data->message = '';
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->function_name = $function_name;
            $data->id = $session_data['id'];
            $data->email = $session_data['email'];
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
                    if(base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/'){
                        $client_mongo_role = $client_mongo_role->mongodb_role_id;
                    }else{
                        $client_mongo_role = $client_mongo_role->live_mangodb_role_id;
                    }
                    $session_data = $this->session->userdata('logged_in');
                    $mongodb_id = $session_data['mongodb_id'];
                    $date = date(DateTime::ISO8601, time());
                    if($password !== ''){
                        $this->m_user->update_pass_email($password,$email);
                    }
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
                    } else
                        $data->message = "Edit false";
                }
            }
            if(base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/'){
                $regular_user = 'XVr1sAmAQl';
            }else{
                $regular_user = 'Di56R0ITXB';
            }
            $user = $this->parserestclient->query(
                    array(
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"'.$regular_user.'"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $id . '"}}',
                    )
            );
            $data->associated_user = json_decode(json_encode($user), true);
            $this->load->view('default/clients/create', $data);
        }else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function add_user($client_id) {
        $session_data = $this->session->userdata('logged_in');
        $data = new stdClass;
        if ($session_data) {
            $this->load->model('m_user');
            $function_name = "ADD ASSOCIATED USER";
            $data->back = TRUE;
            $data->create_associated_user = TRUE;
            $data->message = '';
            
            $email = $this->input->post('email');
            $data->client_id = $client_id;
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('name', 'User Name', 'required|trim');
                if ($this->form_validation->run()) {
                    $response = $this->m_user->create_client_user($client_id);
                    if (isset($response->objectId)) {
                        if ($session_data['role'] == 3) {
                            redirect('/manage/user_management/', 'refresh');
                        } else {
                            redirect('clients/edit/' . $client_id, 'refresh');
                        }
                        //                    $data->message = "Create sucessfully";
                    } else {
                        $temp = $this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "_User",
                                    'query' => '{"email":"' . $email . '"}',
                                )
                        );
                        $user = json_decode(json_encode($temp), true);
                        if (isset($user[0]['email'])) {
                            $response = $this->m_user->edit_client_user($client_id,$user[0]['objectId']);
                        }
                        if($response == -1){
                            $data->message = $_SESSION['error'];
                        }
//                        $data->message = "Create false";
                    }
                }
            }
            redirect('clients/edit/' . $client_id, 'refresh');
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function edit_user($user_id, $client_id) {
        $session_data = $this->session->userdata('logged_in');
        $data = new stdClass;
        $function_name = "Edit Associated User";
        if ($session_data) {
            $data->back = TRUE;
            $data->edit_client = TRUE;
            $data->message = '';
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->function_name = $function_name;
            $data->id = $session_data['id'];
            $data->email = $session_data['email'];
            $this->load->model('m_user');
            $client_mongo_role = $this->m_user->getMongoRoleById(3);
            if(base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/'){
                $client_mongo_role = $client_mongo_role->mongodb_role_id;
            }else{
                $client_mongo_role = $client_mongo_role->live_mangodb_role_id;
            }
            $temp = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "_User",
                        'query' => '{"objectId":"' . $user_id . '"}',
                    )
            );
            $data->client_id = $client_id;
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('name', 'User Name', 'required|trim');
                if ($this->form_validation->run()) {
                    $response = $this->m_user->edit_client_user($client_id,$user_id);
                    if (isset($response->updatedAt))
                        if ($session_data['role'] == 3) {
                            redirect('/manage/user_management/', 'refresh');
                        } else {
                            redirect('/clients/edit/' . $client_id, 'refresh');
                        } else
                        $data->message = "Updated have issues";
                }
            }
            $data->user = json_decode(json_encode($temp), true); //$client;
            $data->back = TRUE;
            $data->edit_associated_user = TRUE;
            $this->load->view('default/clients/edit_user', $data);
        }else {
            $this->load->view('default/include/manage/v_login');
        }
    }

}

?>
