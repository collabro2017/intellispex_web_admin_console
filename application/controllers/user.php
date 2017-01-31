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
			$data->function_name = "Content Manager";
			$this->load->model( 'm_sys_contract', 'contract' , TRUE);
			;

			$this->load->view( 'user/index' , $data);
		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}

	}

	public function ajax_user_datatable_parse(){

		$this->load->library('Jquery_DataTable', $this->input->post() );
		$this->load->model('p_user', 'user', TRUE);
		/*echo '<pre>';var_dump( $this->input->post() );'</pre>';
		exit;*/
		$dt = new Jquery_DataTable( $this->input->post()  );

		$this->user->setParse( $this->parserestclient );
		$recordsTotal = $this->user->countAll();
		$recordsFiltered = $recordsTotal;

		$resultArray = $this->user->getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName( 0 ), $dt->getOrderDir( 0 ) );
		/*var_dump( $resultArray);
		exit;*/
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
			/*echo '<pre>';var_dump( $ids );'</pre>';
			exit;*/
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
}