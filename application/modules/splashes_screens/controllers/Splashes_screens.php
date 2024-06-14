<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Splashes_screens extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('splashes_screens_model', 'splashes_screens_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('splashes_screens/splashes_screens_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->splashes_screens_model->get_all_splashes_screens();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{ 
			$image="";
			if($row['image_path'] && file_exists($row['image_path']))
				 $image ='<img src="'.base_url($row['image_path']).'" alt="'.$row['image_path'].'" width="40">';
			$data[]= array(
				++$i,
				$image,
				$row['sequence'],
				$row['status'],
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('splashes_screens/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("splashes_screens/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');

			$path="assets/img/";

			if(!empty($_FILES['image_path']['name']))
			{
				//$this->functions->delete_file($old_logo);
				$result = $this->functions->file_insert($path, 'image_path', 'image', '9097152');
				if($result['status'] == 1){
					$data['image_path'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('splashes_screens'), 'refresh');
				}
			}

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('splashes_screens/add'),'refresh');
			}
			else{
				$data = array(
					'image_path' => $data['image_path'], 
					'sequence' => $this->input->post('sequence'),
					'status' => $this->input->post('status'),
				);
				
				$data = $this->security->xss_clean($data);
				$result = $this->splashes_screens_model->add_splashes_screens($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Splashes Screens has been added successfully!');
					redirect(base_url('splashes_screens'));
				}
			}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('splashes_screens/splashes_screens_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('sequence', 'Image', 'trim|required');
			
			$path="assets/img/";
			
			if(!empty($_FILES['image_path']['name']))
			{
				//$this->functions->delete_file($old_logo);
				$result = $this->functions->file_insert($path, 'image_path', 'image', '9097152');
				if($result['status'] == 1){
					$data['image_path'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('splashes_screens'), 'refresh');
				}
			}
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('splashes_screens/edit/'.$id),'refresh');
			}
			else{
				if($data['image_path']!="")
				{
					$data = array(
						'image_path' => $data['image_path'], 
						'sequence' => $this->input->post('sequence'),
						'status' => $this->input->post('status'),
					);
				}else{
					$data = array(
						'sequence' => $this->input->post('sequence'),
						'status' => $this->input->post('status'),
					);
				}
				$data = $this->security->xss_clean($data);
				
				$result = $this->splashes_screens_model->edit_splashes_screens($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Splashes Screens has been updated successfully!');
					redirect(base_url('splashes_screens'));
				}
			}
		}
		else{
			$data['splashes_screens'] = $this->splashes_screens_model->get_splashes_screens_by_id($id);
			
			$this->load->view('template/_header');
			$this->load->view('splashes_screens/splashes_screens_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('splashes_screens', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Splashes Screens has been deleted successfully!');
		redirect(base_url('splashes_screens'));
	}

}


?>