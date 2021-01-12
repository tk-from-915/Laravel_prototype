<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Comment;
use App\Page;
use App\Http\Requests\CommentRequest;

class WebController extends Controller
{
    /**
     * トップページ表示
     *
     */
    public function top()
    {
        return view('web.top');
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
        $comments = $post->comments;
        $data =[
            'post' => $post,
            'comments' => $comments,
        ];
        
        return view('web.post_article',$data);
    }

    /**
     * メニューコメント送信
     *
     */
    public function postComment(CommentRequest $request)
    {
        $validated = $request->validated();
        
        $comment = new Comment();
        $comment->menu_id = $request->menu_id;
        $comment->commenter = $request->commenter;
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('menu_article', ['posts_id' => $request->menu_id]);
    }

    /**
     * メニューコメント削除
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteComment($id)
    {
        Comment::find($id)->delete();
        return response()->json();
    }

    /**
     * 固定ページ表示
     * 
     * @param  string  $uri
     */
    public function getPage($uri)
    {
        $page = Page::where('uri', $uri)->first();
        
        if(is_null($page)) abort(404);
        
        return view('web.page',compact('page'));
    }

    public function getContact()
    {
        return view('web.contact_form');
    }
    
}
