<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 静的ページ一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = DB::table('users')
            ->join('pages', function ($join){
                $join->on('users.id', '=', 'pages.user_id');
            })->get();

        return view('admin.pages.list',['pages' => $pages]);
    }

    /**
     * 静的ページ作成画面表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * 静的ページ新規登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //リクエストパラメータにバリデーションをかける
        $this->postValidator($request->all())->validate();

        //ページを新規登録
        $page = new Page();

        return self::saveAndUpdatePage($request,$page);
    }

    /**
     * 静的ページ表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::find($id);
        return view('admin.pages.page',['page' => $page]);
    }

    /**
     * 静的ページ編集画面表示
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        return view('admin.pages.edit',['page' => $page]);
    }

    /**
     * 静的ページ編集・更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //登録されているページ情報を取得
        $page = Page::where('id',$id)->first();
        
        //リクエストパラメータにバリデーションをかける
        $this->putValidator($request->all(),$page->uri)->validate();

        return self::saveAndUpdatePage($request,$page);
    }

    /**
     * 静的ページ削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //記事とファイルデータを削除
        Page::find($id)->delete();
        return response()->json();
    }

    /**
     * 登録時のバリデーション
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function postValidator(array $data)
    {
        return Validator::make($data, [
            'uri' => ['required', 'string', 'max:50','unique:pages'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable','string'],
        ]);
    }

    /**
     * 更新時のバリデーション
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function putValidator(array $data,$savedUri)
    {
        return Validator::make($data, [
            'uri' => ['required', 'string', 'max:50',Rule::unique('pages', 'uri')->whereNot('uri', $savedUri)],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable','string'],
        ]);
    }

    /**
     * 登録〜リダイレクトまで
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $page
     */
    protected function saveAndUpdatePage(Request $request,$page)
    {
        //ページ登録
        self::savePage($request,$page);

        return redirect()->route( 'pages.show',['page' => $page->id]);
    }

    /**
     * ページ登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $page
     */
    public function savePage(Request $request,$page)
    {
        $page->user_id = Auth::id();
        $page->uri = $request->uri;
        $page->title = $request->title;
        $page->content = $request->content;
        return $page->save();
    }
}
