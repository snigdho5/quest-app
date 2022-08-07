<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $tableName;
	private $menuData;

	public function __construct()
	{
        parent::__construct();

		check_adminLogin('login');

		$this->tableName = 'arg_admin';
    }

	public function index()
	{

		$data = array();
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|exact_length[5]|in_list['.$this->session->userdata('admin_cap').']',array('in_list' => 'Invalied captcha code!'));

		if($this->form_validation->run() !== FALSE)
		{
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$adminArr = $this->main_model->isAdmin($username,$password);

			if($adminArr)
			{
				if($adminArr[0]['active']=='1'){
					$adminData = array(
						'admin_id' => $adminArr[0]['id'],
						'username' => $adminArr[0]['username'],
						'name' => $adminArr[0]['name'],
						'role' => $adminArr[0]['role'],
						'del_privilege' => $adminArr[0]['del']
					);
					$where = array(
						'id' => $adminArr[0]['id'],
					);
					$updateArr = array(
						'last_login' => time()
					);
					$this->main_model->update($this->tableName, $updateArr, $where);
					$this->session->unset_userdata('admin_cap');
					$this->session->set_userdata($adminData);
					redirect('admin/dashboard/', 'refresh');
				}
				else $data['err_msg'] = 'Sorry! Access restricted';
			}
			else
				$data['err_msg'] = 'Invalid username / password!';
		}

		$this->load->library('custom_captcha');
		$capData = $this->custom_captcha->generate('#222','#fff',110,40,10,500,'#666');
		$data['capData']=$capData;
		$this->session->set_userdata(array('admin_cap'=>$capData['text']));
		$siteArr = $this->main_model->fetch('arg_site_setting',array('id'=>'1'));
		$data['site'] = $siteArr;

		$this->load->view('admin/login', $data);
	}
}