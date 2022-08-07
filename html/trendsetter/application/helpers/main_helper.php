<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_adminLogin'))
{
    function check_adminLogin($page='')
    {
		$CI = get_instance();

		if($page == 'login'){
			if($CI->session->has_userdata('admin_id')) redirect('admin/dashboard/', 'refresh');
		}
		else{
			if(!$CI->session->has_userdata('admin_id')) redirect('admin/logout/', 'refresh');
		}

    }
}


if ( ! function_exists('get_anydata'))
{
    function get_anydata($table,$field,$id)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        return $CI->main_model->get_anydata($table,$field,$id);
    }
}

if ( ! function_exists('get_alldata'))
{
    function get_alldata($table,$where)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        return $CI->main_model->fetch($table,$where);
    }
}

if ( ! function_exists('count_rows'))
{
    function count_rows($table,$where)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        return intval($CI->main_model->count_rows($table,$where));
    }
}


if ( ! function_exists('getCropSize'))
{
    function getCropSize($width,$height)
    {
    	if ($width > $height) {
    		$size = ($width - $height)/2;
    		$size = array('type' => 'x', 'size' => $size);
    	}else{
    		$size = ($height - $width)/2;
    		$size = array('type' => 'y', 'size' => $size);
    	}

		return $size;
    }
}

if ( ! function_exists('getLinkData'))
{
    function getLinkData()
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $uri = $CI->uri->uri_string().'/';
        $uri = $uri=='/'?'index/':$uri;

        $link_data = $CI->main_model->fetch('arg_link_data',array('link'=>$uri));
        if(isset($link_data[0]) AND $link_data[0]['active']=='0')
            redirect ('unavailable/', 'refresh');
        else
            return $CI->main_model->fetch('arg_link_data',array('link'=>$uri));
    }
}

if ( ! function_exists('getColorScheme'))
{
    function getColorScheme($type='')
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $uri = $CI->uri->uri_string();
        $uri = $uri==''?'index/':$uri;

        $color =  $CI->main_model->fetch('arg_link_data',array('link'=>$uri));
        if(count($color) == 1){
            return  $CI->main_model->fetch('arg_color_scheme',array('id'=>$color[0]['color_scheme']))[0];
        }elseif($type == 'cms'){

            $uri = $CI->uri->segment_array();
            $uri = end($uri);
            $cms = $CI->main_model->fetch('arg_cms',array('slug'=> $uri));
            if(count($cms) == 1){
                return  $CI->main_model->fetch('arg_color_scheme',array('id'=>$cms[0]['color_scheme']))[0];
            }else return array();
        }elseif($type == 'pro_cat'){

            $uri = $CI->uri->segment_array();
            $uri = end($uri);
            $pro_cat = $CI->main_model->fetch('arg_product_cat',array('LCASE(title)'=> str_replace('-',' ',$uri)));
            if(count($pro_cat) == 1){
                return  $CI->main_model->fetch('arg_color_scheme',array('id'=>$pro_cat[0]['color_scheme']))[0];
            }else return array();
        }elseif($type == 'product'){

            $uri = $CI->uri->segment_array();
            $uri = end($uri);
            $product = $CI->main_model->fetch('arg_product',array('LCASE(title)'=> str_replace('-',' ',$uri)));
            if(count($product) == 1){
                return  $CI->main_model->fetch('arg_color_scheme',array('id'=>$product[0]['color_scheme']))[0];
            }else return array();
        }elseif($type == 'mem_cat'){

            $uri = $CI->uri->segment_array();
            $uri = end($uri);
            $mem_cat = $CI->main_model->fetch('arg_member_cat',array('LCASE(title)'=> str_replace('-',' ',$uri)));
            if(count($mem_cat) == 1){
                return  $CI->main_model->fetch('arg_color_scheme',array('id'=>$mem_cat[0]['color_scheme']))[0];
            }else return array();
        }else return array();

    }
}

if ( ! function_exists('productLink'))
{
    function productLink($id)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $pro = $CI->main_model->fetch('arg_product',array('id'=>$id))[0];
        if($pro['cat_id'] == 0){
            $link =  base_url().strtolower(str_replace(' ','-',$pro['title'])).'/';
        }else{
            $link =  procatLink($pro['cat_id']).strtolower(str_replace(' ','-',$pro['title'])).'/';
        }
        return $link;

    }
}

if ( ! function_exists('procatLink'))
{
    function procatLink($id)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $link =  strtolower(str_replace(' ','-',get_anydata('arg_product_cat','title',$id))).'/';
        $parent = get_anydata('arg_product_cat','parent_id',$id);
        while($parent != '0'){
            $link =  strtolower(str_replace(' ','-',get_anydata('arg_product_cat','title',$parent))).'/'.$link;
            $parent = get_anydata('arg_product_cat','parent_id',$parent);
        }
        return base_url().$link;

    }
}

if ( ! function_exists('memcatLink'))
{
    function memcatLink($id)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $link =  strtolower(str_replace(' ','-',get_anydata('arg_member_cat','title',$id))).'/';
        $parent = get_anydata('arg_member_cat','parent_id',$id);
        while($parent != '0'){
            $link =  strtolower(str_replace(' ','-',get_anydata('arg_member_cat','title',$parent))).'/'.$link;
            $parent = get_anydata('arg_member_cat','parent_id',$parent);
        }
        return base_url().$link;
    }
}

if ( ! function_exists('memberLink'))
{
    function memberLink($id)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $mem = $CI->main_model->fetch('arg_member',array('id'=>$id))[0];
        if($mem['cat_id'] == 0){
            $link =  base_url().strtolower(str_replace(' ','-',$mem['title'])).'/';
        }else{
            $link =  memcatLink($mem['cat_id']).strtolower(str_replace(' ','-',$mem['title'])).'/';
        }
        return $link;

    }
}

if ( ! function_exists('cmsLink'))
{
    function cmsLink($slug)
    {
        $CI = get_instance();
        $CI->load->model('main_model');

        $cms = $CI->main_model->fetch('arg_cms',array('slug'=> $slug))[0];

        $link =  $cms['slug'].'/';
        $parent = $cms['parent_id'];
        while($parent != '0'){
            $link =  get_anydata('arg_cms','slug',$parent).'/'.$link;
            $parent = get_anydata('arg_cms','parent_id',$parent);
        }
        return base_url().$link;

    }
}


if ( ! function_exists('getModuleInclude'))
{
    function getModuleInclude($content)
    {
        $data = explode('module_include[',$content);

        if(count($data) == 1) return $data;
        elseif(count($data) == 2){
            $k = explode(']',$data[1]);
            $m = explode(',',$k[0]);
            $module[0] = $data[0].'[---]'.$k[1];
            $module[1] = $m[0];
            $module[2] = $m[1];
            return $module;
        }
    }
}


if ( ! function_exists('sortArrayBy'))
{
    function sortArrayBy($field, &$array, $direction = 'asc')
    {
        $direction = strtolower(trim($direction));

        usort($array, create_function('$a, $b', '
            $a = $a["' . $field . '"];
            $b = $b["' . $field . '"];

            if ($a == $b) return 0;

            return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
        '));

        return true;
    }
}

if ( ! function_exists('genSlug'))
{
    function genSlug($text)
    {
        return strtolower(str_replace(' ','-',$text));
    }
}