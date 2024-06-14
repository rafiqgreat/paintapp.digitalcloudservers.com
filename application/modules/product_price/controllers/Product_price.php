<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product_price extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('product_price_model', 'product_price_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('product_price/product_price_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->product_price_model->get_all_product_price();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$product_dtl = $this->product_price_model->get_product_by_id($row['product_id']);
			$finishtype_dtl = $this->product_price_model->get_finishtype_by_id($row['finish_id']);
			$package_dtl = $this->product_price_model->get_package_by_id($row['package_id']);
			
			$data[]= array(
				++$i,
				(isset($product_dtl['name'])&&$product_dtl['name']!="")?$product_dtl['name']:"",
				(isset($finishtype_dtl['name'])&&$finishtype_dtl['name']!="")?$finishtype_dtl['name']:"",
				(isset($package_dtl['name'])&&$package_dtl['name']!="")?$package_dtl['name']:"",
				$row['price'],	
				$row['isLuxury'],
				$row['currency'],
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('product_price/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("product_price/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('product_id', 'Product Name', 'trim|required');
			$this->form_validation->set_rules('finish_id', 'FinishType', 'trim|required');
			$this->form_validation->set_rules('package_id', 'Packaging', 'trim|required');
			$this->form_validation->set_rules('price', 'Product Price', 'trim|required');
			$this->form_validation->set_rules('isLuxury', 'Luxury Ststus', 'trim|required');
			$this->form_validation->set_rules('currency', 'Currency', 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('product_price/add'),'refresh');
			}
			else{
				$data = array(
					'product_id' => $this->input->post('product_id'), 
					'finish_id' => $this->input->post('finish_id'),
					'package_id' => $this->input->post('package_id'),
					'price' => $this->input->post('price'),
					'isLuxury' => $this->input->post('isLuxury'),
					'currency' => $this->input->post('currency'),
					
				);
				$data = $this->security->xss_clean($data);
				$result = $this->product_price_model->add_product_price($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'City has been added successfully!');
					redirect(base_url('product_price'));
				}
			}
		}
		else{
			$data['products'] = $this->product_price_model->get_all_products();
			$data['finishtypes'] = $this->product_price_model->get_all_finishtypes();
			$data['packagings'] = $this->product_price_model->get_all_packagings();
			
			$this->load->view('template/_header');
			$this->load->view('product_price/product_price_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){

		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('product_id', 'Product Name', 'trim|required');
			$this->form_validation->set_rules('finish_id', 'FinishType', 'trim|required');
			$this->form_validation->set_rules('package_id', 'Packaging', 'trim|required');
			$this->form_validation->set_rules('price', 'Product Price', 'trim|required');
			$this->form_validation->set_rules('isLuxury', 'Luxury Ststus', 'trim|required');
			$this->form_validation->set_rules('currency', 'Currency', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('product_price/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'product_id' => $this->input->post('product_id'), 
					'finish_id' => $this->input->post('finish_id'),
					'package_id' => $this->input->post('package_id'),
					'price' => $this->input->post('price'),
					'isLuxury' => $this->input->post('isLuxury'),
					'currency' => $this->input->post('currency'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->product_price_model->edit_product_price($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Product Price has been updated successfully!');
					redirect(base_url('product_price'));
				}
			}
		}
		else{
			$data['product_price'] = $this->product_price_model->get_product_price_by_id($id);
			$data['products'] = $this->product_price_model->get_all_products();
			$data['finishtypes'] = $this->product_price_model->get_all_finishtypes();
			$data['packagings'] = $this->product_price_model->get_all_packagings();
			$this->load->view('template/_header');
			$this->load->view('product_price/product_price_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		$this->db->delete('products_prices', array('id' => $id));
		// Activity Log 
		//$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Product Price has been deleted successfully!');
		redirect(base_url('product_price'));
	}
}


?>