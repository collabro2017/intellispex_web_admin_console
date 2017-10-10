<?php

class M_user extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->library('grocery_CRUD');
        $this->load->library('ParseRestClient');
    }

    function login($username, $password, $mongodb_id,$user_type) {
        $this->db->select('res_users.id,user_type, username, email,mongodb_role_id');
        $this->db->from('res_users');
        $this->db->join('res_groups', 'res_groups.id = res_users.user_type', 'left');
        $sanitize_username = $this->db->escape($username);
        $where = "( username=" . $sanitize_username . " OR  email=" . $sanitize_username . ")";
        $this->db->where($where);
        $this->db->where('password', md5($password));
        if(SERVER_LIVE == 0){
            $this->db->where('mongodb_role_id', $mongodb_id);
        }else{
            $this->db->where('live_mangodb_role_id', $mongodb_id);
        }
        $this->db->where('res_users.active', 1);
        $this->db->where('res_users.user_type', $user_type);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getMongoRoleById($id) {
        if(base_url() == 'http://test.intellispex.com/'){
            $this->db->select('mongodb_role_id');
        }else{
            $this->db->select('live_mangodb_role_id');
        }
        $this->db->from('res_groups');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function temp_reset_password($temp_pass, $email_to_reset) {
        $data = array('reset_password' => $temp_pass);

        if ($data) {
            $this->db->where('email', $email_to_reset);
            $this->db->update('res_users', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function temp_reset_client_password($temp_pass, $id) {
        $data = array(
            'reset_password' => $temp_pass);

        if ($data) {
            $this->db->where('id', $id);
            $this->db->update('client', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function reset_password($temp_pass) {
        $data = array(
            'password' => md5($this->input->post('password')),
            'reset_password' => '');
        if ($data) {
            $this->db->where('reset_password', $temp_pass);
            $this->db->update('res_users', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function reset_client_password($temp_pass) {
        $data = array(
            'password' => md5($this->input->post('password')),
            'reset_password' => '');
        if ($data) {
            $this->db->where('reset_password', $temp_pass);
            $this->db->update('client', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function is_temp_pass_valid($temp_pass) {
        $this->db->where('reset_password', $temp_pass);
        $query = $this->db->get('res_users');
        if ($query->num_rows() == 1) {
            return TRUE;
        } else
            return FALSE;
    }

    public function is_client_pass_valid($temp_pass) {
        $this->db->where('reset_password', $temp_pass);
        $query = $this->db->get('client');
        if ($query->num_rows() == 1) {
            return TRUE;
        } else
            return FALSE;
    }

    public function userslist() {
        $this->db->select('*');
        $this->db->from('res_users');
        $this->db->where('active', 1);
        $query = $this->db->get();


        return $query->result_array();
    }

    public function save($data) {
        $this->db->insert('res_users', $data);
    }

    public function create_client_user($client_id) {
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
        if(base_url() == 'http://test.intellispex.com/'){
            $client_mongo_role = $client_mongo_role->mongodb_role_id;
        }else{
            $client_mongo_role = $client_mongo_role->live_mangodb_role_id;
        }
        $session_data = $this->session->userdata('logged_in');

        $mongodb_id = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        if(base_url() == 'http://test.intellispex.com/'){
            $regular_user = 'XVr1sAmAQl';
        }else{
            $regular_user = 'Di56R0ITXB';
        }
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
                            "objectId" => "$regular_user"
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
        return $response;
    }

    public function edit_client_user($client_id, $user_id) {
        $session_data = $this->session->userdata('logged_in');
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
        if(base_url() == 'http://test.intellispex.com/'){
            $client_mongo_role = $client_mongo_role->mongodb_role_id;
        }else{
            $client_mongo_role = $client_mongo_role->live_mangodb_role_id;
        }
        $mongodb_id = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        if(base_url() == 'http://test.intellispex.com/'){
            $regular_user = 'XVr1sAmAQl';
        }else{
            $regular_user = 'Di56R0ITXB';
        }
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
                            "objectId" => "$regular_user"
                        ], 'created_by' => [
                            "__type" => "Pointer",
                            "className" => "_User",
                            "objectId" => "$mongodb_id"
                        ], 'associated_with' => [
                            "__type" => "Pointer",                            "className" => "_User",

                            "className" => "_User",
                            "objectId" => "$client_id"
                        ]],
                    'where' => $user_id
                )
        );
        return $response;
    }

}

?>
