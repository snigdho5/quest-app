<?php

namespace App\Http\Controllers;

use App\Models\AdminModels\LoftBanner;
use App\Models\AdminModels\LoftDesigner;
use App\Models\AdminModels\AppBanner;
use App\Models\AdminModels\AppPush;
use App\Models\AdminModels\StoreDeal;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\StoreType;
use App\Models\AdminModels\DineCuisine;
use App\Models\AdminModels\StoreCategory;
use App\Models\AdminModels\StoreBanner;
use App\Models\AdminModels\Event;
use App\Models\AdminModels\EventGallery;
use App\Models\AdminModels\MoviePoster;
use App\Models\AdminModels\Blog;
use App\Models\AdminModels\BlogCategory;
use App\Models\AdminModels\CameraFrame;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
	public function __construct(){

    }

    public function verify($chash){
         $user = User::where('chash',$chash);
         if ($user->count()){
            $user=$user->first();
            $user->active = '1';
            $user->chash = "";
            $user->save();
            echo 'Account verified.';
         }else echo 'Link expired!';
    }

    public function loadStore()
    {
        $storeData = Store::where([['active','1'],['s_type','store'],['post_time','<=',date("Y-m-d H:i:s")]]);
        if(request()->query('search')){
            $storeData = $storeData->search(["name","description"],request()->query('search'));
        }
        if(request()->query('category') && request()->query('category')!='deals'){
            $storeData = $storeData->where(function ($query) {
                            $query->where('category_id', 'like', request()->query('category').',%')
                                  ->orWhere('category_id', 'like', '%,'.request()->query('category'))
                                  ->orWhere('category_id', 'like', '%,'.request()->query('category').',%')
                                  ->orWhere('category_id', '=', request()->query('category'));
                        });
        }elseif(request()->query('category') && request()->query('category')=='deals'){
            $stores = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->pluck('store_id')->toArray();

            $storeData = $storeData->whereIn('id', $stores);
        }
        if(request()->query('type') && request()->query('type') != "all"){
            $storeData = $storeData->where('type_id',request()->query('type'));
        }
        if(request()->query('floor') && request()->query('floor') != "all"){
            $storeData = $storeData->where('floor',request()->query('floor'));
        }

        $storeData = $storeData->orderby("name","asc")->offset(request()->post('count'))->limit(18)->get();

        foreach ($storeData as $key => $value):?>
        <div class="col-lg-4 col-md-6 col-6 mb-4">
            <a href="stores/<?=str_slug($value->name)?>" title="<?=$value->name?>">
                <div class="dealsbox">
                    <span class="dealbg" style="background-image: url(<?=asset('storage/store_banner/thumb/'.$value->banner->where('featured','1')->first()['image'])?>)">
                        <div class="whitecolor">
                            <img src="<?=asset('storage/store/actual/'.$value->logo)?>" class="img-fluid logobg" alt="<?=$value->name?>">
                        </div>
                        <?php if ($value->deals()->where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->count() > 0):?>
                        <div class="imagetext">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="45px" height="45px" viewBox="0 0 45 45" enable-background="new 0 0 45 45" xml:space="preserve">
                                <polygon fill="#FBAE2F" points="0,0.003 0,44.997 21.997,35.834 45,45 45,0 " />
                            </svg>
                            <span>DEALS</span>
                        </div>
                        <?php endif?>
                    </span>
                </div>
            </a>
        </div>
        <?php endforeach;
    }

    public function loadDine()
    {
        $storeData = Store::where([['active','1'],['s_type','dine'],['post_time','<=',date("Y-m-d H:i:s")]]);
        if(request()->query('search')){
            $storeData = $storeData->search(["name","description"],request()->query('search'));
        }
        if(request()->query('category') && request()->query('category')!='deals'){
            $storeData = $storeData->where(function ($query) {
                            $query->where('category_id', 'like', request()->query('category').',%')
                                  ->orWhere('category_id', 'like', '%,'.request()->query('category'))
                                  ->orWhere('category_id', 'like', '%,'.request()->query('category').',%')
                                  ->orWhere('category_id', '=', request()->query('category'));
                        });
        }elseif(request()->query('category') && request()->query('category')=='deals'){
            $stores = StoreDeal::where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->pluck('store_id')->toArray();

            $storeData = $storeData->whereIn('id', $stores);
        }
        if(request()->query('type') && request()->query('type') != "all"){
            $storeData = $storeData->where('type_id',request()->query('type'));
        }
        if(request()->query('floor') && request()->query('floor') != "all"){
            $storeData = $storeData->where('floor',request()->query('floor'));
        }

        $storeData = $storeData->orderby("name","asc")->offset(request()->post('count'))->limit(18)->get();

        foreach ($storeData as $key => $value):?>
        <div class="col-lg-4 col-md-6 col-6 mb-4">
            <a href="dines/<?=str_slug($value->name)?>" title="<?=$value->name?>">
                <div class="dealsbox">
                    <span class="dealbg" style="background-image: url(<?=asset('storage/store_banner/thumb/'.$value->banner->where('featured','1')->first()['image'])?>)">
                        <div class="whitecolor">
                            <img src="<?=asset('storage/store/actual/'.$value->logo)?>" class="img-fluid logobg" alt="<?=$value->name?>">
                        </div>
                        <?php if ($value->deals()->where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->count() > 0):?>
                        <div class="imagetext">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="45px" height="45px" viewBox="0 0 45 45" enable-background="new 0 0 45 45" xml:space="preserve">
                                <polygon fill="#FBAE2F" points="0,0.003 0,44.997 21.997,35.834 45,45 45,0 " />
                            </svg>
                            <span>DEALS</span>
                        </div>
                        <?php endif?>
                    </span>
                </div>
            </a>
        </div>
        <?php endforeach;
    }


    public function loadDeals()
    {
        $deals = StoreDeal::where([['active','1'],['image','!=','']])->where('post_time','<=',date("Y-m-d H:i:s"))->whereDate('end_date','>=', date('Y-m-d'));
        if(request()->type && request()->type != "all"){
            $stores = StoreType::find(request()->type)->stores()->where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])->pluck('id')->toArray();

            $deals = $deals->whereIn('store_id', $stores);
        }
        $deals = $deals->orderby("post_time","DESC")->offset(request()->post('count'))->limit(9)->get();

        foreach ($deals as $key => $value):?>
        <div class="col-lg-4 col-md-6 col-12 mb-4">
                <span class="border-bottom"></span>
                <a href="javascript:void(0)" onclick='showDeal("<?=asset('storage/store_deal/actual/'.$value->image)?>","<?=$value->store['name']?>","<?=$value->description?>","<?=$value->start_date->format('dS M, y')?> - <?=$value->end_date->format('dS M, y')?>")'>
                    <div class="card border-0">
                        <img src="<?=asset('storage/store_deal/thumb/'.$value->image)?>" class="card-img-top rounded-0" alt="..." style="border:thin solid rgba(0,0,0,0.1)">
                        <div class="d_cont pt-3">
                            <h6 class="mb-0 float-left"><?=$value->store['name']?></h6>
                            <h6 class="mb-0 float-right" style="color: #bb141c;"><?=$value->start_date->format('dS M, y')?> - <?=$value->end_date->format('dS M, y')?></h6>
                        </div>
                        <div class="card-body pl-0 p-0 pt-lg-1 pt-2">
                            <span class="card-title"><b><?=$value->description?></b></span><br>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach;
    }


    public function search($searchTerm)
    {
        $searchResult = [];
        $storeResult = Store::select("id","name")->where([['s_type','store'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                                    ->search(["name","description"],$searchTerm)
                                                    ->get()->toArray();
        foreach ($storeResult as $key => $value){
            $storeResult[$key]['link'] = "stores/".str_slug($value['name']);
            $storeResult[$key]['type'] = "Store";
        }

        $dineResult = Store::select("id","name")->where([['s_type','dine'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["name","description"],$searchTerm)
                                            ->get()->toArray();
        foreach ($dineResult as $key => $value){
            $dineResult[$key]['link'] = "dines/".str_slug($value['name']);
            $dineResult[$key]['type'] = "Dine";
        }

        $blogResult = Blog::select("id","title","slug")->where([['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["title","content"],$searchTerm)
                                            ->get()->toArray();
        foreach ($blogResult as $key => $value){
            $blogResult[$key]['link'] = "blogs/".$value['slug'];
            $blogResult[$key]['type'] = "Blog";
        }

        $questEventResult = Event::select("id","title","slug")->where([['type','quest'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["title","content"],$searchTerm)
                                            ->get()->toArray();
        foreach ($questEventResult as $key => $value){
            $questEventResult[$key]['link'] = "events/".$value['slug'];
            $questEventResult[$key]['type'] = "Quest Event";
        }

        $loftEventResult = Event::select("id","title","slug")->where([['type','loft'],['active','1'],['post_time','<=',date("Y-m-d H:i:s")]])
                                            ->search(["title","content"],$searchTerm)
                                            ->get()->toArray();
        foreach ($loftEventResult as $key => $value){
            $loftEventResult[$key]['link'] = "the-loft/events/".$value['slug'];
            $loftEventResult[$key]['type'] = "Loft Event";
        }

        $movieResult = MoviePoster::select("id","title","link")->where('active','1')
                                            ->search(["title"],$searchTerm)
                                            ->get()->toArray();
        foreach ($movieResult as $key => $value){
            $movieResult[$key]['type'] = "Movie";
        }

        $searchResult = array_merge(array_values($storeResult),array_values($dineResult),array_values($blogResult),array_values($questEventResult),array_values($loftEventResult),array_values($movieResult));
        echo json_encode($searchResult);
    }
}
