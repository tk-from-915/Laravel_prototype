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
        <div class="comment_group">
            <img src="/images/hukidashi.jpeg" class="hukidashi">
            <div class="commenter">ポッキー</div>
            <div class="comment">この観葉植物、すくすく育って、今では実を収穫するのが楽しみです</div>
        </div>
        <div class="comment_group">
            <img src="/images/hukidashi.jpeg" class="hukidashi">
            <div class="commenter">みきちゃんママ</div>
            <div class="comment">この間収穫した実を娘と一緒に食べました。美味しかったです</div>
        </div>
        <div class="comment_group">
            <img src="/images/hukidashi.jpeg" class="hukidashi">
            <div class="commenter">ズボラ主婦</div>
            <div class="comment">意外と水をあげなくても勝手に育つ</div>
        </div>
        <button class="green_button comment_more" >More  →</button>
        <div id="comment_edit_area">
            <h5 class="green">Comments</h5>
            <table id ="comment_table">
                <tr>
                    <td class="left_cell">ハンドルネーム</td>
                    <td class="center_cell"></td>
                    <td class="right_cell"><input type ="text" class="comment_form"></td>
                </tr>
                <tr>
                    <td class="left_cell">コメント</td>
                    <td class="center_cell"></td>
                    <td class="right_cell"><textarea rows="7" cols="40" maxlength="120" class="comment_form"></textarea></td>
                </tr>
            </table>
            <button id="comment_submit" class="green_button" >コメントする</button>
        </div>
    </div><!--comment_area-->
    @endif
</div>

@endsection