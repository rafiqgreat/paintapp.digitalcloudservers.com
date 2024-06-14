<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Inquiry extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('inquiry_model', 'inquiry_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){
		$data['title'] = 'Inquiry List';
		$this->load->view('template/_header', $data);
		$this->load->view('inquiry/inquiry_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->inquiry_model->get_all_inquiry();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  			
			$city = $this->inquiry_model->get_city_by_id($row['city']);
			
			$data[]= array(
				++$i,
				$row['message'],
				$row['projectDetails'],
				$row['phone'],
				$row['email'],
				$row['CityId'],
				$row['userId'],
				$row['name'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('inquiry/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("inquiry/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
		
		$this->rbac->check_operation_access(); // check opration permission

		//$data['admin_roles'] = $this->admin->get_admin_roles();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_rules('projectDetails', 'Project Detail', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('inquiry/add'),'refresh');
			}
			else{
				$data = array(
					'message' => $this->input->post('message'), 
					'projectDetails' => $this->input->post('projectDetails'),
					'phone' => $this->input->post('phone'),
					'CountryId' => $this->input->post('CountryId'),
					'state_id' => $this->input->post('state_id'),
					'CityId' => $this->input->post('CityId'),
					'email' => $this->input->post('email'), 
					'userId' => $this->session->userdata('user_id'),
					'name' => $this->input->post('name'), 
					'createdAt' => date('Y-m-d : H:i:s'),
					'updatedAt' => date('Y-m-d : H:i:s'),
					'status' => $this->input->post('status'), 
				);
				$data = $this->security->xss_clean($data);
				$result = $this->inquiry_model->add_inquiry($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Inquiry has been added successfully!');
					redirect(base_url('inquiry'));
				}
			}
		}
		else{
			
			$data['countries'] = $this->inquiry_model->get_all_country();
			$data['title'] = 'Add New Inquiry';
			$this->load->view('template/_header', $data);
			$this->load->view('inquiry/inquiry_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){

		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_rules('projectDetails', 'Project Detail', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('inquiry/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'message' => $this->input->post('message'), 
					'projectDetails' => $this->input->post('projectDetails'),
					'phone' => $this->input->post('phone'),
					'CountryId' => $this->input->post('CountryId'),
					'state_id' => $this->input->post('state_id'),
					'CityId' => $this->input->post('CityId'),
					'email' => $this->input->post('email'), 
					'name' => $this->input->post('name'), 
					'status' => $this->input->post('status'), 
					'updatedAt' => date('Y-m-d : H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->inquiry_model->edit_inquiry($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Inquiry has been updated successfully!');
					redirect(base_url('inquiry'));
				}
			}
		}
		else{
			$data['inquiry'] = $this->inquiry_model->get_inquiry_by_id($id);
			$data['countries'] = $this->inquiry_model->get_all_country();
			
			$data['title'] = 'Edit Inquiry';
			$this->load->view('template/_header', $data);
			$this->load->view('inquiry/inquiry_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('inquiries', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Inquiry has been deleted successfully!');
		redirect(base_url('inquiry'));
	}
	
	public function check_name_exist(){
        $name = $this->input->post('name');
        $result = $this->inquiry_model->check_name_exist($name);
        print $result;    
	}
	
	public function state_by_country()
	{
		echo json_encode($this->inquiry_model->get_state_by_country($this->input->post('CountryId')));
	}
	
	public function city_by_state()
	{
		echo json_encode($this->inquiry_model->get_city_by_state($this->input->post('state_id')));
	}

}


?>