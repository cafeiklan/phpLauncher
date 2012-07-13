<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
		/*判断是否登录，判断当前URL是否是auth/login*/
		if ( ! $this->tank_auth->is_logged_in()
				&& ( $this->router->fetch_class() != 'auth' && $this->router->fetch_method() != 'login'))
		{
			$redirect = $this->uri->uri_string();
		
			if ( $_SERVER['QUERY_STRING'])
			{
				$redirect .= '?' . $_SERVER['QUERY_STRING'];
			}
			/*跳转到用户登陆页面，指定Login后跳转的URL*/
			redirect('auth/login?redirect='.$redirect);
		}		
		
	}
}

