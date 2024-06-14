<?php
	class Product_category_model extends CI_Model{

		public function add_product_category($data){
			$this->db->insert('product_categories', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_product_category(){

			$this->db->select('*');
			$data = $this->db->get('product_categories')->result_array();
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
		
		public function get_category_by_id($id){
			$query = $this->db->get_where('categories', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_all_products(){
			$this->db->select('*');
			$this->db->where('isActive=1');
			$data = $this->db->get('products')->result_array();
			return $data;
		}
		
		public function get_all_categories(){
			$this->db->select('*');
			$data = $this->db->get('categories')->result_array();
			return $data;
		}
		
		public function get_procat_by_catid($id)
		{
			$this->db->select('*');
			$this->db->where('CategoryId', $id);
			$result = $this->db->get('product_categories')->result_array();
			return $result;
		}
		//---------------------------------------------------
		// Edit user Record
		public function get_product_category_by_id($id){
			$query = $this->db->get_where('product_categories', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function edit_product_category($data, $id){
			$this->db->where('id', $id);
			$this->db->update('product_categories', $data);
			return true;
		}
	}

?>