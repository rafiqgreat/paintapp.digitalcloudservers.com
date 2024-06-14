<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
	}

	//----------------------------------------------------------------
	public function invoice(){

		$data['title'] = '';

		$this->load->view('template/_header');
		$this->load->view('pages/invoice', $data);
		$this->load->view('template/_footer');
	}

	//---------------------------------------------------------------
	public function profile(){

		$data['title'] = '';

		$this->load->view('template/_header');
		$this->load->view('pages/profile', $data);
		$this->load->view('template/_footer');
	}

	//---------------------------------------------------------------
	public function login(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;

		$this->load->view('template/_header' , $data);
		$this->load->view('pages/login', $data);
		$this->load->view('template/_footer' , $data);
	}

	//---------------------------------------------------------------
	public function register(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;

		$this->load->view('template/_header' , $data);
		$this->load->view('pages/register', $data);
		$this->load->view('template/_footer' , $data);
	}

	//---------------------------------------------------------------
	public function lockscreen(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;
		
		$this->load->view('template/_header' , $data);
		$this->load->view('pages/lockscreen', $data);
		$this->load->view('template/_footer' , $data);

	}

	

	//---------------------------------------------------------------
	public function pace(){

		$data['title'] = '';

		$this->load->view('template/_header');
		$this->load->view('pages/pace', $data);
		$this->load->view('template/_footer');
	}

}

?>
