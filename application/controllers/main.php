<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Ho_Chi_Minh');
class Main extends CI_Controller {
	private $cost = 12;

	public function __construct()
	{
		Parent::__construct();
		$this->load->model('main_model');
	}

	public function index()
	{
		if($this->session->has_userdata('username')){
			$name_auth = $this->session->userdata('username');

			$data = $this->main_model->fetch_data();
			$levels = $this->main_model->getLevel();

			foreach($data as $key => $value){
				foreach($levels as $k => $v){
					if($value->id_level == $v->id){
						$data[$key]->level_name = $v->name;
						break;
					}
				}
			}
			$data['users_data']= $data;

			$this->load->view('list_view', $data);
		}else{
			redirect(base_url().'main/login');
		}
	}

	public function login()
	{
		$data['title'] = "Vui lòng đăng nhập";
		$this->load->view('main_view', $data);
	}

	public function login_validation()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run()) {	
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if($this->main_model->check_login($username, $password)){

				$data_auth = $this->main_model->data_auth($username, $password);

				$id_user = $data_auth[0]->id_user;
				$id_level = $data_auth[0]->id_level;

				if ($id_level == 1) {
					$user_session = array(
						'id_user' => $id_user,
						'id_level' => $id_level,
						'username' => $username,
					);
					$this->session->set_userdata($user_session);
					redirect(base_url().'main/index');
				}else{
					$user_session = array(
						'username' => $username
					);
					$this->session->set_userdata($user_session);
					redirect(base_url().'main/user');
				}

				
			}else{
				$this->session->set_flashdata('error','<div class="alert alert-danger">Đăng nhập thất bại</div>');
				redirect(base_url().'main/login');
			}
		}else{
			$this->login();
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		redirect(base_url().'main/login');
	}

	public function register()
	{
		$data['title'] = 'Đăng ký người dùng';
		$this->load->view('register_view', $data);
	}

	public function register_validation()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if ($this->form_validation->run()) {
			$data = [
				'username' => $this->input->post('username'),
				'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, ['cost' => $this->cost]),
				'created_at' => date("Y-m-d H:i:s")
			];

			$id = $this->main_model->insert_data($data);

			if ($id > 0) {
				$this->session->set_flashdata('success','<div id="success" class="alert alert-success">Đăng kỳ thành công</div>');
				redirect(base_url().'main/userDetails/'.$id);
			}else{
				$this->register();
			}
		}else{
			$this->register();
		}
	}

	public function update($id)
	{
		if($this->session->has_userdata('username')){
			$user_current_login = $this->session->userdata('id_user');
			$id_level = $this->main_model->get_id_level_by_user_details($id);
			$id_level = $id_level[0]->id_level; #8

			if(($user_current_login != 1) && (($id == 1 || $id_level == 1) && ($user_current_login != $id))){
				$this->session->set_flashdata('error_edit', '<div id="error" class="alert alert-danger">Không có quyền sửa</div>');
				redirect(base_url().'main/index');
			}else{
				$data['title'] = 'Cập nhật thông tin';
				$data['user'] = $this->main_model->fetch_single_data($id);
				// $data['userDetails'] = $this->main_model->fetch_userDetails($id);
				$this->load->view('edit_view', $data);
			}
			
		}else{
			redirect(base_url().'main/login');
		}
	}

	public function update_validation()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if($this->form_validation->run()) {
			$data = [
				'username' => $this->input->post('username'),
				'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, ['cost'=>$this->cost]),
				'updated_at' => date("Y-m-d H:i:s")
			];

			$this->main_model->update_data($data, $this->input->post('hidden_id'));
			redirect(base_url().'main/index');
		}else{
			$this->update();
		}
	}

	public function delete($id)
	{
		#id này là id details
		#xóa bảng con details trước xong mới xóa bảng cha user
		$user_current_login = $this->session->userdata('id_user');
		$id_level = $this->main_model->get_id_level_by_user_details($id);
		$id_level = $id_level[0]->id_level;

		// var_dump($id_level);die;
		if ($id == 1 || $user_current_login != 1 && $id_level == 1) {
			$this->session->set_flashdata('error_delete', '<div id="error" class="alert alert-danger">Không có quyền xóa</div>');
			redirect(base_url().'main/index');
		}else{
			$this->session->set_flashdata('succes_delete', '<div id="success" class="alert alert-success">Xóa Thành Công</div>');
			$this->main_model->delete_data($id);
			redirect(base_url().'main/index');
		}
	}

	// public function create_key()
	// {
	// 	$this->load->library('encryption');
	// 	$key = bin2hex($this->encryption->create_key(16));
	// 	echo $key;
	// }

	#update user details
	public function userDetails($id)
	{
		if ($this->session->has_userdata('username')) {
			$data['title'] = 'Thông tin cá nhân';
			$data['user'] = $this->main_model->fetch_single_data($id);
			$data['userDetails'] = $this->main_model->fetch_userDetails($id);
			$data['level'] = $this->main_model->getLevel();
			$data['id_user']= $id;
			$this->load->view('userdetails_view', $data);
		}else{
			redirect(base_url().'main/index');
		}
	}

	public function userDetails_validation()
	{
		$msg=[];
		$this->form_validation->set_rules('fname','First Name','required|trim|alpha');
		$this->form_validation->set_rules('lname','Last Name','required|trim|alpha');
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		$this->form_validation->set_rules('address','Address','required|trim');
		$this->form_validation->set_rules('phone','Phone','required|trim|min_length[10]');
		$this->form_validation->set_rules('level','Level','required|callback_check_level');
		$this->form_validation->set_message('check_level','Vui lòng chọn quyền người dùng');
			
		if ($this->form_validation->run() == TRUE) {
			$uploadedFile = '';
			$img_current = $this->input->post('img_current');
			
			if (isset($_FILES["upload_data"]["name"]) && $_FILES['upload_data']['name'] != '') {
				#Upload file
				$config['upload_path'] = 'uploads/files/';
				$config['allowed_types'] = 'gif|jpg|png';
				
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('upload_data')){
				 	echo $this->upload->display_errors();
				}
				else{
					if(file_exists('/uploads/files/'.$img_current)){
			            unlink('/uploads/files/'.$img_current);         
			        }
					
					$uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];
				}
			}else{
				$uploadedFile = $img_current;
			}

			$data = [
				'first_name' => $this->input->post('fname'),
				'last_name' => $this->input->post('lname'),
				'email' => $this->input->post('email'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'id_user' => $this->input->post('hidden_idUser'),
				'id_level' => $this->input->post('level'),
				'image' => $uploadedFile,
				'updated_at' => date("Y-m-d H:i:s")
			];
			
			if ($this->main_model->update_userDetails($data)) {
				$this->userDetails($this->input->post('hidden_idUser'));
			}
		}else{
			$this->userDetails($this->input->post('hidden_idUser'));
		}
	}

	public function check_level($value){ 
		return $value == '0' ? false : true;
	}

	public function user_view($id)
	{
		$this->load->view('user_view');
	}

	public function user()
	{
		if ($this->session->has_userdata('username')) {
			echo 'Đây là trang user'.'<br/>';
			echo 'Welcome - '.$this->session->userdata('username').'<br />';
			echo '<a href="'.base_url().'main/login ">Thoát</a>';
		}else{
			redirect(base_url().'main/login');
		}
	}
}
/* End of file main.php */
/* Location: ./application/controllers/main.php */