<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>フォームのサンプル（入力画面）</title>
    <style>
        dl { width:430px; }
        dt { float:left; }
        dd { margin-left:130px; }
        red{ color: red; }
    </style>
</head>
<body>
 
<h1>お問い合わせ入力画面</h1>
 
<form action="{{ url('form/confirm') }}" method="post">
    @csrf
    <dl>
        <dt>お名前：</dt>
        <dd>
            <input type="text" name="username">
        </dd>
    </dl>
 
    <dl>
        <dt>年齢：</dt>
        <dd>
            <input type="text" name="age" >歳
        </dd>
    </dl>
    <dl>
        <dt>郵便番号</dt>
        <dd>
            <input type="text" name="tel">
        </dd>
    </dl>
    <dl>
        <dt>住所</dt>
        <dd>
            <input type="text" name="tel">
        </dd>
    </dl>
    <dl>
        <dt>電話番号：</dt>
        <dd>
            <input type="tel" name="tel">
        </dd>
    </dl>
    <dl>
        <dt>Email：</dt>
        <dd>
            <input type="email" name="mail">
        </dd>
    </dl>
 
    <dl>
        <dt>お問い合わせ内容：</dt>
        <dd>
            <textarea name="opinion" rows="8" cols="40" ></textarea>
        </dd>
 
        <div><input type="submit" name="button1" value="送信" /></div>
    </dl>
</form>
</body>
</html>