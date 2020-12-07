<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\PostsController;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ユーザ一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allusers = User::all();
        return view('admin.users.list',['users' => $allusers]);
    }

    /**
     * ユーザ新規作成画面表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * ユーザ新規作成postメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //リクエストパラメータにバリデーションをかける
        $this->postValidator($request->all())->validate();

        //Userモデルを使って新規作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'authority' => $request->authority,
            'messeage' => $request->messeage,
        ]);

        //登録が終わったらユーザリスト一覧画面にリダイレクトさせる
        return redirect( '/admin/users' );
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
            'name' => ['required', 'string', 'max:50','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'authority' => ['required', 'integer'],
            'messeage' => ['nullable','string','max:255'],
        ]);
    }

    /**
     * 各ユーザ表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.profile',['user' => $user]);
    }

    /**
     * 各ユーザの編集画面表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit',['user' => $user]);
    }

    /**
     * 各ユーザの更新処理putメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //リクエストパラメータにバリデーションをかける
        $this->putvalidator($request->all())->validate();

        //Userモデルを使って更新
        $user = User::where('id',$id)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->authority = $request->authority;
        $user->messeage = $request->messeage;

        $user->save();

        //登録が終わったらプロフィール画面にリダイレクトさせる
        return redirect()->route('users.show',['user' => $id]);
    }

    /**
     * ユーザ更新時のバリデーション
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function putvalidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50','unique:users,name,'.Auth::user()->name.',name'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,'.Auth::user()->email.',email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'authority' => ['required', 'integer'],
            'messeage' => ['nullable','string','max:255'],
        ]);
    }

    /**
     * ユーザ削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_ids = self::getPostIdWithUser($id);

        foreach( $post_ids as $post_id ){
            //post_idに紐づくファイルのデータを全部取得する
            $files = PostsController::getAttachment($post_id->id);
            //post_idに紐づくファイルを全部削除する   
            PostsController::deleteAttachment($files);
        }

        //ユーザと紐づく記事を削除
        User::find($id)->delete();

        return response()->json();
        
    }

    /**
     * ユーザに紐づく記事のIDを取得する
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function getPostIdWithUser($id)
    {
        $post_ids = DB::table('users')             
            ->Join('posts', function ($join) use( $id ){
                $join->on('users.id', '=', 'posts.user_id')   
                    ->where('users.id', '=', $id);
            })
            ->select('posts.id')
            ->get();
        return $post_ids;
    }
}
