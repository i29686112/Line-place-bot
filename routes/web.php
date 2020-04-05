<?php

use App\Classes\HtmlParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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


Route::post('/', "LineWebHookController@index");

Route::get('/parser', function () {
    return json_encode(['foo','boo']);
});


Route::get('/categoryParser', function () {
    return json_encode(['景點','餐廳','住宿']);
});


Route::get('/pyTest', function (Request $request) {

    if( filter_var($request->input('url'),FILTER_VALIDATE_URL)===false){
        return 'illegal input';
    }

    $htmlParser = new HtmlParser($request->input('url'));

    return $htmlParser->getPlaceSuggestNamesFromPython();

});
