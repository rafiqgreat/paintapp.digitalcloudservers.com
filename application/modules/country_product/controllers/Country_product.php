<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Country_product extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('country_product_model', 'country_product_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('template/_header');
		$this->load->view('country_product/country_product_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->country_product_model->get_all_country_product();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$country_dtl = $this->country_product_model->get_country_by_id($row['CountryId']);
			$product_dtl = $this->country_product_model->get_product_by_id($row['ProductId']);
			
			$data[]= array(
				++$i,
				(isset($country_dtl['name'])&&$country_dtl['name']!="")?$country_dtl['name']:"",
				(isset($product_dtl['name'])&&$product_dtl['name']!="")?$product_dtl['name']:"",
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('country_product/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("country_product/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('ProductId', 'Product', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('country_product/add'),'refresh');
			}
			else{
				$prod_country_dtl = $this->country_product_model->get_products_by_country_id($this->input->post('CountryId'));
				foreach ($prod_country_dtl as $row) 
				{
					if($row['CountryId']==$this->input->post('CountryId'))
					{
						$this->session->set_flashdata('errors', 'This combination is already exists');
						redirect(base_url('country_product/add'),'refresh');	
					}
				}
				$data = array(
					'CountryId' => $this->input->post('CountryId'), 
					'ProductId' => $this->input->post('ProductId'),
					'createdAt' => date('Y-m-d : H:i:s'),
					'updatedAt' => date('Y-m-d : H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_product_model->add_country_product($data);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Country Product has been added successfully!');
					redirect(base_url('country_product'));
				}
			}
		}
		else{
			$data['products'] = $this->country_product_model->get_all_products();
			$data['countries'] = $this->country_product_model->get_all_countries();
			
			$this->load->view('template/_header');
			$this->load->view('country_product/country_product_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('ProductId', 'Product', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('country_product/edit/'.$id),'refresh');
			}
			else{
				$prod_country_dtl = $this->country_product_model->get_products_by_country_id($this->input->post('CountryId'));
				//echo '<pre>';
				//print_r($prod_country_dtl);
				//die();
				foreach ($prod_country_dtl as $row) 
				{
					if($row['ProductId']==$this->input->post('ProductId'))
					{
						$this->session->set_flashdata('errors', 'This combination is already exists');
						redirect(base_url('country_product/add'),'refresh');	
					}
				}
				$data = array(
					'CountryId' => $this->input->post('CountryId'), 
					'ProductId' => $this->input->post('ProductId'),
					'createdAt' => date('Y-m-d : H:i:s'),
					'updatedAt' => date('Y-m-d : H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_product_model->edit_country_product($data, $id);
				if($result){
					// Activity Log 
					//$this->activity_model->add_log(2);
					$this->session->set_flashdata('success', 'Country Product has been updated successfully!');
					redirect(base_url('country_product'));
				}
			}
		}
		else{
			$data['country_product'] = $this->country_product_model->get_country_product_by_id($id);
			$data['products'] = $this->country_product_model->get_all_products();
			$data['countries'] = $this->country_product_model->get_all_countries();
			
			$this->load->view('template/_header');
			$this->load->view('country_product/country_product_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		$this->db->delete('country_products', array('id' => $id));
		// Activity Log 
		//$this->activity_model->add_log(3);
		$this->session->set_flashdata('success', 'Country Product has been deleted successfully!');
		redirect(base_url('country_product'));
	}
}


?>