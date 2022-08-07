<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\AdminModels\Blog;
use App\Models\AdminModels\LoftDesigner;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\Event;
use App\Models\AdminModels\StoreDeal;
use App\Models\AdminModels\Contest;



class AjaxController extends Controller
{
	public function __construct(){
        $this->middleware('auth:admin');
    }

    public function cmsSlug(Request $request){
        $slug = $request->slug;
        $final_slug = $slug;
        $i=1;
        if ($request->has('id')) {
            if(count_rows('cms', [['slug',$slug],['id','!=',$request->id]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('cms', [['slug',$final_slug],['id','!=',$request->id]]) == 1);
            }
        }else{
            if(count_rows('cms', [['slug',$slug]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('cms', [['slug',$final_slug]]) == 1);
            }
        }
        return $final_slug;
    }


    public function blogSlug(Request $request){
        $slug = $request->slug;
        $final_slug = $slug;
        $i=1;
        if ($request->has('id')) {
            if(count_rows('blog', [['slug',$slug],['id','!=',$request->id]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('blog', [['slug',$final_slug],['id','!=',$request->id]]) == 1);
            }
        }else{
            if(count_rows('blog', [['slug',$slug]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('blog', [['slug',$final_slug]]) == 1);
            }
        }
        return $final_slug;
    }


    public function qreviewSlug(Request $request){
        $slug = $request->slug;
        $final_slug = $slug;
        $i=1;
        if ($request->has('id')) {
            if(count_rows('qreview', [['slug',$slug],['id','!=',$request->id]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('qreview', [['slug',$final_slug],['id','!=',$request->id]]) == 1);
            }
        }else{
            if(count_rows('qreview', [['slug',$slug]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('qreview', [['slug',$final_slug]]) == 1);
            }
        }
        return $final_slug;
    }




    public function eventSlug(Request $request){
        $slug = $request->slug;
        $final_slug = $slug;
        $i=1;
        if ($request->has('id')) {
            if(count_rows('event', [['slug',$slug],['id','!=',$request->id]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('event', [['slug',$final_slug],['id','!=',$request->id]]) == 1);
            }
        }else{
            if(count_rows('event', [['slug',$slug]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('event', [['slug',$final_slug]]) == 1);
            }
        }
        return $final_slug;
    }


    public function gallerySlug(Request $request){
        $slug = $request->slug;
        $final_slug = $slug;
        $i=1;
        if ($request->has('id')) {
            if(count_rows('gallery', [['slug',$slug],['id','!=',$request->id]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('gallery', [['slug',$final_slug],['id','!=',$request->id]]) == 1);
            }
        }else{
            if(count_rows('gallery', [['slug',$slug]]) == 1){
                do{
                    $final_slug = $slug.'-'.$i;
                    $i++;
                }while(count_rows('gallery', [['slug',$final_slug]]) == 1);
            }
        }
        return $final_slug;
    }



    public function getAppBannerPageDetails(Request $request)
    {
        $searchResult = [];

        if($request->pageName=='bloginner'){
            $searchResult = Blog::select('title','id')->where([['active','1'],['post_time','<=',date('Y-m-d h:i a')]])->orderby('post_time','DESC')->get()->toArray();
        }
        elseif($request->pageName=='designerinner'){
            $searchResult = LoftDesigner::select('name as title','id')->where('active','1')->get()->toArray();
        }
        elseif($request->pageName=='dineinner'){
            $searchResult = Store::select('name as title','id')->where([['active','1'],['s_type','dine'],['post_time','<=',date('Y-m-d h:i a')]])->get()->toArray();
        }
        elseif($request->pageName=='eventinner'){
             $searchResult = Event::select('title','id')->where([['active','1'],['post_time','<=',date('Y-m-d h:i a')],['type','quest']])->orderby('post_time','DESC')->get()->toArray();
        }
        elseif($request->pageName=='lofteventinner'){
           $searchResult = Event::select('title','id')->where([['active','1'],['type','loft']])->orderby('post_time','DESC')->get()->toArray();
        }
        elseif($request->pageName=='offerinner'){
            $searchResult = StoreDeal::select('title','id','description')->where([['active','1'],['post_time','<=',date('Y-m-d h:i a')]])->orderby('post_time','DESC')->get()->toArray();
            foreach ($searchResult as $key => $value) {
               $searchResult[$key]['title'] = $value['title'].' : '. $value['description'];
            }
        }
        elseif($request->pageName=='storeinner'){
           $searchResult = Store::select('name as title','id')->where([['active','1'],['s_type','store'],['post_time','<=',date('Y-m-d h:i a')]])->get()->toArray();
        }
        elseif($request->pageName=='dinenwin'){
           $searchResult = Contest::select('name as title','id')->where([['active','1']])->get()->toArray();
        }

        echo json_encode($searchResult);
    }
}
