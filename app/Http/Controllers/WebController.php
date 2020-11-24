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
     * ニュース一覧
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
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->join('attachments', function ($join) use( $post_type ){
                    $join->on('posts.id', '=', 'attachments.parent_id')   
                        ->where('posts.post_type', '=', $post_type);
                })->get();            
    }

    /**
     * 各記事の内容表示
     *
     * @param int  $id
     */
    public function getPostArticle($id)
    {
        $post = self::getPostArticleAndThumbnail($id);

        return view('web.post_article',['post' => $post]);
    }

    /**
     * 各記事の内容とサムネイル画像を取得
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getPostArticleAndThumbnail($id)
    {
        return DB::table('posts')
                ->join('attachments', function ($join) use( $id ){
                    $join->on('posts.id', '=', 'attachments.parent_id')   
                        ->where('posts.id', '=', $id);
                })->get();            
    }

    public function getContact()
    {
        return view('web.contact_form');
    }
    
}
