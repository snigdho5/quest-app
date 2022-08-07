<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\Banner;
use App\Models\AdminModels\StoreDeal;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\StoreType;
use App\Models\AdminModels\StoreCategory;
use App\Models\AdminModels\MoviePoster;
use App\Models\AdminModels\Blog;
use App\Models\AdminModels\BlogCategory;
use App\Models\AdminModels\Event;
use App\Models\AdminModels\EventGallery;
use App\Models\AdminModels\Map;
use App\Models\AdminModels\LoftBanner;
use App\Models\AdminModels\Cms;
use App\Models\AdminModels\News;
use App\Models\AdminModels\Gallery;
use App\Models\AdminModels\Qreview;
use App\Models\AdminModels\Qauthor;
use App\Models\AdminModels\ReviewTag;
use App\Models\AdminModels\QreviewGallery;
use App\Models\AdminModels\SiteSettings;
use App\Models\User;

class SiteController extends Controller
{
    Public $metaData;

    public function __construct(){
        $this->metaData = getLinkData();
    }

    public function index()
    {
        $deals = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->orderby("post_time","DESC")->limit(50)->get();
        $totalDeals = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->orderby("post_time","DESC")->count();

        $banner = Banner::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("priority","ASC")->limit(6)->get();


        $dines = Store::select('id','name','post_time','cuisine')
                        ->where([['active','1'],['s_type','dine'],['post_time','<=',date("Y-m-d H:i:s")]])->where(function ($query) {
                            $query->where('category_id', 'not like', '8,%')
                                  ->Where('category_id', 'not like', '%,8')
                                  ->Where('category_id', 'not like', '%,8,%')
                                  ->Where('category_id', '!=', '8');
                        })->orderby("post_time","DESC")->limit(4)->get();

        $moviePoster = MoviePoster::where('active','1')->orderby("priority")->get();

        $blogs = Blog::select('sq_image','slug', "post_time","title")->where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->limit(2)->get();

        $qreview = Qreview::select('image','slug', "post_time","title")->where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->first();

        $events = Event::where([['type','loft'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("end_date","DESC")->limit(1)->get();

$events = Event::where([['active','1'],['type','quest'],['post_time','<=',date("Y-m-d H:i:s")]]);
            if(request()->type && request()->type != "all"){
                if (request()->type == "current") {
                    $events = $events->whereDate('end_date','>=', date('Y-m-d'))->whereDate('start_date','<=', date('Y-m-d'));
                }
                elseif (request()->type == "upcoming") {
                    $events = $events->whereDate('start_date','>', date('Y-m-d'));
                }
                elseif (request()->type == "past") {
                    $events = $events->whereDate('end_date','<', date('Y-m-d'));
                }
            }
            $eventsCount = $events->count();
            $eventsData = $events->orderby("start_date","DESC")->limit(3)->get();
        

            $metaData = $this->metaData;

 
$dineData = Store::select('id','name','logo','post_time','cuisine')
                        ->where([['active','1'],['s_type','dine'],['post_time','<=',date("Y-m-d H:i:s")]])->where(function ($query) {
                            $query->where('category_id', 'not like', '8,%')
                                  ->Where('category_id', 'not like', '%,8')
                                  ->Where('category_id', 'not like', '%,8,%')
                                  ->Where('category_id', '!=', '8');
                        })->orderby("post_time","DESC")->limit(12)->get();


$storeData = Store::where([['active','1'],['s_type','store'],['post_time','<=',date("Y-m-d H:i:s")]]);
        if(request()->search){
            $storeData = $storeData->search(["name","description"],request()->search);
        }
        if(request()->category && request()->category!='deals'){
            $storeData = $storeData->where(function ($query) {
                            $query->where('category_id', 'like', request()->category.',%')
                                  ->orWhere('category_id', 'like', '%,'.request()->category)
                                  ->orWhere('category_id', 'like', '%,'.request()->category.',%')
                                  ->orWhere('category_id', '=', request()->category);
                        });
        }elseif(request()->category && request()->category=='deals'){
            $stores = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC")->pluck('store_id')->toArray();

            $storeData = $storeData->whereIn('id', $stores);
        }
        if(request()->type && request()->type != "all"){
            $storeData = $storeData->where('type_id',request()->type);
        }
        if(request()->floor && request()->floor != "all"){
            $storeData = $storeData->where('floor',request()->floor);
        }
        $storeCount = $storeData->count();
        $storeData = $storeData->orderby("name","asc")->limit(12)->get();
        //return view('storelist',compact('storeCount','storeData','typeData','catData'));


           return view('index',compact('deals','totalDeals','banner','dines','moviePoster','blogs','events','qreview','eventsData','eventsCount','metaData','dineData','storeCount','storeData'));


    }

    public function cms($slug,$sub_slug='',$sub_sub_slug='')
    {
        $cmsData = Cms::where([['slug',$slug],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]]);
        if($cmsData->count() == 0) abort(404);
        $cmsData = $cmsData->first();

        $module = getModuleInclude($cmsData->content);
        if(count($module['content'])==1){
            $cmsData->content = array('content'=>$module['content']);
        }else{
            foreach ($module['fun'] as $key => $value) {

                if ($sub_sub_slug) {
                    $functionProperty = new \ReflectionMethod($this,$value);
                    if($functionProperty->getNumberOfParameters() <2){
                        abort(404);
                    }
                    $module['fun'][$key] = $this->$value($sub_slug,$sub_sub_slug);
                }
                elseif ($sub_slug) {
                    $functionProperty = new \ReflectionMethod($this,$value);
                    if($functionProperty->getNumberOfParameters() ==0){
                        abort(404);
                    }
                    $module['fun'][$key] = $this->$value($sub_slug);
                }
                else $module['fun'][$key] = $this->$value();

                if ($module['fun'][$key] == false) abort(404);
                if(is_array($module['fun'][$key])){
                    $metaData = $module['fun'][$key]['meta'];
                    $module['fun'][$key] = $module['fun'][$key]['content'];

                    if(isset($metaData->meta_title)) $cmsData->title = $metaData->meta_title;
                }
            }
            $cmsData->content = array('content'=>$module['content'],'module'=>$module['fun']);
        }


        if(!isset($metaData)){
            if ($this->metaData == false) $metaData = $cmsData;
            else $metaData = $this->metaData;
        }


        return view('cms',compact('cmsData','metaData','sub_slug'));
    }

    public function mallMap()
    {
        $mapData = Map::where('active','1')->orderby('id')->get();
        return view('mall_map',compact('mapData'));
    }

    public function storeList($slug='')
    {
        if($slug) return $this->store($slug);

        $typeData = StoreType::select('id','title')->where([['type', 'store'],['active','1']])->orderby("title")->get();
        $catData = StoreCategory::select('id','title')->where([['type', 'store'],['active','1']])->orderby("title")->get();

        $storeData = Store::where([['active','1'],['s_type','store'],['post_time','<=',date("Y-m-d H:i:s")]]);
        if(request()->search){
            $storeData = $storeData->search(["name","description"],request()->search);
        }
        if(request()->category && request()->category!='deals'){
            $storeData = $storeData->where(function ($query) {
                            $query->where('category_id', 'like', request()->category.',%')
                                  ->orWhere('category_id', 'like', '%,'.request()->category)
                                  ->orWhere('category_id', 'like', '%,'.request()->category.',%')
                                  ->orWhere('category_id', '=', request()->category);
                        });
        }elseif(request()->category && request()->category=='deals'){
            $stores = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC")->pluck('store_id')->toArray();

            $storeData = $storeData->whereIn('id', $stores);
        }
        if(request()->type && request()->type != "all"){
            $storeData = $storeData->where('type_id',request()->type);
        }
        if(request()->floor && request()->floor != "all"){
            $storeData = $storeData->where('floor',request()->floor);
        }
        $storeCount = $storeData->count();
        $storeData = $storeData->orderby("name","asc")->limit(18)->get();
        return view('storelist',compact('storeCount','storeData','typeData','catData'));
    }

    public function dineList($slug='')
    {
        if($slug) return $this->dine($slug);

        $typeData = StoreType::select('id','title')->where([['type', 'dine'],['active','1']])->orderby("title")->get();
        $catData = StoreCategory::select('id','title')->where([['type', 'dine'],['active','1']])->orderby("title")->get();

        $dineData = Store::where([['active','1'],['s_type','dine'],['post_time','<=',date("Y-m-d H:i:s")]]);
        if(request()->search){
            $dineData = $dineData->search(["name","description"],request()->search);
        }
        if(request()->category && request()->category!='deals'){
            $dineData = $dineData->where(function ($query) {
                            $query->where('category_id', 'like', request()->category.',%')
                                  ->orWhere('category_id', 'like', '%,'.request()->category)
                                  ->orWhere('category_id', 'like', '%,'.request()->category.',%')
                                  ->orWhere('category_id', '=', request()->category);
                        });
        }elseif(request()->category && request()->category=='deals'){
            $dines = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC")->pluck('store_id')->toArray();

            $dineData = $dineData->whereIn('id', $dines);
        }
        if(request()->type && request()->type != "all"){
            $dineData = $dineData->where('type_id',request()->type);
        }
        if(request()->floor && request()->floor != "all"){
            $dineData = $dineData->where('floor',request()->floor);
        }
        $dineCount = $dineData->count();
        $dineData = $dineData->orderby("name","asc")->limit(18)->get();
        return view('dinelist',compact('dineCount','dineData','typeData','catData'));
    }

    public function store($slug)
    {
        $stores = Store::where([['active','1'],['s_type','store'],['post_time','<=',date("Y-m-d H:i:s")]])->get();

        foreach ($stores as $key => $value) {
            if(str_slug($value->name) == $slug){
                $storeData = $value;
                $storeBanner = $value->banner()->where('active','1')->orderby('priority')->get();
                $storeDeals = $value->deals()->where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->orderby("post_time","DESC")->get();
                $otherStores = Store::select('name','logo')->where([['id','<>',$value->id],['type_id',$value->type_id],['active','1'],['s_type','store'],['post_time','<=',date("Y-m-d H:i:s")]])->limit(8)->get();

                $metaData = new \stdClass();
                $metaData->meta_title = $storeData->meta_title?$storeData->meta_title:$storeData->name;
                $metaData->meta_desc = $storeData->meta_desc?$storeData->meta_desc:str_limit(strip_tags($storeData->description),120);
                $metaData->meta_keyword = $storeData->meta_keyword?$storeData->meta_keyword:'';

                return array('content'=>view('store',compact('storeData','storeBanner','otherStores','storeDeals')),'meta'=>$metaData);
            }
        }
        return false;
    }

    public function dine($slug)
    {
        $dine = Store::where([['active','1'],['s_type','dine'],['post_time','<=',date("Y-m-d H:i:s")]])->get();
        foreach ($dine as $key => $value) {
            if(str_slug($value->name) == $slug){
                $dineData = $value;
                $dineBanner = $value->banner()->where('active','1')->orderby('priority')->get();
                $dineDeals = $value->deals()->where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->orderby("post_time","DESC")->get();
                $otherDines = Store::select('name','logo')->where([['id','<>',$value->id],['type_id',$value->type_id],['active','1'],['s_type','dine'],['post_time','<=',date("Y-m-d H:i:s")]])->limit(8)->get();

                $metaData = new \stdClass();
                $metaData->meta_title = $dineData->meta_title?$dineData->meta_title:$dineData->name;
                $metaData->meta_desc = $dineData->meta_desc?$dineData->meta_desc:str_limit(strip_tags($dineData->description),120);
                $metaData->meta_keyword = $dineData->meta_keyword?$dineData->meta_keyword:'';

                return array('content'=>view('dine',compact('dineData','dineBanner','otherDines','dineDeals')),'meta'=>$metaData);
            }
        }
    }

    public function deals()
    {
        $deals = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC");
        $typeData = StoreType::select('id','title')->where('active','1')->orderby("title")->get();

        if(request()->type && request()->type != "all"){
    		$stores = StoreType::find(request()->type)->stores()->where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->pluck('id')->toArray();

    		$deals = $deals->whereIn('store_id', $stores);
        }

        $dealsCount = $deals->count();
        $dealsData = $deals->orderby("post_time","DESC")->limit(9)->get();



        return view('deals',compact('dealsData','dealsCount','typeData'));


    }

    public function blog($slug=''){
        if ($slug) {
            $blogData = Blog::where([['slug',$slug],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]]);

            if($blogData->count()==0) abort(404);
            $blogData = $blogData->first();

            $relatedData = Blog::where([['category_id',$blogData->category_id],['id','<>',$blogData->id],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->limit(4)->get();

            $latestData = Blog::where([['id','<>',$blogData->id],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->limit(4)->get();

            $metaData = new \stdClass();
            $metaData->meta_title = $blogData->meta_title?$blogData->meta_title:$blogData->title;
            $metaData->meta_desc = $blogData->meta_desc?$blogData->meta_desc:str_limit(strip_tags($blogData->content),120);
            $metaData->meta_keyword = $blogData->meta_keyword?$blogData->meta_keyword:'';
            $metaData->meta_image = $blogData->meta_image?$blogData->meta_image:'';

            $deals = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->orderby("post_time","DESC")->limit(5)->get();

            return array('content'=>view('blog_details',compact('blogData','relatedData','latestData','deals')),'meta'=>$metaData);
        }else{
            $blogCat = BlogCategory::where('active','1')->get();
            $blogData = Blog::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->paginate(6);
            return view('bloglist',compact('blogData','blogCat'));
        }
    }


    public function loft(){
        $eventData = Event::where([['type','loft'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->whereDate('start_date','<', date('Y-m-d'))->orderby("start_date","DESC")->limit(1)->get();
        $upcomingData = Event::where([['type','loft'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('start_date','>', date('Y-m-d'))->orderby("start_date","DESC")->get();
        $pastData = Event::where([['type','loft'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','<', date('Y-m-d'))->orderby("start_date","DESC")->get();
        $bannerData = LoftBanner::where('active','1')->orderby("priority")->get();
        return view('loft',compact('bannerData','eventData','upcomingData','pastData'));
    }

    public function loftEvents($slug=''){
        if ($slug) {
            $eventData = Event::where([['slug',$slug],['active','1'],['type','loft'],['post_time','<=',date("Y-m-d H:i:s")]])->first();
            $eventBanner = $eventData->banner()->where('active','1')->get();

            $otherData = Event::where([['id','<>',$eventData->id],['active','1'],['type','loft'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("start_date","DESC")->limit(10)->get();

            $metaData = new \stdClass();
            $metaData->meta_title = $eventData->meta_title?$eventData->meta_title:$eventData->title;
            $metaData->meta_desc = $eventData->meta_desc?$eventData->meta_desc:str_limit(strip_tags($eventData->content),120);
            $metaData->meta_keyword = $eventData->meta_keyword?$eventData->meta_keyword:'';

            return view('loft_event_details',compact('eventData','eventBanner','metaData','otherData'));
        }else{
            $events = Event::where([['active','1'],['type','loft'],['post_time','<=',date("Y-m-d H:i:s")]]);
            if(request()->type && request()->type != "all"){
                if (request()->type == "current") {
                    $events = $events->whereDate('end_date','>=', date('Y-m-d'))->whereDate('start_date','<=', date('Y-m-d'));
                }
                elseif (request()->type == "upcoming") {
                    $events = $events->whereDate('start_date','>', date('Y-m-d'));
                }
                elseif (request()->type == "past") {
                    $events = $events->whereDate('end_date','<', date('Y-m-d'));
                }
            }
            $eventsCount = $events->count();
            $eventsData = $events->orderby("start_date","DESC")->get();

            $metaData = $this->metaData;

            return view('loft_event_list',compact('eventsData','eventsCount','metaData'));
        }

    }

    public function event($slug='')
    {
        if ($slug) {
            $eventData = Event::where([['slug',$slug],['active','1'],['type','quest'],['post_time','<=',date("Y-m-d H:i:s")]])->first();
            $eventBanner = $eventData->banner()->where('active','1')->get();

            $otherData = Event::where([['id','<>',$eventData->id],['active','1'],['type','quest'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("start_date","DESC")->limit(10)->get();

            $metaData = new \stdClass();
            $metaData->meta_title = $eventData->meta_title?$eventData->meta_title:$eventData->title;
            $metaData->meta_desc = $eventData->meta_desc?$eventData->meta_desc:str_limit(strip_tags($eventData->content),120);
            $metaData->meta_keyword = $eventData->meta_keyword?$eventData->meta_keyword:'';
            return array('content'=>view('event_details',compact('eventData','eventBanner','otherData')),'meta'=>$metaData);
        }else{
            $events = Event::where([['active','1'],['type','quest'],['post_time','<=',date("Y-m-d H:i:s")]]);
            if(request()->type && request()->type != "all"){
                if (request()->type == "current") {
                    $events = $events->whereDate('end_date','>=', date('Y-m-d'))->whereDate('start_date','<=', date('Y-m-d'));
                }
                elseif (request()->type == "upcoming") {
                    $events = $events->whereDate('start_date','>', date('Y-m-d'));
                }
                elseif (request()->type == "past") {
                    $events = $events->whereDate('end_date','<', date('Y-m-d'));
                }
            }
            $eventsCount = $events->count();
            $eventsData = $events->orderby("start_date","DESC")->limit(9)->get();
            return view('event_list',compact('eventsData','eventsCount'));
        }
    }

    public function newsList()
    {
        $latestData = Blog::where([['active','1'],['post_time','<=',date("Y-m-d h:i:s")]])->orderby("post_time","DESC")->limit(3)->get();
        $newsData = News::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->paginate(8);
        return view('newslist',compact('newsData','latestData'));
    }



    public function gallery($slug='')
    {
        if ($slug) {
            $galleryData = Gallery::where([['slug',$slug],['active','1']])->first();
            $galleryImages = $galleryData->images()->where('active','1')->get();
            $otherData = Gallery::where([['active','1'],['id','<>',$galleryData->id]])->orderby("date","DESC")->limit(6)->get();


            return view('gallery_details',compact('galleryData','galleryImages','otherData'));
        }else{
            $galleryData = Gallery::where('active','1')->orderby("date","DESC")->paginate(6);
            return view('gallery_list',compact('galleryData'));
        }
    }



    public function qreview($slug='',$sub_slug=''){
        if ($slug!='tag' && $slug!='author' && $slug!='') {
            $tagData = ReviewTag::where([['active','1']])->get();

            $blogData = Qreview::where([['slug',$slug],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]]);
            if($blogData->count()==0) abort(404);
            $blogData = $blogData->first();

            $relatedData = Qreview::where([['id','<>',$blogData->id],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->limit(4)->get();

            $latestData = Blog::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->limit(4)->get();

            $metaData = new \stdClass();
            $metaData->meta_title = $blogData->meta_title?$blogData->meta_title:$blogData->title;
            $metaData->meta_desc = $blogData->meta_desc?$blogData->meta_desc:str_limit(strip_tags($blogData->content),120);
            $metaData->meta_keyword = $blogData->meta_keyword?$blogData->meta_keyword:'';
            $metaData->meta_image = $blogData->meta_image?$blogData->meta_image:'';

            $deals = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->orderby("post_time","DESC")->limit(5)->get();

            return array('content'=>view('qreview_details',compact('blogData','relatedData','latestData','deals','tagData')),'meta'=>$metaData);
        }elseif($slug==''){
            $blogData = Qreview::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->orderby("post_time","DESC")->paginate(6);
            return view('qreviewlist',compact('blogData'));
        }
        elseif($slug=='tag'){
            $tags = ReviewTag::where([['active','1'],['title',$sub_slug]])->first();
            $blogData = Qreview::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                ->where(function ($query) use($tags) {
                                    $query->where('tags', 'like', $tags->id.',%')
                                          ->orWhere('tags', 'like', '%,'.$tags->id)
                                          ->orWhere('tags', 'like', '%,'.$tags->id.',%')
                                          ->orWhere('tags', '=', $tags->id);
                                })->orderby("post_time","DESC")->paginate(6);

            return view('qreviewlist',compact('blogData'));
        }
         elseif($slug=='author'){
            $author = Qauthor::where([['active','1'],['title',$sub_slug]])->first();
            $blogData = Qreview::where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                ->where(function ($query) use($author) {
                                    $query->where('author', 'like', $author->id.',%')
                                          ->orWhere('author', 'like', '%,'.$author->id)
                                          ->orWhere('author', 'like', '%,'.$author->id.',%')
                                          ->orWhere('author', '=', $author->id);
                                })->orderby("post_time","DESC")->paginate(6);

            return view('qreviewlist',compact('blogData'));
        }
    }


    public function referralTrack($value)
    {
        $validUser = User::where([['referral_code',$value],['active','1']]);
        if($validUser->count()>0){
            $siteData = SiteSettings::find(1);
            return view('referal_track',compact('siteData'));
        }else{
            abort(404);
        }
    }

}
