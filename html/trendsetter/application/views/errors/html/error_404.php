<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
if( ! isset($CI))
{
    $CI = new CI_Controller();
}
$CI->load->helper('url');
$siteData = $CI->main_model->fetch('arg_site_setting')[0];
$linkData = count(getLinkData()) > 0?getLinkData()[0]:array();

$navData = $CI->main_model->fetch('arg_navigation',array('active'=>'1','parent_id'=>'0'),'priority');
$navData['navData'] = $navData;
$headerData['metaData']=array(
	'meta_desc' => isset($linkData['meta_desc'])?$linkData['meta_desc']:'',
	'meta_keyword' => isset($linkData['meta_keyword'])?$linkData['meta_keyword']:'',
	'meta_image' => isset($linkData['image'])?'uploads/link_data/'.$linkData['image']:'',
);
$headerData['title'] = isset($linkData['meta_title'])?$linkData['meta_title']:'';
$headerData['faviconLink'] = 'uploads/logo_icon/'.$siteData['favicon'];

//CUSTOM CAPTCHA
$CI->load->library('custom_captcha');

$CI->load->view('include/header',$headerData);
$CI->load->view('include/navbar',$navData);

echo '<br><br><h1><center>PAGE NOT FOUND</center></h1>';
echo '<h2><center>The link you clicked may be broken or <br> the page may have been  removed.</center></h2><br><br>';

$CI->load->view('include/footer');


?>
