<template>
  <CommonPageLayout title="採用情報">
    <!-- TODO: GraphQL からデータを取得して動的に表示する -->
    <section class="recruit-section">
      <h6 class="recruit-heading">募集要項</h6>
      <table class="recruit-table">
        <tbody>
          <tr>
            <th>職種</th>
            <td>〇〇職</td>
          </tr>
          <tr>
            <th>雇用形態</th>
            <td>正社員</td>
          </tr>
          <tr>
            <th>給与</th>
            <td>月給〇〇万円〜</td>
          </tr>
          <tr>
            <th>勤務地</th>
            <td>東京都〇〇区</td>
          </tr>
          <tr>
            <th>勤務時間</th>
            <td>〇〇:〇〇〜〇〇:〇〇</td>
          </tr>
          <tr>
            <th>応募方法</th>
            <td>お問い合わせフォームよりご連絡ください。</td>
          </tr>
        </tbody>
      </table>
    </section>
  </CommonPageLayout>
</template>

<style scoped>
.recruit-section {
  margin-bottom: 60px;
}
.recruit-heading {
  color: #007575;
  margin-bottom: 20px;
}
.recruit-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 18px;
}
.recruit-table th,
.recruit-table td {
  padding: 16px 20px;
  border-bottom: 1px solid #e0e0e0;
  text-align: left;
  vertical-align: top;
}
.recruit-table th {
  width: 30%;
  color: #007575;
  font-weight: normal;
  white-space: nowrap;
}
</style>
