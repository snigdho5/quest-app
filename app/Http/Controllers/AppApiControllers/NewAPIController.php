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
use App\Models\AdminModels\SummerBanner;
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
use App\Models\AdminModels\ContestParticipate;
use App\Models\AdminModels\ContestParticipantTransaction;
use App\Mail\EmailVerify;
use App\Mail\ResetPassword;
use App\Mail\OfferClaimed;
use DB;

class NewAPIController extends Controller
{
    public function __construct()
    {
    }

    public function getHome()
    {

        // app banner
        $banner = AppBanner::select('image', 'action', "page")->where('active', '1')->orderby('priority', 'asc')->get()->toArray();

        if (!empty($banner)) {
            foreach ($banner as $key => $value) {
                $banner[$key]['image_actual'] = url('storage/app_banner/actual/' . $value['image']);
                // $banner[$key]['image_thumb'] = url('storage/app_banner/thumb/' . $value['image']);
            }
        }

        $data['banner'] = $banner;

        // summer sale banner
        $summer_sale_banner = SummerBanner::select('image')->where('active', '1')->orderby('priority', 'asc')->get()->toArray();

        // $summer_sale_banner =
        //     [
        //         ['image' => url('storage/summer_banner/summer-offer.jpg')],
        //         ['image' => url('storage/summer_banner/summer-offer-2.jpg'),],
        //         ['image' => url('storage/summer_banner/summer-offer-3.jpg')]
        //     ];

        if (!empty($summer_sale_banner)) {
            foreach ($summer_sale_banner as $key => $value) {
                $summer_sale_banner[$key]['image'] = url('storage/summer_banner/actual/' . $value['image']);
                // $summer_sale_banner[$key]['image_thumb'] = url('storage/summer_banner/thumb/' . $value['image']);
            }
        }

        $data['summer_sale_banner'] = $summer_sale_banner;

        // echo json_encode($data);

        // current deals
        $current_deals = StoreDeal::select('image', 'id', "post_time")->where([['active', '1'], ['beacon_type', '0'], ['image', '!=', ''], ['store_id', '!=', '0']])->where('post_time', '<=', date("Y-m-d H:i:s"))->whereDate('end_date', '>=', date('Y-m-d'))->orderby("post_time", "DESC")->limit(5)->get()->toArray();
        // echo json_encode($data);


        if (!empty($current_deals)) {
            foreach ($current_deals as $key => $value) {
                $current_deals[$key]['image_actual'] = url('storage/store_deal/actual/' . $value['image']);
                $current_deals[$key]['image_thumb'] = url('storage/store_deal/thumb/' . $value['image']);
            }
        }

        $data['current_deals'] = $current_deals;


        // new openings
        $new_openings = Store::select('id', 'logo', "post_time")
            ->where([['active', '1'], ['s_type', 'store']])->where(function ($query) {
                $query->where('category_id', 'like', '1,%')
                    ->orWhere('category_id', 'like', '%,1')
                    ->orWhere('category_id', 'like', '%,1,%')
                    ->orWhere('category_id', '=', '1');
            })->orderby("post_time", "DESC")->limit(5)->get()->toArray();
        // echo json_encode($data);

        if (!empty($new_openings)) {
            foreach ($new_openings as $key => $value) {
                $new_openings[$key]['image_actual'] = url('storage/store/actual/' . $value['logo']);
                // $new_openings[$key]['image_thumb'] = url('storage/store/thumb/' . $value['logo']);

                //get feature image
                $new_openings[$key]['feature_img'] = StoreBanner::where([['active', '1'], ['featured', '1'], ['store_id', $value['id']]])->value('image');
                $new_openings[$key]['feature_img_actual'] = url('storage/store_banner/actual/' . $new_openings[$key]['feature_img']);
                $new_openings[$key]['feature_img_thumb'] = url('storage/store_banner/thumb/' . $new_openings[$key]['feature_img']);
            }
        }

        $data['new_openings'] = $new_openings;

        // Current events
        $data['current_events'] = Event::select('id', 'title', 'sq_image', 'start_date')->where([['type', 'quest'], ['active', '1']])->orderby("start_date", "DESC")->limit(5)->get()->toArray();


        if ($data['current_events']) {
            foreach ($data['current_events'] as $key => $value) {
                $data['current_events'][$key]['start_date'] = date("dS M, Y", strtotime($data['current_events'][$key]['start_date']));
                $data['current_events'][$key]['image'] = $value['sq_image'];
                $data['current_events'][$key]['image_actual'] = url('storage/event/thumb/' . $data['current_events'][$key]['image']);
                // $data['current_events'][$key]['image_thumb'] = url('storage/event/thumb/' . $data['current_events'][$key]['image']);
            }
        } else {
            $data['current_events'] = [];
        }

        // echo json_encode($data);

        // loft events
        $data['loft_events'] = Event::select('id', 'title', 'sq_image', 'start_date')->where([['type', 'loft'], ['active', '1']])->orderby("start_date", "DESC")->limit(5)->get()->toArray();

        if ($data['loft_events']) {
            foreach ($data['loft_events'] as $key => $value) {
                $data['loft_events'][$key]['start_date'] = date("dS M, Y", strtotime($data['loft_events'][$key]['start_date']));
                $data['loft_events'][$key]['image'] = $value['sq_image'];
                $data['loft_events'][$key]['image_actual'] = url('storage/event/thumb/' . $data['loft_events'][$key]['image']);
                // $data['loft_events'][$key]['image_thumb'] = url('storage/event/app/' . $data['loft_events'][$key]['image']);
            }
        } else {
            $data['loft_events'] = [];
        }
        // echo json_encode($data);

        // dine
        $data['dine'] = Store::select('id', 'logo', 'name', "post_time")
            ->where([['active', '1'], ['s_type', 'dine']])->where(function ($query) {
                $query->where('category_id', 'like', '1,%')
                    ->orWhere('category_id', 'like', '%,1')
                    ->orWhere('category_id', 'like', '%,1,%')
                    ->orWhere('category_id', '=', '1');
            })->orderby("post_time", "DESC")->limit(5)->get()->toArray();

        if ($data['dine']) {
            foreach ($data['dine'] as $key => $value) {
                $data['dine'][$key]['feature_img'] = StoreBanner::where([['active', '1'], ['featured', '1'], ['store_id', $value['id']]])->value('image');
            }
        } else {
            $data['dine'] = [];
        }
        // echo json_encode($data);

        // movies
        $data['movies']  = MoviePoster::select('image', 'link')->where('active', '1')->orderby("priority", "asc")->get()->toArray();
        // echo json_encode($data);

        // blog
        $data['blog'] = Blog::select('image', 'id', "post_time", "title", "category_id")->where('active', '1')->orderby("post_time", "DESC")->limit(5)->get()->toArray();


        if ($data['blog']) {
            foreach ($data['blog'] as $key => $value) {
                $data['blog'][$key]['post_time'] = date("dS M, Y", strtotime($data['blog'][$key]['post_time']));
                $data['blog'][$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
                $data['blog'][$key]['image_actual'] = url('storage/blog/actual/' . $data['blog'][$key]['image']);
            }
        } else {
            $data['blog'] = [];
        }
        // echo json_encode($data);


        // top stores
        $top_stores = Store::select('id', 'logo', "post_time", 'view')
            ->where([['active', '1'], ['s_type', 'store']])->where(function ($query) {
                $query->where('category_id', 'not like', '5,%')
                    ->Where('category_id', 'not like', '%,5')
                    ->Where('category_id', 'not like', '%,5,%')
                    ->Where('category_id', '!=', '5');
            })->orderby("view", "DESC")->limit(5)->get()->toArray();

        // echo json_encode($data);

        if (!empty($top_stores)) {
            foreach ($top_stores as $key => $value) {
                $top_stores[$key]['image_actual'] = url('storage/store/actual/' . $value['logo']);
                // $new_openings[$key]['image_thumb'] = url('storage/store/thumb/' . $value['logo']);
            }
        }

        $data['top_stores'] = $top_stores;


        // top dine
        $top_dine = Store::select('id', 'logo', 'name', "post_time", 'view')
            ->where([['active', '1'], ['s_type', 'dine']])->where(function ($query) {
                $query->where('category_id', 'not like', '8,%')
                    ->Where('category_id', 'not like', '%,8')
                    ->Where('category_id', 'not like', '%,8,%')
                    ->Where('category_id', '!=', '8');
            })->orderby("post_time", "DESC")->limit(5)->get()->toArray();

        // echo json_encode($data);

        if (!empty($top_dine)) {
            foreach ($top_dine as $key => $value) {
                $top_dine[$key]['image_actual'] = url('storage/store/actual/' . $value['logo']);
                // $new_openings[$key]['image_thumb'] = url('storage/store/thumb/' . $value['logo']);
            }
        }

        $data['top_dine'] = $top_dine;

        // policies
        $data['policies'] = SiteSettings::select('app_terms', 'app_policies', 'app_disc', 'app_version_and', 'app_version_ios', 'instagram', 'facebook', 'sos', 'porter1', 'porter2', 'porter_desc', 'dine_desc', 'parking_desc', 'dine_and_win_video_url', 'parking_video_url')
            ->where('id', '1')->get()->toArray();
        // echo json_encode($data);

        // upcoming stores
        $data['upcoming_stores'] = Store::select('id', 'logo', "post_time")
            ->where([['active', '1'], ['s_type', 'store']])->where(function ($query) {
                $query->where('category_id', 'like', '5,%')
                    ->orWhere('category_id', 'like', '%,5')
                    ->orWhere('category_id', 'like', '%,5,%')
                    ->orWhere('category_id', '=', '5');
            })->orderby("post_time", "DESC")->limit(5)->get()->toArray();
        // echo json_encode($data);

        // upcoming dines
        $data['upcoming_dines'] = Store::select('id', 'logo', 'name', "post_time")
            ->where([['active', '1'], ['s_type', 'dine']])->where(function ($query) {
                $query->where('category_id', 'like', '8,%')
                    ->orWhere('category_id', 'like', '%,8')
                    ->orWhere('category_id', 'like', '%,8,%')
                    ->orWhere('category_id', '=', '8');
            })->orderby("post_time", "DESC")->limit(5)->get()->toArray();
        // echo json_encode($data);

        // navbar
        $data['navbar'] = AppNavigation::where('active', '1')->orderby("priority", "ASC")->get()->toArray();
        // echo json_encode($data);

        // qreview
        $data['qreview'] = Qreview::select('sq_image', 'id', "post_time", "author", "title")->where('active', '1')->orderby("post_time", "DESC")->limit(5)->get()->toArray();


        if ($data['qreview']) {
            foreach ($data['qreview'] as $key => $value) {
                $data['qreview'][$key]['post_time'] = date("dS M, Y", strtotime($value['post_time']));
                // $data[$key]['tag'] = "#" . implode(', #',ReviewTag::where('active','1')->whereIn('id',explode(',',$value['tags']))->pluck('title')->toArray());
                $data['qreview'][$key]['author'] = "by " . implode(', ', Qauthor::where('active', '1')->whereIn('id', explode(',', $value['author']))->pluck('title')->toArray());

                $data['qreview'][$key]['image_actual'] = url('storage/qreview/thumb/' . $value['sq_image']);
            }
        } else {
            $data['qreview'] = [];
        }


        // echo json_encode($data);

        // content
        // $data = Contest::select('name','id')->where([['active','1'],['form_date','<=',date('Y-m-d 00:00:00')],['to_date','>=',date('Y-m-d 23:59:59')]]);
        // if($data->count() > 0) $data=[$data->first()->id];
        // else $data = [];

        // app exclusive offer
        $data['app_exclusive_offer'] = StoreAppDeal::where('active', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d 23:59:59'));

        if ($data['app_exclusive_offer']) {
            $data['app_exclusive_offer'] = $data['app_exclusive_offer'];
        } else {
            $data['app_exclusive_offer'] = [];
        }
        // $data = []; // to disable the homepage button, comment out this line to enable the button
        // echo json_encode($data);

        //other details

        // test content
        $data['test_content'] = Contest::select('name', 'id')->where([['active', '1'], ['form_date', '<=', date('Y-m-d 00:00:00')], ['to_date', '>=', date('Y-m-d 23:59:59')]]);

        if ($data['test_content']) {
            $data['test_content'] = $data['test_content'];
        } else {
            $data['test_content'] = [];
        }



        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getFeedbackPageData()
    {

        // new openings
        $data['new_openings'] = Store::select('id', 'name')
            ->where([['active', '1'], ['s_type', 'store']])
            ->orderby("name", "ASC")->get()->toArray();
        // echo json_encode($data);

        // dine
        $data['dine'] = Store::select('id', 'name')
            ->where([['active', '1'], ['s_type', 'dine']])
            ->orderby("name", "ASC")->get()->toArray();
        // echo json_encode($data);

        //grievance for
        $data['grievance_for'] = array("Store", "Dine", "Mall Services");
        // echo json_encode($gvf);

        //grievance Type
        $data['grievance_type'] = array("Safety & security", "Hygiene & maintenance", "Other");
        // echo json_encode($grievanceType);

        //suggestion list
        $data['store_suggestion'] = array(
            "Product availability",
            "Store experience",
            "Offers and deals",
            "Staff friendliness",
            "Post purchase services",
            "Miscellaneous"
        );
        // echo json_encode($storeSugg);

        $data['dine_suggestion'] = array(
            "Hygiene",
            "Staff friendliness",
            "Dine experience",
            "Meal presentation",
            "Offers and deals",
            "Wishlist", "Miscellaneous"
        );
        // echo json_encode($dineSugg);

        $data['mall_suggestion'] = array(
            "Mall experience",
            "Staff friendliness",
            "Ambience",
            "Car parking",
            "Wishlist",
            "Restroom Maintenance",
            "Social Media",
            "Miscellaneous"
        );
        // echo json_encode($mallSugg);

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getLoftData()
    {
        // banner
        $banner = LoftBanner::select('app_image')->where('active', '1')->orderby('priority', 'asc')->get()->toArray();
        // echo json_encode($data);

        if (!empty($banner)) {
            foreach ($banner as $key => $value) {
                $banner[$key]['image_actual'] = url('storage/loft_banner/app/' . $value['app_image']);
            }
        }

        $data['banner'] = $banner;


        // // Current upcomming
        // $data = Event::select('id', 'title','sq_image', 'start_date')->where([['type','loft'],['active','1']])->whereDate('start_date','>=', date('Y-m-d'))->orderby("start_date","DESC")->limit(5)->get()->toArray();
        // foreach ($data as $key => $value) {
        //     $data[$key]['image'] = $value['sq_image'];
        //     $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
        // }
        // echo json_encode($data);

        // loft events
        $loft_events = Event::select('id', 'title', 'sq_image', 'start_date')->where([['type', 'loft'], ['active', '1']])->orderby("start_date", "DESC")->limit(5)->get()->toArray();

        foreach ($loft_events as $key => $value) {
            $loft_events[$key]['image'] = $value['sq_image'];
            $loft_events[$key]['image_actual'] = url('storage/event/thumb/' . $loft_events[$key]['image']);
            $loft_events[$key]['start_date'] = date("dS M, Y", strtotime($loft_events[$key]['start_date']));
        }
        // echo json_encode($data);

        $data['loft_events'] = $loft_events;

        // designer
        $loft_designer = LoftDesigner::select('image', 'id')->where('active', '1')->get()->toArray();
        // echo json_encode($data);

        if (!empty($loft_designer)) {
            foreach ($loft_designer as $key => $value) {
                $loft_designer[$key]['image_actual'] = url('storage/loft_designer/actual/' . $value['image']);
            }
        }

        $data['loft_designer'] = $loft_designer;


        // loft cms
        $data['loft_cms'] = Cms::select('content')->where([['active', '1'], ['id', '27']])->get()->toArray();
        foreach ($data['loft_cms'] as $key => $value) {
            $data['loft_cms'][$key]['content'] = str_replace('<p>module_include[loft]</p>', '', $value['content']);
        }
        // echo json_encode($data);

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getBanners()
    {
        $data = AppBanner::select('image')->where('active', '1')->orderby('priority', 'asc')->get()->toArray();

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }


    public function getNewStores()
    {

        // new openings
        $new_openings = Store::select('id', 'logo', "post_time")
            ->where([['active', '1'], ['s_type', 'store']])->where(function ($query) {
                $query->where('category_id', 'like', '1,%')
                    ->orWhere('category_id', 'like', '%,1')
                    ->orWhere('category_id', 'like', '%,1,%')
                    ->orWhere('category_id', '=', '1');
            })->orderby("post_time", "DESC")
            // ->limit(5)
            ->get()->toArray();
        // echo json_encode($data);

        if (!empty($new_openings)) {
            foreach ($new_openings as $key => $value) {
                $new_openings[$key]['image_actual'] = url('storage/store/actual/' . $value['logo']);
                // $new_openings[$key]['image_thumb'] = url('storage/store/thumb/' . $value['logo']);

                //get feature image
                $new_openings[$key]['feature_img'] = StoreBanner::where([['active', '1'], ['featured', '1'], ['store_id', $value['id']]])->value('image');
                $new_openings[$key]['feature_img_actual'] = url('storage/store_banner/actual/' . $new_openings[$key]['feature_img']);
                $new_openings[$key]['feature_img_thumb'] = url('storage/store_banner/thumb/' . $new_openings[$key]['feature_img']);
            }
        }

        if ($new_openings) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $new_openings], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }


    public function getMovies()
    {
        $data = MoviePoster::select('image', 'link')->where('active', '1')->orderby("priority", "asc")->get()->toArray();

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }


    public function getDesigners()
    {
        $data = LoftDesigner::select('image', 'id')->where('active', '1')->get()->toArray();

        if ($data) {

            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $data[$key]['image_actual'] = url('storage/loft_designer/actual/' . $value['image']);
                }
            }

            // $data['loft_designer'] = $data;

            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getDesigner($id)
    {
        $loft_designer = LoftDesigner::where([['id', $id], ['active', '1']])->get()->toArray();

        if (!empty($loft_designer)) {
            foreach ($loft_designer as $key => $value) {
                $loft_designer[$key]['image_actual'] = url('storage/loft_designer/actual/' . $value['image']);
            }
        }
        $data['loft_designer'] = $loft_designer;
        // echo json_encode($data);

        // upcoming
        $upcoming = Event::select('id', 'title', 'start_date')->where([['type', 'loft'], ['active', '1']])
            ->whereDate('start_date', '>', date('Y-m-d'))
            ->where(function ($query) use ($id) {
                $query->where('designers', 'like', $id . ',%')
                    ->orWhere('designers', 'like', '%,' . $id)
                    ->orWhere('designers', 'like', '%,' . $id . ',%')
                    ->orWhere('designers', '=', $id);
            })->orderby("start_date", "DESC")->get()->toArray();
        foreach ($upcoming as $key => $value) {
            $upcoming[$key]['start_date'] = date("dS M, Y", strtotime($upcoming[$key]['start_date']));
        }
        // echo json_encode($data);

        $data['upcoming'] = $upcoming;


        // past
        $past = Event::select('id', 'title', 'start_date')->where([['type', 'loft'], ['active', '1']])
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->where(function ($query) use ($id) {
                $query->where('designers', 'like', $id . ',%')
                    ->orWhere('designers', 'like', '%,' . $id)
                    ->orWhere('designers', 'like', '%,' . $id . ',%')
                    ->orWhere('designers', '=', $id);
            })->orderby("start_date", "DESC")->get()->toArray();
        foreach ($past as $key => $value) {
            $past[$key]['images'] = EventGallery::select('title', 'image')->where([['event_id', $value['id']], ['designer_id', $id], ['active', '1']])->get()->toArray();
            $past[$key]['start_date'] = date("dS M, Y", strtotime($past[$key]['start_date']));
        }
        // echo json_encode($data);

        $data['past'] = $past;

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getBeaconOffers()
    {

        $data = StoreDeal::where([['active', '1'], ['beacon_type', '1']])->whereDate('end_date', '>=', date('Y-m-d'))->orderby("post_time", "DESC")->get()->toArray();
        $entry = array();
        foreach ($data as $key => $value) {
            if ($value['store_id'] == 0) {
                $entrybeacon = Beacon::where('type', '1')->get()->toArray();
                foreach ($entrybeacon as $k => $v) {
                    $b = array(
                        "id" => 0,
                        "store_id" => $value['store_id'],
                        "beacon_type" => $value['beacon_type'],
                        "title" => $value['title'],
                        "description" => $value['description'],
                        "image" => $value['image'],
                        "post_time" => $value['post_time'],
                        "start_date" => $value['start_date'],
                        "end_date" => $value['end_date'],
                        "active" => $value['active'],
                        "beacon_id" => $v['uuid'],
                        'type' => 'text',
                        'activity' => "CurrentOffers",
                        'subText' => "",
                    );

                    array_push($data, $b);
                }
            } elseif ($value['store_id'] == -1) {
                $loftbeacon = Beacon::find(21);
                $b = array(
                    "id" => 0,
                    "store_id" => $value['store_id'],
                    "beacon_type" => $value['beacon_type'],
                    "title" => $value['title'],
                    "description" => $value['description'],
                    "image" => $value['image'],
                    "post_time" => $value['post_time'],
                    "start_date" => $value['start_date'],
                    "end_date" => $value['end_date'],
                    "active" => $value['active'],
                    "beacon_id" => $loftbeacon->uuid,
                    'type' => 'text',
                    'activity' => "CurrentOffers",
                    'subText' => "",
                );

                array_push($data, $b);
            }

            $data[$key]['type'] = 'text';
            $data[$key]['activity'] = $value['store_id'] == 0 || $value['store_id'] == -1 ? "CurrentOffers" : 'NotificationPage';
            $data[$key]['subText'] = $value['store_id'] == 0 || $value['store_id'] == -1 ? "" : Store::find($value['store_id'])->name;
            $data[$key]['beacon_id'] = $value['store_id'] == 0 || $value['store_id'] == -1 ? "" : Beacon::find(Store::find($value['store_id'])->beacon_id)->uuid;
        }


        echo json_encode($data);
    }

    public function getDeals($store_id = false)
    {
        $where = [['active', '1'], ['image', '!=', ''], ['beacon_type', '0']];
        if ($store_id) {
            array_push($where, ['store_id', $store_id]);
        }
        $data = StoreDeal::select('image', 'id', "post_time")->where($where)->where('post_time', '<=', date("Y-m-d H:i:s"))->whereDate('end_date', '>=', date('Y-m-d'))->orderby("post_time", "DESC")->get()->toArray();

        if ($data) {
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $data[$key]['image_actual'] = url('storage/store_deal/actual/' . $value['image']);
                    // $banner[$key]['image_thumb'] = url('storage/store_deal/thumb/' . $value['image']);
                }
            }

            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getReviews($store_id)
    {
        $where = [['approve', '1'], ['store_id', $store_id]];
        $data = StoreRating::where($where)->orderby("id", "DESC")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['user'] = User::find($value['user_id'])->name;
            $data[$key]['date'] = date('F d, Y', strtotime($value['created_at']));
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
        echo json_encode($data);
    }


    public function getDeal($id)
    {
        $data = StoreDeal::where([['active', '1'], ['id', $id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['store_type'] = Store::find($value['store_id'])->s_type;
            $data[$key]['start_date'] = date("dS M, Y", strtotime($data[$key]['start_date']));
            $data[$key]['end_date'] = date("dS M, Y", strtotime($data[$key]['end_date']));
            $data[$key]['image_actual'] = url('storage/store_deal/actual/' . $data[$key]['image']);
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getStores($cat_id, $type = 'store')
    {
        // if ($type_id != "-0") $type_id = explode('-', substr($type_id, 1));
        // if ($cat_id != "-0") $cat_id = explode('-', substr($cat_id, 1));
        // if ($cuisine != "-0") $cuisine = explode('-', substr($cuisine, 1));
        // if ($floor != "Any Floor") $floor = explode('-', $floor);

        if (isset($cat_id) && $cat_id > 0) {
            if ($type == 'store') {
                $data = Store::select('id', 'name', 'type_id', 'category_id', 'cuisine', 'logo')
                    ->where([['active', '1'], ['s_type', $type], ['type_id', $cat_id]]);
            } else {
                $data = Store::select('id', 'name', 'type_id', 'category_id', 'cuisine', 'logo')
                    ->where([['active', '1'], ['s_type', $type]])
                    // ->where([['active', '1'], ['s_type', $type]])
                    ->whereRaw('FIND_IN_SET(' . $cat_id . ', cuisine)');
                // echo 'ss';die;
            }
        } else {
            $data = Store::select('id', 'name', 'type_id', 'category_id', 'cuisine', 'logo')->where([['active', '1'], ['s_type', $type]]);
        }

        // if ($type_id != "-0") $data = $data->whereIn('type_id', $type_id);
        // if ($cat_id != "-0") {
        //     $data = $data->where(function ($query) use ($cat_id) {
        //         $query->where('category_id', 'like', $cat_id[0] . ',%');
        //         foreach ($cat_id as $key => $value) {
        //             $query->orwhere('category_id', 'like', $value . ',%')
        //                 ->orWhere('category_id', 'like', '%,' . $value)
        //                 ->orWhere('category_id', 'like', '%,' . $value . ',%')
        //                 ->orWhere('category_id', '=', $value);
        //         }
        //     });
        // }
        // if ($floor != "Any Floor") $data = $data->whereIn('floor', $floor);
        // if ($cuisine != "-0") {
        //     foreach ($cuisine as $key => $value) {
        //         $data = $data->where(function ($query) use ($value) {
        //             $query->where('cuisine', 'like', $value . ',%')
        //                 ->orWhere('cuisine', 'like', '%,' . $value)
        //                 ->orWhere('cuisine', 'like', '%,' . $value . ',%')
        //                 ->orWhere('cuisine', '=', $value);
        //         });
        //     }
        // }

        $data = $data->orderby("name")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['type_id'] = StoreType::find($value['type_id'])->title;

            $value['category_id'] = explode(',', $value['category_id']);

            if ($value['category_id'][0] != '')
                foreach ($value['category_id'] as $k => $v) {
                    $value['category_id'][$k] = StoreCategory::find($v)->title;
                }
            $data[$key]['category_id'] = implode(', ', $value['category_id']);

            $value['cuisine'] = explode(',', $value['cuisine']);

            if ($value['cuisine'][0] != '')
                foreach ($value['cuisine'] as $k => $v) {
                    $value['cuisine'][$k] = DineCuisine::find($v)->title;
                }
            $data[$key]['cuisine'] = implode(', ', $value['cuisine']);

            $data[$key]['feature_img'] = StoreBanner::where([['active', '1'], ['featured', '1'], ['store_id', $value['id']]])->value('image');

            $data[$key]['logo_url'] = url('storage/store/actual/' . $data[$key]['logo']);
            $data[$key]['feature_img_actual'] = url('storage/store_banner/actual/' . $data[$key]['feature_img']);
            $data[$key]['feature_img_thumb'] = url('storage/store_banner/thumb/' . $data[$key]['feature_img']);

            $rate = StoreRating::where('store_id', $value['id'])->avg('rate');
            if ($rate != null) $data[$key]['rate'] = intval($rate);
            else $data[$key]['rate'] = 0;
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getStore($id)
    {
        $data = Store::where([['active', '1'], ['id', $id]])->get()->makeHidden('login_id')->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['type_id'] = StoreType::find($value['type_id'])->title;

            $value['category_id'] = explode(',', $value['category_id']);

            if ($value['category_id'][0] != '')
                foreach ($value['category_id'] as $k => $v) {
                    $value['category_id'][$k] = StoreCategory::find($v)->title;
                }
            $data[$key]['category_id'] = implode(', ', $value['category_id']);

            $value['cuisine'] = explode(',', $value['cuisine']);
            if ($value['cuisine'][0] != '')
                foreach ($value['cuisine'] as $k => $v) {
                    $value['cuisine'][$k] = DineCuisine::find($v)->title;
                }
            $data[$key]['cuisine'] = implode(', ', $value['cuisine']);

            $data[$key]['store_phones'] = StoreContactNo::where('store_id', $id)->pluck('phone')->toArray();
            $data[$key]['store_emails'] = StoreContactEmail::where('store_id', $id)->pluck('email')->toArray();
            $data[$key]['banners'] = StoreBanner::where([['active', '1'], ['store_id', $id]])->count();


            $data[$key]['deals'] = StoreDeal::where([['active', '1'], ['store_id', $id], ['beacon_type', '0']])->where('post_time', '<=', date("Y-m-d H:i:s"))->whereDate('end_date', '>=', date('Y-m-d'))->count();

            $data[$key]['logo_url'] = url('storage/store/actual/' . $data[$key]['logo']);
            $data[$key]['location_img'] = url('storage/store/actual/' . $data[$key]['location']);

            // app exclusive offer
            $data[$key]['appoffer'] = StoreAppDeal::select('title', 'id', 'end_date as until')->where([['active', 1], ['store_id', $value['id']]])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d 23:59:59'))->get()->toArray();

            $banner_images = StoreBanner::select('image', 'app_image')->where([['active', '1'], ['store_id', $id]])->get()->toArray();

            // if (!empty($banner_images)) {
            //     foreach ($banner_images as $key => $value) {
            //         $banner_images['image_actual'] = url('storage/store_banner/actual/' . $value['image']);
            //         $banner_images['image_thumb'] = url('storage/store_banner/app/' . $value['app_image']);
            //     }
            //     $data[$key]['banner_images'] = $banner_images;
            // }
            $data[$key]['banner_images'] =  $banner_images;
            $data[$key]['image_url'] =  url('storage/store_banner/actual/');
            $data[$key]['app_image_url'] =  url('storage/store_banner/app/');
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getStoreBanners($store_id)
    {
        $data = StoreBanner::select('app_image')->where([['active', '1'], ['store_id', $store_id]])->orderby('priority', 'asc')->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['app_image'];
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getStoreTypes()
    {
        $data = StoreType::select('id', 'title')->where([['type', 'store'], ['active', '1']])->orderby("title")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['store'] = Store::where([['active', '1'], ['type_id', $value['id']]])->count();
        }

        // $data['upcomming'] = StoreCategory::select('id', 'title')->where([['type', 'store'], ['active', '1']])->orderby("title")->get()->toArray();

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getDineTypes()
    {
        $data['store_type'] = StoreType::select('id', 'title')->where([['type', 'dine'], ['active', '1']])->orderby("title")->get()->toArray();
        // echo json_encode($data);

        $data['store_category'] = StoreCategory::select('id', 'title')->where([['type', 'dine'], ['active', '1']])->orderby("title")->get()->toArray();
        // echo json_encode($data);

        $data['dine_cuisine'] = DineCuisine::select('id', 'title')->where('active', '1')->orderby("title")->get()->toArray();
        foreach ($data['dine_cuisine'] as $key => $value) {
            $data['dine_cuisine'][$key]['store'] = Store::where('active', '1')->where(function ($query) use ($value) {
                $query->where('cuisine', 'like', $value['id'] . ',%')
                    ->orWhere('cuisine', 'like', '%,' . $value['id'])
                    ->orWhere('cuisine', 'like', '%,' . $value['id'] . ',%')
                    ->orWhere('cuisine', '=', $value['id']);
            })->count();
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }


    public function getProfileInterests()
    {
        $data = StoreType::select('id', 'title')->where([['type', 'store'], ['active', '1']])->orderby("title")->get()->toArray();
        // foreach ($data as $key => $value) {
        //     $data[$key]['store'] = Store::where([['active', '1'], ['type_id', $value['id']]])->count();
        // }

        // $data['upcomming'] = StoreCategory::select('id', 'title')->where([['type', 'store'], ['active', '1']])->orderby("title")->get()->toArray();

        $dine_cuisine = DineCuisine::select('id', 'title')->where('active', '1')->orderby("title")->get()->toArray();
        // foreach ($dine_cuisine as $key => $value) {
        //     $store = Store::where('active', '1')->where(function ($query) use ($value) {
        //         $query->where('cuisine', 'like', $value['id'] . ',%')
        //             ->orWhere('cuisine', 'like', '%,' . $value['id'])
        //             ->orWhere('cuisine', 'like', '%,' . $value['id'] . ',%')
        //             ->orWhere('cuisine', '=', $value['id']);
        //     })->count();
        // }
        // print_r($dine_cuisine);die;

        $data = array_merge($data, $dine_cuisine);

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getEvents()
    {
        $data = Event::select('id', 'title', 'sq_image', 'start_date')->where([['type', 'quest'], ['active', '1']])->orderby("start_date", "desc")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['image_actual'] = url('storage/event/thumb/' . $data[$key]['image']);
            $data[$key]['start_date'] = date("dS M, Y", strtotime($data[$key]['start_date']));
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }
    public function getEvent($id)
    {
        $data = Event::select('content', 'title', 'sq_image', 'image', 'start_date', 'end_date')->where([['active', '1'], ['id', $id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['start_date'] = date("dS M, Y", strtotime($data[$key]['start_date']));
            $data[$key]['end_date'] = date("dS M, Y", strtotime($data[$key]['end_date']));
            // $data[$key]['content'] = strip_tags($data[$key]['content']);
            $data[$key]['banners'] = EventGallery::where([['active', '1'], ['event_id', $id]])->pluck('image')->toArray();
            foreach ($data[$key]['banners'] as $k => $v) $data[$key]['banners'][$k] = url("/storage/event_gallery/actual/" . $v);
            array_push($data[$key]['banners'], url("/storage/event/thumb/" . $value['sq_image']));
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getLoftEvents()
    {
        $data = Event::select('id', 'title', 'sq_image', 'start_date')->where([['type', 'loft'], ['active', '1']])->orderby("start_date", "DESC")->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['image_actual'] = url('storage/event/thumb/' . $data[$key]['image']);
            $data[$key]['start_date'] = date("dS M, Y", strtotime($data[$key]['start_date']));
        }


        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    // public function getLoftNewEvents(){
    //     $data = Event::select('id', 'title','image', 'start_date')->where([['type','loft'],['active','1']])->whereDate('start_date','>', date('Y-m-d'))->orderby("start_date")->get()->toArray();
    //     foreach ($data as $key => $value) {
    //         $data[$key]['start_date'] = date("dS M, Y",strtotime($data[$key]['start_date']));
    //     }
    //     echo json_encode($data);
    // }

    public function getBlogs($cat_id = false)
    {
        $data = BlogCategory::select('id', 'title')->where('active', '1')->orderby("title")->get()->toArray();
        echo json_encode($data);

        $data = Blog::select('sq_image', 'id', "post_time", "title", "content", "category_id")->where('active', '1');
        if ($cat_id && ($cat_id != "-0")) {
            $cat_id = explode('-', substr($cat_id, 1));
            $data = $data->whereIn('category_id', $cat_id);
        }

        $data = $data->orderby("post_time", "DESC")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['post_time'] = date("dS M, Y", strtotime($data[$key]['post_time']));
            $data[$key]['content'] = str_limit(strip_tags($data[$key]['content']), 20);
            $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
        }
        echo json_encode($data);
    }

    public function getBlog($id)
    {
        $data = Blog::where([['active', '1'], ['id', $id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
            //$data[$key]['content'] = strip_tags($data[$key]['content']);
            $data[$key]['post_time'] = date("dS M, Y", strtotime($data[$key]['post_time']));
        }
        echo json_encode($data);
    }

    public function getFrames()
    {
        $data = CameraFrame::where('active', '1')->orderby('created_at', 'desc')->pluck('image')->toArray();
        echo json_encode($data);
    }

    public function getFaq()
    {
        $data = array("question" => "Do you require some mall assistance? ", "answer" => "Please call, +916290825643 or you can email us at Quest.helpdesk2@rp-sg.in.");

        return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
    }

    public function getNotification()
    {
        $data = AppPush::where('push', '1')->orderby('id', 'desc')->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['push_time'] = \Carbon::parse($value['push_time'])->diffForHumans();
        }
        echo Crypt::encryptString(json_encode($data));
    }

    public function search($searchTerm)
    {
        $searchResult = [];
        $sResult = [];
        $dResult = [];
        $bResult = [];
        $qeResult = [];
        $leResult = [];
        $mResult = [];
        $storeResult = Store::select("id", "name")->where([['s_type', 'store'], ['active', '1'], ['post_time', '<=', date("Y-m-d H:i:s")]])
            ->search(["name", "description"], $searchTerm)
            ->pluck("id", "name")->toArray();
        foreach ($storeResult as $key => $value) {
            $sResult[] = [
                'result' => $key,
                'page' => "Store",
                'id' => $value
            ];
        }

        $dineResult = Store::select("id", "name")->where([['s_type', 'dine'], ['active', '1'], ['post_time', '<=', date("Y-m-d H:i:s")]])
            ->search(["name", "description"], $searchTerm)
            ->pluck("id", "name")->toArray();
        foreach ($dineResult as $key => $value) {
            $dResult[] = [
                'result' => $key,
                'page' => "Restaurant",
                'id' => $value
            ];
        }

        // $blogResult = Blog::select("id", "title")->where([['active', '1'], ['post_time', '<=', date("Y-m-d H:i:s")]])
        //     ->search(["title", "content"], $searchTerm)
        //     ->pluck("id", "title")->toArray();
        // // foreach ($blogResult as $key => $value) $blogResult[$key] = $key . "^^Blog Article-" . $value;
        // foreach ($blogResult as $key => $value) {
        //     $bResult[] = [
        //         'result' => $key,
        //         'page' => "Blog Article",
        //         'id' => $value
        //     ];
        // }

        $questEventResult = Event::select("id", "title")->where([['type', 'quest'], ['active', '1'], ['post_time', '<=', date("Y-m-d H:i:s")]])
            ->search(["title", "content"], $searchTerm)
            ->pluck("id", "title")->toArray();
        // foreach ($questEventResult as $key => $value) $questEventResult[$key] = $key . "^^Quest Event-" . $value;
        foreach ($questEventResult as $key => $value) {
            $qeResult[] = [
                'result' => $key,
                'page' => "Quest Event",
                'id' => $value
            ];
        }

        $loftEventResult = Event::select("id", "title")->where([['type', 'loft'], ['active', '1'], ['post_time', '<=', date("Y-m-d H:i:s")]])
            ->search(["title", "content"], $searchTerm)
            ->pluck("id", "title")->toArray();
        // foreach ($loftEventResult as $key => $value) $loftEventResult[$key] = $key . "^^Loft Event-" . $value;
        foreach ($loftEventResult as $key => $value) {
            $leResult[] = [
                'result' => $key,
                'page' => "Loft Event",
                'id' => $value
            ];
        }

        $movieResult = MoviePoster::select("id", "title")->where('active', '1')
            ->search(["title"], $searchTerm)
            ->pluck("id", "title")->toArray();
        // foreach ($movieResult as $key => $value) $movieResult[$key] = $key . "^^Movie-" . $value;
        foreach ($movieResult as $key => $value) {
            $mResult[] = [
                'result' => $key,
                'page' => "Movie",
                'id' => $value
            ];
        }

        $searchResult = array_merge(
            array_values($sResult),
            array_values($dResult),
            // array_values($bResult),
            array_values($qeResult),
            array_values($leResult),
            array_values($mResult)
        );

        // $resp = array(
        //     'walk_level' => WalkLevel::all()->toArray(),
        //     'redeem_offer' => $redeem_offer,
        //     'walk_offer' => $walk_offer,
        // );

        return response()->json(['status' => 1, 'message' => 'success!', 'respData' => $searchResult], 200);
    }

    private function genCode()
    {
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = substr(str_shuffle($char), 1, 7);
        if (User::where('referral_code', $code)->count() == 0) return $code;
        else return $this->genCode();
    }

    public function socialAuth(Request $request)
    {

        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['image' => Crypt::decryptString(request()->image)]);
        // request()->merge(['login_device' => Crypt::decryptString(request()->login_device)]);
        // request()->merge(['platform' => Crypt::decryptString(request()->platform)]);
        // if (request()->has('apple_user_id')) request()->merge(['apple_user_id' => Crypt::decryptString(request()->apple_user_id)]);

        // validation
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email',
            // 'name' => 'required',
            'login_device' => 'required',
            'platform' => 'required',
            'login_source' => 'required|in:google,facebook,apple',
            'apple_user_id' => 'required_if:login_source,apple',
            'google_user_id' => 'required_if:login_source,google',
            'facebook_user_id' => 'required_if:login_source,facebook',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {

            if (request()->login_source == 'apple') {
                $user = User::where('apple_user_id', request()->apple_user_id);
            }
            if (request()->login_source == 'facebook') {
                $user = User::where('facebook_user_id', request()->facebook_user_id);
            }
            if (request()->login_source == 'google') {
                $user = User::where('google_user_id', request()->google_user_id);
            }

            if ($user->count() > 0) {
                $user = $user->first();
                if ($user->blocked == 1) {
                    return response()->json(['status' => 0, 'message' => 'Sorry! Please try again later.', 'respData' => []], 200);
                }

                // if ($user->image == "" && request()->image != "") {
                //     $time = time();
                //     Storage::disk('public')->put('users/' . $user->id . '_' . $time . '.jpg', \Image::make(request()->image)->encode('jpg')->__toString(), "public");
                //     $user->image = $user->id . '_' . $time . '.jpg';
                // }
                $user->login_device = request()->login_device;
                $user->platform = request()->platform;
                $user->token = bin2hex(openssl_random_pseudo_bytes(128));

                if (request()->login_source == 'apple') {
                    $user->apple_user_id = request()->apple_user_id;
                }
                if (request()->login_source == 'facebook') {
                    $user->facebook_user_id = request()->facebook_user_id;
                }
                if (request()->login_source == 'google') {
                    $user->google_user_id = request()->google_user_id;
                }

                if (isset(request()->email)) {
                    $user->email = request()->email;
                }else{
                    $user->email = 'na';
                }

                if (isset(request()->name)) {
                    $user->name = request()->name;
                }else{
                    $user->name = 'na';
                }

                if ($user->is_first_login == 0) {
                    $user->is_first_login = 1;
                }

                $user->chash = "";
                $user->fhash = "";
                $user->active = "1";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
            } else {
                // request()->merge(['password' => bcrypt("HJDGSIUBSJFKKBF")]);
                request()->merge(['active' => '1']);
                request()->merge(['referral_code' => $this->genCode()]);

                $newUser = User::create(request()->all());
                $user = User::where('id', $newUser->id)->first();

                // if (request()->image != "") {
                //     $time = time();
                //     Storage::disk('public')->put('users/' . $user->id . '_' . $time . '.jpg', \Image::make(request()->image)->encode('jpg')->__toString(), "public");
                //     $user->image = $user->id . '_' . $time . '.jpg';
                // }


                if (request()->login_source == 'apple') {
                    $user->apple_user_id = request()->apple_user_id;
                }
                if (request()->login_source == 'facebook') {
                    $user->facebook_user_id = request()->facebook_user_id;
                }
                if (request()->login_source == 'google') {
                    $user->google_user_id = request()->google_user_id;
                }

                if (isset(request()->email)) {
                    $user->email = request()->email;
                }else{
                    $user->email = 'na';
                }

                if (isset(request()->name)) {
                    $user->name = request()->name;
                }else{
                    $user->name = 'na';
                }

                if ($user->is_first_login == 0) {
                    $user->is_first_login = 1;
                }

                $user->login_device = request()->login_device;
                $user->platform = request()->platform;
                $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                $user->active = "1";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
            }

            $walk_offer = array();
            if ($user->step_data != "") {
                $user_steps = json_decode($user->step_data, true);
                $total = 0;
                foreach ($user_steps as $key => $value) {
                    $total = $total + intval($value);
                }

                $user->total_steps = $total;
                $user->save();

                if (WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->count() > 0) {
                    $near_data = WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->first()->threshold;
                } else {
                    $near_data = WalkLevel::where("threshold", "<", $total)->orderby('id', 'ASC')->first()->threshold;
                }
                $walk_offer = WalkLevel::where('threshold', $near_data)->orwhere('threshold', '<', $near_data);
                $id = $walk_offer->pluck('id')->toArray();
                $walk_offer = WalkOffer::where('active', '1')->orderby('threshold', 'asc')->get()->toArray();
                // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
            }

            $redeem_offer = UserWalkOffer::where("user_id", $user->id)->get()->toArray();
            // $message = array("success" => Crypt::encryptString(json_encode($user->toArray()) . json_encode(WalkLevel::all()->toArray()) . json_encode($redeem_offer) . json_encode($walk_offer)));

            $resp = array(
                'user' => $user,
                'walk_level' => WalkLevel::all()->toArray(),
                'redeem_offer' => $redeem_offer,
                'walk_offer' => $walk_offer,
            );

            return response()->json(['status' => 1, 'message' => 'success!', 'respData' => $resp], 200);
        }
    }

    public function socialAuthApple(Request $request)
    {

        // request()->merge(['login_device' => Crypt::decryptString(request()->login_device)]);
        // request()->merge(['platform' => Crypt::decryptString(request()->platform)]);
        // request()->merge(['apple_user_id' => Crypt::decryptString(request()->apple_user_id)]);

        // validation
        $validator = Validator::make($request->all(), [
            'apple_user_id' => 'required',
            'login_device' => 'required',
            'platform' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        } else {
            $user = User::where('apple_user_id', request()->apple_user_id);

            if ($user->count() > 0) {
                $user = $user->first();
                if ($user->blocked == 1) return json_encode(array("error" => "Sorry! Please try again later."));

                $user->login_device = request()->login_device;
                $user->platform = request()->platform;
                $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                $user->chash = "";
                $user->fhash = "";
                $user->active = "1";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();


                $walk_offer = array();
                if ($user->step_data != "") {
                    $user_steps = json_decode($user->step_data, true);
                    $total = 0;
                    foreach ($user_steps as $key => $value) {
                        $total = $total + intval($value);
                    }

                    $user->total_steps = $total;
                    $user->save();

                    if (WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->count() > 0) {
                        $near_data = WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->first()->threshold;
                    } else {
                        $near_data = WalkLevel::where("threshold", "<", $total)->orderby('id', 'ASC')->first()->threshold;
                    }
                    $walk_offer = WalkLevel::where('threshold', $near_data)->orwhere('threshold', '<', $near_data);
                    $id = $walk_offer->pluck('id')->toArray();
                    $walk_offer = WalkOffer::where('active', '1')->orderby('threshold', 'asc')->get()->toArray();
                    // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                    foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                }

                $redeem_offer = UserWalkOffer::where("user_id", $user->id)->get()->toArray();
                $message = array("success" => Crypt::encryptString(json_encode($user->toArray()) . json_encode(WalkLevel::all()->toArray()) . json_encode($redeem_offer) . json_encode($walk_offer)));
                echo json_encode($message);
            } else {
                return json_encode(array("error" => "nouser"));
            }
        }
    }



    public function sendRegOTP(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'otp_type' => 'required|in:email,phone',
            'email' => 'required_if:otp_type,email|email|unique:user,email',
            'phone' => ['required_if:otp_type,phone', 'size:10', Rule::unique('user')->ignore(request()->id)]
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $otp = 1234;
            $user = User::where('email', $request->email)
                ->orWhere('phone',  $request->phone)
                ->first();
            if ($user) {
                return response()->json(['status' => 0, 'message' => 'User already exists!', 'respData' => []], 200);
            }

            if ($request->otp_type == 'email') {
                $userEmail = DB::table('otp_verification')->where('email', $request->email)->first();

                if (isset($userEmail) && $userEmail->id != '') {
                    //update
                    DB::table('otp_verification')->where('id', $userEmail->id)->update(
                        ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                    );
                } else {
                    //insert
                    DB::table('otp_verification')->insert(
                        ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                    );
                }

                // $data = request()->all();
                // Mail::to(request()->email, request()->name)->send(new EmailVerify($data));
                return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else if ($request->otp_type == 'phone') {
                $userPhone = DB::table('otp_verification')->where('phone', $request->phone)->first();

                // $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737270600501&mobile=" . request()->phone . "&message=" . urlencode($otp . " is your OTP for phone number verification. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));

                if (isset($userPhone) && $userPhone->id != '') {
                    //update
                    DB::table('otp_verification')->where('id', $userPhone->id)->update(
                        ['phone' => $request->phone, 'phone_otp' => $otp]
                    );
                } else {
                    //insert
                    DB::table('otp_verification')->insert(
                        ['phone' => $request->phone, 'phone_otp' => $otp]
                    );
                }

                return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Wrong otp_type!', 'respData' => []], 200);
            }
        }
    }

    public function verifyRegOTP(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'otp_type' => 'required|in:email,phone',
            'otp' => 'required|numeric',
            'email' => 'required_if:otp_type,email|email|unique:user,email',
            'phone' => ['required_if:otp_type,phone', 'size:10', Rule::unique('user')->ignore(request()->id)]
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $user = User::where('email', $request->email)
                ->orWhere('phone',  $request->phone)
                ->first();
            if ($user) {
                return response()->json(['status' => 0, 'message' => 'User already exists!', 'respData' => []], 200);
            }

            if ($request->otp_type == 'email') {
                $userEmail = DB::table('otp_verification')->where('email', $request->email)->first();

                if (isset($userEmail) && $userEmail->id != '') {
                    // update
                    if ($request->otp == $userEmail->email_otp) {
                        //update

                        DB::table('otp_verification')->where('id', $userEmail->id)->update(
                            ['email_verified' => 1]
                        );

                        $userEmail = DB::table('otp_verification')->where('email', $request->email)->first();

                        return response()->json(['status' => 1, 'message' => 'OTP verified successfully!', 'respData' => $userEmail], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => 'OTP not verified!', 'respData' => []], 200);
                    }
                } else {
                    return response()->json(['status' => 0, 'message' => 'OTP not send!', 'respData' => []], 200);
                }
            } else if ($request->otp_type == 'phone') {
                $userPhone = DB::table('otp_verification')->where('phone', $request->phone)->first();

                if (isset($userPhone) && $userPhone->id != '') {
                    // update
                    if ($request->otp == $userPhone->phone_otp) {
                        //
                        DB::table('otp_verification')->where('id', $userPhone->id)->update(
                            ['phone_verified' => 1]
                        );

                        $userPhone = DB::table('otp_verification')->where('phone', $request->phone)->first();

                        return response()->json(['status' => 1, 'message' => 'OTP verified successfully!', 'respData' => $userPhone], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => 'OTP not verified!', 'respData' => []], 200);
                    }
                } else {
                    return response()->json(['status' => 0, 'message' => 'OTP not send!', 'respData' => []], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Wrong otp_type!', 'respData' => []], 200);
            }
        }
    }


    public function sendProfileOTP(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'otp_type' => 'required|in:email,phone',
            'email' => 'required_if:otp_type,email|email|unique:user,email',
            'phone' => ['required_if:otp_type,phone', 'size:10']
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $otp = 1234;
            $user = User::where('email', $request->email)
                ->orWhere('phone',  $request->phone)
                ->first();
            if ($user) {
                return response()->json(['status' => 0, 'message' => 'User already exists!', 'respData' => []], 200);
            }

            if ($request->otp_type == 'email') {
                $userEmail = DB::table('potp_verification')->where('email', $request->email)->first();

                if (isset($userEmail) && $userEmail->id != '') {
                    //update
                    DB::table('potp_verification')->where('id', $userEmail->id)->update(
                        ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                    );
                } else {
                    //insert
                    DB::table('potp_verification')->insert(
                        ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                    );
                }

                // $data = request()->all();
                // Mail::to(request()->email, request()->name)->send(new EmailVerify($data));
                return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else if ($request->otp_type == 'phone') {
                $userPhone = DB::table('potp_verification')->where('phone', $request->phone)->first();

                // $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737270600501&mobile=" . request()->phone . "&message=" . urlencode($otp . " is your OTP for phone number verification. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));

                if (isset($userPhone) && $userPhone->id != '') {
                    //update
                    DB::table('potp_verification')->where('id', $userPhone->id)->update(
                        ['phone' => $request->phone, 'phone_otp' => $otp]
                    );
                } else {
                    //insert
                    DB::table('potp_verification')->insert(
                        ['phone' => $request->phone, 'phone_otp' => $otp]
                    );
                }

                return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Wrong otp_type!', 'respData' => []], 200);
            }
        }
    }



    public function verifyProfileOTP(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'otp_type' => 'required|in:email,phone',
            'otp' => 'required|numeric',
            'email' => 'required_if:otp_type,email|email|unique:user,email',
            'phone' => ['required_if:otp_type,phone', 'size:10']
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $user = User::where('email', $request->email)
                ->orWhere('phone',  $request->phone)
                ->first();
            if ($user) {
                return response()->json(['status' => 0, 'message' => 'User alreadydoes not exists!', 'respData' => []], 200);
            }

            if ($request->otp_type == 'email') {
                $userEmail = DB::table('potp_verification')->where('email', $request->email)->first();

                if (isset($userEmail) && $userEmail->id != '') {
                    // update
                    if ($request->otp == $userEmail->email_otp) {
                        //update

                        DB::table('potp_verification')->where('id', $userEmail->id)->update(
                            ['email_verified' => 1]
                        );

                        $userEmail = DB::table('potp_verification')->where('email', $request->email)->first();

                        return response()->json(['status' => 1, 'message' => 'OTP verified successfully!', 'respData' => $userEmail], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => 'OTP not verified!', 'respData' => []], 200);
                    }
                } else {
                    return response()->json(['status' => 0, 'message' => 'OTP not send!', 'respData' => []], 200);
                }
            } else if ($request->otp_type == 'phone') {
                $userPhone = DB::table('potp_verification')->where('phone', $request->phone)->first();

                if (isset($userPhone) && $userPhone->id != '') {
                    // update
                    if ($request->otp == $userPhone->phone_otp) {
                        //
                        DB::table('potp_verification')->where('id', $userPhone->id)->update(
                            ['phone_verified' => 1]
                        );

                        $userPhone = DB::table('potp_verification')->where('phone', $request->phone)->first();

                        return response()->json(['status' => 1, 'message' => 'OTP verified successfully!', 'respData' => $userPhone], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => 'OTP not verified!', 'respData' => []], 200);
                    }
                } else {
                    return response()->json(['status' => 0, 'message' => 'OTP not send!', 'respData' => []], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Wrong otp_type!', 'respData' => []], 200);
            }
        }
    }


    public function sendLoginOTP(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'otp_type' => 'required|in:email,phone',
            // 'email' => 'required_if:otp_type,email|email|unique:user,email',
            'phone' => ['required_if:otp_type,phone', 'size:10']
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $otp = 1234;
            // $otp = rand(1000, 9999);
            $user = User::where('email', $request->email)
                ->orWhere('phone',  $request->phone)
                ->first();
            if (!$user) {
                return response()->json(['status' => 0, 'message' => 'User not found!', 'respData' => []], 200);
            }

            if ($request->otp_type == 'email') {
                // $userEmail = DB::table('otp_verification')->where('email', $request->email)->first();

                // if (isset($userEmail) && $userEmail->id != '') {
                //update
                // DB::table('otp_verification')->where('id', $userEmail->id)->update(
                //     ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                // );
                // } else {
                //insert
                //     DB::table('otp_verification')->insert(
                //         ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                //     );
                // }

                // $data = request()->all();
                // Mail::to(request()->email, request()->name)->send(new EmailVerify($data));
                // return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else if ($request->otp_type == 'phone') {
                //update
                $user->login_otp = $otp;
                $user->login_otp_verified = 0;
                $user->save();

                // $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737270600501&mobile=" . request()->phone . "&message=" . urlencode($otp . " is your OTP for phone number verification. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));

                return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Wrong otp_type!', 'respData' => []], 200);
            }
        }
    }


    public function verifyLoginOTP(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'otp_type' => 'required|in:email,phone',
            'otp' => 'required|size:4',
            'email' => 'required_if:otp_type,email|email|unique:user,email',
            'phone' => ['required_if:otp_type,phone', 'size:10'],
            'login_device' => 'required',
            'platform' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $user = User::where('email', $request->email)
                ->orWhere('phone',  $request->phone)
                ->first();
            if (!$user) {
                return response()->json(['status' => 0, 'message' => 'User not found!', 'respData' => []], 200);
            }

            if ($request->otp_type == 'email') {
                // $userEmail = DB::table('otp_verification')->where('email', $request->email)->first();

                // if (isset($userEmail) && $userEmail->id != '') {
                //update
                // DB::table('otp_verification')->where('id', $userEmail->id)->update(
                //     ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                // );
                // } else {
                //insert
                //     DB::table('otp_verification')->insert(
                //         ['email' => $request->email, 'email_otp' => $otp, 'dtime' => date('Y-m-d H:i:s')]
                //     );
                // }

                // $data = request()->all();
                // Mail::to(request()->email, request()->name)->send(new EmailVerify($data));
                // return response()->json(['status' => 1, 'message' => 'OTP sent successfully!', 'respData' => ['otp' => $otp]], 200);
            } else if ($request->otp_type == 'phone') {

                if ($request->otp == $user->login_otp) {
                    //update
                    $user->login_otp_verified = 1;
                    $user->token = bin2hex(openssl_random_pseudo_bytes(128));
                    $user->login_device = request()->login_device;
                    $user->platform = request()->platform;

                    if ($user->is_first_login == 0) {
                        $user->is_first_login = 1;
                    }

                    $user->save();

                    $user->image_url = ($user->image != '') ? url('storage/users/' . $user->image) : '';

                    return response()->json(['status' => 1, 'message' => 'OTP verified successfully!', 'respData' => $user], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => 'OTP not verified!', 'respData' => []], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Wrong otp_type!', 'respData' => []], 200);
            }
        }
    }

    public function registerUser(Request $request)
    {
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:user,email',
            // 'password' => 'required|min:6',
            'phone' => ['required', 'size:10', Rule::unique('user')->ignore(request()->id)]
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $userPhone = DB::table('otp_verification')->where('phone', $request->phone)->first();
            $userEmail = DB::table('otp_verification')->where('email', $request->email)->first();

            if (isset($userPhone) && $userPhone->phone_verified == 1) {
                $user_phone = 1;
            } else {
                $user_phone = 0;
            }

            if (isset($userEmail) && $userEmail->email_verified == 1) {
                $user_email = 1;
            } else {
                $user_email = 0;
            }

            if ($user_phone == 0 || $user_email == 0) {
                return response()->json(['status' => 0, 'message' => 'Email / Phone not verified!', 'respData' => []], 200);
            }

            // request()->merge(['password' => bcrypt(request('password'))]);
            request()->merge(['chash' => bin2hex(openssl_random_pseudo_bytes(128))]);
            request()->merge(['active' => '0']);
            request()->merge(['referral_code' => $this->genCode()]);
            request()->merge(['token' => bin2hex(openssl_random_pseudo_bytes(128))]);
            $user = User::create(request()->all());

            $data = request()->all();
            // Mail::to(request()->email, request()->name)->send(new EmailVerify($data));

            $userData = User::where('email', $request->email)
                ->orWhere('id',  $user->id)
                ->first();
            $userData->image_url = ($user->image != '') ? url('storage/users/' . $user->image) : '';

            return response()->json(['status' => 1, 'message' => 'Successfully registered!', 'respData' => $userData], 200);
        }
    }


    public function loginUser(Request $request)
    {

        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['password' => Crypt::decryptString(request()->password)]);
        // request()->merge(['login_device' => Crypt::decryptString(request()->login_device)]);
        // request()->merge(['platform' => Crypt::decryptString(request()->platform)]);

        // validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:user,email',
            'password' => 'required|min:6',
            'login_device' => 'required',
            'platform' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        } else {
            $user = User::where('email', request()->email)->first();
            if ($user->blocked == 1) return json_encode(array("error" => "Sorry! Please try again later."));
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
                    if ($user->step_data != "") {
                        $user_steps = json_decode($user->step_data, true);
                        $total = 0;
                        foreach ($user_steps as $key => $value) {
                            $total = $total + intval($value);
                        }
                        $user->total_steps = $total;
                        $user->save();


                        if (WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->count() > 0) {
                            $near_data = WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->first()->threshold;
                        } else {
                            $near_data = WalkLevel::where("threshold", "<", $total)->orderby('id', 'ASC')->first()->threshold;
                        }

                        $walk_offer = WalkLevel::where('threshold', $near_data)->orwhere('threshold', '<', $near_data);
                        $id = $walk_offer->pluck('id')->toArray();
                        // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                        $walk_offer = WalkOffer::where('active', '1')->orderby('threshold', 'asc')->get()->toArray();
                        foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                    }

                    $redeem_offer = UserWalkOffer::where("user_id", $user->id)->get()->toArray();
                    $message = array("token" => Crypt::encryptString(json_encode($user->toArray()) . json_encode(WalkLevel::all()->toArray()) . json_encode($redeem_offer) . json_encode($walk_offer)));

                    return response()->json(['status' => 1, 'message' => 'Successfully logged in!', 'respData' => $message], 200);
                } else {
                    $message = array("password" => "The password is incorrect.");
                    return response()->json(['status' => 0, 'message' => 'Not logged in!', 'respData' => $message], 200);
                }
            } else {
                $message = array("error" => "Check your email inbox and verify your email address!");
                return response()->json(['status' => 0, 'message' => 'Not logged in!', 'respData' => $message], 200);
            }
        }
    }

    public function logoutUser(Request $request)
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['id' => Crypt::decryptString(request()->id)]);

        // validation
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()), 400);
        } else {
            $user = User::where([['token', request()->token], ['id', request()->id]]);
            if ($user->count()) {
                $user = $user->first();
                $user->login_device = "";
                $user->platform = "";
                $user->token = "";
                $user->chash = "";
                $user->fhash = "";
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                if ($user) {
                    return response()->json(['status' => 1, 'message' => 'Logged out', 'respData' => $user], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => 'User not found', 'respData' => []], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'User not found', 'respData' => []], 200);
            }
        }
    }

    public function getLoggedinUser(Request $request)
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['id' => Crypt::decryptString(request()->id)]);

        // validation
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode(array("error" => "Invalid token."));
        } else {
            $user = User::where([['token', request()->token], ['id', request()->id]]);
            if ($user->count()) {

                User::where([['email', $user->first()->email], ['id', '<>', request()->id]])->delete();

                $walk_offer = array();
                if ($user->first()->step_data != "") {
                    $user_steps = json_decode($user->first()->step_data, true);
                    $total = 0;
                    foreach ($user_steps as $key => $value) {
                        $total = $total + intval($value);
                    }
                    $user->first()->total_steps = $total;
                    $user->first()->save();

                    $near_data = WalkLevel::where("threshold", ">", $total)->orderby('id', 'ASC')->first()->threshold;
                    $walk_offer = WalkLevel::where('threshold', $near_data)->orwhere('threshold', '<', $near_data);
                    $id = $walk_offer->pluck('id')->toArray();
                    $walk_offer = WalkOffer::where('active', '1')->orderby('threshold', 'asc')->get()->toArray();
                    // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                    foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                }

                $redeem_offer = UserWalkOffer::where("user_id", $user->first()->id)->get()->toArray();
                $message = array("success" => Crypt::encryptString(json_encode($user->first()->toArray()) . json_encode(WalkLevel::all()->toArray()) . json_encode($redeem_offer) . json_encode($walk_offer)));

                if ($message) {
                    return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $message], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
                }
            } else echo json_encode(array("error" => "Invalid token."));
        }
    }

    public function userProfile(Request $request)
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['id' => Crypt::decryptString(request()->id)]);

        // validation
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode(array("error" => "Invalid token."));
        } else {
            // $user = User::where('id', request()->id)->first();
            $user = User::where([['token', request()->token], ['id', request()->id]])->first();

            if ($user) {
                return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $user], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Invalid token. Details not found', 'respData' => []], 200);
            }
        }
    }


    public function resetPassword(Request $request)
    {
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);

        // validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        } else {
            $user = User::where('email', request()->email);
            if ($user->count()) {
                $user = $user->first();
                $user->fhash = rand(10000, 99999);
                $user->save();

                if ($user->phone) {

                    $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737258906094&mobile=" . $user->phone . "&message=" . urlencode($user->fhash . " is your OTP for changing password. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));
                }

                Mail::to($user->email, $user->name)->send(new ResetPassword($user));

                return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $user], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Email address is not registered with us!', 'respData' => []], 200);
            }
        }
    }

    public function feedback(Request $request)
    {
        // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['feedback' => Crypt::decryptString(request()->feedback)]);

        // validation
        $validator = Validator::make($request->all(), [
            'feedback' => 'required|max:200',
            'user_id' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation error!', 'respData' => $validator->errors()], 400);
        } else {
            $user = User::where([['id', request()->user_id], ['token', request()->token]]);
            if ($user->count()) {
                Feedback::create(request()->all());
                return response()->json(['status' => 1, 'message' => 'Feedback Added!', 'respData' => []], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'User not found!', 'respData' => []], 200);
            }
        }
    }

    public function savefeedback(Request $request)
    {
        if (request()->user_id) {
            // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
            // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        }

        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['email' => Crypt::decryptString(request()->email)]);
        // request()->merge(['mobile' => Crypt::decryptString(request()->mobile)]);
        // request()->merge(['for' => Crypt::decryptString(request()->for)]);
        // request()->merge(['feedback' => Crypt::decryptString(request()->feedback)]);
        // request()->merge(['type' => Crypt::decryptString(request()->type)]);
        // request()->merge(['store_id' => Crypt::decryptString(request()->store_id)]);
        // request()->merge(['reason' => Crypt::decryptString(request()->reason)]);
        // request()->merge(['floor' => Crypt::decryptString(request()->floor)]);

        // validation
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'for' => 'required',
            'store_id' => 'required_if:type,Grievance',
            'reason' => 'required',
            'feedback' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation error!', 'respData' => $validator->errors()], 400);
        } else {
            if (request()->user_id) {
                $user = User::where([['id', request()->user_id], ['token', request()->token]]);
                if ($user->count() == 0) {
                    return response()->json(['status' => 0, 'message' => 'Something went wrong!', 'respData' => []], 200);
                }
            }
            if (request()->type == "Suggestion") {
                request()->merge(['reason' => implode(", ", json_decode(request()->reason, true))]);
            }

            // if (request()->submit) {
            Feedback::create(request()->all());
            return response()->json(['status' => 1, 'message' => 'Thank you for submitting your feedback.', 'respData' => []], 200);
            // } else {
            // return response()->json(['status' => 0, 'message' => 'User not found!', 'respData' => []], 200);
            // }
        }
    }

    public function updateUserProfile(Request $request)
    {
        // request()->merge(['id' => Crypt::decryptString(request()->id)]);
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['name' => Crypt::decryptString(request()->name)]);
        // request()->merge(['phone' => Crypt::decryptString(request()->phone)]);
        // request()->merge(['interest' => Crypt::decryptString(request()->interest)]);

        // validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'token' => 'required',
            'name' => 'required',
            // 'interest' => 'required',
            'phone' => ['required', 'size:10', Rule::unique('user')->ignore(request()->id)]
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()), 400);
        } else {
            $user = User::where([['id', request()->id], ['token', request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $user->name = request()->name;
                $user->interest = request()->interest; //Beverages,Cafe,Desserts,Italian,Japanese,North Indian,Sushi
                $user->phone = request()->phone;
                $user->save();
                return response()->json(['status' => 1, 'message' => 'success', 'respData' => $user], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'User not found', 'respData' => []], 200);
            }
        }
    }

    public function updateUserImage(Request $request)
    {
        // request()->merge(['id' => Crypt::decryptString(request()->id)]);
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['image' => Crypt::decryptString(request()->image)]);

        // validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'token' => 'required',
            'type' => 'required:in:file,base64',
            'image_base64' => 'required_if:type,base64',
            'image' => 'required_if:type,file'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()), 400);
        } else {
            $user = User::where([['id', request()->id], ['token', request()->token]]);
            if ($user->count()) {
                $user = $user->first();

                if (request()->type == 'file') {
                    if ($user->image != "") {
                        $old_file = Storage::disk('public')->path('users/' . $user->image);
                        if (is_file($old_file)) Storage::disk('public')->delete('users/' . $user->image);
                    }

                    $time = time();
                    Storage::disk('public')->put('users/' . $user->id . '_' . $time . '.jpg', \Image::make(request()->image)->encode('jpg')->__toString(), "public");
                    $user->image = $user->id . '_' . $time . '.jpg';
                    $user->save();
                } else {
                    //base64
                    if ($user->image != "") {
                        $old_file = Storage::disk('public')->path('users/' . $user->image);
                        if (is_file($old_file)) Storage::disk('public')->delete('users/' . $user->image);
                    }

                    $time = time();
                    $image_extension = '.jpg';
                    $image = base64_decode(request()->image_base64);
                    // preg_match("/data:image\/(.*?);/", $image, $image_extension);
                    // $image = preg_replace('/data:image\/(.*?);base64,/', '', $image);
                    // $image = str_replace(' ', '+', $image);
                    Storage::disk('public')->put('users/' . $user->id . '_' . $time . '.jpg', \Image::make($image)->encode('jpg')->__toString(), "public");
                    $user->image = $user->id . '_' . $time . $image_extension;
                    $user->save();
                }


                $user = User::where([['id', $user->id]])->first();

                $user->image_url = ($user->image != '') ? url('storage/users/' . $user->image) : '';


                return response()->json(['status' => 1, 'message' => 'success', 'respData' => $user], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'User not found', 'respData' => []], 200);
            }
        }
    }

    public function savePass(Request $request)
    {
        request()->merge(['email' => Crypt::decryptString(request()->email)]);
        request()->merge(['password' => Crypt::decryptString(request()->password)]);

        // validation
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()), 400);
        } else {
            $user = User::where([['email', request()->email], ['fhash', '<>', '']]);
            if ($user->count()) {
                $user = $user->first();
                $user->password = bcrypt(request('password'));
                $user->fhash = "";
                $user->save();
                echo json_encode(array("success" => "done"));
            } else echo json_encode(array("error" => "Email address is not registered with us!"));
        }
    }

    public function saveArticle(Request $request)
    {
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['blog_id' => Crypt::decryptString(request()->blog_id)]);

        // validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'token' => 'required',
            'blog_id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        } else {
            $user = User::where([['id', request()->user_id], ['token', request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $bookmark = json_decode($user->bookmark, true);
                if ($bookmark) {
                    if (in_array(request()->blog_id, $bookmark)) {
                        unset($bookmark[array_search(request()->blog_id, $bookmark)]);
                    } else {
                        array_push($bookmark, request()->blog_id);
                        $bookmark = array_unique($bookmark);
                    }
                } else $bookmark = array(request()->blog_id);

                $user->bookmark = json_encode($bookmark);
                $user->save();
                echo json_encode(array("success" => Crypt::encryptString(json_encode($bookmark))));
            } else echo json_encode(array("error" => "Something went wrong!"));
        }
    }

    public function rateStore(Request $request)
    {
        // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['store_id' => Crypt::decryptString(request()->store_id)]);
        // request()->merge(['rate' => Crypt::decryptString(request()->rate)]);
        // request()->merge(['message' => Crypt::decryptString(request()->review)]);

        // validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'rate' => 'required',
            'token' => 'required',
            'store_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation error!', 'respData' => $validator->errors()], 400);
        } else {
            $user = User::where([['id', request()->user_id], ['token', request()->token]]);
            $store = Store::where([['id', request()->store_id], ['active', '1']]);
            if ($user->count() && $store->count()) {
                StoreRating::create($request->all());

                return response()->json(['status' => 1, 'message' => 'Rating added!', 'respData' => []], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'User not found!', 'respData' => []], 200);
            }
        }
    }

    public function getSavedBlogs(Request $request)
    {
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);

        // validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode($validator->errors());
        } else {
            $user = User::where([['id', request()->user_id], ['token', request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $bookmark = json_decode($user->bookmark, true);
                if ($bookmark) {
                    $data = Blog::select('sq_image', 'id', "post_time", "title", "content", "category_id")->where('active', '1');
                    $data = $data->whereIn('id', $bookmark)->orderby("post_time", "DESC")->get()->toArray();

                    foreach ($data as $key => $value) {
                        $data[$key]['image'] = $data[$key]['sq_image'];
                        $data[$key]['post_time'] = date("dS M, Y", strtotime($data[$key]['post_time']));
                        $data[$key]['content'] = str_limit(strip_tags($data[$key]['content']), 20);
                        $data[$key]['category_id'] = BlogCategory::find($value['category_id'])->title;
                    }
                    echo Crypt::encryptString(json_encode($data));
                } else echo json_encode(array("error" => "There is no saved article available!"));
            } else echo json_encode(array("error" => "Something went wrong!"));
        }
    }

    public function saveSteps(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['step_data' => Crypt::decryptString(request()->step_data)]);
        request()->merge(['near_data' => Crypt::decryptString(request()->near_data)]);

        // validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'token' => 'required',
            'near_data' => 'required',
            'step_data' => 'required'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()), 400);
        } else {
            $user = User::where([['id', request()->id], ['token', request()->token]]);
            if ($user->count()) {
                $user = $user->first();
                $user->step_data = request()->step_data;
                $user->save();

                $walk_offer = WalkLevel::where('threshold', request()->near_data)->orwhere('threshold', '<', request()->near_data);
                if ($walk_offer->count() > 0) {
                    $id = $walk_offer->pluck('id')->toArray();
                    $walk_offer = WalkOffer::where('active', '1')->orderby('threshold', 'asc')->get()->toArray();
                    // $walk_offer = WalkOffer::where('active','1')->whereIn('threshold',$id)->orderby('threshold','asc')->get()->toArray();
                    foreach ($walk_offer as $key => $value) $walk_offer[$key]['threshold'] = WalkLevel::find($value['threshold'])->threshold;
                    echo json_encode(array("success" => Crypt::encryptString(json_encode($walk_offer))));
                } else echo json_encode(array("success" => Crypt::encryptString(json_encode(array()))));
            } else return response(json_encode(array("error" => "Something went wrong!")), 400);
        }
    }

    public function redeemOffer(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['offer_id' => Crypt::decryptString(request()->offer_id)]);
        request()->merge(['total_step' => Crypt::decryptString(request()->total_step)]);

        // validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'token' => 'required',
            'total_step' => 'required',
            'offer_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()), 400);
        } else {
            $user = User::where([['id', request()->id], ['token', request()->token]]);
            if ($user->count()) {
                $user = $user->first();

                $walk_offer = WalkLevel::where('threshold', request()->total_step)->orwhere('threshold', '<', request()->total_step);
                if ($walk_offer->count() > 0) {

                    $walk_offer = WalkOffer::where([['active', '1'], ['id', request()->offer_id]])->whereIn('threshold', $walk_offer->pluck('id'))->orderby('threshold', 'asc');
                    if ($walk_offer->count() == 1) {
                        $walk_offer = $walk_offer->first();
                        if (UserWalkOffer::where([["user_id", request()->id], ['offer_id', request()->offer_id]])->count() == 0) {
                            $arr = array(
                                "user_id" => request()->id,
                                "store_id" => $walk_offer->store_id,
                                "offer_id" => $walk_offer->id,
                                "offer" => $walk_offer->offer,
                                "image" => $walk_offer->image,
                                "threshold" => WalkLevel::find($walk_offer->threshold)->type,
                                "code" => $walk_offer->code,
                                "redeem_within" => $walk_offer->redeem_within,
                                "redeem_within" => $walk_offer->redeem_within,
                                "redeem_date" => date('Y-m-d H:i:s'),
                            );
                            $data = UserWalkOffer::create($arr);

                            // Mail::to($data->user->email, $data->user->name)->send(new OfferClaimed($data));
                        }
                        $redeem_offer = UserWalkOffer::where("user_id", request()->id)->get()->toArray();
                        echo json_encode(array("success" => Crypt::encryptString(json_encode($redeem_offer))));
                    } else return response(json_encode(array("error" => "Something went wrong!")), 400);
                } else return response(json_encode(array("error" => "Something went wrong!")), 400);
            } else return response(json_encode(array("error" => "Something went wrong!")), 400);
        }
    }

    public function parkingApi()
    {
        print_r(request()->all());
    }

    public function phoneVerifyOtp(Request $request)
    {
        request()->merge(['id' => Crypt::decryptString(request()->id)]);
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['phone' => Crypt::decryptString(request()->phone)]);

        // validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'token' => 'required',
            'phone' => ['required', 'size:10', Rule::unique('user')->ignore(request()->id)]
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        } else {
            $user = User::where([['id', request()->id], ['token', request()->token]]);
            if ($user->count()) {
                $OTP = rand(10000, 99999);
                $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737270600501&mobile=" . request()->phone . "&message=" . urlencode($OTP . " is your OTP for phone number verification. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));

                if (substr(trim($response), 0, 14) == 'SUBMIT_SUCCESS') {
                    $user = $user->first();
                    $user->fhash = $OTP;
                    $user->save();
                    echo json_encode(array("success" => Crypt::encryptString($OTP)));
                } else {
                    response(json_encode(array("error" => $response[0]['msg'])));
                }
            } else return response(json_encode(array("error" => "Something went wrong!")));
        }
    }


    public function getMallMap()
    {
        $data = Map::where('active', '1')->orderby('id')->get()->toArray();

        if ($data) {
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $data[$key]['image_actual'] = url('storage/map/actual/' . $value['image']);
                }
            }

            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }


    public function getQreviews($auth_id = false, $tag_id = false)
    {
        $data = Qauthor::select('id', 'title')->where('active', '1')->orderby("title")->get()->toArray();
        echo json_encode($data);
        $data = ReviewTag::select('id', 'title')->where('active', '1')->orderby("title")->get()->toArray();
        echo json_encode($data);

        $data = Qreview::select('sq_image', 'id', "post_time", "title", "content", "author")->where('active', '1');

        if ($auth_id != "-0") $auth_id = explode('-', substr($auth_id, 1));
        if ($auth_id != "-0") {
            $data = $data->where(function ($query) use ($auth_id) {
                $query->where('author', 'like', $auth_id[0] . ',%');
                foreach ($auth_id as $key => $value) {
                    $query->orwhere('author', 'like', $value . ',%')
                        ->orWhere('author', 'like', '%,' . $value)
                        ->orWhere('author', 'like', '%,' . $value . ',%')
                        ->orWhere('author', '=', $value);
                }
            });
        }

        if ($tag_id != "-0") $tag_id = explode('-', substr($tag_id, 1));
        if ($tag_id != "-0") {
            $data = $data->where(function ($query) use ($tag_id) {
                $query->where('tags', 'like', $tag_id[0] . ',%');
                foreach ($tag_id as $key => $value) {
                    $query->orwhere('tags', 'like', $value . ',%')
                        ->orWhere('tags', 'like', '%,' . $value)
                        ->orWhere('tags', 'like', '%,' . $value . ',%')
                        ->orWhere('tags', '=', $value);
                }
            });
        }

        $data = $data->orderby("post_time", "DESC")->get()->toArray();

        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['post_time'] = date("dS M, Y", strtotime($data[$key]['post_time']));
            $data[$key]['content'] = str_limit(strip_tags($data[$key]['content']), 20);
            $data[$key]['author'] = "by " . implode(', ', Qauthor::where('active', '1')->whereIn('id', explode(',', $value['author']))->pluck('title')->toArray());
        }
        echo json_encode($data);
    }

    public function getQreview($id)
    {
        $data = Qreview::where([['active', '1'], ['id', $id]])->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = $data[$key]['sq_image'];
            $data[$key]['author'] = "by " . implode(', ', Qauthor::where('active', '1')->whereIn('id', explode(',', $value['author']))->pluck('title')->toArray());
            $data[$key]['tags'] = "#" . implode(', #', ReviewTag::where('active', '1')->whereIn('id', explode(',', $value['tags']))->pluck('title')->toArray());
            $data[$key]['post_time'] = date("dS M, Y", strtotime($data[$key]['post_time']));
        }
        echo json_encode($data);
    }

    public function getAppDealStores($type)
    {
        $data = StoreAppDeal::select('store_id')->where('active', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d 23:59:59'))->get()->toArray();
        $data = array_column($data, 'store_id');
        $data = Store::select('id', 'name', 'type_id', 'category_id', 'cuisine', 'logo')->whereIn('id', $data)->where('s_type', $type)->orderby("name")->get()->toArray();


        foreach ($data as $key => $value) {
            $data[$key]['type_id'] = StoreType::find($value['type_id'])->title;

            $value['category_id'] = explode(',', $value['category_id']);

            if ($value['category_id'][0] != '')
                foreach ($value['category_id'] as $k => $v) {
                    $value['category_id'][$k] = StoreCategory::find($v)->title;
                }
            $data[$key]['category_id'] = implode(', ', $value['category_id']);

            $value['cuisine'] = explode(',', $value['cuisine']);

            if ($value['cuisine'][0] != '')
                foreach ($value['cuisine'] as $k => $v) {
                    $value['cuisine'][$k] = DineCuisine::find($v)->title;
                }
            $data[$key]['cuisine'] = implode(', ', $value['cuisine']);
            $data[$key]['image_actual'] = url('storage/store/actual/' . $value['logo']);

            $rate = StoreRating::where('store_id', $value['id'])->avg('rate');
            if ($rate != null) $data[$key]['rate'] = intval($rate);
            else $data[$key]['rate'] = 0;
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getAppDeals($id = 0)
    {

        if ($id > 0) {
            $where = [['active', 1], ['store_id', $id]];
        } else {
            $where = [['active', 1]];
        }

        $data = StoreAppDeal::select('title', 'id', 'end_date as until', 'store_id')->where($where)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d 23:59:59'))->orderBy('end_date', 'asc')->get();

        // print_r($data);die;

        foreach ($data as $key => $value) {
            $value->storename = Store::find($value->store_id)->name;
        }

        if ($data) {
            return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
        }
    }

    public function getAppDeal()
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        // request()->merge(['offer_id' => Crypt::decryptString(request()->offer_id)]);

        $user = User::where([['token', request()->token], ['id', request()->user_id]]);
        if ($user->count() == 0) return response()->json(['status' => 0, 'message' => 'Something went wrong!', 'respData' => []], 400);

        $data = StoreAppDeal::select('*', 'end_date as until')->where([['active', 1], ['id', request('offer_id')]])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d 23:59:59'));
        if ($data->count() == 1) {
            $data = $data->first();
            $data->store_type = Store::find($data->store_id)->s_type;
            $data->storename = Store::find($data->store_id)->name;
            $data->storelogo = Store::find($data->store_id)->logo;
            $data->image_actual = url('storage/store/actual/' . $data->storelogo);

            $activeday = $data->activeday->where('day', date("l"));
            if ($activeday->count()) {
                $activeday = $activeday->first();
                if (strtotime(date('Y-m-d ') . $activeday->fromtime) <= time() and strtotime(date('Y-m-d ') . $activeday->totime) >= time()) {
                    $data->available = 1;
                } else $data->available = 0;
            } else $data->available = 0;

            $userCode = StoreAppDealClaimed::where([['store_id', $data->store_id], ['offer_id', request('offer_id')], ['user_id', request('user_id')], ['claimed', '0']]);
            if ($userCode->count()) {
                $data->code = $userCode->first()->code;
            }

            if ($data) {
                return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Something went wrong!', 'respData' => []], 200);
        }
    }

    public function genAppDealCode()
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        // request()->merge(['offer_id' => Crypt::decryptString(request()->offer_id)]);

        $user = User::where([['token', request()->token], ['id', request()->user_id]]);
        if ($user->count() == 0) return response()->json(['status' => 0, 'message' => 'Something went wrong!', 'respData' => []], 400);

        $data = StoreAppDeal::select('*', 'end_date as until')->where([['active', 1], ['id', request('offer_id')]])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d 23:59:59'));
        if ($data->count() == 1) {
            $data = $data->first();
            $data->store_type = Store::find($data->store_id)->s_type;
            $data->storename = Store::find($data->store_id)->name;
            $data->storelogo = Store::find($data->store_id)->logo;
            $data->image_actual = url('storage/store/actual/' . $data->storelogo);

            $activeday = $data->activeday->where('day', date("l"));
            if ($activeday->count()) {
                $activeday = $activeday->first();
                if (strtotime(date('Y-m-d ') . $activeday->fromtime) <= time() and strtotime(date('Y-m-d ') . $activeday->totime) >= time()) {
                    $data->available = 1;
                } else $data->available = 0;
            } else $data->available = 0;

            $userCode = StoreAppDealClaimed::where([['store_id', $data->store_id], ['offer_id', request('offer_id')], ['user_id', request('user_id')], ['claimed', '0']]);
            if ($userCode->count()) {
                $data->code = $userCode->first()->code;
            } else {
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

            if ($data) {
                return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
            } else {
                return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Something went wrong!', 'respData' => []], 200);
        }
    }

    private function genDealCode()
    {
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = substr(str_shuffle($char), 1, 10); //this can handle 3628800 unique code, increase the last number to handle more code
        if (StoreAppDealClaimed::where('code', $code)->count() == 0) return $code;
        else return $this->genDealCode();
    }



    public function getDineAndWin(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation error!', 'respData' => $validator->errors()], 400);
        } else {
            $user = User::where([['id', request()->user_id], ['token', request()->token]]);
            if ($user->count()) {
                $data = Map::where('active', '1')->orderby('id')->get()->toArray();

                if ($data) {
                    // if (!empty($data)) {
                    //     foreach ($data as $key => $value) {
                    //         $data[$key]['image_actual'] = url('storage/map/actual/' . $value['image']);
                    //     }
                    // }

                    $app_settings = SiteSettings::select('dine_win_tnc')->where('id', '1')->first();
                    $contestData = ContestParticipate::where([['user_id', request()->user_id]])->first();
                    $unique_code = (!empty($contestData)) ? $contestData->unique_code : '';
                    $thresholdDetails = ContestParticipantTransaction::where('unique_code', $unique_code)->max('percentage');

                    // print_r($app_settings->dine_win_tnc);die;

                    $data = array(
                        'terms_and_conditions' => (!empty($app_settings)) ? $app_settings->dine_win_tnc : '<p>NA</p>',
                        'start_date' => (!empty($contestData)) ? $contestData->participation_date : '',
                        'end_date' => (!empty($contestData)) ? $contestData->end_date : '',
                        'unique_code' => $unique_code,
                        'current_percentage' => (!empty($thresholdDetails)) ? $thresholdDetails : 0,
                        'user_details' => $user->first()
                    );

                    return response()->json(['status' => 1, 'message' => 'Details found', 'respData' => $data], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Details not found', 'respData' => []], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'User not found!', 'respData' => []], 200);
            }
        }
    }

    public function getContestDetails()
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        // request()->merge(['contest_id' => Crypt::decryptString(request()->contest_id)]);
        // request()->merge(['type' => Crypt::decryptString(request()->type)]);

        // validation
        $validator = Validator::make(request()->all(), [
            'token' => 'required',
            'user_id' => 'required',
            'contest_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $user = User::where([['token', request()->token], ['id', request()->user_id]]);
            if ($user->count()) {
                $contest = Contest::where([['id', request()->contest_id], ['active', '1'], ['form_date', '<=', date('Y-m-d 00:00:00')], ['to_date', '>=', date('Y-m-d 23:59:59')]]);
                if ($contest->count() == 0) {
                    $message = array("error" => "No contest found!");
                    return Crypt::encryptString(json_encode($message));
                } else {
                    $contest = $contest->first();
                    $contest->connectedDine = $contest->dines->pluck('dineDetails');
                    $contest->dine_count = $contest->dines->count();
                    $contest->connectedFC = $contest->fc_outlets->pluck('dineDetails');
                    $contest->fc_count = $contest->fc_outlets->count();

                    if (request('type') == '0') {
                        if ($contest->fc_count == 0) request()->merge(['type' => 1]);
                    } elseif (request('type') == '1') {
                        if ($contest->dine_count == 0) request()->merge(['type' => 0]);
                    }

                    $contest->userCount = $contest->participants->where('user_id', request()->user_id)->count();
                    if ($contest->userCount <> 0) {

                        $sdate = date("Y-m-01");
                        $edate = date("Y-m-t");
                        $contest->userTransactionAll = $contest->participants
                            ->where('user_id', request()->user_id)
                            ->first()
                            ->transactions
                            ->where('type', request()->type)
                            ->whereBetween('trans_date', [$sdate, $edate])
                            ->all();
                        if (request('timestamp')) {
                            $sdate = date("Y-m-01", intval(Crypt::decryptString(request()->timestamp)));
                            $edate = date("Y-m-t", intval(Crypt::decryptString(request()->timestamp)));
                            $contest->userTransactionAll = $contest->participants
                                ->where('user_id', request()->user_id)
                                ->first()
                                ->transactions
                                ->where('type', request()->type)
                                ->whereBetween('trans_date', [$sdate, $edate])
                                ->all();
                            if (request('week')) {
                                $edate = $this->LastDayofWeek(Crypt::decryptString(request()->week), intval(Crypt::decryptString(request()->timestamp)));
                            }
                        }

                        $contest->userCode = $contest->participants->where('user_id', request()->user_id)->first()->unique_code;
                        $contest->userJoinDate = $contest->participants->where('user_id', request()->user_id)->first()->participation_date;

                        $contest->userTransaction = $contest->participants
                            ->where('user_id', request()->user_id)
                            ->first()
                            ->transactions
                            ->where('type', request()->type)
                            ->whereBetween('trans_date', [$sdate, $edate])
                            ->all();
                        foreach ($contest->userTransaction as $key => $value) {
                            $value->dineDetails;
                        }

                        $contest->userTransaction = array_values($contest->userTransaction);
                        $contest->userTransactionAll = array_values($contest->userTransactionAll);

                        $contest->thresholdDetails = $contest->thresholdDetails->where('type', request()->type)->pluck("percentage");
                    }

                    return response()->json(['status' => 1, 'message' => 'Success!', 'respData' => $contest->toArray()], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Invalid token!', 'respData' => []], 200);
            }
        }
    }

    public function joinContest()
    {
        // request()->merge(['token' => Crypt::decryptString(request()->token)]);
        // request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        // request()->merge(['contest_id' => Crypt::decryptString(request()->contest_id)]);
        // request()->merge(['type' => Crypt::decryptString(request()->type)]);

        // validation
        $validator = Validator::make(request()->all(), [
            'token' => 'required',
            'user_id' => 'required',
            'contest_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Validation failed!', 'respData' => $validator->errors()], 200);
        } else {
            $user = User::where([['token', request()->token], ['id', request()->user_id]]);
            if ($user->count()) {
                $contest = Contest::where([['id', request()->contest_id], ['active', '1'], ['form_date', '<=', date('Y-m-d 00:00:00')], ['to_date', '>=', date('Y-m-d 23:59:59')]]);
                if ($contest->count() == 0) {
                    $message = array("error" => "No contest found!");
                    return response()->json(['status' => 0, 'message' => 'No contest found!', 'respData' => $message], 200);
                } else {
                    if (ContestParticipate::where([['contest_id', request()->contest_id], ['user_id', request()->user_id]])->count() == 0) {
                        $addarr = array(
                            "user_id" => request()->user_id,
                            "contest_id" => request()->contest_id,
                            "unique_code" => $this->genCode(request()->contest_id),
                            "participation_date" => date('Y-m-d'),
                            "end_date" => date('Y-m-d', strtotime("+30 days")),
                        );
                        ContestParticipate::create($addarr);

                        $user = User::where([['token', request()->token], ['id', request()->user_id]])->first();
                        // print_r($user);die;
                        if ($user->is_first_login == 1) {
                            DB::table('user')->where('id', request()->user_id)->update(
                                ['is_first_login' => 2]
                            );
                        }
                    }

                    // request()->merge(['token' => Crypt::encryptString(request()->token)]);
                    // request()->merge(['user_id' => Crypt::encryptString(request()->user_id)]);
                    // request()->merge(['contest_id' => Crypt::encryptString(request()->contest_id)]);
                    // request()->merge(['type' => Crypt::encryptString(request()->type)]);
                    return response()->json(['status' => 1, 'message' => 'Data found!', 'respData' => $this->getContestDetails()], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Invalid token!', 'respData' => []], 200);
            }
        }
    }
}
