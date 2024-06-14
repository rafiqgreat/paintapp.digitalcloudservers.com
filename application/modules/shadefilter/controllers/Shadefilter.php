<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Shadefilter extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('shadefilter_model', 'shadefilter_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('shadefilter/shadefilter_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->shadefilter_model->get_all_shadefilter();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			//$status = ($row['to_display'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('shadefilter/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("shadefilter/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	/*function change_status()
	{   
		$this->user_model->change_status();
	}*/

	public function add(){
		
		//$this->rbac->check_operation_access(); // check opration permission

		//$data['admin_roles'] = $this->admin->get_admin_roles();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|alpha_numeric|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('shadefilter/add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->shadefilter_model->add_shadefilter($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Shade Filter has been added successfully!');
					redirect(base_url('shadefilter'));
				}
			}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('shadefilter/shadefilter_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){

		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('shadefilter/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->shadefilter_model->edit_shadefilter($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Shade Filter has been updated successfully!');
					redirect(base_url('shadefilter'));
				}
			}
		}
		else{
			$data['shadefilter'] = $this->shadefilter_model->get_shadefilter_by_id($id);
			
			$this->load->view('template/_header');
			$this->load->view('shadefilter/shadefilter_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('shadefilters', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Shade Filter has been deleted successfully!');
		redirect(base_url('shadefilter'));
	}
	
	/*public function check_name_exist(){
        $name = $this->input->post('name');
        $result = $this->country_model->check_name_exist($name);
        print $result;    
	}*/
	
	function change_status()
	{   
		$this->shadefilter_model->change_status();
	}

}


?>