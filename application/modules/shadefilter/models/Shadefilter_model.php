<?php
	class Shadefilter_model extends CI_Model{

		public function add_shadefilter($data){
			$this->db->insert('shadefilters', $data);
			return true;
		}
 
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_shadefilter(){

			$this->db->select('*');
			$data = $this->db->get('shadefilters')->result_array();
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
		public function get_shadefilter_by_id($id){
			$query = $this->db->get_where('shadefilters', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_shadefilter($data, $id){
			$this->db->where('id', $id);
			$this->db->update('shadefilters', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		/*function change_status()
		{		
			$this->db->set('to_display', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('shadefilter');
		}*/ 
		
		/*public function check_name_exist($name){
			$this->db->where('name', $name);
			$query = $this->db->get('countries');
			if($query->num_rows() > 0){
				return true; // Name exists
			} else {
				return false; // Name doesn't exist
			}
		}*/

	}

?>