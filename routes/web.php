<?php

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

Route::get('/', 'TemplateController@welcome')->name('welcome');
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::group(['prefix'=>'/articles','as'=>'articles.'],function(){
    Route::get('/', 'ArticlController@index')->name('index');
    Route::get('/create', 'ArticlController@create')->name('create');
    Route::post('/store', 'ArticlController@store')->name('store');
    Route::get('/{id}', 'ArticlController@show')->name('show');
    Route::get('/{id}/edit', 'ArticlController@edit')->name('edit');
    Route::put('/{id}','ArticlController@update')->name('update');
    Route::patch('/{id}','ArticlController@update');
    Route::delete('/{id}', 'ArticlController@destroy')->name('destroy');
    Route::get('/delArticle', 'ArticlController@delArticle')->name('delArticle');
    Route::get('/addImg/{id}', 'ArticlController@addImgShow')->name('addImgShow');
    Route::post('/addImg/{id}', 'ArticlController@addImg')->name('addImg');
});

Route::group(['prefix'=>'/pictures','as'=>'pictures.'],function(){
    Route::get('/', 'PictureController@index')->name('index');
    Route::get('/create', 'PictureController@create')->name('create');
    Route::post('/store', 'PictureController@store')->name('store');
    Route::get('/{id}', 'PictureController@show')->name('show');
    Route::delete('/{id}', 'PictureController@destroy')->name('destroy');
    Route::get('/{id}/addImgPostShow', 'PictureController@addImgPostShow')->name('addImgPostShow');
    Route::put('/{id}','PictureController@addImgPost')->name('addImgPost');
    Route::patch('/{id}','PictureController@addImgPost');
    Route::get('/resize/{id}', 'PictureController@resizeShow')->name('resizeShow');
    Route::post('/resize/{id}', 'PictureController@resize')->name('resize');

});

Route::group(['prefix'=>'/template','as'=>'template.'],function(){
    Route::get('/', 'TemplateController@index')->name('index');
    Route::post('/addPost', 'TemplateController@addPost')->name('addPost');
    Route::delete('/{id}', 'TemplateController@destroy')->name('destroy');
});

Route::group(['prefix'=>'/admin','as'=>'admin.'],function(){
    Route::get('/delArticleShow', 'ArticlController@delArticleShow')->name('delArticleShow');
    Route::delete('/delArticleShow/{id}', 'ArticlController@delArticle')->name('delArticle');
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/create', 'UserController@create')->name('create');
    Route::post('/store', 'UserController@store')->name('store');
    Route::get('/{id}/edit', 'UserController@edit')->name('edit');
    Route::put('/{id}','UserController@update')->name('update');
    Route::patch('/{id}','UserController@update');
    Route::delete('/{id}', 'UserController@destroy')->name('destroy');
});

Route::group(['prefix'=>'/roles','as'=>'roles.'], function() {
    Route::get('/', 'RoleController@index')->name('index');
    Route::get('/create', 'RoleController@create')->name('create');
    Route::post('/store', 'RoleController@store')->name('store');
    Route::get('/{id}', 'RoleController@show')->name('show');
    Route::get('/{id}/edit', 'RoleController@edit')->name('edit');
    Route::put('/{id}','RoleController@update')->name('update');
    Route::patch('/{id}','RoleController@update');
    Route::delete('/{id}', 'RoleController@destroy')->name('destroy');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
