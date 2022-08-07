<?php

namespace App\Http\Controllers\AppApiControllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Models\AdminModels\AppNavigation;
use App\Models\AdminModels\SiteSettings;
use App\Models\AdminModels\LoftBanner;
use App\Models\AdminModels\LoftDesigner;
use App\Models\AdminModels\AppBanner;
use App\Models\AdminModels\AppPush;
use App\Models\AdminModels\Beacon;
use App\Models\AdminModels\StoreDeal;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\StoreType;
use App\Models\AdminModels\StoreRating;
use App\Models\AdminModels\DineCuisine;
use App\Models\AdminModels\StoreCategory;
use App\Models\AdminModels\StoreBanner;
use App\Models\AdminModels\StoreContactNo;
use App\Models\AdminModels\StoreContactEmail;
use App\Models\AdminModels\Event;
use App\Models\AdminModels\EventGallery;
use App\Models\AdminModels\MoviePoster;
use App\Models\AdminModels\Blog;
use App\Models\AdminModels\BlogCategory;
use App\Models\AdminModels\Qreview;
use App\Models\AdminModels\Qauthor;
use App\Models\AdminModels\ReviewTag;
use App\Models\AdminModels\QreviewGallery;
use App\Models\AdminModels\CameraFrame;
use App\Models\AdminModels\Cms;
use App\Models\AdminModels\Map;
use App\Models\AdminModels\WalkLevel;
use App\Models\AdminModels\WalkOffer;
use App\Models\AdminModels\UserWalkOffer;
use App\Models\AdminModels\Contest;
use App\Models\AdminModels\StoreAppDeal;
use App\Models\AdminModels\StoreAppDealDayTime;
use App\Models\AdminModels\StoreAppDealClaimed;
use App\Models\User;
use App\Models\Feedback;

use App\Mail\EmailVerify;
use App\Mail\ResetPassword;
use App\Mail\OfferClaimed;

class AjaxController extends Controller
{
    public function __construct(){

    }

    public function getHome(){

        // app banner
        $data = AppBanner::select('image','action',"page")->where('active','1')->orderby('priority','asc')->get()->toArray();
        echo json_encode($data);

        // current deals
        $data = StoreDeal::select('image','id', "post_time")->where([['active','1'],['beacon_type','0'],['image','!=',''],['store_id','!=','0']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC")->limit(5)->get()->toArray();
        echo json_encode($data);

        // new openings
        $data = Store::select('id','logo',"post_time")
                        ->where([['active','1'],['s_type','store']])->where(function ($query) {
                            $query->where('category_id', 'like', '1,%')
                                  ->orWhere('category_id', 'like', '%,1')
                                  ->orWhere('category_id', 'like', '%,1,%')
                                  ->orWhere('category_id', '=', '1');
                        })->orderby("post_time","DESC")->limit(5)->get()->toArray();
        echo json_encode($data);

        // Current events
        $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','quest'],['active','1']])->orderby("start_date","DESC")->limit(5)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
            $data[$key]['image'] = $value['sq_image'];
        }
        echo json_encode($data);

        // loft events
        $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','loft'],['active','1']])->orderby("start_date","DESC")->limit(5)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
            $data[$key]['image'] = $value['sq_image'];
        }
        echo json_encode($data);

        // dine
        $data = Store::select('id','logo','name',"post_time")
                        ->where([['active','1'],['s_type','dine']])->where(function ($query) {
                            $query->where('category_id', 'like', '1,%')
                                  ->orWhere('category_id', 'like', '%,1')
                                  ->orWhere('category_id', 'like', '%,1,%')
                                  ->orWhere('category_id', '=', '1');
                        })->orderby("post_time","DESC")->limit(5)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['feature_img'] = StoreBanner::where([['active','1'],['featured','1'],['store_id',$value['id']]])->value('image');

        }
        echo json_encode($data);

        // movies
        $data = MoviePoster::select('image','link')->where('active','1')->orderby("priority","asc")->get()->toArray();
        echo json_encode($data);

