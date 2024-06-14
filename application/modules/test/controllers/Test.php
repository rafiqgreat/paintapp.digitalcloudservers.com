<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		//$this->load->model('admin/admin_model', 'admin');
		//$this->load->model('admin/user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('test');
		$this->load->view('template/_footer');
	}

}
