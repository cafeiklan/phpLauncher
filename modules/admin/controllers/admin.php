<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();

		//The user has been logged in
		if ($this->tank_auth->is_logged_in()) {
			$role = $this->tank_auth->get_role();

			if ($role != "admin") {
				redirect('/' . $role . '/index');
			}
		} else {
			redirect('/auth/login/');
		}
		$this->load->model('admin/admin_model');
	}

	public function index()
	{
		$data['users'] = $this->users->get_user_list();
		$data['error'] = $this->messages->get("error");
		$data['success'] = $this->messages->get("success");
		//$this->debugbar($data['users']);

		$this->template->write("header", "<h1>账号管理<small>管理注册用户</small></h1>");
		$this->template->write_view("content", "admin/admin_index", $data);
		$this->template->render();
	}
	
	/**
	 * 用户管理部分
	 * 
	 *
	 * @author allenji
	 */
	
	public function user()
	{
		$data['users'] = $this->users->get_user_list();
		$data['error'] = $this->messages->get("error");
		$data['success'] = $this->messages->get("success");

		//$this->debugbar($data['users']);
	
		$this->template->write("header", "<h1>账号管理<small>用户及业务管理</small></h1>");
		$this->template->write_view("content", "admin/admin_user_index", $data);
		$this->template->render();
	}	

	public function user_add() {

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

		if ($this->form_validation->run()) {
			// validation ok
			if ($this->admin_model->create_user(
					$this->input->post('username'),
					$this->input->post('password'),
					$this->input->post('role'))) {									// success
				$this->messages->add("添加用户成功！", 'success');
			} else {
				$this->messages->add("添加用户失败，请重新添加。", 'error');
			}
		} else {
			$this->messages->add("添加用户失败，请重新添加。部分字段不符合要求，请检查。", 'error');
		}
		redirect("/admin/user");
	}

	public function usereditreq($id){
		$data['user'] = $this->admin_model->get($id);
		$this->template->write("header", "<h1>账号管理<small>添加删除注册用户</small></h1>");
		$this->template->write_view("content", "admin/admin_user_edit_form", $data);
		$edithtml = $this->template->render("content");
		echo $edithtml;
	}

	public function user_edit() {

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|xss_clean|matches[password]');

		if ($this->form_validation->run()) {
			// validation ok
			//$this->debugbar($this->input->post());
			if ($this->admin_model->update_user(
					$this->input->post('id'),
					$this->input->post('username'),
					$this->input->post('password'),
					$this->input->post('role'))) {
				// success
				$this->messages->add("修改用户信息成功！", 'success');
			} else {
				$this->messages->add("修改用户信息失败，请重新操作。", 'error');
			}
		} else {
			$this->messages->add("修改用户信息失败，请重新操作。", 'error');
		}
		redirect("/admin/user");
	}
	
	public function userdelreq($id){
		$data['user'] = $this->admin_model->get($id);
		$this->template->write("header", "<h1>账号管理<small>添加删除注册用户</small></h1>");
		$this->template->write_view("content", "admin/admin_user_del_form", $data);
		$edithtml = $this->template->render("content");
		echo $edithtml;
	}	

	public function user_del($id){
		if($this->admin_model->del_user($id)){
			$this->messages->add("删除用户成功！", 'success');
		} else {
			$this->messages->add("删除用户失败，请重试。", 'error');
		}
		redirect("/admin/user");
	}

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
