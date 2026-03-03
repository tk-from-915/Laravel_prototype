<template>
  <CommonPageLayout title="プライバシーポリシー">
   <p>株式会社Little Healing Green（以下、「当社」といいます。）は、観葉植物・花卉商品の販売および関連サービスの提供にあたり、お客様の個人情報を適切に取り扱うことを重要な責務と考えております。当社は、個人情報の保護に関する法律（個人情報保護法）その他関連法令を遵守し、以下のとおりプライバシーポリシーを定めます。</p>
    <!-- TODO: GraphQL からデータを取得して動的に表示する -->
    <section class="privacy-section">
      <h5 class="privacy-heading">第1条（個人情報の取得）</h5>
      <p>当社は、以下の場合にお客様の個人情報を取得いたします。</p>
      <ul>
        <li>1、商品のご注文時</li>
        <li>2、お問い合わせフォームの送信時</li>
        <li>3、会員登録時</li>
        <li>4、メールマガジンへの登録時</li>
        <li>5、採用応募時</li>
      </ul>
      <p>取得する情報は、氏名、住所、電話番号、メールアドレス、支払情報、配送先情報など、サービス提供に必要な範囲とします。</p>
    </section>

    <section class="privacy-section">
      <h5 class="privacy-heading">第2条（個人情報の利用目的）</h5>
      <p>当社は、取得した個人情報を以下の目的で利用いたします。</p>
       <ul>
        <li>1、商品の発送および関連するご連絡</li>
        <li>2、お問い合わせへの対応</li>
        <li>3、ご注文内容の確認、アフターサービスの提供</li>
        <li>4、メールマガジンやキャンペーン情報の配信</li>
        <li>5、サービス改善・品質向上のための分析</li>
        <li>6、法令に基づく対応</li>
      </ul>
      <p>なお、個人情報の利用目的の変更がある場合は、当社が適切な方法でお客様に通知いたします。</p>
    </section>

    <section class="privacy-section">
      <h5 class="privacy-heading">第3条（個人情報の管理）</h5>
      <p>当社は、個人情報の漏えい、滅失、毀損、不正アクセスを防止するため、適切な安全管理措置を講じます。また、従業員および委託先に対しても適切な監督を行います。</p>
    </section>

    <section class="privacy-section">
      <h5 class="privacy-heading">第4条（第三者提供） 除き</h5>
      <p>当社は、次の場合を除き、個人情報を第三者に提供いたしません。</p>
      <ul>
        <li>1、ご本人の同意がある場合</li>
        <li>2、法令に基づく場合</li>
        <li>3、商品配送のために配送業者へ必要な情報を提供する場合</li>
        <li>4、決済処理のために決済会社へ情報を提供する場合</li>
      </ul>
    </section>

    <section class="privacy-section">
      <h5 class="privacy-heading">第5条（外部サービスの利用）</h5>
      <p>当社は、アクセス解析ツールや広告配信サービスを利用する場合があります。これらのサービスではCookieを使用することがあります。お客様はブラウザの設定によりCookieを無効にすることができます。</p>
    </section>

    <section class="privacy-section">
      <h5 class="privacy-heading">第6条（開示・訂正・削除等）</h5>
      <p>お客様は、ご自身の個人情報について、開示・訂正・追加・削除・利用停止を求めることができます。ご希望の場合は、下記お問い合わせ窓口までご連絡ください。</p>
    </section>

    <section class="privacy-section">
      <h5 class="privacy-heading">第7条（プライバシーポリシーの変更）</h5>
      <p>当社は、法令の改正やサービス内容の変更に応じて、本ポリシーを改定することがあります。変更後の内容は、当社ウェブサイトに掲載した時点で効力を生じます。</p>
    </section>
  </CommonPageLayout>
</template>

<style scoped>
.privacy-section {
  margin-bottom: 48px;
}
.privacy-heading {
  color: #007575;
  margin-bottom: 12px;
}
</style>
