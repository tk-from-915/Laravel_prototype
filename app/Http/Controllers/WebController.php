<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;

class WebController extends Controller
{
    public function company()
    {
        return view('web.page');
    }

    public function getMenu_archive()
    {
        return view('web.menu_archive');
    }

    /**
     * メニュー・ニュース・ブログ一覧表示
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getPosts(Request $request)
    {
        $path = $request->path('');

        switch ($path) {
            case 'menus':
                $posts_archive_title = 'Menu';
                $posts = self::getPostsEachPostType(0);
                break;
            case 'news':
                $posts_archive_title = 'News';
                $posts = self::getPostsEachPostType(1);
                break;
            case 'blogs':
                $posts_archive_title = 'Blogs';
                $posts = self::getPostsEachPostType(2);
                break;
        }
        $data =[
            'posts_archive_title' => $posts_archive_title,
            'posts' => $posts,
        ];
        return view('web.posts_index', $data);
    }

    /**
     * 各投稿タイプの記事一覧取得
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getPostsEachPostType($post_type)
    {
        return DB::table('posts')             
                ->Join('users', function ($join) use( $post_type ){
                    $join->on('posts.user_id', '=', 'users.id')   
                        ->where('posts.post_type', '=', $post_type);
                })
                ->select('posts.id','posts.file_path','posts.post_title','posts.created_at','users.name')
                ->get();            
    }

    /**
     * 各記事の内容表示
     *
     * @param int  $id
     */
    public function getPostArticle($id)
    {
        $post = Post::find($id);
        return view('web.post_article',['post' => $post]);
    }

    public function getContact()
    {
        return view('web.contact_form');
    }
    
}
