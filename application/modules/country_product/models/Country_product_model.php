<?php
	class Country_product_model extends CI_Model{

		public function add_country_product($data){
			$this->db->insert('country_products', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_country_product(){

			$this->db->select('*');
			$data = $this->db->get('country_products')->result_array();
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
		public function get_product_by_id($id){
			$query = $this->db->get_where('products', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_country_by_id($id){
			$query = $this->db->get_where('countries', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_all_products(){
			$this->db->select('*');
			$this->db->where('isActive=1');
			$data = $this->db->get('products')->result_array();
			return $data;
		}
		
		public function get_all_countries(){
			$this->db->select('*');
			$data = $this->db->get('countries')->result_array();
			return $data;
		}
		
		public function get_products_by_country_id($id)
		{
			$this->db->select('*');
			$this->db->where('CountryId', $id);
			$result = $this->db->get('country_products')->result_array();
			return $result;
		}
		//---------------------------------------------------
		// Edit user Record
		public function get_country_product_by_id($id){
			$query = $this->db->get_where('country_products', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function edit_country_product($data, $id){
			$this->db->where('id', $id);
			$this->db->update('country_products', $data);
			return true;
		}
	}

?>