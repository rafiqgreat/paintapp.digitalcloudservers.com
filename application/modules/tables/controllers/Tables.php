<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tables extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
	}

	//----------------------------------------------------------------
	public function simple(){

		$data['title'] = 'Simple Table';

		$this->load->view('template/_header');
		$this->load->view('tables/simple', $data);
		$this->load->view('template/_footer');
	}

	//------------------------------------------------------------------
	public function data(){

		$data['title'] = 'Datatable';

		$this->load->view('template/_header');
		$this->load->view('tables/data', $data);
		$this->load->view('template/_footer');
	}

}

	?>
