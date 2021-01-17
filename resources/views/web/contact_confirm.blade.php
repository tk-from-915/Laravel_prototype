@extends('web.web_common')
@section('title', 'Contact Page')

@section('contents') 
<h5 id="page_title">お問い合わせ＆採用情報</h5>
<form method="POST" action="{{ url('save_contact') }}">
    @csrf
	<table id ="contact_form_table">
		<tr>
			<td class="left_cell"><span class="red">＊</span>　お名前</td>
			<td class="center_cell"></td>
			<td class="right_cell">{{ $名前 }}</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell"></td>
		</tr>
		<tr>
			<td class="left_cell">電話番号</td>
			<td class="center_cell"></td>
			<td class="right_cell">{{ $電話番号 }}</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell"></td>
		</tr>
		<tr>
			<td class="left_cell"><span class="red">＊</span>メールアドレス</td>
			<td class="center_cell"></td>
			<td class="right_cell">{{ $メールアドレス }}</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell"></td>
		</tr>
		<tr>
			<td class="left_cell"><span class="red">＊</span>　種別</td>
			<td class="center_cell"></td>
			<td class="right_cell">{{ $種別 }}</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell"></td>
		</tr>
		<tr>
			<td class="left_cell">お問い合わせ内容</td>
			<td class="center_cell"></td>
			<td class="right_cell">{{ $お問い合わせ内容 }}</td>
		</tr>
		<tr>
			<td class="left_cell"></td>
			<td class="center_cell"></td>
			<td class="right_cell"></td>
		</tr>
	</table>
	<button type="submit" id="confirm_button" class="green_button">
        {{ __('Save') }}
    </button>
</form>
@endsection