<?php
	class Packaging_model extends CI_Model{

		public function add_packaging($data){
			$this->db->insert('packagings', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_packaging(){

			$this->db->select('*');
			$data = $this->db->get('packagings')->result_array();
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
		public function get_packaging_by_id($id){
			$query = $this->db->get_where('packagings', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_packaging($data, $id){
			$this->db->where('id', $id);
			$this->db->update('packagings', $data);
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
		} */

	}

?>