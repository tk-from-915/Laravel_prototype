@extends('admin.admin_common')

@section('admin_page_title') 
    {{$page_title}}作成
@endsection

@section('content')
<form method="POST" action="{{ route('news.store') }}" id="post_form" enctype="multipart/form-data">
@csrf
<input type="hidden" name="post_type" value="1">
    <div class="form_block">
        <p>タイトル</p>
        <input type="text" id="title_form" name="title" value="{{ old('title') }}" required autofocus>
        @if ($errors->has('title'))
            <p class="red">{{ $errors->first('title') }}</p>
        @endif
    </div>
    <div class="form_block">
        <div id="file_upload_box">
            <p>サムネイル画像</p>
            <button id="upload_thumnail_button">
            
                ファイルアップロード<img src="/images/download_arrow.png">
            </button>
            <img id="thumnail_img" src="/images/noimages.png" alt="no images">
        </div>
        <div id="thumnail_drug_and_drop">ここにファイルをドロップ</div>
        <input type="file" name="thumnail" id="thumnail" accept=".jpg,.jpeg,png,.gif">
    </div>
    <div class="form_block">
        <p>本文</p>
        <textarea name="post_content" id="content_form" cols="36">{{ old('post_content') }}</textarea>
        @if ($errors->has('post_content'))
            <p class="red">{{ $errors->first('post_content') }}</p>
        @endif
    </div>
    <div class="form_block">
        <button type="submit" id="send" class="green_button whitelink">
            {{ __('Send') }}
        </button>
    </div>
</form>
@endsection