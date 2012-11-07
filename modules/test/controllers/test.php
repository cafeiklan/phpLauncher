<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {
	function __construct()
	{
		parent::__construct();
	}
	
	//用于测试form_validation
	public function form()
	{
		$this->template->write("header", "<h1>表单验证及上传插件测试</h1>");
		$this->template->write_view("content", "test/form");
		$this->template->render();
	}

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
