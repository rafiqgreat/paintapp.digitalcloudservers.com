<?php
	class Product_price_model extends CI_Model{

		public function add_product_price($data){
			$this->db->insert('products_prices', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_product_price(){

			$this->db->select('*');
			$data = $this->db->get('products_prices')->result_array();
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
		
		public function get_finishtype_by_id($id){
			$query = $this->db->get_where('finishtypes', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_package_by_id($id){
			$query = $this->db->get_where('packagings', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_all_products(){
			$this->db->select('*');
			$this->db->where('isActive=1');
			$data = $this->db->get('products')->result_array();
			return $data;
		}
		
		public function get_all_finishtypes(){
			$this->db->select('*');
			$data = $this->db->get('finishtypes')->result_array();
			return $data;
		}
		
		public function get_all_packagings(){
			$this->db->select('*');
			$data = $this->db->get('packagings')->result_array();
			return $data;
		}

		//---------------------------------------------------
		// Edit user Record
		public function get_product_price_by_id($id){
			$query = $this->db->get_where('products_prices', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function edit_product_price($data, $id){
			$this->db->where('id', $id);
			$this->db->update('products_prices', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('user_id', $this->input->post('id'));
			$this->db->update('ci_users');
		} 
		
		public function check_name_exist($name){
			$this->db->where('name', $name);
			$query = $this->db->get('cities');
			if($query->num_rows() > 0){
				return true; // Name exists
			} else {
				return false; // Name doesn't exist
			}
		}

	}

?>