<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Site_setting extends CI_Controller {
	private $tableName;
	private $menuData;
	public function __construct()
	{
        parent::__construct();
		check_adminLogin();
		$menuList = $this->main_model->fetch('arg_admin_type',array('id'=>$_SESSION['role']));
		$menuList = $this->main_model->fetch_in('arg_admin_module','id',explode(',',$menuList[0]['module']),'id');
		$this->menuData['menuList'] = $menuList;
		$this->tableName = 'arg_site_setting';
    }
	public function index()
	{
		$settingArr = $this->main_model->fetch($this->tableName);
		$data['dataArr'] = array(
			'settingArr' => $settingArr
		);
		if($this->input->post())
		{
			$logo_name = $settingArr[0]['logo'];
			$flogo_name = $settingArr[0]['flogo'];
			$favicon_name = $settingArr[0]['favicon'];
			$disc_img_name = $settingArr[0]['disc_img'];
			$disc_logo_name = $settingArr[0]['disc_logo'];
			$back_name = $settingArr[0]['login_back'];
			$config1['upload_path'] = './uploads/logo_icon';
			$config1['allowed_types'] = 'png';
			$this->load->library('upload', $config1);
			if($_FILES['logo']['name'])
			{
				$config1['file_name'] = time().'_'.str_replace(' ','_',$_FILES['logo']['name']);
				$this->upload->initialize($config1);
				if(!$this->upload->do_upload('logo'))
				{
					$data['dataArr']['err_msg'] = $this->upload->display_errors();
				}
				@unlink('./uploads/logo_icon/'.$logo_name);
				$logo_name = $this->upload->data('file_name');
			}
			if($_FILES['flogo']['name'])
			{
				$config1['file_name'] = time().'_'.str_replace(' ','_',$_FILES['flogo']['name']);
				$this->upload->initialize($config1);
				if(!$this->upload->do_upload('flogo'))
				{
					$data['dataArr']['ferr_msg'] = $this->upload->display_errors();
				}
				@unlink('./uploads/logo_icon/'.$flogo_name);
				$flogo_name = $this->upload->data('file_name');
			}
			if($_FILES['favicon']['name'])
			{
				$config1['file_name'] = time().'_'.str_replace(' ','_',$_FILES['favicon']['name']);
				$this->upload->initialize($config1);
				if(!$this->upload->do_upload('favicon'))
				{
					$data['dataArr']['ierr_msg'] = $this->upload->display_errors();
				}
				@unlink('./uploads/logo_icon/'.$favicon_name);
				$favicon_name = $this->upload->data('file_name');
			}
			if($_FILES['login_back']['name'])
			{
				$config1['file_name'] = time().'_'.str_replace(' ','_',$_FILES['login_back']['name']);
				$config1['allowed_types'] = 'jpeg|jpg';
				$this->upload->initialize($config1);
				if(!$this->upload->do_upload('login_back'))
				{
					$data['dataArr']['jerr_msg'] = $this->upload->display_errors();
				}
				@unlink('./uploads/logo_icon/'.$back_name);
				$back_name = $this->upload->data('file_name');
				$config['image_library'] = 'gd2';
				$config['source_image'] = './uploads/logo_icon/'.$this->upload->data('file_name');
				$config['new_image'] = './uploads/logo_icon/'.$this->upload->data('file_name');
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 1366;
				$config['height'] = 768;
				$config['quality'] = '70%';
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}
			if($_FILES['disc_img']['name'])
			{
				$config1['file_name'] = time().'_'.str_replace(' ','_',$_FILES['disc_img']['name']);
				$config1['allowed_types'] = 'jpeg|jpg';
				$this->upload->initialize($config1);
				if(!$this->upload->do_upload('disc_img'))
				{
					$data['dataArr']['idberr_msg'] = $this->upload->display_errors();
				}
				@unlink('./uploads/logo_icon/'.$disc_img_name);
				$disc_img_name = $this->upload->data('file_name');
			}
			if($_FILES['disc_logo']['name'])
			{
				$config1['file_name'] = time().'_'.str_replace(' ','_',$_FILES['disc_logo']['name']);
				$config1['allowed_types'] = 'png';
				$this->upload->initialize($config1);
				if(!$this->upload->do_upload('disc_logo'))
				{
					$data['dataArr']['idberr_msg'] = $this->upload->display_errors();
				}
				@unlink('./uploads/logo_icon/'.$disc_logo_name);
				$disc_logo_name = $this->upload->data('file_name');
			}
			$updateArr = array(
				'logo' => $logo_name,
				'flogo' => $flogo_name,
				'favicon' => $favicon_name,
				'login_back' => $back_name,
				'disc_logo' => $disc_logo_name,
				'disc_img' => $disc_img_name,
				'facebook' => $this->input->post('facebook'),
				'email' => $this->input->post('email'),
				'instagram' => $this->input->post('instagram'),
				'linkedin' => $this->input->post('linkedin'),
				'twitter' => $this->input->post('twitter'),
				'youtube' => $this->input->post('youtube'),
				'pinterest' => $this->input->post('pinterest'),
				'disclaimer' => $this->input->post('disclaimer'),
				'address' => $this->input->post('address'),
				'who_we_qt' => $this->input->post('who_we_qt'),
				'our_people_qt' => $this->input->post('our_people_qt'),
				'google_map' => $this->input->post('google_map'),
				'ggl_analytic' => $this->input->post('ggl_analytic'),
				'ggl_analytic_ns' => $this->input->post('ggl_analytic_ns'),
				'modified' => time()
			);
			$where = array('id'=>'1');
			$this->main_model->update($this->tableName, $updateArr, $where);
			$this->session->set_flashdata('success', 'Site settings has been updated successfully');
			redirect('admin/site_setting/', 'refresh');
		}
		$this->load->view('admin/include/header',$this->menuData);
		$this->load->view('admin/site_setting',$data);
		$this->load->view('admin/include/footer');
	}
}
