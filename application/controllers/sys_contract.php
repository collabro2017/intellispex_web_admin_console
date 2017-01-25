<?php

class Sys_Contract extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->CheckDataBaseTable();
		$this->load->library('form_validation');
	}

	private function CheckDataBaseTable()
	{
		if( $this->db->table_exists('sys_contract') == FALSE )
		{
			$sql = "CREATE TABLE `sys_contract` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT,`name` varchar(255) DEFAULT NULL,`contract` text,PRIMARY KEY (`id`))";
			$this->db->query( $sql );
		}
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
			$data->rows=[];
			$data->rows=$this->contract->getAll();

			$this->load->view( 'sys_contract/index' , $data);
		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}

	}
	public function add()
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );
		if( $session_data )
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];
			if($this->input->post())
			{

				$this->load->helper( 'url' );
				$this->load->library( 'form_validation' );
				$this->form_validation->set_rules( 'name', 'Contract Name', 'required|xss_clean' );
				$this->form_validation->set_rules( 'contract', 'Contract Text' , 'required');
				if ($this->form_validation->run() == true) {
					$this->load->model( 'm_sys_contract' , '', TRUE);
					$contract=new m_sys_contract();
					$contract->setName( $this->input->post( 'name' ) );
					$contract->setContract( $this->input->post( 'contract' ) );
					if($contract->save())
					{
						redirect( 'sys_contract/index', 'refresh' );
					}
					else
					{
						redirect( 'sys_contract/add', 'refresh' );
					}
				}
				else
				{
					$data->function_name = "Content Manager";
					$data->rows=[];
					$this->load->view( 'sys_contract/form_contract' , $data);
				}
			}
			else
			{
				$data->function_name = "Content Manager";
				$data->rows=[];
				$this->load->view( 'sys_contract/form_contract' , $data);
			}


		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}

	}
	public function edit($id)
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );

		if($session_data)
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];

		    if ($this->input->post())
		    {

		     	$this->load->helper('url');
				$this->load->library('form_validation');
				$this->form_validation->set_rules( 'name', 'Contract Name', 'required|xss_clean' );
				$this->form_validation->set_rules( 'contract', 'Contract Text', 'required' );

				if ($this->form_validation->run() == true)
				{
					$this->load->model('m_sys_contract', '', TRUE);
   					$contract=new m_sys_contract();
   					$contract->setId( $id );
					$contract->setName( $this->input->post( 'name' ) );
					$contract->setContract( $this->input->post( 'contract' ) );

					if($contract->save())
					{
						redirect( 'sys_contract/index', 'refresh' );
					}
					else
					{
						redirect( 'sys_contract/index', 'refresh' );
					}

				}
				else
				{
					$this->load->model( 'm_sys_contract', 'contract' , TRUE);
   					$data->contract = $this->contract->getById( $id );
					$data->function_name = "Content Manager";
					$data->rows=[];
					$this->load->view( 'sys_contract/form_contract' , $data);
				}

		    }
		    else
		    {
	    		$this->load->model( 'm_sys_contract', 'contract' , TRUE);
				$data->contract = $this->contract->getById($id);
				$data->function_name = "Content Manager";
				$data->rows=[];
				$this->load->view( 'sys_contract/form_contract' , $data);
			}

		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}

	}

	function delete ( $id = null )
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );

		if($session_data || $id != null)
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];

			$this->load->model( 'm_sys_contract', '', TRUE);
			$contract=new m_sys_contract();
			$contract->setId( $id );

			if($contract->delete())
			{
				redirect( 'sys_contract/index', 'refresh' );
			}
			else
			{
				redirect( 'sys_contract/index', 'refresh' );
			}

		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}
	}
}