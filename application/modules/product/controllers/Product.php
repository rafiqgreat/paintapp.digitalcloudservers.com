<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('product_model', 'product_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('product/product_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->product_model->get_all_product();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{ 
			$status = ($row['isActive'] == 1)? 'checked': '';
			$image=$coverImage=$image1=$image2=$image3=$productImage="";
			if($row['image'] && file_exists($row['image']))
				 $image ='<img src="'.base_url($row['image']).'" alt="'.$row['name'].'" width="40">';
				 
			if($row['coverImage'] && file_exists($row['coverImage']))
				 $coverImage ='<img src="'.base_url($row['coverImage']).'" alt="'.$row['name'].'" width="40">';
			
			if($row['image1'] && file_exists($row['image1']))
				 $image1 ='<img src="'.base_url($row['image1']).'" alt="'.$row['name'].'" width="40">';
				 
			if($row['image2'] && file_exists($row['image2']))
				 $image2 ='<img src="'.base_url($row['image2']).'" alt="'.$row['name'].'" width="40">';
				 
			if($row['image3'] && file_exists($row['image3']))
				 $image3 ='<img src="'.base_url($row['image3']).'" alt="'.$row['name'].'" width="40">';
				 
			if($row['productImage'] && file_exists($row['productImage']))
				 $productImage ='<img src="'.base_url($row['productImage']).'" alt="'.$row['name'].'" width="40">';
				 	 
			$data[]= array(
				++$i,
				$row['name'],
				$row['description'],
				$row['spreading'],
				$image,
				$coverImage,
				$image1.'<br>'.$image2.'<br>'.$image3,
				$productImage,
				$row['video'],
				$row['isLuxury'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('product/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("product/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('spreading', 'Spreading', 'trim|required');
			$this->form_validation->set_rules('video', 'Video Link', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');
			$this->form_validation->set_rules('isLuxury', 'Luxury', 'trim|required');

			$path="assets/img/";
//image == coverImage == productImage == image1 == image2 == image3
			if(!empty($_FILES['image']['name']))
			{
				//$this->functions->delete_file($old_logo);
				$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
				if($result['status'] == 1){
					$data['image'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('product/add'), 'refresh');
				}
			}
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('product/add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'spreading' => $this->input->post('spreading'),
					'video' => $this->input->post('video'), 
					'sequence' => $this->input->post('sequence'),
					'isLuxury' => $this->input->post('isLuxury'),
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				
				if(!empty($_FILES['coverImage']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'coverImage', 'image', '9097152');
					if($result['status'] == 1){
						$data['coverImage'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('product/add'), 'refresh');
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
						redirect(base_url('product/add'), 'refresh');
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
						redirect(base_url('product/add'), 'refresh');
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
						redirect(base_url('product/add'), 'refresh');
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
						redirect(base_url('product/add'), 'refresh');
					}
				}
				
				$data = $this->security->xss_clean($data);
				$result = $this->product_model->add_product($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Product has been added successfully!');
					redirect(base_url('product'));
				}
			}
		}
		else{
			$this->load->view('template/_header');
			$this->load->view('product/product_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('spreading', 'Spreading', 'trim|required');
			$this->form_validation->set_rules('video', 'Video Link', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');
			$this->form_validation->set_rules('isLuxury', 'Luxury', 'trim|required');
			
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
					redirect(base_url('product/add'), 'refresh');
				}
			}
			
			if(!empty($_FILES['coverImage']['name']))
			{
				//$this->functions->delete_file($old_logo);
				$result = $this->functions->file_insert($path, 'coverImage', 'image', '9097152');
				if($result['status'] == 1){
					$data['coverImage'] = $path.$result['msg'];
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('product/add'), 'refresh');
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
					redirect(base_url('product/add'), 'refresh');
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
					redirect(base_url('product/add'), 'refresh');
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
					redirect(base_url('product/add'), 'refresh');
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
					redirect(base_url('product/add'), 'refresh');
				}
			}
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('product/edit/'.$id),'refresh');
			}
			else{
				$data = array(
						'name' => $this->input->post('name'),
						'description' => $this->input->post('description'),
						'spreading' => $this->input->post('spreading'),
						'video' => $this->input->post('video'), 
						'sequence' => $this->input->post('sequence'),
						'isLuxury' => $this->input->post('isLuxury'),
						'updatedAt' => date('Y-m-d : h:m:s'),
					);
				$data = $this->security->xss_clean($data);
				$result = $this->product_model->edit_product($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Product has been updated successfully!');
					redirect(base_url('product'));
				}
			}
		}
		else{
			$data['product'] = $this->product_model->get_product_by_id($id);
			$this->load->view('template/_header');
			$this->load->view('product/product_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		$this->db->delete('products', array('id' => $id));
		// Activity Log 
		//$this->activity_model->add_log(3);
		$this->session->set_flashdata('success', 'Product has been deleted successfully!');
		redirect(base_url('product'));
	}
	
	function change_status()
	{   
		$this->product_model->change_status();
	}
}


?>