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
// Route::get('login', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::get('login', function (Request $request) {
    return $request->user();
});
    Route::post('register', 'AuthController@register');
    Route::post('registeruser', 'AuthController@registerUser');
    Route::get('getusers', 'AuthController@getUser');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('getcountries', 'AuthController@getContries');
    Route::post('getstates', 'AuthController@getStates');
    Route::post('getcities', 'AuthController@getCities');
    Route::get('getavailcountries', 'AuthController@getAvailableCountries');
    Route::get('getcategories', 'AuthController@getCategories');
    Route::post('getitemsbycategory', 'AuthController@getItemsByCategory');
    Route::post('getitemsbycategoryall', 'AuthController@getItemsByCategoryAll');
    Route::post('getareabyitem', 'AuthController@getAreaByItem');
    //update price
    Route::post('getrates', 'AuthController@getRates');
    Route::post('updaterates', 'AuthController@updateRates');//
    Route::post('updatesizerates', 'AuthController@updateSizeRates');
    Route::post('getpricehistory', 'AuthController@getPriceHistory');
    Route::post('gettodayhistory', 'AuthController@todayHistoryPrice');
    Route::post('gethistorypricebydate', 'AuthController@HistoryPriceDatewise');
    Route::post('getpricehistory', 'AuthController@getPriceHistory');

    //item
    Route::get('/items', 'SettingsController@index');
    Route::post('/additem', 'SettingsController@saveItem');
    Route::post('/updateitem', 'SettingsController@updateItem');

    //category
    Route::post('/addcategory', 'SettingsController@saveCategory');
    Route::post('/updatecategory', 'SettingsController@updateCategory');

    //area
    Route::get('/area', 'SettingsController@area');
    Route::post('/addarea', 'SettingsController@saveArea');
    Route::post('/updatearea', 'SettingsController@updateArea');

    //plans
    Route::post('/saveplans', 'SettingsController@saveplans');
    Route::post('/saveplansvalidity', 'SettingsController@saveplansvalidity');
    Route::post('/savetimetemplate', 'SettingsController@savetimetemplate');

    //
    Route::get('/additem_area', 'SettingsController@addItemArea');
    Route::post('/postadditemarea', 'SettingsController@saveItemArea');
    Route::post('/getcountryitem', 'SettingsController@getcountryitem');
    Route::post('/getareaitems', 'SettingsController@getareaitems');
    //group
    
    Route::post('creategroup', 'AuthController@createGroup');
    Route::get('getgroups', 'AuthController@getGroups');
    Route::post('addmembers', 'AuthController@addMembers');
    Route::post('deletegroup', 'AuthController@deleteGroup');
//users
    Route::get('ghdgfjhghjkggjfgjkjk', 'HomeController@getCategoriesHaveSize');
  
    Route::post('getrkljgfhlkdgjhkfgatgegs', 'HomeController@getRatesForSize');
    Route::get('fdsajhjkhfdsuifnakdkdfmdkk', 'HomeController@getAvailableCountries');
    Route::post('lkahgvddgfkdhd', 'HomeController@getItemsByCategory');
    Route::post('ghfghgjfghhhfhjkoi', 'HomeController@getAreaByItem');
    Route::post('slkdfhgslkdfh', 'HomeController@getRates');
    Route::post('djkdfjkjfhjffk', 'HomeController@saveBuySell');
    Route::get('getbuysell', 'HomeController@getBuySell');
    Route::get('getbuy', 'HomeController@getBuy');
    Route::get('getsell', 'HomeController@getSell');
    // Route::get('gettender', 'HomeController@getTender');
    Route::get('gettender', 'HomeController@getTender');
    // Route::get('getcountries', 'HomeController@getContries');
    Route::post('registeration', 'HomeController@registerUser');
    Route::post('listuser', 'HomeController@listUser');
    Route::post('postsave', 'HomeController@savePost');
    Route::post('postupdate', 'HomeController@updatePost');
    Route::post('buysellupdate', 'HomeController@updateBuySell');
    Route::post('tenderupdate', 'HomeController@tenderUpdate');
    Route::get('getpostdata', 'HomeController@getPostData');
    Route::post('getareafromitem', 'SettingsController@getareafromitem');

    //package
    Route::get('gettimeandplan', 'PackageController@getTimeTemplateAndPlan');
    Route::get('getplanvalidity', 'PackageController@getPlanValidity');
    Route::post('checkout', 'PackageController@checkout');
    Route::post('addtemplate', 'PackageController@addTemplate');
    Route::get('gettemplates', 'PackageController@getTemplates');
    Route::post('changestatus', 'PackageController@changeStatus');
    Route::get('getuserpackages', 'PackageController@getUserPackages');
    Route::get('getcontact', 'PackageController@getContact');
    Route::get('getcomments', 'PackageController@getComments');
    Route::post('savecomment', 'PackageController@saveComment');
    Route::get('getlogistic', 'PackageController@getLogistic');
    Route::post('savelogistic', 'PackageController@saveLogistic');
    Route::post('tendersave', 'HomeController@tenderSave');
    Route::get('getuservalidity', 'HomeController@getUserValidity');
    Route::get('getuserhistory', 'HomeController@getUserHistory');
});
