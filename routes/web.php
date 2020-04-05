<?php

use App\Classes\HtmlParser;
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


Route::get('/pyTest', function () {

    $htmlParser = new HtmlParser('www.google.com');

    log::info(json_encode( $htmlParser->getPlaceSuggestNamesFromPython()));
    return $htmlParser->getPlaceSuggestNamesFromPython();
});
