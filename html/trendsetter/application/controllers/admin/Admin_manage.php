<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_manage extends CI_Controller {

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
		$adminArr = $this->main_model->fetch($this->tableName);
		$data['dataArr'] = array(
			'adminArr' => $adminArr,
		);

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_manage/index', $data);
		$this->load->view('admin/include/footer');
	}

	public function create()
	{
		if($this->input->post())
		{
			$addArr = array(
				'name' => $this->input->post('name'),
				'role' => $this->input->post('role'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'del'=>$this->input->post('role')==1?1:0,
				'active' => $this->input->post('active')
			);
			$this->main_model->create($this->tableName, $addArr);
			$this->session->set_flashdata('success', 'Admin has been added successfully');

			redirect('admin/admin_manage/', 'refresh');
		}

		$catArr = $this->main_model->fetch('arg_admin_type');
		$data['dataArr'] = array(
			'catArr' => $catArr,
		);

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_manage/create',$data);
		$this->load->view('admin/include/footer');
	}

	public function view()
	{
		if(!$this->input->get()) redirect('admin/admin_manage/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$adminArr = $this->main_model->fetch($this->tableName, $where);
		$data['dataArr']['adminArr'] = $adminArr;

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_manage/view',$data);
		$this->load->view('admin/include/footer');
	}

	public function edit()
	{
		if(!$this->input->get()) redirect('admin/admin_manage/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$adminArr = $this->main_model->fetch($this->tableName,$where);

		if($this->input->post())
		{

			$updateArr = array(
				'name' => $this->input->post('name'),
				'role' => $this->input->post('role'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')!=''?md5($this->input->post('password')):$adminArr[0]['password'],
				'del'=>$this->input->post('role')==1?1:0,
				'active' => $this->input->post('active')
			);
			$this->main_model->update($this->tableName, $updateArr, $where);
			$this->session->set_flashdata('success', 'Admin has been updated successfully');

			redirect('admin/admin_manage/', 'refresh');
		}

		$catArr = $this->main_model->fetch('arg_admin_type');

		$data['dataArr'] = array(
			'adminArr' => $adminArr,
			'catArr' => $catArr
		);

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_manage/edit', $data);
		$this->load->view('admin/include/footer');
	}

	public function delete()
	{
		if($_SESSION['del_privilege']=='0'){
			$this->session->set_flashdata('error', 'Sorry! you don`t have permission to delete!');$url=str_replace('delete','',current_url());
			redirect($url, 'refresh');
		}
		if(!$this->input->get()) redirect('admin/admin_manage/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$this->main_model->delete($this->tableName, $where);
		$this->session->set_flashdata('success', 'admin has been deleted successfully');

		redirect('admin/admin_manage/', 'refresh');
	}

	public function change_status()
	{
		if(!$this->input->get()) redirect('admin/admin_manage/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$updateArr = array(
			'active' => $this->input->get('val', TRUE)
		);
		$this->main_model->update($this->tableName, $updateArr, $where);
		$this->session->set_flashdata('success', 'Status has been changed successfully');

		redirect('admin/admin_manage/', 'refresh');
	}



}
