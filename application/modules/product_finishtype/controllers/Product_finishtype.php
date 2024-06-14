<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product_finishtype extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('product_finishtype_model', 'product_finishtype_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('product_finishtype/product_finishtype_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->product_finishtype_model->get_all_product_finishtype();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$finishtype_dtl = $this->product_finishtype_model->get_finishtype_by_id($row['FinishTypeId']);
			$product_dtl = $this->product_finishtype_model->get_product_by_id($row['ProductId']);
			
			$data[]= array(
				++$i,
				(isset($finishtype_dtl['name'])&&$finishtype_dtl['name']!="")?$finishtype_dtl['name']:"",
				(isset($product_dtl['name'])&&$product_dtl['name']!="")?$product_dtl['name']:"",
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('product_finishtype/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("product_finishtype/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			
			$this->form_validation->set_rules('FinishTypeId', 'FinishType', 'trim|required');
			$this->form_validation->set_rules('ProductId', 'Product', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('product_finishtype/add'),'refresh');
			}
			else{
				$prod_fin_dtl = $this->product_finishtype_model->get_products_by_finishid($this->input->post('FinishTypeId'));
				foreach ($prod_fin_dtl as $row) 
				{
					if($row['ProductId']==$this->input->post('ProductId'))
					{
						$this->session->set_flashdata('errors', 'This combination is already exists');
						redirect(base_url('product_finishtype/add'),'refresh');	
					}
				}
				$data = array(
					'FinishTypeId' => $this->input->post('FinishTypeId'), 
					'ProductId' => $this->input->post('ProductId'),
					'createdAt' => date('Y-m-d : H:i:s'),
					'updatedAt' => date('Y-m-d : H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->product_finishtype_model->add_product_finishtype($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Product Finishtype has been added successfully!');
					redirect(base_url('product_finishtype'));
				}
			}
		}
		else{
			$data['products'] = $this->product_finishtype_model->get_all_products();
			$data['finishtypes'] = $this->product_finishtype_model->get_all_finishtypes();
			
			$this->load->view('template/_header');
			$this->load->view('product_finishtype/product_finishtype_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('FinishTypeId', 'FinishType', 'trim|required');
			$this->form_validation->set_rules('ProductId', 'Product', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('product_finishtype/edit/'.$id),'refresh');
			}
			else{
				$prod_fin_dtl = $this->product_finishtype_model->get_products_by_finishid($this->input->post('FinishTypeId'));
				foreach ($prod_fin_dtl as $row) 
				{
					if($row['ProductId']==$this->input->post('ProductId'))
					{
						$this->session->set_flashdata('errors', 'This combination is already exists');
						redirect(base_url('product_finishtype/add'),'refresh');	
					}
				}
				$data = array(
					'FinishTypeId' => $this->input->post('FinishTypeId'), 
					'ProductId' => $this->input->post('ProductId'),
					'createdAt' => date('Y-m-d : H:i:s'),
					'updatedAt' => date('Y-m-d : H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->product_finishtype_model->edit_product_finishtype($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Product Finishtype has been updated successfully!');
					redirect(base_url('product_finishtype'));
				}
			}
		}
		else{
			$data['product_finishtype'] = $this->product_finishtype_model->get_product_finishtype_by_id($id);
			$data['products'] = $this->product_finishtype_model->get_all_products();
			$data['finishtypes'] = $this->product_finishtype_model->get_all_finishtypes();
			
			$this->load->view('template/_header');
			$this->load->view('product_finishtype/product_finishtype_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		$this->db->delete('product_finishtypes', array('id' => $id));
		// Activity Log 
		//$this->activity_model->add_log(3);
		$this->session->set_flashdata('success', 'Product Category has been deleted successfully!');
		redirect(base_url('product_finishtype'));
	}
}


?>