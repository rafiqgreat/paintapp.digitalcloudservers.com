<?php
	class Category_surface_model extends CI_Model
	{
		public function add_category_surface($data)
		{
			$this->db->insert('category_surfaces', $data);
			return true;
		}
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_category_surface()
		{
			$this->db->select('*');
			$data = $this->db->get('category_surfaces')->result_array();
			return $data;
		}
		//---------------------------------------------------
		public function get_catsur_by_catid($id)
		{
			$this->db->select('*');
			$this->db->where('CategoryId', $id);
			$result = $this->db->get('category_surfaces')->result_array();
			return $result;
		}
		//---------------------------------------------------
		// Get user detial by ID
		public function get_category_surface_by_id($id){
			$query = $this->db->get_where('category_surfaces', array('id' => $id));
			return $result = $query->row_array();
		}
		//---------------------------------------------------
		// Edit user Record
		public function edit_category_surface($data, $id){
			$this->db->where('id', $id);
			$this->db->update('category_surfaces', $data);
			return true;
		}
		//---------------------------------------------------
		// Change user status
		//---------------------------------------------------
		/*function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('user_id', $this->input->post('id'));
			$this->db->update('ci_users');
		}*/ 
	}
?>