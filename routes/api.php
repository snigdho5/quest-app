<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});


Route::get('getMallMap', 'AppApiControllers\AjaxController@getMallMap');
Route::get('getFeedbackPageData', 'AppApiControllers\AjaxController@getFeedbackPageData');

Route::get('getNotification', 'AppApiControllers\AjaxController@getNotification');

Route::get('getHome', 'AppApiControllers\AjaxController@getHome');
Route::get('getBanners', 'AppApiControllers\AjaxController@getBanners');
Route::get('getStoreTypes', 'AppApiControllers\AjaxController@getStoreTypes');
Route::get('getDineTypes', 'AppApiControllers\AjaxController@getDineTypes');

Route::get('getFrames', 'AppApiControllers\AjaxController@getFrames');

Route::get('getLoftData', 'AppApiControllers\AjaxController@getLoftData');
Route::get('getLoftEvents', 'AppApiControllers\AjaxController@getLoftEvents');
Route::get('getLoftNewEvents', 'AppApiControllers\AjaxController@getLoftNewEvents');

Route::get('getEvents', 'AppApiControllers\AjaxController@getEvents');
Route::get('getEvent/{id}', 'AppApiControllers\AjaxController@getEvent')->where('id', '[0-9]+');

Route::get('getMovies', 'AppApiControllers\AjaxController@getMovies');

Route::get('getDesigners', 'AppApiControllers\AjaxController@getDesigners');
Route::get('getDesigner/{id}', 'AppApiControllers\AjaxController@getDesigner')->where('id', '[0-9]+');

Route::get('getDeals', 'AppApiControllers\AjaxController@getDeals');
Route::get('getDeals/{store_id}', 'AppApiControllers\AjaxController@getDeals')->where('store_id', '[0-9]+');
Route::get('getDeal/{id}', 'AppApiControllers\AjaxController@getDeal')->where('id', '[0-9]+');

Route::get('getAppDealStores/{type}', 'AppApiControllers\AjaxController@getAppDealStores');
Route::get('getAppDeals/{id?}', 'AppApiControllers\AjaxController@getAppDeals');
Route::get('getAppDeals', 'AppApiControllers\AjaxController@getAppDeals');
Route::post('getAppDeal', 'AppApiControllers\AjaxController@getAppDeal');
Route::post('genAppDealCode', 'AppApiControllers\AjaxController@genAppDealCode');

Route::get('getReview/{store_id}', 'AppApiControllers\AjaxController@getReviews')->where('store_id', '[0-9]+');

Route::get('getStores/{type_id}/{cat_id}/{floor}/{cuisine}/{type}', 'AppApiControllers\AjaxController@getStores');
Route::get('getStore/{id}', 'AppApiControllers\AjaxController@getStore')->where('id', '[0-9]+');
Route::get('getStoreBanners/{store_id}', 'AppApiControllers\AjaxController@getStoreBanners')->where('store_id', '[0-9]+');

Route::get('getBlogs', 'AppApiControllers\AjaxController@getBlogs');
Route::get('getBlogs/{cat_id}', 'AppApiControllers\AjaxController@getBlogs');
Route::get('getBlog/{id}', 'AppApiControllers\AjaxController@getBlog')->where('id', '[0-9]+');

Route::get('getQreviews', 'AppApiControllers\AjaxController@getQreviews');
Route::get('getQreviews/{auth_id}/{tag_id}', 'AppApiControllers\AjaxController@getQreviews');
Route::get('getQreview/{id}', 'AppApiControllers\AjaxController@getQreview')->where('id', '[0-9]+');

Route::get('getBeaconOffers', 'AppApiControllers\AjaxController@getBeaconOffers');

Route::get('search/{searchTerm}', 'AppApiControllers\AjaxController@search');

Route::get('getFaq', 'AppApiControllers\AjaxController@getFaq');

Route::post('socialAuthApple', 'AppApiControllers\AjaxController@socialAuthApple');

