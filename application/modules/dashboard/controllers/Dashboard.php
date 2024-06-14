<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends MY_Controller {



	public function __construct(){

		parent::__construct();

		auth_check(); // check login auth

		$this->rbac->check_module_access();

		if($this->uri->segment(3) != '')
		$this->rbac->check_operation_access();

		$this->load->model('dashboard_model', 'dashboard_model');

	}

	//--------------------------------------------------------------------------

	public function index(){

		$data['title'] = 'Dashboard';

		$this->load->view('template/_header', $data);

		if($this->session->userdata('is_supper')){
    		redirect(base_url('dashboard/index_1'));
		}
		else{
			$this->load->view('dashboard/general');
		}

    	$this->load->view('template/_footer');

	}

	//--------------------------------------------------------------------------

	public function index_1(){

		$data['all_users'] = $this->dashboard_model->get_all_users();

		$data['active_users'] = $this->dashboard_model->get_active_users();

		$data['deactive_users'] = $this->dashboard_model->get_deactive_users();

		$data['title'] = 'Dashboard';

		$this->load->view('template/_header', $data);

    	$this->load->view('dashboard/index', $data);

    	$this->load->view('template/_footer');

	}



	//--------------------------------------------------------------------------

	public function index_2(){

		$data['title'] = 'Dashboard';


		$this->load->view('template/_header');

    	$this->load->view('dashboard/index2');

    	$this->load->view('template/_footer');

	}



	//--------------------------------------------------------------------------

	public function index_3(){

		$data['title'] = 'Dashboard';

		$this->load->view('template/_header');

    	$this->load->view('dashboard/index3');

    	$this->load->view('template/_footer');

	}


}
?>	