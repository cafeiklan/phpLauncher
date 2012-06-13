<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model extends MY_Model {

	protected $table = "users";
	protected $primary_key = "id";
	protected $fields = array("id", "username",	"password", "role_id");
	
	function __construct()
	{
		parent::__construct();	
	}


	/**
	 * Create new user on the site and return some data about it:
	 * user_id, username, password, email, new_email_key (if any).
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	function create_user($username, $password, $role)
	{
		if ((strlen($username) > 0) AND !$this->is_username_available($username)) {
			$this->error = array('username' => 'auth_username_in_use');
		} else {
			// Hash password using phpass
			$hasher = new PasswordHash(8, FALSE);
			$hashed_password = $hasher->HashPassword($password);

			$data = array(
					'username'	=> $username,
					'password'	=> $hashed_password,
					'role_id'		=> $role
			);

			if (!is_null($res = $this->insert($data))) {
				return TRUE;
			}
		}
		return FALSE;
	}

	function update_user($id, $username, $password, $role)
	{
		$olduser = $this->get($id);
		if ((strlen($username) > 0) AND $olduser['username'] != $username AND !$this->is_username_available($username)) {
			$this->error = array('username' => 'auth_username_in_use');
		} else {
			$data = array(
					'username'	=> $username,					
					'role_id'		=> $role,
			);

			if ($password) {
				$hasher = new PasswordHash(8, FALSE);
				$hashed_password = $hasher->HashPassword($password);
				$data['password']	= $hashed_password;
			}
			if (!is_null($res = $this->update($id, $data))) {
				return TRUE;
			}
		}
		return FALSE;
	}

	function del_user($id) {
		return $this->delete($id);
	}

	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		return $this->count_all_results("username", $username) == 0;
	}

}

/* End of file admin.php */
/* Location: ./application/models/admin/admin.php */
