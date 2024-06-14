<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Country extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('country_model', 'country_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index()
	{
		$data['title'] = 'Country List';
		$this->load->view('template/_header', $data);
		$this->load->view('country/country_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json()
	{				   					   
		$records['data'] = $this->country_model->get_all_country();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$status = ($row['to_display'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				$row['sortname'],
				$row['phonecode'],
				date_time($row['createdAt']),	
				$row['sequence'],
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('country/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("country/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	public function add()
	{		
		$this->rbac->check_operation_access(); // check opration permission

		//$data['admin_roles'] = $this->admin->get_admin_roles();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('country/add'),'refresh');
			}
			else{
				$slug = make_slug($this->input->post('name'));
				$data = array(
					'name' => $this->input->post('name'), 
					'sequence' => $this->input->post('sequence'),
					'createdAt' => date('Y-m-d : h:m:s'),
					'sortname' => $this->input->post('sortname'),
					'slug' => $slug,					
					'phonecode' => $this->input->post('phonecode'),
					'to_display' => $this->input->post('to_display'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_model->add_country($data);
				if($result){
					$this->session->set_flashdata('success', 'Country has been added successfully!');
					redirect(base_url('country'));
				}
			}
		}
		else{
			$data['title'] = 'Add New Country';
			$this->load->view('template/_header', $data);
			$this->load->view('country/country_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0)
	{
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|numeric|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('country/edit/'.$id),'refresh');
			}
			else{
				$slug = make_slug($this->input->post('name'));
				$data = array(
					'name' => $this->input->post('name'), 
					'sequence' => $this->input->post('sequence'),
					'updatedAt' => date('Y-m-d : h:m:s'),
					'sortname' => $this->input->post('sortname'),
					'slug' => $slug,					
					'phonecode' => $this->input->post('phonecode'),
					'to_display' => $this->input->post('to_display'),
					//'status' => $this->input->post('status'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_model->edit_country($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Country has been updated successfully!');
					redirect(base_url('country'));
				}
			}
		}
		else{
			$data['country'] = $this->country_model->get_country_by_id($id);
			$data['title'] = 'Edit Country';
			$this->load->view('template/_header', $data);
			$this->load->view('country/country_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('countries', array('id' => $id));

		$this->session->set_flashdata('success', 'Country has been deleted successfully!');
		redirect(base_url('country'));
	}
	
	public function check_name_exist()
	{
        $name = $this->input->post('name');
        $exists = $this->country_model->check_name_exist($name);
		echo count( $exists );  
	}
	
	function change_status()
	{   
		$this->country_model->change_status();
	}
	
	public function state()
	{
		$data['title'] = 'State List';
		$this->load->view('template/_header', $data);
		$this->load->view('country/state_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json_state()
	{				   					   
		$records['data'] = $this->country_model->get_all_states();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{
			$country_name = $this->country_model->get_country_by_id($row['CountryId']);  
			
			$country_name = '';
			$country_name_result = $this->country_model->get_country_by_id($row['CountryId']);
			
			if($country_name_result)
				$country_name = $country_name_result['name'];
				
			$status = ($row['to_display'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				$country_name,
				date_time($row['createdAt']),	
				$row['sequence'],
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('country/state_edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("country/state_delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}
	
	public function state_add()
	{		
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('country/state_add'),'refresh');
			}
			else{
				$slug = make_slug($this->input->post('name'));
				$data = array(
					'name' => $this->input->post('name'), 
					'sequence' => $this->input->post('sequence'),
					'createdAt' => date('Y-m-d : h:m:s'),
					'CountryId' => $this->input->post('CountryId'),
					'slug' => $slug,
					'to_display' => $this->input->post('to_display'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_model->add_state($data);
				if($result){
					$this->session->set_flashdata('success', 'State has been added successfully!');
					redirect(base_url('country/state'));
				}
			}
		}
		else{
			$data['title'] = 'Add New State';
			$data['countries'] = $this->country_model->get_all_country();
			
			$this->load->view('template/_header', $data);
			$this->load->view('country/state_add', /*$data*/"");
			$this->load->view('template/_footer');
		}
		
	}
	
	public function state_edit($id = 0)
	{
		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|numeric|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('country/state_edit/'.$id),'refresh');
			}
			else{
				$slug = make_slug($this->input->post('name'));
				$data = array(
					'name' => $this->input->post('name'), 
					'CountryId' => $this->input->post('CountryId'),
					'sequence' => $this->input->post('sequence'),
					'updatedAt' => date('Y-m-d : h:m:s'),
					'slug' => $slug,
					'to_display' => $this->input->post('to_display'),
					//'status' => $this->input->post('status'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_model->edit_state($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'State has been updated successfully!');
					redirect(base_url('country/state'));
				}
			}
		}
		else{			
			$data['title'] = 'Edit State';
			$data['state'] = $this->country_model->get_state_by_id($id);
			$data['countries'] = $this->country_model->get_all_country();
			
			$this->load->view('template/_header', $data);
			$this->load->view('country/state_edit', $data);
			$this->load->view('template/_footer');
		}
	}
	
	public function state_delete($id = 0)
	{
		//$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('states', array('id' => $id));

		$this->session->set_flashdata('success', 'State has been deleted successfully!');
		redirect(base_url('country/state'));
	}
	
	function change_status_state()
	{   
		$this->country_model->change_status_state();
	}
	
	public function city()
	{
		$data['title'] = 'City List';
		$this->load->view('template/_header', $data);
		$this->load->view('country/city_list');
		$this->load->view('template/_footer');
	}
	public function datatable_json_city()
	{				   					   
		$records['data'] = $this->country_model->get_all_city();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$state_name = '';
			$country_name = '';
			$country_name_result = $this->country_model->get_country_by_id($row['CountryId']);
			$state_name_result = $this->country_model->get_state_by_id($row['state_id']);
			
			if($country_name_result)
				$country_name = $country_name_result['name'];
				
			if($state_name_result)
				$state_name = $state_name_result['name'];	
			
			$status = ($row['to_display'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				$state_name,
				$country_name,
				$row['sequence'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('country/city_edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("country/city_delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}
	
	public function city_add()
	{		
		$this->rbac->check_operation_access(); // check opration permission

		//$data['admin_roles'] = $this->admin->get_admin_roles();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('country/city_add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'CountryId' => $this->input->post('CountryId'),
					'state_id' => $this->input->post('state_id'),
					'sequence' => $this->input->post('sequence'),
					'createdAt' => date('Y-m-d : H:i:s'),
					'updatedAt' => date('Y-m-d : H:i:s'),
					'to_display' => $this->input->post('to_display'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_model->add_city($data);
				if($result){
					$this->session->set_flashdata('success', 'City has been added successfully!');
					redirect(base_url('country/city'));
				}
			}
		}
		else{
			$data['countries'] = $this->country_model->get_all_country();
			$data['title'] = 'Add New City';
			$this->load->view('template/_header', $data);
			$this->load->view('country/city_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function city_edit($id = 0)
	{
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|numeric|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('country/city_edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'CountryId' => $this->input->post('CountryId'), 
					'state_id' => $this->input->post('state_id'),
					'sequence' => $this->input->post('sequence'),
					'updatedAt' => date('Y-m-d : h:m:s'),
					'to_display' => $this->input->post('to_display'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->country_model->edit_city($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'City has been updated successfully!');
					redirect(base_url('country/city'));
				}
			}
		}
		else{
			$data['city'] = $this->country_model->get_city_by_id($id);
			$data['countries'] = $this->country_model->get_all_countries();
			$data['title'] = 'Edit City';
			
			$this->load->view('template/_header', $data);
			$this->load->view('country/city_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function city_delete($id = 0)
	{		
		$this->db->delete('cities', array('id' => $id));
		$this->session->set_flashdata('success', 'City has been deleted successfully!');
		redirect(base_url('country/city'));
	}
	
	public function check_name_exist_city()
	{  
		$name = $this->input->post('name');
        $exists = $this->country_model->check_name_exist_city($name);
		echo count( $exists );   
	}
	
	public function state_by_country()
	{
		echo json_encode($this->country_model->get_state_by_country($this->input->post('CountryId')));
	}
	
	function change_status_city()
	{   
		$this->country_model->change_status_city();
	}

}
?>