Route::post('socialAuth', 'AppApiControllers\AjaxController@socialAuth');
Route::post('registerUser', 'AppApiControllers\AjaxController@registerUser');
Route::post('loginUser', 'AppApiControllers\AjaxController@loginUser');
Route::post('logoutUser', 'AppApiControllers\AjaxController@logoutUser');
Route::post('getLoggedinUser', 'AppApiControllers\AjaxController@getLoggedinUser');
Route::post('resetPassword', 'AppApiControllers\AjaxController@resetPassword');
Route::post('feedback', 'AppApiControllers\AjaxController@feedback');
Route::post('savefeedback', 'AppApiControllers\AjaxController@savefeedback');
Route::post('saveData', 'AppApiControllers\AjaxController@saveData');
Route::post('saveImage', 'AppApiControllers\AjaxController@saveImage');
Route::post('savePass', 'AppApiControllers\AjaxController@savePass');
Route::post('saveSteps', 'AppApiControllers\AjaxController@saveSteps');
Route::post('saveArticle', 'AppApiControllers\AjaxController@saveArticle');
Route::post('getSavedBlogs', 'AppApiControllers\AjaxController@getSavedBlogs');
Route::post('redeemOffer', 'AppApiControllers\AjaxController@redeemOffer');
Route::post('rateStore', 'AppApiControllers\AjaxController@rateStore');
Route::post('phoneVerifyOtp', 'AppApiControllers\AjaxController@phoneVerifyOtp');


Route::get('parkingApi', 'AppApiControllers\AjaxController@parkingApi');
Route::get('test', 'AppApiControllers\ContestController@test');


Route::post('getContestDetails', 'AppApiControllers\ContestController@getContestDetails');
Route::post('joinContest', 'AppApiControllers\ContestController@joinContest');

Route::post('getTriviaDetails', 'AppApiControllers\ContestController@getTriviaDetails');
Route::post('submitTrivia', 'AppApiControllers\ContestController@submitTrivia');


Route::post('getBookingInfo', 'AppApiControllers\BookingController@getInfo');
Route::post('getSlots', 'AppApiControllers\BookingController@getSlots');
Route::post('bootEntry', 'AppApiControllers\BookingController@bootEntry');
Route::post('cancelBooking', 'AppApiControllers\BookingController@cancelBooking');
Route::post('logEntry', 'AppApiControllers\BookingController@logEntry');
Route::post('logExit', 'AppApiControllers\BookingController@logExit');


// CRM App
Route::prefix('crm')->group(function () {
	Route::get('getStoreList', 'AppApiControllers\CrmController@getStoreList');
	Route::post('sendOtp', 'AppApiControllers\CrmController@sendOtp');
	Route::post('login', 'AppApiControllers\CrmController@login');
	Route::post('logout', 'AppApiControllers\CrmController@logout');
	Route::post('checklogin', 'AppApiControllers\CrmController@checklogin');
	Route::post('verifyQrCode', 'AppApiControllers\CrmController@verifyQrCode');
	Route::post('submitOffer', 'AppApiControllers\CrmController@submitOffer');
	Route::post('loadHistory', 'AppApiControllers\CrmController@loadHistory');
});



//// new apis
//snigdho

