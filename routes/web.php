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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/welcome', 'HomeController@welcome')->name('welcome');

Route::get('/timeline', 'Auth\TimelineController@showTimelinePage');
Route::post('/timeline', 'Auth\TimelineController@postTweet'); 

Route::get('/', function () {
    return view('web.top');
});

/*会社情報*/
Route::get('/company', 'WebController@company');

/*コンセプト*/
Route::get('/concept', 'WebController@concept');

/*メニュー一覧*/
Route::get('/menu_archive', 'WebController@getMenu_archive');
/*メニュー詳細*/
Route::get('/menu/{menu_id}', 'WebController@getMenu');

/*ニュース一覧*/
Route::get('/news_archive', 'WebController@getNews_archive');
/*ニュース詳細*/
Route::get('/news/{news_id}', 'WebController@getNews');

/*ブログ一覧*/
Route::get('/blog_archive', 'WebController@getBlog_archive');
/*ブログ詳細*/
Route::get('/blog/{blog_id}', 'WebController@getBlog');

/*お問い合わせ&採用情報*/
Route::get('/contact', 'WebController@getContact');

/*サイトマップ*/
Route::get('/sitemap', 'WebController@sitemap');

/*プライバシーポリシー*/
Route::get('/privacy-policy', 'WebController@privacy-policy');

/*管理画面入り口*/
Route::get('/admin', 'WebController@admin');

/***********************************
    ここから管理画面
**********************************/
/*プロフィール*/
Route::get('/admin/profile', 'AdminController@getProfile');
/*プロフィール画面編集*/
Route::post('/admin/profile', 'AdminController@postProfile');