<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trendsetter extends CI_Controller {

	private $tableName;
	private $menuData;

	public function __construct()
	{
        parent::__construct();
		check_adminLogin();
		$menuList = $this->main_model->fetch('arg_admin_type',array('id'=>$_SESSION['role']));
		$menuList = $this->main_model->fetch_in('arg_admin_module','id',explode(',',$menuList[0]['module']),'id');
		$this->menuData['menuList'] = $menuList;

		$this->tableName = 'arg_trendsetter';
    }

	public function index()
	{
		$trendsetterArr = $this->main_model->fetch($this->tableName);
		$data['dataArr'] = array(
			'trendsetterArr' => $trendsetterArr,
		);

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/trendsetter/index', $data);
		$this->load->view('admin/include/footer');
	}

	public function view()
	{
		if(!$this->input->get()) redirect('admin/trendsetter/', 'refresh');

		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$trendsetterArr = $this->main_model->fetch($this->tableName, $where);
		$data['dataArr']['trendsetterArr'] = $trendsetterArr;

		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/trendsetter/view',$data);
		$this->load->view('admin/include/footer');
	}

	public function delete()
	{
		if($_SESSION['del_privilege']=='0'){
			$this->session->set_flashdata('error', 'Sorry! you don`t have permission to delete!');$url=str_replace('delete','',current_url());
			redirect($url, 'refresh');
		}
		if(!$this->input->get()) redirect('admin/trendsetter/', 'refresh');

		// $where = array(
		// 	'id' => $this->input->get('id', TRUE),
		// );
		// $trendsetterArr = $this->main_model->fetch($this->tableName, $where);
		// $this->main_model->delete($this->tableName, $where);
		// $this->session->set_flashdata('success', 'Contact query has been deleted successfully');

		redirect('admin/trendsetter/', 'refresh');
	}

}
