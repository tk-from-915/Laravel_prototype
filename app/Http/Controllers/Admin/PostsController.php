<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 記事一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 投稿記事の新規作成画面表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $path = $request->path('');

        if ($path == 'admin/news/create'){
            $data =[
                'page_title' => 'News',
            ];
            return view('admin.news.create',$data);

        }elseif($path == 'admin/blogs/create'){
            $data =[
                'page_title' => 'Blog',
            ];
            return view('admin.news.create');

        }else{
            $data =[
                'page_title' => 'Menu',
            ];
            return view('admin.news.create');    
        }
        
    }

    /**
     * 投稿記事の新規作成postメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info($request->all());
        \Log::info($request->file('thumnail'));

        //storage/app以下に保存する
        $request->file('thumnail')->store('test');
    }

    /**
     * 各投稿記事表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 各投稿記事の編集画面表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 投稿記事の更新処理putメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 記事削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
