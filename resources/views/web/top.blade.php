@extends('base_common')

@section('title', 'Top Page')

@section('wrapper')
	@component('layouts.humbarger_menu')
	@endcomponent
	<div id="container">
		<div id = "top_page1" class ="toppage_block">
			<div id ="top_fonts">
				<p id ="top_title">Little Healing Green</p>
				<p id ="sub_title">暮らしにすてきな癒しを</p>
			</div>
		</div>
		<div id ="top_page2" class ="toppage_block">
			<p id ="page2_title1">忙しい毎日に<br>癒しのひとときを</p>
			<div id ="page2_rightblock">
				<p id ="page2_title2">学業やお仕事、家事や育児。<br>毎日がんばるあなたへ。</p>
				<p id ="page2_title3">そんな毎日にちょっとした癒しを<br>プレゼントしませんか？</p>
			</div>
			<div class = "green_section_topdiagonal"></div>
		</div>
		<div id ="top_page3" class ="toppage_block">
			<h1>News</h1>
			<ul id ="news_lists">
				<li class ="news_list">2020/12/15　クリスマスリース販売中です。</li>
				<li class ="news_list">2020/10/31　ハロウィンに使われる植物とは？</li>
				<li class ="news_list">2020/08/12　真夏でも葉焼けしない方法</li>
				<li class ="news_list">2020/06/06　梅雨の時期にぴったりの植物はコレ！</li>
				<li class ="news_list">2020/04/01　卒業式＆入学式にはこの花を</li>
				<li class ="news_list">2020/03/03　桃の花の時期になりました。</li>
				<li class ="news_list">2020/02/01　今年のバレンタインには♡</li>
				<li class ="news_list">2020/01/01　あけましておめでとうございます。</li>
			</ul>
			<button class="green_button toppage_button" >
				<a href="/news_archive"  class="whitelink">More  →</a>
			</button>
		</div>
		<div id ="top_page4" class ="toppage_block">
			<h1>Green</h1>
			<p>当店で扱っている商品をご紹介</p>
			<div id="toppage_menus">
				<div class="menu_block">
					<h5>Foliage plant</h5>
					<img src="images/kajumaru.jpg">
				</div>
				<div class="menu_block">
					<h5>Succulents</h5>
					<img src="images/taniku001.jpeg">
				</div>
				<div class="menu_block">
					<h5>Terrarium</h5>
					<img src="images/Terrarium.jpg">
				</div>
			</div>
			<button class="green_button toppage_button" >
				<a href="/menu_archive" class="whitelink">More  →</a>
			</button>
		</div>

		<div id="footer" class ="toppage_block">
			<table id="footer_menu">
				<tr>
					<td>
						<p class="logo">Little<br>Healing<br>Green</p>
					</td>
					<td>
						<p>株式会社LHG</p>
						〒012-3456-7890<br>
						東京都〇〇区△△△3丁目11-22<br><br>
						TEL<br>
						03-0000-0000<br>
					</td>
					<td>
						<p>サイトマップ</p>
						<p>会社情報</p>
						<p>プライバシーポリシー</p>
						<p>お問い合わせ</p>
					</td>
				</tr>
			</table>
			<p id ="copyright">Copyright©LittleHealingGreen all rights reserved.</p>
		</div>
	</div><!--container-->
@endsection