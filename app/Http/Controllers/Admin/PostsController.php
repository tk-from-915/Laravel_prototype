<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                'post_type_value' =>1,
            ];
            
        }elseif($path == 'admin/blogs/create'){
            $data =[
                'page_title' => 'Blog',
                'post_type_value' =>2,
            ];

        }else{
            $data =[
                'page_title' => 'Menu',
                'post_type_value' =>0,
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

        //ファイルを保存する
        $save_file = self::saveFile($request);
        echo $save_file;
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

    /**
     * ファイル保存(storage/app/年/月/以下に月-日_fileNo_ユニークid.拡張子をファイル名として保存する)
     *
     * @param  int  $id
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

        //連番
        $id = uniqid();
        
        //拡張子を取得
        $extension = $request->thumnail->extension();

        //ファイル名を生成(月-日_fileNo_ユニークid.拡張子) 
        $file_name = $month.'-'.$day.'_'.'No_'.$id.'.'.$extension;

        //保存ディレクトリ生成
        $dir ='public/'.$year.'/'.$month;

        //storage/app/年/月/以下にファイルを保存する
        $save_file = Storage::putFileAs($dir,$request->file('thumnail'), $file_name);

        return $save_file;
    }

}
