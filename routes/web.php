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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function()
{
    return View::make('pages.home');
});
Route::get('about', function()
{
    return View::make('pages.about');
});
// Route::get('projects', function()
// {
//     return View::make('pages.projects');
// });
// Route::get('contact', function()
// {
//     return View::make('pages.contact');
// });

// Route::get('/register', 'RegistrationController@create');
// Route::get('/get-state-list', 'RegistrationController@getStateList');
// Route::get('/get-city-list', 'RegistrationController@getCityList');
// Route::post('register', 'RegistrationController@store');

Route::get('login', function()
{
    return View::make('auth.login');
});

Auth::routes();

Route::post('/login', 'Auth\LoginController@authenticate')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
//Setting Items
Route::get('/item', 'SettingController@index')->name('item');
Route::get('/additem', 'SettingController@addItem')->name('additem');
Route::post('/additem', 'SettingController@saveItem')->name('saveitem');
Route::get('/edititem/{id}', 'SettingController@editItem')->name('edititem');
Route::post('/updateitem', 'SettingController@updateItem')->name('updateitem');
//Setting Category
Route::get('/category', 'SettingController@category')->name('category');
Route::get('/addcategory', 'SettingController@addCategory')->name('addcategory');
Route::post('/addcategory', 'SettingController@saveCategory')->name('savecategory');
Route::get('/editcategory/{id}', 'SettingController@editCategory')->name('editcategory');
Route::post('/updatecategory', 'SettingController@updateCategory')->name('updatecategory');

//Setting Area
Route::get('/area', 'SettingController@area')->name('area');
Route::get('/addarea', 'SettingController@addArea')->name('addarea');
Route::post('/addarea', 'SettingController@saveArea')->name('savearea');
Route::get('/editarea/{id}', 'SettingController@editArea')->name('editarea');
Route::post('/updatearea', 'SettingController@updateArea')->name('updatearea');

Route::get('/item_area', 'SettingController@itemToArea')->name('itemtoarea');
Route::get('/additem_area', 'SettingController@addItemArea')->name('addItemArea');
Route::post('/additem_area', 'SettingController@saveItemArea')->name('saveItemArea');
Route::post('/getcountryitem', 'SettingController@getcountryitem')->name('getcountryitem');
Route::post('/getareaitems', 'SettingController@getareaitems')->name('getareaitems');
//plans
Route::get('/plans', 'SettingController@plans')->name('plans');
Route::post('/saveplans', 'SettingController@saveplans')->name('saveplans');

//plans Validity
Route::get('/plansvalidity', 'SettingController@plansvalidity')->name('plansvalidity');
Route::post('/saveplansvalidity', 'SettingController@saveplansvalidity')->name('saveplansvalidity');

//time template
Route::get('/timetemplate', 'SettingController@timetemplate')->name('timetemplate');
Route::post('/savetimetemplate', 'SettingController@savetimetemplate')->name('savetimetemplate');

//time template
Route::get('/userpackage', 'SettingController@userpackage')->name('userpackage');
Route::post('/saveuserpackage', 'SettingController@saveuserpackage')->name('saveuserpackage');