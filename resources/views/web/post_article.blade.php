@extends('web.web_common')
@section('title', 'News Article')

@section('contents')
<div id="post_archive">
    <h5 id="news_blog_title">{{ $post->post_title }}</h5>
    @if ( $post->file_path )
        <img src = "/{{ $post->file_path }}" class="post_image">
    @else
        <img class="post_image" src="/images/noimages.png" alt="no images">
    @endif
    <div class= "post_content">{{ $post->post_content }}</div>
    @if ( strpos(request()->path(),'menu/')!== false )
    <div id="comment_area">
        <p class="center">みなさんのコメント</p>
        @foreach($comments as $comment)
            <div class="comment_group">
                <img src="/images/hukidashi.jpeg" class="hukidashi">
                <div class="commenter">{{ $comment->commenter }}</div>
                <div class="comment">{{ $comment->comment }}</div>
            </div>
        @endforeach
        <button class="green_button comment_more" >More  →</button>
        <div id="comment_edit_area">
            <form method="POST" action="{{ route('post_comment') }}">
            @csrf
            <input type ="hidden" name ="menu_id" value = "{{ $post->id }}">
                <h5 class="green">Comments</h5>
                <table id ="comment_table">
                    <tr>
                        <td class="left_cell">ハンドルネーム</td>
                        <td class="center_cell"></td>
                        <td class="right_cell"><input type ="text" name="commenter" class="comment_form"></td>
                    </tr>
                    <tr>
                        <td class="left_cell">コメント</td>
                        <td class="center_cell"></td>
                        <td class="right_cell"><textarea name="comment" rows="7" cols="40" maxlength="255" class="comment_form"></textarea></td>
                    </tr>
                </table>
                @if($errors)
                    @foreach($errors->all() as $error)
                    <div class ="comment_error">※{{ $error }}</div>
                    @endforeach
                @endif
                <button type="submit" id="comment_submit" class="green_button" >{{ __('コメントする') }}</button>
            </form>
        </div>
    </div><!--comment_area-->
    @endif
</div>

@endsection