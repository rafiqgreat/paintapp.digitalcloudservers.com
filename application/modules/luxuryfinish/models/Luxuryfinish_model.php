<?php
	class Luxuryfinish_model extends CI_Model{

		public function add_luxuryfinish($data){
			$this->db->insert('luxuryfinishes', $data);
			return true;
		}
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_luxuryfinish(){

			$this->db->select('*');
			$data = $this->db->get('luxuryfinishes')->result_array();
			return $data;
		}
		//---------------------------------------------------
		// Get user detial by ID
		public function get_luxuryfinish_by_id($id){
			$query = $this->db->get_where('luxuryfinishes', array('id' => $id));
			return $result = $query->row_array();
		}
		//---------------------------------------------------
		// Edit user Record
		public function edit_luxuryfinish($data, $id){
			$this->db->where('id', $id);
			$this->db->update('luxuryfinishes', $data);
			return true;
		}
	}
?>