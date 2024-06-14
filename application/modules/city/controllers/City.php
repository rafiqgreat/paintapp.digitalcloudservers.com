<?php defined('BASEPATH') OR exit('No direct script access allowed');
class City extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		//$this->load->model('location_model', 'location_model');
		$this->load->model('city_model', 'city_model');
		//$this->load->model('user_model', 'user_model');
		//$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index()
	{
		$data['title'] = 'City List';
		$this->load->view('template/_header', $data);
		$this->load->view('city/city_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json()
	{				   					   
		$records['data'] = $this->city_model->get_all_city();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$country_name = $this->city_model->get_country_by_id($row['CountryId']);
			$state_name = $this->city_model->get_state_by_id($row['state_id']);
			$status = ($row['to_display'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				$state_name['name'],
				$country_name['name'],
				$row['sequence'],
				date_time($row['createdAt']),	
				date_time($row['updatedAt']),
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('city/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("city/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
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
			$this->form_validation->set_rules('name', 'Name', 'trim|alpha_numeric|required');
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|alpha_numeric|required');


			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('city/add'),'refresh');
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
				$result = $this->city_model->add_city($data);
				if($result){
					$this->session->set_flashdata('success', 'City has been added successfully!');
					redirect(base_url('city'));
				}
			}
		}
		else{
			$data['countries'] = $this->city_model->get_all_countries();
			$data['title'] = 'Add New City';
			$this->load->view('template/_header', $data);
			$this->load->view('city/city_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0)
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
					redirect(base_url('city/edit/'.$id),'refresh');
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
				$result = $this->city_model->edit_city($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'City has been updated successfully!');
					redirect(base_url('city'));
				}
			}
		}
		else{
			$data['city'] = $this->city_model->get_city_by_id($id);
			$data['countries'] = $this->city_model->get_all_countries();
			$data['title'] = 'Edit City';
			
			$this->load->view('template/_header', $data);
			$this->load->view('city/city_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{		
		$this->db->delete('cities', array('id' => $id));
		$this->session->set_flashdata('success', 'City has been deleted successfully!');
		redirect(base_url('city'));
	}
	
	public function check_name_exist(){  
		$name = $this->input->post('name');
        $exists = $this->city_model->check_name_exist($name);
		echo count( $exists );   
	}
	
	public function state_by_country()
	{
		echo json_encode($this->city_model->get_state_by_country($this->input->post('CountryId')));
	}
	function change_status()
	{   
		$this->city_model->change_status();
	}

}


?>