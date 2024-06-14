<?php
	class Product_model extends CI_Model{

		public function add_product($data){
			$this->db->insert('products', $data);
			return true;
		}
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_product(){

			$this->db->select('*');
			$data = $this->db->get('products')->result_array();
			return $data;
		}
		//---------------------------------------------------
		// Get user detial by ID
		public function get_product_by_id($id){
			$query = $this->db->get_where('products', array('id' => $id));
			return $result = $query->row_array();
		}
		//---------------------------------------------------
		// Edit user Record
		public function edit_product($data, $id){
			$this->db->where('id', $id);
			$this->db->update('products', $data);
			return true;
		}
		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('isActive', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('products');
		} 
	}
?>