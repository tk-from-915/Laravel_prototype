@extends('admin.admin_common')

@section('admin_page_title') 
    {{$page_title}}編集
@endsection

@section('content')
<form method="POST" action="{{ route('news.update',['news' => $post]) }}" id="post_form" enctype="multipart/form-data">
@method('PUT')
@csrf
<input type="hidden" name="post_type" value="{{$post_type_value}}">
    <div class="form_block">
        <p>タイトル</p>
        <input type="text" id="title_form" name="post_title" value="{{ old('post_title',$post->post_title) }}" required autofocus>
        @if ($errors->has('post_title'))
            <p class="red">{{ $errors->first('post_title') }}</p>
        @endif
    </div>
    <div class="form_block">
        <div id="file_upload_box">
            <p>サムネイル画像</p>
            <label id="upload_thumnail_button">
                ファイルアップロード<img src="/images/download_arrow.png">
                <input type="file" name="thumnail" id="thumnail" accept=".jpg,.jpeg,png,.gif,.png">
            </label>
            @if ( $post->file_path )
                <img id="thumnail_img" src="/{{ $post->file_path }}" alt="no images">
            @else
                <img id="thumnail_img" src="/images/noimages.png" alt="no images">
            @endif         
        </div>
        <div id="thumnail_drug_and_drop">ここにファイルをドロップ</div>
        @if ($errors->has('thumnail'))
            <p class="red">{{ $errors->first('thumnail') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>本文</p>
        <textarea name="post_content" id="content_form" cols="36">{{old('post_content',$post->post_content)}}</textarea>
        @if ($errors->has('post_content'))
            <p class="red">{{ $errors->first('post_content') }}</p>
        @endif
    </div>
    <div class="form_block">
        <button type="submit" id="send" class="green_button whitelink">
            {{ __('Update') }}
        </button>
    </div>
</form>
@if( strpos(request()->path(),'admin/menus') !== false )
<div id="menu_comments_area">
    <p>このメニューに関するコメント一覧</p>
    <table id="menu_comment_list">
        <tr>
            <th>name</th>
            <th>comments</th>
        </tr>
        <tr>
            <td>ポッキー</td>
            <td>この観葉植物、すくすく育って、今では実を収穫するのが楽しみです</td>
        </tr>
        <tr>
            <td>ズボラ主婦</td>
            <td>意外と水をあげなくても勝手に育つ</td>
        </tr>
        <tr>
            <td>ミキちゃんとターくんのママ</td>
            <td>この間収穫した実を娘と一緒に食べました。</td>
        </tr>
    </table>
</div>
@endif
@endsection