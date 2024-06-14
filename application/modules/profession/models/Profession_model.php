<?php
	class Profession_model extends CI_Model{

		public function add_profession($data){
			$this->db->insert('professions', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_profession(){

			$this->db->select('*');
			$data = $this->db->get('professions')->result_array();
			return $data;
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_profession_by_id($id){
			$query = $this->db->get_where('professions', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_profession($data, $id){
			$this->db->where('id', $id);
			$this->db->update('professions', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		/*function change_status()
		{		
			$this->db->set('to_display', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('countries');
		} */
		
		public function check_name_exist($name){
			$this->db->where('profession_name', $name);
			$query = $this->db->get('profession');
			if($query->num_rows() > 0){
				return true; // Name exists
			} else {
				return false; // Name doesn't exist
			}
		}

	}

?>