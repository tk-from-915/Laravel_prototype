@extends('web.web_common')

@section('contents')
<h5 id="page_title">お問い合わせ＆採用情報</h5>
	<form　action="contact2.html">
		<table id ="contact_form_table">
			<tr>
				<td class="left_cell"><span class="red">＊</span>　お名前</td>
				<td class="center_cell"></td>
				<td class="right_cell"><input type ="text" class="contact_forms"></td>
			</tr>
			<tr>
				<td class="left_cell"></td>
				<td class="center_cell"></td>
				<td class="right_cell"></td>
			</tr>
			<tr>
				<td class="left_cell">電話番号</td>
				<td class="center_cell"></td>
				<td class="right_cell"><input type ="tel" class="contact_forms"></td>
			</tr>
			<tr>
				<td class="left_cell"></td>
				<td class="center_cell"></td>
				<td class="right_cell"></td>
			</tr>
			<tr>
				<td class="left_cell"><span class="red">＊</span>メールアドレス</td>
				<td class="center_cell"></td>
				<td class="right_cell"><input type ="email" class="contact_forms"></td>
			</tr>
			<tr>
				<td class="left_cell"></td>
				<td class="center_cell"></td>
				<td class="right_cell"></td>
			</tr>
			<tr>
				<td class="left_cell"><span class="red">＊</span>　種別</td>
				<td class="center_cell"></td>
				<td class="right_cell">
					<select name="contact_type"  class="contact_forms">
						<option >お問い合わせ内容をお選びください</option>
						<option value="問い合わせ1">1、商品・店舗に関するお問い合わせ</option>
						<option value="問い合わせ2">２、採用情報に関するお問い合わせ</option>
						<option value="問い合わせ3">3、その他</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="left_cell"></td>
				<td class="center_cell"></td>
				<td class="right_cell"></td>
			</tr>
			<tr>
				<td class="left_cell">お問い合わせ内容</td>
				<td class="center_cell"></td>
				<td class="right_cell"><textarea rows="10" cols="54" maxlength="500"></textarea></td>
			</tr>
			<tr>
				<td class="left_cell"></td>
				<td class="center_cell"></td>
				<td class="right_cell"></td>
			</tr>
		</table>
		<a href="contact2.html"><input type="submit" class="green_button confirm_button" value="Submit"></a>
	</form>
@endsection