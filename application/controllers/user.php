<?php

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('ParseRestClient');
	}
	public function index()
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );
		if( $session_data )
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];
			$data->function_name = "User";

			$this->load->view( 'user/index' , $data);
		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}
	}

	public function suspended_user()
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );
		if( $session_data )
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];
			$data->function_name = "Suspended User";

			$this->load->view( 'user/suspended_user' , $data);
		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}
	}

	public function ajax_user_datatable_parse(){

		$this->load->library('Jquery_DataTable', $this->input->post() );
		$this->load->model('p_user', 'user', TRUE);
		$dt = new Jquery_DataTable( $this->input->post()  );

		$this->user->setParse( $this->parserestclient );
		$recordsTotal = $this->user->countAll();
		$recordsFiltered = $recordsTotal;

		$resultArray = $this->user->getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName( 0 ), $dt->getOrderDir( 0 ) );

		foreach ($resultArray as &$result){
			if(!isset($result->name)){
				$result->name='';
			}
			if(!isset($result->LastName)){
				$result->LastName='';
			}
			if(!isset($result->Gender)){
				$result->Gender='';
			}
			if(!isset($result->City )){
				$result->City ='';
			}
			if(!isset($result->State )){
				$result->State ='';
			}
			if(!isset($result->zipcode )){
				$result->zipcode ='';
			}
			if(!isset($result->email )){
				$result->email ='';
			}
			if(!isset($result->email )){
				$result->email ='';
			}
			if(!isset($result->company )){
				$result->company ='';
			}
			if(!isset($result->phone )){
				$result->phone ='';
			}
			if(!isset($result->country )){
				$result->country ='';
			}
		}

		echo $dt->getJsonResponseJsonData( $recordsTotal, $recordsFiltered, json_encode( $resultArray ) );
		exit;
	}

	public function ajax_suspended_user_datatable_parse(){

		$this->load->library('Jquery_DataTable', $this->input->post() );
		$this->load->model('p_user', 'user', TRUE);
		$dt = new Jquery_DataTable( $this->input->post()  );

		$this->user->setParse( $this->parserestclient );
		$recordsTotal = $this->user->countAllSuspendedUser();
		$recordsFiltered = $recordsTotal;

		$resultArray = $this->user->getAllSuspendedUser($dt->getLength(), $dt->getStart(), $dt->getOrderName( 0 ), $dt->getOrderDir( 0 ) );

		foreach ($resultArray as &$result){
			if(!isset($result->name)){
				$result->name='';
			}
			if(!isset($result->LastName)){
				$result->LastName='';
			}
			if(!isset($result->Gender)){
				$result->Gender='';
			}
			if(!isset($result->City )){
				$result->City ='';
			}
			if(!isset($result->State )){
				$result->State ='';
			}
			if(!isset($result->zipcode )){
				$result->zipcode ='';
			}
			if(!isset($result->email )){
				$result->email ='';
			}
			if(!isset($result->email )){
				$result->email ='';
			}
			if(!isset($result->company )){
				$result->company ='';
			}
			if(!isset($result->phone )){
				$result->phone ='';
			}
			if(!isset($result->country )){
				$result->country ='';
			}
		}

		echo $dt->getJsonResponseJsonData( $recordsTotal, $recordsFiltered, json_encode( $resultArray ) );
		exit;
	}

	public function edit($id=''){
		if($id){
			$data = new stdClass;
			$session_data = $this->session->userdata( 'logged_in' );

			if( $session_data )
			{
				$data->username = $session_data[ 'username' ];
				$data->role = $session_data[ 'role' ];
				$data->id = $session_data[ 'id' ];
				$data->function_name = "Edit User";
				$this->load->model('p_user', 'user', TRUE);
				$this->user->setParse( $this->parserestclient );
				if($this->input->post()){
					$params=$this->input->post();
					$this->user->setObjectId($id);
					$this->user->setName($params['name']);
					$this->user->setLastname($params['name']);
					$this->user->setGender($params['gender']);
					$this->user->setCity($params['city']);
					$this->user->setEmail($params['email']);
					$this->user->setState($params['state']);
					$this->user->setZipcode($params['zipcode']);
					$this->user->setCompany($params['company']);
					$this->user->setTelephone($params['telephone']);
					$this->user->setCountry($params['country']);
					$this->user->update();
					redirect( 'user/index', 'refresh' );
				}else{
					$data->user=$this->user->getById($id);
					$this->load->view( 'user/user_form' , $data);
				}

			}
			else
			{
				redirect( 'manage/console_menu', 'refresh' );
			}

		}
	}
	public function suspend_users(){
		$response=[];
		if($this->input->post()){
			$this->load->model('p_user', 'user', TRUE);
			$this->user->setParse( $this->parserestclient );
			$ids=$this->input->post('id');
			$this->user->suspend_batch_user($ids);
			$response['status']='success';

		}else{
			$response['status']='fail';
			$response['error']='Fail to delete users';
		}
		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		exit;
	}
	public function enable_users(){
		$response = [];
		if ( $this->input->post() )
		{
			$this->load->model( 'p_user', 'user', TRUE );
			$this->user->setParse( $this->parserestclient );
			$ids = $this->input->post( 'id' );
			$this->user->enable_batch_user( $ids );
			$response[ 'status' ] = 'success';
		}
		else
		{
			$response[ 'status' ] = 'fail';
			$response[ 'error' ] = 'Fail to delete users';
		}
		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		exit;
	}
	public function delete_users(){
		$response=[];
		if($this->input->post()){
			$this->load->model('p_user', 'user', TRUE);
			$this->user->setParse( $this->parserestclient );
			$ids=$this->input->post('id');
			$this->user->delete_batch_user($ids);
			$response['status']='success';

		}else{
			$response['status']='fail';
			$response['error']='Fail to delete users';
		}
		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		exit;
	}
	public function reset_password()
	{
		$response = [];
		if ( $this->input->post() )
		{
			$user = $this->input->post('id');
			$now = new DateTime();
			$hash = hash( 'md5', $user . $now->getTimestamp() );
			$this->load->model( 'm_reset_password', 'reset', TRUE );
			$this->reset->setUser( $user );
			$this->reset->setHash( $hash );
			$this->reset->save();
			$response[ 'status' ] = 'success';
			$response[ 'hash' ] = $hash;
		}
		else
		{
			$response[ 'status' ] = 'fail';
			$response[ 'error' ] = 'can not send mail';
		}

		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		exit;
	}

	public function change_password( $user, $hash )
	{
		$data = new stdClass;
		$this->load->model('m_reset_password', 'reset', TRUE);
		$model=$this->reset->getUserHash($user, $hash);
		if( $model )
		{
			$data->username = "";
			$data->role = "";
			$data->id = "";
			$data->function_name = "Change Password";
			$data->user=$user;
			$data->hash=$hash;
			$this->load->view( 'user/change_password_form' , $data);
		}
		else
		{
			echo 'Invalid link';
		}

	}
	public function ajax_change_password(){
		$response = [];
		if ( $this->input->post() )
		{
			//$this->form_validation->set_rules( 'old-pass', 'Old Password', 'required' );
			$this->form_validation->set_rules( 'new-pass', 'New Password', 'required|matches[confirm-pass]' );
			$this->form_validation->set_rules( 'confirm-pass', 'Password Confirmation', 'required|matches[new-pass]' );
			$this->form_validation->set_rules( 'user', 'User', 'required' );
			$this->form_validation->set_rules( 'hash', 'Activation Code', 'required' );
			if ( $this->form_validation->run() == true )
			{
				$params=$this->input->post();
				$this->load->model('p_user', 'user', TRUE);
				$this->load->model('m_reset_password', 'reset', TRUE);
				$this->user->setParse( $this->parserestclient );
				$this->user->setObjectId($params['user']);
				$this->reset->delete($params['user']);
				$response['update']=$this->user->updatePassword($params['new-pass']);
				$response['status']='success';
			}else{
				$response[ 'status' ] = 'fail';
				$response[ 'error' ] = validation_errors();
			}
		}
		else
		{
			$response[ 'status' ] = 'fail';
			$response[ 'error' ] = 'Could not change password';
		}
		header( 'Content-Type: application/json' );
		echo json_encode( $response,JSON_PRETTY_PRINT);
		exit;
	}
}