<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Visualizer extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('visualizer_model', 'visualizer_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('visualizer/visualizer_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->visualizer_model->get_all_visualizer();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{ 
			$image="";
			if($row['image'] && file_exists($row['image']))
				 $image ='<img src="'.base_url($row['image']).'" alt="'.$row['name'].'" width="40">';
			$data[]= array(
				++$i,
				$image,
				//$row['image'],
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('visualizer/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("visualizer/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
					redirect(base_url('visualizer'), 'refresh');
				}
			}

			$data = array(
					'image' => $data['image'],
				);
				$data = $this->security->xss_clean($data);
				$result = $this->visualizer_model->add_visualizer($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Visualizer has been added successfully!');
					redirect(base_url('visualizer'));
				}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('visualizer/visualizer_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
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
					redirect(base_url('visualizer'), 'refresh');
				}
			}
			
			$data = array(
						'image' => $data['image'], 
					);
				$data = $this->security->xss_clean($data);
				
				$result = $this->visualizer_model->edit_visualizer($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Visualizer has been updated successfully!');
					redirect(base_url('visualizer'));
				}
		}
		else{
			$data['visualizer'] = $this->visualizer_model->get_visualizer_by_id($id);
			
			$this->load->view('template/_header');
			$this->load->view('visualizer/visualizer_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('visualizer', array('id' => $id));

		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Visualizer has been deleted successfully!');
		redirect(base_url('visualizer'));
	}

}


?>