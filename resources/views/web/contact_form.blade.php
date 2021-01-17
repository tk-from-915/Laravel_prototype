@extends('web.web_common')
@section('title', 'Contact Page')

@section('contents') 
<h5 id="page_title">お問い合わせ＆採用情報</h5>
<form method="POST" action="{{ url('post_contact') }}">
    @csrf
	<table id ="contact_form_table">
		<tr>
			<td class="left_cell"><span class="red">＊</span>　お名前</td>
			<td class="center_cell"></td>
			<td class="right_cell">
				<input type ="text" name="名前" class="contact_forms" value="{{ old('名前') }}">
			</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell">
			@if ($errors->has('名前'))<p class="red">{{ $errors->first('名前') }}</p>@endif
			</td>
		</tr>
		<tr>
			<td class="left_cell">電話番号</td>
			<td class="center_cell"></td>
			<td class="right_cell">
				<input type ="tel" name="電話番号" class="contact_forms" value="{{ old('電話番号') }}">
			</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell">
			@if ($errors->has('電話番号'))<p class="red">{{ $errors->first('電話番号') }}</p>@endif
			</td>
		</tr>
		<tr>
			<td class="left_cell"><span class="red">＊</span>メールアドレス</td>
			<td class="center_cell"></td>
			<td class="right_cell">
				<input type ="email" name="メールアドレス" class="contact_forms" value="{{ old('メールアドレス') }}">
			</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell">
			@if ($errors->has('メールアドレス'))<p class="red">{{ $errors->first('メールアドレス') }}</p>@endif
			</td>
		</tr>
		<tr>
			<td class="left_cell"><span class="red">＊</span>　種別</td>
			<td class="center_cell"></td>
			<td class="right_cell">
				<select name="種別"  class="contact_forms" value="{{ old('種別') }}">
					<option >お問い合わせ内容をお選びください</option>
					<option value="1">1、商品・店舗に関するお問い合わせ</option>
					<option value="2">2、採用情報に関するお問い合わせ</option>
					<option value="3">3、その他</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell">
			@if ($errors->has('種別'))<p class="red">{{ $errors->first('種別') }}</p>@endif
			</td>
		</tr>
		<tr>
			<td class="left_cell">お問い合わせ内容</td>
			<td class="center_cell"></td>
			<td class="right_cell">
				<textarea name="お問い合わせ内容" rows="10" cols="54" maxlength="500">{{ old('お問い合わせ内容') }}</textarea>
			</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell">
			@if ($errors->has('お問い合わせ内容'))<p class="red">{{ $errors->first('お問い合わせ内容') }}</p>@endif
			</td>
		</tr>
	</table>
	<button type="submit" id="confirm_button" class="green_button">
        {{ __('Submit') }}
    </button>
</form>
@endsection