        // blog
        $data = Blog::select('image','id', "post_time","title","category_id")->where('active','1')->orderby("post_time","DESC")->limit(5)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['post_time'] = date("dS M, Y",strtotime($data[$key]['post_time']));
            $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
        }
        echo json_encode($data);


        // top stores
        $data = Store::select('id','logo',"post_time",'view')
                        ->where([['active','1'],['s_type','store']])->where(function ($query) {
                            $query->where('category_id', 'not like', '5,%')
                                  ->Where('category_id', 'not like', '%,5')
                                  ->Where('category_id', 'not like', '%,5,%')
                                  ->Where('category_id', '!=', '5');
                        })->orderby("view","DESC")->limit(5)->get()->toArray();

        echo json_encode($data);

        // top dine
        $data = Store::select('id','logo','name',"post_time",'view')
                        ->where([['active','1'],['s_type','dine']])->where(function ($query) {
                            $query->where('category_id', 'not like', '8,%')
                                  ->Where('category_id', 'not like', '%,8')
                                  ->Where('category_id', 'not like', '%,8,%')
                                  ->Where('category_id', '!=', '8');
                        })->orderby("post_time","DESC")->limit(5)->get()->toArray();

        echo json_encode($data);


        // policies
        $data = SiteSettings::select('app_terms','app_policies','app_disc','app_version_and','app_version_ios')
                        ->where('id','1')->get()->toArray();
        echo json_encode($data);

        // upcoming stores
        $data = Store::select('id','logo',"post_time")
                        ->where([['active','1'],['s_type','store']])->where(function ($query) {
                            $query->where('category_id', 'like', '5,%')
                                  ->orWhere('category_id', 'like', '%,5')
                                  ->orWhere('category_id', 'like', '%,5,%')
                                  ->orWhere('category_id', '=', '5');
                        })->orderby("post_time","DESC")->limit(5)->get()->toArray();
        echo json_encode($data);

        // upcoming dines
        $data = Store::select('id','logo','name',"post_time")
                        ->where([['active','1'],['s_type','dine']])->where(function ($query) {
                            $query->where('category_id', 'like', '8,%')
                                  ->orWhere('category_id', 'like', '%,8')
                                  ->orWhere('category_id', 'like', '%,8,%')
                                  ->orWhere('category_id', '=', '8');
                        })->orderby("post_time","DESC")->limit(5)->get()->toArray();
        echo json_encode($data);

        // navbar
        $data = AppNavigation::where('active','1')->orderby("priority","ASC")->get()->toArray();
        echo json_encode($data);

        // qreview
        $data = Qreview::select('sq_image','id',"post_time", "author","title")->where('active','1')->orderby("post_time","DESC")->limit(5)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['post_time'] = date("dS M, Y",strtotime($value['post_time']));
            // $data[$key]['tag'] = "#" . implode(', #',ReviewTag::where('active','1')->whereIn('id',explode(',',$value['tags']))->pluck('title')->toArray());
            $data[$key]['author'] = "by " . implode(', ',Qauthor::where('active','1')->whereIn('id',explode(',',$value['author']))->pluck('title')->toArray());
        }
        echo json_encode($data);

        // content
        // $data = Contest::select('name','id')->where([['active','1'],['form_date','<=',date('Y-m-d 00:00:00')],['to_date','>=',date('Y-m-d 23:59:59')]]);
        // if($data->count() > 0) $data=[$data->first()->id];
        // else $data = [];

        // app exclusive offer
        $data = StoreAppDeal::where('active',1)->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d 23:59:59'));
        if($data->count() > 0) $data=[$data->count()];
        else $data = [];
        // $data = []; // to disable the homepage button, comment out this line to enable the button
        echo json_encode($data);

        // test content
        $data = Contest::select('name','id')->where([['active','1'],['form_date','<=',date('Y-m-d 00:00:00')],['to_date','>=',date('Y-m-d 23:59:59')]]);
        if($data->count() > 0) $data=[$data->first()->id];
        else $data = [];
        echo json_encode($data);
    }

    public function getFeedbackPageData(){

        // new openings
        $data = Store::select('id','name')
                        ->where([['active','1'],['s_type','store']])
                        ->orderby("name","ASC")->get()->toArray();
        echo json_encode($data);

        // dine
        $data = Store::select('id','name')
                        ->where([['active','1'],['s_type','dine']])
                        ->orderby("name","ASC")->get()->toArray();
        echo json_encode($data);

        //grievance for
        $gvf = array("Store","Dine","Mall Services");
        echo json_encode($gvf);

        //grievance Type
        $grievanceType = array("Safety & security","Hygiene & maintenance","Other");
        echo json_encode($grievanceType);

        //suggestion list
        $storeSugg = array("Product availability",
                            "Store experience",
                            "Offers and deals",
                            "Staff friendliness",
                            "Post purchase services",
                            "Miscellaneous");
        echo json_encode($storeSugg);

        $dineSugg = array("Hygiene",
                            "Staff friendliness",
                            "Dine experience",
                            "Meal presentation",
                            "Offers and deals",
                            "Wishlist","Miscellaneous");
        echo json_encode($dineSugg);

        $mallSugg = array("Mall experience",
                            "Staff friendliness",
                            "Ambience",
                            "Car parking",
                            "Wishlist",
                            "Restroom Maintenance",
                            "Social Media",
                            "Miscellaneous");
        echo json_encode($mallSugg);

    }

    public function getLoftData(){
        // banner
        $data = LoftBanner::select('app_image')->where('active','1')->orderby('priority','asc')->get()->toArray();
        echo json_encode($data);


        // // Current upcomming
        // $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','loft'],['active','1']])->whereDate('start_date','>=', date('Y-m-d'))->orderby("start_date","DESC")->limit(5)->get()->toArray();
        // foreach ($data as $key => $value) {
        //     $data[$key]['image'] = $value['sq_image'];
        //     $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        // }
        // echo json_encode($data);

        // loft events
        $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','loft'],['active','1']])->orderby("start_date","DESC")->limit(5)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $value['sq_image'];
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        }
        echo json_encode($data);

        // designer
        $data = LoftDesigner::select('image','id')->where('active','1')->get()->toArray();
        echo json_encode($data);

        // loft cms
        $data = Cms::select('content')->where([['active','1'],['id','27']])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['content'] = str_replace('<p>module_include[loft]</p>', '', $value['content']);
        }
        echo json_encode($data);

    }


    public function getBanners(){
        $data = AppBanner::select('image')->where('active','1')->orderby('priority','asc')->get()->toArray();
        echo json_encode($data);
    }


    public function getMovies(){
        $data = MoviePoster::select('image','link')->where('active','1')->orderby("priority","asc")->get()->toArray();
        echo json_encode($data);
    }


    public function getDesigners(){
        $data = LoftDesigner::select('image','id')->where('active','1')->get()->toArray();
        echo json_encode($data);
    }

    public function getDesigner($id){
        $data = LoftDesigner::where([['id',$id],['active','1']])->get()->toArray();
        echo json_encode($data);

        // upcoming
        $data = Event::select('id','title','start_date')->where([['type','loft'],['active','1']])
                        ->whereDate('start_date','>', date('Y-m-d'))
                        ->where(function ($query) use($id) {
                            $query->where('designers', 'like', $id.',%')
                                  ->orWhere('designers', 'like', '%,'.$id)
                                  ->orWhere('designers', 'like', '%,'.$id.',%')
                                  ->orWhere('designers', '=', $id);
                        })->orderby("start_date","DESC")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        }
        echo json_encode($data);


        // past
        $data = Event::select('id','title','start_date')->where([['type','loft'],['active','1']])
                        ->whereDate('start_date','<=', date('Y-m-d'))
                        ->where(function ($query) use($id) {
                            $query->where('designers', 'like', $id.',%')
                                  ->orWhere('designers', 'like', '%,'.$id)
                                  ->orWhere('designers', 'like', '%,'.$id.',%')
                                  ->orWhere('designers', '=', $id);
                        })->orderby("start_date","DESC")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['images'] = EventGallery::select('title','image')->where([['event_id',$value['id']],['designer_id',$id], ['active','1']])->get()->toArray();
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        }
        echo json_encode($data);
    }

    public function getBeaconOffers(){

        $data = StoreDeal::where([['active','1'],['beacon_type','1']])->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC")->get()->toArray();
        $entry = array();
        foreach ($data as $key => $value) {
            if ($value['store_id']==0){
                $entrybeacon = Beacon::where('type','1')->get()->toArray();
                foreach ($entrybeacon as $k => $v) {
                    $b = array(
                        "id"=>0,
                        "store_id"=>$value['store_id'],
                        "beacon_type"=>$value['beacon_type'],
                        "title"=>$value['title'],
                        "description"=>$value['description'],
                        "image"=>$value['image'],
                        "post_time"=>$value['post_time'],
                        "start_date"=>$value['start_date'],
                        "end_date"=>$value['end_date'],
                        "active"=>$value['active'],
                        "beacon_id"=>$v['uuid'],
                        'type' => 'text',
                        'activity' => "CurrentOffers",
                        'subText' => "",
                    );

                    array_push($data, $b);
                }
            }
            elseif ($value['store_id']==-1){
                $loftbeacon = Beacon::find(21);
                $b = array(
                    "id"=>0,
                    "store_id"=>$value['store_id'],
                    "beacon_type"=>$value['beacon_type'],
                    "title"=>$value['title'],
                    "description"=>$value['description'],
                    "image"=>$value['image'],
                    "post_time"=>$value['post_time'],
                    "start_date"=>$value['start_date'],
                    "end_date"=>$value['end_date'],
                    "active"=>$value['active'],
                    "beacon_id"=>$loftbeacon->uuid,
                    'type' => 'text',
                    'activity' => "CurrentOffers",
                    'subText' => "",
                );

                array_push($data, $b);
            }

            $data[$key]['type'] = 'text';
            $data[$key]['activity'] = $value['store_id']==0 || $value['store_id']==-1?"CurrentOffers":'NotificationPage';
            $data[$key]['subText'] = $value['store_id']==0 || $value['store_id']==-1?"":Store::find($value['store_id'])->name;
            $data[$key]['beacon_id'] = $value['store_id']==0 || $value['store_id']==-1?"":Beacon::find(Store::find($value['store_id'])->beacon_id)->uuid;
        }


        echo json_encode($data);
    }

    public function getDeals($store_id=false){
        $where = [['active','1'],['image','!=',''],['beacon_type','0']];
        if($store_id){
             array_push($where, ['store_id',$store_id]);
        }
        $data = StoreDeal::select('image','id', "post_time")->where($where)->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->orderby("post_time","DESC")->get()->toArray();
        echo json_encode($data);
    }

    public function getReviews($store_id){
        $where = [['approve','1'],['store_id',$store_id]];
        $data = StoreRating::where($where)->orderby("id","DESC")->get()->toArray();
        foreach ($data as $key => $value) {
        	$data[$key]['user'] = User::find($value['user_id'])->name;
        	$data[$key]['date'] = date('F d, Y',strtotime($value['created_at']));
        }
        echo json_encode($data);
    }



    public function getDeal($id){
        $data = StoreDeal::where([['active','1'],['id',$id]])->get()->toArray();
        foreach ($data as $key => $value) {
        	$data[$key]['store_type'] = Store::find($value['store_id'])->s_type;
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
            $data[$key]['end_date'] = date("dS M, Y",strtotime($data[$key]['end_date']));
        }
        echo json_encode($data);
    }

    public function getStores($type_id,$cat_id,$floor,$cuisine,$type){
        if ($type_id != "-0") $type_id = explode('-', substr($type_id, 1));
        if ($cat_id != "-0") $cat_id = explode('-', substr($cat_id, 1));
        if ($cuisine != "-0") $cuisine = explode('-', substr($cuisine, 1));
        if ($floor != "Any Floor") $floor = explode('-', $floor);

        $data = Store::select('id','name','type_id','category_id','cuisine','logo')->where([['active','1'],['s_type',$type]]);

        if ($type_id != "-0") $data = $data->whereIn('type_id', $type_id);
        if ($cat_id != "-0"){
            $data = $data->where(function ($query) use($cat_id) {
                        $query->where('category_id', 'like', $cat_id[0].',%');
                        foreach ($cat_id as $key => $value) {
                            $query->orwhere('category_id', 'like', $value.',%')
                                  ->orWhere('category_id', 'like', '%,'.$value)
                                  ->orWhere('category_id', 'like', '%,'.$value.',%')
                                  ->orWhere('category_id', '=', $value);
                        }
                    });
        }
        if ($floor != "Any Floor") $data = $data->whereIn('floor', $floor);
        if ($cuisine != "-0"){
            foreach ($cuisine as $key => $value) {
                $data =$data->where(function ($query) use($value) {
                        $query->where('cuisine', 'like', $value.',%')
                              ->orWhere('cuisine', 'like', '%,'.$value)
                              ->orWhere('cuisine', 'like', '%,'.$value.',%')
                              ->orWhere('cuisine', '=', $value);
                    });
            }
        }

        $data = $data->orderby("name")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['type_id'] = StoreType::find($value['type_id'])->title;

            $value['category_id'] = explode(',', $value['category_id']);

            if($value['category_id'][0]!='')
            foreach ($value['category_id'] as $k => $v) {
                $value['category_id'][$k]=StoreCategory::find($v)->title;
            }
            $data[$key]['category_id'] = implode(', ', $value['category_id']);

            $value['cuisine'] = explode(',', $value['cuisine']);

            if($value['cuisine'][0]!='')
            foreach ($value['cuisine'] as $k => $v) {
                $value['cuisine'][$k]=DineCuisine::find($v)->title;
            }
            $data[$key]['cuisine'] = implode(', ', $value['cuisine']);

            $data[$key]['feature_img'] = StoreBanner::where([['active','1'],['featured','1'],['store_id',$value['id']]])->value('image');

            $rate = StoreRating::where('store_id',$value['id'])->avg('rate');
            if($rate != null) $data[$key]['rate'] = intval($rate);
            else $data[$key]['rate'] = 0;

        }
        echo json_encode($data);
    }

    public function getStore($id){
        $data = Store::where([['active','1'],['id',$id]])->get()->makeHidden('login_id')->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['type_id'] = StoreType::find($value['type_id'])->title;

            $value['category_id'] = explode(',', $value['category_id']);

            if($value['category_id'][0]!='')
            foreach ($value['category_id'] as $k => $v) {
                $value['category_id'][$k]=StoreCategory::find($v)->title;
            }
            $data[$key]['category_id'] = implode(', ', $value['category_id']);

            $value['cuisine'] = explode(',', $value['cuisine']);
            if($value['cuisine'][0]!='')
            foreach ($value['cuisine'] as $k => $v) {
                $value['cuisine'][$k]=DineCuisine::find($v)->title;
            }
            $data[$key]['cuisine'] = implode(', ', $value['cuisine']);

            $data[$key]['store_phones'] = StoreContactNo::where('store_id',$id)->pluck('phone')->toArray();
            $data[$key]['store_emails'] = StoreContactEmail::where('store_id',$id)->pluck('email')->toArray();
            $data[$key]['banners'] = StoreBanner::where([['active','1'],['store_id',$id]])->count();
            $data[$key]['deals'] = StoreDeal::where([['active','1'],['store_id',$id],['beacon_type','0']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'))->count();

            // app exclusive offer
	        $data[$key]['appoffer'] = StoreAppDeal::select('title','id','end_date as until')->where([['active',1],['store_id',$value['id']]])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d 23:59:59'))->get()->toArray();
        }
        echo json_encode($data);
    }

    public function getStoreBanners($store_id){
        $data = StoreBanner::select('app_image')->where([['active','1'],['store_id',$store_id]])->orderby('priority','asc')->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['app_image'];
        }
        echo json_encode($data);
    }

    public function getStoreTypes(){
        $data = StoreType::select('id','title')->where([['type', 'store'],['active','1']])->orderby("title")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['store'] = Store::where([['active','1'],['type_id',$value['id']]])->count();
        }
        echo json_encode($data);

        $data = StoreCategory::select('id','title')->where([['type', 'store'],['active','1']])->orderby("title")->get()->toArray();
        echo json_encode($data);
    }

    public function getDineTypes(){
        $data = StoreType::select('id','title')->where([['type', 'dine'],['active','1']])->orderby("title")->get()->toArray();
        echo json_encode($data);

        $data = StoreCategory::select('id','title')->where([['type', 'dine'],['active','1']])->orderby("title")->get()->toArray();
        echo json_encode($data);

        $data = DineCuisine::select('id','title')->where('active','1')->orderby("title")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['store'] = Store::where('active','1')->where(function ($query) use ($value) {
                                            $query->where('cuisine', 'like', $value['id'].',%')
                                                  ->orWhere('cuisine', 'like', '%,'.$value['id'])
                                                  ->orWhere('cuisine', 'like', '%,'.$value['id'].',%')
                                                  ->orWhere('cuisine', '=', $value['id']);
                                        })->count();
        }
        echo json_encode($data);



    }

    public function getEvents(){
        $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','quest'],['active','1']])->orderby("start_date","desc")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        }
        echo json_encode($data);
    }
    public function getEvent($id){
        $data = Event::select('content', 'title','sq_image','image','start_date', 'end_date')->where([['active','1'],['id',$id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
            $data[$key]['end_date'] = date("dS M, Y",strtotime($data[$key]['end_date']));
            // $data[$key]['content'] = strip_tags($data[$key]['content']);
            $data[$key]['banners'] = EventGallery::where([['active','1'],['event_id',$id]])->pluck('image')->toArray();
            foreach ($data[$key]['banners'] as $k => $v) $data[$key]['banners'][$k] = "/storage/event_gallery/actual/".$v;
            array_push($data[$key]['banners'],"/storage/event/actual/".$value['sq_image']);
        }
        echo json_encode($data);
    }

    public function getLoftEvents(){
        $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','loft'],['active','1']])->orderby("start_date","DESC")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        }
        echo json_encode($data);
    }

    // public function getLoftNewEvents(){
    //     $data = Event::select('id', 'title','image', 'start_date')->where([['type','loft'],['active','1']])->whereDate('start_date','>', date('Y-m-d'))->orderby("start_date")->get()->toArray();
    //     foreach ($data as $key => $value) {
    //         $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
    //     }
    //     echo json_encode($data);
    // }

    public function getBlogs($cat_id=false){
        $data = BlogCategory::select('id','title')->where('active','1')->orderby("title")->get()->toArray();
        echo json_encode($data);

        $data = Blog::select('sq_image','id', "post_time","title","content","category_id")->where('active','1');
        if ($cat_id && ($cat_id != "-0")){
            $cat_id = explode('-', substr($cat_id, 1));
            $data = $data->whereIn('category_id', $cat_id);
        }

        $data = $data->orderby("post_time","DESC")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['post_time'] = date("dS M, Y",strtotime($data[$key]['post_time']));
            $data[$key]['content'] = str_limit(strip_tags($data[$key]['content']),20);
            $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
        }
        echo json_encode($data);
    }

    public function getBlog($id){
        $data = Blog::where([['active','1'],['id',$id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
            //$data[$key]['content'] = strip_tags($data[$key]['content']);
            $data[$key]['post_time'] = date("dS M, Y",strtotime($data[$key]['post_time']));
        }
        echo json_encode($data);
    }

    public function getFrames(){
        $data = CameraFrame::where('active','1')->orderby('created_at','desc')->pluck('image')->toArray();
        echo json_encode($data);
    }

    public function getFaq(){
        echo json_encode(array(array("question"=>"Do you require some mall assistance? ","answer"=>"Please call, +916290825643 or you can email us at Quest.helpdesk2@rp-sg.in.")));
    }

    public function getNotification(){
        $data = AppPush::where('push','1')->orderby('id','desc')->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['push_time'] = \Carbon::parse($value['push_time'])->diffForHumans();
        }
        echo Crypt::encryptString(json_encode($data));
    }

    public function search($searchTerm)
    {
        $searchResult = [];
        $storeResult = Store::select("id","name")->where([['s_type','store'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                                    ->search(["name","description"],$searchTerm)
                                                    ->pluck("id","name")->toArray();
        foreach ($storeResult as $key => $value) $storeResult[$key] = $key."^^Store-".$value;

        $dineResult = Store::select("id","name")->where([['s_type','dine'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["name","description"],$searchTerm)
                                            ->pluck("id","name")->toArray();
        foreach ($dineResult as $key => $value) $dineResult[$key] = $key."^^Restaurant-".$value;

        $blogResult = Blog::select("id","title")->where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["title","content"],$searchTerm)
                                            ->pluck("id","title")->toArray();
        foreach ($blogResult as $key => $value) $blogResult[$key] = $key."^^Blog Article-".$value;

        $questEventResult = Event::select("id","title")->where([['type','quest'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["title","content"],$searchTerm)
                                            ->pluck("id","title")->toArray();
        foreach ($questEventResult as $key => $value) $questEventResult[$key] = $key."^^Quest Event-".$value;

        $loftEventResult = Event::select("id","title")->where([['type','loft'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["title","content"],$searchTerm)
                                            ->pluck("id","title")->toArray();
        foreach ($loftEventResult as $key => $value) $loftEventResult[$key] = $key."^^Loft Event-".$value;

        $movieResult = MoviePoster::select("id","title")->where('active','1')
                                            ->search(["title"],$searchTerm)
                                            ->pluck("id","title")->toArray();
        foreach ($movieResult as $key => $value) $movieResult[$key] = $key."^^Movie-".$value;

        $searchResult = array_merge(array_values($storeResult),array_values($dineResult),array_values($blogResult),array_values($questEventResult),array_values($loftEventResult),array_values($movieResult));
        echo json_encode($searchResult);
    }

    private function genCode(){
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = substr(str_shuffle($char),1,7);
        if(User::where('referral_code',$code)->count() == 0) return $code;
        else return $this->genCode();
    }

    public function socialAuth(Request $request)
    {

        request()->merge(['name' => Crypt::decryptString(request()->name)]);
        request()->merge(['email' => Crypt::decryptString(request()->email)]);
        request()->merge(['image' => Crypt::decryptString(request()->image)]);
        request()->merge(['login_device' => Crypt::decryptString(request()->login_device)]);
        request()->merge(['platform' => Crypt::decryptString(request()->platform)]);
        if (request()->has('apple_user_id')) request()->merge(['apple_user_id' => Crypt::decryptString(request()->apple_user_id)]);

        // validation
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'name' => 'required',
            'login_device' => 'required',
            'platform' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where('email',request()->email);

            if ($user->count() > 0) {
                $user=$user->first();
                if($user->blocked == 1) return json_encode(array("error"=>"Sorry! Please try again later."));

                if ($user->image == "" && request()->image != ""){
                    $time = time();
                    Storage::disk('public')->put('users/'.$user->id.'_'.$time.'.jpg', \Image::make(request()->image)->encode('jpg')->__toString(),"public");
                    $user->image = $user->id.'_'.$time.'.jpg';
                }
                $user->login_device = request()->login_device;
                $user->platform = request()->platform;
                $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                if(request()->apple_user_id) $user->apple_user_id = request()->apple_user_id;
                $user->chash = "";
                $user->fhash = "";
                $user->active = "1";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

            }else{
                request()->merge(['password' => bcrypt("HJDGSIUBSJFKKBF")]);
                request()->merge(['active' => '1']);
                request()->merge(['referral_code' => $this->genCode()]);

                User::create(request()->all());
                $user = User::where('email',request()->email)->first();

                if (request()->image != ""){
                    $time = time();
                    Storage::disk('public')->put('users/'.$user->id.'_'.$time.'.jpg', \Image::make(request()->image)->encode('jpg')->__toString(),"public");
                    $user->image = $user->id.'_'.$time.'.jpg';
                }
                $user->login_device = request()->login_device;
                $user->platform = request()->platform;
                $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                $user->active = "1";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
            }

            $walk_offer = array();
            if ($user->step_data != ""){
                $user_steps = json_decode($user->step_data,true);
                $total = 0;
                foreach ($user_steps as $key => $value) {
                    $total = $total + intval($value);
                }

                $user->total_steps = $total;
                $user->save();

                if(WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->count() > 0){
                    $near_data = WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->first()->threshold;
                }else{
                    $near_data = WalkLevel::where("threshold","<",$total)->orderby('id','ASC')->first()->threshold;
                }
                $walk_offer = WalkLevel::where('threshold',$near_data)->orwhere('threshold','<',$near_data);
                $id = $walk_offer->pluck('id')->toArray();
                $walk_offer = WalkOffer::where('active','1')->orderby('threshold','asc')->get()->toArray();
                // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
            }

            $redeem_offer = UserWalkOffer::where("user_id",$user->id)->get()->toArray();
            $message = array("success"=>Crypt::encryptString(json_encode($user->toArray()).json_encode(WalkLevel::all()->toArray()).json_encode($redeem_offer).json_encode($walk_offer)));
            echo json_encode($message);

        }
    }

    public function socialAuthApple(Request $request)
    {

        request()->merge(['login_device' => Crypt::decryptString(request()->login_device)]);
        request()->merge(['platform' => Crypt::decryptString(request()->platform)]);
        request()->merge(['apple_user_id' => Crypt::decryptString(request()->apple_user_id)]);

        // validation
        $validator = Validator::make($request->all(),[
            'apple_user_id' => 'required',
            'login_device' => 'required',
            'platform' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where('apple_user_id',request()->apple_user_id);

            if ($user->count() > 0) {
                $user=$user->first();
                if($user->blocked == 1) return json_encode(array("error"=>"Sorry! Please try again later."));

                $user->login_device = request()->login_device;
                $user->platform = request()->platform;
                $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                $user->chash = "";
                $user->fhash = "";
                $user->active = "1";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();


                $walk_offer = array();
	            if ($user->step_data != ""){
	                $user_steps = json_decode($user->step_data,true);
	                $total = 0;
	                foreach ($user_steps as $key => $value) {
	                    $total = $total + intval($value);
	                }

	                $user->total_steps = $total;
	                $user->save();

	                if(WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->count() > 0){
	                    $near_data = WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->first()->threshold;
	                }else{
	                    $near_data = WalkLevel::where("threshold","<",$total)->orderby('id','ASC')->first()->threshold;
	                }
	                $walk_offer = WalkLevel::where('threshold',$near_data)->orwhere('threshold','<',$near_data);
	                $id = $walk_offer->pluck('id')->toArray();
	                $walk_offer = WalkOffer::where('active','1')->orderby('threshold','asc')->get()->toArray();
	                // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
	                foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
	            }

	            $redeem_offer = UserWalkOffer::where("user_id",$user->id)->get()->toArray();
	            $message = array("success"=>Crypt::encryptString(json_encode($user->toArray()).json_encode(WalkLevel::all()->toArray()).json_encode($redeem_offer).json_encode($walk_offer)));
	            echo json_encode($message);

            }else{
                return json_encode(array("error"=>"nouser"));
            }

            

        }

    }

    public function registerUser(Request $request)
    {
        request()->merge(['name' => Crypt::decryptString(request()->name)]);
        request()->merge(['email' => Crypt::decryptString(request()->email)]);
        request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            request()->merge(['password' => bcrypt(request('password'))]);
            request()->merge(['chash' => bin2hex(openssl_random_pseudo_bytes(128))]);
            request()->merge(['active' => '0']);
            request()->merge(['referral_code' => $this->genCode()]);
            User::create(request()->all());

            $data = request()->all();
            Mail::to(request()->email, request()->name)->send(new EmailVerify($data));

            $message = array("success"=>"done");
            echo json_encode($message);
        }
    }


    public function loginUser(Request $request)
    {

        request()->merge(['email' => Crypt::decryptString(request()->email)]);
        request()->merge(['password' => Crypt::decryptString(request()->password)]);
        request()->merge(['login_device' => Crypt::decryptString(request()->login_device)]);
        request()->merge(['platform' => Crypt::decryptString(request()->platform)]);

        // validation
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:user,email',
            'password' => 'required|min:6',
            'login_device' => 'required',
            'platform' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where('email',request()->email)->first();
            if($user->blocked == 1) return json_encode(array("error"=>"Sorry! Please try again later."));
            else if ($user->active == '1') {
                if (\Hash::check(request()->password, $user->password)) {
                    $user->login_device = request()->login_device;
                    $user->platform = request()->platform;
                    $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                    $user->chash = "";
                    $user->fhash = "";
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->save();

                    $walk_offer = array();
                    if ($user->step_data != ""){
                        $user_steps = json_decode($user->step_data,true);
                        $total = 0;
                        foreach ($user_steps as $key => $value) {
                            $total = $total + intval($value);
                        }
                        $user->total_steps = $total;
                        $user->save();


                        if(WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->count() > 0){
                            $near_data = WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->first()->threshold;
                        }else{
                            $near_data = WalkLevel::where("threshold","<",$total)->orderby('id','ASC')->first()->threshold;
                        }

                        $walk_offer = WalkLevel::where('threshold',$near_data)->orwhere('threshold','<',$near_data);
                        $id = $walk_offer->pluck('id')->toArray();
                        // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                        $walk_offer = WalkOffer::where('active','1')->orderby('threshold','asc')->get()->toArray();
                        foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                    }

                    $redeem_offer = UserWalkOffer::where("user_id",$user->id)->get()->toArray();
                    $message = array("success"=>Crypt::encryptString(json_encode($user->toArray()).json_encode(WalkLevel::all()->toArray()).json_encode($redeem_offer).json_encode($walk_offer)));
                    echo json_encode($message);

                }else{
                    $message = array("password"=>"The password is incorrect.");
                    echo json_encode($message);
                }
            }else{
                $message = array("error"=>"Check your email inbox and verify your email address!");
                echo json_encode($message);
            }


        }

    }

    public function logoutUser(Request $request)
    {
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['id' => Crypt::decryptString(request()->id)]);

        // validation
        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->id]]);
            if ($user->count()) {
                $user = $user->first();
                $user->login_device = "";
                $user->platform = "";
                $user->token = "";
                $user->chash = "";
                $user->fhash = "";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                $message = array("success"=>"done");
                echo json_encode($message);
            }
        }
    }

    public function getLoggedinUser(Request $request)
    {
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['id' => Crypt::decryptString(request()->id)]);

        // validation
        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode(array("error"=>"Invalid token."));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->id]]);
            if ($user->count()) {

            	User::where([['email',$user->first()->email],['id','<>',request()->id]])->delete();

                $walk_offer = array();
                if ($user->first()->step_data != ""){
                    $user_steps = json_decode($user->first()->step_data,true);
                    $total = 0;
                    foreach ($user_steps as $key => $value) {
                        $total = $total + intval($value);
                    }
                    $user->first()->total_steps = $total;
                    $user->first()->save();

                    $near_data = WalkLevel::where("threshold",">",$total)->orderby('id','ASC')->first()->threshold;
                    $walk_offer = WalkLevel::where('threshold',$near_data)->orwhere('threshold','<',$near_data);
                    $id = $walk_offer->pluck('id')->toArray();
                    $walk_offer = WalkOffer::where('active','1')->orderby('threshold','asc')->get()->toArray();
                    // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                    foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                }

                $redeem_offer = UserWalkOffer::where("user_id",$user->first()->id)->get()->toArray();
                $message = array("success"=>Crypt::encryptString(json_encode($user->first()->toArray()).json_encode(WalkLevel::all()->toArray()).json_encode($redeem_offer).json_encode($walk_offer)));
                echo json_encode($message);
            }else echo json_encode(array("error"=>"Invalid token."));
        }

    }



    public function resetPassword(Request $request)
    {
        request()->merge(['email' => Crypt::decryptString(request()->email)]);

        // validation
        $validator = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where('email',request()->email);
            if ($user->count()) {
                $user = $user->first();
                $user->fhash = rand(10000,99999);
                $user->save();

                if ($user->phone){

                    $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737258906094&mobile=".$user->phone."&message=".urlencode($user->fhash." is your OTP for changing password. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));
                }

                Mail::to($user->email, $user->name)->send(new ResetPassword($user));

                echo json_encode(array("success"=>Crypt::encryptString($user->fhash)));
            }else echo json_encode(array("error"=>"Email address is not registered with us!"));
        }

    }

    public function feedback(Request $request)
    {
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['feedback' => Crypt::decryptString(request()->feedback)]);

        // validation
        $validator = Validator::make($request->all(),[
            'feedback' => 'required|max:200',
            'user_id' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['id',request()->user_id],['token',request()->token]]);
            if ($user->count()) {
                Feedback::create(request()->all());
                echo json_encode(array("success"=>"done"));
            }else echo json_encode(array("error"=>"Something went wrong!"));
        }
    }

    public function savefeedback(Request $request)
    {
    	if(request()->user_id){
	        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
	        request()->merge(['token' => Crypt::decryptString(request()->token)]);
    	}

    	request()->merge(['name' => Crypt::decryptString(request()->name)]);
    	request()->merge(['email' => Crypt::decryptString(request()->email)]);
    	request()->merge(['mobile' => Crypt::decryptString(request()->mobile)]);
    	request()->merge(['for' => Crypt::decryptString(request()->for)]);
    	request()->merge(['feedback' => Crypt::decryptString(request()->feedback)]);
    	request()->merge(['type' => Crypt::decryptString(request()->type)]);
    	request()->merge(['store_id' => Crypt::decryptString(request()->store_id)]);
		request()->merge(['reason' => Crypt::decryptString(request()->reason)]);
		request()->merge(['floor' => Crypt::decryptString(request()->floor)]);

        // validation
        $validator = Validator::make($request->all(),[
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'for' => 'required',
            'store_id' => 'required',
            'reason' => 'required',
            'feedback' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode($validator->errors()));
        }
        else{
        	if(request()->user_id){
	            $user = User::where([['id',request()->user_id],['token',request()->token]]);
	            if ($user->count() == 0){
	            	return Crypt::encryptString(json_encode(array("error"=>"Something went wrong!")));
	            }
        	}
        	if(request()->type == "Suggestion") request()->merge(['reason'=>implode(", ",json_decode(request()->reason, true))]);

            if (request()->submit){
                Feedback::create(request()->all());
                return Crypt::encryptString(json_encode(array("success"=>"Thank you for submitting your feedback.")));
            }else return Crypt::encryptString(json_encode(array("checked"=>"done")));
        }
    }


    public function saveData(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['name' => Crypt::decryptString(request()->name)]);
        request()->merge(['phone' => Crypt::decryptString(request()->phone)]);
        request()->merge(['interest' => Crypt::decryptString(request()->interest)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'name' => 'required',
            'phone' => ['required','size:10',Rule::unique('user')->ignore(request()->id)]
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['id',request()->id],['token',request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $user->name = request()->name;
                $user->interest = request()->interest;
                $user->phone = request()->phone;
                $user->save();
                echo json_encode(array("success"=>"done"));
            }else echo json_encode(array("error"=>"Something went wrong!"));
        }

    }

    public function saveImage(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['image' => Crypt::decryptString(request()->image)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['id',request()->id],['token',request()->token]]);
            if ($user->count()) {
                $user = $user->first();

                if($user->image != ""){
                    $old_file = Storage::disk('public')->path('users/'.$user->image);
                    if(is_file($old_file)) Storage::disk('public')->delete('users/'.$user->image);
                }

                $time = time();
                Storage::disk('public')->put('users/'.$user->id.'_'.$time.'.jpg', \Image::make(request()->image)->encode('jpg')->__toString(),"public");
                $user->image = $user->id.'_'.$time.'.jpg';

                $user->save();
                echo json_encode(array("success"=>"done"));
            }else echo json_encode(array("error"=>"Something went wrong!"));
        }

    }

    public function savePass(Request $request)
    {
        request()->merge(['email' => Crypt::decryptString(request()->email)]);
        request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['email',request()->email],['fhash','<>','']]);
            if ($user->count()) {
                $user = $user->first();
                $user->password = bcrypt(request('password'));
                $user->fhash = "";
                $user->save();
                echo json_encode(array("success"=>"done"));
            }else echo json_encode(array("error"=>"Email address is not registered with us!"));
        }

    }

    public function saveArticle(Request $request)
    {
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['blog_id' => Crypt::decryptString(request()->blog_id)]);

        // validation
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'token' => 'required',
            'blog_id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where([['id',request()->user_id],['token',request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $bookmark = json_decode($user->bookmark,true);
                if ($bookmark){
                    if(in_array(request()->blog_id, $bookmark)){
                        unset($bookmark[array_search(request()->blog_id, $bookmark)]);
                    }else{
                        array_push($bookmark, request()->blog_id);
                        $bookmark = array_unique($bookmark);
                    }
                }else $bookmark = array(request()->blog_id);

                $user->bookmark = json_encode($bookmark);
                $user->save();
                echo json_encode(array("success"=>Crypt::encryptString(json_encode($bookmark))));
            }else echo json_encode(array("error"=>"Something went wrong!"));
        }

    }

    public function rateStore(Request $request)
    {
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['store_id' => Crypt::decryptString(request()->store_id)]);
        request()->merge(['rate' => Crypt::decryptString(request()->rate)]);
        request()->merge(['message' => Crypt::decryptString(request()->review)]);

        // validation
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'rate' => 'required',
            'token' => 'required',
            'store_id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where([['id',request()->user_id],['token',request()->token]]);
            $store = Store::where([['id',request()->store_id],['active','1']]);
            if ($user->count() && $store->count()) {
                StoreRating::create($request->all());
                echo json_encode(array("success"=>"done"));
            }else echo json_encode(array("error"=>"Something went wrong!"));
        }
    }

     public function getSavedBlogs(Request $request){
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);

        // validation
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        }
        else{
            $user = User::where([['id',request()->user_id],['token',request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $bookmark = json_decode($user->bookmark,true);
                if ($bookmark){
                    $data = Blog::select('sq_image','id', "post_time","title","content","category_id")->where('active','1');
                    $data = $data->whereIn('id', $bookmark)->orderby("post_time","DESC")->get()->toArray();

                    foreach ($data as $key => $value) {
                        $data[$key]['image'] = $data[$key]['sq_image'];
                        $data[$key]['post_time'] = date("dS M, Y",strtotime($data[$key]['post_time']));
                        $data[$key]['content'] = str_limit(strip_tags($data[$key]['content']),20);
                        $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
                    }
                    echo Crypt::encryptString(json_encode($data));
                }else echo json_encode(array("error"=>"There is no saved article available!"));
            }else echo json_encode(array("error"=>"Something went wrong!"));
        }
    }

    public function saveSteps(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['step_data' => Crypt::decryptString(request()->step_data)]);
        request()->merge(['near_data' => Crypt::decryptString(request()->near_data)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'near_data' => 'required',
            'step_data' => 'required'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['id',request()->id],['token',request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $user->step_data = request()->step_data;
                $user->save();

                $walk_offer = WalkLevel::where('threshold',request()->near_data)->orwhere('threshold','<',request()->near_data);
                if ($walk_offer->count() > 0) {
                    $id = $walk_offer->pluck('id')->toArray();
                    $walk_offer = WalkOffer::where('active','1')->orderby('threshold','asc')->get()->toArray();
                    // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                    foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                    echo json_encode(array("success"=> Crypt::encryptString(json_encode($walk_offer))));
                }else echo json_encode(array("success"=> Crypt::encryptString(json_encode(array()))));
            }else return response(json_encode(array("error"=>"Something went wrong!")),400);
        }

    }

    public function redeemOffer(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['offer_id' => Crypt::decryptString(request()->offer_id)]);
        request()->merge(['total_step' => Crypt::decryptString(request()->total_step)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'total_step' => 'required',
            'offer_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()),400);
        }
        else{
            $user = User::where([['id',request()->id],['token',request()->token]]);
            if ($user->count()) {
                $user = $user->first();

                $walk_offer = WalkLevel::where('threshold',request()->total_step)->orwhere('threshold','<',request()->total_step);
                if ($walk_offer->count() > 0) {

                    $walk_offer = WalkOffer::where([['active','1'],['id',request()->offer_id]])->whereIn('threshold', $walk_offer->pluck('id'))->orderby('threshold','asc');
                    if ($walk_offer->count() == 1){
                        $walk_offer = $walk_offer->first();
                        if(UserWalkOffer::where([["user_id",request()->id],['offer_id',request()->offer_id]])->count() == 0){
                            $arr = array(
                                "user_id"=>request()->id,
                                "store_id"=>$walk_offer->store_id,
                                "offer_id"=>$walk_offer->id,
                                "offer"=>$walk_offer->offer,
                                "image"=>$walk_offer->image,
                                "threshold"=>WalkLevel::find($walk_offer->threshold)->type,
                                "code"=>$walk_offer->code,
                                "redeem_within"=>$walk_offer->redeem_within,
                                "redeem_within"=>$walk_offer->redeem_within,
                                "redeem_date"=>date('Y-m-d H:i:s'),
                            );
                            $data = UserWalkOffer::create($arr);

                            // Mail::to($data->user->email, $data->user->name)->send(new OfferClaimed($data));
                        }
                        $redeem_offer = UserWalkOffer::where("user_id",request()->id)->get()->toArray();
                        echo json_encode(array("success"=> Crypt::encryptString(json_encode($redeem_offer))));
                    }else return response(json_encode(array("error"=>"Something went wrong!")),400);
                }else return response(json_encode(array("error"=>"Something went wrong!")),400);
            }else return response(json_encode(array("error"=>"Something went wrong!")),400);
        }

    }

    public function parkingApi(){
        print_r(request()->all());
    }

    public function phoneVerifyOtp(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['phone' => Crypt::decryptString(request()->phone)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'phone' => ['required','size:10',Rule::unique('user')->ignore(request()->id)]
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        }else{
            $user = User::where([['id',request()->id],['token',request()->token]]);
            if ($user->count()) {
                $OTP = rand(10000,99999);
                $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737270600501&mobile=".request()->phone."&message=".urlencode($OTP." is your OTP for phone number verification. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));

                if (substr(trim($response),0,14) == 'SUBMIT_SUCCESS'){
                	$user = $user->first();
                	$user->fhash = $OTP;
                	$user->save();
                	echo json_encode(array("success"=>Crypt::encryptString($OTP)));
                }else{
                	response(json_encode(array("error"=>$response[0]['msg'])));
                }
            }else return response(json_encode(array("error"=>"Something went wrong!")));
        }
    }

    public function getMallMap(){
        $data = Map::where('active','1')->orderby('id')->get()->toArray();
        echo json_encode($data);
    }

    public function getQreviews($auth_id=false,$tag_id=false){
        $data = Qauthor::select('id','title')->where('active','1')->orderby("title")->get()->toArray();
        echo json_encode($data);
       	$data = ReviewTag::select('id','title')->where('active','1')->orderby("title")->get()->toArray();
        echo json_encode($data);

        $data = Qreview::select('sq_image','id', "post_time","title","content","author")->where('active','1');
        
        if ($auth_id != "-0") $auth_id = explode('-', substr($auth_id, 1));
        if ($auth_id != "-0"){
            $data = $data->where(function ($query) use($auth_id) {
                        $query->where('author', 'like', $auth_id[0].',%');
                        foreach ($auth_id as $key => $value) {
                            $query->orwhere('author', 'like', $value.',%')
                                  ->orWhere('author', 'like', '%,'.$value)
                                  ->orWhere('author', 'like', '%,'.$value.',%')
                                  ->orWhere('author', '=', $value);
                        }
                    });
        }

        if ($tag_id != "-0") $tag_id = explode('-', substr($tag_id, 1));
        if ($tag_id != "-0"){
            $data = $data->where(function ($query) use($tag_id) {
                        $query->where('tags', 'like', $tag_id[0].',%');
                        foreach ($tag_id as $key => $value) {
                            $query->orwhere('tags', 'like', $value.',%')
                                  ->orWhere('tags', 'like', '%,'.$value)
                                  ->orWhere('tags', 'like', '%,'.$value.',%')
                                  ->orWhere('tags', '=', $value);
                        }
                    });
        }

        $data = $data->orderby("post_time","DESC")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['post_time'] = date("dS M, Y",strtotime($data[$key]['post_time']));
            $data[$key]['content'] = str_limit(strip_tags($data[$key]['content']),20);
            $data[$key]['author'] = "by " . implode(', ',Qauthor::where('active','1')->whereIn('id',explode(',',$value['author']))->pluck('title')->toArray());
        }
        echo json_encode($data);
    }

    public function getQreview($id){
        $data = Qreview::where([['active','1'],['id',$id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['author'] = "by " . implode(', ',Qauthor::where('active','1')->whereIn('id',explode(',',$value['author']))->pluck('title')->toArray());
            $data[$key]['tags'] = "#" . implode(', #',ReviewTag::where('active','1')->whereIn('id',explode(',',$value['tags']))->pluck('title')->toArray());
            $data[$key]['post_time'] = date("dS M, Y",strtotime($data[$key]['post_time']));
        }
        echo json_encode($data);
    }

    public function getAppDealStores($type)
    {
        $data = StoreAppDeal::select('store_id')->where('active',1)->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d 23:59:59'))->get()->toArray();
        $data = array_column($data,'store_id');
        $data = Store::select('id','name','type_id','category_id','cuisine','logo')->whereIn('id',$data)->where('s_type',$type)->orderby("name")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['type_id'] = StoreType::find($value['type_id'])->title;

            $value['category_id'] = explode(',', $value['category_id']);

            if($value['category_id'][0]!='')
            foreach ($value['category_id'] as $k => $v) {
                $value['category_id'][$k]=StoreCategory::find($v)->title;
            }
            $data[$key]['category_id'] = implode(', ', $value['category_id']);

            $value['cuisine'] = explode(',', $value['cuisine']);

            if($value['cuisine'][0]!='')
            foreach ($value['cuisine'] as $k => $v) {
                $value['cuisine'][$k]=DineCuisine::find($v)->title;
            }
            $data[$key]['cuisine'] = implode(', ', $value['cuisine']);

            $rate = StoreRating::where('store_id',$value['id'])->avg('rate');
            if($rate != null) $data[$key]['rate'] = intval($rate);
            else $data[$key]['rate'] = 0;

        }

        echo json_encode($data);
    }

    public function getAppDeals($id = 0)
    {
        $where = [['active',1]];
        if($id>0) $where = [['active',1],['store_id',$id]];

    	$data = StoreAppDeal::select('title','id','end_date as until','store_id')->where($where)->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d 23:59:59'))->orderBy('end_date','asc')->get();
    	foreach ($data as $key => $value) {
    		$value->storename=Store::find($value->store_id)->name;
    	}
    	echo json_encode($data->toArray());
    }

    public function getAppDeal()
    {
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['offer_id' => Crypt::decryptString(request()->offer_id)]);

        $user = User::where([['token',request()->token],['id',request()->user_id]]);
        if ($user->count() == 0 ) return response(json_encode(array("error"=>"Something went wrong!")),400);

    	$data = StoreAppDeal::select('*','end_date as until')->where([['active',1],['id',request('offer_id')]])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d 23:59:59'));
    	if($data->count() ==1){
    		$data = $data->first();
    		$data->store_type = Store::find($data->store_id)->s_type;
    		$data->storename = Store::find($data->store_id)->name;
    		$data->storelogo = Store::find($data->store_id)->logo;

    		$activeday = $data->activeday->where('day',date("l"));
            if($activeday->count()){
                $activeday=$activeday->first();
                if(strtotime(date('Y-m-d ').$activeday->fromtime) <= time() and strtotime(date('Y-m-d ').$activeday->totime) >= time()){
                    $data->available = 1;
                }
                else $data->available = 0;
            }else $data->available = 0;

            $userCode = StoreAppDealClaimed::where([['store_id', $data->store_id],['offer_id',request('offer_id')],['user_id',request('user_id')],['claimed','0']]);
            if($userCode->count()){
            	$data->code = $userCode->first()->code; 
            }
    		echo Crypt::encryptString(json_encode($data->toArray()));
    	}
    	else return response(json_encode(array("error"=>"Something went wrong!")),400);
    }

    public function genAppDealCode()
    {
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['offer_id' => Crypt::decryptString(request()->offer_id)]);

        $user = User::where([['token',request()->token],['id',request()->user_id]]);
        if ($user->count() == 0 ) return response(json_encode(array("error"=>"Something went wrong!")),400);

    	$data = StoreAppDeal::select('*','end_date as until')->where([['active',1],['id',request('offer_id')]])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d 23:59:59'));
    	if($data->count() ==1){
    		$data = $data->first();
    		$data->store_type = Store::find($data->store_id)->s_type;
    		$data->storename = Store::find($data->store_id)->name;
    		$data->storelogo = Store::find($data->store_id)->logo;

    		$activeday = $data->activeday->where('day',date("l"));
            if($activeday->count()){
                $activeday=$activeday->first();
                if(strtotime(date('Y-m-d ').$activeday->fromtime) <= time() and strtotime(date('Y-m-d ').$activeday->totime) >= time()){
                    $data->available = 1;
                }
                else $data->available = 0;
            }else $data->available = 0;

            $userCode = StoreAppDealClaimed::where([['store_id', $data->store_id],['offer_id',request('offer_id')],['user_id',request('user_id')],['claimed','0']]);
            if($userCode->count()){
            	$data->code = $userCode->first()->code; 
            }else{
            	$data->code = $this->genDealCode();
            	$arr = [
            		'user_id' => request('user_id'),
            		'store_id' => $data->store_id,
            		'offer_id' => $data->id,
            		'offer_title' => $data->title,
            		'code' => $data->code,
            		'claimed' => 0
            	];
            	StoreAppDealClaimed::create($arr);
            }
    		echo Crypt::encryptString(json_encode($data->toArray()));
    	}
    	else return response(json_encode(array("error"=>"Something went wrong!")),400);
    }

    private function genDealCode(){
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = substr(str_shuffle($char),1,10); //this can handle 3628800 unique code, increade the last number to handle more code
        if(StoreAppDealClaimed::where('code',$code)->count() == 0) return $code;
        else return $this->genDealCode();
    }
}
