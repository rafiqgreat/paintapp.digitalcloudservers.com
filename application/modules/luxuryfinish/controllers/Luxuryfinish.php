<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Luxuryfinish extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		$this->load->model('luxuryfinish_model', 'luxuryfinish_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$data['title'] = 'LuxuryFinish List';
		$this->load->view('template/_header', $data);
		$this->load->view('luxuryfinish/luxuryfinish_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->luxuryfinish_model->get_all_luxuryfinish();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{ 
			$coverImage = $image1 = $image2 = $image3 = $productImage="";
				 
			if($row['coverImage'] && file_exists($row['coverImage']))
				 $coverImage ='<img src="'.base_url($row['coverImage']).'" alt="'.$row['name'].'" width="40">';
				 	 
			$data[]= array(
				++$i,
				$row['name'],
				substr($row['description'],0,50).'...',//$row['description'],
				$row['sequence'],
				$coverImage,
				$row['video'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('luxuryfinish/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("luxuryfinish/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');
			$this->form_validation->set_rules('video', 'Video Link', 'trim|required');
			
			
//image == coverImage == luxuryfinishImage == image1 == image2 == image3
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('luxuryfinish/add'),'refresh');
			}
			else{
				
				$data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'sequence' => $this->input->post('sequence'),
					'video' => $this->input->post('video'), 
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$path="upload/luxuryfinish/";
				if(!empty($_FILES['coverImage']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'coverImage', 'image', '9097152');
					if($result['status'] == 1){
						$data['coverImage'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['productImage']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'productImage', 'image', '9097152');
					if($result['status'] == 1){
						$data['productImage'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['image1']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'image1', 'image', '9097152');
					if($result['status'] == 1){
						$data['image1'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['image2']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'image2', 'image', '9097152');
					if($result['status'] == 1){
						$data['image2'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['image3']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'image3', 'image', '9097152');
					if($result['status'] == 1){
						$data['image3'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
								
				$data = $this->security->xss_clean($data);
				$result = $this->luxuryfinish_model->add_luxuryfinish($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Luxuryfinish has been added successfully!');
					redirect(base_url('luxuryfinish'));
				}
			}
		}
		else{
			$data['title'] = 'Add new LuxuryFinish';
			$this->load->view('template/_header', $data);
			$this->load->view('luxuryfinish/luxuryfinish_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');
			$this->form_validation->set_rules('video', 'Video Link', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('luxuryfinish/edit/'.$id),'refresh');
			}
			else{
				
				$data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'sequence' => $this->input->post('sequence'),
					'video' => $this->input->post('video'), 
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				
				$path="upload/luxuryfinish/";
				if(!empty($_FILES['coverImage']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'coverImage', 'image', '9097152');
					if($result['status'] == 1){
						$data['coverImage'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['productImage']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'productImage', 'image', '9097152');
					if($result['status'] == 1){
						$data['productImage'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['image1']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'image1', 'image', '9097152');
					if($result['status'] == 1){
						$data['image1'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['image2']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'image2', 'image', '9097152');
					if($result['status'] == 1){
						$data['image2'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				if(!empty($_FILES['image3']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'image3', 'image', '9097152');
					if($result['status'] == 1){
						$data['image3'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('luxuryfinish/add'), 'refresh');
					}
				}
				
				$data = $this->security->xss_clean($data);
				$result = $this->luxuryfinish_model->edit_luxuryfinish($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Luxuryfinish has been updated successfully!');
					redirect(base_url('luxuryfinish'));
				}
			}
		}
		else{
			$data['luxuryfinish'] = $this->luxuryfinish_model->get_luxuryfinish_by_id($id);
			$data['title'] = 'Edit LuxuryFinish';
			
			$this->load->view('template/_header', $data);
			$this->load->view('luxuryfinish/luxuryfinish_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		$this->db->delete('luxuryfinishes', array('id' => $id));
		$this->session->set_flashdata('success', 'Luxuryfinish has been deleted successfully!');
		redirect(base_url('luxuryfinish'));
	}
	
	function change_status()
	{   
		$this->luxuryfinish_model->change_status();
	}
	
	public function delete_luximg($imgcolumn, $id = 0)
	{
		$data = array($imgcolumn => '');
		$this->db->where('id', $id);        
		$this->db->update('luxuryfinishes', $data);
		$this->session->set_flashdata('success', 'Image has been deleted successfully!');
		redirect(base_url('luxuryfinish/edit/'.$id));
	}
}


?>