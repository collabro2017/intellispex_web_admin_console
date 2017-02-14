<?php
ini_set( 'session.cache_limiter', 'public' );
session_cache_limiter( false );
session_start();
include_once( 'CI_Controller_EX.php' );

class events extends CI_Controller_EX
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper( 'url' );
		$this->load->model( 'M_user', '', TRUE );
		$this->load->model( 'M_client', '', TRUE );
		if ( $this->input->post( 'remember_me' ) ) // set sess_expire_on_close to 0 or FALSE when remember me is checked.
			$this->config->set_item( 'sess_expire_on_close', '0' ); // do change session config
		$this->load->library( "session" );
		$this->load->library( 'form_validation' );
		$this->load->library( 'grocery_CRUD' );
		$this->load->library( 'ParseRestClient' );
	}

	public function index()
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );
		if ( $session_data )
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];
			$data->function_name = "VIEW OR EDIT GLOBAL EVENT LIST";

			$data->info = $this->parserestclient->query
			(
				array
				(
					"objectId" => "Event",
					//"query" => '{"eventname":"EC STAGE II"}'
				)
			)->results;

			$this->load->view( 'default/events/list', $data );
		}
		else
		{
			$this->load->view( 'default/include/manage/v_login' );
		}
	}

	public function event( $event_id )
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );
		if ( $session_data )
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];
			$data->function_name = "EVENT VIEWER";
			$data->event_id = $event_id;
			$this->load->model( 'p_event', 'pevent', TRUE );
			$this->pevent->setParse($this->parserestclient);
			$data->info=$this->pevent->getEventById($event_id);
/*			echo '<pre>';var_dump( $data->info);'<pre>';
			exit;*/
			if($data->info){
				$this->load->view( 'default/events/view', $data );
			}else{
				redirect( 'events', 'refresh' );
			}

		}
		else
		{
			$this->load->view( 'default/include/manage/v_login' );
		}
	}

	public function ajax_delete_event()
	{
		$session_data = $this->session->userdata( 'logged_in' );
		if ( $session_data )
		{
			$this->form_validation->set_rules( 'id[]', 'evento', 'required|xss_clean' );
			$response = [];
			if ( $this->form_validation->run() == true )
			{
				$objecIds = $this->input->post( 'id' );
				$this->load->model( 'p_event', '', TRUE );
				foreach ( $objecIds as $objecId )
				{
					$event = new p_event();
					$event->setParse( $this->parserestclient );
					$event->setObjectId( $objecId );
					$event->deleteEvent();
					$response = [ 'result' => 'success' ];
				}
			}
			else
			{
				$response = [ 'result' => 'fail', 'error' => validation_errors() ];

			}
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
			exit;
		}
		else
		{
			$this->load->view( 'default/include/manage/v_login' );
		}
	}

	public function ajax_delete_post()
	{
		$session_data = $this->session->userdata( 'logged_in' );
		if ( $session_data )
		{


			$this->form_validation->set_rules( 'id[]', 'Event', 'required|xss_clean' );
			$response = [];
			if ( $this->form_validation->run() == true )
			{
				$listPostsIds = $this->input->post( 'id' );
				$this->load->model( 'p_post', '', TRUE );
				$post = new p_post();
				$post->setParse( $this->parserestclient );
				$post->deletePosts($listPostsIds);
				/*foreach ( $objecIds as $objecId )
				{
					$post->setObjectId( $objecId );
					$post->delete();
				}*/
				$response = [ 'result' => 'success' ];
			}
			else
			{
				$response = [ 'result' => 'fail', 'error' => validation_errors() ];

			}
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
			exit;
		}
		else
		{
			$this->load->view( 'default/include/manage/v_login' );
		}
	}

	public function ajax_delete_post_title( $id )
	{
		$this->load->model( 'p_post', '', TRUE );
		$post = new p_post();
		$post->setParse( $this->parserestclient );
		$response = $post->delete_title( $id );
		header( 'Content-Type: application/json' );
		if ( $response )
		{
			echo json_encode( [ 'result' => 'success', 'message' => $response ] );
		}
		else
		{
			echo json_encode( [ 'result' => 'fail' ] );
		}
		exit;
	}

	public function ajax_delete_post_description( $id )
	{
		$this->load->model( 'p_post', '', TRUE );
		$post = new p_post();
		$post->setParse( $this->parserestclient );
		$response = $post->delete_description( $id );
		header( 'Content-Type: application/json' );
		if ( $response )
		{
			echo json_encode( [ 'result' => 'success', 'message' => $response ] );
		}
		else
		{
			echo json_encode( [ 'result' => 'fail' ] );
		}
		exit;
	}

	public function ajax_delete_comment( $postId, $commendId )
	{
		$this->load->model( 'p_post', '', TRUE );
		$post = new p_post();
		$post->setParse( $this->parserestclient );
		$response = $post->deletePostComments( $postId, [$commendId] );
		header( 'Content-Type: application/json' );
		if ( $response )
		{
			echo json_encode( [ 'result' => 'success', 'message' => $response ] );
		}
		else
		{
			echo json_encode( [ 'result' => 'fail' ] );
		}
		exit;
	}

	public function FlaggedEvents()
	{
		$data = new stdClass;
		$session_data = $this->session->userdata( 'logged_in' );

		if ( $session_data )
		{
			$data->username = $session_data[ 'username' ];
			$data->role = $session_data[ 'role' ];
			$data->id = $session_data[ 'id' ];
			$data->function_name = "Flagged Events";

			$this->load->view( 'default/events/list_flag_event', $data );
		}
		else
		{
			redirect( 'manage/console_menu', 'refresh' );
		}
	}
	public function ajax_get_flagged_events()
	{
		$this->load->library('Jquery_DataTable', $this->input->post() );
		$this->load->model('p_event', 'event', TRUE);
		$dt = new Jquery_DataTable( $this->input->post()  );

		$this->event->setParse( $this->parserestclient );
		$recordsTotal = $this->event->countFlaggedPostEvent();
		$recordsFiltered = $recordsTotal;

		$resultArray = $this->event->get_data_table_flagged_post_events($dt->getLength(), $dt->getStart(), $dt->getOrderName( 0 ), $dt->getOrderDir( 0 ) );

		echo $dt->getJsonResponseJsonData( $recordsTotal, $recordsFiltered, json_encode( $resultArray ) );
		exit;
	}
}