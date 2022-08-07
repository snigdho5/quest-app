<?php


// admin route
Route::prefix('admin')->name('admin::')->group(function(){
	Route::get('',function(){return redirect()->route('admin::login');});



	Route::get('login','AdminControllers\LoginController@show')->name('login');
	Route::post('login','AdminControllers\LoginController@create');
	Route::get('logout','AdminControllers\LoginController@destroy');

	Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

	Route::post('ajax/checkCmsSlug','AdminControllers\AjaxController@cmsSlug');
	Route::post('ajax/checkNewsSlug','AdminControllers\AjaxController@newsSlug');
	Route::post('ajax/checkEventSlug','AdminControllers\AjaxController@eventSlug');
	Route::post('ajax/checkGallerySlug','AdminControllers\AjaxController@gallerySlug');
	Route::post('ajax/checkBlogSlug','AdminControllers\AjaxController@blogSlug');
	Route::post('ajax/checkQreviewSlug','AdminControllers\AjaxController@qreviewSlug');
	Route::post('ajax/getAppBannerPageDetails','AdminControllers\AjaxController@getAppBannerPageDetails');
	

	Route::get('site_setting','AdminControllers\SiteController@index')->name('sitesettings');
	Route::post('site_setting','AdminControllers\SiteController@update');

	Route::get('dashboard','AdminControllers\DashboardController@index')->name('dashboard');

	Route::get('password','AdminControllers\PasswordController@index')->name('password');
	Route::post('password','AdminControllers\PasswordController@update');

	Route::get('app_banner','AdminControllers\AppBannerController@index')->name('appBanner');
	Route::post('app_banner','AdminControllers\AppBannerController@order');
	Route::get('app_banner/create','AdminControllers\AppBannerController@create');
	Route::post('app_banner/create','AdminControllers\AppBannerController@store');
	Route::get('app_banner/edit/{id}','AdminControllers\AppBannerController@edit')->where('id', '[0-9]+');
	Route::post('app_banner/edit/{id}','AdminControllers\AppBannerController@update')->where('id', '[0-9]+');
	Route::get('app_banner/delete/{id}','AdminControllers\AppBannerController@destroy')->where('id', '[0-9]+');
	Route::get('app_banner/status/{id}/{type}','AdminControllers\AppBannerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	
	Route::get('summer_banner','AdminControllers\SummerBannerController@index')->name('summerBanner');
	Route::post('summer_banner','AdminControllers\SummerBannerController@order');
	Route::get('summer_banner/create','AdminControllers\SummerBannerController@create');
	Route::post('summer_banner/create','AdminControllers\SummerBannerController@store');
	Route::get('summer_banner/edit/{id}','AdminControllers\SummerBannerController@edit')->where('id', '[0-9]+');
	Route::post('summer_banner/edit/{id}','AdminControllers\SummerBannerController@update')->where('id', '[0-9]+');
	Route::get('summer_banner/delete/{id}','AdminControllers\SummerBannerController@destroy')->where('id', '[0-9]+');
	Route::get('summer_banner/status/{id}/{type}','AdminControllers\SummerBannerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('banner','AdminControllers\BannerController@index')->name('banner');
	Route::post('banner','AdminControllers\BannerController@order');
	Route::get('banner/create','AdminControllers\BannerController@create');
	Route::post('banner/create','AdminControllers\BannerController@store');
	Route::get('banner/edit/{id}','AdminControllers\BannerController@edit')->where('id', '[0-9]+');
	Route::post('banner/edit/{id}','AdminControllers\BannerController@update')->where('id', '[0-9]+');
	Route::get('banner/delete/{id}','AdminControllers\BannerController@destroy')->where('id', '[0-9]+');
	Route::get('banner/status/{id}/{type}','AdminControllers\BannerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('loft_banner','AdminControllers\LoftBannerController@index')->name('loftBanner');
	Route::post('loft_banner','AdminControllers\LoftBannerController@order');
	Route::get('loft_banner/create','AdminControllers\LoftBannerController@create');
	Route::post('loft_banner/create','AdminControllers\LoftBannerController@store');
	Route::get('loft_banner/edit/{id}','AdminControllers\LoftBannerController@edit')->where('id', '[0-9]+');
	Route::post('loft_banner/edit/{id}','AdminControllers\LoftBannerController@update')->where('id', '[0-9]+');
	Route::get('loft_banner/delete/{id}','AdminControllers\LoftBannerController@destroy')->where('id', '[0-9]+');
	Route::get('loft_banner/status/{id}/{type}','AdminControllers\LoftBannerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('loft_designer','AdminControllers\LoftDesignerController@index')->name('loftDesigner');
	Route::get('loft_designer/create','AdminControllers\LoftDesignerController@create');
	Route::post('loft_designer/create','AdminControllers\LoftDesignerController@store');
	Route::get('loft_designer/edit/{id}','AdminControllers\LoftDesignerController@edit')->where('id', '[0-9]+');
	Route::post('loft_designer/edit/{id}','AdminControllers\LoftDesignerController@update')->where('id', '[0-9]+');
	Route::get('loft_designer/delete/{id}','AdminControllers\LoftDesignerController@destroy')->where('id', '[0-9]+');
	Route::get('loft_designer/status/{id}/{type}','AdminControllers\LoftDesignerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('loft_designer/{designer_id}/events','AdminControllers\LoftDesignerEventController@index')->where('designer_id', '[0-9]+')->name('loftDesignerEvent');
	Route::get('loft_designer/{designer_id}/events/create','AdminControllers\LoftDesignerEventController@create')->where('designer_id', '[0-9]+');
	Route::post('loft_designer/{designer_id}/events/create','AdminControllers\LoftDesignerEventController@store')->where('designer_id', '[0-9]+');
	Route::get('loft_designer/{designer_id}/events/edit/{id}','AdminControllers\LoftDesignerEventController@edit')->where('id', '[0-9]+')->where('designer_id', '[0-9]+');
	Route::post('loft_designer/{designer_id}/events/edit/{id}','AdminControllers\LoftDesignerEventController@update')->where('id', '[0-9]+')->where('designer_id', '[0-9]+');
	Route::get('loft_designer/{designer_id}/events/delete/{id}','AdminControllers\LoftDesignerEventController@destroy')->where('id', '[0-9]+')->where('designer_id', '[0-9]+');
	Route::get('loft_designer/{designer_id}/events/status/{id}/{type}','AdminControllers\LoftDesignerEventController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('designer_id', '[0-9]+');

	Route::get('admin_module','AdminControllers\AdminModuleController@index')->name('module');
	Route::post('admin_module','AdminControllers\AdminModuleController@order');
	Route::get('admin_module/create','AdminControllers\AdminModuleController@create');
	Route::post('admin_module/create','AdminControllers\AdminModuleController@store');
	Route::get('admin_module/edit/{id}','AdminControllers\AdminModuleController@edit')->where('id', '[0-9]+');
	Route::post('admin_module/edit/{id}','AdminControllers\AdminModuleController@update')->where('id', '[0-9]+');
	Route::get('admin_module/delete/{id}','AdminControllers\AdminModuleController@destroy')->where('id', '[0-9]+');
	Route::get('admin_module/status/{id}/{type}','AdminControllers\AdminModuleController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('admin_manage','AdminControllers\AdminManageController@index')->name('manage');
	Route::get('admin_manage/create','AdminControllers\AdminManageController@create');
	Route::post('admin_manage/create','AdminControllers\AdminManageController@store');
	Route::get('admin_manage/edit/{id}','AdminControllers\AdminManageController@edit')->where('id', '[0-9]+');
	Route::post('admin_manage/edit/{id}','AdminControllers\AdminManageController@update')->where('id', '[0-9]+');
	Route::get('admin_manage/delete/{id}','AdminControllers\AdminManageController@destroy')->where('id', '[0-9]+');
	Route::get('admin_manage/status/{id}/{type}','AdminControllers\AdminManageController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('admin_type','AdminControllers\AdminTypeController@index')->name('type');
	Route::get('admin_type/create','AdminControllers\AdminTypeController@create');
	Route::post('admin_type/create','AdminControllers\AdminTypeController@store');
	Route::get('admin_type/edit/{id}','AdminControllers\AdminTypeController@edit')->where('id', '[0-9]+');
	Route::post('admin_type/edit/{id}','AdminControllers\AdminTypeController@update')->where('id', '[0-9]+');
	Route::get('admin_type/delete/{id}','AdminControllers\AdminTypeController@destroy')->where('id', '[0-9]+');
	Route::get('admin_type/status/{id}/{type}','AdminControllers\AdminTypeController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('navigation','AdminControllers\NavigationController@index')->name('navigation');
	Route::post('navigation','AdminControllers\NavigationController@order');
	Route::get('navigation/create','AdminControllers\NavigationController@create');
	Route::post('navigation/create','AdminControllers\NavigationController@store');
	Route::get('navigation/edit/{id}','AdminControllers\NavigationController@edit')->where('id', '[0-9]+');
	Route::post('navigation/edit/{id}','AdminControllers\NavigationController@update')->where('id', '[0-9]+');
	Route::get('navigation/delete/{id}','AdminControllers\NavigationController@destroy')->where('id', '[0-9]+');
	Route::get('navigation/status/{id}/{type}','AdminControllers\NavigationController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('footer_navigation','AdminControllers\FooterNavigationController@index')->name('footer_navigation');
	Route::post('footer_navigation','AdminControllers\FooterNavigationController@order');
	Route::get('footer_navigation/create','AdminControllers\FooterNavigationController@create');
	Route::post('footer_navigation/create','AdminControllers\FooterNavigationController@store');
	Route::get('footer_navigation/edit/{id}','AdminControllers\FooterNavigationController@edit')->where('id', '[0-9]+');
	Route::post('footer_navigation/edit/{id}','AdminControllers\FooterNavigationController@update')->where('id', '[0-9]+');
	Route::get('footer_navigation/delete/{id}','AdminControllers\FooterNavigationController@destroy')->where('id', '[0-9]+');
	Route::get('footer_navigation/status/{id}/{type}','AdminControllers\FooterNavigationController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('cms','AdminControllers\CmsController@index')->name('cms');
	Route::get('cms/create','AdminControllers\CmsController@create');
	Route::post('cms/create','AdminControllers\CmsController@store');
	Route::get('cms/edit/{id}','AdminControllers\CmsController@edit')->where('id', '[0-9]+');
	Route::post('cms/edit/{id}','AdminControllers\CmsController@update')->where('id', '[0-9]+');
	Route::get('cms/delete/{id}','AdminControllers\CmsController@destroy')->where('id', '[0-9]+');
	Route::get('cms/status/{id}/{type}','AdminControllers\CmsController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('link_data','AdminControllers\SeoController@index')->name('seo');
	Route::get('link_data/create','AdminControllers\SeoController@create');
	Route::post('link_data/create','AdminControllers\SeoController@store');
	Route::get('link_data/edit/{id}','AdminControllers\SeoController@edit')->where('id', '[0-9]+');
	Route::post('link_data/edit/{id}','AdminControllers\SeoController@update')->where('id', '[0-9]+');
	Route::get('link_data/delete/{id}','AdminControllers\SeoController@destroy')->where('id', '[0-9]+');
	Route::get('link_data/status/{id}/{type}','AdminControllers\SeoController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('query','AdminControllers\QueryController@index')->name('query');
	Route::get('query/view/{id}','AdminControllers\QueryController@show')->where('id', '[0-9]+');
	Route::get('query/delete/{id}','AdminControllers\QueryController@destroy')->where('id', '[0-9]+');

	Route::get('store_type','AdminControllers\StoreTypeController@index')->name('storeType');
	Route::get('store_type/create','AdminControllers\StoreTypeController@create');
	Route::post('store_type/create','AdminControllers\StoreTypeController@store');
	Route::get('store_type/edit/{id}','AdminControllers\StoreTypeController@edit')->where('id', '[0-9]+');
	Route::post('store_type/edit/{id}','AdminControllers\StoreTypeController@update')->where('id', '[0-9]+');
	Route::get('store_type/delete/{id}','AdminControllers\StoreTypeController@destroy')->where('id', '[0-9]+');
	Route::get('store_type/status/{id}/{type}','AdminControllers\StoreTypeController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('store_category','AdminControllers\StoreCategoryController@index')->name('storeCategory');
	Route::get('store_category/create','AdminControllers\StoreCategoryController@create');
	Route::post('store_category/create','AdminControllers\StoreCategoryController@store');
	Route::get('store_category/edit/{id}','AdminControllers\StoreCategoryController@edit')->where('id', '[0-9]+');
	Route::post('store_category/edit/{id}','AdminControllers\StoreCategoryController@update')->where('id', '[0-9]+');
	Route::get('store_category/delete/{id}','AdminControllers\StoreCategoryController@destroy')->where('id', '[0-9]+');
	Route::get('store_category/status/{id}/{type}','AdminControllers\StoreCategoryController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('store','AdminControllers\StoreController@index')->name('store');
	Route::get('store/create','AdminControllers\StoreController@create');
	Route::post('store/create','AdminControllers\StoreController@store');
	Route::get('store/edit/{id}','AdminControllers\StoreController@edit')->where('id', '[0-9]+');
	Route::post('store/edit/{id}','AdminControllers\StoreController@update')->where('id', '[0-9]+');
	Route::get('store/delete/{id}','AdminControllers\StoreController@destroy')->where('id', '[0-9]+');
	Route::get('store/status/{id}/{type}','AdminControllers\StoreController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('store/{store_id}/banner','AdminControllers\StoreBannerController@index')->where('store_id', '[0-9]+')->name('storeBanner');
	Route::post('store/{store_id}/banner','AdminControllers\StoreBannerController@order')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/banner/create','AdminControllers\StoreBannerController@create')->where('store_id', '[0-9]+');
	Route::post('store/{store_id}/banner/create','AdminControllers\StoreBannerController@store')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/banner/edit/{id}','AdminControllers\StoreBannerController@edit')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::post('store/{store_id}/banner/edit/{id}','AdminControllers\StoreBannerController@update')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/banner/delete/{id}','AdminControllers\StoreBannerController@destroy')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/banner/status/{id}/{type}','AdminControllers\StoreBannerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('store_id', '[0-9]+');

	Route::get('store/{store_id}/deal','AdminControllers\StoreDealController@index')->where('store_id', '[0-9]+')->name('storeDeal');
	Route::get('store/{store_id}/deal/create','AdminControllers\StoreDealController@create')->where('store_id', '[0-9]+');
	Route::post('store/{store_id}/deal/create','AdminControllers\StoreDealController@store')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/deal/edit/{id}','AdminControllers\StoreDealController@edit')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::post('store/{store_id}/deal/edit/{id}','AdminControllers\StoreDealController@update')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/deal/delete/{id}','AdminControllers\StoreDealController@destroy')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('store/{store_id}/deal/status/{id}/{type}','AdminControllers\StoreDealController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('store_id', '[0-9]+');


	Route::get('dine_type','AdminControllers\DineTypeController@index')->name('dineType');
	Route::get('dine_type/create','AdminControllers\DineTypeController@create');
	Route::post('dine_type/create','AdminControllers\DineTypeController@store');
	Route::get('dine_type/edit/{id}','AdminControllers\DineTypeController@edit')->where('id', '[0-9]+');
	Route::post('dine_type/edit/{id}','AdminControllers\DineTypeController@update')->where('id', '[0-9]+');
	Route::get('dine_type/delete/{id}','AdminControllers\DineTypeController@destroy')->where('id', '[0-9]+');
	Route::get('dine_type/status/{id}/{type}','AdminControllers\DineTypeController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('dine_category','AdminControllers\DineCategoryController@index')->name('dineCategory');
	Route::get('dine_category/create','AdminControllers\DineCategoryController@create');
	Route::post('dine_category/create','AdminControllers\DineCategoryController@store');
	Route::get('dine_category/edit/{id}','AdminControllers\DineCategoryController@edit')->where('id', '[0-9]+');
	Route::post('dine_category/edit/{id}','AdminControllers\DineCategoryController@update')->where('id', '[0-9]+');
	Route::get('dine_category/delete/{id}','AdminControllers\DineCategoryController@destroy')->where('id', '[0-9]+');
	Route::get('dine_category/status/{id}/{type}','AdminControllers\DineCategoryController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('dine_cuisine','AdminControllers\DineCuisineController@index')->name('dineCuisine');
	Route::get('dine_cuisine/create','AdminControllers\DineCuisineController@create');
	Route::post('dine_cuisine/create','AdminControllers\DineCuisineController@store');
	Route::get('dine_cuisine/edit/{id}','AdminControllers\DineCuisineController@edit')->where('id', '[0-9]+');
	Route::post('dine_cuisine/edit/{id}','AdminControllers\DineCuisineController@update')->where('id', '[0-9]+');
	Route::get('dine_cuisine/delete/{id}','AdminControllers\DineCuisineController@destroy')->where('id', '[0-9]+');
	Route::get('dine_cuisine/status/{id}/{type}','AdminControllers\DineCuisineController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('dine','AdminControllers\DineController@index')->name('dine');
	Route::get('dine/create','AdminControllers\DineController@create');
	Route::post('dine/create','AdminControllers\DineController@store');
	Route::get('dine/edit/{id}','AdminControllers\DineController@edit')->where('id', '[0-9]+');
	Route::post('dine/edit/{id}','AdminControllers\DineController@update')->where('id', '[0-9]+');
	Route::get('dine/delete/{id}','AdminControllers\DineController@destroy')->where('id', '[0-9]+');
	Route::get('dine/status/{id}/{type}','AdminControllers\DineController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('dine/{store_id}/banner','AdminControllers\DineBannerController@index')->where('store_id', '[0-9]+')->name('dineBanner');
	Route::post('dine/{store_id}/banner','AdminControllers\DineBannerController@order')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/banner/create','AdminControllers\DineBannerController@create')->where('store_id', '[0-9]+');
	Route::post('dine/{store_id}/banner/create','AdminControllers\DineBannerController@store')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/banner/edit/{id}','AdminControllers\DineBannerController@edit')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::post('dine/{store_id}/banner/edit/{id}','AdminControllers\DineBannerController@update')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/banner/delete/{id}','AdminControllers\DineBannerController@destroy')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/banner/status/{id}/{type}','AdminControllers\DineBannerController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('store_id', '[0-9]+');

	Route::get('dine/{store_id}/deal','AdminControllers\DineDealController@index')->where('store_id', '[0-9]+')->name('dineDeal');
	Route::get('dine/{store_id}/deal/create','AdminControllers\DineDealController@create')->where('store_id', '[0-9]+');
	Route::post('dine/{store_id}/deal/create','AdminControllers\DineDealController@store')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/deal/edit/{id}','AdminControllers\DineDealController@edit')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::post('dine/{store_id}/deal/edit/{id}','AdminControllers\DineDealController@update')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/deal/delete/{id}','AdminControllers\DineDealController@destroy')->where('id', '[0-9]+')->where('store_id', '[0-9]+');
	Route::get('dine/{store_id}/deal/status/{id}/{type}','AdminControllers\DineDealController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('store_id', '[0-9]+');

	Route::get('fashion_post','AdminControllers\FashionPostController@index')->name('fashionPost');
	Route::get('fashion_post/create','AdminControllers\FashionPostController@create');
	Route::post('fashion_post/create','AdminControllers\FashionPostController@store');
	Route::get('fashion_post/edit/{id}','AdminControllers\FashionPostController@edit')->where('id', '[0-9]+');
	Route::post('fashion_post/edit/{id}','AdminControllers\FashionPostController@update')->where('id', '[0-9]+');
	Route::get('fashion_post/delete/{id}','AdminControllers\FashionPostController@destroy')->where('id', '[0-9]+');
	Route::get('fashion_post/status/{id}/{type}','AdminControllers\FashionPostController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('movie_poster','AdminControllers\MoviePosterController@index')->name('moviePoster');
	Route::post('movie_poster','AdminControllers\MoviePosterController@order');
	Route::get('movie_poster/create','AdminControllers\MoviePosterController@create');
	Route::post('movie_poster/create','AdminControllers\MoviePosterController@store');
	Route::get('movie_poster/edit/{id}','AdminControllers\MoviePosterController@edit')->where('id', '[0-9]+');
	Route::post('movie_poster/edit/{id}','AdminControllers\MoviePosterController@update')->where('id', '[0-9]+');
	Route::get('movie_poster/delete/{id}','AdminControllers\MoviePosterController@destroy')->where('id', '[0-9]+');
	Route::get('movie_poster/status/{id}/{type}','AdminControllers\MoviePosterController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('award','AdminControllers\AwardController@index')->name('award');
	Route::get('award/create','AdminControllers\AwardController@create');
	Route::post('award/create','AdminControllers\AwardController@store');
	Route::get('award/edit/{id}','AdminControllers\AwardController@edit')->where('id', '[0-9]+');
	Route::post('award/edit/{id}','AdminControllers\AwardController@update')->where('id', '[0-9]+');
	Route::get('award/delete/{id}','AdminControllers\AwardController@destroy')->where('id', '[0-9]+');
	Route::get('award/status/{id}/{type}','AdminControllers\AwardController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('blog','AdminControllers\BlogController@index')->name('blog');
	Route::get('blog/create','AdminControllers\BlogController@create');
	Route::post('blog/create','AdminControllers\BlogController@store');
	Route::get('blog/edit/{id}','AdminControllers\BlogController@edit')->where('id', '[0-9]+');
	Route::post('blog/edit/{id}','AdminControllers\BlogController@update')->where('id', '[0-9]+');
	Route::get('blog/delete/{id}','AdminControllers\BlogController@destroy')->where('id', '[0-9]+');
	Route::get('blog/status/{id}/{type}','AdminControllers\BlogController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('qreview','AdminControllers\QreviewController@index')->name('qreview');
	Route::get('qreview/create','AdminControllers\QreviewController@create');
	Route::post('qreview/create','AdminControllers\QreviewController@store');
	Route::get('qreview/edit/{id}','AdminControllers\QreviewController@edit')->where('id', '[0-9]+');
	Route::post('qreview/edit/{id}','AdminControllers\QreviewController@update')->where('id', '[0-9]+');
	Route::get('qreview/delete/{id}','AdminControllers\QreviewController@destroy')->where('id', '[0-9]+');
	Route::get('qreview/status/{id}/{type}','AdminControllers\QreviewController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('qreview/{q_id}/gallery','AdminControllers\QreviewGalleryController@index')->where('q_id', '[0-9]+')->name('qreviewGallery');
	Route::post('qreview/{q_id}/gallery','AdminControllers\QreviewGalleryController@order')->where('q_id', '[0-9]+');
	Route::get('qreview/{q_id}/gallery/create','AdminControllers\QreviewGalleryController@create')->where('q_id', '[0-9]+');
	Route::post('qreview/{q_id}/gallery/create','AdminControllers\QreviewGalleryController@store')->where('q_id', '[0-9]+');
	Route::get('qreview/{q_id}/gallery/edit/{id}','AdminControllers\QreviewGalleryController@edit')->where('id', '[0-9]+')->where('q_id', '[0-9]+');
	Route::post('qreview/{q_id}/gallery/edit/{id}','AdminControllers\QreviewGalleryController@update')->where('id', '[0-9]+')->where('q_id', '[0-9]+');
	Route::get('qreview/{q_id}/gallery/delete/{id}','AdminControllers\QreviewGalleryController@destroy')->where('id', '[0-9]+')->where('q_id', '[0-9]+');
	Route::get('qreview/{q_id}/gallery/status/{id}/{type}','AdminControllers\QreviewGalleryController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('q_id', '[0-9]+');



	Route::get('review_tag','AdminControllers\ReviewTagController@index')->name('reviewTag');
	Route::get('review_tag/create','AdminControllers\ReviewTagController@create');
	Route::post('review_tag/create','AdminControllers\ReviewTagController@store');
	Route::get('review_tag/edit/{id}','AdminControllers\ReviewTagController@edit')->where('id', '[0-9]+');
	Route::post('review_tag/edit/{id}','AdminControllers\ReviewTagController@update')->where('id', '[0-9]+');
	Route::get('review_tag/delete/{id}','AdminControllers\ReviewTagController@destroy')->where('id', '[0-9]+');
	Route::get('review_tag/status/{id}/{type}','AdminControllers\ReviewTagController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');



	Route::get('qauthor','AdminControllers\QauthorController@index')->name('qauthor');
	Route::get('qauthor/create','AdminControllers\QauthorController@create');
	Route::post('qauthor/create','AdminControllers\QauthorController@store');
	Route::get('qauthor/edit/{id}','AdminControllers\QauthorController@edit')->where('id', '[0-9]+');
	Route::post('qauthor/edit/{id}','AdminControllers\QauthorController@update')->where('id', '[0-9]+');
	Route::get('qauthor/delete/{id}','AdminControllers\QauthorController@destroy')->where('id', '[0-9]+');
	Route::get('qauthor/status/{id}/{type}','AdminControllers\QauthorController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');



	Route::get('blog_category','AdminControllers\BlogCategoryController@index')->name('blogCategory');
	Route::get('blog_category/create','AdminControllers\BlogCategoryController@create');
	Route::post('blog_category/create','AdminControllers\BlogCategoryController@store');
	Route::get('blog_category/edit/{id}','AdminControllers\BlogCategoryController@edit')->where('id', '[0-9]+');
	Route::post('blog_category/edit/{id}','AdminControllers\BlogCategoryController@update')->where('id', '[0-9]+');
	Route::get('blog_category/delete/{id}','AdminControllers\BlogCategoryController@destroy')->where('id', '[0-9]+');
	Route::get('blog_category/status/{id}/{type}','AdminControllers\BlogCategoryController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('event','AdminControllers\EventController@index')->name('event');
	Route::get('event/create','AdminControllers\EventController@create');
	Route::post('event/create','AdminControllers\EventController@store');
	Route::get('event/edit/{id}','AdminControllers\EventController@edit')->where('id', '[0-9]+');
	Route::post('event/edit/{id}','AdminControllers\EventController@update')->where('id', '[0-9]+');
	Route::get('event/delete/{id}','AdminControllers\EventController@destroy')->where('id', '[0-9]+');
	Route::get('event/status/{id}/{type}','AdminControllers\EventController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('event/{event_id}/gallery','AdminControllers\EventGalleryController@index')->where('event_id', '[0-9]+')->name('eventGallery');
	Route::get('event/{event_id}/gallery/create','AdminControllers\EventGalleryController@create')->where('event_id', '[0-9]+');
	Route::post('event/{event_id}/gallery/create','AdminControllers\EventGalleryController@store')->where('event_id', '[0-9]+');
	Route::get('event/{event_id}/gallery/edit/{id}','AdminControllers\EventGalleryController@edit')->where('id', '[0-9]+')->where('event_id', '[0-9]+');
	Route::post('event/{event_id}/gallery/edit/{id}','AdminControllers\EventGalleryController@update')->where('id', '[0-9]+')->where('event_id', '[0-9]+');
	Route::get('event/{event_id}/gallery/delete/{id}','AdminControllers\EventGalleryController@destroy')->where('id', '[0-9]+')->where('event_id', '[0-9]+');
	Route::get('event/{event_id}/gallery/status/{id}/{type}','AdminControllers\EventGalleryController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('event_id', '[0-9]+');

	Route::get('news','AdminControllers\NewsController@index')->name('news');
	Route::get('news/create','AdminControllers\NewsController@create');
	Route::post('news/create','AdminControllers\NewsController@store');
	Route::get('news/edit/{id}','AdminControllers\NewsController@edit')->where('id', '[0-9]+');
	Route::post('news/edit/{id}','AdminControllers\NewsController@update')->where('id', '[0-9]+');
	Route::get('news/delete/{id}','AdminControllers\NewsController@destroy')->where('id', '[0-9]+');
	Route::get('news/status/{id}/{type}','AdminControllers\NewsController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('gallery','AdminControllers\GalleryController@index')->name('gallery');
	Route::get('gallery/create','AdminControllers\GalleryController@create');
	Route::post('gallery/create','AdminControllers\GalleryController@store');
	Route::get('gallery/edit/{id}','AdminControllers\GalleryController@edit')->where('id', '[0-9]+');
	Route::post('gallery/edit/{id}','AdminControllers\GalleryController@update')->where('id', '[0-9]+');
	Route::get('gallery/delete/{id}','AdminControllers\GalleryController@destroy')->where('id', '[0-9]+');
	Route::get('gallery/status/{id}/{type}','AdminControllers\GalleryController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('gallery/{gallery_id}/images','AdminControllers\GalleryImagesController@index')->where('gallery_id', '[0-9]+')->name('galleryImages');
	Route::get('gallery/{gallery_id}/images/create','AdminControllers\GalleryImagesController@create')->where('gallery_id', '[0-9]+');
	Route::post('gallery/{gallery_id}/images/create','AdminControllers\GalleryImagesController@store')->where('gallery_id', '[0-9]+');
	Route::get('gallery/{gallery_id}/images/edit/{id}','AdminControllers\GalleryImagesController@edit')->where('id', '[0-9]+')->where('gallery_id', '[0-9]+');
	Route::post('gallery/{gallery_id}/images/edit/{id}','AdminControllers\GalleryImagesController@update')->where('id', '[0-9]+')->where('gallery_id', '[0-9]+');
	Route::get('gallery/{gallery_id}/images/delete/{id}','AdminControllers\GalleryImagesController@destroy')->where('id', '[0-9]+')->where('gallery_id', '[0-9]+');
	Route::get('gallery/{gallery_id}/images/status/{id}/{type}','AdminControllers\GalleryImagesController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('event_id', '[0-9]+');

	Route::get('map','AdminControllers\MapController@index')->name('map');
	Route::get('map/create','AdminControllers\MapController@create');
	Route::post('map/create','AdminControllers\MapController@store');
	Route::get('map/edit/{id}','AdminControllers\MapController@edit')->where('id', '[0-9]+');
	Route::post('map/edit/{id}','AdminControllers\MapController@update')->where('id', '[0-9]+');
	Route::get('map/delete/{id}','AdminControllers\MapController@destroy')->where('id', '[0-9]+');
	Route::get('map/status/{id}/{type}','AdminControllers\MapController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('camera_frame','AdminControllers\CameraFrameController@index')->name('cameraFrame');
	Route::get('camera_frame/create','AdminControllers\CameraFrameController@create');
	Route::post('camera_frame/create','AdminControllers\CameraFrameController@store');
	Route::get('camera_frame/edit/{id}','AdminControllers\CameraFrameController@edit')->where('id', '[0-9]+');
	Route::post('camera_frame/edit/{id}','AdminControllers\CameraFrameController@update')->where('id', '[0-9]+');
	Route::get('camera_frame/delete/{id}','AdminControllers\CameraFrameController@destroy')->where('id', '[0-9]+');
	Route::get('camera_frame/status/{id}/{type}','AdminControllers\CameraFrameController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('app_push','AdminControllers\AppPushController@index')->name('appPush');
	Route::get('app_push/create','AdminControllers\AppPushController@create');
	Route::post('app_push/create','AdminControllers\AppPushController@store');
	Route::get('app_push/edit/{id}','AdminControllers\AppPushController@edit')->where('id', '[0-9]+');
	Route::post('app_push/edit/{id}','AdminControllers\AppPushController@update')->where('id', '[0-9]+');
	Route::get('app_push/delete/{id}','AdminControllers\AppPushController@destroy')->where('id', '[0-9]+');
	Route::get('app_push/trigger/{id}','AdminControllers\AppPushController@trigger')->where('id', '[0-9]+');

	Route::get('walk_offer','AdminControllers\WalkOfferController@index')->name('walkOffer');
	Route::get('walk_offer/create','AdminControllers\WalkOfferController@create');
	Route::post('walk_offer/create','AdminControllers\WalkOfferController@store');
	Route::get('walk_offer/edit/{id}','AdminControllers\WalkOfferController@edit')->where('id', '[0-9]+');
	Route::post('walk_offer/edit/{id}','AdminControllers\WalkOfferController@update')->where('id', '[0-9]+');
	Route::get('walk_offer/delete/{id}','AdminControllers\WalkOfferController@destroy')->where('id', '[0-9]+');
	Route::get('walk_offer/status/{id}/{type}','AdminControllers\WalkOfferController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('beacon','AdminControllers\BeaconController@index')->name('beacon');
	Route::get('beacon/create','AdminControllers\BeaconController@create');
	Route::post('beacon/create','AdminControllers\BeaconController@store');
	Route::get('beacon/edit/{id}','AdminControllers\BeaconController@edit')->where('id', '[0-9]+');
	Route::post('beacon/edit/{id}','AdminControllers\BeaconController@update')->where('id', '[0-9]+');
	Route::get('beacon/delete/{id}','AdminControllers\BeaconController@destroy')->where('id', '[0-9]+');

	Route::get('walknwin-validate','AdminControllers\WnwvalidateController@index')->name('userwnw_login');
	Route::post('walknwin-validate','AdminControllers\WnwvalidateController@check');
	Route::get('walknwin-validate/list','AdminControllers\WnwvalidateController@list')->name('userwnw');
	Route::get('walknwin-validate/update/{id}','AdminControllers\WnwvalidateController@update');
	Route::get('walknwin-validate/logout','AdminControllers\WnwvalidateController@logout')->name('userwnw_logout');



	Route::get('contest-validate','AdminControllers\ContestvalidateController@index')->name('contestvalidate_login');
	Route::post('contest-validate','AdminControllers\ContestvalidateController@check');
	Route::get('contest-validate/list','AdminControllers\ContestvalidateController@list')->name('contestvalidate');
	Route::post('contest-validate/list','AdminControllers\ContestvalidateController@list');
	Route::get('contest-validate/update/{id}','AdminControllers\ContestvalidateController@update');
	Route::get('contest-validate/logout','AdminControllers\ContestvalidateController@logout')->name('contestvalidate_logout');


	Route::get('store_review','AdminControllers\StoreReviewController@index')->name('store_review');
	Route::get('store_review/view/{id}','AdminControllers\StoreReviewController@show')->where('id', '[0-9]+');
	Route::get('store_review/delete/{id}','AdminControllers\StoreReviewController@destroy')->where('id', '[0-9]+');
	Route::get('store_review/status/{id}/{type}','AdminControllers\StoreReviewController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('feedback','AdminControllers\FeedbackController@index')->name('feedback');
	Route::get('feedback/view/{id}','AdminControllers\FeedbackController@show')->where('id', '[0-9]+');
	Route::get('feedback/delete/{id}','AdminControllers\FeedbackController@destroy')->where('id', '[0-9]+');
	Route::get('feedback/status/{id}/{type}','AdminControllers\FeedbackController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');



	Route::get('app_navigation', 'AdminControllers\AppNavigationController@index')->name('app_navigation');
	Route::post('app_navigation', 'AdminControllers\AppNavigationController@order');
	Route::get('app_navigation/create', 'AdminControllers\AppNavigationController@create');
	Route::post('app_navigation/create', 'AdminControllers\AppNavigationController@store');
	Route::get('app_navigation/edit/{id}', 'AdminControllers\AppNavigationController@edit')->where('id', '[0-9]+');
	Route::post('app_navigation/edit/{id}', 'AdminControllers\AppNavigationController@update')->where('id', '[0-9]+');
	Route::get('app_navigation/delete/{id}', 'AdminControllers\AppNavigationController@destroy')->where('id', '[0-9]+');
	Route::get('app_navigation/status/{id}/{type}', 'AdminControllers\AppNavigationController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('referral','AdminControllers\ReferralController@index')->name('referral');
	Route::get('referral/view/{id}','AdminControllers\ReferralController@show')->where('id', '[0-9]+');
	Route::get('referral/delete/{id}','AdminControllers\ReferralController@destroy')->where('id', '[0-9]+');
	Route::get('referral/status/{id}/{type}','AdminControllers\ReferralController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('qcard_transaction','AdminControllers\QcardTransactionController@index')->name('qcard_transaction');
	Route::get('qcard_transaction/view/{id}','AdminControllers\QcardTransactionController@show')->where('id', '[0-9]+');
	Route::get('qcard_transaction/delete/{id}','AdminControllers\QcardTransactionController@destroy')->where('id', '[0-9]+');
	Route::get('qcard_transaction/status/{id}/{type}','AdminControllers\QcardTransactionController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('walk_win_count','AdminControllers\WalkWinCountController@index')->name('walk_win_count');
	Route::post('walk_win_count', 'AdminControllers\WalkWinCountController@index');


	Route::get('walk_win_offer_redeem','AdminControllers\WalkWinOfferRedeemController@index')->name('walk_win_offer_redeem');
	Route::post('walk_win_offer_redeem','AdminControllers\WalkWinOfferRedeemController@index');


	Route::any('trivia-contest','AdminControllers\TriviaContestController@index')->name('teiviacontest');

	Route::get('contest','AdminControllers\ContestController@index')->name('contest');
	Route::get('contest/create','AdminControllers\ContestController@create');
	Route::post('contest/create','AdminControllers\ContestController@store');
	Route::get('contest/edit/{id}','AdminControllers\ContestController@edit')->where('id', '[0-9]+');
	Route::post('contest/edit/{id}','AdminControllers\ContestController@update')->where('id', '[0-9]+');
	Route::get('contest/delete/{id}','AdminControllers\ContestController@destroy')->where('id', '[0-9]+');
	Route::get('contest/status/{id}/{type}','AdminControllers\ContestController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');


	Route::get('contest/{contest_id}/threshold','AdminControllers\ContestThresholdController@index')->where('contest_id', '[0-9]+')->name('threshold');
	Route::get('contest/{contest_id}/threshold/create','AdminControllers\ContestThresholdController@create')->where('contest_id', '[0-9]+');
	Route::post('contest/{contest_id}/threshold/create','AdminControllers\ContestThresholdController@store')->where('contest_id', '[0-9]+');
	Route::get('contest/{contest_id}/threshold/edit/{id}','AdminControllers\ContestThresholdController@edit')->where('id', '[0-9]+')->where('contest_id', '[0-9]+');
	Route::post('contest/{contest_id}/threshold/edit/{id}','AdminControllers\ContestThresholdController@update')->where('id', '[0-9]+')->where('contest_id', '[0-9]+');
	Route::get('contest/{contest_id}/threshold/delete/{id}','AdminControllers\ContestThresholdController@destroy')->where('id', '[0-9]+')->where('contest_id', '[0-9]+');
	Route::get('contest/{contest_id}/threshold/status/{id}/{type}','AdminControllers\ContestThresholdController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+')->where('contest_id', '[0-9]+');


	Route::get('contest_participants','AdminControllers\ContestParticipantsController@index')->name('contest_participants');
	Route::get('contest_participants/view/{id}','AdminControllers\ContestParticipantsController@show')->where('id', '[0-9]+');


	Route::get('contest_participants_transaction','AdminControllers\ContestParticipantsTransactionController@index')->name('contest_participants_transaction');
	Route::get('contest_participants_transaction/view/{id}','AdminControllers\ContestParticipantsTransactionController@show')->where('id', '[0-9]+');


	Route::get('entry_slots','AdminControllers\EntrySlotsController@index')->name('entrySlots');
	Route::post('entry_slots','AdminControllers\EntrySlotsController@store');
	Route::get('entry_slots/delete/{id}','AdminControllers\EntrySlotsController@destroy')->where('id', '[0-9]+');
	Route::get('entry_slots/status/{id}/{type}','AdminControllers\EntrySlotsController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('entry_booking','AdminControllers\EntryBookingController@index')->name('entryBooking');

	Route::get('entry_setting','AdminControllers\EntrySettingsController@index')->name('entrysettings');
	Route::post('entry_setting','AdminControllers\EntrySettingsController@update');

	Route::get('app_offer', 'AdminControllers\AppOfferController@index')->name('appOffer');
	Route::post('app_offer', 'AdminControllers\AppOfferController@order');
	Route::get('app_offer/create', 'AdminControllers\AppOfferController@create');
	Route::post('app_offer/create', 'AdminControllers\AppOfferController@store');
	Route::get('app_offer/edit/{id}', 'AdminControllers\AppOfferController@edit')->where('id', '[0-9]+');
	Route::post('app_offer/edit/{id}', 'AdminControllers\AppOfferController@update')->where('id', '[0-9]+');
	Route::get('app_offer/delete/{id}', 'AdminControllers\AppOfferController@destroy')->where('id', '[0-9]+');
	Route::get('app_offer/status/{id}/{type}', 'AdminControllers\AppOfferController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

	Route::get('appoffer-validate','AdminControllers\AppoffervalidateController@index')->name('appOfferValidate_login');
	Route::post('appoffer-validate','AdminControllers\AppoffervalidateController@check');
	Route::get('appoffer-validate/list','AdminControllers\AppoffervalidateController@list')->name('appOfferValidate');
	Route::post('appoffer-validate/list','AdminControllers\AppoffervalidateController@list');
	Route::get('appoffer-validate/update/{id}','AdminControllers\AppoffervalidateController@update');
	Route::get('appoffer-validate/logout','AdminControllers\AppoffervalidateController@logout')->name('appOfferValidate_logout');

	Route::prefix('store-panel')->name('storePanel::')->group(function(){
		Route::get('',function(){return redirect()->route('admin::storePanel::login');});
		Route::get('login','AdminControllers\StorePanel\StoreLoginController@index')->name('login');
		Route::post('login','AdminControllers\StorePanel\StoreLoginController@check');
		Route::get('logout','AdminControllers\StorePanel\StoreLoginController@logout')->name('logout');
		Route::get('dashboard','AdminControllers\StorePanel\TransactionListController@index')->name('home');

		Route::get('employees', 'AdminControllers\StorePanel\EmployeesController@index')->name('employees');
		Route::get('employees/create', 'AdminControllers\StorePanel\EmployeesController@create');
		Route::post('employees/create', 'AdminControllers\StorePanel\EmployeesController@store');
		Route::get('employees/edit/{id}', 'AdminControllers\StorePanel\EmployeesController@edit')->where('id', '[0-9]+');
		Route::post('employees/edit/{id}', 'AdminControllers\StorePanel\EmployeesController@update')->where('id', '[0-9]+');
		Route::get('employees/delete/{id}', 'AdminControllers\StorePanel\EmployeesController@destroy')->where('id', '[0-9]+');
		Route::get('employees/status/{id}/{type}', 'AdminControllers\StorePanel\EmployeesController@change_status')->where('type', '[0-1]')->where('id', '[0-9]+');

		Route::get('dinenwin','AdminControllers\StorePanel\ContestvalidateController@list')->name('contestvalidate');
		Route::post('dinenwin','AdminControllers\StorePanel\ContestvalidateController@list');

		Route::get('apponlyoffer','AdminControllers\StorePanel\AppoffervalidateController@list')->name('appOfferValidate');
		Route::post('apponlyoffer','AdminControllers\StorePanel\AppoffervalidateController@list');
	});
});


Route::any('ajax/loadStore','AjaxController@loadStore');
Route::any('ajax/loadDine','AjaxController@loadDine');
Route::any('ajax/loadDeals','AjaxController@loadDeals');
Route::get('ajax/search/{searchTerm}','AjaxController@search');

Route::get('the-loft/events/{slug?}','SiteController@loftEvents');
Route::get('refer/{refer_code}','SiteController@referralTrack');

Route::get('verifyEmail/{chash}','AjaxController@verify');

Route::get('/','SiteController@index');
Route::get('/{slug}/{sub_slug?}/{sub_sub_slug?}','SiteController@cms');



//new website

Route::get('new','SiteControllerNew@index');