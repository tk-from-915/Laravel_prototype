<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Attachment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 記事一覧表示
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $path = $request->path('');

        switch ($path) {
            case 'admin/menus':
                $page_title = 'Menu';
                $post_type = 0;
                break;
                
            case 'admin/news':
                $page_title = 'News';
                $post_type = 1;
                break;
            case 'admin/blogs':
                $page_title = 'Blog';
                $post_type = 2;
                break;
        }

        $posts = DB::table('users')
            ->join('posts', function ($join) use( $post_type ){
                $join->on('users.id', '=', 'posts.user_id')   
                    ->where('posts.post_type', '=', $post_type);
            })->get();

        $data =[
            'page_title' => $page_title,
            'posts' => $posts,
        ];

        return view('admin.posts.list',$data);
    }

    /**
     * 投稿記事の新規作成画面表示
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $path = $request->path('');

        switch ($path) {
            case 'admin/menus/create':
                $data =[
                    'page_title' => 'Menu',
                    'post_type_value' => 0,
                ];
                break;
            case 'admin/news/create':
                $data =[
                    'page_title' => 'News',
                    'post_type_value' => 1,
                ];
                break;
            case 'admin/blogs/create':
                $data =[
                    'page_title' => 'Blog',
                    'post_type_value' => 2,
                ];
                break;
        }

        return view('admin.posts.create',$data);
        
    }

    /**
     * 投稿記事の新規作成postメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //リクエストパラメータにバリデーションをかける
        $this->postValidator($request->all())->validate();

        //ファイルを保存する
        $save_file = self::saveFile($request);
        $file_path = str_replace('public', 'storage', $save_file);

        //記事データを保存
        $post = new \App\Post();
        $post->user_id = Auth::id();
        $post->post_title = $request->post_title;
        $post->file_path = $file_path;
        $post->post_content = $request->post_content;
        $post->post_type = $request->post_type;
        $post->save();

        //ファイルデータ保存
        $attachment = new \App\Attachment();
        $attachment->parent_id = $post->id;
        $attachment->original_file_name = $request->file('thumnail')->getClientOriginalName();
        $attachment->file_path = $file_path;
        $attachment->save();

        //登録が終わったら記事詳細画面にリダイレクトさせる
        switch($request->post_type){
            case 0 :
                return redirect()->route( 'menus.show',['menu' => $post->id]);
                break;
            case 1 :
                return redirect()->route( 'news.show',['news' => $post->id]);
                break;
            case 2 :
                return redirect()->route( 'blogs.show',['blog' => $post->id]);
                break;
        }      
    }

    /**
     * 各投稿記事表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.post',['post' => $post]);
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
        $post = Post::find($id);
        $post->delete();

        return response()->json();
    }

    /**
     * ユーザ登録時のバリデーション
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function postValidator(array $data)
    {
        return Validator::make($data, [
            'post_title' => ['required', 'string', 'max:255'],
            'thumnail' => 'required',
            'thumnail.*' => 'image',
            'post_content' => ['required','string'],
        ]);
    }

    /**
     * ファイル保存(storage/app/年/月/以下に名前が「月-日_No_ユニークid.拡張子」のファイルを保存する)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveFile(Request $request)
    {
        //現在時刻を取得
        $datetime = (explode(" ",Carbon::now()));
        $date = (explode("-",$datetime[0]));
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        //ユニークid
        $id = uniqid();
        
        //拡張子を取得
        $extension = $request->thumnail->extension();

        //ファイル名を生成(月-日_No_ユニークid.拡張子) 
        $file_name = $month.'-'.$day.'_'.'No_'.$id.'.'.$extension;

        //保存ディレクトリ生成
        $dir ='public/'.$year.'/'.$month;

        //storage/app/年/月/以下にファイルを保存する
        $save_file = Storage::putFileAs($dir,$request->file('thumnail'), $file_name);

        return $save_file;
    }

}
