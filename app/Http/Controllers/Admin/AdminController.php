<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 管理画面homeを表示する
     *
     */
    public function home()
    {
        $data =[
            'menu_posts' => self::getEachPosts(0),
            'news_posts' => self::getEachPosts(1),
            'blog_posts' => self::getEachPosts(2),
        ];
        return view('admin.home',$data);
    }

    /**
     * 最近更新した記事を３件取得する
     *
     * @param  $post_type
     */
    public function getEachPosts($post_type)
    {
        return DB::table('users')
                ->join('posts', function ($join) use( $post_type ){
                    $join->on('users.id', '=', 'posts.user_id')   
                        ->where('posts.post_type', '=', $post_type);
                })
                ->orderBy('posts.updated_at', 'desc')
                ->take(3)
                ->get();
    }
}
