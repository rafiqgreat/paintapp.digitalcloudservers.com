<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Finishtype extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('finishtype_model', 'finishtype_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('finishtype/finishtype_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->finishtype_model->get_all_finishtype();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{ 
			$image="";
			if($row['image'] && file_exists($row['image']))
				 $image ='<img src="'.base_url($row['image']).'" alt="'.$row['name'].'" width="40">';
			$data[]= array(
				++$i,
				$row['name'],
				$image,
				//$row['image'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('finishtype/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("finishtype/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('name', 'Name', 'trim|required');

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
					redirect(base_url('finishtype'), 'refresh');
				}
			}

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('finishtype/add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'image' => $data['image'],
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->finishtype_model->add_finishtype($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Finishtype has been added successfully!');
					redirect(base_url('finishtype'));
				}
			}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('finishtype/finishtype_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|alpha_numeric|required');
			$path="assets/img/";
			//print_r($_REQUEST);
			//die();
			//print_r($_FILES['image']['name']);
			//die();
			if(!empty($_FILES['image']['name']))
			{
				$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
				if($result['status'] == 1){
					$data['image'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('finishtype'), 'refresh');
				}
			}
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('finishtype/edit/'.$id),'refresh');
			}
			else{
				if($data['image']!="")
				{
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
				
				$result = $this->finishtype_model->edit_finishtype($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Finishtype has been updated successfully!');
					redirect(base_url('finishtype'));
				}
			}
		}
		else{
			$data['finishtype'] = $this->finishtype_model->get_finishtype_by_id($id);
			
			$this->load->view('template/_header');
			$this->load->view('finishtype/finishtype_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('finishtypes', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Finishtype has been deleted successfully!');
		redirect(base_url('finishtype'));
	}

}


?>