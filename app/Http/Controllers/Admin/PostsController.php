<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Attachment;
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
                'post_type_value' => 1,
            ];
            
        }elseif($path == 'admin/blogs/create'){
            $data =[
                'page_title' => 'Blog',
                'post_type_value' => 2,
            ];

        }else{
            $data =[
                'page_title' => 'Menu',
                'post_type_value' => 0,
            ];   
        }
        return view('admin.news.create',$data);
        
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

        //記事データを保存する
        $post = new \App\Post();
        $post->user_id = Auth::id();
        $post->post_title = $request->post_title;
        $post->post_content = $request->post_content;
        $post->post_type = $request->post_type;
        $post_save = $post->save();

        if ($post_save && $request->hasFile('thumnail')) {
            //ファイルを保存する
            $save_file = self::saveFile($request);
            $file_path = str_replace('public', 'storage', $save_file);

            //ファイルデータ保存
            $attachment = new \App\Attachment();
            $attachment->parent_id = $post->id;
            $attachment->original_file_name = $request->file('thumnail')->getClientOriginalName();
            $attachment->file_path = $file_path;
            $attachment->save();
        }

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
        //
        echo $id;
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
            'thumnail' => 'nullable',
            'thumnail.*' => 'image',
            'post_content' => ['string','nullable'],
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
