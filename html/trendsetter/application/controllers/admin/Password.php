<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {

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
		$where = array(
			'id' => $this->session->userdata('admin_id'),
		);
		
		if($this->input->post())
		{
			$data = array();
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
		
			if($this->form_validation->run() !== FALSE)
			{
				$password = md5($this->input->post('password'));
				$updateArr = array(
					'password' => $password,
				);

				$this->main_model->update($this->tableName, $updateArr, $where);
				$this->session->set_flashdata('success', 'Password has been updated successfully');
				
				redirect('admin/password/', 'refresh');
			}
			
		}

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/password');
		$this->load->view('admin/include/footer');
	}



}
