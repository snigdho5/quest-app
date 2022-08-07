<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cms extends CI_Controller {
	private $tableName;
	private $menuData;
	public function __construct()
	{
        parent::__construct();
		check_adminLogin();
		$menuList = $this->main_model->fetch('arg_admin_type',array('id'=>$_SESSION['role']));
		$menuList = $this->main_model->fetch_in('arg_admin_module','id',explode(',',$menuList[0]['module']),'id');
		$this->menuData['menuList'] = $menuList;
		$this->tableName = 'arg_cms';
    }
	public function index()
	{
		if($this->input->post())
		{
			$order = intval(get_anydata($this->tableName,'priority', $this->input->post('id')));
			$parent_id = intval(get_anydata($this->tableName,'parent_id', $this->input->post('id')));
			if($order < intval($this->input->post('o')))
				$this->main_model->update($this->tableName, 'priority', array('priority>'=>$order,'priority<='=>$this->input->post('o'),'parent_id'=>$parent_id),'`priority`-1');
			else $this->main_model->update($this->tableName, 'priority', array('priority<'=>$order,'priority>='=>$this->input->post('o'),'parent_id'=>$parent_id),'`priority`+1');
			$updateArr = array(
				'priority' => $this->input->post('o'),
				'modified' => time()
			);
			$this->main_model->update($this->tableName, $updateArr, array('id' => $this->input->post('id')));
			$this->session->set_flashdata('success', 'Order has been changed successfully');
			redirect('admin/cms', 'refresh');
		}
		$cmsArr = $this->main_model->fetch($this->tableName);
		$data['dataArr'] = array(
			'cmsArr' => $cmsArr,
		);
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/cms/index', $data);
		$this->load->view('admin/include/footer');
	}
	public function create()
	{
		if($this->input->post())
		{
			if($this->input->post("actual_value")==$this->input->post("slug")){
			    $this->form_validation->set_rules('slug', 'Seo URL', 'trim|required|alpha_dash');
			}else{
			    $this->form_validation->set_rules('slug', 'Seo URL', 'trim|required|alpha_dash|is_unique[arg_cms.slug]');
			}
			if($this->form_validation->run() !== FALSE)
			{
				$filename = '';
				if($_FILES['image']['name'])
				{
					$config2['file_name'] = time().'_'.str_replace(' ','_',$_FILES['image']['name']);
					$config2['upload_path'] = './uploads/cms/actual';
					$config2['allowed_types'] = 'jpeg|jpg|png';
					$config2['max_size'] = 4096;
					$this->load->library('upload', $config2);
					if(!$this->upload->do_upload('image'))
					{
						$cmsArr = $this->main_model->fetch($this->tableName);
						$data['dataArr'] = array(
							'cmsArr' => $cmsArr,
							'ferr_msg' => $this->upload->display_errors()
						);
						$this->load->view('admin/include/header',$this->menuData);
						$this->load->view('admin/cms/create',$data);
						$this->load->view('admin/include/footer');
					}
					$filename = $this->upload->data('file_name');
				}
				$mimgfile = '';
				if($_FILES['meta_image']['name']){
					$config['file_name'] = time().'_'.str_replace(' ','_',$_FILES['meta_image']['name']);
					$config['upload_path'] = './uploads/link_data/actual';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 4096;
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('meta_image'))
					{
						$data['dataArr'] = array(
							'err_msg' => $this->upload->display_errors()
						);
					}
					else
					{
						$mimgfile = $this->upload->data('file_name');
					}
				}
				$addArr = array(
					'title' => $this->input->post('title'),
					'slug' => $this->input->post('slug'),
					'parent_id' => $this->input->post('parent_id')?$this->input->post('parent_id'):0,
					'meta_desc' => $this->input->post('meta_desc'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'priority' => $this->input->post('parent_id')?(count_rows($this->tableName,array('parent_id'=>$this->input->post('parent_id')))+1):0,
					'meta_image' => $mimgfile,
					//'image' => $imgname,
					'image' => $filename,
					'post_time' => strtotime($this->input->post('post_time')),
					'content' => $this->input->post('content'),
					//'header_text' => $this->input->post('header_text'),
					'active' => $this->input->post('active'),
					'created' => time(),
					'modified' => time()
				);
				$this->main_model->create($this->tableName, $addArr);
				$this->session->set_flashdata('success', 'Page has been added successfully');
				redirect('admin/cms/', 'refresh');
			}
		}
		$cmsArr = $this->main_model->fetch($this->tableName,array('parent_id'=>0));
		$data['dataArr'] = array(
			'cmsArr' => $cmsArr,
		);
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/cms/create',$data);
		$this->load->view('admin/include/footer');
	}
	public function view()
	{
		if(!$this->input->get()) redirect('admin/cms/', 'refresh');
		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$cmsArr = $this->main_model->fetch($this->tableName, $where);
		$data['dataArr']['cmsArr'] = $cmsArr;
		//print_r($data['dataArr']['cmsArr']);//exit();
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/cms/view',$data);
		$this->load->view('admin/include/footer');
	}
	public function edit()
	{
		if(!$this->input->get()) redirect('admin/cms/', 'refresh');
		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$cmsArr = $this->main_model->fetch($this->tableName,$where);
		$mimgfile = $cmsArr[0]['meta_image'];
		$filename = $cmsArr[0]['image'];
		if($this->input->post())
		{
			if($this->input->post("actual_value")==$this->input->post("slug")){
			    $this->form_validation->set_rules('slug', 'Seo URL', 'trim|required|alpha_dash');
			}else{
			    $this->form_validation->set_rules('slug', 'Seo URL', 'trim|required|alpha_dash|is_unique[arg_cms.slug]');
			}
			if($this->form_validation->run() !== FALSE)
			{
				if($_FILES['image']['name'])
				{
					$config2['file_name'] = time().'_'.str_replace(' ','_',$_FILES['image']['name']);
					$config2['upload_path'] = './uploads/cms/actual';
					$config2['allowed_types'] = 'jpeg|jpg|png';
					$config2['max_size'] = 4096;
					$this->load->library('upload', $config2);
					if(!$this->upload->do_upload('image'))
					{
						$cmsArrAll = $this->main_model->fetch($this->tableName);
						$data['dataArr'] = array(
							'cmsArrAll' => $cmsArrAll,
							'cmsArr' => $cmsArr,
							'ferr_msg' => $this->upload->display_errors()
						);
						$this->load->view('admin/include/header',$this->menuData);
						$this->load->view('admin/cms/edit', $data);
						$this->load->view('admin/include/footer');
					}
					@unlink('./uploads/cms/actual/'.$cmsArr[0]['image']);
					$filename = $this->upload->data('file_name');
				}

				if($_FILES['meta_image']['name'])
				{
					$config['file_name'] = time().'_'.str_replace(' ','_',$_FILES['meta_image']['name']);
					$config['upload_path'] = './uploads/link_data/actual';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 4096;
					if(!$this->load->is_loaded('upload')) $this->load->library('upload');
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('meta_image'))
					{
						$data['dataArr'] = array(
							'err_msg' => $this->upload->display_errors()
						);
					}
					@unlink('./uploads/link_data/actual/'.$cmsArr[0]['meta_image']);
					$mimgfile = $this->upload->data('file_name');
				}

				$updateArr = array(
					'title' => $this->input->post('title'),
					'slug' => $this->input->post('slug'),
					'image' => $filename,
					'parent_id' => $this->input->post('parent_id')?$this->input->post('parent_id'):0,
					'meta_title' => $this->input->post('meta_title'),
					'meta_desc' => $this->input->post('meta_desc'),
					'post_time' => strtotime($this->input->post('post_time')),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_image' => $mimgfile,
					'content' => $this->input->post('content'),
					//'header_text' => $this->input->post('header_text'),
					'active' => $this->input->post('active'),
					'modified' => time()
				);
				$this->main_model->update($this->tableName, $updateArr, $where);
				$this->session->set_flashdata('success', 'Page has been updated successfully');
				redirect('admin/cms/', 'refresh');

			}
		}
		$cmsArrAll = $this->main_model->fetch($this->tableName,array('parent_id'=>0));
		$data['dataArr'] = array(
			'cmsArrAll' => $cmsArrAll,
			'cmsArr' => $cmsArr,
		);
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/cms/edit', $data);
		$this->load->view('admin/include/footer');
	}
	public function delete()
	{
		if($_SESSION['del_privilege']=='0'){
			$this->session->set_flashdata('error', 'Sorry! you don`t have permission to delete!');$url=str_replace('delete','',current_url());
			redirect($url, 'refresh');
		}
		if(!$this->input->get()) redirect('admin/cms/', 'refresh');
		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$cmsArr = $this->main_model->fetch($this->tableName, $where);
		$order = $cmsArr[0]['priority'];
		$this->main_model->update($this->tableName, 'priority', array('priority>'=>$order,'parent_id'=>$cmsArr[0]['parent_id']),'`priority`-1');
		unlink('./uploads/cms/actual/'.$cmsArr[0]['image']);
		@unlink('./uploads/link_data/actual/'.$cmsArr[0]['meta_image']);
		$this->main_model->delete($this->tableName, $where);
		$this->session->set_flashdata('success', 'Page has been deleted successfully');

		redirect('admin/cms/', 'refresh');
	}
	public function change_status()
	{
		if(!$this->input->get()) redirect('admin/cms/', 'refresh');
		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$updateArr = array(
			'active' => $this->input->get('val', TRUE),
			'modified' => time()
		);
		$this->main_model->update($this->tableName, $updateArr, $where);
		$this->session->set_flashdata('success', 'Status has been changed successfully');
		redirect('admin/cms/', 'refresh');
	}
	// delete pdf
	public function delimg()
	{
		if(!$this->input->get()) redirect('admin/cms/', 'refresh');
		$where = array(
			'id' => $this->input->get('id', TRUE),
		);
		$proArr = $this->main_model->fetch($this->tableName, $where);
		unlink('./uploads/cms/actual/'.$proArr[0]['image']);
		$updateArr = array(
			'image' => '',
			'modified' => time()
		);
		$this->main_model->update($this->tableName, $updateArr, $where);
		redirect('admin/cms/edit/?id='.$this->input->get('id', TRUE), 'refresh');
	}
}
