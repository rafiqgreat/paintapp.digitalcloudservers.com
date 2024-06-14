<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
	}

	public function general(){

		$data['title'] = 'Export Database';

		$this->load->view('template/_header', $data);
		$this->load->view('forms/general');
		$this->load->view('template/_footer');
	}

	//------------------------------------------------------------------
	public function advanced(){

		$data['title'] = 'Export Database';

		$this->load->view('template/_header');
		$this->load->view('forms/advanced', $data);
		$this->load->view('template/_footer');
	}

	//------------------------------------------------------------------
	public function editors(){

		$data['title'] = 'Export Database';

		$this->load->view('template/_header');
		$this->load->view('forms/editors', $data);
		$this->load->view('template/_footer');
	}

}

	?>
