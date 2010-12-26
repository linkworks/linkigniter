<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function test()
	{
	  $u = Doctrine_Core::getTable('User')->findOneById(1);
	  echo $u->username;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */