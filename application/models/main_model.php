<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {

	public function check_login($username, $password)
	{
		$hash = $this->getPasswordHash($username);
		$hash = $hash[0]->password;

		$this->db->where('username', $username);

		if(password_verify($password, $hash)) {
			$query = $this->db->get('users');
			if ($query->num_rows() > 0) {
				return true;
			}else{
				return false;
			}
		}	
	}

	public function getPasswordHash($username)
	{
		$this->db->select('password');
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		return $query->result();
	}

	public function insert_data($data)
	{
		$this->db->insert('users', $data);
		$id_user = $this->db->insert_id();
		$data_userDetails = [
			'first_name' => 'No First Name',
			'last_name' => 'No Last Name',
			'email' => 'No Email',
			'address' => 'No Address',
			'phone' => 0,
			'image' => '',
			'id_level' => 2,
			'id_user' => $id_user,
			'created_at' => date("Y-m-d H:i:s")
		];
		$this->db->insert('user_details', $data_userDetails);
		return $id_user;
	}

	public function fetch_data()
	{
		$this->db->from('users');
		$this->db->join('user_details', 'user_details.id_user = users.id');
		$this->db->order_by('id_user', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_single_data($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		return $query->result();
	}

	public function update_data($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('users', $data);
		return $query;
	}

	public function delete_data($id)
	{	
		$user_details = $this->fetch_userDetails($id);
		$this->db->where('id', $user_details[0]->id);
		$this->db->delete('user_details');
		$this->db->where('id', $id);
		$this->db->delete('users');
	}

	public function getLevel()
	{
		$query = $this->db->get('level');
		return $query->result();
	}

	public function insert_userDetails($data)
	{
		$this->db->insert('user_details', $data);
		$query = $this->db->insert_id();
		if ($query > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function fetch_userDetails($id)
	{
		$this->db->from('user_details');
		$this->db->where('id_user', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_userDetails($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('user_details', $data);
		return $query;
	}

	public function data_auth($username, $password)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('user_details', 'user_details.id_user = users.id', 'left');
		$this->db->join('level', 'level.id = user_details.id_level', 'left');
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_id_level_by_user_details($id)
	{
		$this->db->select('id_level');
		$this->db->from('user_details');
		$this->db->join('users', 'users.id = user_details.id_user', 'left');
		$this->db->where('id_user', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_user($id)
	{
		$this->db->from('user_details');
		$this->db->join('users', 'users.id = user_details.id_user');
		$this->db->join('level', 'level.id = user_details.id_level');
		$this->db->where('id_user', $id);
		$query =$this->db->get();
		return $query->result();
	}

	public function search_data($keywords)
	{
		$this->db->select('*');
		$this->db->from('user_details');
		$this->db->join('users', 'users.id = user_details.id_user', 'left');
		$this->db->join('level', 'level.id = user_details.id_level', 'left');
		if($keywords != '')
		{
			$this->db->like('username', $keywords);
			$this->db->or_like('name', $keywords);
		}
		$this->db->order_by('user_details.id', 'DESC');
		return $this->db->get();
	}
}

/* End of file main_model.php */
/* Location: ./application/models/main_model.php */