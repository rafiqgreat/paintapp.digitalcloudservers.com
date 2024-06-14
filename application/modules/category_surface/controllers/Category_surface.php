<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category_surface extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('category_surface_model', 'category_surface_model');
		$this->load->model('category/category_model', 'category_model');
		$this->load->model('surface/surface_model', 'surface_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('category_surface/category_surface_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->category_surface_model->get_all_category_surface();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$data[]= array(
				++$i,
				$row['CategoryId'],
				$row['SurfaceId'],
				date_time($row['createdAt']),
				date_time($row['updatedAt']),	
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('category_surface/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("category_surface/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('CategoryId', 'Category', 'trim|alpha_numeric|required');
			$this->form_validation->set_rules('SurfaceId', 'Surface', 'trim|alpha_numeric|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('category_surface/add'),'refresh');
			}
			else{
				$cat = $this->input->post('CategoryId');
				$suf = $this->input->post('SurfaceId');
				$catsur_dtl = $this->category_surface_model->get_catsur_by_catid($cat);
				foreach ($catsur_dtl as $row) 
				{
					if($row['SurfaceId']==$suf)
					{
						$this->session->set_flashdata('errors', 'This combination already exists');
						redirect(base_url('category_surface/add'),'refresh');	
					}
				}
				
				$data = array(
					'CategoryId' => $this->input->post('CategoryId'), 
					'SurfaceId' => $this->input->post('SurfaceId'),
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->category_surface_model->add_category_surface($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Category Surface has been added successfully!');
					redirect(base_url('category_surface'));
				}
			}
		}
		else{
			$data['categories'] = $this->category_model->get_all_category();
			$data['surfaces'] = $this->surface_model->get_all_surface();
			$this->load->view('template/_header');
			$this->load->view('category_surface/category_surface_add', $data);
			$this->load->view('template/_footer');
		}
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('CategoryId', 'Category', 'trim|alpha_numeric|required');
			$this->form_validation->set_rules('SurfaceId', 'Surface', 'trim|alpha_numeric|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('category_surface/edit/'.$id),'refresh');
			}
			else{
				$cat = $this->input->post('CategoryId');
				$suf = $this->input->post('SurfaceId');
				$catsur_dtl = $this->category_surface_model->get_catsur_by_catid($cat);
				foreach ($catsur_dtl as $row) 
				{
					if($row['SurfaceId']==$suf)
					{
						$this->session->set_flashdata('errors', 'This combination already exists');
						redirect(base_url('category_surface'),'refresh');	
					}
				}
				
				$data = array(
					'CategoryId' => $this->input->post('CategoryId'), 
					'SurfaceId' => $this->input->post('SurfaceId'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->category_surface_model->edit_category_surface($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Category Surface has been updated successfully!');
					redirect(base_url('category_surface'));
				}
			}
		}
		else{
			$data['catsur'] = $this->category_surface_model->get_category_surface_by_id($id);
			$data['categories'] = $this->category_model->get_all_category();
			$data['surfaces'] = $this->surface_model->get_all_surface();
			$this->load->view('template/_header');
			$this->load->view('category_surface/category_surface_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		$this->db->delete('category_surfaces', array('id' => $id));
		// Activity Log 
		//$this->activity_model->add_log(3);
		$this->session->set_flashdata('success', 'Category Surface has been deleted successfully!');
		redirect(base_url('category_surface'));
	}
}


?>