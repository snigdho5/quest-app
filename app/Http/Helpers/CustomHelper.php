<?php


if ( ! function_exists('checkAccess'))
{
    function checkAccess($role)
    {
        $accessList = get_anydata('admin_type',$role,'access_type');
        $access_type = explode(',',$accessList);
        $access = [];
        foreach ($access_type as $key => $value) {
            $t = explode('_', $value);
            $t[0] = get_anydata('admin_module',$t[0],'link');
            if(isset($access[$t[0]])) array_push($access[$t[0]], $t[1]);
            else $access[$t[0]] = array($t[1]);
        }
        if(is_numeric(request()->segment(3))) $url = request()->segment(2).'/#/'.request()->segment(4);
        else $url = request()->segment(2);
        if(!isset($access[$url])) return [];
        else return $access[$url];
    }
}

if ( ! function_exists('get_anydata'))
{
    function get_anydata($table,$id,$field)
    {
        return DB::table($table)->where('id', $id)->value($field);
    }
}

if ( ! function_exists('get_alldata'))
{
    function get_alldata($table,$where=[],$orderBy=false)
    {
        $data = DB::table($table)->where($where);
        if($orderBy) $data->orderBy($orderBy[0],$orderBy[1]);
        return $data->get();
    }
}


if ( ! function_exists('count_rows'))
{
    function count_rows($table,$where)
    {
        return intval(DB::table($table)->where($where)->count());
    }
}

if ( ! function_exists('sortArrayBy'))
{
    function sortArrayBy($array,$field, $type)
    {
        if ($type = "asc"){
            return collect($array)->sortBy($field)->toArray();
        }else{
            return collect($array)->sortBy($field)->reverse()->toArray();
        }
    }
}



if ( ! function_exists('getModuleInclude'))
{
    function getModuleInclude($content)
    {
        $data = explode('module_include[',$content);

        if(count($data) == 1) return array('content'=>$data);
        else{
            $content = array();
            $fun = array();
            foreach($data as $val){
                $k = explode(']',$val,2);
                if(count($k) == 1) array_push($content,$k[0]);
                else{
                    array_push($fun,$k[0]);
                    array_push($content,$k[1]);
                }
            }
            return compact('fun','content');
        }
    }
}


if(! function_exists('image_crop')){
    function image_crop($src_img,$dst_img,$size=100,$quality=90){

        list($width, $height) = getimagesize($src_img);

        if ($width > $height) {
    		$cropSize = ($width - $height)/2;
    		$cropSize = array('type' => 'x', 'size' => $cropSize);
    	}else{
    		$cropSize = ($height - $width)/2;
    		$cropSize = array('type' => 'y', 'size' => $cropSize);
    	}

        $x_axis=$cropSize['type']=='x'?$cropSize['size']:0;
        $y_axis=$cropSize['type']=='y'?$cropSize['size']:0;

        $cropSize = min($width, $height);

        $img = Image::make($src_img)->crop(intval($cropSize), intval($cropSize), intval($x_axis), intval($y_axis))->resize($size,$size);

    	$img->save($dst_img, $quality);
    	return true;
    }
}

if(! function_exists('image_resize')){
    function image_resize($src_img,$dst_img,$width,$height,$auto='h',$quality=90){

        if($auto=='h') $img = Image::make($src_img)->resize($width, null, function ($_) {$_->aspectRatio();});
        else $img = Image::make($src_img)->resize(null, $height, function ($_) {$_->aspectRatio();});

        $img->save($dst_img, $quality);
        return true;
    }
}


if(! function_exists('filterFileName')){
    function filterFileName($image){
        return time().'_'.str_random(5).'_'.str_slug($image->getClientOriginalName()).'.'.$image->extension();
    }
}

if ( ! function_exists('getLinkData'))
{
    function getLinkData()
    {
        $uri = request()->path();
        $uri = $uri=='/'?'index':$uri;
        $link_data = DB::table('link_data')->where('link',$uri);
        if($link_data->count() AND $link_data->first()->active=='0')
            return false;
        else
            return $link_data->first();
    }
}