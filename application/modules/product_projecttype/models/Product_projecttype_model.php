<?php
	class Product_projecttype_model extends CI_Model{

		public function add_product_projecttype($data){
			$this->db->insert('product_projecttypes', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_product_projecttype(){

			$this->db->select('*');
			$data = $this->db->get('product_projecttypes')->result_array();
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
		
		public function get_projecttype_by_id($id){
			$query = $this->db->get_where('projecttypes', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function get_all_products(){
			$this->db->select('*');
			$this->db->where('isActive=1');
			$data = $this->db->get('products')->result_array();
			return $data;
		}
		
		public function get_all_projecttypes(){
			$this->db->select('*');
			$data = $this->db->get('projecttypes')->result_array();
			return $data;
		}
		
		public function get_products_by_projecttype_id($id)
		{
			$this->db->select('*');
			$this->db->where('ProjectTypeId', $id);
			$result = $this->db->get('product_projecttypes')->result_array();
			return $result;
		}
		//---------------------------------------------------
		// Edit user Record
		public function get_product_projecttype_by_id($id){
			$query = $this->db->get_where('product_projecttypes', array('id' => $id));
			return $result = $query->row_array();
		}
		
		public function edit_product_projecttype($data, $id){
			$this->db->where('id', $id);
			$this->db->update('product_projecttypes', $data);
			return true;
		}
	}

?>