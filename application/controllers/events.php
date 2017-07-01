<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include_once('CI_Controller_EX.php');

class events extends CI_Controller_EX
{

	public function __construct()
	{
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

	public function index()
	{
		$data = new stdClass;
		$session_data = $this->session->userdata('logged_in');
		if ($session_data)
		{
			$data->username = $session_data['username'];
			$data->role = $session_data['role'];
			$data->id = $session_data['id'];
			$data->function_name = "VIEW OR EDIT GLOBAL EVENT LIST";

        	/*$data->info = $this->parserestclient->query
        	(
        		array
        		(
        			"objectId" => "Event",
        			"query" =>  '{"targetEvent":{"__type":"Pointer","className":"Event"}}'                   

        		)
        	);*/
            $temp = $this->parserestclient->query
        	(
        		array
        		(
        			"objectId" => "Event",
        			//"query" => '{"eventname":"EC STAGE II"}'
        		)
        	);
            $data->info = json_decode(json_encode($temp), true);
			$this->load->view('default/events/list', $data);
		}
		else
		{
			$this->load->view('default/include/manage/v_login');
		}
	}

  	public function event( $event_id )
	{
		$data = new stdClass;
		$session_data = $this->session->userdata('logged_in');
		if ($session_data)
		{
			$data->username = $session_data['username'];
			$data->role = $session_data['role'];
			$data->id = $session_data['id'];
			$data->function_name = "EVENT VIEWER";
			$data->event_id = $event_id;

			$data->info = $this->parserestclient->query
			(
	            array
	            (
	                "objectId" => "Post",
	                "query" =>  '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"'. $event_id . '"}}'
	            )
            );

			$this->load->view('default/events/view', $data);
		}
		else
		{
		    $this->load->view('default/include/manage/v_login');
		}
	}
}

?>
