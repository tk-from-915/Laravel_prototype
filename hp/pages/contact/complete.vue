<template>
  <div id="backgroud">
    <h5 id="page_title">お問い合わせ完了</h5>
    <div class="complete-message">
      <p>お問い合わせいただきありがとうございます。</p>
      <p>内容を確認の上、2、3日以内に担当者よりご連絡いたします。</p>
    </div>
    <CommonAppButton to="/" class="complete-btn">トップページへ</CommonAppButton>
  </div>
</template>

<style scoped>
.complete-message {
  text-align: center;
  line-height: 2;
  font-size: 18px;
  color: #a8a8a8;
  margin-bottom: 40px;
}

.complete-btn {
  display: block;
  width: fit-content;
  margin: 0px auto 40px;
  text-decoration: none;
  padding: 12px 40px;
  font-size: 16px;
}
</style>
