<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mailbox extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
	}	

	//---------------------------------------------------------------------------
	public function inbox(){

		$data['title'] = '';

		$this->load->view('template/_header');
		$this->load->view('mailbox/mailbox', $data);
		$this->load->view('template/_footer');
	}

	//----------------------------------------------------------------------------
	public function compose(){

		$data['title'] = '';

		$this->load->view('template/_header');
		$this->load->view('mailbox/compose', $data);
		$this->load->view('template/_footer');
	}

	//-----------------------------------------------------------------------------
	public function read_mail(){

		$data['title'] = '';

		$this->load->view('template/_header');
		$this->load->view('mailbox/read-mail', $data);
		$this->load->view('template/_footer');
	}
}

?>