<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Code_editor extends CI_Controller {

	public function __construct() 
	{
        parent::__construct();
        check_adminLogin();
    }

	public function index()
	{	
		if(!$this->input->get('file')) redirect('admin/dashboard/');

		if(is_dir($this->input->get('file'))) redirect('admin/dashboard/');

		if(substr($this->input->get('file'),0,20) != './application/views/') $fileData = 'Sorry! Access Restricted.';
		else $fileData = file_get_contents($this->input->get('file'));

		$this->session->set_userdata(array('prev_data'=>$fileData));

		$fileData = $fileData===false?'Sorry! cannot read file.':$fileData;
		$data['fileData'] = htmlspecialchars($fileData);
		$this->load->view('admin/code_editor/index',$data);
	}

	
}
