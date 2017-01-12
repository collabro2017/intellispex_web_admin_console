<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Send_mail extends CI_Controller
{
	public function sendMail ()
	{
		$data = $this->input->post();
		$from = $data['from'];
		$fromDescription = $data['fromDescription'];
		$email = $data['email'];
		$subject = isset( $data['subject'] ) ? $data['subject'] : '';
		$cc = isset( $data['cc'] ) ? $data['cc'] : '';
		$bcc = isset( $data['bcc'] ) ? $data['bcc'] : '';
		$attach = isset( $data['attach'] ) ? $data['attach'] : '';
		$message = isset( $data['message'] ) ? $data['message'] : '';

		$this->load->library( "email" );

		$config[ 'charset' ] = 'utf-8';
		$config[ 'wordwrap' ] = TRUE;
		$config[ 'mailtype' ] = 'html';
		$this->email->initialize( $config );

		$this->email->from( $from, $fromDescription );
		$this->email->to( $email );
		if ( strlen( $cc ) > 0 )
		{
			$this->email->cc( $cc );
		}
		if ( strlen( $bcc ) > 0 )
		{
			$this->email->bcc( $bcc );
		}
		$this->email->subject( $subject );

		$this->email->message( $message );
		
		if ( !empty($attach))
		{
			$this->email->attach( $attach );
		}

		header('Content-type: application/json');
		if ( $this->email->send() )
		{
			echo json_encode( array('status' => true ) );
			exit;
		}
		else
		{
			echo json_encode( array('status' => false ) );
			exit;			
		}
	}
}