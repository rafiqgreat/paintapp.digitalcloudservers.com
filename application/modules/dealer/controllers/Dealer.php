<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dealer extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		//$this->load->model('admin/admin_model', 'admin');
		$this->load->model('dealer_model', 'dealer_model');
		$this->load->model('country/country_model', 'country_model');
		$this->load->model('city/city_model', 'city_model');
		$this->load->model('admin/activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){
		$data['title'] = "Dealers List";
		$this->load->view('template/_header',$data);
		$this->load->view('dealer/dealer_list');
		$this->load->view('template/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->dealer_model->get_all_dealer();
		$data = array();

		$i=0;
		foreach ($records['data'] as $row) 
		{  
			$country = $this->dealer_model->get_country_by_id($row['CountryId']);
			if($country!="")
			{$country=$country['name'];}else{$country="";}
			
			$city = $this->dealer_model->get_city_by_id($row['CityId']);
			if($city!="")
			{$city=$city['name'];}else{$city="";}
			//echo '<pre>';
			//print_r($row);
			//die();
			
			//$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				$row['address'],
				$row['longitude'].'<br />'.$row['latitude'],
				$row['phone'],
				$row['isAC'],
				$row['isRM'],
				$country,
				$city,
				$row['sequence'],
				$row['createdAt'],
				$row['updatedAt'],
				'<a title="Edit" class="update btn btn-xs btn-warning" href="'.base_url('dealer/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-xs btn-danger" href='.base_url("dealer/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\');"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	function change_status()
	{   
		$this->user_model->change_status();
	}

	public function add(){
		
		$this->rbac->check_operation_access(); // check opration permission

		//$data['admin_roles'] = $this->admin->get_admin_roles();


		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Dealer Name', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('CityId', 'City', 'trim|required');
			$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
			$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('isAC', 'isAC', 'trim|required');
			$this->form_validation->set_rules('isRM', 'isRM', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');
			

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('dealer/add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'address' => $this->input->post('address'),
					'CountryId' => $this->input->post('CountryId'),
					'state_id' => $this->input->post('state_id'),
					'CityId' => $this->input->post('CityId'),
					'longitude' => $this->input->post('longitude'),
					'latitude' => $this->input->post('latitude'),
					'phone' => $this->input->post('phone'),
					'isAC' => $this->input->post('isAC'),
					'isRM' => $this->input->post('isRM'),
					'sequence' => $this->input->post('sequence'),
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				$path="upload/dealerlogo/";
				if(!empty($_FILES['dealerlogo']['name']))
				{
					//$this->functions->delete_file($old_logo);
					$result = $this->functions->file_insert($path, 'dealerlogo', 'image', '9097152');
					if($result['status'] == 1){
						$data['dealerlogo'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('dealer/dealer_edit/'.$id),'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->dealer_model->add_dealer($data);
				if($result)
				{
					//$this->activity_model->add_log(1);
					$this->session->set_flashdata('success', 'Dealer has been added successfully!');
					redirect(base_url('dealer'));
				}
			}
		}
		else{
			$data['countries'] = $this->country_model->get_all_country();
			$data['title'] = "Add New Dealers";
			$this->load->view('template/_header',$data);
			$this->load->view('dealer/dealer_add', $data);
			$this->load->view('template/_footer');
		}
		
	}

	public function edit($id = 0){

		//$data['admin_roles'] = $this->admin->get_admin_roles();

		//$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Dealer Name', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');
			$this->form_validation->set_rules('CountryId', 'Country', 'trim|required');
			$this->form_validation->set_rules('CityId', 'City', 'trim|required');
			$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
			$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('isAC', 'isAC', 'trim|required');
			$this->form_validation->set_rules('isRM', 'isRM', 'trim|required');
			$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('dealer/dealer_edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'address' => $this->input->post('address'),
					'CountryId' => $this->input->post('CountryId'),
					'state_id' => $this->input->post('state_id'),
					'CityId' => $this->input->post('CityId'),
					'longitude' => $this->input->post('longitude'),
					'latitude' => $this->input->post('latitude'),
					'phone' => $this->input->post('phone'),
					'isAC' => $this->input->post('isAC'),
					'isRM' => $this->input->post('isRM'),
					'sequence' => $this->input->post('sequence'),
					'createdAt' => date('Y-m-d : h:m:s'),
					'updatedAt' => date('Y-m-d : h:m:s'),
				);
				
				$path="upload/dealerlogo/";
				if(!empty($_FILES['dealerlogo']['name']))
				{
					$result = $this->functions->file_insert($path, 'dealerlogo', 'image', '9097152');
					if($result['status'] == 1){
						$data['dealerlogo'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('dealer/dealer_edit/'.$id),'refresh');
					}
				}
				//die($data['dealerlogo']);
				$data = $this->security->xss_clean($data);
				$result = $this->dealer_model->edit_dealer($data, $id);
				if($result){
					// Activity Log 
					$this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'Dealer has been updated successfully!');
					redirect(base_url('dealer'));
				}
			}
		}
		else{
			$data['dealer'] = $this->dealer_model->get_dealer_by_id($id);
			$data['countries'] = $this->country_model->get_all_country();
			
			$data['title'] = "Edit Dealer";
			$this->load->view('template/_header',$data);
			$this->load->view('dealer/dealer_edit', $data);
			$this->load->view('template/_footer');
		}
	}

	public function delete($id = 0)
	{
		$this->db->delete('dealers', array('id' => $id));
		$this->session->set_flashdata('success', 'Dealer has been deleted successfully!');
		redirect(base_url('dealer'));
	}
	
	public function city_by_country()
	{
		echo json_encode($this->dealer_model->get_city_by_country($this->input->post('CountryId')));
	}
	
	public function state_by_country()
	{
		echo json_encode($this->dealer_model->get_state_by_country($this->input->post('CountryId')));
	}
	
	public function city_by_state()
	{
		echo json_encode($this->dealer_model->get_city_by_state($this->input->post('state_id')));
	}
	
	public function delete_dealerimg($imgcolumn, $id = 0)
	{
		$data = array($imgcolumn => '');
		$this->db->where('id', $id);        
		$this->db->update('dealers', $data);
		$this->session->set_flashdata('success', 'Image has been deleted successfully!');
		redirect(base_url('dealer/edit/'.$id));
	}

}


?>