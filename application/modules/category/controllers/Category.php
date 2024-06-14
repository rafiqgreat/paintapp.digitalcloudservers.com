<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('category_model', 'category_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('category/category_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->category_model->get_all_category();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$data[]= array(
				++$i,
				$row['name'],
				$row['image'],
				date_time($row['createdAt']),	
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('category/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("category/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('name', 'Name', 'trim|alpha_numeric|required');
			//$this->form_validation->set_rules('image', 'Image', 'trim|required');

			//$old_logo = $this->input->post('old_image');
			$path="assets/img/";

			if(!empty($_FILES['image']['name']))
			{
				//$this->functions->delete_file($old_logo);
				$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
				if($result['status'] == 1){
					$data['image'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('category'), 'refresh');
				}
			}

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('category/add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'image' => $data['image'],
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->category_model->add_category($data);
				if($result){

					// Activity Log 
					//$this->activity_model->add_log(1);

					$this->session->set_flashdata('success', 'Category has been added successfully!');
					redirect(base_url('category'));
				}
			}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('category/category_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){

		//$data['admin_roles'] = $this->admin->get_admin_roles();

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|alpha_numeric|required');
			if(!empty($_FILES['image']['name']))
			{
				//$this->functions->delete_file($old_logo);
				$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
				if($result['status'] == 1){
					$data['image'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('category'), 'refresh');
				}
			}
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('category/edit/'.$id),'refresh');
			}
			else{
				if($data['image']!=""){
					$data = array(
						'name' => $this->input->post('name'), 
						'image' => $data['image'],
						'updatedAt' => date('Y-m-d : h:m:s'),
					);
				}else{
					$data = array(
						'name' => $this->input->post('name'), 
						'updatedAt' => date('Y-m-d : h:m:s'),
					);
				}
				$data = $this->security->xss_clean($data);
				$result = $this->category_model->edit_category($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Category has been updated successfully!');
					redirect(base_url('category'));
				}
			}
		}
		else{
			$data['category'] = $this->category_model->get_category_by_id($id);
			
			$this->load->view('template/_header');
			$this->load->view('category/category_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('categories', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Category has been deleted successfully!');
		redirect(base_url('category'));
	}

}


?>