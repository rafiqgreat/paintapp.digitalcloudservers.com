<?php
	class Inquiry_model extends CI_Model{

		public function add_inquiry($data){
			$this->db->insert('inquiries', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_inquiry(){

			$this->db->select('*');
			$data = $this->db->get('inquiries')->result_array();
			return $data;
			
			/*if($this->session->userdata('is_supper')){
				$this->db->where('is_user',1);
				return $this->db->get('ci_users')->result_array();
			}
			else{
				$this->db->where('is_user', 1);
				$this->db->where('added_by',($this->session->userdata('user_id')));
				return $this->db->get('ci_users')->result_array();
			}*/
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_inquiry_by_id($id){
			$query = $this->db->get_where('inquiries', array('id' => $id));
			return $result = $query->row_array();
		}
		//---------------------------------------------------
		// Edit user Record
		public function edit_inquiry($data, $id){
			$this->db->where('id', $id);
			$this->db->update('inquiries', $data);
			return true;
		}
		
		public function get_all_cities(){
			$this->db->select('*');
			$data = $this->db->get('cities')->result_array();
			return $data;
		}
		
		public function get_city_by_id($id){
			$query = $this->db->get_where('cities', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_all_country(){
			$this->db->select('*');
			$data = $this->db->get('countries')->result_array();
			return $data;
		}
		
		public function get_state_by_country($CountryId)
		{
			$this->db->select('id,name')
					 ->from('states')
					 ->where('CountryId', $CountryId);
			$query = $this->db->get();			
			return $result = $query->result_array();			
		}
		
		public function get_city_by_state($state_id)
		{
			$this->db->select('id,name')
					 ->from('cities')
					 ->where('state_id', $state_id);
			$query = $this->db->get();			
			return $result = $query->result_array();			
		}
	}

?>