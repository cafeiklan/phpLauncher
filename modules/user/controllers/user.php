<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	function __construct()
	{
		parent::__construct();

		//The user has been logged in
		if ($this->tank_auth->is_logged_in()) {
			$role = $this->tank_auth->get_role();

			if ($role != "user") {
				redirect('/' . $role . '/index');
			} 
		} else {
			redirect('/auth/login/');
		}

	}

	public function index()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['role']		= $this->tank_auth->get_role();
		$data['email']		= $this->tank_auth->get_email();
		
		$this->load->helper('gravatar_helper');
		$this->template->write("header", "<h1>用户首页</h1>");
		$this->template->write_view("content", "user/profile", $data);
		$this->template->render();
	}

	public function profile()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role']		= $this->tank_auth->get_role();
			$data['email']		= $this->tank_auth->get_email();

			$this->load->helper('gravatar_helper');
			$this->template->write("header", "<h1>My Profile <small> Registered User</small></h1>");
			$this->template->write_view("content", "user/profile", $data);
			$this->template->render();
		}
	}

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