Route::get('mall-map', 'AppApiControllers\NewAPIController@getMallMap');
Route::get('banners', 'AppApiControllers\NewAPIController@getBanners');
Route::get('home', 'AppApiControllers\NewAPIController@getHome');
Route::get('store-types', 'AppApiControllers\NewAPIController@getStoreTypes');
Route::get('get-stores/{cat_id}/{type}', 'AppApiControllers\NewAPIController@getStores');
Route::get('get-store/{id}', 'AppApiControllers\NewAPIController@getStore')->where('id', '[0-9]+');
Route::get('get-deals', 'AppApiControllers\NewAPIController@getDeals');
// Route::get('app-only-offers', 'AppApiControllers\NewAPIController@getAppOnlyOffers');
Route::get('get-deals/{store_id}', 'AppApiControllers\NewAPIController@getDeals')->where('store_id', '[0-9]+');
Route::get('get-deal/{id}', 'AppApiControllers\NewAPIController@getDeal')->where('id', '[0-9]+');
Route::get('dine-types', 'AppApiControllers\NewAPIController@getDineTypes');
Route::get('movies', 'AppApiControllers\NewAPIController@getMovies');
Route::get('loft-data', 'AppApiControllers\NewAPIController@getLoftData');
Route::get('loft-events', 'AppApiControllers\NewAPIController@getLoftEvents');
// Route::get('loft-new-events','AppApiControllers\NewAPIController@getLoftNewEvents');
Route::post('send-registration-otp', 'AppApiControllers\NewAPIController@sendRegOTP');
Route::post('verify-registration', 'AppApiControllers\NewAPIController@verifyRegOTP');
Route::post('register-user', 'AppApiControllers\NewAPIController@registerUser'); //not in use
Route::post('send-login-otp', 'AppApiControllers\NewAPIController@sendLoginOTP');
Route::post('verify-login-otp', 'AppApiControllers\NewAPIController@verifyLoginOTP');
Route::post('login-user', 'AppApiControllers\NewAPIController@loginUser'); //not in use
Route::post('logout-user', 'AppApiControllers\NewAPIController@logoutUser');
Route::post('delete-user', 'AppApiControllers\NewAPIController@deleteUser');
Route::post('loggedin-user', 'AppApiControllers\NewAPIController@getLoggedinUser'); //not in use
Route::post('user-profile', 'AppApiControllers\NewAPIController@userProfile');
Route::get('profile-interests', 'AppApiControllers\NewAPIController@getProfileInterests');
Route::post('update-user-profile', 'AppApiControllers\NewAPIController@updateUserProfile');
Route::post('update-user-image', 'AppApiControllers\NewAPIController@updateUserImage');
Route::post('reset-password', 'AppApiControllers\NewAPIController@resetPassword');
Route::get('faq', 'AppApiControllers\NewAPIController@getFaq');
Route::get('parking', 'AppApiControllers\NewAPIController@parkingApi');
Route::get('feedback-data', 'AppApiControllers\NewAPIController@getFeedbackPageData');
Route::post('new-feedback', 'AppApiControllers\NewAPIController@feedback');
Route::post('save-feedback', 'AppApiControllers\NewAPIController@savefeedback');
Route::get('get-events', 'AppApiControllers\NewAPIController@getEvents');
Route::get('get-event/{id}', 'AppApiControllers\NewAPIController@getEvent')->where('id', '[0-9]+');

Route::get('app-only-offers/{type}', 'AppApiControllers\NewAPIController@getAppDealStores');
Route::get('get-app-deals/{id?}', 'AppApiControllers\NewAPIController@getAppDeals');
Route::get('get-app-deals', 'AppApiControllers\NewAPIController@getAppDeals');
Route::post('get-app-deal', 'AppApiControllers\NewAPIController@getAppDeal');
Route::post('gen-app-deal-code', 'AppApiControllers\NewAPIController@genAppDealCode');

Route::get('get-blogs', 'AppApiControllers\NewAPIController@getBlogs');
Route::get('get-blogs/{cat_id}', 'AppApiControllers\NewAPIController@getBlogs');
Route::get('get-blog/{id}', 'AppApiControllers\NewAPIController@getBlog')->where('id', '[0-9]+');
Route::get('get-designers', 'AppApiControllers\NewAPIController@getDesigners');
Route::get('get-designer/{id}', 'AppApiControllers\NewAPIController@getDesigner')->where('id', '[0-9]+');
Route::post('dine-and-win', 'AppApiControllers\NewAPIController@getDineAndWin');
Route::post('send-profile-otp', 'AppApiControllers\NewAPIController@sendProfileOTP');
Route::post('verify-profile-otp', 'AppApiControllers\NewAPIController@verifyProfileOTP');
Route::get('get-newstores', 'AppApiControllers\NewAPIController@getNewStores');
Route::get('get-review/{store_id}', 'AppApiControllers\NewAPIController@getReviews')->where('store_id', '[0-9]+');
Route::post('rate-store', 'AppApiControllers\NewAPIController@rateStore');
Route::post('social-login', 'AppApiControllers\NewAPIController@socialAuth');
Route::get('global-search/{searchTerm}', 'AppApiControllers\NewAPIController@search');

Route::post('contest-details', 'AppApiControllers\NewAPIController@getContestDetails');
Route::post('join-contest', 'AppApiControllers\NewAPIController@joinContest');


//clear
Route::get('clear-cache', 'ConfigController@clearCache');
Route::get('clear_cache', function () {

	\Artisan::call('config:clear');
	\Artisan::call('config:cache');

	echo "Cache is cleared";
});
