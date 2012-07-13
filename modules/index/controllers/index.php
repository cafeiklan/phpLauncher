<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{		
		//echo modules::run("auth/tank_auth/is_logged_in");exit;
		if ($this->tank_auth->is_logged_in()) {
			$role = $this->tank_auth->get_role();
			//echo $role;
			redirect('/' . $role . '/index');
		} else {
			redirect('/auth/login/');
		}		

	}

	//use table_torch
	function torch(){
		// you can do this in any method you like
		// !! you would obviously need to do your authorization prior to letting the world see your Table Torch
		$this->load->spark( 'table_torch/1.1.2');
		$this->table_torch->route();
	}

	//use tracer
	function tracer(){
		$this->benchmark->mark('code_start');
		$this->load->spark( 'tracer/0.6.0');		
		$this->benchmark->mark('code_end');
		// keep on rendering page if false ( default )
		trace( $_SERVER, FALSE );
		// exit php and rendering if true
		//trace( $_SERVER, TRUE );
	}
	//use messages
	function message(){
		$this->load->spark("messages/1.0.2");
		$this->messages->add("An error has occurred", "error");
		$this->messages->add("Thank you for registering", "error");
		$this->messages->add("Please not this message", "message");

		$errors = $this->messages->get("error");
		foreach($errors as $error)
			echo 'error: '.$error.'<br>';
	}

	//use mobiledetection
	function mobile(){
		$this->load->spark('mobiledetection/1.0.1');
		echo "***".$this->mobiledetection->isMobile()."***";
		exit;
	}

	function clean(){
		//clean the asserts generated files
		$this->assets->clear_cache();

	}

}
