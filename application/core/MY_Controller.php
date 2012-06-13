<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
		//$this->load->module("auth");
		//$this->load->model('auth/tank_auth/users');
		//$this->lang->load('tank_auth');
		//$this->load->model('admin/admin_model');
	}

	function debugbar($var){
		//$this->load->spark('Debug-Toolbar/1.0.7');
		$this->load->library('console');
		//$this->load->library('profiler');
		$this->output->enable_profiler(true);
		Console::log($var);
	}


}

