<?php
	class Dealer_model extends CI_Model{

		public function add_dealer($data){
			$this->db->insert('dealers', $data);
			return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_dealer(){
			$this->db->select('*');
			$data = $this->db->get('dealers')->result_array();
			return $data;
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_dealer_by_id($id){
			$query = $this->db->get_where('dealers', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_city_by_id($id){
			$query = $this->db->get_where('cities', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_country_by_id($id){
			$query = $this->db->get_where('countries', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_dealer($data, $id){
			$this->db->where('id', $id);
			$this->db->update('dealers', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		/*function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('user_id', $this->input->post('id'));
			$this->db->update('ci_users');
		}*/ 
		
		public function city_by_country($CountryId){
			$this->db->where('CountryId', $CountryId);
			$query = $this->db->get('countries');
			if($query->num_rows() > 0){
				return true; // Name exists
			} else {
				return false; // Name doesn't exist
			}
		}
		
		function get_city_by_country($CountryId)
		{
			$this->db->select('id,name')
					 ->from('cities')
					 ->where('CountryId', $CountryId);
			$query = $this->db->get();			
			return $result = $query->result_array();			
		}
		
		function get_state_by_country($CountryId)
		{
			$this->db->select('id,name')
					 ->from('states')
					 ->where('CountryId', $CountryId);
			$query = $this->db->get();			
			return $result = $query->result_array();			
		}
		
		function get_city_by_state($state_id)
		{
			$this->db->select('id,name')
					 ->from('cities')
					 ->where('state_id', $state_id);
			$query = $this->db->get();			
			return $result = $query->result_array();			
		}

	}

?>