<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>パスワードリセット</title>
</head>
<body style="font-family: sans-serif; color: #333; padding: 32px;">
  <p>パスワードリセットのリクエストを受け付けました。</p>
  <p>以下のリンクをクリックして、新しいパスワードを設定してください。</p>
  <p style="margin: 24px 0;">
    <a href="{{ $resetUrl }}" style="background-color: #007575; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px;">
      パスワードをリセットする
    </a>
  </p>
  <p>このリンクは60分間有効です。</p>
  <p>心当たりのない場合は、このメールを無視してください。</p>
</body>
</html>
