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
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/timeline', 'Auth\TimelineController@showTimelinePage');
Route::post('/timeline', 'Auth\TimelineController@postTweet'); 


/*トップページ*/
Route::get('/', 'WebController@top');

/*メニュー一覧*/
Route::get('/menus', 'WebController@getPosts')->name('menus_archive');
/*メニュー詳細*/
Route::get('/menu/{posts_id}', 'WebController@getPostArticle')->name('menu_article');
/*メニューコメント送信*/
Route::post('/comment', 'WebController@postComment')->name('post_comment');
/*メニューコメント削除*/
Route::delete('/comment/{comment_id}', 'WebController@deleteComment')->name('delete_comment');

/*ニュース一覧*/
Route::get('/news', 'WebController@getPosts')->name('news_archive');
/*ニュース詳細*/
Route::get('/news/{posts_id}', 'WebController@getPostArticle')->name('news_article');

/*ブログ一覧*/
Route::get('/blogs', 'WebController@getPosts')->name('blog_archive');
/*ブログ詳細*/
Route::get('/blog/{posts_id}', 'WebController@getPostArticle')->name('blog_article');

/*お問い合わせ&採用情報*/
Route::get('/contact', 'WebController@getContact');
Route::post('/post_contact', 'WebController@postContact');
Route::post('/save_contact', 'WebController@sendContact');

/*サイトマップ*/
Route::get('/sitemap', 'WebController@sitemap');


/***************************
    　　管理画面
***************************/
Route::prefix('admin')->group(function(){

    /*ホーム画面*/
    Route::get('/', 'Admin\AdminController@home');

    /*CRUD*/
    Route::resources([
        '/users' => 'Admin\UsersController',
        '/menus' => 'Admin\PostsController',
        '/news' => 'Admin\PostsController',
        '/blogs' => 'Admin\PostsController',
        '/pages' => 'Admin\PagesController',
    ]);
    Route::get('/contacts', 'Admin\AdminController@home');
    
});

/*静的ページと404ページ*/
Route::fallback('WebController@getPage');