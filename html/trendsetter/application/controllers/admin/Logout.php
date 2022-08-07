<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct() 
	{
        parent::__construct();
    }

	public function index()
	{

		$adminData = array('admin_id', 'username', 'name', 'email');
		$this->session->unset_userdata($adminData);
		
		redirect('admin/login/', 'refresh');
	}

}