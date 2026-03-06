<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>{{ $mailSubject }}</title>
</head>
<body style="font-family: sans-serif; color: #333; padding: 32px;">
  <p>{{ $contactorName }} 様</p>
  <p>お問い合わせいただきありがとうございます。<br>以下の通りご回答申し上げます。</p>

  <div style="margin: 24px 0; padding: 20px; background-color: #f5f5f5; border-left: 4px solid #007575;">
    {!! nl2br(e($replyMessage)) !!}
  </div>

  <hr style="border: none; border-top: 1px solid #ddd; margin: 32px 0;">

  <p style="color: #888; font-size: 13px;">【元のお問い合わせ内容】</p>
  <p style="color: #888; font-size: 13px; white-space: pre-wrap;">{{ $originalMessage }}</p>
</body>
</html>
