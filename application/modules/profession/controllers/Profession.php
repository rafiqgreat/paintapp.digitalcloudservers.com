<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profession extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('profession_model', 'profession_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('profession/profession_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->profession_model->get_all_profession();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			//$status = ($row['to_display'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['profession_name'],
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('profession/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("profession/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			//die('45555555555555555');
			$this->form_validation->set_rules('profession_name', 'Profession Name', 'trim|alpha_numeric|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('profession/add'),'refresh');
			}
			else{
				$data = array(
					'profession_name' => $this->input->post('profession_name'), 
				);
				$data = $this->security->xss_clean($data);
				$result = $this->profession_model->add_profession($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Profession has been added successfully!');
					redirect(base_url('profession'));
				}
			}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('profession/profession_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){

		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('profession_name', 'Profession Name', 'trim|alpha_numeric|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('profession/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'profession_name' => $this->input->post('profession_name'), 
				);
				$data = $this->security->xss_clean($data);
				$result = $this->profession_model->edit_profession($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Profession has been updated successfully!');
					redirect(base_url('profession'));
				}
			}
		}
		else{
			$data['profession'] = $this->profession_model->get_profession_by_id($id);
			
			$this->load->view('template/_header');
			$this->load->view('profession/profession_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('professions', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Profession has been deleted successfully!');
		redirect(base_url('profession'));
	}
	
	public function check_name_exist(){
        $name = $this->input->post('profession_name');
        $result = $this->profession_model->check_name_exist($name);
        print $result;    
	}
	

}


?>