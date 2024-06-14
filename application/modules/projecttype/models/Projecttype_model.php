<?php
	class Projecttype_model extends CI_Model{

		public function add_projecttype($data){
			$this->db->insert('projecttypes', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_projecttype(){

			$this->db->select('*');
			$data = $this->db->get('projecttypes')->result_array();
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
		public function get_projecttype_by_id($id){
			$query = $this->db->get_where('projecttypes', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_projecttype($data, $id){
			$this->db->where('id', $id);
			$this->db->update('projecttypes', $data);
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