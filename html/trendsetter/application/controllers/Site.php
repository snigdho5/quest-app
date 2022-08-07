<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public $siteData;
	public $linkData;
	private $navData;
	private $headerData;
	private $mainData;

	public function __construct()
	{

		parent::__construct();
		$this->db->cache_on(); 
		$this->siteData = $this->main_model->fetch('arg_site_setting')[0]; 
		//$this->linkData = count(getLinkData()) > 0?getLinkData()[0]:array(); 

		$this->navData = $this->main_model->fetch('arg_navigation',array('active'=>'1','parent_id'=>'0','post_time<='=>time()),'priority');
		$this->navData['navData'] = $this->navData;
		$this->headerData['metaData']=array(
			'title' => isset($this->linkData['meta_title'])?$this->linkData['meta_title']:'',
			'meta_desc' => isset($this->linkData['meta_desc'])?$this->linkData['meta_desc']:'',
			'meta_keyword' => isset($this->linkData['meta_keyword'])?$this->linkData['meta_keyword']:'',
			'meta_image' => isset($this->linkData['image'])?'uploads/link_data/'.$this->linkData['image']:'',
		);
		$this->headerData['title'] = isset($this->linkData['meta_title'])?$this->linkData['meta_title']:'';
		$this->headerData['faviconLink'] = 'uploads/logo_icon/'.$this->siteData['favicon'];

		//CUSTOM CAPTCHA
		$this->load->library('custom_captcha');
		
		//Disclaimer
		if(!isset($_SESSION['disc'])){
			$this->headerData['disc'] = 1;
		}
	}

	public function index()
	{   
		$data = $this->mainData;

		// checking if cms or independent page
		$uri = $this->uri->segment_array();
		$uri = (count($uri)==0 || end($uri)=='home' || end($uri)=='index')?'home':end($uri);
		$cms = $this->main_model->fetch('arg_cms',array('slug'=> $uri));
		if(count($cms) == 1){
			$this->cmsPage($cms,$data);
		}else{

			if($uri=='home'){
				
				$this->load->view('index');
			}else show_404();
		}
	}

	public function whoTrendsetter()
	{
		$this->load->view('who-trendsetter');
	}
	public function whyTrendsetter()
	{
		$this->load->view('why-trendsetter');
	}

	public function cmsPage($page,$data){

		if(!$this->session->has_userdata('admin_id'))
			if(($page[0]['post_time'] > time()) || ($page[0]['active'] == '0')) show_404();

		if(cmsLink($page[0]['slug']) != current_url().'/') redirect(cmsLink($page[0]['slug']),true);

		if($this->headerData['metaData']['meta_desc'] == '')
			$this->headerData['metaData']['meta_desc'] = $page[0]['meta_desc'];
		if($this->headerData['metaData']['meta_keyword'] == '')
			$this->headerData['metaData']['meta_keyword'] = $page[0]['meta_keyword'];
		if($this->headerData['metaData']['meta_image'] == '')
			$this->headerData['metaData']['meta_image'] = 'uploads/link_data/actual/'.($page[0]['meta_image']?$page[0]['meta_image']:$page[0]['image']);

		$module = getModuleInclude($page[0]['content']);
		$page[0]['content']=$module[0];
		$data['pageData'] = $page[0];
		if(count($module)>1){
			if(file_exists(APPPATH.'views/include/'.$module[1].'.php')){
				$data['module'] = 'include/'.$module[1];
				$data['moduleData'] = $this->main_model->fetch($module[2]);
			}
		}
		if($this->headerData['title'] == '')
			$this->headerData['title'] = $page[0]['meta_title']!=''?$page[0]['meta_title']:$page[0]['title'];

		$this->load->view('include/header',$this->headerData);
		$this->load->view('include/navbar',$this->navData);
		$this->load->view('cms_page',$data);
		$this->load->view('include/footer');
	}

	
}
