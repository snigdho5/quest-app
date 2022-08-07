<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// get list of tasks
Route::get('category/{dept_type}','TaskController@getCategory');
Route::get('categoryEscalate','TaskController@getCategoryEscalate');
Route::get('problemDetails/{userid}','TaskController@problemDetails');
Route::get('solutionDetails/{docketNo}','TaskController@solutionDetails');
Route::get('deptList','TaskController@deptList');
Route::get('mainProblemType','TaskController@mainProblemType');
Route::get('subProblemType/{prob_type}','TaskController@subProblemType');
Route::get('vendorList/{dept}','TaskController@vendorList');
Route::get('locationName','TaskController@locationName');
Route::get('location','TaskController@getLocation');
Route::get('generateDocket/{user_id}/{prob_desc}/{for_dept}/{comp_type}/{sub_prob}/{prob_status}/{mobile}/{epabx}/{mode}/{nodal}/{other_loc}/{ven_id}','TaskController@generateDocket');
Route::get('sendbasicemail/','MailController@basic_email');
Route::get('section','TaskController@getSection');
Route::get('region/{section}','TaskController@getRegion');
Route::get('devtype','TaskController@getDevtype');
Route::get('devname/{sec}/{region}/{dev_type}','TaskController@getDevname');
Route::get('test/{section}','TaskController@mis_test');
Route::get('generateDocketForMIS/{user_id}/{section}/{region}/{dev_type}/{dev_name}/{mobile}/{prob_desc}','TaskController@generateDocketForMIS');
Route::get('newTicket/{user_id}/{subject}/{category}/{issue_type}/{mobile}/{file_name}','TaskController@newTicket');
Route::get('docketDetails/{docket}','TaskController@docketDetails');
Route::get('insertFeedback/{docket}/{feedback}','TaskController@insertFeedback');
Route::get('insertReply/{docket}/{reply}/{feedback_type}','TaskController@insertReply');
#Route::get('insertReply/{docket}/{reply}/{category}/{subject}/{location}/{mobile}/{intercom}/{category_desc}/{user}','TaskController@insertReply');
Route::get('docketAllocation/{userid}','TaskController@docketAllocation');
Route::get('docketAllocationPending','TaskController@docketAllocationPending');
Route::get('userType/{userid}','TaskController@userType');
Route::get('issueType/{category}','TaskController@issueType');
Route::get('generateOTP/{email}/{flag}','TaskController@generateOTP');
Route::get('checkOTP/{email}/{otp}','TaskController@checkOTP');
Route::get('checkRetailer/{email}','TaskController@checkRetailer');
Route::get('getWappNo/{issue_type}','TaskController@getWappNo');
Route::get('checkAdmin/{email}','TaskController@checkAdmin');
Route::get('complainantName/{email_mob}','TaskController@complainantName');
Route::get('fetchEmail/{mob}','TaskController@fetchEmail');

