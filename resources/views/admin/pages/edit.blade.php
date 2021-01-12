@extends('admin.admin_common')

@section('admin_page_title') 
    ページ編集
@endsection

@section('content')
    <form method="POST" action="{{ route('pages.update',['page' => $page->id]) }}" id="post_form">
    @method('PUT')
    @csrf
        <div class="form_block">
            <p>このページのURL</p>
            <div id="page_url">
                <p>https://little-healing-green.embodyer.com/</p>
                <input type="text" name="uri" id="uri_form" value="{{ old('uri',$page->uri) }}" required autofocus>
            </div>
            @if ($errors->has('uri'))
                <p class="red">{{ $errors->first('uri') }}</p>
            @endif
            <div id="precautionary_statement">※入れることのできる文字は半角英数字と_（アンダースコア）と-（ハイフン）になっています。<br>
                ※URLに入れる単語は/（スラッシュ）、menus、news、blogs、contact、sitemap、adminはご使用できません。
            </div>
        </div>
        <div class="form_block">
            <p>タイトル</p>
            <input type="text" name="title" id="title_form" value="{{ old('title',$page->title) }}" required>
            @if ($errors->has('title'))
                <p class="red">{{ $errors->first('title') }}</p>
            @endif
        </div>
        <div class="form_block">
            <p>本文</p>
            <textarea name="content" id="content_form" cols="36">{{ old('content',$page->content) }}</textarea>
            @if ($errors->has('content'))
                <p class="red">{{ $errors->first('content') }}</p>
            @endif
        </div>
        <div class="form_block">
            <button type="submit" id="send" class="green_button whitelink">
                {{ __('Update') }}
            </button>
        </div>
    </form>
@endsection