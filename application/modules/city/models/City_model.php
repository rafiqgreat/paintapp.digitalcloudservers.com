<?php
	class City_model extends CI_Model{

		public function add_city($data){
			$this->db->insert('cities', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_city(){

			$this->db->select('*');
			$data = $this->db->get('cities')->result_array();
			return $data;
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_city_by_id($id){
			$query = $this->db->get_where('cities', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_country_by_id($id){
			$query = $this->db->get_where('countries', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_all_countries(){
			$this->db->select('*');
			$this->db->where('to_display=1');
			$data = $this->db->get('countries')->result_array();
			return $data;
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_city($data, $id){
			$this->db->where('id', $id);
			$this->db->update('cities', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('to_display', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('cities');
		} 
		
		public function check_name_exist($name){
			$this->db->select( '*' );
			$this->db->from( 'cities' );
			$this->db->where( 'name', $name );
			$query = $this->db->get();
			$result = $query->result_array();		
			return $result;
		}
		public function get_state_by_id($id){
			$query = $this->db->get_where('states', array('id' => $id));
			return $result = $query->row_array();
		}
		public function get_state_by_country_id($id){
			$query = $this->db->get_where('states', array('CountryId' => $id));
			return $result = $query->result_array();
		}
		
		function get_state_by_country($CountryId)
		{
			$this->db->select('id, name')
					 ->from('states')
					 ->where('CountryId', $CountryId);					 
			$query = $this->db->get();			
			return $query->result_array();
		}

	}

?>