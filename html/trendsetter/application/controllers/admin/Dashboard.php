<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	private $tableName;
	private $menuData;

	public function __construct() 
	{
        parent::__construct();

        check_adminLogin();
		$menuList = $this->main_model->fetch('arg_admin_type',array('id'=>$_SESSION['role']));
		$menuList = $this->main_model->fetch_in('arg_admin_module','id',explode(',',$menuList[0]['module']),'id');
		$this->menuData['menuList'] = $menuList;
        
		$this->tableName = 'arg_admin';
    }

	public function index()
	{
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/dashboard');
		$this->load->view('admin/include/footer');
	}
}