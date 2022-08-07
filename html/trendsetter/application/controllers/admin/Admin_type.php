<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_type extends CI_Controller {

	private $tableName;
	private $menuData;

	public function __construct() 
	{
        parent::__construct();
		check_adminLogin();
		$menuList = $this->main_model->fetch('arg_admin_type',array('id'=>$_SESSION['role']));
		$menuList = $this->main_model->fetch_in('arg_admin_module','id',explode(',',$menuList[0]['module']),'id');
		$this->menuData['menuList'] = $menuList;
			
		$this->tableName = 'arg_admin_type';
    }

	public function index()
	{
		$typArr = $this->main_model->fetch($this->tableName);
		$data['dataArr'] = array(
			'typArr' => $typArr,
		);

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_type/index', $data);
		$this->load->view('admin/include/footer');
	}

	public function create()
	{
		if($this->input->post())
		{	
			$addArr = array(
				'title' => $this->input->post('title'),
				'module' => implode(',',$this->input->post('module')),
				'active' => $this->input->post('active')
			);
			$this->main_model->create($this->tableName, $addArr);
			$this->session->set_flashdata('success', 'Type has been added successfully');
			
			redirect('admin/admin_type/', 'refresh');
		}

		$modArr = $this->main_model->fetch('arg_admin_module','','id');
		$data['dataArr'] = array(
			'modArr' => $modArr,
		);
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_type/create',$data);
		$this->load->view('admin/include/footer');
	}
	
	public function view()
	{
		if(!$this->input->get()) redirect('admin/admin_type/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$typArr = $this->main_model->fetch($this->tableName, $where);
		$data['dataArr']['typArr'] = $typArr;
		
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_type/view',$data);
		$this->load->view('admin/include/footer');
	}
	
	public function edit()
	{	
		if(!$this->input->get()) redirect('admin/admin_type/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$typArr = $this->main_model->fetch($this->tableName,$where);
		
		if($this->input->post())
		{
			$updateArr = array(
				'title' => $this->input->post('title'),
				'module' => implode(',',$this->input->post('module')),
				'active' => $this->input->post('active')
			);
			$this->main_model->update($this->tableName, $updateArr, $where);
			$this->session->set_flashdata('success', 'Type has been updated successfully');
			
			redirect('admin/admin_type/', 'refresh');
		}

		$modArr = $this->main_model->fetch('arg_admin_module','','id');
		$data['dataArr'] = array(
			'typArr' => $typArr,
			'modArr' => $modArr
		);

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/admin_type/edit', $data);
		$this->load->view('admin/include/footer');
	}
	
	public function delete()
	{
		if($_SESSION['del_privilege']=='0'){
			$this->session->set_flashdata('error', 'Sorry! you don`t have permission to delete!');$url=str_replace('delete','',current_url());
			redirect($url, 'refresh');
		}
		if(!$this->input->get()) redirect('admin/admin_type/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$this->main_model->delete($this->tableName, $where);
		$this->session->set_flashdata('success', 'Type has been deleted successfully');
		
		redirect('admin/admin_type/', 'refresh');
	}
	
	public function change_status()
	{	
		if(!$this->input->get()) redirect('admin/admin_type/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$updateArr = array(
			'active' => $this->input->get('val', TRUE)
		);
		$this->main_model->update($this->tableName, $updateArr, $where);
		$this->session->set_flashdata('success', 'Status has been changed successfully');
		
		redirect('admin/admin_type/', 'refresh');
	}
}
